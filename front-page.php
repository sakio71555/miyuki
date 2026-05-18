<?php get_header(); ?>

<main>

  <!-- ============================================================
    ヒーロー
  ============================================================ -->
  <section class="hero">
    <div class="hero-background">
      <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/12.jpg" alt="モダンな住宅のインテリア">
      <div class="hero-overlay"></div>
    </div>
    <div class="container">
      <div class="hero-content">
        <h1 class="hero-title">QUALITY FOR<br>YOUR LIVING.</h1>
        <p class="hero-text">
          広島市東区を拠点に、建築工事・リフォームから清掃、メンテナンスまで。<br>
          住まいと建物の快適な状態を、地域に根ざした技術で支えます。
        </p>
        <div class="hero-buttons">
          <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-hero btn-hero-primary">
            無料相談はこちら
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
          <a href="<?php echo esc_url(home_url('/works')); ?>" class="btn-hero btn-hero-secondary">施工事例を見る</a>
        </div>
      </div>
    </div>
    <div class="scroll-indicator">
  <span class="scroll-text">scroll</span>
  <div class="scroll-line"></div>
  <svg class="scroll-arrow" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <polyline points="6 9 12 15 18 9"></polyline>
  </svg>
</div>
  </section>


  <!-- ============================================================
    お知らせ（ニュースティッカー + カード）
    news + event の投稿を統合表示
  ============================================================ -->
  <section class="news-section">
    <?php
    // ティッカー：最新1件を表示（news + event 統合）
    $ticker_query = new WP_Query([
      'post_type'      => ['news', 'event'],
      'posts_per_page' => 1,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ]);
    ?>
    <div class="news-ticker">
      <div class="news-ticker-content">
        <span class="news-label">INFORMATION</span>
        <?php if ($ticker_query->have_posts()) : $ticker_query->the_post(); ?>
          <span class="news-item">
            <?php echo get_the_date('Y.m.d'); ?>　
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </span>
        <?php else : ?>
          <span class="news-item">最新情報をお届けします</span>
        <?php endif; wp_reset_postdata(); ?>
      </div>
    </div>

    <?php
    // カード一覧：news + event 統合、日付降順
    $news_query = new WP_Query([
      'post_type'      => ['news', 'event'],
      'posts_per_page' => 12,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ]);
    ?>
    <div class="news-cards-wrapper">
      <button class="carousel-nav carousel-prev" aria-label="前へ">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </button>
      <div class="news-cards">
        <?php if ($news_query->have_posts()) : while ($news_query->have_posts()) : $news_query->the_post();
          $post_type = get_post_type();
          $event_type = ($post_type === 'event') ? get_post_meta(get_the_ID(), 'event_type', true) : '';
        ?>
          <a href="<?php the_permalink(); ?>" class="news-card">

            <?php if ($post_type === 'event' && $event_type) : ?>
              <div class="news-card-badge"><?php echo esc_html($event_type); ?></div>
            <?php elseif (get_post_meta(get_the_ID(), 'is_pickup', true)) : ?>
              <div class="news-card-badge">PICK UP!!</div>
            <?php endif; ?>

            <div class="news-card-image">
  <?php
  $thumb_url = has_post_thumbnail()
    ? get_the_post_thumbnail_url( get_the_ID(), 'medium' )
    : get_first_image_from_content( get_the_ID() );
  ?>
  <img src="<?= esc_url( $thumb_url ?: get_stylesheet_directory_uri() . '/assets/images/no-image.svg' ) ?>"
       alt="<?= esc_attr( get_the_title() ) ?>" loading="lazy">
</div>
            <h3 class="news-card-title"><?php the_title(); ?></h3>
            <p class="news-card-description">
              <?php echo wp_trim_words(get_the_excerpt(), 40, '…'); ?>
            </p>

          </a>
        <?php endwhile; wp_reset_postdata();
        else : ?>
          <p class="p-4">お知らせはまだありません。</p>
        <?php endif; ?>
      </div>
      <button class="carousel-nav carousel-next" aria-label="次へ">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </button>
      <div class="carousel-dots"></div>
    </div>
  </section>

  <!-- ============================================================
    サービス
  ============================================================ -->
  <section class="services section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">
          <span class="section-title-main">SERVICE</span>
          <span class="section-title-sub">サービス</span>
        </h2>
        <p class="section-subtitle">広島市周辺で、建築・リフォーム・清掃・メンテナンスを一貫して支えます</p>
      </div>

