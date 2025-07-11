/**
 * Появление фиксированного заголовка при прокрутке
 * 
 * При прокрутке страницы больше чем на 100px, элемент с id="sliding-header"
 * получает класс "visible", благодаря которому он может, например, фиксироваться или анимированно появляться.
 * При прокрутке обратно вверх (меньше 100px) класс удаляется.
 * 
 * Используется флаг isVisible, чтобы избежать лишних изменений DOM.
 */

document.addEventListener('scroll', function () {
  var sliderHeader = document.getElementById('sliding-header');

  var prokrutka = window.pageYOffset;
  if (window.screen.width >= 992) {
    if (prokrutka > 300) {
      sliderHeader.style.top = '0px';
      sliderHeader.style.opacity = '1';
    } else if (prokrutka <= 300) {
      sliderHeader.style.top = '-100px';
      sliderHeader.style.opacity = '0';
    }
  }
});

/**
 * Параллакс-эффект для секции .hero-section
 * 
 * При прокрутке страницы элемент .hero-section смещается вверх,
 * создавая эффект параллакса. Скорость регулируется множителем 0.35.
 * 
 * Эффект применяется только если .hero-section есть в DOM.
 */

window.addEventListener('scroll', function () {
  const section = document.querySelector('.hero-section > div');
  const scrolled = window.scrollY;
  if (section) {
    // Параллакс через изменение позиции фона
    section.style.backgroundPositionY = `${50 - scrolled * 0.2}%`;
  }
});
