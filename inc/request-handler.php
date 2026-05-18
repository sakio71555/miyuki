<?php
/**
 * request-handler.php
 * 資料請求フォーム処理（バリデーション・セッション・Resend API送信）
 *
 * inc/ フォルダに配置してください。
 * wp-config.php の定数は contact-handler.php と共用です。
 */

if ( ! defined( 'ABSPATH' ) ) exit;
require_once get_template_directory() . '/inc/contact-handler.php';

/* ------------------------------------------------------------------
 * 資料リスト定義
 * ★ ここを差し替えてください
 * ------------------------------------------------------------------ */
function miyuki_request_documents(): array {
  return [
  'company'     => [
  'name' => '会社案内・施工事例集',
  'desc' => '会社概要と施工実例を一冊にまとめた資料です。',
  ],
  'price_guide' => [
  'name' => 'リフォーム料金ガイド',
  'desc' => '各種リフォームの目安費用をわかりやすく解説した資料です。',
  ],
  'maintenance' => [
  'name' => '住まいのメンテナンスBOOK',
  'desc' => '建物を長持ちさせるためのメンテナンス情報をまとめた資料です。',
  ],
  ];
}

/* ------------------------------------------------------------------
 * STEP 1 → STEP 2: バリデーション＆セッション保存
 * ------------------------------------------------------------------ */
function miyuki_request_validate_and_store(): array {
  $errors = [];
  
  $docs     = array_map( 'sanitize_text_field', (array)( $_POST['docs'] ?? [] ) );
  $name     = sanitize_text_field( $_POST['req_name']     ?? '' );
  $kana     = sanitize_text_field( $_POST['req_kana']     ?? '' );
  $tel      = sanitize_text_field( $_POST['req_tel']      ?? '' );
  $email    = sanitize_email(      $_POST['req_email']    ?? '' );
  $zip      = sanitize_text_field( $_POST['req_zip']      ?? '' );
  $address  = sanitize_text_field( $_POST['req_address']  ?? '' );
  $interest = sanitize_text_field( $_POST['req_interest'] ?? '' );
  $note     = sanitize_textarea_field( $_POST['req_note'] ?? '' );
  
  /* ホワイトリスト検証 */
  $valid_keys = array_keys( miyuki_request_documents() );
  $docs = array_filter( $docs, fn( $k ) => in_array( $k, $valid_keys, true ) );
  
  /* 必須チェック */
  if ( empty( $docs ) )    $errors['docs']    = '資料を1つ以上お選びください。';
  if ( $name === '' )      $errors['name']    = 'お名前は必須です。';
  if ( $email === '' )     $errors['email']   = 'メールアドレスは必須です。';
  elseif ( ! is_email( $email ) ) $errors['email'] = 'メールアドレスの形式が正しくありません。';
  if ( $zip === '' )       $errors['zip']     = '郵便番号は必須です。';
  if ( $address === '' )   $errors['address'] = 'ご住所は必須です。';
  
  if ( ! empty( $errors ) ) {
    return [ 'status' => 'error', 'errors' => $errors ];
  }
  
  $_SESSION['miyuki_request'] = [
  'docs'      => array_values( $docs ),
  'name'      => $name,
  'kana'      => $kana,
  'tel'       => $tel,
  'email'     => $email,
  'zip'       => $zip,
  'address'   => $address,
  'interest'  => $interest,
  'note'      => $note,
  'timestamp' => time(),
  ];
  
  return [ 'status' => 'ok' ];
}

/* ------------------------------------------------------------------
 * STEP 2 → STEP 3: Resend API でメール送信
 * ------------------------------------------------------------------ */
function miyuki_request_send(): array {
  $data = $_SESSION['miyuki_request'] ?? null;
  if ( ! $data ) {
    return [ 'status' => 'error', 'message' => 'セッションが見つかりません。最初からやり直してください。' ];
  }
  
  $documents = miyuki_request_documents();
  $doc_names = implode( '、', array_map(
  fn( $k ) => $documents[$k]['name'] ?? $k,
  $data['docs']
  ) );
  
  /* 管理者宛 */
  $res = miyuki_resend_send( [
  'from'     => CONTACT_MAIL_FROM_NAME . ' <' . CONTACT_MAIL_FROM . '>',
  'to'       => [ CONTACT_MAIL_TO ],
  'subject'  => '【資料請求】' . $data['name'] . ' 様より資料請求がありました',
  'html'     => miyuki_build_request_admin_mail( $data, $doc_names ),
  'reply_to' => $data['email'],
  ] );
  
  if ( $res['status'] === 'error' ) return $res;
  
  /* 自動返信 */
  miyuki_resend_send( [
  'from'    => CONTACT_MAIL_FROM_NAME . ' <' . CONTACT_MAIL_FROM . '>',
  'to'      => [ $data['email'] ],
  'subject' => '【ミユキハウジング】資料請求を受け付けました',
  'html'    => miyuki_build_request_reply_mail( $data, $doc_names ),
  ] );
  
  unset( $_SESSION['miyuki_request'] );
  return [ 'status' => 'ok' ];
}

