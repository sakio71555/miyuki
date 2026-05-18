<?php
/**
 * single-event.php
 * イベント情報 詳細ページ
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
$date     = get_post_meta( get_the_ID(), 'event_date', true );
$location = get_post_meta( get_the_ID(), 'event_location', true );
$type     = get_post_meta( get_the_ID(), 'event_type', true );
$capacity = get_post_meta( get_the_ID(), 'event_capacity', true );
$time     = get_post_meta( get_the_ID(), 'event_time', true );
$note     = get_post_meta( get_the_ID(), 'event_note', true );
$date_fmt = $date ? date('Y年n月j日', strtotime($date)) : '';
$today    = date('Ymd');
$is_past  = $date && $date < $today;
$no_image = get_template_directory_uri() . '/assets/images/no-image.svg';
$thumb_url = has_post_thumbnail()
  ? get_the_post_thumbnail_url( get_the_ID(), 'large' )
  : get_first_image_from_content( get_the_ID() );
?>
<main id="main" class="site-main event-single-page">
<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Event</span>
    <span class="page-hero-ja">イベント情報</span>
  </div>
</div>
<div class="container py-5">
  <div class="row">
    <div class="col-lg-8 mx-auto">

      <!-- パンくず -->
      <nav class="event-breadcrumb mb-4">
        <a href="<?= esc_url( home_url('/') ) ?>">HOME</a>
        <span>›</span>
        <a href="<?= esc_url( get_post_type_archive_link('event') ) ?>">イベント情報</a>
        <span>›</span>
        <span><?= esc_html( get_the_title() ) ?></span>
      </nav>

      <!-- 種別バッジ -->
      <?php if ( $type ) : ?>
      <p class="event-single-type">
        <span class="event-badge <?= $is_past ? 'event-badge--past' : '' ?>">
          <?= $is_past ? '終了' : esc_html( $type ) ?>
        </span>
        <?php if ( ! $is_past ) : ?>
        <span class="event-badge-name"><?= esc_html( $type ) ?></span>
        <?php endif; ?>
      </p>
      <?php endif; ?>

      <!-- タイトル -->
      <h1 class="event-single-title"><?= esc_html( get_the_title() ) ?></h1>

      <!-- アイキャッチ（本文1枚目 → no-image.svg にフォールバック） -->
      <div class="event-single-thumb mb-4">
        <img src="<?= esc_url( $thumb_url ?: $no_image ) ?>"
             alt="<?= esc_attr( get_the_title() ) ?>" loading="lazy">
      </div>

      <!-- イベント情報テーブル -->
      <div class="event-info-table mb-5">
        <?php if ( $date_fmt ) : ?>
        <div class="event-info-row">
          <dt>開催日</dt>
          <dd><?= esc_html( $date_fmt ) ?><?= $time ? '　' . esc_html( $time ) : '' ?></dd>
        </div>
        <?php endif; ?>
        <?php if ( $location ) : ?>
        <div class="event-info-row">
          <dt>開催場所</dt>
          <dd><?= esc_html( $location ) ?></dd>
        </div>
        <?php endif; ?>
        <?php if ( $capacity ) : ?>
        <div class="event-info-row">
          <dt>定員</dt>
          <dd><?= esc_html( $capacity ) ?></dd>
        </div>
        <?php endif; ?>
        <?php if ( $note ) : ?>
        <div class="event-info-row">
          <dt>備考</dt>
          <dd><?= nl2br( esc_html( $note ) ) ?></dd>
        </div>
        <?php endif; ?>
      </div>

      <!-- 本文 -->
      <div class="event-single-content">
        <?php the_content(); ?>
      </div>

      <!-- 申込みボタン（開催予定のみ表示） -->
      <?php if ( ! $is_past ) : ?>
      <div class="event-single-cta text-center mt-5">
        <p class="mb-3">このイベントへのお申し込みはお問い合わせフォームよりご連絡ください。</p>
        <a href="<?= esc_url( home_url('/contact') ) ?>?event=<?= get_the_ID() ?>"
          class="btn-contact-submit">
          このイベントに申し込む
        </a>
      </div>
      <?php endif; ?>

      <!-- 一覧に戻る -->
      <div class="text-center mt-5">
        <a href="<?= esc_url( get_post_type_archive_link('event') ) ?>" class="btn-contact-back">
          イベント一覧へ戻る
        </a>
      </div>

    </div>
  </div>
</div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>