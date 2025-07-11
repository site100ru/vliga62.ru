<?php
/**
 * Block Name: Секция с партнерами
 * Description: Блок для отображения карусели с логотипами партнеров
 */

// Создаем уникальный ID для блока
$id = 'section-partners-' . $block['id'];
$slider_id = 'partners-glide-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

// Получаем данные из полей ACF
$title = get_field('partners_title');
$partners = get_field('partners', 'option'); // Получаем партнеров из страницы настроек
$background_color = get_field('background_color') ?: 'light';

// Определяем классы на основе настроек
$section_class = 'section section-glide';
$section_class .= $background_color === 'dark' ? ' bg-image text-white' : ' text-dark';

// Получаем настройки карусели
$slides_per_view = get_field('slides_per_view') ?: 5;
$slides_per_view_tablet = get_field('slides_per_view_tablet') ?: 3;
$slides_per_view_mobile = get_field('slides_per_view_mobile') ?: 2;
$left_arrow = get_field('left_arrow');
$right_arrow = get_field('right_arrow');
?>

<section id="<?php echo esc_attr($id); ?>"
  class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?>">
  <div class="container">
    <?php if (!empty($title)): ?>
      <div class="section-title text-center">
        <h3 class="<?php echo $background_color === 'dark' ? 'text-white' : 'text-dark'; ?>">
          <?php echo esc_html($title); ?>
        </h3>

        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png" class="img-fluid" alt="" />

      </div>
    <?php endif; ?>

    <?php if (!empty($partners)): ?>
      <div class="glide" id="<?php echo esc_attr($slider_id); ?>">
        <div class="glide__track" data-glide-el="track">
          <ul class="glide__slides">
            <?php foreach ($partners as $partner): ?>
              <li class="glide__slide text-center">
                <?php if (!empty($partner['link'])): ?>
                  <a href="<?php echo esc_url($partner['link']); ?>" target="_blank" rel="noopener noreferrer">
                  <?php endif; ?>
                  <img src="<?php echo esc_url($partner['logo']['url']); ?>" class="img-fluid w-100"
                    alt="<?php echo esc_attr($partner['logo']['alt'] ?: $partner['name']); ?>" />
                  <?php if (!empty($partner['link'])): ?>
                  </a>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="glide__arrows" data-glide-el="controls">
          <button class="glide__arrow glide__arrow--left btn-carousel-left" data-glide-dir="&lt;"
            aria-label="Предыдущий слайд">
            <?php if (!empty($left_arrow)): ?>
              <img src="<?php echo esc_url($left_arrow['url']); ?>" alt="Предыдущий" class="" loading="lazy" />
            <?php else: ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
            <?php endif; ?>
          </button>
          <button class="glide__arrow glide__arrow--right btn-carousel-right" data-glide-dir="&gt;"
            aria-label="Следующий слайд">
            <?php if (!empty($right_arrow)): ?>
              <img src="<?php echo esc_url($right_arrow['url']); ?>" alt="Следующий" class="" loading="lazy" />
            <?php else: ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            <?php endif; ?>
          </button>
        </div>
      </div>

      <script>
        document.addEventListener('DOMContentLoaded', function () {
          new Glide('#<?php echo esc_js($slider_id); ?>', {
            type: 'carousel',
            perView: <?php echo esc_js($slides_per_view); ?>,
            gap: 24,
            breakpoints: {
              992: {
                perView: <?php echo esc_js($slides_per_view_tablet); ?>
              },
              768: {
                perView: <?php echo esc_js($slides_per_view_mobile); ?>
              }
            }
          }).mount();
        });
      </script>
    <?php else: ?>
      <div class="alert alert-info">
        Нет доступных партнеров. Пожалуйста, добавьте партнеров в настройках сайта.
      </div>
    <?php endif; ?>
  </div>
</section>