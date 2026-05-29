<?php
/* Template Name: コンセプト */
get_header(); ?>

<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Concept</span>
    <span class="page-hero-ja">コンセプト</span>
  </div>
</div>

<main>

<!-- ABOUT -->
<section class="section">
  <div class="container">

    <div class="section-header">
      <h2 class="section-title">
        <span class="section-title-main">ABOUT</span>
        <span class="section-title-sub">私たちについて</span>
      </h2>
    </div>

    <!-- 上段：写真左・テキスト右 -->
    <div class="about-row">
      <div class="about-photo">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/about-011.jpg"
             alt="ミユキハウジング ショールーム">
      </div>
      <div class="about-texts">
        <div class="about-item mb-2 mb-xl-5 px-3 px-sm-1">
          <span class="about-item-number">01</span>
          <h3 class="about-item-title">暮らしに、ちょうどいい距離感を。</h3>
          <p class="about-item-text">
            広島市東区曙を拠点に、顔の見える関係を大切にしています。<br>
            建築工事もリフォームも、暮らしや建物の状態に寄り添いながら丁寧に形にしていきます。
          </p>
        </div>
        <div class="about-item px-3 px-sm-1">
          <span class="about-item-number">02</span>
          <h3 class="about-item-title">ミユキハウジングでつくる、あなたの暮らし</h3>
          <p class="about-item-text">
            一つひとつのご相談にしっかり向き合い、ご家族や事業の使い方に合った空間を一緒につくっていきます。<br>
            建物を整えることは、これからの暮らしや仕事の時間を整えること。その時間に寄り添える存在でありたいと思っています。
          </p>
        </div>
      </div>
    </div>

    <!-- 下段：テキスト左・写真右 -->
    <div class="about-row about-row-reverse">
      <div class="about-photo">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/about-021.jpg"
             alt="ミユキハウジング スタッフ打ち合わせ">
      </div>
      <div class="about-texts">
        <div class="about-item mb-2 mb-xl-5 px-3 px-sm-1">
          <span class="about-item-number">03</span>
          <h3 class="about-item-title">建築も、リフォームも。ずっとそばに</h3>
          <p class="about-item-text">
            新しく建てるときも、今の建物を直すときも。<br>
            暮らしや仕事の節目には、いつでも頼っていただける存在でありたい。<br>
            大きなことも、小さなことも気軽に相談できる。そんな"近くの工務店"であり続けます。
          </p>
        </div>
        <div class="about-item px-3 px-sm-1">
          <span class="about-item-number">04</span>
          <h3 class="about-item-title">「話しやすい」が、いちばんの強みです</h3>
          <p class="about-item-text">
            建築やリフォームは、わからないことや不安も多いもの。<br>
            だからこそ、何でも気軽に話せる関係を大切にしています。<br>
            やわらかくて安心できる進め方で、建物の相談に向き合います。
          </p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ============================================================
  ものづくりの信念
============================================================ -->
<section class="section section-alt" id="belief">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">
        <span class="section-title-main">BELIEF</span>
        <span class="section-title-sub">ものづくりの理念</span>
      </h2>
      <p class="section-subtitle">私たちがものづくりで大切にしていること</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8 px-4">
        <div class="belief-body">
          <p>
            私たちは、広島で暮らし、広島市東区を拠点に仕事をしています。<br>
            だからこそ、ここで暮らす方々の気候や風土、日々の暮らし方を大切にした建築・リフォームを心がけています。
          </p>
          <p>
            建物は建てて終わり、直して終わりではなく、そこから長い時間を過ごしていく場所です。<br>
            何かあったときにすぐに顔を出せること。そんな距離の近い関係を、何より大切にしています。
          </p>
          <p>
            一棟一棟、一人ひとりのお客様としっかり向き合い、最初から最後まで責任をもって関わり続けます。<br>
            建築も、リフォームも。大きな工事も、小さな修繕も。
          </p>
          <p class="belief-quote">
            この地域で暮らす皆さまの"これから"に寄り添いながら、<br>
            安心して長く使い続けられる建物を、一緒に整えていきます。
          </p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
  他社との違い（強み）
