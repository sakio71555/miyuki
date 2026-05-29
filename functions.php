<?php
/**
 * Miyuki Housing - functions.php
 */

/* ============================================================
   スクリプト・スタイルの読み込み
   ============================================================ */
function miyuki_enqueue_assets() {
  wp_enqueue_style(
    'google-fonts',
    'https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&family=Montserrat:wght@600;700&display=swap',
    [],
    null
  );
  wp_enqueue_style(
    'bootstrap',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    [],
    '5.3.3'
  );
  wp_enqueue_style(
    'miyuki-style',
    get_stylesheet_directory_uri() . '/assets/css/style.css',
    ['bootstrap'],
    filemtime(get_stylesheet_directory() . '/assets/css/style.css')
  );
  wp_enqueue_script(
    'bootstrap',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
    [],
    '5.3.3',
    true
  );
  wp_enqueue_script(
    'miyuki-script',
    get_stylesheet_directory_uri() . '/assets/js/script.js',
    ['bootstrap'],
    filemtime(get_stylesheet_directory() . '/assets/js/script.js'),
    true
  );
}
add_action('wp_enqueue_scripts', 'miyuki_enqueue_assets');


/* ============================================================
   テーマサポート
   ============================================================ */
function miyuki_theme_setup() {
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
  add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption']);
}
add_action('after_setup_theme', 'miyuki_theme_setup');

/* ============================================================
   SEO基本設定
   ============================================================ */
function miyuki_site_brand() {
  return '有限会社ミユキハウジング';
}

function miyuki_contact_email_encoded() {
  return [
    'user' => 'bV9tZW50ZW5hbnN1Lmk=',
    'domain' => 'aGVsZW4ub2NuLm5lLmpw',
  ];
}

function miyuki_obfuscated_email_link($label = 'メールアドレスを表示') {
  $email = miyuki_contact_email_encoded();

  return sprintf(
    '<a href="#" class="miyuki-email-link" data-user="%s" data-domain="%s" rel="nofollow">%s</a>',
    esc_attr($email['user']),
    esc_attr($email['domain']),
    esc_html($label)
  );
}

function miyuki_default_description() {
  return '広島市東区曙の有限会社ミユキハウジング。建築工事、住宅・店舗のリフォーム、建物清掃、メンテナンスまで暮らしと建物を支えます。';
}

function miyuki_is_yoast_active() {
  return defined('WPSEO_VERSION') || class_exists('WPSEO_Options');
}

function miyuki_google_site_verification_code() {
  return 'bx8pva5jx_WLYV6iImnVjJMrXiddVPc9OXPa6Zr0AWM';
}

add_action('wp_head', function() {
  if (is_admin()) {
    return;
  }

  echo "\n" . '<meta name="google-site-verification" content="' . esc_attr(miyuki_google_site_verification_code()) . '">' . "\n";
}, 1);

function miyuki_schema_logo_url() {
  return get_stylesheet_directory_uri() . '/assets/images/02.png';
}

add_filter('get_site_icon_url', function($url, $size, $blog_id) {
  return miyuki_schema_logo_url();
}, 10, 3);

function miyuki_seo_page_map() {
  return [
    'concept' => [
      'title' => '選ばれる理由｜広島市東区で相談しやすい建築会社',
      'description' => '広島市東区の有限会社ミユキハウジングが大切にしている考え方。建築、リフォーム、メンテナンスを地域密着で相談しやすく進めます。',
    ],
    'service' => [
      'title' => 'サービス｜広島市の建築・リフォーム・建物メンテナンス',
      'description' => '有限会社ミユキハウジングのサービス案内。広島市で住宅・店舗の建築施工、リフォーム、建物清掃、メンテナンスをご相談いただけます。',
    ],
    'company' => [
      'title' => '会社概要｜有限会社ミユキハウジング 広島市東区',
      'description' => '有限会社ミユキハウジングの会社概要。広島市東区曙5丁目4-6を拠点に、建築工事、リフォーム、建物メンテナンスに対応しています。',
    ],
    'contact' => [
      'title' => 'お問い合わせ｜広島市の建築・リフォーム相談',
      'description' => '広島市で建築工事、リフォーム、建物清掃、メンテナンスをご検討中の方は有限会社ミユキハウジングへお気軽にご相談ください。',
    ],
    'request' => [
      'title' => '資料請求｜有限会社ミユキハウジング',
      'description' => '有限会社ミユキハウジングの資料請求ページです。広島市での建築、リフォーム、建物メンテナンスのご相談前にご活用ください。',
    ],
    'visit' => [
      'title' => '相談予約｜広島市東区の建築・リフォーム相談',
      'description' => '広島市東区の有限会社ミユキハウジングへの相談予約ページです。建築工事、リフォーム、メンテナンスをお気軽にご相談ください。',
    ],
    'privacy' => [
      'title' => 'プライバシーポリシー｜有限会社ミユキハウジング',
      'description' => '有限会社ミユキハウジングのプライバシーポリシーです。お問い合わせや資料請求で取得する個人情報の取り扱いについて掲載しています。',
    ],
  ];
}

function miyuki_seo_archive_map() {
  return [
    'works' => [
      'title' => '施工事例｜広島市の建築・リフォーム実績',
      'description' => '広島市周辺で有限会社ミユキハウジングが手がけた建築工事、リフォーム、清掃、メンテナンスの施工事例をご紹介します。',
    ],
    'news' => [
      'title' => 'お知らせ｜有限会社ミユキハウジング',
      'description' => '有限会社ミユキハウジングからのお知らせ。広島市での建築、リフォーム、建物メンテナンスに関する情報を掲載します。',
    ],
    'event' => [
      'title' => 'イベント情報｜広島市の建築・リフォーム相談会',
      'description' => '有限会社ミユキハウジングのイベント情報。広島市での建築、リフォーム、メンテナンスに関する相談会や見学情報を掲載します。',
    ],
    'staff' => [
      'title' => 'スタッフ紹介｜有限会社ミユキハウジング',
      'description' => '広島市東区の有限会社ミユキハウジングで建築、リフォーム、メンテナンスに関わるスタッフをご紹介します。',
    ],
    'voice' => [
      'title' => 'お客様の声｜広島市の建築・リフォーム相談',
      'description' => '有限会社ミユキハウジングへ建築工事、リフォーム、メンテナンスをご相談いただいたお客様の声をご紹介します。',
    ],
  ];
}

function miyuki_current_seo_data() {
  $brand = miyuki_site_brand();
  $data = [
    'title' => $brand,
    'description' => miyuki_default_description(),
    'type' => 'website',
  ];

  if (is_front_page() || is_home()) {
    $data['title'] = '有限会社ミユキハウジング｜広島市東区の建築・リフォーム';
    return $data;
  }

  if (is_page()) {
    $slug = get_post_field('post_name', get_queried_object_id());
    $page_map = miyuki_seo_page_map();
    if (isset($page_map[$slug])) {
      return array_merge($data, $page_map[$slug], ['type' => 'article']);
    }
  }

  if (is_post_type_archive()) {
    $post_type = get_query_var('post_type');
    if (is_array($post_type)) {
      $post_type = reset($post_type);
    }
    $archive_map = miyuki_seo_archive_map();
    if (isset($archive_map[$post_type])) {
      return array_merge($data, $archive_map[$post_type], ['type' => 'website']);
    }
  }

  if (is_tax('works_category')) {
    $term = get_queried_object();
    if ($term && !is_wp_error($term)) {
      $data['title'] = sprintf('%sの施工事例｜広島市の建築・リフォーム実績', $term->name);
      $data['description'] = sprintf('広島市周辺で有限会社ミユキハウジングが手がけた%sの施工事例をご紹介します。', $term->name);
      $data['type'] = 'website';
    }
    return $data;
  }

  if (is_singular()) {
    $title = single_post_title('', false);
    $post_type = get_post_type();
    $data['title'] = $title . '｜' . $brand;
    $data['type'] = 'article';

    if (has_excerpt()) {
      $data['description'] = wp_strip_all_tags(get_the_excerpt());
    } elseif ($post_type === 'works') {
      $data['description'] = $title . 'の施工事例です。広島市周辺での建築工事、リフォーム、清掃、メンテナンスは有限会社ミユキハウジングへご相談ください。';
    } elseif ($post_type === 'news') {
      $data['description'] = $title . '。有限会社ミユキハウジングからのお知らせです。';
    }
    return $data;
  }

  if (is_404()) {
    $data['title'] = 'ページが見つかりません｜' . $brand;
    $data['description'] = 'お探しのページは見つかりませんでした。有限会社ミユキハウジングのトップページまたはお問い合わせページをご確認ください。';
  }

  return $data;
}

add_filter('pre_get_document_title', function() {
  if (is_admin() || miyuki_is_yoast_active()) {
    return null;
  }
  $seo = miyuki_current_seo_data();
  return $seo['title'];
});

add_action('wp_head', function() {
  if (is_admin() || miyuki_is_yoast_active()) {
    return;
  }

  $seo = miyuki_current_seo_data();
  $canonical = miyuki_canonical_url();
  $image = get_stylesheet_directory_uri() . '/assets/images/12.jpg';

  echo "\n" . '<meta name="description" content="' . esc_attr($seo['description']) . '">' . "\n";
  echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
  echo '<meta property="og:locale" content="ja_JP">' . "\n";
  echo '<meta property="og:type" content="' . esc_attr($seo['type']) . '">' . "\n";
  echo '<meta property="og:title" content="' . esc_attr($seo['title']) . '">' . "\n";
  echo '<meta property="og:description" content="' . esc_attr($seo['description']) . '">' . "\n";
  echo '<meta property="og:url" content="' . esc_url($canonical) . '">' . "\n";
  echo '<meta property="og:site_name" content="' . esc_attr(miyuki_site_brand()) . '">' . "\n";
  echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
  echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}, 1);

remove_action('wp_head', 'rel_canonical');

function miyuki_canonical_url() {
  if (is_front_page() || is_home()) {
    return home_url('/');
  }

  if (is_singular()) {
    return get_permalink();
  }

  if (is_post_type_archive()) {
    $post_type = get_query_var('post_type');
    if (is_array($post_type)) {
      $post_type = reset($post_type);
    }
    $archive_link = get_post_type_archive_link($post_type);
    return $archive_link ?: home_url('/');
  }

  if (is_tax() || is_category() || is_tag()) {
    $term = get_queried_object();
    if ($term && !is_wp_error($term)) {
      $term_link = get_term_link($term);
      return is_wp_error($term_link) ? home_url('/') : $term_link;
    }
  }

  if (is_404()) {
    return home_url('/');
  }

  return get_pagenum_link();
}

function miyuki_breadcrumb_items() {
  $items = [
    [
      '@type' => 'ListItem',
      'position' => 1,
      'name' => 'ホーム',
      'item' => home_url('/'),
    ],
  ];

  if (is_front_page() || is_home()) {
    return $items;
  }

  if (is_singular()) {
    $post_type = get_post_type();
    if ($post_type && $post_type !== 'page' && $post_type !== 'post') {
      $object = get_post_type_object($post_type);
      $archive_link = get_post_type_archive_link($post_type);
      if ($object && $archive_link) {
        $items[] = [
          '@type' => 'ListItem',
          'position' => count($items) + 1,
          'name' => $object->labels->name,
          'item' => $archive_link,
        ];
      }
    }
    $items[] = [
      '@type' => 'ListItem',
      'position' => count($items) + 1,
      'name' => single_post_title('', false),
      'item' => get_permalink(),
    ];
    return $items;
  }

  if (is_post_type_archive()) {
    $post_type = get_query_var('post_type');
    if (is_array($post_type)) {
      $post_type = reset($post_type);
    }
    $object = get_post_type_object($post_type);
    $items[] = [
      '@type' => 'ListItem',
      'position' => count($items) + 1,
      'name' => $object ? $object->labels->name : wp_get_document_title(),
      'item' => miyuki_canonical_url(),
    ];
    return $items;
  }

  if (is_tax('works_category')) {
    $term = get_queried_object();
    $items[] = [
      '@type' => 'ListItem',
      'position' => count($items) + 1,
      'name' => '施工事例',
      'item' => get_post_type_archive_link('works'),
    ];
    $items[] = [
      '@type' => 'ListItem',
      'position' => count($items) + 1,
      'name' => $term->name,
      'item' => miyuki_canonical_url(),
    ];
    return $items;
  }

  if (is_page()) {
    $items[] = [
      '@type' => 'ListItem',
      'position' => count($items) + 1,
      'name' => get_the_title(),
      'item' => get_permalink(),
    ];
  }

  return $items;
}

add_action('wp_head', function() {
  if (is_admin() || miyuki_is_yoast_active()) {
    return;
  }

  $schemas = [];

  if (is_front_page() || is_home()) {
    $schemas[] = [
      '@context' => 'https://schema.org',
      '@type' => ['LocalBusiness', 'HomeAndConstructionBusiness'],
      '@id' => home_url('/#localbusiness'),
      'name' => miyuki_site_brand(),
      'url' => home_url('/'),
      'telephone' => '082-263-8066',
      'description' => miyuki_default_description(),
      'image' => get_stylesheet_directory_uri() . '/assets/images/12.jpg',
      'address' => [
        '@type' => 'PostalAddress',
        'postalCode' => '732-0045',
        'addressRegion' => '広島県',
        'addressLocality' => '広島市東区',
        'streetAddress' => '曙5丁目4-6',
        'addressCountry' => 'JP',
      ],
      'areaServed' => [
        [
          '@type' => 'City',
          'name' => '広島市',
        ],
        [
          '@type' => 'AdministrativeArea',
          'name' => '広島県',
        ],
      ],
      'knowsAbout' => ['建築工事', 'リフォーム', '建物清掃', '建物メンテナンス'],
    ];

    $schemas[] = [
      '@context' => 'https://schema.org',
      '@type' => 'WebSite',
      '@id' => home_url('/#website'),
      'name' => miyuki_site_brand(),
      'url' => home_url('/'),
      'inLanguage' => 'ja',
    ];
  }

  $schemas[] = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => miyuki_breadcrumb_items(),
  ];

  foreach ($schemas as $schema) {
    echo "\n" . '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
  }
}, 20);

add_filter('wpseo_title', function($title) {
  if (is_admin()) {
    return $title;
  }
  $seo = miyuki_current_seo_data();
  return $seo['title'];
});

add_filter('wpseo_metadesc', function($description) {
  if (is_admin()) {
    return $description;
  }
  $seo = miyuki_current_seo_data();
  return $seo['description'];
});

add_filter('wpseo_canonical', function($canonical) {
  if (is_admin()) {
    return $canonical;
  }
  return miyuki_canonical_url();
});

add_filter('wpseo_opengraph_title', function($title) {
  if (is_admin()) {
    return $title;
  }
  $seo = miyuki_current_seo_data();
  return $seo['title'];
});

add_filter('wpseo_opengraph_desc', function($description) {
  if (is_admin()) {
    return $description;
  }
  $seo = miyuki_current_seo_data();
  return $seo['description'];
});

add_filter('wpseo_twitter_title', function($title) {
  if (is_admin()) {
    return $title;
  }
  $seo = miyuki_current_seo_data();
  return $seo['title'];
});

add_filter('wpseo_twitter_description', function($description) {
  if (is_admin()) {
    return $description;
  }
  $seo = miyuki_current_seo_data();
  return $seo['description'];
});

add_filter('wpseo_schema_graph', function($graph, $context) {
  if (is_admin() || !(is_front_page() || is_home())) {
    return $graph;
  }

  $logo_url = miyuki_schema_logo_url();

  foreach ($graph as &$schema) {
    if (($schema['@type'] ?? '') !== 'Organization') {
      continue;
    }

    $schema['name'] = miyuki_site_brand();
    $schema['url'] = home_url('/');
    $schema['logo'] = [
      '@type' => 'ImageObject',
      '@id' => home_url('/#/schema/logo/image/'),
      'url' => $logo_url,
      'contentUrl' => $logo_url,
      'width' => 334,
      'height' => 374,
      'caption' => miyuki_site_brand(),
      'inLanguage' => 'ja',
    ];
    $schema['image'] = [
      '@id' => home_url('/#/schema/logo/image/'),
    ];
  }
  unset($schema);

  $graph[] = [
    '@type' => ['LocalBusiness', 'HomeAndConstructionBusiness'],
    '@id' => home_url('/#localbusiness'),
    'name' => miyuki_site_brand(),
    'url' => home_url('/'),
    'telephone' => '082-263-8066',
    'description' => miyuki_default_description(),
    'image' => get_stylesheet_directory_uri() . '/assets/images/12.jpg',
    'address' => [
      '@type' => 'PostalAddress',
      'postalCode' => '732-0045',
      'addressRegion' => '広島県',
      'addressLocality' => '広島市東区',
      'streetAddress' => '曙5丁目4-6',
      'addressCountry' => 'JP',
    ],
    'areaServed' => [
      [
        '@type' => 'City',
        'name' => '広島市',
      ],
      [
        '@type' => 'AdministrativeArea',
        'name' => '広島県',
      ],
    ],
    'knowsAbout' => ['建築工事', 'リフォーム', '建物清掃', '建物メンテナンス'],
  ];

  return $graph;
}, 10, 2);


/* ============================================================
   カスタム投稿タイプの登録
   ============================================================ */
function miyuki_register_post_types() {

  // お知らせ
  register_post_type('news', [
    'labels' => [
      'name'               => 'お知らせ',
      'singular_name'      => 'お知らせ',
      'add_new'            => '新規追加',
      'add_new_item'       => 'お知らせを追加',
      'edit_item'          => 'お知らせを編集',
      'new_item'           => '新規お知らせ',
      'view_item'          => 'お知らせを表示',
      'not_found'          => 'お知らせが見つかりません',
      'not_found_in_trash' => 'ゴミ箱にお知らせはありません',
    ],
    'public'        => true,
    'has_archive'   => true,
    'menu_icon'     => 'dashicons-megaphone',
    'menu_position' => 4,
    'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
    'rewrite'       => ['slug' => 'news'],
    'show_in_rest'  => true,
  ]);

  // 施工事例
  register_post_type('works', [
    'labels' => [
      'name'               => '施工事例',
      'singular_name'      => '施工事例',
      'add_new'            => '新規追加',
      'add_new_item'       => '施工事例を追加',
      'edit_item'          => '施工事例を編集',
      'new_item'           => '新規施工事例',
      'view_item'          => '施工事例を表示',
      'search_items'       => '施工事例を検索',
      'not_found'          => '施工事例が見つかりません',
      'not_found_in_trash' => 'ゴミ箱に施工事例はありません',
    ],
    'public'        => true,
    'has_archive'   => true,
    'menu_icon'     => 'dashicons-building',
    'menu_position' => 5,
    'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    'rewrite'       => ['slug' => 'works'],
    'show_in_rest'  => true,
  ]);

  // スタッフ紹介
  register_post_type('staff', [
    'labels' => [
      'name'               => 'スタッフ紹介',
      'singular_name'      => 'スタッフ',
      'add_new'            => '新規追加',
      'add_new_item'       => 'スタッフを追加',
      'edit_item'          => 'スタッフを編集',
      'new_item'           => '新規スタッフ',
      'view_item'          => 'スタッフを表示',
      'search_items'       => 'スタッフを検索',
      'not_found'          => 'スタッフが見つかりません',
      'not_found_in_trash' => 'ゴミ箱にスタッフはありません',
    ],
    'public'        => true,
    'has_archive'   => true,
    'menu_icon'     => 'dashicons-groups',
    'menu_position' => 6,
    'supports'      => ['title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'],
    'rewrite'       => ['slug' => 'staff'],
    'show_in_rest'  => true,
  ]);

  // イベント情報
  register_post_type('event', [
    'labels' => [
      'name'               => 'イベント情報',
      'singular_name'      => 'イベント',
      'add_new'            => '新規追加',
      'add_new_item'       => 'イベントを追加',
      'edit_item'          => 'イベントを編集',
      'new_item'           => '新規イベント',
      'view_item'          => 'イベントを表示',
      'search_items'       => 'イベントを検索',
      'not_found'          => 'イベントが見つかりません',
      'not_found_in_trash' => 'ゴミ箱にイベントはありません',
    ],
    'public'        => true,
    'has_archive'   => true,
    'menu_icon'     => 'dashicons-calendar-alt',
    'menu_position' => 7,
    'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
    'rewrite'       => ['slug' => 'event'],
    'show_in_rest'  => true,
  ]);

  // お客様の声
  register_post_type('voice', [
    'labels' => [
      'name'               => 'お客様の声',
      'singular_name'      => 'お客様の声',
      'add_new'            => '新規追加',
      'add_new_item'       => 'お客様の声を追加',
      'edit_item'          => 'お客様の声を編集',
      'new_item'           => '新規お客様の声',
      'view_item'          => 'お客様の声を表示',
      'not_found'          => 'お客様の声が見つかりません',
      'not_found_in_trash' => 'ゴミ箱にお客様の声はありません',
    ],
    'public'        => true,
    'has_archive'   => true,
    'menu_icon'     => 'dashicons-format-quote',
    'menu_position' => 8,
    'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'],
    'rewrite'       => ['slug' => 'voice'],
    'show_in_rest'  => true,
  ]);

  // お客様アンケート（公開ページには出さず、管理画面専用で扱う）
  register_post_type('voice_survey', [
    'labels' => [
      'name'               => 'お客様アンケート',
      'singular_name'      => 'お客様アンケート',
      'add_new'            => '新規追加',
      'add_new_item'       => 'アンケートを追加',
      'edit_item'          => 'アンケートを編集',
      'new_item'           => '新規アンケート',
      'view_item'          => 'アンケートを表示',
      'not_found'          => 'アンケートが見つかりません',
      'not_found_in_trash' => 'ゴミ箱にアンケートはありません',
    ],
    'public'              => false,
    'publicly_queryable'  => false,
    'show_ui'             => false,
    'show_in_menu'        => false,
    'exclude_from_search' => true,
    'supports'            => ['title', 'custom-fields'],
    'show_in_rest'        => false,
  ]);

}
add_action('init', 'miyuki_register_post_types');


/* ============================================================
   施工事例のカテゴリータクソノミー登録
   ============================================================ */
function miyuki_register_taxonomies() {
  register_taxonomy('works_category', 'works', [
    'labels' => [
      'name'          => '施工カテゴリー',
      'singular_name' => 'カテゴリー',
      'add_new_item'  => 'カテゴリーを追加',
      'edit_item'     => 'カテゴリーを編集',
    ],
    'hierarchical' => true,
    'public'       => true,
    'rewrite'      => ['slug' => 'works-category'],
    'show_in_rest' => true,
  ]);
}
add_action('init', 'miyuki_register_taxonomies');

function miyuki_default_works_categories() {
  return [
    'new-build'    => '新築',
    'construction' => '建築施工',
    'renovation'   => 'リフォーム',
    'maintenance'  => 'メンテナンス',
  ];
}

function miyuki_ensure_works_categories() {
  if (!taxonomy_exists('works_category')) {
    return;
  }

  foreach (miyuki_default_works_categories() as $slug => $name) {
    if (get_term_by('slug', $slug, 'works_category') || get_term_by('name', $name, 'works_category')) {
      continue;
    }

    wp_insert_term($name, 'works_category', [
      'slug' => $slug,
    ]);
  }
}
add_action('init', 'miyuki_ensure_works_categories', 20);

function miyuki_sort_works_categories($terms) {
  if (empty($terms) || is_wp_error($terms)) {
    return $terms;
  }

  $order = array_keys(miyuki_default_works_categories());
  usort($terms, function($a, $b) use ($order) {
    $a_index = array_search($a->slug, $order, true);
    $b_index = array_search($b->slug, $order, true);

    $a_index = ($a_index === false) ? 999 : $a_index;
    $b_index = ($b_index === false) ? 999 : $b_index;

    if ($a_index === $b_index) {
      return strcasecmp($a->name, $b->name);
    }

    return $a_index <=> $b_index;
  });

  return $terms;
}


/* ============================================================
   アイキャッチ未設定時、本文の最初の画像URLを取得する
   ============================================================ */
function get_first_image_from_content( $post_id = null ) {
  if ( ! $post_id ) $post_id = get_the_ID();
  $post    = get_post( $post_id );
  $content = $post->post_content;
  preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/', $content, $matches );
  return $matches[1] ?? '';
}

function miyuki_get_works_gallery_ids($post_id = null) {
  if (!$post_id) {
    $post_id = get_the_ID();
  }

  $gallery = get_post_meta($post_id, '_miyuki_works_gallery_ids', true);
  if (!$gallery) {
    return [];
  }

  if (is_array($gallery)) {
    $ids = $gallery;
  } else {
    $ids = explode(',', $gallery);
  }

  return array_values(array_filter(array_map('absint', $ids)));
}

function miyuki_get_works_main_image_id($post_id = null) {
  if (!$post_id) {
    $post_id = get_the_ID();
  }

  $main_image_id = absint(get_post_meta($post_id, '_miyuki_works_main_image_id', true));
  if ($main_image_id) {
    return $main_image_id;
  }

  $thumbnail_id = get_post_thumbnail_id($post_id);
  if ($thumbnail_id) {
    return absint($thumbnail_id);
  }

  $gallery_ids = miyuki_get_works_gallery_ids($post_id);
  return $gallery_ids[0] ?? 0;
}

function miyuki_render_works_image($post_id = null, $size = 'large', $attr = []) {
  $image_id = miyuki_get_works_main_image_id($post_id);
  if (!$image_id) {
    return '';
  }

  return wp_get_attachment_image($image_id, $size, false, $attr);
}

function miyuki_works_category_link($slug) {
  $link = get_term_link($slug, 'works_category');
  if (is_wp_error($link)) {
    $archive_link = get_post_type_archive_link('works');
    return $archive_link ?: home_url('/works');
  }
  return $link;
}


/* ============================================================
   アーカイブの表示件数
   ============================================================ */
add_action('pre_get_posts', function($query) {
  if ($query->is_post_type_archive('works') && $query->is_main_query()) {
    $query->set('posts_per_page', 6);
  }
  if ($query->is_post_type_archive('news') && $query->is_main_query()) {
    $query->set('posts_per_page', 10);
  }
  if ($query->is_post_type_archive('staff') && $query->is_main_query()) {
    $query->set('orderby', ['menu_order' => 'ASC', 'date' => 'DESC']);
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }
  if ($query->is_post_type_archive('voice') && $query->is_main_query()) {
    $query->set('orderby', ['menu_order' => 'ASC', 'date' => 'DESC']);
    $query->set('order', 'ASC');
    $query->set('posts_per_page', 9);
  }
});


/* ============================================================
   施工事例 入力テンプレート
   ============================================================ */
