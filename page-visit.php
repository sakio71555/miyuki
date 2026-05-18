<?php
/**
 * Template Name: 来店予約
 *
 * 入力 → 確認 → 完了 の3ステップ
 * Resend API でメール送信
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once get_template_directory() . '/inc/visit-handler.php';

/* ---------------------------------------------------------------
 * POST 処理
 * ------------------------------------------------------------- */
$errors     = [];
$send_error = '';
$step       = 'input';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  
  if ( isset( $_POST['action'] ) && $_POST['action'] === 'confirm' ) {
    if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'miyuki_visit_input' ) ) {
      $errors['nonce'] = '不正なリクエストです。もう一度お試しください。';
    } else {
      $result = miyuki_visit_validate_and_store();
      if ( $result['status'] === 'ok' ) {
        $step = 'confirm';
      } else {
        $errors = $result['errors'];
      }
    }
  }
  
  elseif ( isset( $_POST['action'] ) && $_POST['action'] === 'send' ) {
    if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'miyuki_visit_confirm' ) ) {
      $send_error = '不正なリクエストです。もう一度お試しください。';
      $step = 'confirm';
    } else {
      $result = miyuki_visit_send();
      if ( $result['status'] === 'ok' ) {
        $step = 'complete';
      } else {
        $send_error = $result['message'];
        $step = 'confirm';
      }
    }
  }
  
  elseif ( isset( $_POST['action'] ) && $_POST['action'] === 'back' ) {
    $step = 'input';
  }
}

$d = $_SESSION['miyuki_visit'] ?? [];

/* 時間帯選択肢 */
$time_slots = miyuki_visit_time_slots();

/* ご相談内容選択肢 */
$topics = miyuki_visit_topics();

get_header();
?>

<main id="main" class="site-main visit-page">

<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Reservation</span>
    <span class="page-hero-ja">来店予約</span>
  </div>
</div>

