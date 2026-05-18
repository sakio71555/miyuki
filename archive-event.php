<?php
/**
 * archive-event.php
 * イベント情報 一覧ページ
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="main" class="site-main event-archive-page">

<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Event</span>
    <span class="page-hero-ja">イベント情報</span>
  </div>
</div>

<div class="container py-5">

  <!-- タブ：開催予定 / 終了したイベント -->
  <div class="event-tabs mb-5">
    <button class="event-tab active" data-tab="upcoming">開催予定</button>
    <button class="event-tab" data-tab="past">終了したイベント</button>
  </div>

  <?php
  $today    = date('Ymd');
  $no_image = get_template_directory_uri() . '/assets/images/no-image.svg';

  /* ---- 開催予定 ---- */
  $upcoming = new WP_Query([
    'post_type'      => 'event',
    'posts_per_page' => 12,
    'meta_key'       => 'event_date',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'meta_query'     => [[
      'key'     => 'event_date',
      'value'   => $today,
      'compare' => '>=',
      'type'    => 'DATE',
    ]],
  ]);

  /* ---- 終了したイベント ---- */
  $past = new WP_Query([
    'post_type'      => 'event',
    'posts_per_page' => 12,
    'meta_key'       => 'event_date',
    'orderby'        => 'meta_value',
    'order'          => 'DESC',
    'meta_query'     => [[
      'key'     => 'event_date',
      'value'   => $today,
      'compare' => '<',
      'type'    => 'DATE',
    ]],
  ]);
  ?>

  <!-- 開催予定イベント -->
  <div class="event-tab-content" id="tab-upcoming">
    <?php if ( $upcoming->have_posts() ) : ?>
    <div class="event-grid">
      <?php while ( $upcoming->have_posts() ) : $upcoming->the_post();
        $date      = get_post_meta( get_the_ID(), 'event_date', true );
        $location  = get_post_meta( get_the_ID(), 'event_location', true );
        $type      = get_post_meta( get_the_ID(), 'event_type', true );
        $capacity  = get_post_meta( get_the_ID(), 'event_capacity', true );
        $date_fmt  = $date ? date('Y年n月j日', strtotime($date)) : '';
        $thumb_url = has_post_thumbnail()
          ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
          : get_first_image_from_content( get_the_ID() );
      ?>
      <article class="event-card">
        <a href="<?= esc_url( get_permalink() ) ?>" class="event-card-link">
          <div class="event-card-thumb">
            <img src="<?= esc_url( $thumb_url ?: $no_image ) ?>"
                 alt="<?= esc_attr( get_the_title() ) ?>" loading="lazy">
            <?php if ( $type ) : ?>
              <span class="event-badge"><?= esc_html( $type ) ?></span>
            <?php endif; ?>
          </div>
          <div class="event-card-body">
            <?php if ( $date_fmt ) : ?>
              <p class="event-card-date">📅 <?= esc_html( $date_fmt ) ?></p>
            <?php endif; ?>
            <h3 class="event-card-title"><?= esc_html( get_the_title() ) ?></h3>
            <?php if ( $location ) : ?>
              <p class="event-card-location">📍 <?= esc_html( $location ) ?></p>
            <?php endif; ?>
            <?php if ( $capacity ) : ?>
              <p class="event-card-capacity">定員：<?= esc_html( $capacity ) ?></p>
            <?php endif; ?>
            <span class="event-card-more">詳しく見る →</span>
          </div>
        </a>
      </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else : ?>
    <div class="event-empty">
      <p>現在、開催予定のイベントはありません。<br>新しいイベントが決まり次第、こちらでお知らせします。</p>
    </div>
    <?php endif; ?>
  </div>

  <!-- 終了したイベント -->
  <div class="event-tab-content" id="tab-past" style="display:none;">
    <?php if ( $past->have_posts() ) : ?>
    <div class="event-grid event-grid-past">
      <?php while ( $past->have_posts() ) : $past->the_post();
        $date      = get_post_meta( get_the_ID(), 'event_date', true );
        $location  = get_post_meta( get_the_ID(), 'event_location', true );
        $type      = get_post_meta( get_the_ID(), 'event_type', true );
        $date_fmt  = $date ? date('Y年n月j日', strtotime($date)) : '';
        $thumb_url = has_post_thumbnail()
          ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
          : get_first_image_from_content( get_the_ID() );
      ?>
      <article class="event-card event-card--past">
        <a href="<?= esc_url( get_permalink() ) ?>" class="event-card-link">
          <div class="event-card-thumb">
            <img src="<?= esc_url( $thumb_url ?: $no_image ) ?>"
                 alt="<?= esc_attr( get_the_title() ) ?>" loading="lazy">
            <span class="event-badge event-badge--past">終了</span>
          </div>
          <div class="event-card-body">
            <?php if ( $date_fmt ) : ?>
              <p class="event-card-date">📅 <?= esc_html( $date_fmt ) ?></p>
            <?php endif; ?>
            <h3 class="event-card-title"><?= esc_html( get_the_title() ) ?></h3>
            <?php if ( $location ) : ?>
              <p class="event-card-location">📍 <?= esc_html( $location ) ?></p>
            <?php endif; ?>
            <span class="event-card-more">レポートを見る →</span>
          </div>
        </a>
      </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else : ?>
    <div class="event-empty">
      <p>過去のイベントはまだありません。</p>
    </div>
    <?php endif; ?>
  </div>

</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.event-tab');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.event-tab-content').forEach(c => c.style.display = 'none');
            document.getElementById('tab-' + this.dataset.tab).style.display = 'block';
        });
    });
});
</script>

<?php get_footer(); ?>