<div class="services-grid">
  <div class="service-card">
    <div class="service-image" style="background-image: url('https://images.pexels.com/photos/186077/pexels-photo-186077.jpeg?auto=compress&cs=tinysrgb&w=800');">
      <div class="service-overlay"></div>
      <div class="service-content">
        <span class="service-category">CONSTRUCTION</span>
        <h3 class="service-title">住宅・店舗の建築施工</h3>
      </div>
    </div>
    <p class="service-description">住宅や店舗の新築・改修を、設計から施工まで丁寧に対応。広島市周辺の建物づくりを支えます。</p>
  </div>
  <div class="service-card">
    <div class="service-image" style="background-image: url('https://images.pexels.com/photos/4108715/pexels-photo-4108715.jpeg?auto=compress&cs=tinysrgb&w=800');">
      <div class="service-overlay"></div>
      <div class="service-content">
        <span class="service-category">RENOVATION</span>
        <h3 class="service-title">リフォーム・改修工事</h3>
      </div>
    </div>
    <p class="service-description">住まいや店舗の使い勝手を整えるリフォーム・改修工事に対応。小さな修繕もご相談いただけます。</p>
  </div>
  <div class="service-card">
    <div class="service-image" style="background-image: url('https://images.pexels.com/photos/5691607/pexels-photo-5691607.jpeg?auto=compress&cs=tinysrgb&w=800');">
      <div class="service-overlay"></div>
      <div class="service-content">
        <span class="service-category">MAINTENANCE</span>
        <h3 class="service-title">メンテナンス業務</h3>
      </div>
    </div>
    <p class="service-description">建物清掃や定期メンテナンスで、美観と使いやすさを維持。修繕のご相談にも幅広く対応します。</p>
  </div>
</div>
		<div class="section-footer-center">
  <a href="<?php echo esc_url(home_url('/service')); ?>" class="btn-works">
    サービスをみる
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <polyline points="9 18 15 12 9 6"></polyline>
    </svg>
  </a>
</div>
    </div>
  </section>


 <!-- ============================================================
    施工事例（WORKSカルーセル）
  ============================================================ -->
  <section class="projects section section-alt">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">
          <span class="section-title-main">WORKS</span>
          <span class="section-title-sub">施工事例</span>
        </h2>
        <p class="section-subtitle">広島市周辺で手がけた建築工事・リフォーム・メンテナンスの実績をご紹介</p>
      </div>
      <?php
      $works_query = new WP_Query([
        'post_type'      => 'works',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC',
      ]);
      ?>
      <div class="projects-carousel-wrapper">
        <button class="carousel-nav carousel-prev" aria-label="前へ">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </button>
        <div class="projects-carousel">
          <?php if ($works_query->have_posts()) : while ($works_query->have_posts()) : $works_query->the_post(); ?>
            <div class="project-card">
              <a href="<?php the_permalink(); ?>" style="text-decoration:none; color:inherit;">
                <div class="project-image-wrapper">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', ['class' => 'project-image', 'loading' => 'lazy']); ?>
                  <?php else : ?>
                    <?php $first_img = get_first_image_from_content(get_the_ID()); ?>
                    <?php if ($first_img) : ?>
                      <img src="<?php echo esc_url($first_img); ?>"
                           alt="<?php the_title_attribute(); ?>"
                           class="project-image" loading="lazy">
                    <?php else : ?>
                      <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/no-image.svg"
                           alt="No Image" class="project-image" loading="lazy">
                    <?php endif; ?>
                  <?php endif; ?>
                  <?php
                  $cats = get_the_terms(get_the_ID(), 'works_category');
                  if ($cats && !is_wp_error($cats)) : ?>
                    <span class="works-card-category"><?php echo esc_html($cats[0]->name); ?></span>
                  <?php endif; ?>
                </div>
                <div class="project-info">
                  <h3 class="project-title"><?php the_title(); ?></h3>
                  <?php
$location = get_post_meta(get_the_ID(), 'location', true);
if ($location) : ?>
  <span class="works-card-location-tag"><?php echo esc_html($location); ?></span>
