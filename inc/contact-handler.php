<?php
/**
 * contact-handler.php
 * お問い合わせフォーム処理（バリデーション・セッション・Resend API送信）
 *
 * wp-config.php に以下の定数を定義してください:
 *   define( 'RESEND_API_KEY',    're_xxxxxxxxxxxx' );
 *   define( 'CONTACT_MAIL_TO',   'info@miyukihousing.com' );
 *   define( 'CONTACT_MAIL_FROM', 'noreply@miyukihousing.com' );
 *   define( 'CONTACT_MAIL_FROM_NAME', '有限会社ミユキハウジング' );
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ------------------------------------------------------------------
 * 定数フォールバック（wp-config.php に書き忘れた場合の保険）
 * ------------------------------------------------------------------ */
if ( ! defined( 'RESEND_API_KEY' ) )        define( 'RESEND_API_KEY', '' );
if ( ! defined( 'CONTACT_MAIL_TO' ) )       define( 'CONTACT_MAIL_TO', get_option( 'admin_email' ) );
if ( ! defined( 'CONTACT_MAIL_FROM' ) )     define( 'CONTACT_MAIL_FROM', 'noreply@' . parse_url( home_url(), PHP_URL_HOST ) );
if ( ! defined( 'CONTACT_MAIL_FROM_NAME' ) ) define( 'CONTACT_MAIL_FROM_NAME', get_bloginfo( 'name' ) );

/* ------------------------------------------------------------------
 * セレクト選択肢の定義（バリデーション共用）
 * ------------------------------------------------------------------ */
function miyuki_contact_choices() {
    return [
        'inquiry_type' => [
            ''           => '選択してください',
            'new_build'  => '新築',
            'extension'  => '増改築',
            'reform'     => 'リフォーム',
            'maintenance'=> 'メンテナンス',
            'other'      => 'その他',
        ],
        'building_type' => [
            ''           => '選択してください',
            'house'      => '戸建て',
            'mansion'    => 'マンション・アパート',
            'store'      => '店舗・事務所',
            'other'      => 'その他',
        ],
        'timing' => [
            ''           => '選択してください',
            'asap'       => 'できるだけ早く',
            '1month'     => '1ヶ月以内',
            '3months'    => '3ヶ月以内',
            '6months'    => '半年以内',
            '1year'      => '1年以内',
            'undecided'  => '未定・検討中',
        ],
        'referral' => [
            ''           => '選択してください',
            'search'     => '検索エンジン（Google・Yahoo など）',
            'sns'        => 'SNS（Instagram・Facebook など）',
            'referral'   => '知人・ご紹介',
            'signboard'  => '看板・チラシ',
            'repeat'     => '以前ご利用いただいた',
            'other'      => 'その他',
        ],
        'budget' => [
            ''           => '選択してください',
            'under50'    => '50万円未満',
            '50to100'    => '50〜100万円程度',
            '100to300'   => '100〜300万円程度',
            '300to500'   => '300〜500万円程度',
            'over500'    => '500万円以上',
            'undecided'  => '未定・わからない',
        ],
    ];
}

/* ------------------------------------------------------------------
 * STEP 1 → STEP 2: 入力値バリデーション＆セッション保存
 * ------------------------------------------------------------------ */
function miyuki_contact_validate_and_store() {
    $errors = [];
    $choices = miyuki_contact_choices();

    /* ---- テキスト系 ---- */
    $name  = sanitize_text_field( $_POST['contact_name']  ?? '' );
    $kana  = sanitize_text_field( $_POST['contact_kana']  ?? '' );
    $tel   = sanitize_text_field( $_POST['contact_tel']   ?? '' );
    $email = sanitize_email(      $_POST['contact_email'] ?? '' );
    $address  = sanitize_text_field( $_POST['contact_address']  ?? '' );
    $age      = sanitize_text_field( $_POST['contact_age']      ?? '' );
    $message  = sanitize_textarea_field( $_POST['contact_message'] ?? '' );

    /* ---- セレクト系（ホワイトリスト検証） ---- */
    $inquiry_type  = $_POST['contact_inquiry_type']  ?? '';
    $building_type = $_POST['contact_building_type'] ?? '';
    $timing        = $_POST['contact_timing']        ?? '';
    $referral      = $_POST['contact_referral']      ?? '';
    $budget        = $_POST['contact_budget']        ?? '';

    // ホワイトリスト外の値は空文字にする
    $inquiry_type  = isset( $choices['inquiry_type'][$inquiry_type] )  ? $inquiry_type  : '';
    $building_type = isset( $choices['building_type'][$building_type] ) ? $building_type : '';
    $timing        = isset( $choices['timing'][$timing] )              ? $timing        : '';
    $referral      = isset( $choices['referral'][$referral] )          ? $referral      : '';
    $budget        = isset( $choices['budget'][$budget] )              ? $budget        : '';

    /* ---- 必須チェック ---- */
    if ( $name === '' )  $errors['name']  = 'お名前は必須です。';
    if ( $email === '' ) $errors['email'] = 'メールアドレスは必須です。';
    elseif ( ! is_email( $email ) ) $errors['email'] = 'メールアドレスの形式が正しくありません。';

    if ( ! empty( $errors ) ) {
        return [ 'status' => 'error', 'errors' => $errors ];
    }

    /* ---- セッションに保存 ---- */
    $_SESSION['miyuki_contact'] = [
        'name'          => $name,
        'kana'          => $kana,
        'tel'           => $tel,
        'email'         => $email,
        'inquiry_type'  => $inquiry_type,
        'address'       => $address,
        'building_type' => $building_type,
        'age'           => $age,
        'timing'        => $timing,
        'referral'      => $referral,
        'budget'        => $budget,
        'message'       => $message,
        'timestamp'     => time(),
    ];

    return [ 'status' => 'ok' ];
}