function miyuki_register_works_meta() {
  register_post_meta('works', 'location', [
    'type'              => 'string',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'sanitize_text_field',
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);

  register_post_meta('works', '_miyuki_works_lead', [
    'type'              => 'string',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'sanitize_textarea_field',
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);

  register_post_meta('works', '_miyuki_works_main_image_id', [
    'type'              => 'integer',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'absint',
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);

  register_post_meta('works', '_miyuki_works_gallery_ids', [
    'type'              => 'string',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'sanitize_text_field',
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);
}
add_action('init', 'miyuki_register_works_meta');

function miyuki_add_works_meta_boxes() {
  add_meta_box(
    'miyuki_works_template',
    '施工事例 入力テンプレート',
    'miyuki_render_works_template_meta_box',
    'works',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'miyuki_add_works_meta_boxes');

function miyuki_render_works_template_meta_box($post) {
  wp_nonce_field('miyuki_save_works_template', 'miyuki_works_template_nonce');

  $location      = get_post_meta($post->ID, 'location', true);
  $lead          = get_post_meta($post->ID, '_miyuki_works_lead', true);
  $main_image_id = miyuki_get_works_main_image_id($post->ID);
  $gallery_ids   = miyuki_get_works_gallery_ids($post->ID);
  ?>
  <div class="miyuki-works-admin">
    <div class="miyuki-works-admin-guide">
      <p><strong>入力の流れ</strong></p>
      <ol>
        <li>上部のタイトル欄に施工事例名を入力します。</li>
        <li>この欄でメイン画像、説明文、下に並べる写真を設定します。</li>
        <li>右側の「施工カテゴリー」を選んで公開します。</li>
      </ol>
    </div>

    <div class="miyuki-works-field">
      <label for="miyuki_works_location">エリア・種別</label>
      <input type="text" id="miyuki_works_location" name="miyuki_works_location" value="<?php echo esc_attr($location); ?>" placeholder="例：広島市東区 / 戸建てリフォーム">
      <p class="description">一覧カードと詳細ページに小さく表示されます。</p>
    </div>

    <div class="miyuki-works-field">
      <label>メイン画像</label>
      <input type="hidden" class="miyuki-main-image-input" name="miyuki_works_main_image_id" value="<?php echo esc_attr($main_image_id); ?>">
      <div class="miyuki-main-image-preview">
        <?php if ($main_image_id) : ?>
          <?php echo wp_get_attachment_image($main_image_id, 'medium'); ?>
        <?php endif; ?>
      </div>
      <div class="miyuki-works-actions">
        <button type="button" class="button miyuki-main-image-select">メイン画像を選択</button>
        <button type="button" class="button miyuki-main-image-remove">削除</button>
      </div>
      <p class="description">一覧のサムネイルと詳細ページ上部の大きな写真に使われます。</p>
    </div>

    <div class="miyuki-works-field">
      <label for="miyuki_works_lead">説明文</label>
      <textarea id="miyuki_works_lead" name="miyuki_works_lead" rows="5" placeholder="例：キッチンとリビングを明るく使いやすい空間へ改修しました。収納計画や動線にも配慮しています。"><?php echo esc_textarea($lead); ?></textarea>
      <p class="description">詳細ページのタイトル下に表示されます。長い文章は下の本文欄に入力できます。</p>
    </div>

    <div class="miyuki-works-field">
      <label>下に並べる写真</label>
      <input type="hidden" class="miyuki-gallery-input" name="miyuki_works_gallery_ids" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">
      <div class="miyuki-gallery-preview">
        <?php foreach ($gallery_ids as $gallery_id) : ?>
          <?php if (wp_attachment_is_image($gallery_id)) : ?>
            <div class="miyuki-gallery-item" data-id="<?php echo esc_attr($gallery_id); ?>">
              <?php echo wp_get_attachment_image($gallery_id, 'thumbnail'); ?>
              <button type="button" class="miyuki-gallery-remove" aria-label="写真を削除">×</button>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
      <div class="miyuki-works-actions">
        <button type="button" class="button miyuki-gallery-select">写真を選択・追加</button>
        <button type="button" class="button miyuki-gallery-clear">すべて削除</button>
      </div>
      <p class="description">複数選択できます。選んだ順に詳細ページへ並びます。</p>
    </div>
  </div>
  <?php
}

function miyuki_save_works_template_meta($post_id) {
  if (!isset($_POST['miyuki_works_template_nonce']) || !wp_verify_nonce($_POST['miyuki_works_template_nonce'], 'miyuki_save_works_template')) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (get_post_type($post_id) !== 'works' || !current_user_can('edit_post', $post_id)) {
    return;
  }

  $location = isset($_POST['miyuki_works_location']) ? sanitize_text_field(wp_unslash($_POST['miyuki_works_location'])) : '';
  $lead = isset($_POST['miyuki_works_lead']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_works_lead'])) : '';
  $main_image_id = isset($_POST['miyuki_works_main_image_id']) ? absint($_POST['miyuki_works_main_image_id']) : 0;
  $gallery_raw = isset($_POST['miyuki_works_gallery_ids']) ? sanitize_text_field(wp_unslash($_POST['miyuki_works_gallery_ids'])) : '';

  miyuki_update_works_template_fields($post_id, $location, $lead, $main_image_id, $gallery_raw);
}
add_action('save_post_works', 'miyuki_save_works_template_meta');

function miyuki_update_works_template_fields($post_id, $location, $lead, $main_image_id, $gallery_raw) {
  if ($location !== '') {
    update_post_meta($post_id, 'location', $location);
  } else {
    delete_post_meta($post_id, 'location');
  }

  if ($lead !== '') {
    update_post_meta($post_id, '_miyuki_works_lead', $lead);
  } else {
    delete_post_meta($post_id, '_miyuki_works_lead');
  }

  if ($main_image_id) {
    update_post_meta($post_id, '_miyuki_works_main_image_id', $main_image_id);
    set_post_thumbnail($post_id, $main_image_id);
  } else {
    delete_post_meta($post_id, '_miyuki_works_main_image_id');
    delete_post_thumbnail($post_id);
  }

  $gallery_ids = array_values(array_filter(array_map('absint', explode(',', $gallery_raw))));
  if (!empty($gallery_ids)) {
    update_post_meta($post_id, '_miyuki_works_gallery_ids', implode(',', $gallery_ids));
  } else {
    delete_post_meta($post_id, '_miyuki_works_gallery_ids');
  }
}

function miyuki_add_works_easy_admin_page() {
  add_submenu_page(
    'edit.php?post_type=works',
    '施工事例 かんたん投稿',
    'かんたん投稿',
    'edit_posts',
    'miyuki-works-easy-new',
    'miyuki_render_works_easy_admin_page'
  );

  add_submenu_page(
    'edit.php?post_type=works',
    '施工事例 かんたん編集',
    'かんたん編集',
    'edit_posts',
    'miyuki-works-easy-list',
    'miyuki_render_works_easy_list_page'
  );

  remove_submenu_page('edit.php?post_type=works', 'post-new.php?post_type=works');
}
add_action('admin_menu', 'miyuki_add_works_easy_admin_page');

function miyuki_redirect_works_default_editor() {
  global $pagenow;

  if ($pagenow === 'post-new.php' && ($_GET['post_type'] ?? '') === 'works' && !isset($_GET['miyuki_standard'])) {
    wp_safe_redirect(admin_url('edit.php?post_type=works&page=miyuki-works-easy-new'));
    exit;
  }

  if ($pagenow !== 'post.php' || isset($_GET['miyuki_standard'])) {
    return;
  }

  $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
  if (!$post_id || get_post_type($post_id) !== 'works' || ($_GET['action'] ?? '') !== 'edit') {
    return;
  }

  wp_safe_redirect(miyuki_works_easy_edit_url($post_id));
  exit;
}
add_action('admin_init', 'miyuki_redirect_works_default_editor');

function miyuki_works_easy_edit_url($post_id) {
  return admin_url('edit.php?post_type=works&page=miyuki-works-easy-list&works_id=' . absint($post_id));
}

function miyuki_get_works_selected_category_id($post_id) {
  $terms = get_the_terms($post_id, 'works_category');
  if (empty($terms) || is_wp_error($terms)) {
    return 0;
  }

  return absint($terms[0]->term_id);
}

function miyuki_get_works_easy_data($post_id = 0) {
  $post = $post_id ? get_post($post_id) : null;

  if ($post && $post->post_type !== 'works') {
    $post = null;
  }

  return [
    'post_id'      => $post ? absint($post->ID) : 0,
    'title'        => $post ? $post->post_title : '',
    'body'         => $post ? $post->post_content : '',
    'status'       => $post ? $post->post_status : 'publish',
    'location'     => $post ? get_post_meta($post->ID, 'location', true) : '',
    'lead'         => $post ? get_post_meta($post->ID, '_miyuki_works_lead', true) : '',
    'main_image'   => $post ? miyuki_get_works_main_image_id($post->ID) : 0,
    'gallery_ids'  => $post ? miyuki_get_works_gallery_ids($post->ID) : [],
    'category_id'  => $post ? miyuki_get_works_selected_category_id($post->ID) : 0,
  ];
}

function miyuki_render_works_easy_notices() {
  $created_id = isset($_GET['created']) ? absint($_GET['created']) : 0;
  $updated_id = isset($_GET['updated']) ? absint($_GET['updated']) : 0;
  $error      = isset($_GET['miyuki_error']) ? sanitize_key($_GET['miyuki_error']) : '';
  $preview_stopped = isset($_GET['preview_stopped']) ? absint($_GET['preview_stopped']) : 0;
  $preview_started = isset($_GET['preview_started']) ? absint($_GET['preview_started']) : 0;

  if ($created_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>
        施工事例を作成しました。
        <a href="<?php echo esc_url(get_permalink($created_id)); ?>" target="_blank" rel="noopener">表示を確認</a>
      </p>
    </div>
  <?php endif;

  if ($updated_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>
        施工事例を更新しました。
        <a href="<?php echo esc_url(get_permalink($updated_id)); ?>" target="_blank" rel="noopener">表示を確認</a>
      </p>
    </div>
  <?php endif;

  if ($preview_stopped) : ?>
    <div class="notice notice-success is-dismissible">
      <p>お客様確認用URLの公開を終了しました。以前の確認用URLでは表示できません。</p>
    </div>
  <?php endif;

  if ($preview_started) : ?>
    <div class="notice notice-success is-dismissible">
      <p>お客様確認用URLを発行しました。新しいURLを共有できます。</p>
    </div>
  <?php endif;

  if ($error === 'title') : ?>
    <div class="notice notice-error is-dismissible">
      <p>タイトルを入力してください。</p>
    </div>
  <?php elseif ($error === 'save') : ?>
    <div class="notice notice-error is-dismissible">
      <p>保存できませんでした。入力内容を確認してください。</p>
    </div>
  <?php endif;
}

function miyuki_works_status_label($status) {
  $labels = [
    'publish' => '公開中',
    'private' => '非公開',
    'draft'   => '下書き',
    'pending' => 'レビュー待ち',
  ];

  return $labels[$status] ?? $status;
}

function miyuki_get_works_preview_token($post_id) {
  $post_id = absint($post_id);
  $token = get_post_meta($post_id, '_miyuki_works_preview_token', true);

  if (!$token || strlen($token) < 24) {
    $token = wp_generate_password(32, false, false);
    update_post_meta($post_id, '_miyuki_works_preview_token', $token);
  }

  return $token;
}

function miyuki_works_customer_preview_is_enabled($post_id) {
  return get_post_meta(absint($post_id), '_miyuki_works_preview_disabled', true) !== '1';
}

function miyuki_disable_works_customer_preview($post_id) {
  $post_id = absint($post_id);
  update_post_meta($post_id, '_miyuki_works_preview_disabled', '1');
  delete_post_meta($post_id, '_miyuki_works_preview_token');
}

function miyuki_enable_works_customer_preview($post_id) {
  $post_id = absint($post_id);
  delete_post_meta($post_id, '_miyuki_works_preview_disabled');
  miyuki_get_works_preview_token($post_id);
}

function miyuki_production_home_url($path = '/') {
  return 'https://miyuki-housing.jp/miyuki-test' . '/' . ltrim($path, '/');
}

function miyuki_allow_mobile_image_upload_mimes($mimes) {
  $mimes['heic'] = 'image/heic';
  $mimes['heif'] = 'image/heif';
  $mimes['heics'] = 'image/heic-sequence';
  $mimes['heifs'] = 'image/heif-sequence';

  return $mimes;
}
add_filter('upload_mimes', 'miyuki_allow_mobile_image_upload_mimes');

function miyuki_works_customer_preview_url($post_id) {
  $post_id = absint($post_id);
  if (!miyuki_works_customer_preview_is_enabled($post_id)) {
    return '';
  }

  return add_query_arg([
    'miyuki_works_preview' => $post_id,
    'preview_key'          => miyuki_get_works_preview_token($post_id),
  ], miyuki_production_home_url('/'));
}

function miyuki_render_works_preview_404() {
  status_header(404);
  wp_die('確認用URLが無効です。', 'ページが見つかりません', ['response' => 404]);
}

function miyuki_handle_works_customer_preview() {
  if (empty($_GET['miyuki_works_preview'])) {
    return;
  }

  $post_id = absint($_GET['miyuki_works_preview']);
  $preview_key = isset($_GET['preview_key']) ? sanitize_text_field(wp_unslash($_GET['preview_key'])) : '';
  $post = get_post($post_id);

  if (!$post || $post->post_type !== 'works' || in_array($post->post_status, ['trash', 'auto-draft'], true) || !miyuki_works_customer_preview_is_enabled($post_id)) {
    miyuki_render_works_preview_404();
  }

  $token = get_post_meta($post_id, '_miyuki_works_preview_token', true);
  if (!$token || !$preview_key || !hash_equals($token, $preview_key)) {
    miyuki_render_works_preview_404();
  }

  status_header(200);
  nocache_headers();
  header('X-Robots-Tag: noindex, nofollow', true);

  add_filter('wpseo_robots', function() {
    return 'noindex, nofollow';
  });
  add_filter('private_title_format', function() {
    return '%s';
  });
  add_filter('protected_title_format', function() {
    return '%s';
  });

  global $wp_query;
  $GLOBALS['post'] = $post;
  $wp_query->posts = [$post];
  $wp_query->post = $post;
  $wp_query->post_count = 1;
  $wp_query->current_post = -1;
  $wp_query->found_posts = 1;
  $wp_query->max_num_pages = 1;
  $wp_query->queried_object = $post;
  $wp_query->queried_object_id = $post_id;
  $wp_query->is_404 = false;
  $wp_query->is_single = true;
  $wp_query->is_singular = true;
  $wp_query->is_home = false;
  $wp_query->is_archive = false;
  $wp_query->is_post_type_archive = false;

  include get_stylesheet_directory() . '/single-works.php';
  exit;
}
add_action('template_redirect', 'miyuki_handle_works_customer_preview', 0);

function miyuki_render_works_easy_header($title, $description, $actions = [], $kicker = 'WORKS EDIT FORM') {
  ?>
  <div class="miyuki-easy-header">
    <div>
      <p class="miyuki-easy-kicker"><?php echo esc_html($kicker); ?></p>
      <h1><?php echo esc_html($title); ?></h1>
      <p><?php echo esc_html($description); ?></p>
    </div>
    <div class="miyuki-easy-header-actions">
      <?php foreach ($actions as $action) : ?>
        <a class="button<?php echo !empty($action['primary']) ? ' button-primary' : ''; ?>" href="<?php echo esc_url($action['url']); ?>"><?php echo esc_html($action['label']); ?></a>
      <?php endforeach; ?>
    </div>
  </div>
  <?php
}

function miyuki_render_works_easy_admin_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('施工事例 かんたん投稿', '写真を選んで、見出しと説明文を入れるだけで施工事例ページを作成できます。', [
    ['label' => 'かんたん編集へ', 'url' => admin_url('edit.php?post_type=works&page=miyuki-works-easy-list'), 'primary' => true],
    ['label' => '施工事例一覧へ', 'url' => admin_url('edit.php?post_type=works')],
  ]);
  miyuki_render_works_easy_notices();
  miyuki_render_works_easy_form(miyuki_get_works_easy_data(), 'new');
  echo '</div>';
}

function miyuki_render_works_easy_edit_page() {
  $post_id = isset($_GET['works_id']) ? absint($_GET['works_id']) : 0;

  if (!$post_id || get_post_type($post_id) !== 'works' || !current_user_can('edit_post', $post_id)) {
    wp_die('編集する施工事例が見つかりません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('施工事例 かんたん編集', '公開後の施工事例も、写真と文章を見ながら同じフォームで編集できます。', [
    ['label' => 'かんたん編集一覧へ', 'url' => admin_url('edit.php?post_type=works&page=miyuki-works-easy-list'), 'primary' => true],
    ['label' => '表示を確認', 'url' => get_permalink($post_id)],
  ]);
  miyuki_render_works_easy_notices();
  miyuki_render_works_easy_form(miyuki_get_works_easy_data($post_id), 'edit');
  echo '</div>';
}

function miyuki_render_works_easy_list_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  if (!empty($_GET['works_id'])) {
    miyuki_render_works_easy_edit_page();
    return;
  }

  $works_query = new WP_Query([
    'post_type'      => 'works',
    'post_status'    => ['publish', 'draft', 'pending', 'private'],
    'posts_per_page' => 60,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('施工事例 かんたん編集', '編集したい施工事例を選ぶと、視覚的な編集フォームで開きます。', [
    ['label' => '新しく投稿する', 'url' => admin_url('edit.php?post_type=works&page=miyuki-works-easy-new'), 'primary' => true],
    ['label' => '通常一覧へ', 'url' => admin_url('edit.php?post_type=works')],
  ]);
  miyuki_render_works_easy_notices();

  if ($works_query->have_posts()) : ?>
    <div class="miyuki-easy-edit-grid">
      <?php while ($works_query->have_posts()) : $works_query->the_post(); ?>
        <?php
        $post_id = get_the_ID();
        $image   = miyuki_render_works_image($post_id, 'medium', ['loading' => 'lazy']);
        $status  = get_post_status($post_id);
        ?>
        <article class="miyuki-easy-edit-card">
          <a class="miyuki-easy-edit-thumb" href="<?php echo esc_url(miyuki_works_easy_edit_url($post_id)); ?>">
            <?php echo $image ?: '<span>NO IMAGE</span>'; ?>
          </a>
          <div class="miyuki-easy-edit-body">
            <span class="miyuki-easy-status miyuki-easy-status-<?php echo esc_attr($status); ?>"><?php echo esc_html(miyuki_works_status_label($status)); ?></span>
            <h2><?php the_title(); ?></h2>
            <p><?php echo esc_html(get_post_meta($post_id, 'location', true)); ?></p>
            <div class="miyuki-easy-edit-actions">
              <a class="button button-primary" href="<?php echo esc_url(miyuki_works_easy_edit_url($post_id)); ?>">かんたん編集</a>
              <a class="button" href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_blank" rel="noopener">表示</a>
            </div>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <div class="miyuki-easy-empty-list">
      <p>施工事例はまだありません。</p>
      <a class="button button-primary" href="<?php echo esc_url(admin_url('edit.php?post_type=works&page=miyuki-works-easy-new')); ?>">最初の施工事例を作成</a>
    </div>
  <?php endif;

  echo '</div>';
}

function miyuki_render_works_easy_form($data, $mode = 'new') {
  $terms = get_terms([
    'taxonomy'   => 'works_category',
    'hide_empty' => false,
  ]);
  $terms = miyuki_sort_works_categories($terms);

  $post_id         = absint($data['post_id']);
  $main_image_id   = absint($data['main_image']);
  $gallery_ids     = array_map('absint', $data['gallery_ids']);
  $selected_cat_id = absint($data['category_id']);
  $is_edit         = $mode === 'edit' && $post_id;
  $status          = in_array($data['status'], ['publish', 'private', 'draft'], true) ? $data['status'] : 'publish';
  $standard_url    = $is_edit ? admin_url('post.php?post=' . $post_id . '&action=edit&miyuki_standard=1') : admin_url('post-new.php?post_type=works&miyuki_standard=1');
  ?>
  <form class="miyuki-works-easy-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <?php wp_nonce_field('miyuki_works_easy_submit', 'miyuki_works_easy_nonce'); ?>
    <input type="hidden" name="action" value="miyuki_works_easy_submit">
    <input type="hidden" name="miyuki_works_id" value="<?php echo esc_attr($post_id); ?>">

    <div class="miyuki-easy-layout">
      <div class="miyuki-easy-main">
        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>1</span>
            <div>
              <h2>基本情報</h2>
              <p>一覧と詳細ページに表示される文字情報です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_works_title">施工事例タイトル</label>
            <input type="text" id="miyuki_works_title" name="miyuki_works_title" required value="<?php echo esc_attr($data['title']); ?>" placeholder="例：明るいLDKへリフォームした住まい">
          </div>

          <div class="miyuki-easy-grid-2">
            <div class="miyuki-works-field">
              <label for="miyuki_works_location">エリア・種別</label>
              <input type="text" id="miyuki_works_location" name="miyuki_works_location" value="<?php echo esc_attr($data['location']); ?>" placeholder="例：広島市東区 / 戸建てリフォーム">
            </div>

            <div class="miyuki-works-field">
              <label for="miyuki_works_category">施工カテゴリー</label>
              <select id="miyuki_works_category" name="miyuki_works_category">
                <option value="">選択してください</option>
                <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                  <?php foreach ($terms as $term) : ?>
                    <option value="<?php echo esc_attr($term->term_id); ?>" <?php selected($selected_cat_id, $term->term_id); ?>><?php echo esc_html($term->name); ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>2</span>
            <div>
              <h2>メイン画像</h2>
              <p>一覧カードと詳細ページの一番大きな写真になります。大きい画像は自動で軽量化します。</p>
            </div>
          </div>

          <input type="hidden" class="miyuki-main-image-input" name="miyuki_works_main_image_id" value="<?php echo esc_attr($main_image_id); ?>">
          <div class="miyuki-easy-main-drop miyuki-main-image-preview" data-drop-target="main">
            <?php if ($main_image_id) : ?>
              <?php echo wp_get_attachment_image($main_image_id, 'medium'); ?>
            <?php else : ?>
              <div class="miyuki-easy-empty">
                <strong>ここに画像をドラッグ</strong>
                <span>容量オーバー防止のため、自動で軽くしてからアップします。</span>
              </div>
            <?php endif; ?>
          </div>
          <div class="miyuki-works-actions">
            <button type="button" class="button button-primary miyuki-main-image-select">画像を選択・アップロード</button>
            <button type="button" class="button miyuki-main-image-remove">削除</button>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>3</span>
            <div>
              <h2>説明文</h2>
              <p>タイトル下に表示される紹介文です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_works_lead">短い説明文</label>
            <textarea id="miyuki_works_lead" name="miyuki_works_lead" rows="5" placeholder="例：キッチンとリビングを明るく使いやすい空間へ。動線と収納計画を整えました。"><?php echo esc_textarea($data['lead']); ?></textarea>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_works_body">詳しい説明文</label>
            <textarea id="miyuki_works_body" name="miyuki_works_body" rows="6" placeholder="工事のポイント、こだわったところ、お客様のご要望などを入力できます。空欄でも公開できます。"><?php echo esc_textarea($data['body']); ?></textarea>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>4</span>
            <div>
              <h2>下に並べる写真</h2>
              <p>室内・設備・ビフォーアフターなど、複数枚を選べます。1枚ずつ順番に軽量化してアップします。</p>
            </div>
          </div>

          <input type="hidden" class="miyuki-gallery-input" name="miyuki_works_gallery_ids" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">
          <div class="miyuki-gallery-preview miyuki-easy-gallery-preview" data-drop-target="gallery">
            <?php if (!empty($gallery_ids)) : ?>
              <?php foreach ($gallery_ids as $gallery_id) : ?>
                <?php if (wp_attachment_is_image($gallery_id)) : ?>
                  <div class="miyuki-gallery-item" data-id="<?php echo esc_attr($gallery_id); ?>">
                    <?php echo wp_get_attachment_image($gallery_id, 'thumbnail'); ?>
                    <button type="button" class="miyuki-gallery-remove" aria-label="写真を削除">×</button>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php else : ?>
              <div class="miyuki-gallery-empty">
                <strong>写真をまとめてドラッグ</strong>
                <span>大きい写真も自動で軽くして、順番に追加します。</span>
              </div>
            <?php endif; ?>
          </div>
          <div class="miyuki-works-actions">
            <button type="button" class="button button-primary miyuki-gallery-select">写真を選択・追加</button>
            <button type="button" class="button miyuki-gallery-clear">すべて削除</button>
          </div>
        </section>
      </div>

      <aside class="miyuki-easy-side">
        <div class="miyuki-easy-preview-card">
          <p class="miyuki-easy-preview-label">完成イメージ</p>
          <div class="miyuki-easy-preview-image">
            <?php echo $main_image_id ? wp_get_attachment_image($main_image_id, 'medium') : 'メイン画像'; ?>
          </div>
          <p class="miyuki-easy-preview-en">WORKS</p>
          <h2><?php echo esc_html($data['title'] ?: '施工事例タイトル'); ?></h2>
          <p><?php echo esc_html($data['lead'] ?: '説明文がここに表示されます。'); ?></p>
        </div>

        <div class="miyuki-easy-publish-card">
          <h2><?php echo $is_edit ? '更新' : '保存'; ?></h2>
          <?php if ($is_edit) : ?>
            <p class="miyuki-easy-current-status">
              現在：<span class="miyuki-easy-status miyuki-easy-status-<?php echo esc_attr($status); ?>"><?php echo esc_html(miyuki_works_status_label($status)); ?></span>
            </p>
          <?php endif; ?>
          <p>公開状態を選んで保存できます。非公開にするとホームページの施工事例一覧には表示されません。</p>
          <div class="miyuki-works-field miyuki-easy-status-field">
            <label for="miyuki_works_status">公開状態</label>
            <select id="miyuki_works_status" name="miyuki_works_status">
              <option value="publish" <?php selected($status, 'publish'); ?>>公開する</option>
              <option value="private" <?php selected($status, 'private'); ?>>非公開にする</option>
              <option value="draft" <?php selected($status, 'draft'); ?>>下書きにする</option>
            </select>
          </div>
          <button type="submit" class="button button-primary button-hero"><?php echo $is_edit ? '保存する' : '作成する'; ?></button>
          <?php if ($is_edit) : ?>
            <?php
            $customer_preview_enabled = miyuki_works_customer_preview_is_enabled($post_id);
            $customer_preview_url = $customer_preview_enabled ? miyuki_works_customer_preview_url($post_id) : '';
            ?>
            <div class="miyuki-easy-customer-preview">
              <label for="miyuki_works_customer_preview_url">お客様確認用URL</label>
              <?php if ($customer_preview_enabled && $customer_preview_url) : ?>
                <input type="text" id="miyuki_works_customer_preview_url" value="<?php echo esc_url($customer_preview_url); ?>" readonly onclick="this.select();">
                <a class="button" href="<?php echo esc_url($customer_preview_url); ?>" target="_blank" rel="noopener">ログインなしで確認</a>
                <button type="submit" name="miyuki_works_preview_action" value="disable" class="button miyuki-easy-preview-stop" formnovalidate>確認用URLの公開を終了</button>
                <p>非公開・下書きでも、このURLを知っている人だけ表示を確認できます。検索結果には出ない設定です。</p>
              <?php else : ?>
                <p class="miyuki-easy-preview-disabled">確認用URLは停止中です。以前のURLでは表示できません。</p>
                <button type="submit" name="miyuki_works_preview_action" value="enable" class="button" formnovalidate>確認用URLを発行する</button>
              <?php endif; ?>
            </div>
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_blank" rel="noopener">表示を確認</a>
          <?php endif; ?>
          <a href="<?php echo esc_url($standard_url); ?>">通常編集画面を使う</a>
        </div>
      </aside>
    </div>
  </form>
  <?php
}

function miyuki_handle_works_easy_submit() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  if (!isset($_POST['miyuki_works_easy_nonce']) || !wp_verify_nonce($_POST['miyuki_works_easy_nonce'], 'miyuki_works_easy_submit')) {
    wp_die('不正な送信です。');
  }

  $post_id = isset($_POST['miyuki_works_id']) ? absint($_POST['miyuki_works_id']) : 0;
  $is_edit = $post_id && get_post_type($post_id) === 'works';

  if ($is_edit && !current_user_can('edit_post', $post_id)) {
    wp_die('この施工事例を編集する権限がありません。');
  }

  $preview_action = isset($_POST['miyuki_works_preview_action']) ? sanitize_key(wp_unslash($_POST['miyuki_works_preview_action'])) : '';
  if ($is_edit && $preview_action) {
    if ($preview_action === 'disable') {
      miyuki_disable_works_customer_preview($post_id);
      wp_safe_redirect(add_query_arg('preview_stopped', 1, miyuki_works_easy_edit_url($post_id)));
      exit;
    }

    if ($preview_action === 'enable') {
      miyuki_enable_works_customer_preview($post_id);
      wp_safe_redirect(add_query_arg('preview_started', 1, miyuki_works_easy_edit_url($post_id)));
      exit;
    }
  }

  $title = isset($_POST['miyuki_works_title']) ? sanitize_text_field(wp_unslash($_POST['miyuki_works_title'])) : '';
  if ($title === '') {
    $redirect = $is_edit ? miyuki_works_easy_edit_url($post_id) : admin_url('edit.php?post_type=works&page=miyuki-works-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'title', $redirect));
    exit;
  }

  $lead          = isset($_POST['miyuki_works_lead']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_works_lead'])) : '';
  $body          = isset($_POST['miyuki_works_body']) ? wp_kses_post(wp_unslash($_POST['miyuki_works_body'])) : '';
  $location      = isset($_POST['miyuki_works_location']) ? sanitize_text_field(wp_unslash($_POST['miyuki_works_location'])) : '';
  $category_id   = isset($_POST['miyuki_works_category']) ? absint($_POST['miyuki_works_category']) : 0;
  $main_image_id = isset($_POST['miyuki_works_main_image_id']) ? absint($_POST['miyuki_works_main_image_id']) : 0;
  $gallery_raw   = isset($_POST['miyuki_works_gallery_ids']) ? sanitize_text_field(wp_unslash($_POST['miyuki_works_gallery_ids'])) : '';
  $status        = isset($_POST['miyuki_works_status']) ? sanitize_key(wp_unslash($_POST['miyuki_works_status'])) : 'publish';
  if (!in_array($status, ['publish', 'private', 'draft'], true)) {
    $status = 'publish';
  }

  $post_data = [
    'post_type'    => 'works',
    'post_status'  => $status,
    'post_title'   => $title,
    'post_content' => $body,
    'post_excerpt' => $lead,
  ];

  if ($is_edit) {
    $post_data['ID'] = $post_id;
    $saved_id = wp_update_post($post_data, true);
  } else {
    $saved_id = wp_insert_post($post_data, true);
  }

  if (is_wp_error($saved_id)) {
    $redirect = $is_edit ? miyuki_works_easy_edit_url($post_id) : admin_url('edit.php?post_type=works&page=miyuki-works-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'save', $redirect));
    exit;
  }

  $post_id = absint($saved_id);
  miyuki_update_works_template_fields($post_id, $location, $lead, $main_image_id, $gallery_raw);

  if ($category_id) {
    wp_set_object_terms($post_id, [$category_id], 'works_category');
  } else {
    wp_set_object_terms($post_id, [], 'works_category');
  }

  $redirect_arg = $is_edit ? 'updated' : 'created';
  wp_safe_redirect(add_query_arg($redirect_arg, $post_id, miyuki_works_easy_edit_url($post_id)));
  exit;
}
add_action('admin_post_miyuki_works_easy_submit', 'miyuki_handle_works_easy_submit');

add_filter('post_row_actions', function($actions, $post) {
  if ($post->post_type !== 'works') {
    return $actions;
  }

  $actions = ['miyuki_easy_edit' => '<a href="' . esc_url(miyuki_works_easy_edit_url($post->ID)) . '">かんたん編集</a>'] + $actions;
  return $actions;
}, 10, 2);

function miyuki_ajax_upload_works_image() {
  if (!current_user_can('upload_files')) {
    wp_send_json_error(['message' => '画像をアップロードする権限がありません。'], 403);
  }

  check_ajax_referer('miyuki_works_upload_image', 'nonce');

  if (empty($_FILES['file'])) {
    wp_send_json_error(['message' => '画像ファイルが見つかりません。'], 400);
  }

  $file = $_FILES['file'];

  if (!empty($file['error'])) {
    $message = 'アップロードに失敗しました。';
    if ((int) $file['error'] === UPLOAD_ERR_INI_SIZE || (int) $file['error'] === UPLOAD_ERR_FORM_SIZE) {
      $message = '画像容量が大きすぎます。画像を小さくして再度お試しください。';
    }

    wp_send_json_error(['message' => $message], 400);
  }

  $filetype = wp_check_filetype_and_ext($file['tmp_name'], $file['name']);

  if (empty($filetype['type']) || strpos($filetype['type'], 'image/') !== 0) {
    wp_send_json_error(['message' => '画像ファイルを選択してください。'], 400);
  }

  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';

  $upload = wp_handle_upload($file, ['test_form' => false]);

  if (isset($upload['error'])) {
    wp_send_json_error(['message' => $upload['error']], 500);
  }

  $attachment_id = wp_insert_attachment([
    'post_mime_type' => $upload['type'],
    'post_title'     => sanitize_file_name(pathinfo($upload['file'], PATHINFO_FILENAME)),
    'post_content'   => '',
    'post_status'    => 'inherit',
  ], $upload['file']);

  if (is_wp_error($attachment_id)) {
    wp_send_json_error(['message' => $attachment_id->get_error_message()], 500);
  }

  $metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
  wp_update_attachment_metadata($attachment_id, $metadata);

  wp_send_json_success([
    'id'    => $attachment_id,
    'url'   => wp_get_attachment_image_url($attachment_id, 'full'),
    'title' => get_the_title($attachment_id),
    'alt'   => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
    'sizes' => [
      'thumbnail' => ['url' => wp_get_attachment_image_url($attachment_id, 'thumbnail')],
      'medium'    => ['url' => wp_get_attachment_image_url($attachment_id, 'medium')],
    ],
  ]);
}
add_action('wp_ajax_miyuki_works_upload_image', 'miyuki_ajax_upload_works_image');

function miyuki_enqueue_works_admin_assets($hook) {
  global $post_type;

  $easy_pages = [
    'miyuki-works-easy-new',
    'miyuki-works-easy-list',
    'miyuki-staff-easy-new',
    'miyuki-staff-easy-list',
    'miyuki-news-easy-new',
    'miyuki-news-easy-list',
    'miyuki-event-easy-new',
    'miyuki-event-easy-list',
    'miyuki-voice-easy-new',
    'miyuki-voice-easy-list',
    'miyuki-voice-surveys',
    'miyuki-voice-survey-list',
  ];
  $is_supported_editor = in_array($hook, ['post.php', 'post-new.php'], true) && in_array($post_type, ['works', 'staff', 'news', 'event', 'voice'], true);
  $is_easy_page        = isset($_GET['page']) && in_array($_GET['page'], $easy_pages, true);

  if (!$is_supported_editor && !$is_easy_page) {
    return;
  }

  wp_enqueue_media();
  if (isset($_GET['page']) && in_array($_GET['page'], ['miyuki-news-easy-new', 'miyuki-news-easy-list', 'miyuki-event-easy-new', 'miyuki-event-easy-list'], true)) {
    wp_enqueue_editor();
  }
  wp_enqueue_style(
    'miyuki-works-admin',
    get_stylesheet_directory_uri() . '/assets/css/admin-works.css',
    [],
    filemtime(get_stylesheet_directory() . '/assets/css/admin-works.css')
  );
  wp_enqueue_script(
    'miyuki-works-admin',
    get_stylesheet_directory_uri() . '/assets/js/admin-works.js',
    ['jquery'],
    filemtime(get_stylesheet_directory() . '/assets/js/admin-works.js'),
    true
  );
  wp_localize_script('miyuki-works-admin', 'miyukiWorksAdmin', [
    'ajaxUrl'        => admin_url('admin-ajax.php'),
    'nonce'          => wp_create_nonce('miyuki_works_upload_image'),
    'maxUploadBytes' => wp_max_upload_size(),
  ]);
}
add_action('admin_enqueue_scripts', 'miyuki_enqueue_works_admin_assets');


/* ============================================================
   スタッフ紹介 かんたん投稿・編集
   ============================================================ */
function miyuki_register_staff_meta() {
  foreach (['position', 'career', 'comment'] as $meta_key) {
    register_post_meta('staff', $meta_key, [
      'type'              => 'string',
      'single'            => true,
      'show_in_rest'      => true,
      'sanitize_callback' => $meta_key === 'comment' ? 'sanitize_textarea_field' : 'sanitize_text_field',
      'auth_callback'     => function() {
        return current_user_can('edit_posts');
      },
    ]);
  }

  register_post_meta('staff', '_miyuki_staff_photo_id', [
    'type'              => 'integer',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'absint',
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);
}
add_action('init', 'miyuki_register_staff_meta');

function miyuki_get_staff_photo_id($post_id = null) {
  if (!$post_id) {
    $post_id = get_the_ID();
  }

  $photo_id = absint(get_post_meta($post_id, '_miyuki_staff_photo_id', true));
  if ($photo_id) {
    return $photo_id;
  }

  $thumbnail_id = get_post_thumbnail_id($post_id);
  return $thumbnail_id ? absint($thumbnail_id) : 0;
}

function miyuki_render_staff_image($post_id = null, $size = 'medium', $attr = []) {
  $photo_id = miyuki_get_staff_photo_id($post_id);
  if (!$photo_id) {
    return '';
  }

  return wp_get_attachment_image($photo_id, $size, false, $attr);
}

function miyuki_staff_placeholder_image($alt = 'No Image') {
  return '<img src="' . esc_url(get_stylesheet_directory_uri() . '/assets/images/no-image-staff.svg') . '" alt="' . esc_attr($alt) . '" loading="lazy">';
}

function miyuki_get_next_staff_menu_order() {
  global $wpdb;

  $max_order = (int) $wpdb->get_var(
    "SELECT MAX(menu_order) FROM {$wpdb->posts} WHERE post_type = 'staff' AND post_status NOT IN ('trash', 'auto-draft')"
  );

  return $max_order + 10;
}

function miyuki_update_staff_menu_order($post_id, $menu_order) {
  $menu_order = absint($menu_order);

  if ((int) get_post_field('menu_order', $post_id) === $menu_order) {
    return;
  }

  remove_action('save_post_staff', 'miyuki_save_staff_template_meta');
  wp_update_post([
    'ID'         => $post_id,
    'menu_order' => $menu_order,
  ]);
  add_action('save_post_staff', 'miyuki_save_staff_template_meta');
}

function miyuki_update_staff_template_fields($post_id, $position, $career, $comment, $photo_id) {
  foreach ([
    'position' => $position,
    'career'   => $career,
    'comment'  => $comment,
  ] as $key => $value) {
    if ($value !== '') {
      update_post_meta($post_id, $key, $value);
    } else {
      delete_post_meta($post_id, $key);
    }
  }

  if ($photo_id) {
    update_post_meta($post_id, '_miyuki_staff_photo_id', $photo_id);
    set_post_thumbnail($post_id, $photo_id);
  } else {
    delete_post_meta($post_id, '_miyuki_staff_photo_id');
    delete_post_thumbnail($post_id);
  }
}

function miyuki_add_staff_meta_boxes() {
  add_meta_box(
    'miyuki_staff_template',
    'スタッフ紹介 入力テンプレート',
    'miyuki_render_staff_template_meta_box',
    'staff',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'miyuki_add_staff_meta_boxes');

function miyuki_render_staff_template_meta_box($post) {
  wp_nonce_field('miyuki_save_staff_template', 'miyuki_staff_template_nonce');

  $position = get_post_meta($post->ID, 'position', true);
  $career   = get_post_meta($post->ID, 'career', true);
  $comment  = get_post_meta($post->ID, 'comment', true);
  $photo_id = miyuki_get_staff_photo_id($post->ID);
  $order    = (int) get_post_field('menu_order', $post->ID);
  ?>
  <div class="miyuki-works-admin">
    <div class="miyuki-works-admin-guide">
      <p><strong>入力の流れ</strong></p>
      <ol>
        <li>上部のタイトル欄にスタッフ名を入力します。</li>
        <li>写真、肩書き、資格・補足、紹介文を入力します。</li>
        <li>公開するとスタッフ紹介ページに表示されます。</li>
      </ol>
    </div>

    <div class="miyuki-works-field">
      <label for="miyuki_staff_order">表示順</label>
      <input type="number" id="miyuki_staff_order" name="miyuki_staff_order" value="<?php echo esc_attr($order); ?>" min="0" step="1" placeholder="例：10">
      <p class="description">数字が小さいスタッフほど、ホームページで左から先に表示されます。</p>
    </div>

    <div class="miyuki-works-field">
      <label for="miyuki_staff_position">肩書き・役職</label>
      <input type="text" id="miyuki_staff_position" name="miyuki_staff_position" value="<?php echo esc_attr($position); ?>" placeholder="例：代表取締役">
    </div>

    <div class="miyuki-works-field">
      <label for="miyuki_staff_career">資格・補足</label>
      <input type="text" id="miyuki_staff_career" name="miyuki_staff_career" value="<?php echo esc_attr($career); ?>" placeholder="例：一級建築施工管理技士">
    </div>

    <div class="miyuki-works-field">
      <label>スタッフ写真</label>
      <input type="hidden" class="miyuki-main-image-input" name="miyuki_staff_photo_id" value="<?php echo esc_attr($photo_id); ?>">
      <div class="miyuki-main-image-preview">
        <?php if ($photo_id) : ?>
          <?php echo wp_get_attachment_image($photo_id, 'medium'); ?>
        <?php endif; ?>
      </div>
      <div class="miyuki-works-actions">
        <button type="button" class="button miyuki-main-image-select">写真を選択</button>
        <button type="button" class="button miyuki-main-image-remove">削除</button>
      </div>
      <p class="description">未設定の場合は仮画像が表示されます。</p>
    </div>

    <div class="miyuki-works-field">
      <label for="miyuki_staff_comment">紹介文</label>
      <textarea id="miyuki_staff_comment" name="miyuki_staff_comment" rows="5" placeholder="例：お客様の暮らしに寄り添いながら、住まいの魅力を引き出すご提案を行っています。"><?php echo esc_textarea($comment); ?></textarea>
    </div>
  </div>
  <?php
}

function miyuki_save_staff_template_meta($post_id) {
  if (!isset($_POST['miyuki_staff_template_nonce']) || !wp_verify_nonce($_POST['miyuki_staff_template_nonce'], 'miyuki_save_staff_template')) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (get_post_type($post_id) !== 'staff' || !current_user_can('edit_post', $post_id)) {
    return;
  }

  $position = isset($_POST['miyuki_staff_position']) ? sanitize_text_field(wp_unslash($_POST['miyuki_staff_position'])) : '';
  $career   = isset($_POST['miyuki_staff_career']) ? sanitize_text_field(wp_unslash($_POST['miyuki_staff_career'])) : '';
  $comment  = isset($_POST['miyuki_staff_comment']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_staff_comment'])) : '';
  $photo_id = isset($_POST['miyuki_staff_photo_id']) ? absint($_POST['miyuki_staff_photo_id']) : 0;
  $order    = isset($_POST['miyuki_staff_order']) ? absint($_POST['miyuki_staff_order']) : 0;

  miyuki_update_staff_template_fields($post_id, $position, $career, $comment, $photo_id);
  miyuki_update_staff_menu_order($post_id, $order);
}
add_action('save_post_staff', 'miyuki_save_staff_template_meta');

function miyuki_add_staff_easy_admin_page() {
  add_submenu_page(
    'edit.php?post_type=staff',
    'スタッフ かんたん投稿',
    'かんたん投稿',
    'edit_posts',
    'miyuki-staff-easy-new',
    'miyuki_render_staff_easy_admin_page'
  );

  add_submenu_page(
    'edit.php?post_type=staff',
    'スタッフ かんたん編集',
    'かんたん編集',
    'edit_posts',
    'miyuki-staff-easy-list',
    'miyuki_render_staff_easy_list_page'
  );

  remove_submenu_page('edit.php?post_type=staff', 'post-new.php?post_type=staff');
}
add_action('admin_menu', 'miyuki_add_staff_easy_admin_page');

function miyuki_staff_easy_edit_url($post_id) {
  return admin_url('edit.php?post_type=staff&page=miyuki-staff-easy-list&staff_id=' . absint($post_id));
}

function miyuki_redirect_staff_default_editor() {
  global $pagenow;

  if ($pagenow === 'post-new.php' && ($_GET['post_type'] ?? '') === 'staff' && !isset($_GET['miyuki_standard'])) {
    wp_safe_redirect(admin_url('edit.php?post_type=staff&page=miyuki-staff-easy-new'));
    exit;
  }

  if ($pagenow !== 'post.php' || isset($_GET['miyuki_standard'])) {
    return;
  }

  $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
  if (!$post_id || get_post_type($post_id) !== 'staff' || ($_GET['action'] ?? '') !== 'edit') {
    return;
  }

  wp_safe_redirect(miyuki_staff_easy_edit_url($post_id));
  exit;
}
add_action('admin_init', 'miyuki_redirect_staff_default_editor');

function miyuki_get_staff_easy_data($post_id = 0) {
  $post = $post_id ? get_post($post_id) : null;
  if ($post && $post->post_type !== 'staff') {
    $post = null;
  }

  return [
    'post_id'  => $post ? absint($post->ID) : 0,
    'title'    => $post ? $post->post_title : '',
    'status'   => $post ? $post->post_status : 'publish',
    'order'    => $post ? (int) get_post_field('menu_order', $post->ID) : miyuki_get_next_staff_menu_order(),
    'position' => $post ? get_post_meta($post->ID, 'position', true) : '',
    'career'   => $post ? get_post_meta($post->ID, 'career', true) : '',
    'comment'  => $post ? get_post_meta($post->ID, 'comment', true) : '',
    'photo_id' => $post ? miyuki_get_staff_photo_id($post->ID) : 0,
  ];
}

function miyuki_render_staff_easy_notices() {
  $created_id = isset($_GET['created']) ? absint($_GET['created']) : 0;
  $updated_id = isset($_GET['updated']) ? absint($_GET['updated']) : 0;
  $error      = isset($_GET['miyuki_error']) ? sanitize_key($_GET['miyuki_error']) : '';

  if ($created_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>スタッフ情報を作成しました。<a href="<?php echo esc_url(get_post_type_archive_link('staff')); ?>" target="_blank" rel="noopener">表示を確認</a></p>
    </div>
  <?php endif;

  if ($updated_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>スタッフ情報を更新しました。<a href="<?php echo esc_url(get_post_type_archive_link('staff')); ?>" target="_blank" rel="noopener">表示を確認</a></p>
    </div>
  <?php endif;

  if ($error === 'title') : ?>
    <div class="notice notice-error is-dismissible"><p>スタッフ名を入力してください。</p></div>
  <?php elseif ($error === 'save') : ?>
    <div class="notice notice-error is-dismissible"><p>保存できませんでした。入力内容を確認してください。</p></div>
  <?php endif;
}

function miyuki_render_staff_easy_admin_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('スタッフ かんたん投稿', '写真、名前、肩書き、紹介文を入れるだけでスタッフ紹介に表示できます。', [
    ['label' => 'かんたん編集へ', 'url' => admin_url('edit.php?post_type=staff&page=miyuki-staff-easy-list'), 'primary' => true],
    ['label' => 'スタッフ一覧へ', 'url' => admin_url('edit.php?post_type=staff')],
  ], 'STAFF EDIT FORM');
  miyuki_render_staff_easy_notices();
  miyuki_render_staff_easy_form(miyuki_get_staff_easy_data(), 'new');
  echo '</div>';
}

function miyuki_render_staff_easy_edit_page() {
  $post_id = isset($_GET['staff_id']) ? absint($_GET['staff_id']) : 0;

  if (!$post_id || get_post_type($post_id) !== 'staff' || !current_user_can('edit_post', $post_id)) {
    wp_die('編集するスタッフ情報が見つかりません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('スタッフ かんたん編集', '公開後のスタッフ情報も、同じフォームで写真と文章を見ながら編集できます。', [
    ['label' => 'かんたん編集一覧へ', 'url' => admin_url('edit.php?post_type=staff&page=miyuki-staff-easy-list'), 'primary' => true],
    ['label' => '表示を確認', 'url' => get_post_type_archive_link('staff')],
  ], 'STAFF EDIT FORM');
  miyuki_render_staff_easy_notices();
  miyuki_render_staff_easy_form(miyuki_get_staff_easy_data($post_id), 'edit');
  echo '</div>';
}

function miyuki_render_staff_easy_list_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  if (!empty($_GET['staff_id'])) {
    miyuki_render_staff_easy_edit_page();
    return;
  }

  $staff_query = new WP_Query([
    'post_type'      => 'staff',
    'post_status'    => ['publish', 'draft', 'pending', 'private'],
    'posts_per_page' => 80,
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
  ]);

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('スタッフ かんたん編集', '編集したいスタッフを選ぶと、視覚的な編集フォームで開きます。', [
    ['label' => '新しく投稿する', 'url' => admin_url('edit.php?post_type=staff&page=miyuki-staff-easy-new'), 'primary' => true],
    ['label' => '通常一覧へ', 'url' => admin_url('edit.php?post_type=staff')],
  ], 'STAFF EDIT FORM');
  miyuki_render_staff_easy_notices();

  if ($staff_query->have_posts()) : ?>
    <div class="miyuki-easy-edit-grid">
      <?php while ($staff_query->have_posts()) : $staff_query->the_post(); ?>
        <?php
        $post_id  = get_the_ID();
        $image    = miyuki_render_staff_image($post_id, 'medium', ['loading' => 'lazy']);
        $status   = get_post_status($post_id);
        $position = get_post_meta($post_id, 'position', true);
        $order    = (int) get_post_field('menu_order', $post_id);
        ?>
        <article class="miyuki-easy-edit-card">
          <a class="miyuki-easy-edit-thumb miyuki-staff-edit-thumb" href="<?php echo esc_url(miyuki_staff_easy_edit_url($post_id)); ?>">
            <?php echo $image ?: miyuki_staff_placeholder_image(get_the_title()); ?>
          </a>
          <div class="miyuki-easy-edit-body">
            <span class="miyuki-easy-status miyuki-easy-status-<?php echo esc_attr($status); ?>"><?php echo esc_html($status === 'publish' ? '公開中' : '下書き'); ?></span>
            <h2><?php the_title(); ?></h2>
            <p><?php echo esc_html(trim($position . ' / 表示順: ' . $order)); ?></p>
            <div class="miyuki-easy-edit-actions">
              <a class="button button-primary" href="<?php echo esc_url(miyuki_staff_easy_edit_url($post_id)); ?>">かんたん編集</a>
              <a class="button" href="<?php echo esc_url(get_post_type_archive_link('staff')); ?>" target="_blank" rel="noopener">表示</a>
            </div>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <div class="miyuki-easy-empty-list">
      <p>スタッフ情報はまだありません。</p>
      <a class="button button-primary" href="<?php echo esc_url(admin_url('edit.php?post_type=staff&page=miyuki-staff-easy-new')); ?>">最初のスタッフを作成</a>
    </div>
  <?php endif;

  echo '</div>';
}

function miyuki_render_staff_easy_form($data, $mode = 'new') {
  $post_id      = absint($data['post_id']);
  $photo_id     = absint($data['photo_id']);
  $is_edit      = $mode === 'edit' && $post_id;
  $standard_url = $is_edit ? admin_url('post.php?post=' . $post_id . '&action=edit&miyuki_standard=1') : admin_url('post-new.php?post_type=staff&miyuki_standard=1');
  ?>
  <form class="miyuki-works-easy-form miyuki-staff-easy-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <?php wp_nonce_field('miyuki_staff_easy_submit', 'miyuki_staff_easy_nonce'); ?>
    <input type="hidden" name="action" value="miyuki_staff_easy_submit">
    <input type="hidden" name="miyuki_staff_id" value="<?php echo esc_attr($post_id); ?>">

    <div class="miyuki-easy-layout">
      <div class="miyuki-easy-main">
        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>1</span>
            <div>
              <h2>基本情報</h2>
              <p>スタッフ紹介カードに表示される文字情報です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_staff_title">スタッフ名</label>
            <input type="text" id="miyuki_staff_title" name="miyuki_staff_title" required value="<?php echo esc_attr($data['title']); ?>" placeholder="例：奥田 智美">
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_staff_order">表示順</label>
            <input type="number" id="miyuki_staff_order" name="miyuki_staff_order" required value="<?php echo esc_attr($data['order']); ?>" min="0" step="1" placeholder="例：10">
            <p class="description">数字が小さいスタッフほど、ホームページで左から先に表示されます。10、20、30のように空けておくと後から差し込みやすいです。</p>
          </div>

          <div class="miyuki-easy-grid-2">
            <div class="miyuki-works-field">
              <label for="miyuki_staff_position">肩書き・役職</label>
              <input type="text" id="miyuki_staff_position" name="miyuki_staff_position" value="<?php echo esc_attr($data['position']); ?>" placeholder="例：インテリアコーディネーター">
            </div>

            <div class="miyuki-works-field">
              <label for="miyuki_staff_career">資格・補足</label>
              <input type="text" id="miyuki_staff_career" name="miyuki_staff_career" value="<?php echo esc_attr($data['career']); ?>" placeholder="例：一級建築施工管理技士">
            </div>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>2</span>
            <div>
              <h2>スタッフ写真</h2>
              <p>カード上部に表示される写真です。未設定の場合は仮画像を表示します。</p>
            </div>
          </div>

          <input type="hidden" class="miyuki-main-image-input" name="miyuki_staff_photo_id" value="<?php echo esc_attr($photo_id); ?>">
          <div class="miyuki-easy-main-drop miyuki-main-image-preview" data-drop-target="main">
            <?php if ($photo_id) : ?>
              <?php echo wp_get_attachment_image($photo_id, 'medium'); ?>
            <?php else : ?>
              <div class="miyuki-easy-empty">
                <strong>ここに写真をドラッグ</strong>
                <span>大きい写真も自動で軽くしてアップします。</span>
              </div>
            <?php endif; ?>
          </div>
          <div class="miyuki-works-actions">
            <button type="button" class="button button-primary miyuki-main-image-select">写真を選択・アップロード</button>
            <button type="button" class="button miyuki-main-image-remove">削除</button>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>3</span>
            <div>
              <h2>紹介文</h2>
              <p>スタッフカードの下部に表示される文章です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_staff_comment">紹介文</label>
            <textarea id="miyuki_staff_comment" name="miyuki_staff_comment" rows="7" placeholder="例：お客様のライフスタイルやご希望に寄り添いながら、住まいの魅力を最大限に引き出すご提案を行っています。"><?php echo esc_textarea($data['comment']); ?></textarea>
          </div>
        </section>
      </div>

      <aside class="miyuki-easy-side">
        <div class="miyuki-easy-preview-card miyuki-staff-preview-card">
          <p class="miyuki-easy-preview-label">完成イメージ</p>
          <div class="miyuki-easy-preview-image">
            <?php echo $photo_id ? wp_get_attachment_image($photo_id, 'medium') : miyuki_staff_placeholder_image('スタッフ写真'); ?>
          </div>
          <p class="miyuki-easy-preview-en">STAFF</p>
          <?php if ($data['position']) : ?>
            <p class="miyuki-staff-preview-position"><?php echo esc_html($data['position']); ?></p>
          <?php endif; ?>
          <h2><?php echo esc_html($data['title'] ?: 'スタッフ名'); ?></h2>
          <?php if ($data['career']) : ?>
            <p class="miyuki-staff-preview-career"><?php echo esc_html($data['career']); ?></p>
          <?php endif; ?>
          <p><?php echo esc_html($data['comment'] ?: '紹介文がここに表示されます。'); ?></p>
        </div>

        <div class="miyuki-easy-publish-card">
          <h2><?php echo $is_edit ? '更新' : '公開'; ?></h2>
          <p><?php echo $is_edit ? '公開後の内容も、このフォームから更新できます。' : '入力内容を確認してから公開してください。下書き保存もできます。'; ?></p>
          <button type="submit" name="miyuki_staff_status" value="publish" class="button button-primary button-hero"><?php echo $is_edit ? '更新する' : '公開する'; ?></button>
          <button type="submit" name="miyuki_staff_status" value="draft" class="button button-large">下書き保存</button>
          <?php if ($is_edit) : ?>
            <a href="<?php echo esc_url(get_post_type_archive_link('staff')); ?>" target="_blank" rel="noopener">表示を確認</a>
          <?php endif; ?>
          <a href="<?php echo esc_url($standard_url); ?>">通常編集画面を使う</a>
        </div>
      </aside>
    </div>
  </form>
  <?php
}

function miyuki_handle_staff_easy_submit() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  if (!isset($_POST['miyuki_staff_easy_nonce']) || !wp_verify_nonce($_POST['miyuki_staff_easy_nonce'], 'miyuki_staff_easy_submit')) {
    wp_die('不正な送信です。');
  }

  $post_id = isset($_POST['miyuki_staff_id']) ? absint($_POST['miyuki_staff_id']) : 0;
  $is_edit = $post_id && get_post_type($post_id) === 'staff';

  if ($is_edit && !current_user_can('edit_post', $post_id)) {
    wp_die('このスタッフ情報を編集する権限がありません。');
  }

  $title = isset($_POST['miyuki_staff_title']) ? sanitize_text_field(wp_unslash($_POST['miyuki_staff_title'])) : '';
  if ($title === '') {
    $redirect = $is_edit ? miyuki_staff_easy_edit_url($post_id) : admin_url('edit.php?post_type=staff&page=miyuki-staff-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'title', $redirect));
    exit;
  }

  $position = isset($_POST['miyuki_staff_position']) ? sanitize_text_field(wp_unslash($_POST['miyuki_staff_position'])) : '';
  $career   = isset($_POST['miyuki_staff_career']) ? sanitize_text_field(wp_unslash($_POST['miyuki_staff_career'])) : '';
  $comment  = isset($_POST['miyuki_staff_comment']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_staff_comment'])) : '';
  $photo_id = isset($_POST['miyuki_staff_photo_id']) ? absint($_POST['miyuki_staff_photo_id']) : 0;
  $order    = isset($_POST['miyuki_staff_order']) ? absint($_POST['miyuki_staff_order']) : 0;
  $status   = (isset($_POST['miyuki_staff_status']) && $_POST['miyuki_staff_status'] === 'draft') ? 'draft' : 'publish';

  $post_data = [
    'post_type'    => 'staff',
    'post_status'  => $status,
    'post_title'   => $title,
    'post_content' => $comment,
    'post_excerpt' => $comment,
    'menu_order'   => $order,
  ];

  if ($is_edit) {
    $post_data['ID'] = $post_id;
    $saved_id = wp_update_post($post_data, true);
  } else {
    $saved_id = wp_insert_post($post_data, true);
  }

  if (is_wp_error($saved_id)) {
    $redirect = $is_edit ? miyuki_staff_easy_edit_url($post_id) : admin_url('edit.php?post_type=staff&page=miyuki-staff-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'save', $redirect));
    exit;
  }

  $post_id = absint($saved_id);
  miyuki_update_staff_template_fields($post_id, $position, $career, $comment, $photo_id);

  $redirect_arg = $is_edit ? 'updated' : 'created';
  wp_safe_redirect(add_query_arg($redirect_arg, $post_id, miyuki_staff_easy_edit_url($post_id)));
  exit;
}
add_action('admin_post_miyuki_staff_easy_submit', 'miyuki_handle_staff_easy_submit');

add_filter('post_row_actions', function($actions, $post) {
  if ($post->post_type !== 'staff') {
    return $actions;
  }

  $actions = ['miyuki_easy_edit' => '<a href="' . esc_url(miyuki_staff_easy_edit_url($post->ID)) . '">かんたん編集</a>'] + $actions;
  return $actions;
}, 10, 2);


/* ============================================================
   お知らせ かんたん投稿・編集
   ============================================================ */
function miyuki_register_news_meta() {
  register_post_meta('news', 'is_pickup', [
    'type'              => 'boolean',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => function($value) {
      return (bool) $value;
    },
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);

  register_post_meta('news', '_miyuki_news_image_id', [
    'type'              => 'integer',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'absint',
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);
}
add_action('init', 'miyuki_register_news_meta');

function miyuki_get_news_image_id($post_id = null) {
  if (!$post_id) {
    $post_id = get_the_ID();
  }

  $image_id = absint(get_post_meta($post_id, '_miyuki_news_image_id', true));
  if ($image_id) {
    return $image_id;
  }

  $thumbnail_id = get_post_thumbnail_id($post_id);
  return $thumbnail_id ? absint($thumbnail_id) : 0;
}

function miyuki_render_news_image($post_id = null, $size = 'medium', $attr = []) {
  $image_id = miyuki_get_news_image_id($post_id);
  if (!$image_id) {
    return '';
  }

  return wp_get_attachment_image($image_id, $size, false, $attr);
}

function miyuki_update_news_template_fields($post_id, $excerpt, $image_id, $is_pickup) {
  if ($excerpt !== '') {
    wp_update_post([
      'ID'           => $post_id,
      'post_excerpt' => $excerpt,
    ]);
  }

  if ($image_id) {
    update_post_meta($post_id, '_miyuki_news_image_id', $image_id);
    set_post_thumbnail($post_id, $image_id);
  } else {
    delete_post_meta($post_id, '_miyuki_news_image_id');
    delete_post_thumbnail($post_id);
  }

  if ($is_pickup) {
    update_post_meta($post_id, 'is_pickup', '1');
  } else {
    delete_post_meta($post_id, 'is_pickup');
  }
}

function miyuki_add_news_easy_admin_page() {
  add_submenu_page(
    'edit.php?post_type=news',
    'お知らせ かんたん投稿',
    'かんたん投稿',
    'edit_posts',
    'miyuki-news-easy-new',
    'miyuki_render_news_easy_admin_page'
  );

  add_submenu_page(
    'edit.php?post_type=news',
    'お知らせ かんたん編集',
    'かんたん編集',
    'edit_posts',
    'miyuki-news-easy-list',
    'miyuki_render_news_easy_list_page'
  );

  remove_submenu_page('edit.php?post_type=news', 'post-new.php?post_type=news');
}
add_action('admin_menu', 'miyuki_add_news_easy_admin_page');

function miyuki_news_easy_edit_url($post_id) {
  return admin_url('edit.php?post_type=news&page=miyuki-news-easy-list&news_id=' . absint($post_id));
}

function miyuki_redirect_news_default_editor() {
  global $pagenow;

  if ($pagenow === 'post-new.php' && ($_GET['post_type'] ?? '') === 'news' && !isset($_GET['miyuki_standard'])) {
    wp_safe_redirect(admin_url('edit.php?post_type=news&page=miyuki-news-easy-new'));
    exit;
  }

  if ($pagenow !== 'post.php' || isset($_GET['miyuki_standard'])) {
    return;
  }

  $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
  if (!$post_id || get_post_type($post_id) !== 'news' || ($_GET['action'] ?? '') !== 'edit') {
    return;
  }

  wp_safe_redirect(miyuki_news_easy_edit_url($post_id));
  exit;
}
add_action('admin_init', 'miyuki_redirect_news_default_editor');

function miyuki_get_news_easy_data($post_id = 0) {
  $post = $post_id ? get_post($post_id) : null;
  if ($post && $post->post_type !== 'news') {
    $post = null;
  }

  return [
    'post_id'   => $post ? absint($post->ID) : 0,
    'title'     => $post ? $post->post_title : '',
    'body'      => $post ? $post->post_content : '',
    'excerpt'   => $post ? $post->post_excerpt : '',
    'status'    => $post ? $post->post_status : 'publish',
    'date'      => $post ? mysql2date('Y-m-d', $post->post_date) : current_time('Y-m-d'),
    'image_id'  => $post ? miyuki_get_news_image_id($post->ID) : 0,
    'is_pickup' => $post ? (bool) get_post_meta($post->ID, 'is_pickup', true) : false,
  ];
}

function miyuki_render_news_easy_notices() {
  $created_id = isset($_GET['created']) ? absint($_GET['created']) : 0;
  $updated_id = isset($_GET['updated']) ? absint($_GET['updated']) : 0;
  $error      = isset($_GET['miyuki_error']) ? sanitize_key($_GET['miyuki_error']) : '';

  if ($created_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>お知らせを作成しました。<a href="<?php echo esc_url(get_permalink($created_id)); ?>" target="_blank" rel="noopener">表示を確認</a></p>
    </div>
  <?php endif;

  if ($updated_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>お知らせを更新しました。<a href="<?php echo esc_url(get_permalink($updated_id)); ?>" target="_blank" rel="noopener">表示を確認</a></p>
    </div>
  <?php endif;

  if ($error === 'title') : ?>
    <div class="notice notice-error is-dismissible"><p>タイトルを入力してください。</p></div>
  <?php elseif ($error === 'date') : ?>
    <div class="notice notice-error is-dismissible"><p>表示日を正しく入力してください。</p></div>
  <?php elseif ($error === 'save') : ?>
    <div class="notice notice-error is-dismissible"><p>保存できませんでした。入力内容を確認してください。</p></div>
  <?php endif;
}

function miyuki_render_news_easy_admin_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('お知らせ かんたん投稿', 'タイトル、表示日、画像、本文を入れるだけでお知らせを作成できます。', [
    ['label' => 'かんたん編集へ', 'url' => admin_url('edit.php?post_type=news&page=miyuki-news-easy-list'), 'primary' => true],
    ['label' => 'お知らせ一覧へ', 'url' => admin_url('edit.php?post_type=news')],
  ], 'NEWS EDIT FORM');
  miyuki_render_news_easy_notices();
  miyuki_render_news_easy_form(miyuki_get_news_easy_data(), 'new');
  echo '</div>';
}

function miyuki_render_news_easy_edit_page() {
  $post_id = isset($_GET['news_id']) ? absint($_GET['news_id']) : 0;

  if (!$post_id || get_post_type($post_id) !== 'news' || !current_user_can('edit_post', $post_id)) {
    wp_die('編集するお知らせが見つかりません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('お知らせ かんたん編集', '公開後のお知らせも、同じフォームで画像と文章を見ながら編集できます。', [
    ['label' => 'かんたん編集一覧へ', 'url' => admin_url('edit.php?post_type=news&page=miyuki-news-easy-list'), 'primary' => true],
    ['label' => '表示を確認', 'url' => get_permalink($post_id)],
  ], 'NEWS EDIT FORM');
  miyuki_render_news_easy_notices();
  miyuki_render_news_easy_form(miyuki_get_news_easy_data($post_id), 'edit');
  echo '</div>';
}

function miyuki_render_news_easy_list_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  if (!empty($_GET['news_id'])) {
    miyuki_render_news_easy_edit_page();
    return;
  }

  $news_query = new WP_Query([
    'post_type'      => 'news',
    'post_status'    => ['publish', 'draft', 'pending', 'private', 'future'],
    'posts_per_page' => 80,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('お知らせ かんたん編集', '編集したいお知らせを選ぶと、視覚的な編集フォームで開きます。', [
    ['label' => '新しく投稿する', 'url' => admin_url('edit.php?post_type=news&page=miyuki-news-easy-new'), 'primary' => true],
    ['label' => '通常一覧へ', 'url' => admin_url('edit.php?post_type=news')],
  ], 'NEWS EDIT FORM');
  miyuki_render_news_easy_notices();

  if ($news_query->have_posts()) : ?>
    <div class="miyuki-easy-edit-grid">
      <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
        <?php
        $post_id = get_the_ID();
        $image   = miyuki_render_news_image($post_id, 'medium', ['loading' => 'lazy']);
        $status  = get_post_status($post_id);
        ?>
        <article class="miyuki-easy-edit-card">
          <a class="miyuki-easy-edit-thumb" href="<?php echo esc_url(miyuki_news_easy_edit_url($post_id)); ?>">
            <?php echo $image ?: '<span>NO IMAGE</span>'; ?>
          </a>
          <div class="miyuki-easy-edit-body">
            <span class="miyuki-easy-status miyuki-easy-status-<?php echo esc_attr($status); ?>"><?php echo esc_html($status === 'publish' ? '公開中' : ($status === 'future' ? '予約済み' : '下書き')); ?></span>
            <h2><?php the_title(); ?></h2>
            <p><?php echo esc_html(get_the_date('Y.m.d')); ?></p>
            <div class="miyuki-easy-edit-actions">
              <a class="button button-primary" href="<?php echo esc_url(miyuki_news_easy_edit_url($post_id)); ?>">かんたん編集</a>
              <a class="button" href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_blank" rel="noopener">表示</a>
            </div>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <div class="miyuki-easy-empty-list">
      <p>お知らせはまだありません。</p>
      <a class="button button-primary" href="<?php echo esc_url(admin_url('edit.php?post_type=news&page=miyuki-news-easy-new')); ?>">最初のお知らせを作成</a>
    </div>
  <?php endif;

  echo '</div>';
}

function miyuki_render_news_easy_form($data, $mode = 'new') {
  $post_id      = absint($data['post_id']);
  $image_id     = absint($data['image_id']);
  $is_edit      = $mode === 'edit' && $post_id;
  $standard_url = $is_edit ? admin_url('post.php?post=' . $post_id . '&action=edit&miyuki_standard=1') : admin_url('post-new.php?post_type=news&miyuki_standard=1');
  ?>
  <form class="miyuki-works-easy-form miyuki-news-easy-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <?php wp_nonce_field('miyuki_news_easy_submit', 'miyuki_news_easy_nonce'); ?>
    <input type="hidden" name="action" value="miyuki_news_easy_submit">
    <input type="hidden" name="miyuki_news_id" value="<?php echo esc_attr($post_id); ?>">

    <div class="miyuki-easy-layout">
      <div class="miyuki-easy-main">
        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>1</span>
            <div>
              <h2>基本情報</h2>
              <p>お知らせ一覧とトップページに表示される情報です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_news_title">お知らせタイトル</label>
            <input type="text" id="miyuki_news_title" name="miyuki_news_title" required value="<?php echo esc_attr($data['title']); ?>" placeholder="例：ホームページをリニューアルしました">
          </div>

          <div class="miyuki-easy-grid-2">
            <div class="miyuki-works-field">
              <label for="miyuki_news_date">表示日</label>
              <input type="date" id="miyuki_news_date" name="miyuki_news_date" required value="<?php echo esc_attr($data['date']); ?>">
            </div>

            <div class="miyuki-works-field miyuki-checkbox-field">
              <label for="miyuki_news_pickup">PICK UP表示</label>
              <label class="miyuki-easy-check">
                <input type="checkbox" id="miyuki_news_pickup" name="miyuki_news_pickup" value="1" <?php checked($data['is_pickup']); ?>>
                <span>トップページのカードにPICK UPを表示する</span>
              </label>
            </div>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>2</span>
            <div>
              <h2>画像</h2>
              <p>トップページのカードと詳細ページに使う画像です。未設定でも公開できます。</p>
            </div>
          </div>

          <input type="hidden" class="miyuki-main-image-input" name="miyuki_news_image_id" value="<?php echo esc_attr($image_id); ?>">
          <div class="miyuki-easy-main-drop miyuki-main-image-preview" data-drop-target="main">
            <?php if ($image_id) : ?>
              <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
            <?php else : ?>
              <div class="miyuki-easy-empty">
                <strong>ここに画像をドラッグ</strong>
                <span>大きい画像も自動で軽くしてアップします。</span>
              </div>
            <?php endif; ?>
          </div>
          <div class="miyuki-works-actions">
            <button type="button" class="button button-primary miyuki-main-image-select">画像を選択・アップロード</button>
            <button type="button" class="button miyuki-main-image-remove">削除</button>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>3</span>
            <div>
              <h2>本文</h2>
              <p>一覧用の短い説明と、詳細ページに表示する本文です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_news_excerpt">一覧用の短い説明</label>
            <textarea id="miyuki_news_excerpt" name="miyuki_news_excerpt" rows="4" placeholder="例：このたび、有限会社ミユキハウジングのホームページをリニューアルいたしました。"><?php echo esc_textarea($data['excerpt']); ?></textarea>
          </div>

          <div class="miyuki-works-field miyuki-news-editor-field">
            <label for="miyuki_news_body">詳しい本文</label>
            <p class="description">個別ページに表示されます。画像は本文エリアへドラッグ&ドロップ、または「メディアを追加」から挿入できます。空欄の場合は一覧用の短い説明を表示します。</p>
            <div class="miyuki-body-image-drop" data-body-editor-id="miyuki_news_body">
              <strong>本文に画像をドラッグ</strong>
              <span>アップロード後、この本文へ自動で挿入します。</span>
            </div>
            <?php
            wp_editor($data['body'], 'miyuki_news_body', [
              'textarea_name' => 'miyuki_news_body',
              'textarea_rows' => 10,
              'media_buttons' => true,
              'teeny'         => false,
              'quicktags'     => true,
              'editor_class'  => 'miyuki-news-body-editor',
            ]);
            ?>
          </div>
        </section>
      </div>

      <aside class="miyuki-easy-side">
        <div class="miyuki-easy-preview-card">
          <p class="miyuki-easy-preview-label">完成イメージ</p>
          <div class="miyuki-easy-preview-image">
            <?php echo $image_id ? wp_get_attachment_image($image_id, 'medium') : 'NO IMAGE'; ?>
          </div>
          <p class="miyuki-easy-preview-en">NEWS</p>
          <p class="miyuki-news-preview-date"><?php echo esc_html(mysql2date('Y.m.d', $data['date'])); ?></p>
          <h2><?php echo esc_html($data['title'] ?: 'お知らせタイトル'); ?></h2>
          <p><?php echo esc_html($data['excerpt'] ?: '一覧用の短い説明がここに表示されます。'); ?></p>
        </div>

        <div class="miyuki-easy-publish-card">
          <h2><?php echo $is_edit ? '更新' : '公開'; ?></h2>
          <p><?php echo $is_edit ? '公開後の内容も、このフォームから更新できます。' : '入力内容を確認してから公開してください。下書き保存もできます。'; ?></p>
          <button type="submit" name="miyuki_news_status" value="publish" class="button button-primary button-hero"><?php echo $is_edit ? '更新する' : '公開する'; ?></button>
          <button type="submit" name="miyuki_news_status" value="draft" class="button button-large">下書き保存</button>
          <?php if ($is_edit) : ?>
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_blank" rel="noopener">表示を確認</a>
          <?php endif; ?>
          <a href="<?php echo esc_url($standard_url); ?>">通常編集画面を使う</a>
        </div>
      </aside>
    </div>
  </form>
  <?php
}

function miyuki_normalize_news_date($date) {
  $date = preg_replace('/[^0-9-]/', '', (string) $date);
  if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $matches)) {
    return '';
  }

  if (!checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])) {
    return '';
  }

  return $date;
}

function miyuki_handle_news_easy_submit() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  if (!isset($_POST['miyuki_news_easy_nonce']) || !wp_verify_nonce($_POST['miyuki_news_easy_nonce'], 'miyuki_news_easy_submit')) {
    wp_die('不正な送信です。');
  }

  $post_id = isset($_POST['miyuki_news_id']) ? absint($_POST['miyuki_news_id']) : 0;
  $is_edit = $post_id && get_post_type($post_id) === 'news';

  if ($is_edit && !current_user_can('edit_post', $post_id)) {
    wp_die('このお知らせを編集する権限がありません。');
  }

  $title = isset($_POST['miyuki_news_title']) ? sanitize_text_field(wp_unslash($_POST['miyuki_news_title'])) : '';
  if ($title === '') {
    $redirect = $is_edit ? miyuki_news_easy_edit_url($post_id) : admin_url('edit.php?post_type=news&page=miyuki-news-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'title', $redirect));
    exit;
  }

  $date = isset($_POST['miyuki_news_date']) ? miyuki_normalize_news_date(wp_unslash($_POST['miyuki_news_date'])) : '';
  if ($date === '') {
    $redirect = $is_edit ? miyuki_news_easy_edit_url($post_id) : admin_url('edit.php?post_type=news&page=miyuki-news-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'date', $redirect));
    exit;
  }

  $excerpt   = isset($_POST['miyuki_news_excerpt']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_news_excerpt'])) : '';
  $body      = isset($_POST['miyuki_news_body']) ? wp_kses_post(wp_unslash($_POST['miyuki_news_body'])) : '';
  $image_id  = isset($_POST['miyuki_news_image_id']) ? absint($_POST['miyuki_news_image_id']) : 0;
  $is_pickup = !empty($_POST['miyuki_news_pickup']);
  $status    = (isset($_POST['miyuki_news_status']) && $_POST['miyuki_news_status'] === 'draft') ? 'draft' : 'publish';
  $time      = $is_edit ? mysql2date('H:i:s', get_post_field('post_date', $post_id)) : current_time('H:i:s');

  $post_data = [
    'post_type'    => 'news',
    'post_status'  => $status,
    'post_title'   => $title,
    'post_content' => $body,
    'post_excerpt' => $excerpt,
    'post_date'    => $date . ' ' . $time,
  ];

  if ($is_edit) {
    $post_data['ID'] = $post_id;
    $saved_id = wp_update_post($post_data, true);
  } else {
    $saved_id = wp_insert_post($post_data, true);
  }

  if (is_wp_error($saved_id)) {
    $redirect = $is_edit ? miyuki_news_easy_edit_url($post_id) : admin_url('edit.php?post_type=news&page=miyuki-news-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'save', $redirect));
    exit;
  }

  $post_id = absint($saved_id);
  miyuki_update_news_template_fields($post_id, $excerpt, $image_id, $is_pickup);

  $redirect_arg = $is_edit ? 'updated' : 'created';
  wp_safe_redirect(add_query_arg($redirect_arg, $post_id, miyuki_news_easy_edit_url($post_id)));
  exit;
}
add_action('admin_post_miyuki_news_easy_submit', 'miyuki_handle_news_easy_submit');

add_filter('post_row_actions', function($actions, $post) {
  if ($post->post_type !== 'news') {
    return $actions;
  }

  $actions = ['miyuki_easy_edit' => '<a href="' . esc_url(miyuki_news_easy_edit_url($post->ID)) . '">かんたん編集</a>'] + $actions;
  return $actions;
}, 10, 2);


/* ============================================================
   イベント情報 かんたん投稿・編集
   ============================================================ */
function miyuki_register_event_meta() {
  foreach (['event_date', 'event_location', 'event_type', 'event_capacity', 'event_time', 'event_note'] as $meta_key) {
    register_post_meta('event', $meta_key, [
      'type'              => 'string',
      'single'            => true,
      'show_in_rest'      => true,
      'sanitize_callback' => $meta_key === 'event_note' ? 'sanitize_textarea_field' : 'sanitize_text_field',
      'auth_callback'     => function() {
        return current_user_can('edit_posts');
      },
    ]);
  }

  register_post_meta('event', '_miyuki_event_image_id', [
    'type'              => 'integer',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'absint',
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);
}
add_action('init', 'miyuki_register_event_meta');

function miyuki_get_event_image_id($post_id = null) {
  if (!$post_id) {
    $post_id = get_the_ID();
  }

  $image_id = absint(get_post_meta($post_id, '_miyuki_event_image_id', true));
  if ($image_id) {
    return $image_id;
  }

  $thumbnail_id = get_post_thumbnail_id($post_id);
  return $thumbnail_id ? absint($thumbnail_id) : 0;
}

function miyuki_render_event_image($post_id = null, $size = 'medium', $attr = []) {
  $image_id = miyuki_get_event_image_id($post_id);
  if (!$image_id) {
    return '';
  }

  return wp_get_attachment_image($image_id, $size, false, $attr);
}

function miyuki_update_event_template_fields($post_id, $date, $location, $type, $capacity, $time, $note, $image_id) {
  foreach ([
    'event_date'     => $date,
    'event_location' => $location,
    'event_type'     => $type,
    'event_capacity' => $capacity,
    'event_time'     => $time,
    'event_note'     => $note,
  ] as $key => $value) {
    if ($value !== '') {
      update_post_meta($post_id, $key, $value);
    } else {
      delete_post_meta($post_id, $key);
    }
  }

  if ($image_id) {
    update_post_meta($post_id, '_miyuki_event_image_id', $image_id);
    set_post_thumbnail($post_id, $image_id);
  } else {
    delete_post_meta($post_id, '_miyuki_event_image_id');
    delete_post_thumbnail($post_id);
  }
}

function miyuki_add_event_easy_admin_page() {
  add_submenu_page(
    'edit.php?post_type=event',
    'イベント かんたん投稿',
    'かんたん投稿',
    'edit_posts',
    'miyuki-event-easy-new',
    'miyuki_render_event_easy_admin_page'
  );

  add_submenu_page(
    'edit.php?post_type=event',
    'イベント かんたん編集',
    'かんたん編集',
    'edit_posts',
    'miyuki-event-easy-list',
    'miyuki_render_event_easy_list_page'
  );

  remove_submenu_page('edit.php?post_type=event', 'post-new.php?post_type=event');
}
add_action('admin_menu', 'miyuki_add_event_easy_admin_page');

function miyuki_event_easy_edit_url($post_id) {
  return admin_url('edit.php?post_type=event&page=miyuki-event-easy-list&event_id=' . absint($post_id));
}

function miyuki_redirect_event_default_editor() {
  global $pagenow;

  if ($pagenow === 'post-new.php' && ($_GET['post_type'] ?? '') === 'event' && !isset($_GET['miyuki_standard'])) {
    wp_safe_redirect(admin_url('edit.php?post_type=event&page=miyuki-event-easy-new'));
    exit;
  }

  if ($pagenow !== 'post.php' || isset($_GET['miyuki_standard'])) {
    return;
  }

  $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
  if (!$post_id || get_post_type($post_id) !== 'event' || ($_GET['action'] ?? '') !== 'edit') {
    return;
  }

  wp_safe_redirect(miyuki_event_easy_edit_url($post_id));
  exit;
}
add_action('admin_init', 'miyuki_redirect_event_default_editor');

function miyuki_event_date_for_input($date) {
  $date = trim((string) $date);
  if ($date === '') {
    return '';
  }

  if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $matches) && checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])) {
    return $date;
  }

  if (preg_match('/^(\d{4})(\d{2})(\d{2})$/', $date, $matches) && checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])) {
    return sprintf('%04d-%02d-%02d', (int) $matches[1], (int) $matches[2], (int) $matches[3]);
  }

  $timestamp = strtotime($date);
  return $timestamp ? wp_date('Y-m-d', $timestamp) : '';
}

function miyuki_get_event_easy_data($post_id = 0) {
  $post = $post_id ? get_post($post_id) : null;
  if ($post && $post->post_type !== 'event') {
    $post = null;
  }

  return [
    'post_id'  => $post ? absint($post->ID) : 0,
    'title'    => $post ? $post->post_title : '',
    'body'     => $post ? $post->post_content : '',
    'excerpt'  => $post ? $post->post_excerpt : '',
    'status'   => $post ? $post->post_status : 'publish',
    'date'     => $post ? miyuki_event_date_for_input(get_post_meta($post->ID, 'event_date', true)) : current_time('Y-m-d'),
    'location' => $post ? get_post_meta($post->ID, 'event_location', true) : '',
    'type'     => $post ? get_post_meta($post->ID, 'event_type', true) : '',
    'capacity' => $post ? get_post_meta($post->ID, 'event_capacity', true) : '',
    'time'     => $post ? get_post_meta($post->ID, 'event_time', true) : '',
    'note'     => $post ? get_post_meta($post->ID, 'event_note', true) : '',
    'image_id' => $post ? miyuki_get_event_image_id($post->ID) : 0,
  ];
}

function miyuki_render_event_easy_notices() {
  $created_id = isset($_GET['created']) ? absint($_GET['created']) : 0;
  $updated_id = isset($_GET['updated']) ? absint($_GET['updated']) : 0;
  $error      = isset($_GET['miyuki_error']) ? sanitize_key($_GET['miyuki_error']) : '';

  if ($created_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>イベントを作成しました。<a href="<?php echo esc_url(get_permalink($created_id)); ?>" target="_blank" rel="noopener">表示を確認</a></p>
    </div>
  <?php endif;

  if ($updated_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>イベントを更新しました。<a href="<?php echo esc_url(get_permalink($updated_id)); ?>" target="_blank" rel="noopener">表示を確認</a></p>
    </div>
  <?php endif;

  if ($error === 'title') : ?>
    <div class="notice notice-error is-dismissible"><p>イベントタイトルを入力してください。</p></div>
  <?php elseif ($error === 'date') : ?>
    <div class="notice notice-error is-dismissible"><p>開催日を正しく入力してください。</p></div>
  <?php elseif ($error === 'save') : ?>
    <div class="notice notice-error is-dismissible"><p>保存できませんでした。入力内容を確認してください。</p></div>
  <?php endif;
}

function miyuki_render_event_easy_admin_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('イベント かんたん投稿', '開催日、場所、写真、本文を入れるだけでイベント情報を作成できます。', [
    ['label' => 'かんたん編集へ', 'url' => admin_url('edit.php?post_type=event&page=miyuki-event-easy-list'), 'primary' => true],
    ['label' => 'イベント一覧へ', 'url' => admin_url('edit.php?post_type=event')],
  ], 'EVENT EDIT FORM');
  miyuki_render_event_easy_notices();
  miyuki_render_event_easy_form(miyuki_get_event_easy_data(), 'new');
  echo '</div>';
}

function miyuki_render_event_easy_edit_page() {
  $post_id = isset($_GET['event_id']) ? absint($_GET['event_id']) : 0;

  if (!$post_id || get_post_type($post_id) !== 'event' || !current_user_can('edit_post', $post_id)) {
    wp_die('編集するイベントが見つかりません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('イベント かんたん編集', '公開後のイベントも、同じフォームで画像と内容を見ながら編集できます。', [
    ['label' => 'かんたん編集一覧へ', 'url' => admin_url('edit.php?post_type=event&page=miyuki-event-easy-list'), 'primary' => true],
    ['label' => '表示を確認', 'url' => get_permalink($post_id)],
  ], 'EVENT EDIT FORM');
  miyuki_render_event_easy_notices();
  miyuki_render_event_easy_form(miyuki_get_event_easy_data($post_id), 'edit');
  echo '</div>';
}

function miyuki_render_event_easy_list_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  if (!empty($_GET['event_id'])) {
    miyuki_render_event_easy_edit_page();
    return;
  }

  $event_query = new WP_Query([
    'post_type'      => 'event',
    'post_status'    => ['publish', 'draft', 'pending', 'private'],
    'posts_per_page' => 80,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('イベント かんたん編集', '編集したいイベントを選ぶと、視覚的な編集フォームで開きます。', [
    ['label' => '新しく投稿する', 'url' => admin_url('edit.php?post_type=event&page=miyuki-event-easy-new'), 'primary' => true],
    ['label' => '通常一覧へ', 'url' => admin_url('edit.php?post_type=event')],
  ], 'EVENT EDIT FORM');
  miyuki_render_event_easy_notices();

  if ($event_query->have_posts()) : ?>
    <div class="miyuki-easy-edit-grid">
      <?php while ($event_query->have_posts()) : $event_query->the_post(); ?>
        <?php
        $post_id = get_the_ID();
        $image   = miyuki_render_event_image($post_id, 'medium', ['loading' => 'lazy']);
        $status  = get_post_status($post_id);
        $date    = get_post_meta($post_id, 'event_date', true);
        $type    = get_post_meta($post_id, 'event_type', true);
        ?>
        <article class="miyuki-easy-edit-card">
          <a class="miyuki-easy-edit-thumb" href="<?php echo esc_url(miyuki_event_easy_edit_url($post_id)); ?>">
            <?php echo $image ?: '<span>NO IMAGE</span>'; ?>
          </a>
          <div class="miyuki-easy-edit-body">
            <span class="miyuki-easy-status miyuki-easy-status-<?php echo esc_attr($status); ?>"><?php echo esc_html($status === 'publish' ? '公開中' : '下書き'); ?></span>
            <h2><?php the_title(); ?></h2>
            <p><?php echo esc_html(trim(miyuki_format_event_date_label($date) . ($type ? ' / ' . $type : ''))); ?></p>
            <div class="miyuki-easy-edit-actions">
              <a class="button button-primary" href="<?php echo esc_url(miyuki_event_easy_edit_url($post_id)); ?>">かんたん編集</a>
              <a class="button" href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_blank" rel="noopener">表示</a>
            </div>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <div class="miyuki-easy-empty-list">
      <p>イベントはまだありません。</p>
      <a class="button button-primary" href="<?php echo esc_url(admin_url('edit.php?post_type=event&page=miyuki-event-easy-new')); ?>">最初のイベントを作成</a>
    </div>
  <?php endif;

  echo '</div>';
}

function miyuki_format_event_date_label($date) {
  $date = miyuki_event_date_for_input($date);
  if (!$date) {
    return '';
  }

  $timestamp = strtotime($date);
  if (!$timestamp) {
    return '';
  }

  return wp_date('Y年n月j日', $timestamp);
}

function miyuki_render_event_easy_form($data, $mode = 'new') {
  $post_id      = absint($data['post_id']);
  $image_id     = absint($data['image_id']);
  $is_edit      = $mode === 'edit' && $post_id;
  $standard_url = $is_edit ? admin_url('post.php?post=' . $post_id . '&action=edit&miyuki_standard=1') : admin_url('post-new.php?post_type=event&miyuki_standard=1');
  $date_label   = miyuki_format_event_date_label($data['date']);
  ?>
  <form class="miyuki-works-easy-form miyuki-event-easy-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <?php wp_nonce_field('miyuki_event_easy_submit', 'miyuki_event_easy_nonce'); ?>
    <input type="hidden" name="action" value="miyuki_event_easy_submit">
    <input type="hidden" name="miyuki_event_id" value="<?php echo esc_attr($post_id); ?>">

    <div class="miyuki-easy-layout">
      <div class="miyuki-easy-main">
        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>1</span>
            <div>
              <h2>基本情報</h2>
              <p>イベント一覧と詳細ページに表示される情報です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_event_title">イベントタイトル</label>
            <input type="text" id="miyuki_event_title" name="miyuki_event_title" required value="<?php echo esc_attr($data['title']); ?>" placeholder="例：完成内覧会のご案内｜広島市東区モデルハウス">
          </div>

          <div class="miyuki-easy-grid-2">
            <div class="miyuki-works-field">
              <label for="miyuki_event_type">イベント種別</label>
              <input type="text" id="miyuki_event_type" name="miyuki_event_type" value="<?php echo esc_attr($data['type']); ?>" placeholder="例：完成見学会 / 相談会">
            </div>

            <div class="miyuki-works-field">
              <label for="miyuki_event_date">開催日</label>
              <input type="date" id="miyuki_event_date" name="miyuki_event_date" required value="<?php echo esc_attr($data['date']); ?>">
            </div>
          </div>

          <div class="miyuki-easy-grid-2">
            <div class="miyuki-works-field">
              <label for="miyuki_event_time">開催時間</label>
              <input type="text" id="miyuki_event_time" name="miyuki_event_time" value="<?php echo esc_attr($data['time']); ?>" placeholder="例：10:00〜16:00">
            </div>

            <div class="miyuki-works-field">
              <label for="miyuki_event_location">開催場所</label>
              <input type="text" id="miyuki_event_location" name="miyuki_event_location" value="<?php echo esc_attr($data['location']); ?>" placeholder="例：広島市東区曙5丁目4-6">
            </div>
          </div>

          <div class="miyuki-easy-grid-2">
            <div class="miyuki-works-field">
              <label for="miyuki_event_capacity">定員・参加条件</label>
              <input type="text" id="miyuki_event_capacity" name="miyuki_event_capacity" value="<?php echo esc_attr($data['capacity']); ?>" placeholder="例：予約不要・入場無料">
            </div>

            <div class="miyuki-works-field">
              <label for="miyuki_event_note">備考</label>
              <textarea id="miyuki_event_note" name="miyuki_event_note" rows="3" placeholder="例：お車でお越しの方は近隣のコインパーキングをご利用ください。"><?php echo esc_textarea($data['note']); ?></textarea>
            </div>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>2</span>
            <div>
              <h2>メイン画像</h2>
              <p>一覧カードと詳細ページの一番大きな写真になります。大きい画像は自動で軽量化します。</p>
            </div>
          </div>

          <input type="hidden" class="miyuki-main-image-input" name="miyuki_event_image_id" value="<?php echo esc_attr($image_id); ?>">
          <div class="miyuki-easy-main-drop miyuki-main-image-preview" data-drop-target="main">
            <?php if ($image_id) : ?>
              <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
            <?php else : ?>
              <div class="miyuki-easy-empty">
                <strong>ここに画像をドラッグ</strong>
                <span>大きい画像も自動で軽くしてアップします。</span>
              </div>
            <?php endif; ?>
          </div>
          <div class="miyuki-works-actions">
            <button type="button" class="button button-primary miyuki-main-image-select">画像を選択・アップロード</button>
            <button type="button" class="button miyuki-main-image-remove">削除</button>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>3</span>
            <div>
              <h2>本文</h2>
              <p>一覧用の短い説明と、詳細ページに表示する本文です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_event_excerpt">一覧用の短い説明</label>
            <textarea id="miyuki_event_excerpt" name="miyuki_event_excerpt" rows="4" placeholder="例：広島市東区に完成した新築住宅の内覧会を開催いたします。"><?php echo esc_textarea($data['excerpt']); ?></textarea>
          </div>

          <div class="miyuki-works-field miyuki-news-editor-field">
            <label for="miyuki_event_body">詳しい本文</label>
            <p class="description">イベント詳細ページに表示されます。画像は本文エリアへドラッグ&ドロップ、または「メディアを追加」から挿入できます。</p>
            <div class="miyuki-body-image-drop" data-body-editor-id="miyuki_event_body">
              <strong>本文に画像をドラッグ</strong>
              <span>アップロード後、この本文へ自動で挿入します。</span>
            </div>
            <?php
            wp_editor($data['body'], 'miyuki_event_body', [
              'textarea_name' => 'miyuki_event_body',
              'textarea_rows' => 10,
              'media_buttons' => true,
              'teeny'         => false,
              'quicktags'     => true,
              'editor_class'  => 'miyuki-event-body-editor',
            ]);
            ?>
          </div>
        </section>
      </div>

      <aside class="miyuki-easy-side">
        <div class="miyuki-easy-preview-card">
          <p class="miyuki-easy-preview-label">完成イメージ</p>
          <div class="miyuki-easy-preview-image">
            <?php echo $image_id ? wp_get_attachment_image($image_id, 'medium') : 'NO IMAGE'; ?>
          </div>
          <p class="miyuki-easy-preview-en">EVENT</p>
          <p class="miyuki-news-preview-date"><?php echo esc_html($date_label ?: '開催日'); ?></p>
          <h2><?php echo esc_html($data['title'] ?: 'イベントタイトル'); ?></h2>
          <p><?php echo esc_html($data['excerpt'] ?: '一覧用の短い説明がここに表示されます。'); ?></p>
        </div>

        <div class="miyuki-easy-publish-card">
          <h2><?php echo $is_edit ? '更新' : '公開'; ?></h2>
          <p><?php echo $is_edit ? '公開後の内容も、このフォームから更新できます。' : '入力内容を確認してから公開してください。下書き保存もできます。'; ?></p>
          <button type="submit" name="miyuki_event_status" value="publish" class="button button-primary button-hero"><?php echo $is_edit ? '更新する' : '公開する'; ?></button>
          <button type="submit" name="miyuki_event_status" value="draft" class="button button-large">下書き保存</button>
          <?php if ($is_edit) : ?>
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_blank" rel="noopener">表示を確認</a>
          <?php endif; ?>
          <a href="<?php echo esc_url($standard_url); ?>">通常編集画面を使う</a>
        </div>
      </aside>
    </div>
  </form>
  <?php
}

function miyuki_normalize_event_date($date) {
  $date = preg_replace('/[^0-9-]/', '', (string) $date);
  if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $matches)) {
    return '';
  }

  if (!checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])) {
    return '';
  }

  return $date;
}

function miyuki_handle_event_easy_submit() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  if (!isset($_POST['miyuki_event_easy_nonce']) || !wp_verify_nonce($_POST['miyuki_event_easy_nonce'], 'miyuki_event_easy_submit')) {
    wp_die('不正な送信です。');
  }

  $post_id = isset($_POST['miyuki_event_id']) ? absint($_POST['miyuki_event_id']) : 0;
  $is_edit = $post_id && get_post_type($post_id) === 'event';

  if ($is_edit && !current_user_can('edit_post', $post_id)) {
    wp_die('このイベントを編集する権限がありません。');
  }

  $title = isset($_POST['miyuki_event_title']) ? sanitize_text_field(wp_unslash($_POST['miyuki_event_title'])) : '';
  if ($title === '') {
    $redirect = $is_edit ? miyuki_event_easy_edit_url($post_id) : admin_url('edit.php?post_type=event&page=miyuki-event-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'title', $redirect));
    exit;
  }

  $date = isset($_POST['miyuki_event_date']) ? miyuki_normalize_event_date(wp_unslash($_POST['miyuki_event_date'])) : '';
  if ($date === '') {
    $redirect = $is_edit ? miyuki_event_easy_edit_url($post_id) : admin_url('edit.php?post_type=event&page=miyuki-event-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'date', $redirect));
    exit;
  }

  $type      = isset($_POST['miyuki_event_type']) ? sanitize_text_field(wp_unslash($_POST['miyuki_event_type'])) : '';
  $time      = isset($_POST['miyuki_event_time']) ? sanitize_text_field(wp_unslash($_POST['miyuki_event_time'])) : '';
  $location  = isset($_POST['miyuki_event_location']) ? sanitize_text_field(wp_unslash($_POST['miyuki_event_location'])) : '';
  $capacity  = isset($_POST['miyuki_event_capacity']) ? sanitize_text_field(wp_unslash($_POST['miyuki_event_capacity'])) : '';
  $note      = isset($_POST['miyuki_event_note']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_event_note'])) : '';
  $excerpt   = isset($_POST['miyuki_event_excerpt']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_event_excerpt'])) : '';
  $body      = isset($_POST['miyuki_event_body']) ? wp_kses_post(wp_unslash($_POST['miyuki_event_body'])) : '';
  $image_id  = isset($_POST['miyuki_event_image_id']) ? absint($_POST['miyuki_event_image_id']) : 0;
  $status    = (isset($_POST['miyuki_event_status']) && $_POST['miyuki_event_status'] === 'draft') ? 'draft' : 'publish';

  $post_data = [
    'post_type'    => 'event',
    'post_status'  => $status,
    'post_title'   => $title,
    'post_content' => $body,
    'post_excerpt' => $excerpt,
  ];

  if ($is_edit) {
    $post_data['ID'] = $post_id;
    $saved_id = wp_update_post($post_data, true);
  } else {
    $saved_id = wp_insert_post($post_data, true);
  }

  if (is_wp_error($saved_id)) {
    $redirect = $is_edit ? miyuki_event_easy_edit_url($post_id) : admin_url('edit.php?post_type=event&page=miyuki-event-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'save', $redirect));
    exit;
  }

  $post_id = absint($saved_id);
  miyuki_update_event_template_fields($post_id, $date, $location, $type, $capacity, $time, $note, $image_id);

  $redirect_arg = $is_edit ? 'updated' : 'created';
  wp_safe_redirect(add_query_arg($redirect_arg, $post_id, miyuki_event_easy_edit_url($post_id)));
  exit;
}
add_action('admin_post_miyuki_event_easy_submit', 'miyuki_handle_event_easy_submit');

add_filter('post_row_actions', function($actions, $post) {
  if ($post->post_type !== 'event') {
    return $actions;
  }

  $actions = ['miyuki_easy_edit' => '<a href="' . esc_url(miyuki_event_easy_edit_url($post->ID)) . '">かんたん編集</a>'] + $actions;
  return $actions;
}, 10, 2);


/* ============================================================
   お客様の声 かんたん投稿・編集
   ============================================================ */
function miyuki_voice_category_options() {
  return [
    '新築',
    'リフォーム',
    '店舗・事務所',
    'メンテナンス',
    'その他',
  ];
}

function miyuki_voice_question_labels() {
  return [
    'problem' => 'ご依頼前に悩んでいたこと',
    'reason'  => 'ミユキハウジングを選んだ理由',
    'good'    => '打ち合わせ・工事中で安心できたこと',
    'after'   => '完成後の暮らしの変化',
  ];
}

function miyuki_voice_question_label_meta_key($key) {
  return 'voice_' . sanitize_key($key) . '_label';
}

function miyuki_voice_question_image_meta_key($key) {
  return '_miyuki_voice_' . sanitize_key($key) . '_image_id';
}

function miyuki_voice_question_images_meta_key($key) {
  return '_miyuki_voice_' . sanitize_key($key) . '_image_ids';
}

function miyuki_get_voice_question_label($post_id, $key) {
  $labels = miyuki_voice_question_labels();
  $custom_label = get_post_meta($post_id, miyuki_voice_question_label_meta_key($key), true);

  return $custom_label !== '' ? $custom_label : ($labels[$key] ?? '');
}

function miyuki_parse_voice_image_ids($value) {
  if (is_array($value)) {
    $ids = $value;
  } else {
    $ids = explode(',', (string) $value);
  }

  return array_values(array_unique(array_filter(array_map('absint', $ids))));
}

function miyuki_get_voice_question_image_ids($post_id, $key) {
  $image_ids = miyuki_parse_voice_image_ids(get_post_meta($post_id, miyuki_voice_question_images_meta_key($key), true));
  if (!empty($image_ids)) {
    return $image_ids;
  }

  $legacy_image_id = absint(get_post_meta($post_id, miyuki_voice_question_image_meta_key($key), true));
  return $legacy_image_id ? [$legacy_image_id] : [];
}

function miyuki_get_voice_question_image_id($post_id, $key) {
  $image_ids = miyuki_get_voice_question_image_ids($post_id, $key);
  return $image_ids[0] ?? 0;
}

function miyuki_get_voice_gallery_ids($post_id = null) {
  if (!$post_id) {
    $post_id = get_the_ID();
  }

  $gallery = get_post_meta($post_id, '_miyuki_voice_gallery_ids', true);
  if (!$gallery) {
    return [];
  }

  if (is_array($gallery)) {
    $ids = $gallery;
  } else {
    $ids = explode(',', $gallery);
  }

  return array_values(array_filter(array_map('absint', $ids)));
}

function miyuki_get_voice_question_items($post_id) {
  $items = [];

  foreach (miyuki_voice_question_labels() as $key => $default_label) {
    $answer = get_post_meta($post_id, 'voice_' . $key, true);
    $image_ids = miyuki_get_voice_question_image_ids($post_id, $key);

    if ($answer === '' && empty($image_ids)) {
      continue;
    }

    $items[$key] = [
      'label'     => miyuki_get_voice_question_label($post_id, $key) ?: $default_label,
      'answer'    => $answer,
      'image_ids' => $image_ids,
      'image_id'  => $image_ids[0] ?? 0,
    ];
  }

  return $items;
}

function miyuki_register_voice_meta() {
  $meta_keys = [
    'customer_name'     => 'sanitize_text_field',
    'customer_area'     => 'sanitize_text_field',
    'customer_category' => 'sanitize_text_field',
    'customer_quote'    => 'sanitize_textarea_field',
    'voice_problem'     => 'sanitize_textarea_field',
    'voice_reason'      => 'sanitize_textarea_field',
    'voice_good'        => 'sanitize_textarea_field',
    'voice_after'       => 'sanitize_textarea_field',
  ];

  foreach (miyuki_voice_question_labels() as $key => $label) {
    $meta_keys[miyuki_voice_question_label_meta_key($key)] = 'sanitize_text_field';
  }

  foreach ($meta_keys as $meta_key => $sanitize_callback) {
    register_post_meta('voice', $meta_key, [
      'type'              => 'string',
      'single'            => true,
      'show_in_rest'      => true,
      'sanitize_callback' => $sanitize_callback,
      'auth_callback'     => function() {
        return current_user_can('edit_posts');
      },
    ]);
  }

  register_post_meta('voice', '_miyuki_voice_gallery_ids', [
    'type'              => 'string',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'sanitize_text_field',
    'auth_callback'     => function() {
      return current_user_can('edit_posts');
    },
  ]);

  foreach (array_keys(miyuki_voice_question_labels()) as $key) {
    register_post_meta('voice', miyuki_voice_question_images_meta_key($key), [
      'type'              => 'string',
      'single'            => true,
      'show_in_rest'      => true,
      'sanitize_callback' => 'sanitize_text_field',
      'auth_callback'     => function() {
        return current_user_can('edit_posts');
      },
    ]);
  }

  $image_meta_keys = ['_miyuki_voice_image_id', '_miyuki_voice_related_work_id'];
  foreach (array_keys(miyuki_voice_question_labels()) as $key) {
    $image_meta_keys[] = miyuki_voice_question_image_meta_key($key);
  }

  foreach ($image_meta_keys as $meta_key) {
    register_post_meta('voice', $meta_key, [
      'type'              => 'integer',
      'single'            => true,
      'show_in_rest'      => true,
      'sanitize_callback' => 'absint',
      'auth_callback'     => function() {
        return current_user_can('edit_posts');
      },
    ]);
  }
}
add_action('init', 'miyuki_register_voice_meta');

function miyuki_get_voice_image_id($post_id = null) {
  if (!$post_id) {
    $post_id = get_the_ID();
  }

  $image_id = absint(get_post_meta($post_id, '_miyuki_voice_image_id', true));
  if ($image_id) {
    return $image_id;
  }

  $thumbnail_id = get_post_thumbnail_id($post_id);
  return $thumbnail_id ? absint($thumbnail_id) : 0;
}

function miyuki_render_voice_image($post_id = null, $size = 'large', $attr = []) {
  $image_id = miyuki_get_voice_image_id($post_id);
  if (!$image_id) {
    return '';
  }

  return wp_get_attachment_image($image_id, $size, false, $attr);
}

function miyuki_voice_placeholder_image($alt = 'No Image') {
  return '<img src="' . esc_url(get_stylesheet_directory_uri() . '/assets/images/no-image.svg') . '" alt="' . esc_attr($alt) . '" loading="lazy">';
}

function miyuki_voice_status_label($status) {
  $labels = [
    'publish' => '公開中',
    'private' => '非公開',
    'draft'   => '下書き',
    'pending' => '確認待ち',
    'future'  => '予約済み',
  ];

  return $labels[$status] ?? $status;
}

function miyuki_get_next_voice_menu_order() {
  global $wpdb;

  $max_order = (int) $wpdb->get_var(
    "SELECT MAX(menu_order) FROM {$wpdb->posts} WHERE post_type = 'voice' AND post_status NOT IN ('trash', 'auto-draft')"
  );

  return $max_order + 10;
}

function miyuki_voice_easy_edit_url($post_id) {
  return admin_url('edit.php?post_type=voice&page=miyuki-voice-easy-list&voice_id=' . absint($post_id));
}

function miyuki_voice_build_content($data) {
  $parts = [];

  if (!empty($data['quote'])) {
    $parts[] = '<p>' . esc_html($data['quote']) . '</p>';
  }

  foreach (miyuki_voice_question_labels() as $key => $label) {
    if (empty($data[$key])) {
      continue;
    }

    $question_label = !empty($data[$key . '_label']) ? $data[$key . '_label'] : $label;
    $parts[] = '<h2>' . esc_html($question_label) . '</h2>' . "\n" . '<p>' . nl2br(esc_html($data[$key])) . '</p>';
  }

  return implode("\n\n", $parts);
}

function miyuki_update_voice_template_fields($post_id, $data) {
  foreach ([
    'customer_name'     => $data['customer_name'],
    'customer_area'     => $data['customer_area'],
    'customer_category' => $data['category'],
    'customer_quote'    => $data['quote'],
    'voice_problem'     => $data['problem'],
    'voice_reason'      => $data['reason'],
    'voice_good'        => $data['good'],
    'voice_after'       => $data['after'],
  ] as $key => $value) {
    if ($value !== '') {
      update_post_meta($post_id, $key, $value);
    } else {
      delete_post_meta($post_id, $key);
    }
  }

  foreach (miyuki_voice_question_labels() as $key => $default_label) {
    $label = $data[$key . '_label'] ?? '';
    if ($label !== '' && $label !== $default_label) {
      update_post_meta($post_id, miyuki_voice_question_label_meta_key($key), $label);
    } else {
      delete_post_meta($post_id, miyuki_voice_question_label_meta_key($key));
    }

    $question_image_ids = miyuki_parse_voice_image_ids($data[$key . '_image_ids_raw'] ?? ($data[$key . '_image_id'] ?? ''));
    if (!empty($question_image_ids)) {
      update_post_meta($post_id, miyuki_voice_question_images_meta_key($key), implode(',', $question_image_ids));
      update_post_meta($post_id, miyuki_voice_question_image_meta_key($key), $question_image_ids[0]);
    } else {
      delete_post_meta($post_id, miyuki_voice_question_images_meta_key($key));
      delete_post_meta($post_id, miyuki_voice_question_image_meta_key($key));
    }
  }

  delete_post_meta($post_id, 'voice_message');

  $image_id = absint($data['image_id']);
  if ($image_id) {
    update_post_meta($post_id, '_miyuki_voice_image_id', $image_id);
    set_post_thumbnail($post_id, $image_id);
  } else {
    delete_post_meta($post_id, '_miyuki_voice_image_id');
    delete_post_thumbnail($post_id);
  }

  $related_work_id = absint($data['related_work_id']);
  if ($related_work_id && get_post_type($related_work_id) === 'works') {
    update_post_meta($post_id, '_miyuki_voice_related_work_id', $related_work_id);
  } else {
    delete_post_meta($post_id, '_miyuki_voice_related_work_id');
  }

  $gallery_ids = miyuki_parse_voice_image_ids($data['gallery_raw'] ?? '');
  if (!empty($gallery_ids)) {
    update_post_meta($post_id, '_miyuki_voice_gallery_ids', implode(',', $gallery_ids));
  } else {
    delete_post_meta($post_id, '_miyuki_voice_gallery_ids');
  }
}

function miyuki_add_voice_easy_admin_page() {
  add_submenu_page(
    'edit.php?post_type=voice',
    'お客様の声 かんたん投稿',
    'かんたん投稿',
    'edit_posts',
    'miyuki-voice-easy-new',
    'miyuki_render_voice_easy_admin_page'
  );

  add_submenu_page(
    'edit.php?post_type=voice',
    'お客様の声 かんたん編集',
    'かんたん編集',
    'edit_posts',
    'miyuki-voice-easy-list',
    'miyuki_render_voice_easy_list_page'
  );

  remove_submenu_page('edit.php?post_type=voice', 'post-new.php?post_type=voice');
}
add_action('admin_menu', 'miyuki_add_voice_easy_admin_page');

function miyuki_redirect_voice_default_editor() {
  global $pagenow;

  if ($pagenow === 'post-new.php' && ($_GET['post_type'] ?? '') === 'voice' && !isset($_GET['miyuki_standard'])) {
    wp_safe_redirect(admin_url('edit.php?post_type=voice&page=miyuki-voice-easy-new'));
    exit;
  }

  if ($pagenow !== 'post.php' || isset($_GET['miyuki_standard'])) {
    return;
  }

  $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
  if (!$post_id || get_post_type($post_id) !== 'voice' || ($_GET['action'] ?? '') !== 'edit') {
    return;
  }

  wp_safe_redirect(miyuki_voice_easy_edit_url($post_id));
  exit;
}
add_action('admin_init', 'miyuki_redirect_voice_default_editor');

function miyuki_get_voice_easy_data($post_id = 0) {
  $post = $post_id ? get_post($post_id) : null;
  if ($post && $post->post_type !== 'voice') {
    $post = null;
  }

  $data = [
    'post_id'         => $post ? absint($post->ID) : 0,
    'title'           => $post ? $post->post_title : '',
    'status'          => $post ? $post->post_status : 'publish',
    'order'           => $post ? (int) get_post_field('menu_order', $post->ID) : miyuki_get_next_voice_menu_order(),
    'customer_name'   => $post ? get_post_meta($post->ID, 'customer_name', true) : '',
    'customer_area'   => $post ? get_post_meta($post->ID, 'customer_area', true) : '',
    'category'        => $post ? get_post_meta($post->ID, 'customer_category', true) : '',
    'quote'           => $post ? get_post_meta($post->ID, 'customer_quote', true) : '',
    'problem'         => $post ? get_post_meta($post->ID, 'voice_problem', true) : '',
    'reason'          => $post ? get_post_meta($post->ID, 'voice_reason', true) : '',
    'good'            => $post ? get_post_meta($post->ID, 'voice_good', true) : '',
    'after'           => $post ? get_post_meta($post->ID, 'voice_after', true) : '',
    'image_id'        => $post ? miyuki_get_voice_image_id($post->ID) : 0,
    'gallery_ids'     => $post ? miyuki_get_voice_gallery_ids($post->ID) : [],
    'related_work_id' => $post ? absint(get_post_meta($post->ID, '_miyuki_voice_related_work_id', true)) : 0,
  ];

  foreach (miyuki_voice_question_labels() as $key => $default_label) {
    $data[$key . '_label'] = $post ? miyuki_get_voice_question_label($post->ID, $key) : $default_label;
    $data[$key . '_image_id'] = $post ? miyuki_get_voice_question_image_id($post->ID, $key) : 0;
    $data[$key . '_image_ids'] = $post ? miyuki_get_voice_question_image_ids($post->ID, $key) : [];
  }

  return $data;
}

function miyuki_render_voice_easy_notices() {
  $created_id = isset($_GET['created']) ? absint($_GET['created']) : 0;
  $updated_id = isset($_GET['updated']) ? absint($_GET['updated']) : 0;
  $error      = isset($_GET['miyuki_error']) ? sanitize_key($_GET['miyuki_error']) : '';
  $survey_message = isset($_GET['miyuki_survey_message']) ? sanitize_key($_GET['miyuki_survey_message']) : '';

  if ($created_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>お客様の声を作成しました。<a href="<?php echo esc_url(get_permalink($created_id)); ?>" target="_blank" rel="noopener">表示を確認</a></p>
    </div>
  <?php endif;

  if ($updated_id) : ?>
    <div class="notice notice-success is-dismissible">
      <p>お客様の声を更新しました。<a href="<?php echo esc_url(get_permalink($updated_id)); ?>" target="_blank" rel="noopener">表示を確認</a></p>
    </div>
  <?php endif;

  if ($survey_message === 'converted') : ?>
    <div class="notice notice-success is-dismissible"><p>アンケート回答から「お客様の声」の下書きを作成しました。内容を確認して保存してください。</p></div>
  <?php endif;

  if ($error === 'title') : ?>
    <div class="notice notice-error is-dismissible"><p>タイトルを入力してください。</p></div>
  <?php elseif ($error === 'save') : ?>
    <div class="notice notice-error is-dismissible"><p>保存できませんでした。入力内容を確認してください。</p></div>
  <?php endif;
}

function miyuki_render_voice_easy_admin_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('お客様の声 かんたん投稿', '写真、一言コメント、質問への回答を入れるだけでお客様の声ページを作成できます。', [
    ['label' => 'かんたん編集へ', 'url' => admin_url('edit.php?post_type=voice&page=miyuki-voice-easy-list'), 'primary' => true],
    ['label' => 'お客様の声一覧へ', 'url' => admin_url('edit.php?post_type=voice')],
  ], 'VOICE EDIT FORM');
  miyuki_render_voice_easy_notices();
  miyuki_render_voice_easy_form(miyuki_get_voice_easy_data(), 'new');
  echo '</div>';
}

function miyuki_render_voice_easy_edit_page() {
  $post_id = isset($_GET['voice_id']) ? absint($_GET['voice_id']) : 0;

  if (!$post_id || get_post_type($post_id) !== 'voice' || !current_user_can('edit_post', $post_id)) {
    wp_die('編集するお客様の声が見つかりません。');
  }

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('お客様の声 かんたん編集', '公開後のお客様の声も、同じフォームで写真と文章を見ながら編集できます。', [
    ['label' => 'かんたん編集一覧へ', 'url' => admin_url('edit.php?post_type=voice&page=miyuki-voice-easy-list'), 'primary' => true],
    ['label' => '表示を確認', 'url' => get_permalink($post_id)],
  ], 'VOICE EDIT FORM');
  miyuki_render_voice_easy_notices();
  miyuki_render_voice_easy_form(miyuki_get_voice_easy_data($post_id), 'edit');
  echo '</div>';
}

function miyuki_render_voice_easy_list_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  if (!empty($_GET['voice_id'])) {
    miyuki_render_voice_easy_edit_page();
    return;
  }

  $voice_query = new WP_Query([
    'post_type'      => 'voice',
    'post_status'    => ['publish', 'draft', 'pending', 'private'],
    'posts_per_page' => 80,
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
    'order'          => 'ASC',
  ]);

  echo '<div class="wrap miyuki-works-easy-page">';
  miyuki_render_works_easy_header('お客様の声 かんたん編集', '編集したいお客様の声を選ぶと、視覚的な編集フォームで開きます。', [
    ['label' => '新しく投稿する', 'url' => admin_url('edit.php?post_type=voice&page=miyuki-voice-easy-new'), 'primary' => true],
    ['label' => '通常一覧へ', 'url' => admin_url('edit.php?post_type=voice')],
  ], 'VOICE EDIT FORM');
  miyuki_render_voice_easy_notices();

  if ($voice_query->have_posts()) : ?>
    <div class="miyuki-easy-edit-grid">
      <?php while ($voice_query->have_posts()) : $voice_query->the_post(); ?>
        <?php
        $post_id  = get_the_ID();
        $image    = miyuki_render_voice_image($post_id, 'medium', ['loading' => 'lazy']);
        $status   = get_post_status($post_id);
        $category = get_post_meta($post_id, 'customer_category', true);
        $name     = get_post_meta($post_id, 'customer_name', true);
        ?>
        <article class="miyuki-easy-edit-card">
          <a class="miyuki-easy-edit-thumb" href="<?php echo esc_url(miyuki_voice_easy_edit_url($post_id)); ?>">
            <?php echo $image ?: miyuki_voice_placeholder_image(get_the_title()); ?>
          </a>
          <div class="miyuki-easy-edit-body">
            <span class="miyuki-easy-status miyuki-easy-status-<?php echo esc_attr($status); ?>"><?php echo esc_html(miyuki_voice_status_label($status)); ?></span>
            <h2><?php the_title(); ?></h2>
            <p><?php echo esc_html(trim(($category ?: 'カテゴリ未設定') . ($name ? ' / ' . $name : ''))); ?></p>
            <div class="miyuki-easy-edit-actions">
              <a class="button button-primary" href="<?php echo esc_url(miyuki_voice_easy_edit_url($post_id)); ?>">かんたん編集</a>
              <a class="button" href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_blank" rel="noopener">表示</a>
            </div>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <div class="miyuki-easy-empty-list">
      <p>お客様の声はまだありません。</p>
      <a class="button button-primary" href="<?php echo esc_url(admin_url('edit.php?post_type=voice&page=miyuki-voice-easy-new')); ?>">最初のお客様の声を作成</a>
    </div>
  <?php endif;

  echo '</div>';
}

function miyuki_get_voice_related_works_options() {
  return get_posts([
    'post_type'      => 'works',
    'post_status'    => ['publish', 'draft', 'private'],
    'posts_per_page' => 100,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);
}

function miyuki_render_voice_easy_form($data, $mode = 'new') {
  $post_id      = absint($data['post_id']);
  $image_id     = absint($data['image_id']);
  $gallery_ids  = array_map('absint', $data['gallery_ids'] ?? []);
  $is_edit      = $mode === 'edit' && $post_id;
  $standard_url = $is_edit ? admin_url('post.php?post=' . $post_id . '&action=edit&miyuki_standard=1') : admin_url('post-new.php?post_type=voice&miyuki_standard=1');
  $status       = in_array($data['status'], ['publish', 'private', 'draft'], true) ? $data['status'] : 'publish';
  $related_works = miyuki_get_voice_related_works_options();
  ?>
  <form class="miyuki-works-easy-form miyuki-voice-easy-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <?php wp_nonce_field('miyuki_voice_easy_submit', 'miyuki_voice_easy_nonce'); ?>
    <input type="hidden" name="action" value="miyuki_voice_easy_submit">
    <input type="hidden" name="miyuki_voice_id" value="<?php echo esc_attr($post_id); ?>">

    <div class="miyuki-easy-layout">
      <div class="miyuki-easy-main">
        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>1</span>
            <div>
              <h2>基本情報</h2>
              <p>一覧カードと詳細ページの上部に表示される内容です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_voice_title">タイトル</label>
            <input type="text" id="miyuki_voice_title" name="miyuki_voice_title" required value="<?php echo esc_attr($data['title']); ?>" placeholder="例：相談しやすく、安心して任せられました">
          </div>

          <div class="miyuki-easy-grid-2">
            <div class="miyuki-works-field">
              <label for="miyuki_voice_customer_name">お客様名・イニシャル</label>
              <input type="text" id="miyuki_voice_customer_name" name="miyuki_voice_customer_name" value="<?php echo esc_attr($data['customer_name']); ?>" placeholder="例：K様 / 広島市東区 K様">
            </div>

            <div class="miyuki-works-field">
              <label for="miyuki_voice_area">エリア</label>
              <input type="text" id="miyuki_voice_area" name="miyuki_voice_area" value="<?php echo esc_attr($data['customer_area']); ?>" placeholder="例：広島市東区">
            </div>
          </div>

          <div class="miyuki-easy-grid-2">
            <div class="miyuki-works-field">
              <label for="miyuki_voice_category">カテゴリー</label>
              <select id="miyuki_voice_category" name="miyuki_voice_category">
                <option value="">選択してください</option>
                <?php foreach (miyuki_voice_category_options() as $category) : ?>
                  <option value="<?php echo esc_attr($category); ?>" <?php selected($data['category'], $category); ?>><?php echo esc_html($category); ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="miyuki-works-field">
              <label for="miyuki_voice_order">表示順</label>
              <input type="number" id="miyuki_voice_order" name="miyuki_voice_order" required value="<?php echo esc_attr($data['order']); ?>" min="0" step="1" placeholder="例：10">
              <p class="description">数字が小さいものほど、一覧で先に表示されます。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_voice_related_work">関連する施工事例</label>
            <select id="miyuki_voice_related_work" name="miyuki_voice_related_work_id">
              <option value="0">選択しない</option>
              <?php foreach ($related_works as $work) : ?>
                <option value="<?php echo esc_attr($work->ID); ?>" <?php selected($data['related_work_id'], $work->ID); ?>><?php echo esc_html($work->post_title); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>2</span>
            <div>
              <h2>写真</h2>
              <p>顔写真でなくても、完成写真・住まいの一部・打ち合わせ風景で大丈夫です。</p>
            </div>
          </div>

          <div class="miyuki-image-upload-field">
            <input type="hidden" class="miyuki-main-image-input" name="miyuki_voice_image_id" value="<?php echo esc_attr($image_id); ?>">
            <div class="miyuki-easy-main-drop miyuki-main-image-preview" data-drop-target="main">
              <?php if ($image_id) : ?>
                <?php echo wp_get_attachment_image($image_id, 'large'); ?>
              <?php else : ?>
                <div class="miyuki-easy-empty">
                  <strong>ここに写真をドラッグ</strong>
                  <span>大きい写真も自動で軽くしてアップします。</span>
                </div>
              <?php endif; ?>
            </div>
            <div class="miyuki-works-actions">
              <button type="button" class="button button-primary miyuki-main-image-select">写真を選択・アップロード</button>
              <button type="button" class="button miyuki-main-image-remove">削除</button>
            </div>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>3</span>
            <div>
              <h2>一言コメント</h2>
              <p>一覧カードにも表示される、いちばん伝えたい短い声です。</p>
            </div>
          </div>

          <div class="miyuki-works-field">
            <label for="miyuki_voice_quote">一言コメント</label>
            <textarea id="miyuki_voice_quote" name="miyuki_voice_quote" rows="4" placeholder="例：最初の相談から完成まで、こちらの希望を丁寧に聞いてくださり安心できました。"><?php echo esc_textarea($data['quote']); ?></textarea>
          </div>
        </section>

        <section class="miyuki-easy-card">
          <div class="miyuki-easy-step">
            <span>4</span>
            <div>
              <h2>本文ブロック</h2>
              <p>設問名は変更できます。表示側では、読み物のように自然な本文として並びます。</p>
            </div>
          </div>

          <?php foreach (miyuki_voice_question_labels() as $key => $label) : ?>
            <?php $question_image_ids = array_map('absint', $data[$key . '_image_ids'] ?? []); ?>
            <div class="miyuki-voice-question-editor">
              <div class="miyuki-works-field">
                <label for="miyuki_voice_<?php echo esc_attr($key); ?>_label">小見出し</label>
                <input type="text" id="miyuki_voice_<?php echo esc_attr($key); ?>_label" name="miyuki_voice_<?php echo esc_attr($key); ?>_label" value="<?php echo esc_attr($data[$key . '_label'] ?: $label); ?>" placeholder="<?php echo esc_attr($label); ?>">
                <p class="description">必要に応じて自由に変更できます。空にすると標準の小見出しで保存されます。</p>
              </div>

              <div class="miyuki-works-field">
                <label for="miyuki_voice_<?php echo esc_attr($key); ?>">本文</label>
                <textarea id="miyuki_voice_<?php echo esc_attr($key); ?>" name="miyuki_voice_<?php echo esc_attr($key); ?>" rows="4"><?php echo esc_textarea($data[$key]); ?></textarea>
              </div>

              <div class="miyuki-works-field miyuki-gallery-upload-field miyuki-voice-question-image-field">
                <label>設問の写真</label>
                <input type="hidden" class="miyuki-gallery-input" name="miyuki_voice_<?php echo esc_attr($key); ?>_image_ids" value="<?php echo esc_attr(implode(',', $question_image_ids)); ?>">
                <div class="miyuki-gallery-preview miyuki-easy-gallery-preview miyuki-voice-question-gallery-preview" data-drop-target="gallery">
                  <?php foreach ($question_image_ids as $question_image_id) : ?>
                    <?php if (wp_attachment_is_image($question_image_id)) : ?>
                      <div class="miyuki-gallery-item" data-id="<?php echo esc_attr($question_image_id); ?>">
                        <?php echo wp_get_attachment_image($question_image_id, 'thumbnail'); ?>
                        <button type="button" class="miyuki-gallery-remove" aria-label="写真を削除">×</button>
                      </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                  <?php if (empty($question_image_ids)) : ?>
                    <div class="miyuki-gallery-empty">
                      <strong>写真をドラッグ</strong>
                      <span>複数枚入れられます。</span>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="miyuki-works-actions">
                  <button type="button" class="button miyuki-gallery-select">写真を追加</button>
                  <button type="button" class="button miyuki-gallery-clear">すべて削除</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </section>

        <section class="miyuki-easy-card miyuki-gallery-upload-field miyuki-voice-gallery-card">
          <div class="miyuki-easy-step">
            <span>5</span>
            <div>
              <h2>ギャラリー写真</h2>
              <p>詳細ページ下部にまとめて表示する写真です。複数枚を一度に追加できます。</p>
            </div>
          </div>

          <input type="hidden" class="miyuki-gallery-input" name="miyuki_voice_gallery_ids" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">
          <div class="miyuki-gallery-preview miyuki-easy-gallery-preview miyuki-voice-gallery-preview" data-drop-target="gallery">
            <?php foreach ($gallery_ids as $gallery_id) : ?>
              <?php if (wp_attachment_is_image($gallery_id)) : ?>
                <div class="miyuki-gallery-item" data-id="<?php echo esc_attr($gallery_id); ?>">
                  <?php echo wp_get_attachment_image($gallery_id, 'thumbnail'); ?>
                  <button type="button" class="miyuki-gallery-remove" aria-label="写真を削除">×</button>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty($gallery_ids)) : ?>
              <div class="miyuki-gallery-empty"><strong>写真をまとめてドラッグ</strong><span>詳細ページのGalleryに表示されます。</span></div>
            <?php endif; ?>
          </div>
          <div class="miyuki-works-actions">
            <button type="button" class="button button-primary miyuki-gallery-select">ギャラリー写真を追加</button>
            <button type="button" class="button miyuki-gallery-clear">すべて削除</button>
          </div>
        </section>

      </div>

      <aside class="miyuki-easy-side">
        <div class="miyuki-easy-preview-card miyuki-voice-preview-card">
          <p class="miyuki-easy-preview-label">完成イメージ</p>
          <div class="miyuki-easy-preview-image">
            <?php echo $image_id ? wp_get_attachment_image($image_id, 'medium') : miyuki_voice_placeholder_image('お客様の声'); ?>
          </div>
          <p class="miyuki-easy-preview-en">VOICE</p>
          <?php if ($data['category']) : ?>
            <p class="miyuki-voice-preview-meta"><?php echo esc_html($data['category']); ?></p>
          <?php endif; ?>
          <h2><?php echo esc_html($data['title'] ?: 'お客様の声タイトル'); ?></h2>
          <p class="miyuki-voice-preview-quote"><?php echo esc_html($data['quote'] ?: '一言コメントがここに表示されます。'); ?></p>
        </div>

        <div class="miyuki-easy-publish-card">
          <h2><?php echo $is_edit ? '更新' : '公開'; ?></h2>
          <?php if ($is_edit) : ?>
            <p class="miyuki-easy-current-status">
              現在：<span class="miyuki-easy-status miyuki-easy-status-<?php echo esc_attr($status); ?>"><?php echo esc_html(miyuki_voice_status_label($status)); ?></span>
            </p>
          <?php endif; ?>
          <p><?php echo $is_edit ? '公開状態を選んで保存できます。' : '入力内容を確認してから公開してください。下書きや非公開保存もできます。'; ?></p>
          <div class="miyuki-works-field miyuki-easy-status-field">
            <label for="miyuki_voice_status">公開状態</label>
            <select id="miyuki_voice_status" name="miyuki_voice_status">
              <option value="publish" <?php selected($status, 'publish'); ?>>公開する</option>
              <option value="private" <?php selected($status, 'private'); ?>>非公開にする</option>
              <option value="draft" <?php selected($status, 'draft'); ?>>下書きにする</option>
            </select>
          </div>
          <button type="submit" class="button button-primary button-hero"><?php echo $is_edit ? '保存する' : '作成する'; ?></button>
          <?php if ($is_edit) : ?>
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" target="_blank" rel="noopener">表示を確認</a>
          <?php endif; ?>
          <a href="<?php echo esc_url($standard_url); ?>">通常編集画面を使う</a>
        </div>
      </aside>
    </div>
  </form>
  <?php
}

function miyuki_handle_voice_easy_submit() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  if (!isset($_POST['miyuki_voice_easy_nonce']) || !wp_verify_nonce($_POST['miyuki_voice_easy_nonce'], 'miyuki_voice_easy_submit')) {
    wp_die('不正な送信です。');
  }

  $post_id = isset($_POST['miyuki_voice_id']) ? absint($_POST['miyuki_voice_id']) : 0;
  $is_edit = $post_id && get_post_type($post_id) === 'voice';

  if ($is_edit && !current_user_can('edit_post', $post_id)) {
    wp_die('このお客様の声を編集する権限がありません。');
  }

  $title = isset($_POST['miyuki_voice_title']) ? sanitize_text_field(wp_unslash($_POST['miyuki_voice_title'])) : '';
  if ($title === '') {
    $redirect = $is_edit ? miyuki_voice_easy_edit_url($post_id) : admin_url('edit.php?post_type=voice&page=miyuki-voice-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'title', $redirect));
    exit;
  }

  $data = [
    'customer_name'   => isset($_POST['miyuki_voice_customer_name']) ? sanitize_text_field(wp_unslash($_POST['miyuki_voice_customer_name'])) : '',
    'customer_area'   => isset($_POST['miyuki_voice_area']) ? sanitize_text_field(wp_unslash($_POST['miyuki_voice_area'])) : '',
    'category'        => isset($_POST['miyuki_voice_category']) ? sanitize_text_field(wp_unslash($_POST['miyuki_voice_category'])) : '',
    'quote'           => isset($_POST['miyuki_voice_quote']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_voice_quote'])) : '',
    'problem'         => isset($_POST['miyuki_voice_problem']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_voice_problem'])) : '',
    'reason'          => isset($_POST['miyuki_voice_reason']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_voice_reason'])) : '',
    'good'            => isset($_POST['miyuki_voice_good']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_voice_good'])) : '',
    'after'           => isset($_POST['miyuki_voice_after']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_voice_after'])) : '',
    'image_id'        => isset($_POST['miyuki_voice_image_id']) ? absint($_POST['miyuki_voice_image_id']) : 0,
    'gallery_raw'     => isset($_POST['miyuki_voice_gallery_ids']) ? sanitize_text_field(wp_unslash($_POST['miyuki_voice_gallery_ids'])) : '',
    'related_work_id' => isset($_POST['miyuki_voice_related_work_id']) ? absint($_POST['miyuki_voice_related_work_id']) : 0,
  ];

  foreach (miyuki_voice_question_labels() as $key => $default_label) {
    $label_key = 'miyuki_voice_' . $key . '_label';
    $image_key = 'miyuki_voice_' . $key . '_image_id';
    $image_ids_key = 'miyuki_voice_' . $key . '_image_ids';
    $data[$key . '_label'] = isset($_POST[$label_key]) ? sanitize_text_field(wp_unslash($_POST[$label_key])) : $default_label;
    $data[$key . '_image_id'] = isset($_POST[$image_key]) ? absint($_POST[$image_key]) : 0;
    $data[$key . '_image_ids_raw'] = isset($_POST[$image_ids_key]) ? sanitize_text_field(wp_unslash($_POST[$image_ids_key])) : '';
  }

  $order  = isset($_POST['miyuki_voice_order']) ? absint($_POST['miyuki_voice_order']) : 0;
  $status = isset($_POST['miyuki_voice_status']) ? sanitize_key(wp_unslash($_POST['miyuki_voice_status'])) : 'publish';
  if (!in_array($status, ['publish', 'private', 'draft'], true)) {
    $status = 'publish';
  }

  $post_data = [
    'post_type'    => 'voice',
    'post_status'  => $status,
    'post_title'   => $title,
    'post_content' => miyuki_voice_build_content($data),
    'post_excerpt' => $data['quote'],
    'menu_order'   => $order,
  ];

  if ($is_edit) {
    $post_data['ID'] = $post_id;
    $saved_id = wp_update_post($post_data, true);
  } else {
    $saved_id = wp_insert_post($post_data, true);
  }

  if (is_wp_error($saved_id)) {
    $redirect = $is_edit ? miyuki_voice_easy_edit_url($post_id) : admin_url('edit.php?post_type=voice&page=miyuki-voice-easy-new');
    wp_safe_redirect(add_query_arg('miyuki_error', 'save', $redirect));
    exit;
  }

  $post_id = absint($saved_id);
  miyuki_update_voice_template_fields($post_id, $data);

  $redirect_arg = $is_edit ? 'updated' : 'created';
  wp_safe_redirect(add_query_arg($redirect_arg, $post_id, miyuki_voice_easy_edit_url($post_id)));
  exit;
}
add_action('admin_post_miyuki_voice_easy_submit', 'miyuki_handle_voice_easy_submit');

add_filter('post_row_actions', function($actions, $post) {
  if ($post->post_type !== 'voice') {
    return $actions;
  }

  $actions = ['miyuki_easy_edit' => '<a href="' . esc_url(miyuki_voice_easy_edit_url($post->ID)) . '">かんたん編集</a>'] + $actions;
  return $actions;
}, 10, 2);


/* ============================================================
   お客様アンケート
   ============================================================ */
function miyuki_voice_survey_meta_key($key) {
  return '_miyuki_survey_' . sanitize_key($key);
}

function miyuki_voice_survey_image_meta_key($key) {
  return '_miyuki_survey_' . sanitize_key($key) . '_image_ids';
}

function miyuki_voice_survey_meta($post_id, $key, $default = '') {
  $value = get_post_meta($post_id, miyuki_voice_survey_meta_key($key), true);
  return $value !== '' ? $value : $default;
}

function miyuki_voice_survey_bool($post_id, $key) {
  return miyuki_voice_survey_meta($post_id, $key) === '1';
}

function miyuki_voice_survey_default_questions() {
  $questions = [];

  foreach (miyuki_voice_question_labels() as $key => $label) {
    $questions[] = [
      'key'   => $key,
      'label' => $label,
    ];
  }

  return $questions;
}

function miyuki_sanitize_voice_survey_questions($labels, $existing_questions = [], $keys = []) {
  $questions = [];
  $existing_keys = [];
  $used_keys = [];

  foreach ($existing_questions as $index => $question) {
    if (!empty($question['key'])) {
      $existing_keys[$index] = sanitize_key($question['key']);
    }
  }

  if (!is_array($labels)) {
    $labels = [];
  }

  if (!is_array($keys)) {
    $keys = [];
  }

  foreach (array_values($labels) as $index => $label) {
    $label = sanitize_text_field(wp_unslash($label));
    if ($label === '') {
      continue;
    }

    $key = isset($keys[$index]) ? sanitize_key(wp_unslash($keys[$index])) : '';
    if ($key === '') {
      $key = $existing_keys[$index] ?? '';
    }
    if ($key === '') {
      $key = 'q' . ($index + 1);
    }

    $base_key = $key;
    $suffix = 2;
    while (in_array($key, $used_keys, true)) {
      $key = $base_key . '_' . $suffix;
      $suffix++;
    }
    $used_keys[] = $key;

    $questions[] = [
      'key'   => sanitize_key($key),
      'label' => $label,
    ];

    if (count($questions) >= 12) {
      break;
    }
  }

  return !empty($questions) ? $questions : miyuki_voice_survey_default_questions();
}

function miyuki_get_voice_survey_questions($post_id) {
  $raw = get_post_meta($post_id, '_miyuki_survey_questions', true);
  if ($raw) {
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) {
      $questions = [];
      foreach ($decoded as $question) {
        $key = isset($question['key']) ? sanitize_key($question['key']) : '';
        $label = isset($question['label']) ? sanitize_text_field($question['label']) : '';
        if ($key !== '' && $label !== '') {
          $questions[] = [
            'key'   => $key,
            'label' => $label,
          ];
        }
      }

      if (!empty($questions)) {
        return $questions;
      }
    }
  }

  return miyuki_voice_survey_default_questions();
}

function miyuki_save_voice_survey_questions($post_id, $questions) {
  update_post_meta($post_id, '_miyuki_survey_questions', wp_json_encode(array_values($questions), JSON_UNESCAPED_UNICODE));
}

function miyuki_get_voice_survey_question_image_ids($post_id, $key) {
  return miyuki_parse_voice_image_ids(get_post_meta($post_id, miyuki_voice_survey_image_meta_key($key), true));
}

function miyuki_get_voice_survey_gallery_ids($post_id) {
  return miyuki_parse_voice_image_ids(get_post_meta($post_id, '_miyuki_survey_gallery_ids', true));
}

function miyuki_voice_survey_public_url($token) {
  return add_query_arg('miyuki_survey', rawurlencode($token), miyuki_production_home_url('/'));
}

function miyuki_voice_survey_url_is_active($post_id) {
  $post_id = absint($post_id);
  $token = miyuki_voice_survey_meta($post_id, 'token');
  return $token !== '' && miyuki_voice_survey_meta($post_id, 'url_disabled') !== '1';
}

function miyuki_voice_survey_form_is_open($post_id) {
  $post_id = absint($post_id);
  if (!miyuki_voice_survey_url_is_active($post_id)) {
    return false;
  }

  $submitted_at = miyuki_voice_survey_meta($post_id, 'submitted_at');
  if ($submitted_at === '') {
    return true;
  }

  $reissued_at = miyuki_voice_survey_meta($post_id, 'reissued_at');
  return $reissued_at !== '' && strtotime($reissued_at) >= strtotime($submitted_at);
}

function miyuki_disable_voice_survey_url($post_id) {
  $post_id = absint($post_id);
  delete_post_meta($post_id, '_miyuki_survey_token');
  update_post_meta($post_id, '_miyuki_survey_url_disabled', '1');
}

function miyuki_reissue_voice_survey_url($post_id) {
  $post_id = absint($post_id);
  $token = wp_generate_password(32, false, false);
  update_post_meta($post_id, '_miyuki_survey_token', $token);
  delete_post_meta($post_id, '_miyuki_survey_url_disabled');
  update_post_meta($post_id, '_miyuki_survey_reissued_at', current_time('mysql'));

  return $token;
}

function miyuki_voice_survey_admin_create_url() {
  return admin_url('admin.php?page=miyuki-voice-surveys');
}

function miyuki_voice_survey_admin_list_url() {
  return admin_url('admin.php?page=miyuki-voice-survey-list');
}

function miyuki_voice_survey_admin_detail_url($survey_id) {
  return add_query_arg('survey_id', absint($survey_id), miyuki_voice_survey_admin_create_url());
}

function miyuki_voice_survey_print_sheet_url($survey_id) {
  $survey_id = absint($survey_id);
  return wp_nonce_url(
    add_query_arg([
      'action'    => 'miyuki_voice_survey_print_sheet',
      'survey_id' => $survey_id,
    ], admin_url('admin-post.php')),
    'miyuki_voice_survey_print_sheet_' . $survey_id
  );
}

function miyuki_get_voice_survey_by_token($token) {
  $token = sanitize_text_field($token);
  if ($token === '') {
    return null;
  }

  $query = new WP_Query([
    'post_type'      => 'voice_survey',
    'post_status'    => ['draft', 'pending', 'private', 'publish'],
    'posts_per_page' => 1,
    'meta_key'       => '_miyuki_survey_token',
    'meta_value'     => $token,
    'no_found_rows'  => true,
  ]);

  if (!$query->have_posts()) {
    return null;
  }

  return $query->posts[0];
}

function miyuki_create_voice_survey_post($data = []) {
  $token = wp_generate_password(32, false, false);
  $title = isset($data['title']) ? sanitize_text_field($data['title']) : '';
  if ($title === '') {
    $title = 'アンケート ' . current_time('Y.m.d H:i');
  }

  $post_id = wp_insert_post([
    'post_type'   => 'voice_survey',
    'post_status' => 'draft',
    'post_title'  => $title,
  ], true);

  if (is_wp_error($post_id)) {
    return $post_id;
  }

  $intro = isset($data['intro']) ? sanitize_textarea_field($data['intro']) : '';
  $questions = isset($data['questions']) && is_array($data['questions']) ? $data['questions'] : miyuki_voice_survey_default_questions();
  update_post_meta($post_id, '_miyuki_survey_token', $token);
  update_post_meta($post_id, '_miyuki_survey_created_at', current_time('mysql'));
  update_post_meta($post_id, '_miyuki_survey_intro', $intro);
  miyuki_save_voice_survey_questions($post_id, $questions);

  return absint($post_id);
}

function miyuki_add_voice_survey_admin_menu() {
  add_menu_page(
    'お客様アンケート',
    'お客様アンケート',
    'edit_posts',
    'miyuki-voice-surveys',
    'miyuki_render_voice_survey_admin_page',
    'dashicons-clipboard',
    9
  );

  add_submenu_page(
    'miyuki-voice-surveys',
    'アンケート制作',
    'アンケート制作',
    'edit_posts',
    'miyuki-voice-surveys',
    'miyuki_render_voice_survey_admin_page'
  );

  add_submenu_page(
    'miyuki-voice-surveys',
    'アンケート一覧',
    'アンケート一覧',
    'edit_posts',
    'miyuki-voice-survey-list',
    'miyuki_render_voice_survey_admin_page'
  );
}
add_action('admin_menu', 'miyuki_add_voice_survey_admin_menu');

function miyuki_voice_survey_status_label($post_id) {
  $converted_voice_id = absint(miyuki_voice_survey_meta($post_id, 'converted_voice_id'));
  if ($converted_voice_id && get_post_type($converted_voice_id) === 'voice') {
    return ['label' => '声作成済み', 'class' => 'converted'];
  }

  $submitted_at = miyuki_voice_survey_meta($post_id, 'submitted_at');
  if ($submitted_at && miyuki_voice_survey_url_is_active($post_id)) {
    if (miyuki_voice_survey_form_is_open($post_id)) {
      return ['label' => '再回答待ち', 'class' => 'reissued'];
    }
  }

  if ($submitted_at) {
    return ['label' => '回答済み', 'class' => 'submitted'];
  }

  if (!miyuki_voice_survey_url_is_active($post_id)) {
    return ['label' => 'URL停止', 'class' => 'stopped'];
  }

  return ['label' => '回答待ち', 'class' => 'waiting'];
}

function miyuki_render_voice_survey_permission_badge($allowed, $label) {
  $class = $allowed ? 'is-allowed' : 'is-denied';
  $text  = $allowed ? $label . ' OK' : $label . ' なし';
  return '<span class="miyuki-survey-permission ' . esc_attr($class) . '">' . esc_html($text) . '</span>';
}

function miyuki_render_voice_survey_admin_page() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  echo '<div class="wrap miyuki-works-easy-page miyuki-survey-admin-page">';
  $current_page = isset($_GET['page']) ? sanitize_key($_GET['page']) : '';

  if (!empty($_GET['survey_id'])) {
    miyuki_render_voice_survey_detail_page(absint($_GET['survey_id']));
    echo '</div>';
    return;
  }

  if ($current_page === 'miyuki-voice-survey-list' || (isset($_GET['survey_action']) && sanitize_key($_GET['survey_action']) === 'list')) {
    miyuki_render_voice_survey_list_page();
    echo '</div>';
    return;
  }

  miyuki_render_voice_survey_create_page();
  echo '</div>';
}

function miyuki_render_voice_survey_list_page() {
  miyuki_render_works_easy_header('お客様アンケート', '作成したアンケートと回答状況を一覧で確認できます。内容編集やURL確認は各アンケートのページで行います。', [
    ['label' => 'アンケートを作成', 'url' => miyuki_voice_survey_admin_create_url(), 'primary' => true],
  ], 'VOICE SURVEY');
  miyuki_render_voice_survey_admin_notices();
  miyuki_render_voice_survey_list();
}

function miyuki_render_voice_survey_admin_notices() {
  $message = isset($_GET['miyuki_survey_message']) ? sanitize_key($_GET['miyuki_survey_message']) : '';
  $error   = isset($_GET['miyuki_survey_error']) ? sanitize_key($_GET['miyuki_survey_error']) : '';

  if ($message === 'created') : ?>
    <div class="notice notice-success is-dismissible"><p>アンケート内容と回答URLを作成しました。お客様へURLを共有できます。</p></div>
  <?php elseif ($message === 'updated') : ?>
    <div class="notice notice-success is-dismissible"><p>アンケート内容を更新しました。</p></div>
  <?php elseif ($message === 'converted') : ?>
    <div class="notice notice-success is-dismissible"><p>アンケート回答から「お客様の声」の下書きを作成しました。</p></div>
  <?php elseif ($message === 'reissued') : ?>
    <div class="notice notice-success is-dismissible"><p>お客様用の回答URLを再発行しました。新しいURLを共有してください。</p></div>
  <?php elseif ($message === 'disabled') : ?>
    <div class="notice notice-success is-dismissible"><p>お客様用の回答URLを無効にしました。必要な場合はこのページから再発行できます。</p></div>
  <?php endif;

  if ($error === 'convert_permission') : ?>
    <div class="notice notice-error is-dismissible"><p>HP掲載許可がないため、「お客様の声」には変換できません。</p></div>
  <?php elseif ($error === 'save') : ?>
    <div class="notice notice-error is-dismissible"><p>保存できませんでした。もう一度お試しください。</p></div>
  <?php endif;
}

function miyuki_render_voice_survey_content_fields($survey_id = 0) {
  $post = $survey_id ? get_post($survey_id) : null;
  $title = $post ? $post->post_title : '';
  $intro = $survey_id ? miyuki_voice_survey_meta($survey_id, 'intro') : 'ご回答内容は確認後に社内で管理します。許可なくホームページに公開されることはありません。';
  $questions = $survey_id ? miyuki_get_voice_survey_questions($survey_id) : miyuki_voice_survey_default_questions();
  ?>
  <div class="miyuki-survey-builder-guide">
    <div><span>1</span><strong>タイトルを入れる</strong><small>社内で見分けやすい名前</small></div>
    <div><span>2</span><strong>設問を整える</strong><small>追加・削除できます</small></div>
    <div><span>3</span><strong>URLを送る</strong><small>回答は公開されません</small></div>
  </div>

  <div class="miyuki-works-field">
    <label for="miyuki_survey_title">管理用タイトル</label>
    <input type="text" id="miyuki_survey_title" name="miyuki_survey_title" required value="<?php echo esc_attr($title); ?>" placeholder="例：新築完成後アンケート / K様">
    <p class="description">管理画面の一覧に表示されます。お客様にも回答ページ上部で表示されます。</p>
  </div>

  <div class="miyuki-works-field">
    <label for="miyuki_survey_intro">お客様への説明文</label>
    <textarea id="miyuki_survey_intro" name="miyuki_survey_intro" rows="3" placeholder="例：今後の住まいづくりの参考にさせていただくため、率直なご感想をお聞かせください。"><?php echo esc_textarea($intro); ?></textarea>
  </div>

  <div class="miyuki-survey-question-builder" data-next-index="<?php echo esc_attr(count($questions) + 1); ?>">
    <div class="miyuki-survey-question-builder-head">
      <div>
        <h3>設問</h3>
        <p>聞きたい内容だけ残してください。右上の削除で減らせます。</p>
      </div>
      <button type="button" class="button miyuki-survey-question-add">設問を追加</button>
    </div>

    <div class="miyuki-survey-question-list-edit">
      <?php foreach ($questions as $index => $question) : ?>
        <?php
        $question_key = sanitize_key($question['key'] ?? ('q' . ($index + 1)));
        $label = $question['label'] ?? '';
        ?>
        <div class="miyuki-survey-question-edit-card">
          <div class="miyuki-survey-question-edit-head">
            <span>設問 <?php echo esc_html($index + 1); ?></span>
            <button type="button" class="button-link-delete miyuki-survey-question-remove">削除</button>
          </div>
          <input type="hidden" name="miyuki_survey_question_keys[]" value="<?php echo esc_attr($question_key); ?>">
          <div class="miyuki-works-field">
            <label for="miyuki_survey_question_<?php echo esc_attr($index); ?>">質問文</label>
            <input type="text" id="miyuki_survey_question_<?php echo esc_attr($index); ?>" name="miyuki_survey_question_labels[]" value="<?php echo esc_attr($label); ?>" placeholder="例：ミユキハウジングを選んだ理由">
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <script type="text/template" class="miyuki-survey-question-template">
      <div class="miyuki-survey-question-edit-card">
        <div class="miyuki-survey-question-edit-head">
          <span>設問 __NUMBER__</span>
          <button type="button" class="button-link-delete miyuki-survey-question-remove">削除</button>
        </div>
        <input type="hidden" name="miyuki_survey_question_keys[]" value="__KEY__">
        <div class="miyuki-works-field">
          <label>質問文</label>
          <input type="text" name="miyuki_survey_question_labels[]" value="" placeholder="例：ミユキハウジングを選んだ理由">
        </div>
      </div>
    </script>

    <button type="button" class="button miyuki-survey-question-add miyuki-survey-question-add-bottom">設問を追加</button>
    <?php if (count($questions) <= 1) : ?>
      <p class="miyuki-survey-question-note">設問は最低1つ必要です。</p>
    <?php endif; ?>
  </div>
  <?php
}

function miyuki_render_voice_survey_create_box() {
  ?>
  <section class="miyuki-easy-card miyuki-survey-create-card">
    <h2>アンケート内容を作成</h2>
    <p>設問内容を作って保存すると、そのアンケート専用の回答URLが発行されます。</p>
    <form class="miyuki-survey-builder-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
      <?php wp_nonce_field('miyuki_voice_survey_create', 'miyuki_voice_survey_create_nonce'); ?>
      <input type="hidden" name="action" value="miyuki_voice_survey_create">
      <?php miyuki_render_voice_survey_content_fields(); ?>
      <button type="submit" class="button button-primary button-hero">この内容で回答URLを作成</button>
    </form>
  </section>
  <?php
}

function miyuki_render_voice_survey_create_page() {
  miyuki_render_works_easy_header('アンケート作成', 'お客様に回答していただく内容を作成します。保存すると、このアンケート専用の回答URLが発行されます。', [
    ['label' => '一覧へ戻る', 'url' => miyuki_voice_survey_admin_list_url(), 'primary' => true],
  ], 'VOICE SURVEY');
  miyuki_render_voice_survey_admin_notices();
  miyuki_render_voice_survey_create_box();
}

function miyuki_render_voice_survey_list() {
  $survey_query = new WP_Query([
    'post_type'      => 'voice_survey',
    'post_status'    => ['draft', 'pending', 'private', 'publish'],
    'posts_per_page' => 80,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);

  if (!$survey_query->have_posts()) : ?>
    <div class="miyuki-easy-empty-list">
      <p>アンケートはまだありません。</p>
    </div>
    <?php
    return;
  endif;
  ?>
  <section class="miyuki-survey-admin-list">
    <?php while ($survey_query->have_posts()) : $survey_query->the_post(); ?>
      <?php
      $post_id   = get_the_ID();
      $status    = miyuki_voice_survey_status_label($post_id);
      $name      = miyuki_voice_survey_meta($post_id, 'customer_name', '未回答');
      $area      = miyuki_voice_survey_meta($post_id, 'customer_area');
      $submitted = miyuki_voice_survey_meta($post_id, 'submitted_at');
      $question_count = count(miyuki_get_voice_survey_questions($post_id));
      $detail_label = $submitted ? '回答を見る' : '編集・URL確認';
      ?>
      <article class="miyuki-survey-row">
        <div>
          <span class="miyuki-survey-status miyuki-survey-status-<?php echo esc_attr($status['class']); ?>"><?php echo esc_html($status['label']); ?></span>
          <h2><?php echo esc_html(get_the_title()); ?></h2>
          <p><?php echo esc_html(trim($name . ($area ? ' / ' . $area : ''))); ?></p>
          <p class="miyuki-survey-date">
            <?php echo esc_html($question_count . '問 / '); ?><?php echo $submitted ? esc_html('回答日：' . mysql2date('Y.m.d H:i', $submitted)) : esc_html('作成日：' . get_the_date('Y.m.d H:i')); ?>
          </p>
        </div>
        <div class="miyuki-survey-row-actions">
          <?php if (miyuki_voice_survey_url_is_active($post_id)) : ?>
            <a class="button" href="<?php echo esc_url(miyuki_voice_survey_print_sheet_url($post_id)); ?>" target="_blank" rel="noopener">QR用紙</a>
          <?php endif; ?>
          <a class="button button-primary" href="<?php echo esc_url(miyuki_voice_survey_admin_detail_url($post_id)); ?>"><?php echo esc_html($detail_label); ?></a>
        </div>
      </article>
    <?php endwhile; wp_reset_postdata(); ?>
  </section>
  <?php
}

function miyuki_render_voice_survey_detail_page($survey_id) {
  $survey = get_post($survey_id);
  if (!$survey || $survey->post_type !== 'voice_survey') {
    wp_die('アンケートが見つかりません。');
  }

  $token      = miyuki_voice_survey_meta($survey_id, 'token');
  $url_active = miyuki_voice_survey_url_is_active($survey_id);
  $form_open  = miyuki_voice_survey_form_is_open($survey_id);
  $url        = ($token && $url_active) ? miyuki_voice_survey_public_url($token) : '';
  $submitted  = miyuki_voice_survey_meta($survey_id, 'submitted_at');
  $converted  = absint(miyuki_voice_survey_meta($survey_id, 'converted_voice_id'));
  $publish_ok = miyuki_voice_survey_bool($survey_id, 'publish_permission');
  $photo_ok   = miyuki_voice_survey_bool($survey_id, 'photo_permission');
  $name_ok    = miyuki_voice_survey_bool($survey_id, 'name_permission');
  $page_title = $submitted ? 'アンケート回答' : 'アンケート編集';
  $page_description = $submitted ? '回答内容を確認し、必要な場合だけ「お客様の声」の下書きへ変換できます。' : '設問内容を編集し、お客様へ送る回答URLを確認できます。';

  miyuki_render_works_easy_header($page_title, $page_description, [
    ['label' => '一覧へ戻る', 'url' => miyuki_voice_survey_admin_list_url(), 'primary' => true],
  ], 'VOICE SURVEY');
  miyuki_render_voice_survey_admin_notices();
  ?>

  <div class="miyuki-easy-layout miyuki-survey-detail-layout">
    <div class="miyuki-easy-main">
      <?php if (!$submitted) : ?>
        <section class="miyuki-easy-card miyuki-survey-create-card">
          <h2>アンケート内容</h2>
          <p>回答が届く前であれば、設問内容を調整できます。この内容に対して下のURLが発行されています。</p>
          <form class="miyuki-survey-builder-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('miyuki_voice_survey_update_' . $survey_id, 'miyuki_voice_survey_update_nonce'); ?>
            <input type="hidden" name="action" value="miyuki_voice_survey_update">
            <input type="hidden" name="survey_id" value="<?php echo esc_attr($survey_id); ?>">
            <?php miyuki_render_voice_survey_content_fields($survey_id); ?>
            <button type="submit" class="button button-primary button-hero">アンケート内容を更新</button>
          </form>
        </section>
      <?php else : ?>
        <section class="miyuki-easy-card miyuki-survey-question-card">
          <h2>アンケート内容</h2>
          <p><?php echo nl2br(esc_html(miyuki_voice_survey_meta($survey_id, 'intro'))); ?></p>
          <ol class="miyuki-survey-question-list">
            <?php foreach (miyuki_get_voice_survey_questions($survey_id) as $question) : ?>
              <li><?php echo esc_html($question['label']); ?></li>
            <?php endforeach; ?>
          </ol>
        </section>
      <?php endif; ?>

      <section class="miyuki-easy-card">
        <h2>お客様確認用URL</h2>
        <?php if ($url_active && $url) : ?>
          <?php if ($submitted && !$form_open) : ?>
            <p>回答済みです。このURLを開くと完了画面が表示され、再回答はできません。URLを止めたい場合は手動で無効にできます。</p>
          <?php elseif ($submitted && $form_open) : ?>
            <p>再回答用URLとして有効です。このURLをお客様へ送ると、ログインなしで再回答できます。</p>
          <?php else : ?>
            <p>このURLをお客様へ送ると、ログインなしでアンケートに回答できます。</p>
          <?php endif; ?>
          <div class="miyuki-survey-url-copy">
            <input type="text" readonly value="<?php echo esc_attr($url); ?>" onclick="this.select();">
            <button type="button" class="button miyuki-survey-copy-url">URLをコピー</button>
          </div>
          <div class="miyuki-survey-url-actions">
            <a class="button button-primary" href="<?php echo esc_url(miyuki_voice_survey_print_sheet_url($survey_id)); ?>" target="_blank" rel="noopener">QR付きA4用紙を表示</a>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
              <?php wp_nonce_field('miyuki_voice_survey_disable_url_' . $survey_id, 'miyuki_voice_survey_disable_url_nonce'); ?>
              <input type="hidden" name="action" value="miyuki_voice_survey_disable_url">
              <input type="hidden" name="survey_id" value="<?php echo esc_attr($survey_id); ?>">
              <button type="submit" class="button miyuki-survey-disable-url-button">URLを無効にする</button>
            </form>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
              <?php wp_nonce_field('miyuki_voice_survey_reissue_url_' . $survey_id, 'miyuki_voice_survey_reissue_url_nonce'); ?>
              <input type="hidden" name="action" value="miyuki_voice_survey_reissue_url">
              <input type="hidden" name="survey_id" value="<?php echo esc_attr($survey_id); ?>">
              <button type="submit" class="button">URLを再発行</button>
            </form>
          </div>
        <?php else : ?>
          <div class="miyuki-survey-url-stopped">
            <strong>現在、回答URLは停止中です。</strong>
            <p><?php echo $submitted ? '手動で無効にしたURL、または未発行のURLです。再回答が必要な場合だけ再発行してください。' : '回答URLが未発行、または手動で無効になっています。必要な場合は再発行してください。'; ?></p>
          </div>
          <form class="miyuki-survey-reissue-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('miyuki_voice_survey_reissue_url_' . $survey_id, 'miyuki_voice_survey_reissue_url_nonce'); ?>
            <input type="hidden" name="action" value="miyuki_voice_survey_reissue_url">
            <input type="hidden" name="survey_id" value="<?php echo esc_attr($survey_id); ?>">
            <button type="submit" class="button">回答URLを再発行</button>
          </form>
        <?php endif; ?>
      </section>

      <?php if (!$submitted) : ?>
        <section class="miyuki-easy-card miyuki-survey-waiting-card">
          <h2>まだ回答はありません</h2>
          <p>お客様の回答が送信されると、このページに内容が表示されます。</p>
        </section>
      <?php else : ?>
        <section class="miyuki-easy-card miyuki-survey-answer-card">
          <h2>回答内容</h2>
          <dl class="miyuki-survey-answer-list">
            <div><dt>お客様名</dt><dd><?php echo esc_html(miyuki_voice_survey_meta($survey_id, 'customer_name', '未入力')); ?></dd></div>
            <div><dt>エリア</dt><dd><?php echo esc_html(miyuki_voice_survey_meta($survey_id, 'customer_area', '未入力')); ?></dd></div>
            <div><dt>連絡先</dt><dd><?php echo esc_html(miyuki_voice_survey_meta($survey_id, 'customer_contact', '未入力')); ?></dd></div>
            <div><dt>種別</dt><dd><?php echo esc_html(miyuki_voice_survey_meta($survey_id, 'category', '未入力')); ?></dd></div>
            <div><dt>満足度</dt><dd><?php echo esc_html(miyuki_voice_survey_meta($survey_id, 'satisfaction', '未入力')); ?></dd></div>
            <div><dt>一言コメント</dt><dd><?php echo nl2br(esc_html(miyuki_voice_survey_meta($survey_id, 'quote', '未入力'))); ?></dd></div>
          </dl>
          <div class="miyuki-survey-permissions">
            <?php echo miyuki_render_voice_survey_permission_badge($publish_ok, 'HP掲載'); ?>
            <?php echo miyuki_render_voice_survey_permission_badge($photo_ok, '写真掲載'); ?>
            <?php echo miyuki_render_voice_survey_permission_badge($name_ok, '名前掲載'); ?>
          </div>
        </section>

        <?php foreach (miyuki_get_voice_survey_questions($survey_id) as $question) : ?>
          <?php
          $key = sanitize_key($question['key']);
          $label = $question['label'];
          $answer = miyuki_voice_survey_meta($survey_id, $key);
          $image_ids = miyuki_get_voice_survey_question_image_ids($survey_id, $key);
          ?>
          <section class="miyuki-easy-card miyuki-survey-question-card">
            <h2><?php echo esc_html($label); ?></h2>
            <p><?php echo $answer !== '' ? nl2br(esc_html($answer)) : '未入力'; ?></p>
            <?php if (!empty($image_ids)) : ?>
              <div class="miyuki-survey-admin-images">
                <?php foreach ($image_ids as $image_id) : ?>
                  <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </section>
        <?php endforeach; ?>

        <?php $gallery_ids = miyuki_get_voice_survey_gallery_ids($survey_id); ?>
        <?php if (!empty($gallery_ids)) : ?>
          <section class="miyuki-easy-card miyuki-survey-question-card">
            <h2>ギャラリー写真</h2>
            <div class="miyuki-survey-admin-images">
              <?php foreach ($gallery_ids as $image_id) : ?>
                <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <aside class="miyuki-easy-side">
      <div class="miyuki-easy-publish-card">
        <h2>お客様の声へ変換</h2>
        <?php if ($converted && get_post_type($converted) === 'voice') : ?>
          <p>このアンケートから、すでに「お客様の声」を作成済みです。</p>
          <a class="button button-primary button-hero" href="<?php echo esc_url(miyuki_voice_easy_edit_url($converted)); ?>">お客様の声を編集</a>
        <?php elseif (!$submitted) : ?>
          <p>回答が届くと、ここから「お客様の声」の下書きを作成できます。</p>
        <?php elseif (!$publish_ok) : ?>
          <p>HP掲載許可がないため、公開用のお客様の声には変換しません。</p>
        <?php else : ?>
          <p>回答内容をもとに「お客様の声」の下書きを作成します。作成後に文章や写真を調整できます。</p>
          <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('miyuki_voice_survey_convert_' . $survey_id, 'miyuki_voice_survey_convert_nonce'); ?>
            <input type="hidden" name="action" value="miyuki_voice_survey_convert">
            <input type="hidden" name="survey_id" value="<?php echo esc_attr($survey_id); ?>">
            <button type="submit" class="button button-primary button-hero">下書きを作成</button>
          </form>
        <?php endif; ?>
      </div>
    </aside>
  </div>
  <?php
}

function miyuki_handle_voice_survey_create() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  if (!isset($_POST['miyuki_voice_survey_create_nonce']) || !wp_verify_nonce($_POST['miyuki_voice_survey_create_nonce'], 'miyuki_voice_survey_create')) {
    wp_die('不正な送信です。');
  }

  $questions = miyuki_sanitize_voice_survey_questions($_POST['miyuki_survey_question_labels'] ?? [], [], $_POST['miyuki_survey_question_keys'] ?? []);
  $post_id = miyuki_create_voice_survey_post([
    'title'     => isset($_POST['miyuki_survey_title']) ? sanitize_text_field(wp_unslash($_POST['miyuki_survey_title'])) : '',
    'intro'     => isset($_POST['miyuki_survey_intro']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_survey_intro'])) : '',
    'questions' => $questions,
  ]);
  if (is_wp_error($post_id)) {
    wp_safe_redirect(add_query_arg('miyuki_survey_error', 'save', miyuki_voice_survey_admin_create_url()));
    exit;
  }

  wp_safe_redirect(add_query_arg([
    'miyuki_survey_message' => 'created',
  ], miyuki_voice_survey_admin_detail_url($post_id)));
  exit;
}
add_action('admin_post_miyuki_voice_survey_create', 'miyuki_handle_voice_survey_create');

function miyuki_handle_voice_survey_update() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  $survey_id = isset($_POST['survey_id']) ? absint($_POST['survey_id']) : 0;
  $survey = $survey_id ? get_post($survey_id) : null;
  if (!$survey || $survey->post_type !== 'voice_survey') {
    wp_die('アンケートが見つかりません。');
  }

  if (!isset($_POST['miyuki_voice_survey_update_nonce']) || !wp_verify_nonce($_POST['miyuki_voice_survey_update_nonce'], 'miyuki_voice_survey_update_' . $survey_id)) {
    wp_die('不正な送信です。');
  }

  if (miyuki_voice_survey_meta($survey_id, 'submitted_at')) {
    wp_safe_redirect(add_query_arg([
      'miyuki_survey_error' => 'save',
    ], miyuki_voice_survey_admin_detail_url($survey_id)));
    exit;
  }

  $existing_questions = miyuki_get_voice_survey_questions($survey_id);
  $questions = miyuki_sanitize_voice_survey_questions($_POST['miyuki_survey_question_labels'] ?? [], $existing_questions, $_POST['miyuki_survey_question_keys'] ?? []);
  $title = isset($_POST['miyuki_survey_title']) ? sanitize_text_field(wp_unslash($_POST['miyuki_survey_title'])) : '';
  if ($title === '') {
    $title = get_the_title($survey_id);
  }

  wp_update_post([
    'ID'         => $survey_id,
    'post_title' => $title,
  ]);
  update_post_meta($survey_id, '_miyuki_survey_intro', isset($_POST['miyuki_survey_intro']) ? sanitize_textarea_field(wp_unslash($_POST['miyuki_survey_intro'])) : '');
  miyuki_save_voice_survey_questions($survey_id, $questions);

  wp_safe_redirect(add_query_arg([
    'miyuki_survey_message' => 'updated',
  ], miyuki_voice_survey_admin_detail_url($survey_id)));
  exit;
}
add_action('admin_post_miyuki_voice_survey_update', 'miyuki_handle_voice_survey_update');

function miyuki_handle_voice_survey_disable_url() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  $survey_id = isset($_POST['survey_id']) ? absint($_POST['survey_id']) : 0;
  $survey = $survey_id ? get_post($survey_id) : null;
  if (!$survey || $survey->post_type !== 'voice_survey') {
    wp_die('アンケートが見つかりません。');
  }

  if (!isset($_POST['miyuki_voice_survey_disable_url_nonce']) || !wp_verify_nonce($_POST['miyuki_voice_survey_disable_url_nonce'], 'miyuki_voice_survey_disable_url_' . $survey_id)) {
    wp_die('不正な送信です。');
  }

  miyuki_disable_voice_survey_url($survey_id);
  wp_safe_redirect(add_query_arg([
    'miyuki_survey_message' => 'disabled',
  ], miyuki_voice_survey_admin_detail_url($survey_id)));
  exit;
}
add_action('admin_post_miyuki_voice_survey_disable_url', 'miyuki_handle_voice_survey_disable_url');

function miyuki_handle_voice_survey_reissue_url() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  $survey_id = isset($_POST['survey_id']) ? absint($_POST['survey_id']) : 0;
  $survey = $survey_id ? get_post($survey_id) : null;
  if (!$survey || $survey->post_type !== 'voice_survey') {
    wp_die('アンケートが見つかりません。');
  }

  if (!isset($_POST['miyuki_voice_survey_reissue_url_nonce']) || !wp_verify_nonce($_POST['miyuki_voice_survey_reissue_url_nonce'], 'miyuki_voice_survey_reissue_url_' . $survey_id)) {
    wp_die('不正な送信です。');
  }

  miyuki_reissue_voice_survey_url($survey_id);
  wp_safe_redirect(add_query_arg([
    'miyuki_survey_message' => 'reissued',
  ], miyuki_voice_survey_admin_detail_url($survey_id)));
  exit;
}
add_action('admin_post_miyuki_voice_survey_reissue_url', 'miyuki_handle_voice_survey_reissue_url');

function miyuki_handle_voice_survey_print_sheet() {
  if (!current_user_can('edit_posts')) {
    wp_die('このページを表示する権限がありません。');
  }

  $survey_id = isset($_GET['survey_id']) ? absint($_GET['survey_id']) : 0;
  $survey = $survey_id ? get_post($survey_id) : null;
  if (!$survey || $survey->post_type !== 'voice_survey') {
    wp_die('アンケートが見つかりません。');
  }

  if (!isset($_GET['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'miyuki_voice_survey_print_sheet_' . $survey_id)) {
    wp_die('不正なURLです。');
  }

  if (!miyuki_voice_survey_url_is_active($survey_id)) {
    wp_die('回答URLが停止中です。先にURLを再発行してください。');
  }

  $token = miyuki_voice_survey_meta($survey_id, 'token');
  $survey_url = miyuki_voice_survey_public_url($token);
  $company_name = '有限会社ミユキハウジング';
  $phone = '082-263-8066';
  $logo_url = miyuki_schema_logo_url();
  $detail_url = miyuki_voice_survey_admin_detail_url($survey_id);

  nocache_headers();
  header('Content-Type: text/html; charset=' . get_option('blog_charset'));
  ?>
  <!doctype html>
  <html lang="ja">
  <head>
    <meta charset="<?php echo esc_attr(get_option('blog_charset')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html(get_the_title($survey_id)); ?>｜アンケート用紙</title>
    <style>
      @page {
        size: A4;
        margin: 0;
      }

      * {
        box-sizing: border-box;
      }

      body {
        margin: 0;
        background: #e9eef2;
        color: #13202f;
        font-family: "Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", "Yu Gothic", Meiryo, sans-serif;
        line-height: 1.7;
      }

      .miyuki-print-toolbar {
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.94);
        border-bottom: 1px solid #d6dee4;
      }

      .miyuki-print-toolbar button,
      .miyuki-print-toolbar a {
        display: inline-flex;
        align-items: center;
        min-height: 38px;
        padding: 0 16px;
        border: 1px solid #1f5f7a;
        border-radius: 6px;
        background: #1f5f7a;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
      }

      .miyuki-print-toolbar a {
        background: #fff;
        color: #1f5f7a;
      }

      .miyuki-survey-print-stage {
        display: flex;
        justify-content: center;
        padding: 22px 0;
      }

      .miyuki-survey-print-sheet {
        display: flex;
        flex-direction: column;
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 14mm 16mm 12mm;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 16px 50px rgba(15, 23, 42, 0.14);
        transform-origin: top center;
      }

      .miyuki-survey-print-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14mm;
        margin-bottom: 8mm;
      }

      .miyuki-survey-print-logo {
        width: 28mm;
        height: auto;
      }

      .miyuki-survey-print-company {
        margin: 0;
        color: #4b5563;
        font-size: 9.5pt;
        text-align: right;
      }

      .miyuki-survey-print-title {
        margin: 0 0 6mm;
        font-size: 22pt;
        line-height: 1.35;
        letter-spacing: 0;
      }

      .miyuki-survey-print-lead {
        margin: 0 0 7mm;
        color: #334155;
        font-size: 11.5pt;
        line-height: 1.85;
      }

      .miyuki-survey-print-guide {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 4mm;
        margin-bottom: 7mm;
      }

      .miyuki-survey-print-guide div {
        min-height: 20mm;
        padding: 4mm;
        border: 1px solid #d9e2e8;
        border-radius: 8px;
        background: #f7fafc;
      }

      .miyuki-survey-print-guide strong {
        display: block;
        margin-bottom: 2mm;
        color: #1f5f7a;
        font-size: 9pt;
      }

      .miyuki-survey-print-guide span {
        display: block;
        color: #111827;
        font-size: 10.5pt;
        font-weight: 700;
        line-height: 1.55;
      }

      .miyuki-survey-print-qr-area {
        display: grid;
        justify-items: center;
        gap: 3mm;
        margin: 2mm 0 6mm;
        text-align: center;
      }

      .miyuki-survey-print-qr {
        display: grid;
        place-items: center;
        width: 68mm;
        height: 68mm;
        padding: 3mm;
        border: 1px solid #d9e2e8;
        border-radius: 10px;
        background: #fff;
      }

      .miyuki-survey-print-qr canvas,
      .miyuki-survey-print-qr img,
      .miyuki-survey-print-qr table {
        width: 60mm !important;
        height: 60mm !important;
      }

      .miyuki-survey-print-qr span,
      .miyuki-survey-print-qr p {
        margin: 0;
        color: #64748b;
        font-size: 10pt;
      }

      .miyuki-survey-print-qr-caption {
        margin: 0;
        color: #111827;
        font-size: 12pt;
        font-weight: 700;
      }

      .miyuki-survey-print-url-block {
        margin: 0 0 6mm;
        padding: 3.5mm;
        border-top: 1px solid #d9e2e8;
        border-bottom: 1px solid #d9e2e8;
      }

      .miyuki-survey-print-url-block p {
        margin: 0 0 2mm;
        color: #4b5563;
        font-size: 9.5pt;
        font-weight: 700;
      }

      .miyuki-survey-print-url {
        margin: 0;
        color: #13202f;
        font-size: 9pt;
        line-height: 1.5;
        word-break: break-all;
      }

      .miyuki-survey-print-footer {
        margin-top: auto;
        padding-top: 5mm;
        border-top: 1px solid #d9e2e8;
        color: #334155;
      }

      .miyuki-survey-print-thanks {
        margin: 0 0 3mm;
        font-size: 13pt;
        font-weight: 700;
      }

      .miyuki-survey-print-footer dl {
        display: grid;
        grid-template-columns: 22mm minmax(0, 1fr);
        gap: 1mm 4mm;
        margin: 0;
        font-size: 9.5pt;
      }

      .miyuki-survey-print-footer dt {
        font-weight: 700;
      }

      .miyuki-survey-print-footer dd {
        margin: 0;
      }

      @media print {
        body {
          background: #fff;
        }

        .miyuki-print-toolbar {
          display: none;
        }

        .miyuki-survey-print-stage {
          display: block;
          padding: 0;
        }

        .miyuki-survey-print-sheet {
          width: 210mm;
          height: 297mm;
          margin: 0;
          box-shadow: none;
          transform: none !important;
        }
      }
    </style>
  </head>
  <body>
    <div class="miyuki-print-toolbar">
      <button type="button" onclick="window.print();">この用紙を印刷</button>
      <a href="<?php echo esc_url($detail_url); ?>">編集画面へ戻る</a>
    </div>

    <div class="miyuki-survey-print-stage">
      <main class="miyuki-survey-print-sheet">
        <header class="miyuki-survey-print-header">
          <img class="miyuki-survey-print-logo" src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($company_name); ?>">
          <p class="miyuki-survey-print-company">
            <?php echo esc_html($company_name); ?><br>
            TEL：<?php echo esc_html($phone); ?><br>
            担当者名：＿＿＿＿＿＿＿＿
          </p>
        </header>

        <h1 class="miyuki-survey-print-title">お客様アンケート<br>ご協力のお願い</h1>

        <p class="miyuki-survey-print-lead">
          このたびは弊社に工事をご依頼いただき、誠にありがとうございました。<br>
          今後のサービス向上のため、アンケートへのご協力をお願いいたします。
        </p>

        <div class="miyuki-survey-print-guide">
          <div>
            <strong>回答時間</strong>
            <span>1〜2分程度</span>
          </div>
          <div>
            <strong>回答方法</strong>
            <span>スマートフォンでQRコードを読み取りご回答ください</span>
          </div>
          <div>
            <strong>お願い</strong>
            <span>率直なご意見をお聞かせください</span>
          </div>
        </div>

        <section class="miyuki-survey-print-qr-area" aria-label="アンケート回答QRコード">
          <p class="miyuki-survey-print-qr-caption">こちらのQRコードからご回答ください</p>
          <div id="miyukiSurveyPrintQr" class="miyuki-survey-print-qr" data-url="<?php echo esc_attr($survey_url); ?>">
            <span>QRコードを読み込み中です</span>
          </div>
        </section>

        <section class="miyuki-survey-print-url-block">
          <p>QRコードが読み取れない場合はこちら</p>
          <div class="miyuki-survey-print-url"><?php echo esc_html($survey_url); ?></div>
        </section>

        <footer class="miyuki-survey-print-footer">
          <p class="miyuki-survey-print-thanks">ご協力ありがとうございます</p>
          <dl>
            <dt>会社名</dt>
            <dd><?php echo esc_html($company_name); ?></dd>
            <dt>電話番号</dt>
            <dd><?php echo esc_html($phone); ?></dd>
            <dt>担当者名</dt>
            <dd>＿＿＿＿＿＿＿＿</dd>
          </dl>
        </footer>
      </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      (function () {
        var target = document.getElementById('miyukiSurveyPrintQr');
        var stage = document.querySelector('.miyuki-survey-print-stage');
        var sheet = document.querySelector('.miyuki-survey-print-sheet');
        if (!target) {
          return;
        }

        var surveyUrl = target.getAttribute('data-url');
        function fitPreview() {
          if (!stage || !sheet || window.matchMedia('print').matches) {
            return;
          }

          var scale = Math.min(1, (window.innerWidth - 32) / sheet.offsetWidth);
          sheet.style.transform = 'scale(' + scale + ')';
          stage.style.height = (sheet.offsetHeight * scale + 44) + 'px';
        }

        function showFallback() {
          target.innerHTML = '<p>QRコードを生成できませんでした。下のURLをご利用ください。</p>';
        }

        function renderQr() {
          if (!window.QRCode || !surveyUrl) {
            showFallback();
            return;
          }

          target.innerHTML = '';
          new window.QRCode(target, {
            text: surveyUrl,
            width: 360,
            height: 360,
            colorDark: '#0f172a',
            colorLight: '#ffffff',
            correctLevel: window.QRCode.CorrectLevel.M
          });
        }

        if (window.QRCode) {
          renderQr();
        } else {
          window.addEventListener('load', renderQr);
          window.setTimeout(function () {
            if (!target.querySelector('canvas') && !target.querySelector('img') && !target.querySelector('table')) {
              showFallback();
            }
          }, 3000);
        }

        fitPreview();
        window.addEventListener('resize', fitPreview);
        window.addEventListener('beforeprint', function () {
          if (sheet) {
            sheet.style.transform = '';
          }
          if (stage) {
            stage.style.height = '';
          }
        });
        window.addEventListener('afterprint', fitPreview);
      }());
    </script>
  </body>
  </html>
  <?php
  exit;
}
add_action('admin_post_miyuki_voice_survey_print_sheet', 'miyuki_handle_voice_survey_print_sheet');

function miyuki_render_voice_survey_closed_page() {
  status_header(410);
  ?>
  <main class="miyuki-survey-page">
    <section class="miyuki-survey-shell">
      <div class="miyuki-survey-complete">
        <h2>このアンケートURLは終了しています</h2>
        <p>回答済み、または受付が終了したURLです。再回答が必要な場合は、ミユキハウジングから新しいURLをお送りします。</p>
      </div>
    </section>
  </main>
  <?php
}

function miyuki_maybe_render_voice_survey_public_page() {
  if (empty($_GET['miyuki_survey'])) {
    return;
  }

  $token  = sanitize_text_field(wp_unslash($_GET['miyuki_survey']));
  $survey = miyuki_get_voice_survey_by_token($token);

  if (!$survey) {
    status_header(404);
    get_header();
    echo '<main class="miyuki-survey-page"><section class="miyuki-survey-shell"><h1>アンケートが見つかりません</h1><p>URLをご確認ください。</p></section></main>';
    get_footer();
    exit;
  }

  if (!miyuki_voice_survey_url_is_active($survey->ID)) {
    get_header();
    miyuki_render_voice_survey_closed_page();
    get_footer();
    exit;
  }

  get_header();
  miyuki_render_voice_survey_public_form($survey);
  get_footer();
  exit;
}
add_action('template_redirect', 'miyuki_maybe_render_voice_survey_public_page');

function miyuki_render_voice_survey_public_form($survey) {
  $survey_id    = absint($survey->ID);
  $token        = miyuki_voice_survey_meta($survey_id, 'token');
  $submitted_at = miyuki_voice_survey_meta($survey_id, 'submitted_at');
  $is_complete  = !empty($_GET['submitted']) || ($submitted_at && !miyuki_voice_survey_form_is_open($survey_id));
  $intro        = miyuki_voice_survey_meta($survey_id, 'intro', 'ご回答内容は確認後に社内で管理します。許可なくホームページに公開されることはありません。');
  $questions    = miyuki_get_voice_survey_questions($survey_id);
  ?>
  <main class="miyuki-survey-page">
    <section class="miyuki-survey-shell">
      <div class="miyuki-survey-heading">
        <p>MIYUKI HOUSING</p>
        <h1><?php echo esc_html(get_the_title($survey_id)); ?></h1>
        <span><?php echo nl2br(esc_html($intro)); ?></span>
      </div>

      <?php if ($is_complete) : ?>
        <div class="miyuki-survey-complete">
          <h2>ご回答ありがとうございました</h2>
          <p>内容を確認し、今後の住まいづくりに活用させていただきます。</p>
        </div>
      <?php else : ?>
        <form class="miyuki-survey-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
          <?php wp_nonce_field('miyuki_voice_survey_submit_' . $token, 'miyuki_voice_survey_nonce'); ?>
          <input type="hidden" name="action" value="miyuki_voice_survey_submit">
          <input type="hidden" name="survey_id" value="<?php echo esc_attr($survey_id); ?>">
          <input type="hidden" name="survey_token" value="<?php echo esc_attr($token); ?>">

          <section class="miyuki-survey-card">
            <h2>基本情報</h2>
            <div class="miyuki-survey-grid">
              <label>お名前・イニシャル
                <input type="text" name="miyuki_survey_customer_name" required placeholder="例：K様">
              </label>
              <label>エリア
                <input type="text" name="miyuki_survey_customer_area" placeholder="例：広島市東区">
              </label>
              <label>ご連絡先（社内確認用）
                <input type="text" name="miyuki_survey_customer_contact" placeholder="メールまたは電話番号">
              </label>
              <label>工事内容
                <select name="miyuki_survey_category">
                  <option value="">選択してください</option>
                  <?php foreach (miyuki_voice_category_options() as $category) : ?>
                    <option value="<?php echo esc_attr($category); ?>"><?php echo esc_html($category); ?></option>
                  <?php endforeach; ?>
                </select>
              </label>
              <label>満足度
                <select name="miyuki_survey_satisfaction">
                  <option value="">選択してください</option>
                  <option value="5">5 とても満足</option>
                  <option value="4">4 満足</option>
                  <option value="3">3 普通</option>
                  <option value="2">2 やや不満</option>
                  <option value="1">1 不満</option>
                </select>
              </label>
            </div>
          </section>

          <section class="miyuki-survey-card">
            <h2>一言コメント</h2>
            <textarea name="miyuki_survey_quote" rows="4" placeholder="例：相談しやすく、安心して家づくりを進められました。"></textarea>
          </section>

          <?php foreach ($questions as $question) : ?>
            <?php
            $key = sanitize_key($question['key']);
            $label = $question['label'];
            ?>
            <section class="miyuki-survey-card">
              <h2><?php echo esc_html($label); ?></h2>
              <textarea name="miyuki_survey_answer[<?php echo esc_attr($key); ?>]" rows="5" placeholder="自由にご記入ください。"></textarea>
              <label class="miyuki-survey-file">写真を追加（任意・複数可）
                <input type="file" name="miyuki_survey_question_<?php echo esc_attr($key); ?>_images[]" accept="image/*,.heic,.heif" multiple>
              </label>
            </section>
          <?php endforeach; ?>

          <section class="miyuki-survey-card">
            <h2>その他の写真</h2>
            <label class="miyuki-survey-file">掲載候補の写真をまとめて追加できます
              <input type="file" name="miyuki_survey_gallery_images[]" accept="image/*,.heic,.heif" multiple>
            </label>
          </section>

          <section class="miyuki-survey-card">
            <h2>掲載許可</h2>
            <p>チェックがない場合でもアンケートは送信できます。ホームページ掲載は、許可をいただいた内容だけ確認後に使用します。</p>
            <div class="miyuki-survey-checks">
              <label><input type="checkbox" name="miyuki_survey_publish_permission" value="1"> ホームページへの掲載を許可します</label>
              <label><input type="checkbox" name="miyuki_survey_photo_permission" value="1"> 写真の掲載を許可します</label>
              <label><input type="checkbox" name="miyuki_survey_name_permission" value="1"> お名前・イニシャルの掲載を許可します</label>
            </div>
          </section>

          <button type="submit" class="miyuki-survey-submit">送信する</button>
        </form>
      <?php endif; ?>
    </section>
  </main>
  <?php
}

function miyuki_handle_voice_survey_file_group($field_name, $post_id) {
  if (empty($_FILES[$field_name]['name']) || !is_array($_FILES[$field_name]['name'])) {
    return [];
  }

  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';

  $files = $_FILES[$field_name];
  $attachment_ids = [];

  foreach ($files['name'] as $index => $name) {
    if ($name === '' || (int) $files['error'][$index] === UPLOAD_ERR_NO_FILE) {
      continue;
    }

    if ((int) $files['error'][$index] !== UPLOAD_ERR_OK) {
      continue;
    }

    $_FILES['miyuki_survey_upload'] = [
      'name'     => $files['name'][$index],
      'type'     => $files['type'][$index],
      'tmp_name' => $files['tmp_name'][$index],
      'error'    => $files['error'][$index],
      'size'     => $files['size'][$index],
    ];

    $attachment_id = media_handle_upload('miyuki_survey_upload', $post_id);
    if (!is_wp_error($attachment_id)) {
      $attachment_ids[] = absint($attachment_id);
    }
  }

  unset($_FILES['miyuki_survey_upload']);
  return $attachment_ids;
}

function miyuki_handle_voice_survey_submit() {
  $survey_id = isset($_POST['survey_id']) ? absint($_POST['survey_id']) : 0;
  $token     = isset($_POST['survey_token']) ? sanitize_text_field(wp_unslash($_POST['survey_token'])) : '';
  $survey    = $survey_id ? get_post($survey_id) : null;

  if (!$survey || $survey->post_type !== 'voice_survey' || miyuki_voice_survey_meta($survey_id, 'token') !== $token) {
    wp_die('アンケートが見つかりません。');
  }

  if (!isset($_POST['miyuki_voice_survey_nonce']) || !wp_verify_nonce($_POST['miyuki_voice_survey_nonce'], 'miyuki_voice_survey_submit_' . $token)) {
    wp_die('不正な送信です。');
  }

  if (!miyuki_voice_survey_form_is_open($survey_id)) {
    wp_safe_redirect(add_query_arg('submitted', '1', miyuki_voice_survey_public_url($token)));
    exit;
  }

  $fields = [
    'customer_name'    => 'sanitize_text_field',
    'customer_area'    => 'sanitize_text_field',
    'customer_contact' => 'sanitize_text_field',
    'category'         => 'sanitize_text_field',
    'satisfaction'     => 'sanitize_text_field',
    'quote'            => 'sanitize_textarea_field',
  ];

  foreach ($fields as $key => $sanitize_callback) {
    $post_key = 'miyuki_survey_' . $key;
    $value = isset($_POST[$post_key]) ? call_user_func($sanitize_callback, wp_unslash($_POST[$post_key])) : '';
    update_post_meta($survey_id, miyuki_voice_survey_meta_key($key), $value);
  }

  $answers = isset($_POST['miyuki_survey_answer']) && is_array($_POST['miyuki_survey_answer']) ? wp_unslash($_POST['miyuki_survey_answer']) : [];
  foreach (miyuki_get_voice_survey_questions($survey_id) as $question) {
    $key = sanitize_key($question['key']);
    $legacy_post_key = 'miyuki_survey_' . $key;
    $answer = isset($answers[$key]) ? sanitize_textarea_field($answers[$key]) : '';
    if ($answer === '' && isset($_POST[$legacy_post_key])) {
      $answer = sanitize_textarea_field(wp_unslash($_POST[$legacy_post_key]));
    }
    update_post_meta($survey_id, miyuki_voice_survey_meta_key($key), $answer);

    $image_ids = miyuki_handle_voice_survey_file_group('miyuki_survey_question_' . $key . '_images', $survey_id);
    if (empty($image_ids)) {
      $image_ids = miyuki_handle_voice_survey_file_group($legacy_post_key . '_images', $survey_id);
    }
    if (!empty($image_ids)) {
      update_post_meta($survey_id, miyuki_voice_survey_image_meta_key($key), implode(',', $image_ids));
    }
  }

  $gallery_ids = miyuki_handle_voice_survey_file_group('miyuki_survey_gallery_images', $survey_id);
  if (!empty($gallery_ids)) {
    update_post_meta($survey_id, '_miyuki_survey_gallery_ids', implode(',', $gallery_ids));
  }

  update_post_meta($survey_id, '_miyuki_survey_publish_permission', !empty($_POST['miyuki_survey_publish_permission']) ? '1' : '0');
  update_post_meta($survey_id, '_miyuki_survey_photo_permission', !empty($_POST['miyuki_survey_photo_permission']) ? '1' : '0');
  update_post_meta($survey_id, '_miyuki_survey_name_permission', !empty($_POST['miyuki_survey_name_permission']) ? '1' : '0');
  update_post_meta($survey_id, '_miyuki_survey_submitted_at', current_time('mysql'));
  delete_post_meta($survey_id, '_miyuki_survey_reissued_at');

  $customer_name = miyuki_voice_survey_meta($survey_id, 'customer_name', 'お客様');
  wp_update_post([
    'ID'          => $survey_id,
    'post_status' => 'pending',
    'post_title'  => 'アンケート回答 - ' . $customer_name . ' - ' . current_time('Y.m.d'),
  ]);

  wp_safe_redirect(add_query_arg('submitted', '1', miyuki_voice_survey_public_url($token)));
  exit;
}
add_action('admin_post_miyuki_voice_survey_submit', 'miyuki_handle_voice_survey_submit');
add_action('admin_post_nopriv_miyuki_voice_survey_submit', 'miyuki_handle_voice_survey_submit');

function miyuki_voice_survey_make_voice_title($survey_id) {
  $quote = miyuki_voice_survey_meta($survey_id, 'quote');
  if ($quote !== '') {
    return function_exists('mb_substr') && function_exists('mb_strlen') && mb_strlen($quote) > 34 ? mb_substr($quote, 0, 34) . '...' : $quote;
  }

  $area = miyuki_voice_survey_meta($survey_id, 'customer_area');
  $name = miyuki_voice_survey_meta($survey_id, 'customer_name', 'お客様');
  return trim(($area ? $area . ' ' : '') . $name . 'の声');
}

function miyuki_create_voice_from_survey($survey_id) {
  if (!miyuki_voice_survey_bool($survey_id, 'publish_permission')) {
    return new WP_Error('permission_denied', 'HP掲載許可がありません。');
  }

  $photo_allowed = miyuki_voice_survey_bool($survey_id, 'photo_permission');
  $name_allowed  = miyuki_voice_survey_bool($survey_id, 'name_permission');
  $main_image_id = 0;
  $gallery_ids   = $photo_allowed ? miyuki_get_voice_survey_gallery_ids($survey_id) : [];
  $voice_keys    = array_keys(miyuki_voice_question_labels());

  $data = [
    'customer_name'   => $name_allowed ? miyuki_voice_survey_meta($survey_id, 'customer_name') : '匿名希望',
    'customer_area'   => miyuki_voice_survey_meta($survey_id, 'customer_area'),
    'category'        => miyuki_voice_survey_meta($survey_id, 'category'),
    'quote'           => miyuki_voice_survey_meta($survey_id, 'quote'),
    'problem'         => '',
    'reason'          => '',
    'good'            => '',
    'after'           => '',
    'image_id'        => 0,
    'gallery_raw'     => '',
    'related_work_id' => 0,
  ];

  foreach (miyuki_voice_question_labels() as $key => $label) {
    $data[$key . '_label'] = $label;
    $data[$key . '_image_ids_raw'] = '';
  }

  $extra_answers = [];
  $extra_images = [];
  foreach (miyuki_get_voice_survey_questions($survey_id) as $index => $question) {
    $survey_key = sanitize_key($question['key']);
    $label = $question['label'];
    $answer = miyuki_voice_survey_meta($survey_id, $survey_key);
    $image_ids = $photo_allowed ? miyuki_get_voice_survey_question_image_ids($survey_id, $survey_key) : [];

    if ($index < count($voice_keys)) {
      $voice_key = $voice_keys[$index];
      $data[$voice_key] = $answer;
      $data[$voice_key . '_label'] = $label;
      $data[$voice_key . '_image_ids_raw'] = implode(',', $image_ids);
    } else {
      if ($answer !== '') {
        $extra_answers[] = '【' . $label . "】\n" . $answer;
      }
      $extra_images = array_merge($extra_images, $image_ids);
    }

    if (!$main_image_id && !empty($image_ids)) {
      $main_image_id = $image_ids[0];
    }
  }

  if (!empty($extra_answers)) {
    $extra_text = implode("\n\n", $extra_answers);
    if ($data['after'] !== '') {
      $data['after'] .= "\n\n" . $extra_text;
    } else {
      $data['after'] = $extra_text;
      $data['after_label'] = 'その他のご回答';
    }
  }

  if (!empty($extra_images)) {
    $gallery_ids = array_merge($gallery_ids, $extra_images);
  }

  if (!$main_image_id && !empty($gallery_ids)) {
    $main_image_id = $gallery_ids[0];
  }
  $data['image_id'] = $main_image_id;
  $data['gallery_raw'] = $photo_allowed ? implode(',', array_values(array_unique(array_map('absint', $gallery_ids)))) : '';

  $voice_id = wp_insert_post([
    'post_type'    => 'voice',
    'post_status'  => 'draft',
    'post_title'   => miyuki_voice_survey_make_voice_title($survey_id),
    'post_content' => miyuki_voice_build_content($data),
    'post_excerpt' => $data['quote'],
    'menu_order'   => miyuki_get_next_voice_menu_order(),
  ], true);

  if (is_wp_error($voice_id)) {
    return $voice_id;
  }

  miyuki_update_voice_template_fields($voice_id, $data);
  update_post_meta($survey_id, '_miyuki_survey_converted_voice_id', absint($voice_id));

  return absint($voice_id);
}

function miyuki_handle_voice_survey_convert() {
  if (!current_user_can('edit_posts')) {
    wp_die('この操作を実行する権限がありません。');
  }

  $survey_id = isset($_POST['survey_id']) ? absint($_POST['survey_id']) : 0;
  $survey = $survey_id ? get_post($survey_id) : null;
  if (!$survey || $survey->post_type !== 'voice_survey') {
    wp_die('アンケートが見つかりません。');
  }

  if (!isset($_POST['miyuki_voice_survey_convert_nonce']) || !wp_verify_nonce($_POST['miyuki_voice_survey_convert_nonce'], 'miyuki_voice_survey_convert_' . $survey_id)) {
    wp_die('不正な送信です。');
  }

  $voice_id = miyuki_create_voice_from_survey($survey_id);
  if (is_wp_error($voice_id)) {
    $error = $voice_id->get_error_code() === 'permission_denied' ? 'convert_permission' : 'save';
    wp_safe_redirect(add_query_arg([
      'miyuki_survey_error' => $error,
    ], miyuki_voice_survey_admin_detail_url($survey_id)));
    exit;
  }

  wp_safe_redirect(add_query_arg([
    'from_survey'           => $survey_id,
    'miyuki_survey_message' => 'converted',
  ], miyuki_voice_easy_edit_url($voice_id)));
  exit;
}
add_action('admin_post_miyuki_voice_survey_convert', 'miyuki_handle_voice_survey_convert');


/* ============================================================
   セッション開始（WordPress の init より早く）
   ============================================================ */
add_action( 'init', function () {
  if ( session_status() === PHP_SESSION_NONE ) {
    session_start();
  }
}, 1 );


/* ============================================================
   お問い合わせ・資料請求・来店予約 CSS のエンキュー
   ============================================================ */
add_action( 'wp_enqueue_scripts', function () {
  if ( is_page( 'contact' ) || is_page( 'request' ) || is_page( 'visit' ) ) {
    wp_enqueue_style(
      'miyuki-contact',
      get_template_directory_uri() . '/assets/css/contact.css',
      [],
      '1.0.0'
    );
  }
} );

// Instagram API
function get_instagram_posts($limit = 9) {
    $access_token = 'IGAASchPHrrZCZABZAGJMZAjVpQzJNMEF1OVhCazRFRGMwSzEybTZAxakNodVBONW5XdnJsLXVKNXV4SUhBdGFzcFdCZA1dWYnJPLW1aZAkQ5UkQ3UVJOU3FOU3BDSUZAlZAVd6VV9RZAWtVR0FMSEpYaUNWR1R0UFA1X2Fld2VvNjI4bDVnOAZDZD';
    $user_id = '17841416223079144';
    
    $cache_key = 'instagram_posts_cache';
    $cached = get_transient($cache_key);
    
    if ($cached !== false) {
        return $cached;
    }
    
    $url = "https://graph.instagram.com/v21.0/{$user_id}/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,timestamp&limit={$limit}&access_token={$access_token}";
    
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return [];
    }
    
    $body = json_decode(wp_remote_retrieve_body($response), true);
    
    if (empty($body['data'])) {
        return [];
    }
    
    // 1時間キャッシュ
    set_transient($cache_key, $body['data'], HOUR_IN_SECONDS);
    
    return $body['data'];
}
