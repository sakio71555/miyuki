<?php
// フォールバック（front-page.php / page.php が優先される）
get_header();
?>

<main>
  <div class="container section">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; endif; ?>
  </div>
</main>

<?php get_footer(); ?>
