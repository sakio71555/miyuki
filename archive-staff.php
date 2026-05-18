<?php get_header(); ?>
<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Staff</span>
    <span class="page-hero-ja">スタッフ紹介</span>
  </div>
</div>
<main>
<section class="section">
  <div class="container">
    <?php if (have_posts()) : ?>
    <div class="row g-4">
      <?php while (have_posts()) : the_post(); ?>
      <div class="col-lg-4 col-md-6">
        <div class="staff-card-new">
         <div class="staff-card-image">
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
          <div class="staff-card-body">
            <?php
            $position = get_post_meta(get_the_ID(), 'position', true);
            if ($position) : ?>
            <p class="staff-card-position"><?php echo esc_html($position); ?></p>
            <?php endif; ?>
            <h3 class="staff-card-name"><?php the_title(); ?></h3>
            <?php
            $career = get_post_meta(get_the_ID(), 'career', true);
            if ($career) : ?>
            <p class="staff-card-career"><?php echo esc_html($career); ?></p>
            <?php endif; ?>
            <?php
            $comment = get_post_meta(get_the_ID(), 'comment', true);
            if ($comment) : ?>
            <p class="staff-card-comment"><?php echo esc_html($comment); ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <?php else : ?>
    <p class="text-center py-5">スタッフ情報はまだありません。</p>
    <?php endif; ?>
  </div>
</section>
</main>
<?php get_footer(); ?>