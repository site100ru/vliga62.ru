document.addEventListener('DOMContentLoaded', function () {
  const carousel = document.querySelector('#carouselMain');

  function animateSlide(slide) {
    const image = slide.querySelector('.carousel-center-image');
    const title = slide.querySelector('.carousel-title');

    // Удалим прошлые классы
    document.querySelectorAll('.carousel-center-image, .carousel-title').forEach(el => {
      el.classList.remove('animate-up', 'delay-1', 'delay-2');
      el.style.opacity = 0;
    });

    // Добавим классы для текущего слайда
    if (image) {
      image.classList.add('animate-up', 'delay-1');
      image.style.opacity = 1;
    }

    if (title) {
      title.classList.add('animate-up', 'delay-2');
      title.style.opacity = 1;
    }
  }

  if (carousel) {
    const firstSlide = carousel.querySelector('.carousel-item.active');
    animateSlide(firstSlide);

    carousel.addEventListener('slid.bs.carousel', function () {
      const activeSlide = carousel.querySelector('.carousel-item.active');
      animateSlide(activeSlide);
    });
  }
});
