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
  return 'https://miyuki-housing.jp' . '/' . ltrim($path, '/');
}

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
