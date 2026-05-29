<?php get_header(); ?>

<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Voice</span>
    <span class="page-hero-ja">お客様の声</span>
  </div>
</div>

<main>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php
  $post_id = get_the_ID();
  $category = get_post_meta($post_id, 'customer_category', true);
  $name = get_post_meta($post_id, 'customer_name', true);
  $area = get_post_meta($post_id, 'customer_area', true);
  $quote = get_post_meta($post_id, 'customer_quote', true);
  $related_work_id = absint(get_post_meta($post_id, '_miyuki_voice_related_work_id', true));
  $question_items = miyuki_get_voice_question_items($post_id);
  $has_questions = !empty($question_items);
  $gallery_ids = miyuki_get_voice_gallery_ids($post_id);
  $prev = get_previous_post();
  $next = get_next_post();
  ?>
  <article class="section voice-detail-section">
    <div class="container">
      <nav class="works-breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">TOP</a>
        <span>/</span>
        <a href="<?php echo esc_url(get_post_type_archive_link('voice')); ?>">お客様の声</a>
      </nav>

      <div class="voice-top-actions">
        <a href="<?php echo esc_url(get_post_type_archive_link('voice')); ?>">お客様の声一覧へ</a>
        <div>
          <?php if ($prev) : ?>
            <a href="<?php echo esc_url(get_permalink($prev)); ?>">前の記事へ</a>
          <?php endif; ?>
          <?php if ($next) : ?>
            <a href="<?php echo esc_url(get_permalink($next)); ?>">次の記事へ</a>
          <?php endif; ?>
        </div>
      </div>

      <header class="voice-detail-header">
        <?php if ($name || $area) : ?>
          <p class="voice-detail-meta"><?php echo esc_html(trim(($area ?: '') . ($area && $name ? '　' : '') . ($name ?: ''))); ?></p>
        <?php endif; ?>
        <h1 class="voice-detail-title"><?php the_title(); ?></h1>
      </header>

      <div class="voice-detail-image">
        <?php echo miyuki_render_voice_image($post_id, 'full', ['loading' => 'eager']) ?: miyuki_voice_placeholder_image(get_the_title()); ?>
      </div>

      <div class="voice-detail-body">
        <?php if ($quote) : ?>
          <p class="voice-detail-quote"><?php echo nl2br(esc_html($quote)); ?></p>
        <?php endif; ?>

        <?php if ($has_questions) : ?>
          <div class="voice-question-list">
            <?php foreach ($question_items as $item) : ?>
              <section class="voice-question-item <?php echo !empty($item['image_ids']) ? 'has-image' : ''; ?>">
                <div class="voice-question-body">
                  <h2><?php echo esc_html($item['label']); ?></h2>
                  <?php if ($item['answer']) : ?>
                    <p><?php echo nl2br(esc_html($item['answer'])); ?></p>
                  <?php endif; ?>
                </div>
                <?php if (!empty($item['image_ids'])) : ?>
                  <div class="voice-question-images">
                    <?php foreach ($item['image_ids'] as $question_image_id) : ?>
                      <?php if (wp_attachment_is_image($question_image_id)) : ?>
                        <div class="voice-question-image">
                          <?php echo wp_get_attachment_image($question_image_id, 'medium_large', false, ['loading' => 'lazy']); ?>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </section>
            <?php endforeach; ?>
          </div>
        <?php else : ?>
          <div class="works-content voice-content">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if (!empty($gallery_ids)) : ?>
        <section class="voice-gallery-section">
          <h2>Gallery</h2>
          <div class="voice-gallery-grid">
            <?php foreach ($gallery_ids as $gallery_id) : ?>
              <?php if (wp_attachment_is_image($gallery_id)) : ?>
                <button type="button" class="voice-gallery-item" data-full-src="<?php echo esc_url(wp_get_attachment_image_url($gallery_id, 'full')); ?>" data-alt="<?php echo esc_attr(get_post_meta($gallery_id, '_wp_attachment_image_alt', true) ?: get_the_title($gallery_id)); ?>">
                  <?php echo wp_get_attachment_image($gallery_id, 'large', false, ['loading' => 'lazy']); ?>
                </button>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </section>
        <div class="voice-lightbox" role="dialog" aria-modal="true" aria-hidden="true">
          <button type="button" class="voice-lightbox-close" aria-label="閉じる">×</button>
          <div class="voice-lightbox-inner">
            <img src="" alt="">
          </div>
        </div>
      <?php endif; ?>

      <?php if ($related_work_id && get_post_status($related_work_id) === 'publish') : ?>
        <div class="voice-related-work">
          <p>関連する施工事例</p>
          <a href="<?php echo esc_url(get_permalink($related_work_id)); ?>"><?php echo esc_html(get_the_title($related_work_id)); ?></a>
        </div>
      <?php endif; ?>

      <div class="works-post-nav">
        <div class="works-post-nav-prev">
          <?php if ($prev) : ?>
            <a href="<?php echo esc_url(get_permalink($prev)); ?>">
              <span class="nav-label">&#8592; PREV</span>
              <span class="nav-title nav-title-full"><?php echo esc_html($prev->post_title); ?></span>
              <span class="nav-title nav-title-short"><?php echo esc_html(mb_strimwidth($prev->post_title, 0, 18, '…')); ?></span>
            </a>
          <?php endif; ?>
        </div>
        <a href="<?php echo esc_url(get_post_type_archive_link('voice')); ?>" class="works-post-nav-index">一覧へ戻る</a>
        <div class="works-post-nav-next">
          <?php if ($next) : ?>
            <a href="<?php echo esc_url(get_permalink($next)); ?>">
              <span class="nav-label">NEXT &#8594;</span>
              <span class="nav-title nav-title-full"><?php echo esc_html($next->post_title); ?></span>
              <span class="nav-title nav-title-short"><?php echo esc_html(mb_strimwidth($next->post_title, 0, 18, '…')); ?></span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </article>
<?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
