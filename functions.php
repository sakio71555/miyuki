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

function miyuki_default_description() {
  return '広島市東区曙の有限会社ミユキハウジング。建築工事、住宅・店舗のリフォーム、建物清掃、メンテナンスまで暮らしと建物を支えます。';
}

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
  if (is_admin()) {
    return null;
  }
  $seo = miyuki_current_seo_data();
  return $seo['title'];
});

add_action('wp_head', function() {
  if (is_admin()) {
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
  if (is_admin()) {
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
      'email' => 'm_mentenansu.i@helen.ocn.ne.jp',
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
    'supports'      => ['title', 'editor', 'thumbnail', 'custom-fields'],
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
    'supports'      => ['title', 'editor', 'thumbnail', 'custom-fields'],
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
});


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