<?php endif; ?>
                </div>
              </a>
            </div>
          <?php endwhile; wp_reset_postdata();
          else : ?>
            <p class="p-4">施工事例はまだありません。</p>
          <?php endif; ?>
        </div>
        <button class="carousel-nav carousel-next" aria-label="次へ">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </button>
        <div class="projects-carousel-dots"></div>
      </div>
      <div class="section-footer-center">
        <a href="<?php echo esc_url(home_url('/works')); ?>" class="btn-works">
          施工事例をみる
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </a>
      </div>
    </div>
  </section>


  <!-- ============================================================
    Instagram
  ============================================================ -->
<section class="instagram section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">
        <span class="section-title-main">INSTAGRAM</span>
        <span class="section-title-sub">インスタグラム</span>
      </h2>
    </div>

    <?php $posts = get_instagram_posts(9); ?>
    <?php if (!empty($posts)) : ?>
    <div class="instagram-carousel-wrapper">
      <button class="carousel-nav carousel-prev" aria-label="前へ">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </button>
      <div class="instagram-carousel">
        <?php foreach ($posts as $post) : ?>
          <?php
            $image_url = $post['media_type'] === 'VIDEO'
              ? ($post['thumbnail_url'] ?? '')
              : ($post['media_url'] ?? '');
            if (empty($image_url)) continue;
          ?>
          <a class="instagram-card" href="<?php echo esc_url($post['permalink'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
  <div class="instagram-image">
    <img
      src="<?php echo esc_url($image_url); ?>"
      alt="Instagram投稿"
      loading="lazy"
      onerror="this.onerror=null;this.src='<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/no-image.svg';"
    >
  </div>
  <div class="instagram-content">
    <div class="instagram-header">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
      <span class="instagram-username">miyukihousing_official</span>
    </div>
    <?php if (!empty($post['caption'])) : ?>
    <p class="instagram-description"><?php echo esc_html(mb_substr($post['caption'], 0, 40)); ?>...</p>
    <?php endif; ?>
    <div class="instagram-footer">
      <div class="instagram-actions">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      </div>
      <span class="instagram-date"><?php echo date('Y.m.d', strtotime($post['timestamp'])); ?></span>
    </div>
  </div>
</a>
        <?php endforeach; ?>
      </div>
      <button class="carousel-nav carousel-next" aria-label="次へ">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </button>
      <div class="instagram-carousel-dots"></div>
    </div>
    <?php else : ?>
      <p style="text-align:center;">Instagramの投稿を読み込めませんでした。</p>
    <?php endif; ?>

    <div class="section-footer-center" style="margin-top: 2rem;">
      <a href="https://www.instagram.com/mim85119" target="_blank" rel="noopener noreferrer" class="btn-works">
        Instagramをフォロー
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </a>
    </div>
  </div>
</section>


<!-- ============================================================
    About
  ============================================================ -->
  <section class="about section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-md-6">
          <div class="about-title">
            <span class="section-title-main">ABOUT</span>
            <span class="section-title-sub">私たちについて</span>
          </div>
          <p class="about-description">
            広島市東区曙を拠点に、建築工事・リフォーム・清掃・メンテナンスを手がける建設会社です。地域の皆さまの大切な建物を、誠実な技術で支え続けます。
          </p>
          <a href="<?php echo esc_url(home_url('/concept')); ?>" class="btn-link mb-4 d-inline-flex">
            コンセプトを見る
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>

          <div class="about-flow">
            <div class="about-title">
              <span class="section-title-main">FLOW</span>
              <span class="section-title-sub">ご相談から施工までの流れ</span>
            </div>
            <p class="about-description">
              まずは無料でご相談・現地確認を行います。内容を伺ったうえで、建築・リフォーム・メンテナンスに合わせた進め方をご提案します。
            </p>
           <a href="<?php echo esc_url(home_url('/concept')); ?>#flow" class="btn-link d-inline-flex">
  詳しい流れはこちら
  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <line x1="5" y1="12" x2="19" y2="12"></line>
    <polyline points="12 5 19 12 12 19"></polyline>
  </svg>
</a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="about-image">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/about-01.jpg"
                 alt="代表写真または会社外観"
                 style="width:100%; height:100%; object-fit:cover; border-radius:1.5rem;">
          </div>
        </div>
      </div>
    </div>
  </section>

</main>




<?php get_footer(); ?>
