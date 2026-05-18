<?php get_header(); ?>
<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Voice</span>
    <span class="page-hero-ja">お客様の声</span>
  </div>
</div>
<main>
  <section class="section">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="row g-4">
          <?php while (have_posts()) : the_post(); ?>
            <div class="col-lg-4 col-md-6">
              <div class="voice-card">
                <!-- 写真クリックで個別ページへ -->
                <a href="<?php the_permalink(); ?>" class="voice-card-image-link">
                  <div class="voice-card-image">
                    <?php if (has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail('large', ['loading' => 'lazy']); ?>
                    <?php else : ?>
                      <?php $first_img = get_first_image_from_content(get_the_ID()); ?>
                      <?php if ($first_img) : ?>
                        <img src="<?php echo esc_url($first_img); ?>"
                             alt="<?php the_title_attribute(); ?>" loading="lazy">
                      <?php else : ?>
                        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/no-image-staff.svg"
                             alt="No Image" loading="lazy">
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </a>
                <div class="works-card-info voice-card-info">
                  <?php
                  $category = get_post_meta(get_the_ID(), 'customer_category', true);
                  if ($category) : ?>
                    <span class="voice-card-category"><?php echo esc_html($category); ?></span>
                  <?php endif; ?>
                  <h3 class="works-card-title"><?php the_title(); ?></h3>
                  <?php
                  $name = get_post_meta(get_the_ID(), 'customer_name', true);
                  if ($name) : ?>
                    <p class="works-card-location"><?php echo esc_html($name); ?></p>
                  <?php endif; ?>
                  <?php
                  $excerpt = strip_tags(get_the_content());
                  if ($excerpt) : ?>
                    <p class="works-card-excerpt"><?php echo esc_html(mb_strimwidth($excerpt, 0, 150, '…')); ?></p>
                  <?php endif; ?>
                  <!-- 続きを見るリンク -->
                  <a href="<?php the_permalink(); ?>" class="voice-read-more">続きを見る &rarr;</a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
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
        <p class="text-center py-5">お客様の声はまだありません。</p>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php get_footer(); ?>