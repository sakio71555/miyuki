<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
$news_content = trim(get_the_content(null, false, get_the_ID()));
$news_excerpt = get_the_excerpt();
$no_image = get_template_directory_uri() . '/assets/images/no-image.svg';
$thumb_url = has_post_thumbnail()
  ? get_the_post_thumbnail_url(get_the_ID(), 'large')
  : (function_exists('get_first_image_from_content') ? get_first_image_from_content(get_the_ID()) : '');
?>
<main id="main" class="site-main event-single-page news-single-page">
  <!-- ページタイトル -->
  <div class="page-hero">
    <div class="container d-flex justify-content-between align-items-center">
      <span class="page-hero-en">News</span>
      <span class="page-hero-ja">お知らせ</span>
    </div>
  </div>

  <div class="container py-5">
    <div class="row">
      <div class="col-lg-8 mx-auto">

        <!-- パンくず -->
        <nav class="event-breadcrumb mb-4">
          <a href="<?php echo esc_url(home_url('/')); ?>">HOME</a>
          <span>›</span>
          <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">お知らせ</a>
          <span>›</span>
          <span><?php echo esc_html(get_the_title()); ?></span>
        </nav>

        <p class="news-single-date"><?php echo esc_html(get_the_date('Y.m.d')); ?></p>

        <!-- タイトル -->
        <h1 class="event-single-title"><?php echo esc_html(get_the_title()); ?></h1>

        <!-- アイキャッチ（本文1枚目 → no-image.svg にフォールバック） -->
        <div class="event-single-thumb mb-4">
          <img src="<?php echo esc_url($thumb_url ?: $no_image); ?>"
               alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
        </div>

        <!-- 本文 -->
        <?php if ($news_content !== '' || $news_excerpt !== '') : ?>
          <div class="event-single-content">
            <?php if ($news_content !== '') : ?>
              <?php the_content(); ?>
            <?php else : ?>
              <?php echo wpautop(esc_html($news_excerpt)); ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- 一覧に戻る -->
        <div class="text-center mt-5">
          <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>" class="btn-contact-back">
            お知らせ一覧へ戻る
          </a>
        </div>

      </div>
    </div>
  </div>
</main>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
