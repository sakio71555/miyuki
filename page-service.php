<?php
/* Template Name: サービス */
get_header(); ?>

<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Service</span>
    <span class="page-hero-ja">サービス</span>
  </div>
</div>

<main>

<!-- ① 住宅・店舗の建築施工 -->
<section class="service-section section" id="s-01">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/service-build.jpg"
        alt="住宅・店舗の建築施工" class="service-image" loading="lazy">
      </div>
      <div class="col-lg-6">
        <p class="service-number">01</p>
        <h2 class="service-title">住宅・店舗の<br>建築施工</h2>
        <p class="service-text">お客様のライフスタイルや事業内容を丁寧にヒアリングし、住まい・店舗づくりをサポートします。地元広島で培った確かな技術と誠実な施工で、長く安心して使える空間をご提供します。</p>
        <ul class="service-points">
          <li>完全注文住宅・店舗の新築施工</li>
          <li>お客様の予算に合わせた柔軟なプランニング</li>
          <li>アフターフォロー・定期点検も充実</li>
        </ul>
<a href="<?php echo esc_url(miyuki_works_category_link('construction')); ?>"
   class="btn-service">施工事例を見る &rarr;</a>
      </div>
    </div>
  </div>
</section>

<!-- ② リフォーム・改修工事 -->
<section class="service-section section section-alt" id="s-02">
  <div class="container">
    <div class="row align-items-center g-5 flex-lg-row-reverse">
      <div class="col-lg-6">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/service-clean.jpg"
        alt="リフォーム・改修工事" class="service-image" loading="lazy">
      </div>
      <div class="col-lg-6">
        <p class="service-number">02</p>
        <h2 class="service-title">リフォーム・<br>改修工事</h2>
        <p class="service-text">住まいの内装・外装、店舗や事務所の改修、水回りの修繕など、建物の状態と使い方に合わせてご提案します。小さな修繕からまとまった改修まで、広島市周辺で気軽にご相談いただけます。</p>
        <ul class="service-points">
          <li>住宅・店舗・事務所のリフォーム</li>
          <li>内装・外装・水回りの修繕相談</li>
          <li>使い勝手と予算に合わせた改修提案</li>
        </ul>
<a href="<?php echo esc_url(miyuki_works_category_link('renovation')); ?>"
   class="btn-service">施工事例を見る &rarr;</a>
      </div>
    </div>
  </div>
</section>

<!-- ③ メンテナンス業務 -->
<section class="service-section section" id="s-03">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/service-maintenance.jpg"
        alt="メンテナンス業務" class="service-image" loading="lazy">
      </div>
      <div class="col-lg-6">
        <p class="service-number">03</p>
        <h2 class="service-title">メンテナンス業務</h2>
        <p class="service-text">建物は定期的な清掃とメンテナンスが寿命を大きく左右します。外壁・屋根の点検や補修をはじめ、建物清掃や水回りのトラブル対応まで、コンディションを長期にわたって維持するお手伝いをいたします。</p>
        <ul class="service-points">
          <li>外壁・屋根の点検・補修・塗装</li>
          <li>建物清掃・クリーニング対応</li>
          <li>水回りのトラブルや定期点検のご提案</li>
        </ul>
<a href="<?php echo esc_url(miyuki_works_category_link('maintenance')); ?>"
   class="btn-service">施工事例を見る &rarr;</a>
      </div>
    </div>
  </div>
</section>

<!-- お問い合わせ導線 -->
<section class="service-cta section section-alt">
  <div class="container text-center">
    <h2 class="service-cta-title">まずはお気軽にご相談ください</h2>
    <p class="service-cta-text">広島市周辺の建築工事・リフォーム・メンテナンスはお気軽にご相談ください。<br>現地調査・お見積りは無料です。</p>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-contact-large">お問い合わせはこちら</a>
  </div>
</section>

</main>

<?php get_footer(); ?>
