<?php
/**
 * Template Name: お問い合わせ
 *
 * 入力 → 確認 → 完了 の3ステップフォーム
 * セッション処理・送信ロジックは inc/contact-handler.php に分離
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once get_template_directory() . '/inc/contact-handler.php';

/* ---------------------------------------------------------------
 * POST 処理
 * ------------------------------------------------------------- */
$errors      = [];
$send_error  = '';
$step        = 'input'; // 'input' | 'confirm' | 'complete'

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

    /* ---- 入力 → 確認 ---- */
    if ( isset( $_POST['action'] ) && $_POST['action'] === 'confirm' ) {
        if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'miyuki_contact_input' ) ) {
            $errors['nonce'] = '不正なリクエストです。もう一度お試しください。';
            $step = 'input';
        } else {
            $result = miyuki_contact_validate_and_store();
            if ( $result['status'] === 'ok' ) {
                $step = 'confirm';
            } else {
                $errors = $result['errors'];
                $step   = 'input';
            }
        }
    }

    /* ---- 確認 → 送信 ---- */
    elseif ( isset( $_POST['action'] ) && $_POST['action'] === 'send' ) {
        if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'miyuki_contact_confirm' ) ) {
            $send_error = '不正なリクエストです。もう一度お試しください。';
            $step = 'confirm';
        } else {
            $result = miyuki_contact_send();
            if ( $result['status'] === 'ok' ) {
                $step = 'complete';
            } else {
                $send_error = $result['message'];
                $step = 'confirm';
            }
        }
    }

    /* ---- 確認 → 入力に戻る ---- */
    elseif ( isset( $_POST['action'] ) && $_POST['action'] === 'back' ) {
        $step = 'input';
    }

} // end POST

/* セッションから復元（確認画面表示用） */
$d       = $_SESSION['miyuki_contact'] ?? [];
$choices = miyuki_contact_choices();

/* ラベル変換ヘルパー */
$label = function( $group, $key ) use ( $choices ) {
    return $choices[$group][$key] ?? '';
};

get_header();
?>

