<?php
/**
 * visit-handler.php
 * 来店予約フォーム処理（バリデーション・セッション・Resend API送信）
 *
 * inc/ フォルダに配置してください。
 * Resend API の送信関数は contact-handler.php の miyuki_resend_send() を共用します。
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once get_template_directory() . '/inc/contact-handler.php';

/* ------------------------------------------------------------------
 * 時間帯選択肢
 * ------------------------------------------------------------------ */
function miyuki_visit_time_slots(): array {
  return [
  ''        => '選択してください',
  'morning' => '午前中（9:00〜12:00）',
  'early'   => '13:00〜15:00',
  'late'    => '15:00〜18:00',
  'anytime' => 'いつでも可',
  ];
}

/* ------------------------------------------------------------------
 * ご相談内容選択肢
 * ------------------------------------------------------------------ */
function miyuki_visit_topics(): array {
  return [
  ''           => '選択してください',
  'new_build'  => '新築・建て替え',
  'reform'     => 'リフォーム・増改築',
  'exterior'   => '外壁・屋根塗装',
  'maintenance'=> 'メンテナンス',
  'other'      => 'その他・まだ決まっていない',
  ];
}

/* ------------------------------------------------------------------
 * STEP 1 → STEP 2: バリデーション＆セッション保存
 * ------------------------------------------------------------------ */
function miyuki_visit_validate_and_store(): array {
  $errors = [];
  
  $name  = sanitize_text_field( $_POST['visit_name']  ?? '' );
  $tel   = sanitize_text_field( $_POST['visit_tel']   ?? '' );
  $email = sanitize_email(      $_POST['visit_email'] ?? '' );
  $date1 = sanitize_text_field( $_POST['visit_date1'] ?? '' );
  $date2 = sanitize_text_field( $_POST['visit_date2'] ?? '' );
  $note  = sanitize_textarea_field( $_POST['visit_note'] ?? '' );
  
  /* セレクト ホワイトリスト検証 */
  $time  = $_POST['visit_time']  ?? '';
  $topic = $_POST['visit_topic'] ?? '';
  $time  = isset( miyuki_visit_time_slots()[$time] )   ? $time  : '';
  $topic = isset( miyuki_visit_topics()[$topic] )      ? $topic : '';
  
  /* 必須チェック */
  if ( $name === '' )  $errors['name']  = 'お名前は必須です。';
  if ( $tel === '' )   $errors['tel']   = '電話番号は必須です。';
  if ( $email === '' ) $errors['email'] = 'メールアドレスは必須です。';
  elseif ( ! is_email( $email ) ) $errors['email'] = 'メールアドレスの形式が正しくありません。';
  if ( $date1 === '' ) $errors['date1'] = '来店希望日（第1希望）は必須です。';
  
  if ( ! empty( $errors ) ) {
    return [ 'status' => 'error', 'errors' => $errors ];
  }
  
  $_SESSION['miyuki_visit'] = [
  'name'      => $name,
  'tel'       => $tel,
  'email'     => $email,
  'date1'     => $date1,
  'date2'     => $date2,
  'time'      => $time,
  'topic'     => $topic,
  'note'      => $note,
  'timestamp' => time(),
  ];
  
  return [ 'status' => 'ok' ];
}

/* ------------------------------------------------------------------
 * STEP 2 → STEP 3: Resend API でメール送信
 * ------------------------------------------------------------------ */
function miyuki_visit_send(): array {
  $data = $_SESSION['miyuki_visit'] ?? null;
  if ( ! $data ) {
    return [ 'status' => 'error', 'message' => 'セッションが見つかりません。最初からやり直してください。' ];
  }
  
  $time_slots = miyuki_visit_time_slots();
  $topics     = miyuki_visit_topics();
  
  $date1_fmt = $data['date1'] ? date('Y年n月j日', strtotime($data['date1'])) : '';
  $date2_fmt = $data['date2'] ? date('Y年n月j日', strtotime($data['date2'])) : '（なし）';
  $time_label  = $time_slots[ $data['time'] ]  ?? '（未選択）';
  $topic_label = $topics[ $data['topic'] ] ?? '（未選択）';
  
  /* 管理者宛 */
  $res = miyuki_resend_send( [
  'from'     => CONTACT_MAIL_FROM_NAME . ' <' . CONTACT_MAIL_FROM . '>',
  'to'       => [ CONTACT_MAIL_TO ],
  'subject'  => '【来店予約】' . $data['name'] . ' 様より来店予約がありました',
  'html'     => miyuki_build_visit_admin_mail( $data, $date1_fmt, $date2_fmt, $time_label, $topic_label ),
  'reply_to' => $data['email'],
  ] );
  
  if ( $res['status'] === 'error' ) return $res;
  
  /* 自動返信 */
  miyuki_resend_send( [
  'from'    => CONTACT_MAIL_FROM_NAME . ' <' . CONTACT_MAIL_FROM . '>',
  'to'      => [ $data['email'] ],
  'subject' => '【ミユキハウジング】来店予約を受け付けました',
  'html'    => miyuki_build_visit_reply_mail( $data, $date1_fmt, $date2_fmt, $time_label ),
  ] );
  
  unset( $_SESSION['miyuki_visit'] );
  return [ 'status' => 'ok' ];
}

