<?php
/**
 * Template Name: プライバシーポリシー
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="main" class="site-main privacy-page">

<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Privacy Policy</span>
    <span class="page-hero-ja">プライバシーポリシー</span>
  </div>
</div>

<div class="container py-5">
  <div class="row">
    <div class="col-xl-8 col-lg-9 mx-auto privacy-content">
      
      <p class="privacy-intro">有限会社ミユキハウジング（以下「当社」）は、お客様の個人情報の保護を重要な責務と考え、以下のとおりプライバシーポリシーを定めます。</p>
      
      <section class="privacy-section">
        <h2>1. 個人情報の定義</h2>
        <p>個人情報とは、氏名・住所・電話番号・メールアドレスその他の記述等により特定の個人を識別することができる情報をいいます。</p>
      </section>
      
      <section class="privacy-section">
        <h2>2. 個人情報の取得</h2>
        <p>当社は、以下の場合に個人情報を取得することがあります。</p>
        <ul>
          <li>お問い合わせフォームからのご連絡時</li>
          <li>来店予約・資料請求時</li>
          <li>イベント・見学会へのお申し込み時</li>
          <li>工事・施工のご契約時</li>
          <li>その他、当社サービスのご利用時</li>
        </ul>
      </section>
      
      <section class="privacy-section">
        <h2>3. 個人情報の利用目的</h2>
        <p>取得した個人情報は、以下の目的に限り利用します。</p>
        <ul>
          <li>お問い合わせ・ご相談へのご回答</li>
          <li>工事・施工に関するご連絡・ご提案</li>
          <li>来店予約・資料請求・イベント申込への対応</li>
          <li>アフターサポート・定期点検のご案内</li>
          <li>当社サービスに関するご案内・ニュースレターの送付</li>
          <li>法令に基づく対応</li>
        </ul>
      </section>
      
      <section class="privacy-section">
        <h2>4. 個人情報の第三者提供</h2>
        <p>当社は、以下の場合を除き、お客様の個人情報を第三者に提供・開示しません。</p>
        <ul>
          <li>お客様ご本人の同意がある場合</li>
          <li>法令に基づく開示が必要な場合</li>
          <li>人の生命・身体・財産の保護のために必要な場合</li>
        </ul>
      </section>
      
      <section class="privacy-section">
        <h2>5. 個人情報の管理</h2>
        <p>当社は、個人情報の正確性を保ち、不正アクセス・紛失・破壊・改ざん・漏洩等を防止するため、適切な安全管理措置を講じます。個人情報を取り扱う業務を外部に委託する場合は、委託先に対して適切な監督を行います。</p>
      </section>
      
      <section class="privacy-section">
        <h2>6. Cookie（クッキー）の使用について</h2>
        <p>当サイトでは、サービス向上およびアクセス解析のためにCookieを使用することがあります。Cookieによって個人を特定する情報を収集することはありません。ブラウザの設定によりCookieを無効にすることが可能ですが、一部のサービスが正常に動作しない場合があります。</p>
        <p>また、当サイトではGoogle Analyticsを利用しています。Google Analyticsはデータ収集のためにCookieを使用しており、収集されたデータはGoogleのプライバシーポリシーに基づいて管理されます。</p>
      </section>
      
      <section class="privacy-section">
        <h2>7. 個人情報の開示・訂正・削除</h2>
        <p>お客様は、当社が保有するご自身の個人情報について、開示・訂正・削除・利用停止をご請求いただくことができます。ご請求の際は、下記お問い合わせ窓口までご連絡ください。本人確認のうえ、速やかに対応いたします。</p>
      </section>
      
      <section class="privacy-section">
        <h2>8. プライバシーポリシーの変更</h2>
        <p>当社は、必要に応じて本ポリシーを変更することがあります。変更後のプライバシーポリシーは、本ページに掲載した時点から効力を生じるものとします。</p>
      </section>
      
      <section class="privacy-section">
        <h2>9. お問い合わせ窓口</h2>
        <p>個人情報の取り扱いに関するご質問・ご相談は、下記までお問い合わせください。</p>
        <div class="privacy-contact-box">
          <p>
            <strong>有限会社ミユキハウジング</strong><br>
            〒732-0045 広島市東区曙5丁目4-6<br>
            TEL：<a href="tel:0822638066">082-263-8066</a><br>
            メール：<?php echo miyuki_obfuscated_email_link(); ?><br>
            受付時間：平日 8:30〜18:00
          </p>
        </div>
      </section>
      
      <p class="privacy-date">制定日：<?php echo date('Y年n月j日'); ?></p>
      
      <div class="privacy-back text-center mt-5">
        <a href="<?= esc_url( home_url( '/' ) ) ?>" class="btn-contact-back">トップページへ戻る</a>
      </div>
      
    </div>
  </div>
</div>

</main>

<?php get_footer(); ?>
