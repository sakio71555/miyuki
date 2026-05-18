<footer class="footer">
  <div class="container">
    <div class="row g-4 mb-5">

      <div class="col-lg-4 col-md-6">
        <div class="footer-logo">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/logo-white.png" alt="<?php bloginfo('name'); ?>" class="logo-image me-2"><span>有限会社<br>ミユキハウジング</span></div>
        <p class="footer-description">
          広島県知事 許可（般-7）第35460号<br>
          建築・リフォーム・清掃・メンテナンスの建設会社
        </p>
        <div class="social-links">
          <a href="#" class="social-link" aria-label="Instagram">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="#" class="social-link" aria-label="X (Twitter)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
          </a>
          <a href="#" class="social-link" aria-label="LINE">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-6">
        <h3 class="footer-title">サービス</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/service#s-01')); ?>">建築施工</a></li><li><a href="<?php echo esc_url(home_url('/service#s-02')); ?>">リフォーム</a></li>
          <li><a href="<?php echo esc_url(home_url('/service#s-03')); ?>">清掃・メンテナンス</a></li>
			<li><a href="<?php echo esc_url(home_url('/works')); ?>">施工事例</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-6 col-6">
        <h3 class="footer-title">会社情報</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/concept')); ?>">コンセプト</a></li>
          <li><a href="<?php echo esc_url(home_url('/staff')); ?>">スタッフ紹介</a></li><li><a href="<?php echo esc_url(home_url('/voice')); ?>">お客様の声</a></li>
			<li><a href="<?php echo esc_url(home_url('/company')); ?>">会社概要</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-6">
        <h3 class="footer-title">お問い合わせ</h3>
        <ul class="footer-contact">
          <li>TEL: 082-263-8066</li>
          <li>FAX: 082-263-8067</li>
          <li>Email: m_mentenansu.i@helen.ocn.ne.jp</li>
          <li>〒732-0045<br>広島県広島市東区曙5丁目4-6</li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom">
      <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
    </div>
  </div>
</footer>
<!-- モバイル下部固定バー -->
<div class="mobile-bottom-bar d-lg-none">
  <a href="<?php echo esc_url(home_url('/visit')); ?>" class="mobile-bottom-item">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
    </svg>
    <span>来店予約</span>
  </a>
  <a href="<?php echo esc_url(home_url('/request')); ?>" class="mobile-bottom-item">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
    </svg>
    <span>資料請求</span>
  </a>
  <a href="<?php echo esc_url(home_url('/event')); ?>" class="mobile-bottom-item">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
    </svg>
    <span>イベント</span>
  </a>
  <a href="<?php echo esc_url(home_url('/contact')); ?>" class="mobile-bottom-item">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
    </svg>
    <span>お問い合わせ</span>
  </a>
</div>
<script>
const requestZipInput = document.getElementById('req_zip');
const requestAddressInput = document.getElementById('req_address');

if (requestZipInput && requestAddressInput) {
  requestZipInput.addEventListener('input', function () {
    const zip = this.value.replace(/[^0-9]/g, '');
    if (zip.length !== 7) return;

    fetch('https://zipcloud.ibsnet.co.jp/api/search?zipcode=' + zip)
        .then(res => res.json())
        .then(data => {
            if (data.results) {
                const r = data.results[0];
                const address = r.address1 + r.address2 + r.address3;
                requestAddressInput.value = address;
            }
        })
        .catch(() => {}); // エラーは無視
  });
}
</script>
<!-- 固定CTAボタン -->
<div class="fixed-cta">
  <a href="<?php echo esc_url(home_url('/visit')); ?>" class="cta-button cta-visit">
    <span class="cta-text">来店予約</span>
    <svg class="cta-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <polyline points="9 18 15 12 9 6"></polyline>
    </svg>
  </a>
  <a href="<?php echo esc_url(home_url('/request')); ?>" class="cta-button cta-documents">
    <span class="cta-text">資料請求</span>
    <svg class="cta-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <polyline points="9 18 15 12 9 6"></polyline>
    </svg>
  </a>
  <a href="<?php echo esc_url(home_url('/event')); ?>" class="cta-button cta-events">
    <span class="cta-text">イベント情報</span>
    <svg class="cta-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <polyline points="9 18 15 12 9 6"></polyline>
    </svg>
  </a>
</div>
<?php wp_footer(); ?>
</body>
</html>
