// メニュートグル
document.addEventListener('DOMContentLoaded', function() {

  function decodeEmailPart(value) {
    try {
      return atob(value || '');
    } catch (error) {
      return '';
    }
  }

  document.querySelectorAll('.miyuki-email-link').forEach(element => {
    element.addEventListener('click', event => {
      const user = decodeEmailPart(element.dataset.user);
      const domain = decodeEmailPart(element.dataset.domain);

      if (!user || !domain) return;

      const email = `${user}@${domain}`;
      event.preventDefault();
      element.textContent = email;
      element.href = `mailto:${email}`;
      window.location.href = `mailto:${email}`;
    });
  });

  // スクロール時のヘッダー背景変更 + スマートスクロール
  const header = document.querySelector('.site-header');
  let lastScrollY = 0;

  if (header) {
    header.classList.toggle('scrolled', window.scrollY > 50);
    window.addEventListener('scroll', function() {
      const currentScrollY = window.scrollY;
      header.classList.toggle('scrolled', currentScrollY > 50);
      if (currentScrollY > 50) {
        if (currentScrollY > lastScrollY) {
          header.style.transform = 'translateY(-100%)';
        } else {
          header.style.transform = 'translateY(0)';
        }
      } else {
        header.style.transform = 'translateY(0)';
      }
      lastScrollY = currentScrollY;
    });
  }

  // スムーズスクロール
  document.querySelectorAll('a[href^="#"]:not(.miyuki-email-link)').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // FAQアコーディオン
  const faqQuestions = document.querySelectorAll('.faq-question');
  faqQuestions.forEach(question => {
    question.addEventListener('click', function() {
      const item = this.parentElement;
      const answer = item.querySelector('.faq-answer');
      const isOpen = answer.style.display === 'block';
      document.querySelectorAll('.faq-answer').forEach(a => {
        a.style.display = 'none';
      });
      if (!isOpen) {
        answer.style.display = 'block';
      }
    });
  });

  // フォーム送信処理
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(contactForm);
      const data = {};
      formData.forEach((value, key) => { data[key] = value; });
      const formContainer = document.querySelector('.form-container');
      if (formContainer) {
        formContainer.innerHTML = `
          <div style="background: #f0fdf4; border: 2px solid #86efac; border-radius: 12px; padding: 3rem; text-align: center;">
            <div style="width: 64px; height: 64px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2">
                <path d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">送信完了</h3>
            <p style="color: #4b5563;">お問い合わせありがとうございます。<br>担当者より折り返しご連絡いたします。</p>
          </div>
        `;
        setTimeout(() => { location.reload(); }, 3000);
      }
    });
  }

  // ニュースカルーセル
  const newsCardsWrapper = document.querySelector('.news-cards-wrapper');
  if (newsCardsWrapper) {
    const newsCardsContainer = newsCardsWrapper.querySelector('.news-cards');
    const newsCards = document.querySelectorAll('.news-card');
    const prevBtn = newsCardsWrapper.querySelector('.carousel-prev');
    const nextBtn = newsCardsWrapper.querySelector('.carousel-next');
    const dotsContainer = newsCardsWrapper.querySelector('.carousel-dots');

    let currentIndex = 0;
    let autoScrollInterval;
    let isUserInteracting = false;
    let scrollTimeout;

    function createDots() {
      if (newsCards.length === 0) return;
      const visibleCards = Math.floor(newsCardsContainer.offsetWidth / newsCards[0].offsetWidth);
      const totalDots = Math.max(1, newsCards.length - visibleCards + 1);
      dotsContainer.innerHTML = '';
      for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement('button');
        dot.className = 'carousel-dot';
        dot.setAttribute('aria-label', `スライド ${i + 1}`);
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {
          currentIndex = i;
          scrollToIndex(i);
          updateDots();
        });
        dotsContainer.appendChild(dot);
      }
    }

    function scrollToIndex(index) {
      if (newsCards[index]) {
        const cardWidth = newsCards[0].offsetWidth + 24;
        newsCardsContainer.scrollTo({ left: cardWidth * index, behavior: 'smooth' });
      }
    }

    function updateDots() {
      const dots = dotsContainer.querySelectorAll('.carousel-dot');
      dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
      });
    }

    function autoScroll() {
      if (!isUserInteracting && newsCards.length > 0) {
        const dots = dotsContainer.querySelectorAll('.carousel-dot');
        currentIndex = (currentIndex + 1) % dots.length;
        scrollToIndex(currentIndex);
        updateDots();
      }
    }

    function startAutoScroll() {
      stopAutoScroll();
      autoScrollInterval = setInterval(autoScroll, 4000);
    }

    function stopAutoScroll() {
      clearInterval(autoScrollInterval);
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        isUserInteracting = true;
        currentIndex = Math.max(0, currentIndex - 1);
        scrollToIndex(currentIndex);
        updateDots();
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
          isUserInteracting = false;
          startAutoScroll();
        }, 2000);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        isUserInteracting = true;
        const dots = dotsContainer.querySelectorAll('.carousel-dot');
        currentIndex = Math.min(dots.length - 1, currentIndex + 1);
        scrollToIndex(currentIndex);
        updateDots();
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
          isUserInteracting = false;
          startAutoScroll();
        }, 2000);
      });
    }

    newsCardsContainer.addEventListener('scroll', () => {
      isUserInteracting = true;
      stopAutoScroll();
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        const cardWidth = newsCards[0].offsetWidth + 24;
        currentIndex = Math.round(newsCardsContainer.scrollLeft / cardWidth);
        updateDots();
        isUserInteracting = false;
        startAutoScroll();
      }, 500);
    });

    newsCardsWrapper.addEventListener('mouseenter', stopAutoScroll);
    newsCardsWrapper.addEventListener('mouseleave', () => {
      if (!isUserInteracting) startAutoScroll();
    });

    createDots();
    startAutoScroll();

    window.addEventListener('resize', () => {
      createDots();
      currentIndex = 0;
      updateDots();
    });
  }

  // プロジェクトカルーセル
  const projectsCarouselWrapper = document.querySelector('.projects-carousel-wrapper');
  if (projectsCarouselWrapper) {
    const projectsCarousel = projectsCarouselWrapper.querySelector('.projects-carousel');
    const projectCards = document.querySelectorAll('.project-card');
    const prevBtn = projectsCarouselWrapper.querySelector('.carousel-prev');
    const nextBtn = projectsCarouselWrapper.querySelector('.carousel-next');
    const dotsContainer = projectsCarouselWrapper.querySelector('.projects-carousel-dots');

    let currentProjectIndex = 0;
    let autoProjectScrollInterval;
    let isUserProjectInteracting = false;
    let scrollProjectTimeout;

    function createProjectDots() {
      if (projectCards.length === 0) return;
      const visibleCards = Math.floor(projectsCarousel.offsetWidth / projectCards[0].offsetWidth);
      const totalDots = Math.max(1, projectCards.length - visibleCards + 1);
      dotsContainer.innerHTML = '';
      for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement('button');
        dot.className = 'projects-carousel-dot';
        dot.setAttribute('aria-label', `スライド ${i + 1}`);
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {
          currentProjectIndex = i;
          scrollProjectToIndex(i);
          updateProjectDots();
        });
        dotsContainer.appendChild(dot);
      }
    }

    function scrollProjectToIndex(index) {
      if (projectCards[index]) {
        const cardWidth = projectCards[0].offsetWidth + 24;
        projectsCarousel.scrollTo({ left: cardWidth * index, behavior: 'smooth' });
      }
    }

    function updateProjectDots() {
      const dots = dotsContainer.querySelectorAll('.projects-carousel-dot');
      dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentProjectIndex);
      });
    }

    function autoProjectScroll() {
      if (!isUserProjectInteracting && projectCards.length > 0) {
        const dots = dotsContainer.querySelectorAll('.projects-carousel-dot');
        currentProjectIndex = (currentProjectIndex + 1) % dots.length;
        scrollProjectToIndex(currentProjectIndex);
        updateProjectDots();
      }
    }

    function startProjectAutoScroll() {
      stopProjectAutoScroll();
      autoProjectScrollInterval = setInterval(autoProjectScroll, 5000);
    }

    function stopProjectAutoScroll() {
      clearInterval(autoProjectScrollInterval);
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        isUserProjectInteracting = true;
        currentProjectIndex = Math.max(0, currentProjectIndex - 1);
        scrollProjectToIndex(currentProjectIndex);
        updateProjectDots();
        clearTimeout(scrollProjectTimeout);
        scrollProjectTimeout = setTimeout(() => {
          isUserProjectInteracting = false;
          startProjectAutoScroll();
        }, 2000);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        isUserProjectInteracting = true;
        const dots = dotsContainer.querySelectorAll('.projects-carousel-dot');
        currentProjectIndex = Math.min(dots.length - 1, currentProjectIndex + 1);
        scrollProjectToIndex(currentProjectIndex);
        updateProjectDots();
        clearTimeout(scrollProjectTimeout);
        scrollProjectTimeout = setTimeout(() => {
          isUserProjectInteracting = false;
          startProjectAutoScroll();
        }, 2000);
      });
    }

    projectsCarousel.addEventListener('scroll', () => {
      isUserProjectInteracting = true;
      stopProjectAutoScroll();
      clearTimeout(scrollProjectTimeout);
      scrollProjectTimeout = setTimeout(() => {
        if (projectCards.length > 0) {
          const cardWidth = projectCards[0].offsetWidth + 24;
          currentProjectIndex = Math.round(projectsCarousel.scrollLeft / cardWidth);
          updateProjectDots();
        }
        isUserProjectInteracting = false;
        startProjectAutoScroll();
      }, 500);
    });

    projectsCarouselWrapper.addEventListener('mouseenter', stopProjectAutoScroll);
    projectsCarouselWrapper.addEventListener('mouseleave', () => {
      if (!isUserProjectInteracting) startProjectAutoScroll();
    });

    createProjectDots();
    startProjectAutoScroll();

    window.addEventListener('resize', () => {
      createProjectDots();
      currentProjectIndex = 0;
      updateProjectDots();
    });
  }

  // Instagramカルーセル
  const instagramCarouselWrapper = document.querySelector('.instagram-carousel-wrapper');
  if (instagramCarouselWrapper) {
    const instagramCarousel = instagramCarouselWrapper.querySelector('.instagram-carousel');
    const prevBtn = instagramCarouselWrapper.querySelector('.carousel-prev');
    const nextBtn = instagramCarouselWrapper.querySelector('.carousel-next');
    const dotsContainer = instagramCarouselWrapper.querySelector('.instagram-carousel-dots');

    let currentInstagramIndex = 0;
    let autoInstagramScrollInterval;
    let isUserInstagramInteracting = false;
    let scrollInstagramTimeout;

    function getInstagramCards() {
      return instagramCarouselWrapper.querySelectorAll('.instagram-card');
    }

    function createInstagramDots() {
      const instagramCards = getInstagramCards();
      if (instagramCards.length === 0) return;
      const cardWidth = instagramCards[0].getBoundingClientRect().width || 280;
      const visibleCards = Math.floor(instagramCarousel.offsetWidth / cardWidth);
      const totalDots = Math.max(1, instagramCards.length - visibleCards + 1);
      dotsContainer.innerHTML = '';
      for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement('button');
        dot.className = 'instagram-carousel-dot';
        dot.setAttribute('aria-label', `スライド ${i + 1}`);
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {
          currentInstagramIndex = i;
          scrollInstagramToIndex(i);
          updateInstagramDots();
        });
        dotsContainer.appendChild(dot);
      }
    }

    function scrollInstagramToIndex(index) {
      const instagramCards = getInstagramCards();
      if (instagramCards[index]) {
        const cardWidth = instagramCards[0].getBoundingClientRect().width + 24;
        instagramCarousel.scrollTo({ left: cardWidth * index, behavior: 'smooth' });
      }
    }

    function updateInstagramDots() {
      const dots = dotsContainer.querySelectorAll('.instagram-carousel-dot');
      dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentInstagramIndex);
      });
    }

    function autoInstagramScroll() {
      const instagramCards = getInstagramCards();
      if (!isUserInstagramInteracting && instagramCards.length > 0) {
        const dots = dotsContainer.querySelectorAll('.instagram-carousel-dot');
        currentInstagramIndex = (currentInstagramIndex + 1) % dots.length;
        scrollInstagramToIndex(currentInstagramIndex);
        updateInstagramDots();
      }
    }

    function startInstagramAutoScroll() {
      stopInstagramAutoScroll();
      autoInstagramScrollInterval = setInterval(autoInstagramScroll, 5000);
    }

    function stopInstagramAutoScroll() {
      clearInterval(autoInstagramScrollInterval);
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        isUserInstagramInteracting = true;
        currentInstagramIndex = Math.max(0, currentInstagramIndex - 1);
        scrollInstagramToIndex(currentInstagramIndex);
        updateInstagramDots();
        clearTimeout(scrollInstagramTimeout);
        scrollInstagramTimeout = setTimeout(() => {
          isUserInstagramInteracting = false;
          startInstagramAutoScroll();
        }, 2000);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        isUserInstagramInteracting = true;
        const dots = dotsContainer.querySelectorAll('.instagram-carousel-dot');
        currentInstagramIndex = Math.min(dots.length - 1, currentInstagramIndex + 1);
        scrollInstagramToIndex(currentInstagramIndex);
        updateInstagramDots();
        clearTimeout(scrollInstagramTimeout);
        scrollInstagramTimeout = setTimeout(() => {
          isUserInstagramInteracting = false;
          startInstagramAutoScroll();
        }, 2000);
      });
    }

    instagramCarousel.addEventListener('scroll', () => {
      isUserInstagramInteracting = true;
      stopInstagramAutoScroll();
      clearTimeout(scrollInstagramTimeout);
      scrollInstagramTimeout = setTimeout(() => {
        const instagramCards = getInstagramCards();
        if (instagramCards.length > 0) {
          const cardWidth = instagramCards[0].getBoundingClientRect().width + 24;
          currentInstagramIndex = Math.round(instagramCarousel.scrollLeft / cardWidth);
          updateInstagramDots();
        }
        isUserInstagramInteracting = false;
        startInstagramAutoScroll();
      }, 500);
    });

    instagramCarouselWrapper.addEventListener('mouseenter', stopInstagramAutoScroll);
    instagramCarouselWrapper.addEventListener('mouseleave', () => {
      if (!isUserInstagramInteracting) startInstagramAutoScroll();
    });

    setTimeout(() => {
      createInstagramDots();
      startInstagramAutoScroll();
    }, 1000);

    window.addEventListener('resize', () => {
      createInstagramDots();
      currentInstagramIndex = 0;
      updateInstagramDots();
    });
  }

}); // DOMContentLoaded終わり

