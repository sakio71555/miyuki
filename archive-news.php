<?php get_header(); ?>
<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">News</span>
    <span class="page-hero-ja">お知らせ</span>
  </div>
</div>
<main>
<section class="section">
  <div class="container">
    <!-- お知らせ一覧 -->
    <?php if (have_posts()) : ?>
    <div class="row g-4">
      <?php while (have_posts()) : the_post(); ?>
      <div class="col-12">
        <a href="<?php the_permalink(); ?>" class="news-list-item">
          <span class="news-list-date"><?php echo get_the_date('Y.m.d'); ?></span>
          <span class="news-list-title"><?php the_title(); ?></span>
        </a>
      </div>
      <?php endwhile; ?>
    </div>
    <!-- ページネーション -->
    <div class="works-pagination">
      <?php
      the_posts_pagination([
      'mid_size'  => 2,
      'prev_text' => '&laquo;',
      'next_text' => '&raquo;',
      ]);
      ?>
    </div>
    <?php else : ?>
    <p class="text-center py-5">お知らせはまだありません。</p>
    <?php endif; ?>
  </div>
</section>
</main>
<?php get_footer(); ?>