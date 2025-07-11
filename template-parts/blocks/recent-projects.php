<?php
/**
 * Block Name: Последние проекты
 * Description: Блок для отображения последних 6 проектов с возможностью фильтрации по категории
 */

// Создаем уникальный ID для блока
$id = 'recent-projects-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$background_color = get_field('background_color') ?: 'light';
$section_title = get_field('section_title') ?: 'Наши работы';
$selected_category = get_field('project_category'); // Новое поле для выбора категории

// Определяем классы на основе настроек
$section_class = 'section section-works';
$section_class .= $background_color === 'dark' ? ' bg-image' : '';
$title_class = $background_color === 'dark' ? 'text-white' : 'text-dark';

// Формируем аргументы для запроса проектов
$args = array(
  'post_type' => 'project',
  'posts_per_page' => 6,
  'post_status' => 'publish',
  'orderby' => 'date',
  'order' => 'DESC'
);

// Добавляем фильтрацию по категории, если выбрана
if (!empty($selected_category)) {
  $args['tax_query'] = array(
    array(
      'taxonomy' => 'project_category', // Замените на название вашей таксономии
      'field'    => 'term_id',
      'terms'    => $selected_category,
    ),
  );
}

$recent_projects = new WP_Query($args);
?>

<section id="<?php echo esc_attr($id); ?>"
  class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?>">
  <div class="container">
    <div class="section-title text-center mb-5">
      <h3 class="<?php echo esc_attr($title_class); ?>"><?php echo esc_html($section_title); ?></h3>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png" alt="Декоративные точки"
        class="img-fluid" />
    </div>
    
    <?php if ($recent_projects->have_posts()): ?>
      <div class="row g-4 justify-content-center">
        <?php while ($recent_projects->have_posts()):
          $recent_projects->the_post();
          $project_url = get_permalink();
          $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/assets/img/portfolio-card.jpg';
          $excerpt = get_the_excerpt();
          
          // Ограничиваем длину описания
          $excerpt = wp_trim_words($excerpt, 10, '...');
          ?>
          <div class="col-12 col-md-6 col-xl-4">
            <a href="<?php echo esc_url($project_url); ?>"
              class="work-item position-relative d-block overflow-hidden bg-linear-gradient">
              <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                class="img-fluid work-image w-100" />
              <div class="work-text text-white">
                <p><?php echo esc_html($excerpt); ?></p>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">
        <p>Проекты не найдены. Пожалуйста, добавьте проекты в административной панели.</p>
      </div>
    <?php endif;
    wp_reset_postdata(); // Сбрасываем данные запроса
    ?>
    
    <div class="text-center mt-5">
      <a href="/portfolio" class="btn btn-primary px-4 py-2">Смотреть все</a>
    </div>
  </div>
</section>