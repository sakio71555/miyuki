<?php
/**
 * Template Name: 資料請求
 *
 * 入力 → 確認 → 完了 の3ステップ
 * Resend API でメール送信
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once get_template_directory() . '/inc/request-handler.php';

/* ---------------------------------------------------------------
 * POST 処理
 * ------------------------------------------------------------- */
$errors     = [];
$send_error = '';
$step       = 'input';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  
  if ( isset( $_POST['action'] ) && $_POST['action'] === 'confirm' ) {
    if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'miyuki_request_input' ) ) {
      $errors['nonce'] = '不正なリクエストです。もう一度お試しください。';
    } else {
      $result = miyuki_request_validate_and_store();
      if ( $result['status'] === 'ok' ) {
        $step = 'confirm';
      } else {
        $errors = $result['errors'];
      }
    }
  }
  
  elseif ( isset( $_POST['action'] ) && $_POST['action'] === 'send' ) {
    if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'miyuki_request_confirm' ) ) {
      $send_error = '不正なリクエストです。もう一度お試しください。';
      $step = 'confirm';
    } else {
      $result = miyuki_request_send();
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

$d = $_SESSION['miyuki_request'] ?? [];

/* 資料リスト */
$documents = miyuki_request_documents();

get_header();
?>

<main id="main" class="site-main request-page">

<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Request</span>
    <span class="page-hero-ja">資料請求</span>
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
        <p>ご希望の資料をお選びの上、送付先をご入力ください。<br>
          資料は郵便にてお届けいたします（無料）。<br>
        <span class="text-danger">*</span> は必須項目です。</p>
      </div>
      
      <?php if ( ! empty( $errors ) ) : ?>
      <div class="alert alert-danger mb-4">
        <ul class="mb-0">
          <?php foreach ( $errors as $e ) echo '<li>' . esc_html( $e ) . '</li>'; ?>
        </ul>
      </div>
      <?php endif; ?>
      
      <form method="post" action="" novalidate class="contact-form">
        <?php wp_nonce_field( 'miyuki_request_input' ); ?>
        <input type="hidden" name="action" value="confirm">
        
        <!-- 資料選択 -->
        <div class="contact-field request-docs-field">
          <label>ご希望の資料 <span class="required">*</span></label>
			<p><br><br>
				只今準備中です。今しばらくお待ちください。<br><br>
			</p>
         <!-- <div class="request-docs-list">
            <?php foreach ( $documents as $key => $doc ) :
            $checked = in_array( $key, (array)( $d['docs'] ?? $_POST['docs'] ?? [] ) ) ? 'checked' : ''; ?>
            <label class="request-doc-item">
              <input type="checkbox" name="docs[]" value="<?= esc_attr( $key ) ?>" <?= $checked ?>>
              <div class="request-doc-body">
                <span class="request-doc-name"><?= esc_html( $doc['name'] ) ?></span>
                <span class="request-doc-desc"><?= esc_html( $doc['desc'] ) ?></span>
              </div>
            </label>
            <?php endforeach; ?>
          </div>
          <?php if ( isset( $errors['docs'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['docs'] ) ?></p>
          <?php endif; ?>-->
        </div>
        
        <!-- お名前 -->
        <div class="contact-field <?= isset( $errors['name'] ) ? 'has-error' : '' ?>">
          <label for="req_name">お名前 <span class="required">*</span></label>
          <input type="text" id="req_name" name="req_name"
          value="<?= esc_attr( $d['name'] ?? $_POST['req_name'] ?? '' ) ?>"
          placeholder="例：宮之浦 太郎" required>
          <?php if ( isset( $errors['name'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['name'] ) ?></p>
          <?php endif; ?>
        </div>
        
        <!-- フリガナ -->
        <div class="contact-field">
          <label for="req_kana">フリガナ</label>
          <input type="text" id="req_kana" name="req_kana"
          value="<?= esc_attr( $d['kana'] ?? $_POST['req_kana'] ?? '' ) ?>"
          placeholder="例：ミヤノウラ タロウ">
        </div>
        
        <!-- 電話番号 -->
        <div class="contact-field">
          <label for="req_tel">電話番号</label>
          <input type="tel" id="req_tel" name="req_tel"
          value="<?= esc_attr( $d['tel'] ?? $_POST['req_tel'] ?? '' ) ?>"
          placeholder="例：082-123-4567">
        </div>
        
        <!-- メールアドレス -->
        <div class="contact-field <?= isset( $errors['email'] ) ? 'has-error' : '' ?>">
          <label for="req_email">メールアドレス <span class="required">*</span></label>
          <input type="email" id="req_email" name="req_email"
          value="<?= esc_attr( $d['email'] ?? $_POST['req_email'] ?? '' ) ?>"
          placeholder="例：info@example.com" required>
          <?php if ( isset( $errors['email'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['email'] ) ?></p>
          <?php endif; ?>
        </div>
        
        <!-- 郵便番号 -->
        <div class="contact-field <?= isset( $errors['zip'] ) ? 'has-error' : '' ?>">
          <label for="req_zip">郵便番号 <span class="required">*</span></label>
          <input type="text" id="req_zip" name="req_zip"
          value="<?= esc_attr( $d['zip'] ?? $_POST['req_zip'] ?? '' ) ?>"
          placeholder="例：730-0001" style="max-width:200px;">
          <?php if ( isset( $errors['zip'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['zip'] ) ?></p>
          <?php endif; ?>
        </div>
        
        <!-- 住所 -->
        <div class="contact-field <?= isset( $errors['address'] ) ? 'has-error' : '' ?>">
          <label for="req_address">ご住所 <span class="required">*</span></label>
          <input type="text" id="req_address" name="req_address"
          value="<?= esc_attr( $d['address'] ?? $_POST['req_address'] ?? '' ) ?>"
          placeholder="例：広島市東区曙5丁目4-6">
          <?php if ( isset( $errors['address'] ) ) : ?>
          <p class="field-error"><?= esc_html( $errors['address'] ) ?></p>
          <?php endif; ?>
        </div>
        
        <!-- ご興味のある工事 -->
        <div class="contact-field">
          <label for="req_interest">ご興味のある工事内容</label>
          <input type="text" id="req_interest" name="req_interest"
          value="<?= esc_attr( $d['interest'] ?? $_POST['req_interest'] ?? '' ) ?>"
          placeholder="例：外壁塗装・キッチンリフォームなど">
        </div>
        
        <!-- 備考 -->
        <div class="contact-field">
          <label for="req_note">備考・ご質問</label>
          <textarea id="req_note" name="req_note" rows="4"
          placeholder="ご自由にお書きください"><?= esc_textarea( $d['note'] ?? $_POST['req_note'] ?? '' ) ?></textarea>
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
        
        <!-- 資料 -->
        <div class="confirm-row">
          <dt>ご希望の資料</dt>
          <dd>
          <?php
          $selected_docs = (array)( $d['docs'] ?? [] );
          foreach ( $selected_docs as $key ) {
            if ( isset( $documents[$key] ) ) {
              echo esc_html( $documents[$key]['name'] ) . '<br>';
            }
          }
          ?>
          </dd>
        </div>
        
        <?php
        $rows = [
        'お名前'           => $d['name']     ?? '',
        'フリガナ'         => $d['kana']     ?? '',
        '電話番号'         => $d['tel']      ?? '',
        'メールアドレス'   => $d['email']    ?? '',
        '郵便番号'         => $d['zip']      ?? '',
        'ご住所'           => $d['address']  ?? '',
        'ご興味の工事内容' => $d['interest'] ?? '',
        '備考・ご質問'     => $d['note']     ?? '',
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
          <?php wp_nonce_field( 'miyuki_request_confirm' ); ?>
          <input type="hidden" name="action" value="back">
          <button type="submit" class="btn-contact-back">入力に戻る</button>
        </form>
        <form method="post" action="" style="display:inline;">
          <?php wp_nonce_field( 'miyuki_request_confirm' ); ?>
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
        <h2 class="mb-3">資料請求を受け付けました</h2>
        <p>このたびは資料請求いただき、誠にありがとうございます。<br>
          ご入力いただいたメールアドレス宛に確認メールをお送りしました。<br>
        資料は順次ご登録の住所へ郵送いたします。</p>
        <p class="mt-2 text-muted" style="font-size:.9em;">
          ※ 発送まで1週間程度お時間をいただく場合がございます。<br>
          ※ お急ぎの方はお電話でもお気軽にご連絡ください。
        </p>
        <a href="<?= esc_url( home_url( '/' ) ) ?>" class="btn-contact-back mt-4 d-inline-block">トップページへ戻る</a>
      </div>
      
      <?php endif; ?>
      
    </div>
  </div>
</div>

</main>

<?php get_footer(); ?>