<div class="container py-5">
  <div class="row">
    <div class="col-xl-8 col-lg-9 mx-auto">
      
      <!-- ステップインジケーター -->
      <div class="contact-steps mb-5">
        <div class="step <?= $step === 'input'    ? 'active' : ( in_array( $step, ['confirm','complete'] ) ? 'done' : '' ) ?>">
          <span class="step-num">1</span><span class="step-label">入力</span>
        </div>
        <div class="step-arrow">›</div>
        <div class="step <?= $step === 'confirm'  ? 'active' : ( $step === 'complete' ? 'done' : '' ) ?>">
          <span class="step-num">2</span><span class="step-label">確認</span>
        </div>
        <div class="step-arrow">›</div>
        <div class="step <?= $step === 'complete' ? 'active' : '' ?>">
          <span class="step-num">3</span><span class="step-label">完了</span>
        </div>
      </div>
      
      <?php /* ================================================================
         * STEP 1: 入力フォーム
         * ============================================================== */ ?>
      <?php if ( $step === 'input' ) : ?>
      
      <div class="contact-lead mb-4">
        <p>ご希望の来店日をご入力ください。<br>
          確認後、担当者よりご連絡いたします（2営業日以内）。<br>
        <span class="text-danger">*</span> は必須項目です。</p>
      </div>
      
      <!-- 営業情報 -->
      <div class="visit-info-box mb-4">
        <p>📍 広島市東区曙5丁目4-6</p>
        <p>🕐 受付時間：平日・土日 9:00〜18:00（水曜定休）</p>
      </div>
      
      <?php if ( ! empty( $errors ) ) : ?>
      <div class="alert alert-danger mb-4">
        <ul class="mb-0">
          <?php foreach ( $errors as $e ) echo '<li>' . esc_html( $e ) . '</li>'; ?>
        </ul>
      </div>
      <?php endif; ?>
      
      <form method="post" action="" novalidate class="contact-form">
        <?php wp_nonce_field( 'miyuki_visit_input' ); ?>
        <input type="hidden" name="action" value="confirm">
        
        <!-- お名前 -->
        <div class="contact-field <?= isset( $errors['name'] ) ? 'has-error' : '' ?>">
          <label for="visit_name">お名前 <span class="required">*</span></label>
          <input type="text" id="visit_name" name="visit_name"
          value="<?= esc_attr( $d['name'] ?? $_POST['visit_name'] ?? '' ) ?>"
          placeholder="例：宮之浦 太郎" required>
          <?php if ( isset( $errors['name'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['name'] ) ?></p>
          <?php endif; ?>
        </div>
        
        <!-- 電話番号 -->
        <div class="contact-field <?= isset( $errors['tel'] ) ? 'has-error' : '' ?>">
          <label for="visit_tel">電話番号 <span class="required">*</span></label>
          <input type="tel" id="visit_tel" name="visit_tel"
          value="<?= esc_attr( $d['tel'] ?? $_POST['visit_tel'] ?? '' ) ?>"
          placeholder="例：082-123-4567" required>
          <?php if ( isset( $errors['tel'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['tel'] ) ?></p>
          <?php endif; ?>
        </div>
        
        <!-- メールアドレス -->
        <div class="contact-field <?= isset( $errors['email'] ) ? 'has-error' : '' ?>">
          <label for="visit_email">メールアドレス <span class="required">*</span></label>
          <input type="email" id="visit_email" name="visit_email"
          value="<?= esc_attr( $d['email'] ?? $_POST['visit_email'] ?? '' ) ?>"
          placeholder="例：info@example.com" required>
          <?php if ( isset( $errors['email'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['email'] ) ?></p>
          <?php endif; ?>
        </div>
        
        <!-- 来店希望日 第1希望 -->
        <div class="contact-field <?= isset( $errors['date1'] ) ? 'has-error' : '' ?>">
          <label for="visit_date1">来店希望日 第1希望 <span class="required">*</span></label>
          <input type="date" id="visit_date1" name="visit_date1"
          value="<?= esc_attr( $d['date1'] ?? $_POST['visit_date1'] ?? '' ) ?>"
          min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
          <?php if ( isset( $errors['date1'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['date1'] ) ?></p>
          <?php endif; ?>
        </div>
        
        <!-- 来店希望日 第2希望 -->
        <div class="contact-field">
          <label for="visit_date2">来店希望日 第2希望</label>
          <input type="date" id="visit_date2" name="visit_date2"
          value="<?= esc_attr( $d['date2'] ?? $_POST['visit_date2'] ?? '' ) ?>"
          min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
        </div>
        
        <!-- 希望時間帯 -->
        <div class="contact-field">
          <label for="visit_time">ご希望の時間帯</label>
          <select id="visit_time" name="visit_time">
            <?php foreach ( $time_slots as $val => $label ) :
            $sel = ( ( $d['time'] ?? $_POST['visit_time'] ?? '' ) === $val ) ? 'selected' : ''; ?>
            <option value="<?= esc_attr( $val ) ?>" <?= $sel ?>><?= esc_html( $label ) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <!-- ご相談内容 -->
        <div class="contact-field">
          <label for="visit_topic">ご相談内容</label>
          <select id="visit_topic" name="visit_topic">
            <?php foreach ( $topics as $val => $label ) :
            $sel = ( ( $d['topic'] ?? $_POST['visit_topic'] ?? '' ) === $val ) ? 'selected' : ''; ?>
            <option value="<?= esc_attr( $val ) ?>" <?= $sel ?>><?= esc_html( $label ) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <!-- ご自由記入 -->
        <div class="contact-field">
          <label for="visit_note">ご質問・ご要望</label>
          <textarea id="visit_note" name="visit_note" rows="4"
          placeholder="ご質問やご要望があればご自由にお書きください"><?= esc_textarea( $d['note'] ?? $_POST['visit_note'] ?? '' ) ?></textarea>
        </div>
        
        <!-- プライバシーポリシー同意 -->
        <div class="contact-privacy mb-4">
          <label class="privacy-check">
            <input type="checkbox" name="agree_privacy" value="1" required>
            <a href="<?= esc_url( home_url( '/privacy/' ) ) ?>" target="_blank">プライバシーポリシー</a>に同意する
          </label>
        </div>
        
        <div class="contact-submit">
          <button type="submit" class="btn-contact-submit">確認画面へ</button>
        </div>
        
      </form>
      
      <?php /* ================================================================
         * STEP 2: 確認画面
         * ============================================================== */ ?>
      <?php elseif ( $step === 'confirm' ) : ?>
      
      <div class="contact-lead mb-4">
        <p>以下の内容でよろしければ「送信する」ボタンを押してください。</p>
      </div>
      
      <?php if ( $send_error ) : ?>
      <div class="alert alert-danger mb-4"><?= esc_html( $send_error ) ?></div>
      <?php endif; ?>
      
      <div class="contact-confirm-table mb-5">
        <?php
        $date1_fmt = $d['date1'] ? date('Y年n月j日', strtotime($d['date1'])) : '';
        $date2_fmt = $d['date2'] ? date('Y年n月j日', strtotime($d['date2'])) : '';
        $rows = [
        'お名前'           => $d['name']   ?? '',
        '電話番号'         => $d['tel']    ?? '',
        'メールアドレス'   => $d['email']  ?? '',
        '来店希望日 第1希望' => $date1_fmt,
        '来店希望日 第2希望' => $date2_fmt,
        'ご希望の時間帯'   => $time_slots[ $d['time'] ?? '' ] ?? '',
        'ご相談内容'       => $topics[ $d['topic'] ?? '' ] ?? '',
        'ご質問・ご要望'   => $d['note']   ?? '',
        ];
        foreach ( $rows as $label => $value ) :
        if ( $value === '' ) continue; ?>
        <div class="confirm-row">
          <dt><?= esc_html( $label ) ?></dt>
          <dd><?= nl2br( esc_html( $value ) ) ?></dd>
        </div>
        <?php endforeach; ?>
      </div>
      
      <div class="contact-confirm-actions">
        <form method="post" action="" style="display:inline;">
          <?php wp_nonce_field( 'miyuki_visit_confirm' ); ?>
          <input type="hidden" name="action" value="back">
          <button type="submit" class="btn-contact-back">入力に戻る</button>
        </form>
        <form method="post" action="" style="display:inline;">
          <?php wp_nonce_field( 'miyuki_visit_confirm' ); ?>
          <input type="hidden" name="action" value="send">
          <button type="submit" class="btn-contact-submit">送信する</button>
        </form>
      </div>
      
      <?php /* ================================================================
         * STEP 3: 完了画面
         * ============================================================== */ ?>
      <?php elseif ( $step === 'complete' ) : ?>
      
      <div class="contact-complete text-center py-5">
        <div class="complete-icon mb-4">✓</div>
        <h2 class="mb-3">来店予約を受け付けました</h2>
        <p>このたびはご予約いただき、誠にありがとうございます。<br>
          ご入力いただいたメールアドレス宛に確認メールをお送りしました。<br>
        担当者より2営業日以内にご連絡いたします。</p>
        <p class="mt-2 text-muted" style="font-size:.9em;">
          ※ お急ぎの方はお電話でもお気軽にご連絡ください。<br>
          ※ 水曜日は定休日です。
        </p>
        <p style="font-size:1.2rem;font-weight:bold;color:#c8a96e;" class="mt-3">
          📞 082-263-8066
        </p>
        <a href="<?= esc_url( home_url( '/' ) ) ?>" class="btn-contact-back mt-4 d-inline-block">トップページへ戻る</a>
      </div>
      
      <?php endif; ?>
      
    </div>
  </div>
</div>

</main>

<?php get_footer(); ?>