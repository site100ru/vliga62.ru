<?php
/**
 * Template Name: Страница проекта
 * Template Post Type: project
 *
 * Шаблон для отображения одиночного проекта
 */

get_header();

// Получаем текущий ID проекта
$project_id = get_the_ID();

// Получаем категории проекта
$categories = get_the_terms($project_id, 'project_category');
$category_name = '';
if (!empty($categories) && !is_wp_error($categories)) {
  $category_name = $categories[0]->name;
}

// Получаем основное изображение проекта
$featured_image = get_the_post_thumbnail_url($project_id, 'full');

// Получаем дополнительные изображения проекта, если используется ACF
$gallery_images = [];
if (function_exists('get_field')) {
  $gallery_images = get_field('project_gallery', $project_id);
}

// Определяем ID галереи
$gallery_id = 'gallery-' . $project_id;
?>

<main id="primary" class="site-main">
  <!-- Hero секция -->
  <section class="hero-section">
    <div class="single-service-page-1">
      <div class="container position-relative">
        <div class="row">
          <div class="col hero-content">
            <h1>
              <?php the_title(); ?>
            </h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SINGLE PRODUCT SECTION -->
  <section class="section text-dark section-about section-grid">
    <div class="container pb-5 single-product">
      <!-- Хлебные крошки -->
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 m-0">
          <li class="breadcrumb-item">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none text-secondary">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/breadcrumbs.svg" loading="lazy" />
            </a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?php echo esc_url(home_url('/portfolio/')); ?>" class="text-decoration-none text-secondary">
              Наши работы
            </a>
          </li>
          <?php if (!empty($category_name)): ?>
            <li class="breadcrumb-item">
              <a href="<?php echo esc_url(get_term_link($categories[0])); ?>" class="text-decoration-none text-secondary">
                <?php echo esc_html($category_name); ?>
              </a>
            </li>
          <?php endif; ?>
          <li class="breadcrumb-item active" aria-current="page">
            <?php the_title(); ?>
          </li>
        </ol>
      </nav>

      <div class="row justify-content-center">
        <div class="col-12 col-md-6 mb-4 mb-md-0 section-image">
          <?php if (!empty($gallery_images)): ?>
            <div id="carousel-<?php echo esc_attr($project_id); ?>" class="carousel slide carousel-xx" data-bs-ride="false" data-bs-interval="false">
              <div class="carousel-inner rounded">
                <!-- .shadow -->
                <?php 
                // Выводим все изображения из галереи
                foreach ($gallery_images as $index => $image): 
                  $active_class = ($index == 0) ? 'active' : '';
                ?>
                  <div class="carousel-item <?php echo $gallery_id; ?>-wrapper gallery-2691-wrapper <?php echo $active_class; ?>">
                    <button class="<?php echo $gallery_id; ?> gallery-2691" onClick="galleryOn('<?php echo $gallery_id; ?>', <?php echo $index; ?>);">
                      <div class="single-product-img approximation img-wrapper position-relative">
                        <img 
                          src="<?php echo esc_url($image['url']); ?>" 
                          class="d-block w-100" 
                          loading="lazy" 
                          alt="..." 
                        />
                        <div class="overlay">
                          <img 
                            src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/zoom-icon.svg" 
                            alt="Zoom" 
                            class="zoom-icon" 
                          />
                        </div>
                      </div>
                    </button>
                  </div>
                <?php endforeach; ?>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo esc_attr($project_id); ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo esc_attr($project_id); ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          <?php elseif (!empty($featured_image)): ?>
            <!-- Если нет галереи, выводим основное изображение -->
            <div class="single-product-img approximation img-wrapper position-relative">
              <img src="<?php echo esc_url($featured_image); ?>" class="d-block w-100" loading="lazy" alt="<?php the_title_attribute(); ?>" />
            </div>
          <?php endif; ?>
        </div>

        <!-- Пустая колонка для увеличения отступа на больших экранах -->
        <div class="d-none d-xl-block col-xl-1"></div>

        <div class="col-12 col-md-6 col-xl-5 text-dark">
          <div class="content">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery wrapper -->
  <?php if (!empty($gallery_images)): ?>
    <div id="galleryWrapper" style="background: rgba(0, 0, 0, 0.85); display: none; position: fixed; top: 0; bottom: 0; left: 0; right: 0; z-index: 9999;">
      <div id="<?php echo $gallery_id; ?>" class="carousel slide" data-bs-ride="false" data-bs-interval="false" style="display: none; position: fixed; top: 0; height: 100%; width: 100%">
        <div class="carousel-inner h-100">
          <?php foreach ($gallery_images as $index => $image): ?>
            <div class="carousel-item carousel-item-2 h-100" data-slide-index="<?php echo $index; ?>">
              <div class="row align-items-center h-100">
                <div class="col text-center">
                  <img 
                    src="<?php echo esc_url($image['url']); ?>" 
                    class="img-fluid" 
                    loading="lazy" 
                    style="max-width: 75vw; max-height: 75vh" 
                    alt="..." 
                  />
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $gallery_id; ?>" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $gallery_id; ?>" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <!-- Кнопка закрытия галереи -->
      <button type="button" onClick="closeGallery();" class="btn-close btn-close-white" style="position: fixed; top: 25px; right: 25px; z-index: 99999" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <!-- Скрипт для галереи -->
  <script>
    /* Функция открытия галереи */
    function galleryOn(gal, slideIndex) {
      var gallery = gal; // Получаем ID галереи
      var modalCarousel = document.getElementById(gallery);
      
      // Открываем обертку галереи
      document.getElementById('galleryWrapper').style.display = 'block';
      
      // Открываем галерею
      modalCarousel.style.display = 'block';
      
      // Убираем класс active со всех слайдов в модальном окне
      var modalSlides = modalCarousel.querySelectorAll('.carousel-item');
      modalSlides.forEach(function(slide) {
        slide.classList.remove('active');
      });
      
      // Активируем нужный слайд в модальном окне
      var targetSlide = modalCarousel.querySelector('[data-slide-index="' + slideIndex + '"]');
      if (targetSlide) {
        targetSlide.classList.add('active');
      }
    }

    /* Кнопка закрытия галереи */
    function closeGallery() {
      // Закрываем обертку галереи
      document.getElementById('galleryWrapper').style.display = 'none';
      <?php if (!empty($gallery_id)): ?>
        document.getElementById('<?php echo $gallery_id; ?>').style.display = 'none';
      <?php endif; ?>
    }
  </script>
</main>

<?php
get_footer();
?>