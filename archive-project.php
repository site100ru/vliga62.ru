<?php
/**
 * The template for displaying project archives
 */

get_header();

// Настройки отображения элементов
$columns_desktop = 3; // Количество колонок на десктопе
$columns_tablet = 2;  // Количество колонок на планшете

// Определяем классы для колонок в зависимости от настроек
$column_class = 'col-12';
$column_class .= ' col-md-' . (12 / $columns_tablet);
$column_class .= ' col-xl-' . (12 / $columns_desktop);

// Получаем все категории проектов для фильтрации
$categories = get_terms(array(
  'taxonomy' => 'project_category',
  'hide_empty' => true,
));
?>

<main id="primary" class="site-main">
  <!-- Хлебные крошки -->
  <div class="container mt-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb p-0 m-0">
        <li class="breadcrumb-item">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none text-secondary">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/breadcrumbs.svg" loading="lazy" />
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Наши проекты
        </li>
      </ol>
    </nav>
  </div>

  <section class="section section-works">
    <div class="container">
      <div class="section-title text-center mb-5">
        <h1 class="text-dark">Наши проекты</h1>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png" alt="Декоративные точки"
          class="img-fluid" />
      </div>

      <?php if (have_posts()): ?>
        <div class="row g-4 justify-content-center">
          <?php
          while (have_posts()):
            the_post();
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/assets/img/portfolio-card.jpg';
            $excerpt = get_the_excerpt();
            // Ограничиваем длину описания
            $excerpt = wp_trim_words($excerpt, 10, '...');
            ?>
            <div class="<?php echo esc_attr($column_class); ?>">
              <a href="<?php the_permalink(); ?>"
                class="work-item position-relative d-block overflow-hidden bg-linear-gradient">
                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>"
                  class="img-fluid work-image w-100" />
                <div class="work-text text-white">
                  <p><?php echo esc_html($excerpt); ?></p>
                </div>
              </a>
            </div>
          <?php endwhile; ?>
        </div>

        <?php
        // Пагинация
        $pagination = get_the_posts_pagination(array(
          'mid_size' => 2,
          'prev_text' => '&laquo;',
          'next_text' => '&raquo;',
          'screen_reader_text' => ' ',
          'class' => 'mt-5',
        ));

        if (!empty($pagination)) {
          echo '<div class="pagination-container mt-5 d-flex justify-content-center">';
          echo $pagination;
          echo '</div>';
        }
        ?>

      <?php else: ?>
        <div class="alert alert-info text-center">
          <p>Проекты не найдены. Пожалуйста, добавьте проекты в административной панели.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php
get_footer();