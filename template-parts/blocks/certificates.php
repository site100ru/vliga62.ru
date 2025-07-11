<?php
/**
 * Block Name: Сертификаты и лицензии
 * Description: Блок для отображения сертификатов и лицензий в карусели
 */

// Создаем уникальный ID для блока
$id = 'certificates-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$section_title = get_field('section_title') ?: 'Наши лицензии и сертификаты';
$background_color = get_field('background_color') ?: 'dark';

// Определяем классы на основе настроек
$section_class = 'section section-certificates';
$section_class .= $background_color === 'dark' ? ' bg-image text-white' : '';
$title_class = $background_color === 'dark' ? 'text-white' : 'text-dark';

// Получаем изображения сертификатов из настроек сайта 
$certificates = [];
if (function_exists('get_field')) {
  // Если для сайта настроено глобальное поле certificates на странице опций ACF
  $certificates = get_field('certificates', 'option');
}

// Если нет сертификатов из ACF, используем демо-данные
if (empty($certificates) || !is_array($certificates)) {
  $certificates = [
    [
      'url' => get_template_directory_uri() . '/assets/img/certificate-image/certificate-image-1.jpg',
      'alt' => 'Демо-сертификат 1'
    ],
    [
      'url' => get_template_directory_uri() . '/assets/img/certificate-image/certificate-image-2.jpg',
      'alt' => 'Демо-сертификат 2'
    ]
  ];
}

// Уникальный ID для карусели и модального окна
$carousel_id = 'certCarousel-' . $block['id'];
$modal_id = 'imageModal-' . $block['id'];

// ВАЖНОЕ ИЗМЕНЕНИЕ: Устанавливаем ТОЧНО 2 изображения на слайд
$items_per_slide = 2;

// Разбиваем массив сертификатов на группы по 2 для слайдов
$certificate_slides = array_chunk($certificates, $items_per_slide);
?>

<section id="<?php echo esc_attr($id); ?>"
  class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?>">
  <div class="container-fluid" id="certCarousel">
    <!-- Заголовок -->
    <div class="section-title text-center mb-5">
      <h3 class="<?php echo esc_attr($title_class); ?>"><?php echo esc_html($section_title); ?></h3>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png" alt="Декоративные точки"
        class="img-fluid" />
    </div>

    <!-- Карусель Bootstrap -->
    <?php if (!empty($certificate_slides)): ?>
      <div id="<?php echo esc_attr($carousel_id); ?>" class="carousel slide">
        <div class="carousel-inner">
          <?php
          foreach ($certificate_slides as $index => $slide_certificates):
            $is_active = $index === 0 ? 'active' : '';
            ?>
            <div class="carousel-item <?php echo esc_attr($is_active); ?>">
              <div class="row g-4 justify-content-center">
                <?php foreach ($slide_certificates as $certificate):
                  $img_url = isset($certificate['url']) ? $certificate['url'] : '';
                  $img_alt = isset($certificate['alt']) ? $certificate['alt'] : 'Сертификат';
                  ?>
                  <div class="col-6 col-lg-4 col-xl-3">
                    <div class="certificate-item">
                      <a href="<?php echo esc_url($img_url); ?>" class="certificate-link" data-bs-toggle="modal"
                        data-bs-target="#<?php echo esc_attr($modal_id); ?>" data-img-src="<?php echo esc_url($img_url); ?>">
                        <img src="<?php echo esc_url($img_url); ?>" class="img-fluid"
                          alt="<?php echo esc_attr($img_alt); ?>" />
                        <div class="overlay">
                          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/zoom-icon.svg" alt="Zoom"
                            class="zoom-icon" />
                        </div>
                      </a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <?php if (count($certificate_slides) > 1): ?>
          <!-- Стрелки -->
          <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo esc_attr($carousel_id); ?>"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#<?php echo esc_attr($carousel_id); ?>"
            data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-info">
        Сертификаты и лицензии не добавлены. Пожалуйста, добавьте их в настройках сайта.
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Модальное окно -->
<div class="modal fade" id="<?php echo esc_attr($modal_id); ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: max-content">
    <div class="modal-content bg-transparent border-0">
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3 bg-white" data-bs-dismiss="modal"
        aria-label="Закрыть"></button>

      <div class="modal-body p-0">
        <img src="" alt="Просмотр изображения" id="modalImage-<?php echo esc_attr($block['id']); ?>"
          class="img-fluid w-100" style="    max-width: 100%;    max-height: 80vh;    object-fit: contain;" />
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Выбираем все ссылки сертификатов в текущем блоке
    const certificateLinks = document.querySelectorAll('#<?php echo esc_js($id); ?> .certificate-link');
    // ID модального изображения соответствует ID блока
    const modalImageId = 'modalImage-<?php echo esc_js($block['id']); ?>';

    certificateLinks.forEach(function (link) {
      link.addEventListener('click', function (e) {
        // Используем специальный атрибут data-img-src для установки источника изображения
        const imgSrc = this.getAttribute('data-img-src');
        // Устанавливаем источник для изображения в модальном окне
        document.getElementById(modalImageId).setAttribute('src', imgSrc);
      });
    });
  });
</script>