/* ------------------------------------------------------------------
 * STEP 2 → STEP 3: Resend API でメール送信
 * ------------------------------------------------------------------ */
function miyuki_contact_send() {
    $data = $_SESSION['miyuki_contact'] ?? null;
    if ( ! $data ) {
        return [ 'status' => 'error', 'message' => 'セッションが見つかりません。最初からやり直してください。' ];
    }

    $choices = miyuki_contact_choices();

    // ラベル変換ヘルパー
    $label = function( $group, $key ) use ( $choices ) {
        return $choices[$group][$key] ?? $key;
    };

    /* ---- 管理者宛メール HTML ---- */
    $admin_html = miyuki_build_admin_mail( $data, $label );

    /* ---- 自動返信メール HTML ---- */
    $reply_html = miyuki_build_reply_mail( $data );

    /* ---- Resend API 送信（管理者宛） ---- */
    $res1 = miyuki_resend_send( [
        'from'    => CONTACT_MAIL_FROM_NAME . ' <' . CONTACT_MAIL_FROM . '>',
        'to'      => [ CONTACT_MAIL_TO ],
        'subject' => '【お問い合わせ】' . $data['name'] . ' 様よりお問い合わせがありました',
        'html'    => $admin_html,
        'reply_to' => $data['email'],
    ] );

    if ( $res1['status'] === 'error' ) {
        return $res1;
    }

    /* ---- Resend API 送信（自動返信） ---- */
    miyuki_resend_send( [
        'from'    => CONTACT_MAIL_FROM_NAME . ' <' . CONTACT_MAIL_FROM . '>',
        'to'      => [ $data['email'] ],
        'subject' => '【ミユキハウジング】お問い合わせを受け付けました',
        'html'    => $reply_html,
    ] );
    // 自動返信の失敗は無視（管理者宛が届いていれば問題なし）

    /* ---- セッションクリア ---- */
    unset( $_SESSION['miyuki_contact'] );

    return [ 'status' => 'ok' ];
}

/* ------------------------------------------------------------------
 * Resend API 呼び出し（低レベル）
 * ------------------------------------------------------------------ */
function miyuki_resend_send( array $payload ): array {
    if ( RESEND_API_KEY === '' ) {
        return [ 'status' => 'error', 'message' => 'RESEND_API_KEY が設定されていません。' ];
    }

    $response = wp_remote_post( 'https://api.resend.com/emails', [
        'timeout' => 15,
        'headers' => [
            'Authorization' => 'Bearer ' . RESEND_API_KEY,
            'Content-Type'  => 'application/json',
        ],
        'body' => wp_json_encode( $payload ),
    ] );

    if ( is_wp_error( $response ) ) {
        return [ 'status' => 'error', 'message' => $response->get_error_message() ];
    }

    $code = wp_remote_retrieve_response_code( $response );
    if ( $code < 200 || $code >= 300 ) {
        $body = wp_remote_retrieve_body( $response );
        return [ 'status' => 'error', 'message' => "Resend API エラー (HTTP {$code}): {$body}" ];
    }

    return [ 'status' => 'ok' ];
}

/* ------------------------------------------------------------------
 * メール本文ビルダー（管理者宛）
 * ------------------------------------------------------------------ */
