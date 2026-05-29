<?php get_header(); ?>

<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Works</span>
    <span class="page-hero-ja">施工事例</span>
  </div>
</div>

<main>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <article class="section">
    <div class="container">
      <?php
      $post_id       = get_the_ID();
      $cats          = get_the_terms($post_id, 'works_category');
      $location      = get_post_meta($post_id, 'location', true);
      $lead          = get_post_meta($post_id, '_miyuki_works_lead', true);
      $main_image    = miyuki_render_works_image($post_id, 'full', ['loading' => 'eager']);
      $gallery_ids   = miyuki_get_works_gallery_ids($post_id);
      $has_content   = trim(strip_tags(get_the_content())) !== '';
      ?>

      <!-- パンくずリスト -->
      <nav class="works-breadcrumb">
  <a href="<?php echo esc_url(home_url('/')); ?>">TOP</a>
  <span>/</span>
  <a href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">施工事例</a>
</nav>

      <!-- メイン画像・タイトル・説明文 -->
      <div class="works-detail-visual<?php echo $main_image ? '' : ' works-detail-visual-no-image'; ?>">
        <?php if ($main_image) : ?>
          <div class="works-detail-main-image">
            <?php echo $main_image; ?>
          </div>
        <?php endif; ?>

        <div class="works-detail-intro">
          <p class="works-detail-en">WORKS</p>

          <?php if ($cats && !is_wp_error($cats)) : ?>
            <span class="works-meta-category"><?php echo esc_html($cats[0]->name); ?></span>
          <?php endif; ?>

          <h1 class="works-detail-title"><?php the_title(); ?></h1>

          <?php if ($location) : ?>
            <p class="works-detail-location"><?php echo esc_html($location); ?></p>
          <?php endif; ?>

          <?php if ($lead) : ?>
            <div class="works-detail-lead">
              <?php echo wpautop(esc_html($lead)); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- 本文 -->
      <?php if ($has_content) : ?>
        <div class="works-content">
          <?php the_content(); ?>
        </div>
      <?php endif; ?>

      <!-- ギャラリー -->
      <?php if (!empty($gallery_ids)) : ?>
        <div class="works-gallery-grid" aria-label="施工写真">
          <?php foreach ($gallery_ids as $gallery_id) : ?>
            <?php if (wp_attachment_is_image($gallery_id)) : ?>
              <figure class="works-gallery-item">
                <button type="button" class="works-gallery-trigger" data-full-src="<?php echo esc_url(wp_get_attachment_image_url($gallery_id, 'full')); ?>" data-alt="<?php echo esc_attr(get_post_meta($gallery_id, '_wp_attachment_image_alt', true) ?: get_the_title($gallery_id)); ?>">
                  <?php echo wp_get_attachment_image($gallery_id, 'large', false, ['loading' => 'lazy']); ?>
                </button>
              </figure>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <div class="voice-lightbox works-lightbox" role="dialog" aria-modal="true" aria-hidden="true">
          <button type="button" class="voice-lightbox-close" aria-label="閉じる">×</button>
          <div class="voice-lightbox-inner">
            <img src="" alt="">
          </div>
        </div>
      <?php endif; ?>

      <!-- 前後の投稿ナビ -->
      <div class="works-post-nav">
        <?php
        $prev = get_previous_post();
        $next = get_next_post();
        ?>
<div class="works-post-nav-prev">
  <?php if ($prev) : ?>
    <a href="<?php echo esc_url(get_permalink($prev)); ?>">
      <span class="nav-label">&#8592; PREV</span>
      <span class="nav-title nav-title-full"><?php echo esc_html($prev->post_title); ?></span>
      <span class="nav-title nav-title-short"><?php echo esc_html(mb_strimwidth($prev->post_title, 0, 15, '…')); ?></span>
    </a>
  <?php endif; ?>
</div>
<a href="<?php echo esc_url(get_post_type_archive_link('works')); ?>" class="works-post-nav-index">
  一覧へ戻る
</a>
<div class="works-post-nav-next">
  <?php if ($next) : ?>
    <a href="<?php echo esc_url(get_permalink($next)); ?>">
      <span class="nav-label">NEXT &#8594;</span>
      <span class="nav-title nav-title-full"><?php echo esc_html($next->post_title); ?></span>
      <span class="nav-title nav-title-short"><?php echo esc_html(mb_strimwidth($next->post_title, 0, 15, '…')); ?></span>
    </a>
  <?php endif; ?>
</div>
      </div>

    </div>
  </article>

  <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