/* ------------------------------------------------------------------
 * メール本文（管理者宛）
 * ------------------------------------------------------------------ */
function miyuki_build_visit_admin_mail( array $d, string $date1, string $date2, string $time, string $topic ): string {
  $site = esc_html( get_bloginfo( 'name' ) );
  $recv = wp_date( 'Y年n月j日 H:i' );
  
  $rows = [
  'お名前'           => $d['name'],
  '電話番号'         => $d['tel'],
  'メールアドレス'   => $d['email'],
  '来店希望日 第1希望' => $date1,
  '来店希望日 第2希望' => $date2,
  'ご希望の時間帯'   => $time,
  'ご相談内容'       => $topic,
  'ご質問・ご要望'   => $d['note'] ?: '（なし）',
  ];
  
  $table_rows = '';
  foreach ( $rows as $label => $value ) {
    $table_rows .= sprintf(
    '<tr><th style="width:180px;padding:10px 14px;background:#f5f5f5;border:1px solid #ddd;text-align:left;white-space:nowrap;">%s</th><td style="padding:10px 14px;border:1px solid #ddd;">%s</td></tr>',
    esc_html( $label ),
    nl2br( esc_html( $value ) )
    );
  }
  
  return <<<HTML
<!DOCTYPE html><html lang="ja"><head><meta charset="UTF-8"></head>
<body style="font-family:sans-serif;color:#333;line-height:1.7;max-width:640px;margin:0 auto;padding:20px;">
  <h2 style="border-left:4px solid #c8a96e;padding-left:12px;font-size:18px;">{$site}：来店予約がありました</h2>
  <p style="color:#666;font-size:14px;">受信日時：{$recv}</p>
  <table style="width:100%;border-collapse:collapse;margin:16px 0;">{$table_rows}</table>
  <hr style="margin:24px 0;border:none;border-top:1px solid #eee;">
  <p style="font-size:12px;color:#999;">このメールは {$site} ウェブサイトの来店予約フォームから自動送信されました。</p>
</body></html>
HTML;
}

/* ------------------------------------------------------------------
 * メール本文（自動返信）
 * ------------------------------------------------------------------ */
function miyuki_build_visit_reply_mail( array $d, string $date1, string $date2, string $time ): string {
  $site = esc_html( get_bloginfo( 'name' ) );
  $name = esc_html( $d['name'] );
  
  return <<<HTML
<!DOCTYPE html><html lang="ja"><head><meta charset="UTF-8"></head>
<body style="font-family:sans-serif;color:#333;line-height:1.8;max-width:600px;margin:0 auto;padding:20px;">
  <h2 style="border-left:4px solid #c8a96e;padding-left:12px;font-size:18px;">来店予約ありがとうございます</h2>
  <p>{$name} 様</p>
  <p>このたびはご予約いただき、誠にありがとうございます。<br>
  担当者より2営業日以内にご連絡いたします。</p>
  <div style="background:#f9f7f4;border:1px solid #e8ddd0;padding:16px 20px;border-radius:4px;margin:16px 0;">
    <strong>ご来店希望日</strong><br>
    第1希望：{$date1}<br>
    第2希望：{$date2}<br>
    時間帯：{$time}
  </div>
  <p>お急ぎの場合は下記までお電話ください。</p>
  <p style="font-size:18px;font-weight:bold;color:#c8a96e;">📞 082-263-8066</p>
  <p style="font-size:.85rem;color:#888;">受付時間：平日・土日 9:00〜18:00（水曜定休）</p>
  <hr style="margin:24px 0;border:none;border-top:1px solid #eee;">
  <p style="font-size:13px;color:#999;">{$site}<br>このメールは自動送信されています。このメールへの返信はお受けできません。</p>
</body></html>
HTML;
}