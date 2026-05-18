<?php
/* Template Name: 会社概要 */
get_header(); ?>

<!-- ページタイトル -->
<div class="page-hero">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="page-hero-en">Company</span>
    <span class="page-hero-ja">会社概要</span>
  </div>
</div>

<main class="page-company">
  <section class="section">
    <div class="container">

      <div class="row">
        <div class="col-xl-10 mx-auto">
          <table class="company-table">
            <tbody>
              <tr>
                <th>会社名</th>
                <td>有限会社ミユキハウジング</td>
              </tr>
              <tr>
                <th>代表者名</th>
                <td>代表取締役　奥田　順</td>
              </tr>
              <tr>
                <th>所在地</th>
                <td>〒732-0045　広島県広島市東区曙5丁目4-6</td>
              </tr>
              <tr>
                <th>電話番号</th>
                <td><a href="tel:0822638066">082-263-8066</a></td>
              </tr>
              <tr>
                <th>FAX</th>
                <td>082-263-8067</td>
              </tr>
              <tr>
                <th>メールアドレス</th>
                <td><a href="mailto:m_mentenansu.i@helen.ocn.ne.jp">m_mentenansu.i@helen.ocn.ne.jp</a></td>
              </tr>
              <tr>
                <th>対応エリア</th>
                <td>広島市を中心に広島県周辺</td>
              </tr>
              <tr>
                <th>営業時間</th>
                <td>8：30〜18：00</td>
              </tr>
              <tr>
                <th>定休日</th>
                <td>日曜日・祝日</td>
              </tr>
              <tr>
                <th>建設業許可番号</th>
                <td>広島県知事 許可（般-7）第35460号</td>
              </tr>
              <tr>
                <th>事業内容</th>
                <td>
                  建築一式工事<br>
                  住宅・店舗の建築施工及び設計・監理業務<br>
                  リフォーム・改修工事の設計・施工・管理業務<br>
                  建物の清掃・クリーニング・メンテナンス業務
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- お問い合わせ導線 -->
      <div class="text-center mt-5">
        <p class="mb-4" style="color: #4b5563;">ご不明な点はお気軽にお問い合わせください。</p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-contact-large">お問い合わせはこちら</a>
      </div>
    </div>
  </section>

  <!-- 地図 -->
  <div class="company-map">

    <div class="company-map-frame">
      <iframe
        src="https://maps.google.com/maps?q=〒732-0045+広島市東区曙5丁目4-6&output=embed&hl=ja"
        width="100%"
        height="100%"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        title="有限会社ミユキハウジング 地図">
      </iframe>
    </div>
  </div>

</main>

<?php get_footer(); ?>
