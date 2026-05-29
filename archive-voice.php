<?php get_header(); ?>

<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Voice</span>
    <span class="page-hero-ja">お客様の声</span>
  </div>
</div>

<main>
  <section class="section voice-archive-section">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="voice-grid">
          <?php while (have_posts()) : the_post(); ?>
            <?php
            $post_id  = get_the_ID();
            $category = get_post_meta($post_id, 'customer_category', true);
            $name     = get_post_meta($post_id, 'customer_name', true);
            $area     = get_post_meta($post_id, 'customer_area', true);
            $quote    = get_post_meta($post_id, 'customer_quote', true);
            $excerpt  = $quote ?: get_the_excerpt();
            ?>
            <article class="voice-card">
              <a href="<?php the_permalink(); ?>" class="voice-card-image-link">
                <div class="voice-card-image">
                  <?php echo miyuki_render_voice_image($post_id, 'large', ['loading' => 'lazy']) ?: miyuki_voice_placeholder_image(get_the_title()); ?>
                </div>
              </a>
              <div class="voice-card-info">
                <?php if ($category) : ?>
                  <span class="voice-card-category"><?php echo esc_html($category); ?></span>
                <?php endif; ?>
                <h2 class="voice-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php if ($name || $area) : ?>
                  <p class="voice-card-name"><?php echo esc_html(trim(($name ?: '') . ($name && $area ? ' / ' : '') . ($area ?: ''))); ?></p>
                <?php endif; ?>
                <?php if ($excerpt) : ?>
                  <p class="voice-card-comment"><?php echo esc_html(mb_strimwidth(wp_strip_all_tags($excerpt), 0, 150, '…')); ?></p>
                <?php endif; ?>
                <a href="<?php the_permalink(); ?>" class="voice-read-more">詳しく見る</a>
              </div>
            </article>
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
