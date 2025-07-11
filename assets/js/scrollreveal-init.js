/**
 * ScrollReveal: Анимации для заголовков и секций
 *
 * Анимация:
 * - Заголовки секций (.section-title h3)
 * - Изображения под заголовками (.section-title img)
 */

document.addEventListener('DOMContentLoaded', function () {
  const sr = ScrollReveal({
    distance: '40px',
    duration: 800,
    easing: 'ease-out',
    reset: false,
  });

  // Анимация заголовков
  sr.reveal('.hero-section h1', {
    origin: 'bottom',
    delay: 200,
  });

  // Анимация заголовков
  sr.reveal('.section-title h3', {
    origin: 'bottom',
    delay: 200,
  });

  // Анимация изображений под заголовком
  sr.reveal('.section-title img', {
    origin: 'bottom',
    delay: 400,
  });

  // Анимация заголовков
  sr.reveal('.section-director-name', {
    origin: 'bottom',
    delay: 200,
  });

  // Анимация заголовков
  sr.reveal('.section-director-position', {
    origin: 'bottom',
    delay: 300,
  });

  // Анимация изображений под заголовком
  sr.reveal('.section-director-points', {
    origin: 'bottom',
    delay: 400,
  });
});