/* ------------------------------------------------------------------
 * メール本文（管理者宛）
 * ------------------------------------------------------------------ */
function miyuki_build_request_admin_mail( array $d, string $doc_names ): string {
  $site = esc_html( get_bloginfo( 'name' ) );
  $date = wp_date( 'Y年n月j日 H:i' );
  
  $rows = [
  'ご希望の資料'     => $doc_names,
  'お名前'           => $d['name'],
  'フリガナ'         => $d['kana']    ?: '（未入力）',
  '電話番号'         => $d['tel']     ?: '（未入力）',
  'メールアドレス'   => $d['email'],
  '郵便番号'         => $d['zip'],
  'ご住所'           => $d['address'],
  'ご興味の工事内容' => $d['interest'] ?: '（未入力）',
  '備考・ご質問'     => $d['note']    ?: '（未入力）',
  ];
  
  $table_rows = '';
  foreach ( $rows as $label => $value ) {
    $table_rows .= sprintf(
    '<tr><th style="width:160px;padding:10px 14px;background:#f5f5f5;border:1px solid #ddd;text-align:left;white-space:nowrap;">%s</th><td style="padding:10px 14px;border:1px solid #ddd;">%s</td></tr>',
    esc_html( $label ),
    nl2br( esc_html( $value ) )
    );
  }
  
  return <<<HTML
<!DOCTYPE html><html lang="ja"><head><meta charset="UTF-8"></head>
<body style="font-family:sans-serif;color:#333;line-height:1.7;max-width:640px;margin:0 auto;padding:20px;">
  <h2 style="border-left:4px solid #c8a96e;padding-left:12px;font-size:18px;">{$site}：資料請求がありました</h2>
  <p style="color:#666;font-size:14px;">受信日時：{$date}</p>
  <table style="width:100%;border-collapse:collapse;margin:16px 0;">{$table_rows}</table>
  <hr style="margin:24px 0;border:none;border-top:1px solid #eee;">
  <p style="font-size:12px;color:#999;">このメールは {$site} ウェブサイトの資料請求フォームから自動送信されました。</p>
</body></html>
HTML;
}

/* ------------------------------------------------------------------
 * メール本文（自動返信）
 * ------------------------------------------------------------------ */
function miyuki_build_request_reply_mail( array $d, string $doc_names ): string {
  $site = esc_html( get_bloginfo( 'name' ) );
  $name = esc_html( $d['name'] );
  
  return <<<HTML
<!DOCTYPE html><html lang="ja"><head><meta charset="UTF-8"></head>
<body style="font-family:sans-serif;color:#333;line-height:1.8;max-width:600px;margin:0 auto;padding:20px;">
  <h2 style="border-left:4px solid #c8a96e;padding-left:12px;font-size:18px;">資料請求ありがとうございます</h2>
  <p>{$name} 様</p>
  <p>このたびは資料請求いただき、誠にありがとうございます。<br>
  下記の資料を順次ご登録の住所へ郵送いたします。</p>
  <div style="background:#f9f7f4;border:1px solid #e8ddd0;padding:16px 20px;border-radius:4px;margin:16px 0;">
    <strong>ご請求の資料：</strong><br>
    {$doc_names}
  </div>
  <p>発送まで1週間程度お時間をいただく場合がございます。<br>
  お急ぎの場合は下記までお電話ください。</p>
  <p style="font-size:18px;font-weight:bold;color:#c8a96e;">📞 082-263-8066</p>
  <hr style="margin:24px 0;border:none;border-top:1px solid #eee;">
  <p style="font-size:13px;color:#999;">{$site}<br>このメールは自動送信されています。このメールへの返信はお受けできません。</p>
</body></html>
HTML;
}