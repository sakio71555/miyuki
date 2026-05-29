<?php get_header(); ?>
<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Works</span>
    <span class="page-hero-ja">施工事例</span>
  </div>
</div>
<main>
  <section class="section">
    <div class="container">
<!-- カテゴリーフィルター -->
<?php
$works_categories = get_terms([
  'taxonomy'   => 'works_category',
  'hide_empty' => true,
]);
$works_categories = miyuki_sort_works_categories($works_categories);
?>
<?php if (!empty($works_categories) && !is_wp_error($works_categories)) : ?>
  <div class="filter-buttons">
    <button type="button" class="filter-button active" data-filter="all">すべて</button>
    <?php foreach ($works_categories as $cat) : ?>
      <button type="button" class="filter-button" data-filter="<?php echo esc_attr($cat->slug); ?>">
        <?php echo esc_html($cat->name); ?>
      </button>
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