<main id="main" class="site-main contact-page">

  <!-- ページタイトル -->
  <div class="page-hero">
    <div class="container d-flex justify-content-between align-items-center">
      <span class="page-hero-en">Contact</span>
      <span class="page-hero-ja">お問い合わせ</span>
    </div>
  </div>

  <div class="container py-5">

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
<div class="row">
	<div class="contact-lead mb-4 col-xl-7 col-lg-9 mx-auto">
        <p>お気軽にお問い合わせください。<br>
        担当者より2営業日以内にご連絡いたします。<br>
        <span class="text-danger">*</span> は必須項目です。</p>
      </div>
	  </div>
      

      <?php if ( ! empty( $errors ) ) : ?>
        <div class="alert alert-danger mb-4">
          <ul class="mb-0">
            <?php foreach ( $errors as $e ) echo '<li>' . esc_html( $e ) . '</li>'; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" action="" novalidate class="contact-form">
        <?php wp_nonce_field( 'miyuki_contact_input' ); ?>
        <input type="hidden" name="action" value="confirm">

        <!-- お名前 -->
        <div class="contact-field <?= isset( $errors['name'] ) ? 'has-error' : '' ?>">
          <label for="contact_name">お名前 <span class="required">*</span></label>
          <input type="text" id="contact_name" name="contact_name"
                 value="<?= esc_attr( $d['name'] ?? $_POST['contact_name'] ?? '' ) ?>"
                 placeholder="例：宮之浦 太郎" required>
          <?php if ( isset( $errors['name'] ) ) : ?>
            <p class="field-error"><?= esc_html( $errors['name'] ) ?></p>
          <?php endif; ?>
        </div>

        <!-- フリガナ -->
        <div class="contact-field">
          <label for="contact_kana">フリガナ</label>
          <input type="text" id="contact_kana" name="contact_kana"
                 value="<?= esc_attr( $d['kana'] ?? $_POST['contact_kana'] ?? '' ) ?>"
                 placeholder="例：ミヤノウラ タロウ">
        </div>

        <!-- 電話番号 -->
        <div class="contact-field">
          <label for="contact_tel">電話番号</label>
          <input type="tel" id="contact_tel" name="contact_tel"
                 value="<?= esc_attr( $d['tel'] ?? $_POST['contact_tel'] ?? '' ) ?>"
                 placeholder="例：082-123-4567">
        </div>

        <!-- メールアドレス -->
        <div class="contact-field <?= isset( $errors['email'] ) ? 'has-error' : '' ?>">
          <label for="contact_email">メールアドレス <span class="required">*</span></label>
          <input type="email" id="contact_email" name="contact_email"
                 value="<?= esc_attr( $d['email'] ?? $_POST['contact_email'] ?? '' ) ?>"
                 placeholder="例：info@example.com" required>
          <?php if ( isset( $errors['email'] ) ) : ?>
            <p class="field-error"><?= esc_html( $errors['email'] ) ?></p>
          <?php endif; ?>
        </div>

        <!-- 都道府県・市町村 -->
        <div class="contact-field">
          <label for="contact_address">都道府県・市町村</label>
          <input type="text" id="contact_address" name="contact_address"
                 value="<?= esc_attr( $d['address'] ?? $_POST['contact_address'] ?? '' ) ?>"
                 placeholder="例：広島県広島市">
        </div>

        <!-- お問い合わせ種別 -->
        <div class="contact-field">
          <label for="contact_inquiry_type">お問い合わせ種別</label>
          <select id="contact_inquiry_type" name="contact_inquiry_type">
            <?php foreach ( $choices['inquiry_type'] as $val => $text ) :
              $sel = ( ( $d['inquiry_type'] ?? $_POST['contact_inquiry_type'] ?? '' ) === $val ) ? 'selected' : ''; ?>
              <option value="<?= esc_attr( $val ) ?>" <?= $sel ?>><?= esc_html( $text ) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- 建物の種類 -->
        <div class="contact-field">
          <label for="contact_building_type">建物の種類</label>
          <select id="contact_building_type" name="contact_building_type">
            <?php foreach ( $choices['building_type'] as $val => $text ) :
              $sel = ( ( $d['building_type'] ?? $_POST['contact_building_type'] ?? '' ) === $val ) ? 'selected' : ''; ?>
              <option value="<?= esc_attr( $val ) ?>" <?= $sel ?>><?= esc_html( $text ) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- 築年数・建築年 -->
        <div class="contact-field">
          <label for="contact_age">築年数・建築年</label>
          <input type="text" id="contact_age" name="contact_age"
                 value="<?= esc_attr( $d['age'] ?? $_POST['contact_age'] ?? '' ) ?>"
                 placeholder="例：築20年 / 2004年築">
        </div>

        <!-- ご希望の工事時期 -->
        <div class="contact-field">
          <label for="contact_timing">ご希望の工事時期</label>
          <select id="contact_timing" name="contact_timing">
            <?php foreach ( $choices['timing'] as $val => $text ) :
              $sel = ( ( $d['timing'] ?? $_POST['contact_timing'] ?? '' ) === $val ) ? 'selected' : ''; ?>
              <option value="<?= esc_attr( $val ) ?>" <?= $sel ?>><?= esc_html( $text ) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- おおよその予算 -->
        <div class="contact-field">
          <label for="contact_budget">おおよその予算</label>
          <select id="contact_budget" name="contact_budget">
            <?php foreach ( $choices['budget'] as $val => $text ) :
              $sel = ( ( $d['budget'] ?? $_POST['contact_budget'] ?? '' ) === $val ) ? 'selected' : ''; ?>
              <option value="<?= esc_attr( $val ) ?>" <?= $sel ?>><?= esc_html( $text ) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- どこでお知りになりましたか -->
        <div class="contact-field">
          <label for="contact_referral">どこでお知りになりましたか</label>
          <select id="contact_referral" name="contact_referral">
            <?php foreach ( $choices['referral'] as $val => $text ) :
              $sel = ( ( $d['referral'] ?? $_POST['contact_referral'] ?? '' ) === $val ) ? 'selected' : ''; ?>
              <option value="<?= esc_attr( $val ) ?>" <?= $sel ?>><?= esc_html( $text ) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- お問い合わせ内容 -->
        <div class="contact-field">
          <label for="contact_message">お問い合わせ内容</label>
          <textarea id="contact_message" name="contact_message" rows="6"
                    placeholder="ご質問・ご要望などをご自由にお書きください"><?= esc_textarea( $d['message'] ?? $_POST['contact_message'] ?? '' ) ?></textarea>
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
        $confirm_rows = [
            'お名前'             => $d['name'] ?? '',
            'フリガナ'           => $d['kana'] ?? '',
            '電話番号'           => $d['tel']  ?? '',
            'メールアドレス'     => $d['email'] ?? '',
            'お問い合わせ種別'   => $label( 'inquiry_type', $d['inquiry_type'] ?? '' ),
            '都道府県・市町村'   => $d['address'] ?? '',
            '建物の種類'         => $label( 'building_type', $d['building_type'] ?? '' ),
            '築年数・建築年'     => $d['age'] ?? '',
            'ご希望の工事時期'   => $label( 'timing', $d['timing'] ?? '' ),
            'おおよその予算'     => $label( 'budget', $d['budget'] ?? '' ),
            'お知りになった経緯' => $label( 'referral', $d['referral'] ?? '' ),
        ];
        foreach ( $confirm_rows as $label_text => $value ) :
            if ( $value === '' ) continue; ?>
          <div class="confirm-row">
            <dt><?= esc_html( $label_text ) ?></dt>
            <dd><?= esc_html( $value ) ?: '—' ?></dd>
          </div>
        <?php endforeach; ?>
        <?php if ( ! empty( $d['message'] ) ) : ?>
          <div class="confirm-row">
            <dt>お問い合わせ内容</dt>
            <dd><?= nl2br( esc_html( $d['message'] ) ) ?></dd>
          </div>
        <?php endif; ?>
      </div>

      <div class="contact-confirm-actions">
        <form method="post" action="" style="display:inline;">
          <?php wp_nonce_field( 'miyuki_contact_confirm' ); ?>
          <input type="hidden" name="action" value="back">
          <button type="submit" class="btn-contact-back">入力に戻る</button>
        </form>
        <form method="post" action="" style="display:inline;">
          <?php wp_nonce_field( 'miyuki_contact_confirm' ); ?>
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
        <h2 class="mb-3">お問い合わせを受け付けました</h2>
        <p>このたびはお問い合わせいただき、誠にありがとうございます。<br>
        ご入力いただいたメールアドレス宛に確認メールをお送りしました。<br>
        担当者より2営業日以内にご連絡いたします。</p>
        <p class="mt-2 text-muted" style="font-size:.9em;">
          ※ メールが届かない場合は、迷惑メールフォルダもご確認ください。<br>
          ※ お急ぎの方はお電話でもお気軽にご連絡ください。
        </p>
        <a href="<?= esc_url( home_url( '/' ) ) ?>" class="btn-contact-back mt-4 d-inline-block">トップページへ戻る</a>
      </div>

    <?php endif; ?>

  </div><!-- /container -->
</main>

<?php get_footer(); ?>