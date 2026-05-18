<?php get_header(); ?>
<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">News</span>
    <span class="page-hero-ja">お知らせ</span>
  </div>
</div>
<main>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article class="section">
  <div class="container">
    <!-- パンくずリスト -->
    <nav class="works-breadcrumb">
  <a href="<?php echo esc_url(home_url('/')); ?>">TOP</a>
  <span>/</span>
  <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">お知らせ</a>
</nav>
    <!-- タイトル・メタ情報 -->
    <div class="works-meta">
      <p class="works-meta-date"><?php echo get_the_date('Y.m.d'); ?></p>
      <h1 class="works-detail-title"><?php the_title(); ?></h1>
    </div>
    <!-- アイキャッチ -->
    <?php if (has_post_thumbnail()) : ?>
    <div class="works-hero-image">
      <?php the_post_thumbnail('full', ['loading' => 'eager']); ?>
    </div>
    <?php endif; ?>
    <!-- 本文 -->
    <div class="works-content">
      <?php the_content(); ?>
    </div>
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
<a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>" class="works-post-nav-index">
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