// コピーライト年自動更新
const yearEl = document.querySelector('.footer-bottom p');
if (yearEl) {
  yearEl.innerHTML = yearEl.innerHTML.replace(
    /\d{4}/,
    new Date().getFullYear()
  );
}

// 施工事例フィルター
if (document.querySelector('.filter-button[data-filter]')) {
  document.querySelectorAll('.filter-button[data-filter]').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelectorAll('.filter-button[data-filter]').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const filter = this.dataset.filter;
      const cards = document.querySelectorAll('.col-lg-4[data-category]');
      cards.forEach(card => {
        if (filter === 'all' || card.dataset.category === filter) {
          card.style.opacity = '0';
          card.style.display = '';
          requestAnimationFrame(() => {
            requestAnimationFrame(() => {
              card.style.opacity = '1';
            });
          });
        } else {
          card.style.display = 'none';
          card.style.opacity = '0';
        }
      });
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const lightbox = document.querySelector('.voice-lightbox');
  const lightboxImage = lightbox ? lightbox.querySelector('img') : null;
  const closeButton = lightbox ? lightbox.querySelector('.voice-lightbox-close') : null;
  const galleryItems = document.querySelectorAll('.voice-gallery-item[data-full-src]');

  if (!lightbox || !lightboxImage || !galleryItems.length) {
    return;
  }

  const closeLightbox = () => {
    lightbox.classList.remove('is-open');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    lightboxImage.removeAttribute('src');
    lightboxImage.setAttribute('alt', '');
  };

  galleryItems.forEach((item) => {
    item.addEventListener('click', () => {
      lightboxImage.src = item.dataset.fullSrc;
      lightboxImage.alt = item.dataset.alt || '';
      lightbox.classList.add('is-open');
      lightbox.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      if (closeButton) {
        closeButton.focus();
      }
    });
  });

  if (closeButton) {
    closeButton.addEventListener('click', closeLightbox);
  }

  lightbox.addEventListener('click', (event) => {
    if (event.target === lightbox) {
      closeLightbox();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && lightbox.classList.contains('is-open')) {
      closeLightbox();
    }
  });
});