function miyuki_build_admin_mail( array $d, callable $label ): string {
    $site = esc_html( get_bloginfo( 'name' ) );
    $date = wp_date( 'Y年n月j日 H:i' );

    $rows = [
        'お名前'             => $d['name'],
        'フリガナ'           => $d['kana'] ?: '（未入力）',
        '電話番号'           => $d['tel']  ?: '（未入力）',
        'メールアドレス'     => $d['email'],
        'お問い合わせ種別'   => $label( 'inquiry_type', $d['inquiry_type'] ) ?: '（未選択）',
        '都道府県・市町村'   => $d['address']  ?: '（未入力）',
        '建物の種類'         => $label( 'building_type', $d['building_type'] ) ?: '（未選択）',
        '築年数・建築年'     => $d['age']      ?: '（未入力）',
        'ご希望の工事時期'   => $label( 'timing', $d['timing'] ) ?: '（未選択）',
        'おおよその予算'     => $label( 'budget', $d['budget'] ) ?: '（未選択）',
        'お知りになった経緯' => $label( 'referral', $d['referral'] ) ?: '（未選択）',
    ];

    $table_rows = '';
    foreach ( $rows as $label_text => $value ) {
        $table_rows .= sprintf(
            '<tr><th style="width:180px;padding:10px 14px;background:#f5f5f5;border:1px solid #ddd;text-align:left;white-space:nowrap;">%s</th><td style="padding:10px 14px;border:1px solid #ddd;">%s</td></tr>',
            esc_html( $label_text ),
            nl2br( esc_html( $value ) )
        );
    }

    $message_html = nl2br( esc_html( $d['message'] ) ) ?: '（未入力）';

    return <<<HTML
<!DOCTYPE html>
<html lang="ja">
<head><meta charset="UTF-8"><title>お問い合わせ通知</title></head>
<body style="font-family:sans-serif;color:#333;line-height:1.7;max-width:640px;margin:0 auto;padding:20px;">
  <h2 style="border-left:4px solid #c8a96e;padding-left:12px;font-size:18px;">{$site}：お問い合わせがありました</h2>
  <p style="color:#666;font-size:14px;">受信日時：{$date}</p>
  <table style="width:100%;border-collapse:collapse;margin:16px 0;">
    {$table_rows}
  </table>
  <h3 style="border-left:4px solid #c8a96e;padding-left:12px;font-size:16px;">お問い合わせ内容</h3>
  <div style="background:#fafafa;border:1px solid #ddd;padding:16px;border-radius:4px;">{$message_html}</div>
  <hr style="margin:24px 0;border:none;border-top:1px solid #eee;">
  <p style="font-size:12px;color:#999;">このメールは {$site} ウェブサイトのお問い合わせフォームから自動送信されました。</p>
</body>
</html>
HTML;
}

/* ------------------------------------------------------------------
 * メール本文ビルダー（自動返信）
 * ------------------------------------------------------------------ */
function miyuki_build_reply_mail( array $d ): string {
    $site = esc_html( get_bloginfo( 'name' ) );
    $name = esc_html( $d['name'] );
    $tel  = 'info@miyuki-housing.jp';
    $message_html = nl2br( esc_html( $d['message'] ) ) ?: '（未入力）';

    return <<<HTML
<!DOCTYPE html>
<html lang="ja">
<head><meta charset="UTF-8"><title>お問い合わせ受付</title></head>
<body style="font-family:sans-serif;color:#333;line-height:1.8;max-width:600px;margin:0 auto;padding:20px;">
  <h2 style="border-left:4px solid #c8a96e;padding-left:12px;font-size:18px;">お問い合わせありがとうございます</h2>
  <p>{$name} 様</p>
  <p>このたびはお問い合わせいただき、誠にありがとうございます。<br>
  内容を確認の上、担当者より改めてご連絡いたします。</p>
  <p>なお、お急ぎの場合は下記までお電話ください。</p>
<p style="font-size:18px;font-weight:bold;color:#c8a96e;">📞 082-263-8066</p>
  <hr style="margin:24px 0;border:none;border-top:1px solid #eee;">
  <h3 style="font-size:15px;color:#666;">【送信内容の確認】</h3>
  <div style="background:#fafafa;border:1px solid #ddd;padding:16px;border-radius:4px;font-size:14px;">{$message_html}</div>
  <hr style="margin:24px 0;border:none;border-top:1px solid #eee;">
  <p style="font-size:13px;color:#999;">
    {$site}<br>
    このメールは自動送信されています。このメールへの返信はお受けできません。<br>
    お問い合わせは <a href="{$tel}" style="color:#c8a96e;">{$tel}</a> までお願いします。
  </p>
</body>
</html>
HTML;
}