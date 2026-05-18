<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="siteHeader">
  <nav class="navbar navbar-expand-lg py-3">
    <div class="container">

      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/02.png"
             alt="<?php bloginfo('name'); ?>"
             class="logo-image">
      </a>

      <button class="menu-toggle d-lg-none border-0 bg-transparent p-2"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#mainNav"
              aria-controls="mainNav"
              aria-expanded="false"
              aria-label="メニューを開く">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/concept')); ?>">コンセプト</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/concept#flow')); ?>">ご相談の流れ</a></li>
			<li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/service')); ?>">事業内容</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/works')); ?>">施工事例</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/staff')); ?>">スタッフ紹介</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/voice')); ?>">お客様の声</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/news')); ?>">お知らせ</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(home_url('/company')); ?>">会社概要</a></li>
          <li class="nav-item">
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-contact">お問い合わせ</a>
          </li>
        </ul>
      </div>

    </div>
  </nav>
</header>