============================================================ -->
<section class="section" id="strength">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">
        <span class="section-title-main">STRENGTH</span>
        <span class="section-title-sub">他社との違い</span>
      </h2>
      <p class="section-subtitle">ミユキハウジングが選ばれる5つの理由</p>
    </div>

    <div class="row g-4 justify-content-center">

      <!-- 強み 01 自由設計 -->
      <div class="col-md-4">
        <div class="strength-card">
          <div class="strength-number">01</div>
          <h3 class="strength-title">自由設計</h3>
          <p class="strength-text">
            規格品にとらわれず、お客様の「こうしたい」を形にします。間取り・素材・仕様すべてにおいてご要望に柔軟に対応し、世界に一つだけの住まいをご提案します。
          </p>
        </div>
      </div>

      <!-- 強み 02 高断熱住宅 -->
      <div class="col-md-4">
        <div class="strength-card">
          <div class="strength-number">02</div>
          <h3 class="strength-title">高断熱住宅</h3>
          <p class="strength-text">
            優れた断熱性能により、夏は涼しく冬は暖かい快適な住環境を実現します。光熱費の削減にもつながり、長く住むほどそのメリットを実感いただけます。
          </p>
        </div>
      </div>

      <!-- 強み 03 地元密着 -->
      <div class="col-md-4">
        <div class="strength-card">
          <div class="strength-number">03</div>
          <h3 class="strength-title">地元密着</h3>
          <p class="strength-text">
            広島で長年にわたり地域に根ざした施工を続けてきました。地元の気候・風土を熟知した職人が、迅速かつ丁寧に対応。アフターフォローも安心です。
          </p>
        </div>
      </div>

      <!-- 強み 04 自然素材 -->
      <div class="col-md-4">
        <div class="strength-card">
          <div class="strength-number">04</div>
          <h3 class="strength-title">自然素材</h3>
          <p class="strength-text">
            体に優しく、時を経るほど味わいが増す自然素材を積極的に採用しています。木の温もりや質感を活かした住まいは、長く愛着を持って暮らしていただけます。
          </p>
        </div>
      </div>

      <!-- 強み 05 デザイン住宅 -->
      <div class="col-md-4">
        <div class="strength-card">
          <div class="strength-number">05</div>
          <h3 class="strength-title">デザイン住宅</h3>
          <p class="strength-text">
            機能性と美しさを両立した住まいをご提案します。暮らしやすさを追求しながら、お客様のライフスタイルに合ったデザインを丁寧に形にします。
          </p>
        </div>
      </div>

    </div>

    <!-- 新築＋リフォームのリード -->
    <div class="row justify-content-center mt-5">
      <div class="col-lg-8">
        <div class="belief-body text-center px-2 px-sm-1">
          <p>
            新しく建てるときも、<br class="d-block d-sm-none">今の住まいをより良くするときも。<br>
            暮らしに関わることを、ずっと任せていただける<br class="d-block d-sm-none">存在でありたいと思っています。<br>
            施工して終わりではなく、<br class="d-block d-sm-none">その先の暮らしまで見守り続けること。<br class="d-block d-sm-none">それが、私たちのものづくりです。
          </p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ご相談から施工までの流れ -->
<section class="section section-alt" id="flow">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">
        <span class="section-title-main">FLOW</span>
        <span class="section-title-sub">ご相談から施工までの流れ</span>
      </h2>
      <p class="section-subtitle">建築工事も、リフォームも、メンテナンスも。<br class="d-block d-sm-none">一緒に進んでいきましょう。</p>
    </div>
    <div class="flow-steps">

      <div class="flow-step">
        <div class="flow-step-illust">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/flow_01.jpg"
               alt="まずはご相談から始まります"
               loading="lazy">
          <span class="flow-step-number-overlay">01</span>
        </div>
        <div class="flow-step-content">
          <h3 class="flow-step-title">まずはご相談から始まります</h3>
          <p class="flow-step-text">「建物を直したい」「今の空間をもう少し使いやすくしたい」<br>
          そんな想いが浮かんだときに、まずはお気軽にご連絡ください。<br>
          建築でもリフォームでもメンテナンスでも大丈夫です。私たちが直接お話をお聞きします。</p>
        </div>
      </div>

      <div class="flow-arrow">↓</div>

      <div class="flow-step">
        <div class="flow-step-illust">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/flow_04.jpg"
               alt="暮らしのお話を聞かせてください"
               loading="lazy">
          <span class="flow-step-number-overlay">02</span>
        </div>
        <div class="flow-step-content">
          <h3 class="flow-step-title">暮らしのお話を聞かせてください</h3>
          <p class="flow-step-text">どんな毎日を過ごしたいのか、今どんなことに困っているのか。<br>
          新築や改修の方にはこれからの使い方を、リフォームの方には今のお住まいのことを、<br>
          じっくりお聞きしながら、一緒に方向性を見つけていきます。</p>
        </div>
      </div>

      <div class="flow-arrow">↓</div>

      <div class="flow-step">
        <div class="flow-step-illust">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/flow_03.jpg"
               alt="ご提案（プラン・アイデア）"
               loading="lazy">
          <span class="flow-step-number-overlay">03</span>
        </div>
        <div class="flow-step-content">
          <h3 class="flow-step-title">ご提案（プラン・アイデア）</h3>
          <p class="flow-step-text">お聞きした内容をもとに、プランや改善のアイデアをご提案します。<br>
          建築の場合は間取りやデザインを、リフォームの場合は「こう変えるともっと良くなる」<br>
          という具体的な工夫をお伝えします。</p>
        </div>
      </div>

      <div class="flow-arrow">↓</div>

      <div class="flow-step">
        <div class="flow-step-illust">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/flow_02.jpg"
               alt="一緒に悩んで、一緒に決める"
               loading="lazy">
          <span class="flow-step-number-overlay">04</span>
        </div>
        <div class="flow-step-content">
          <h3 class="flow-step-title">一緒に悩んで、一緒に決める</h3>
          <p class="flow-step-text">「これでいいのかな？」と迷う時間も大切にしています。<br>
          私たちも同じ目線で考えながら、無理のない形で、納得できる選択を一緒に見つけていきます。</p>
        </div>
      </div>

      <div class="flow-arrow">↓</div>

      <div class="flow-step">
        <div class="flow-step-illust">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/flow_05.jpg"
               alt="安心できたらご契約へ"
               loading="lazy">
          <span class="flow-step-number-overlay">05</span>
        </div>
        <div class="flow-step-content">
          <h3 class="flow-step-title">安心できたらご契約へ</h3>
          <p class="flow-step-text">内容やご予算、進め方にご納得いただけましたらご契約となります。<br>
          建築でもリフォームでもメンテナンスでも、「ここに頼んでよかった」と思っていただける関係づくりを大切にしています。</p>
        </div>
      </div>

    </div>
    
    <!-- お問い合わせ導線 -->
    <div class="text-center mt-5">
      <p class="mb-4" style="color: #4b5563;">まずはお気軽にご相談ください。現地調査・お見積りは無料です。</p>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-contact-large">お問い合わせはこちら</a>
    </div>
    
  </div>
</section>

</main>

<?php get_footer(); ?>
