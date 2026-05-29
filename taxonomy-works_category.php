<?php get_header(); ?>
<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Works</span>
    <span class="page-hero-ja"><?php single_term_title(); ?></span>
  </div>
</div>
<main>
<section class="section">
  <div class="container">
    <!-- パンくずリスト -->
    <nav class="works-breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">TOP</a>
      <span>/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">施工事例</a>
      <span>/</span>
      <span><?php single_term_title(); ?></span>
    </nav>
	  <!-- 他のカテゴリーへのリンク -->
<?php
$all_cats = get_terms([
  'taxonomy'   => 'works_category',
  'hide_empty' => false,
]);
$all_cats = miyuki_sort_works_categories($all_cats);
$current_cat = get_queried_object();
?>
<?php if ($all_cats && !is_wp_error($all_cats)) : ?>
  <div class="filter-buttons">
    <a href="<?php echo esc_url(get_post_type_archive_link('works')); ?>"
       class="filter-button">すべて</a>
    <?php foreach ($all_cats as $cat) : ?>
      <a href="<?php echo esc_url(get_term_link($cat)); ?>"
         class="filter-button <?php echo ($cat->term_id === $current_cat->term_id) ? 'active' : ''; ?>">
        <?php echo esc_html($cat->name); ?>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
    <!-- 施工事例グリッド -->
    <?php if (have_posts()) : ?>
    <div class="row g-4">
      <?php while (have_posts()) : the_post(); ?>
      <?php
      $cats = get_the_terms(get_the_ID(), 'works_category');
      $cat_slug = ($cats && !is_wp_error($cats)) ? $cats[0]->slug : '';
      $works_image = miyuki_render_works_image(get_the_ID(), 'large', ['loading' => 'lazy']);
      ?>
      <div class="col-lg-4 col-md-6" data-category="<?php echo esc_attr($cat_slug); ?>">
        <a href="<?php the_permalink(); ?>" class="works-card">
          <div class="works-card-image">
            <?php if ($works_image) : ?>
            <?php echo $works_image; ?>
            <?php else : ?>
            <?php $first_img = get_first_image_from_content(get_the_ID()); ?>
            <?php if ($first_img) : ?>
            <img src="<?php echo esc_url($first_img); ?>"
            alt="<?php the_title_attribute(); ?>" loading="lazy">
            <?php else : ?>
            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/no-image.svg"
            alt="No Image" loading="lazy">
            <?php endif; ?>
            <?php endif; ?>
            <?php if ($cats && !is_wp_error($cats)) : ?>
            <span class="works-card-category"><?php echo esc_html($cats[0]->name); ?></span>
            <?php endif; ?>
          </div>
          <div class="works-card-info">
            <h3 class="works-card-title"><?php the_title(); ?></h3>
            <?php
            $location = get_post_meta(get_the_ID(), 'location', true);
            if ($location) : ?>
            <p class="works-card-location"><?php echo esc_html($location); ?></p>
            <?php endif; ?>
            <?php
            $excerpt = get_the_excerpt();
            if ($excerpt) : ?>
            <p class="works-card-excerpt"><?php echo esc_html(mb_strimwidth($excerpt, 0, 50, '…')); ?></p>
            <?php endif; ?>
          </div>
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
    <p class="text-center py-5">施工事例はまだありません。</p>
    <?php endif; ?>
  </div>
</section>
</main>
<?php get_footer(); ?>
