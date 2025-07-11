<?php
/**
 * Block Name: Секция с преимуществами
 * Description: Блок для отображения преимуществ компании в колонках с иконками
 */

// Создаем уникальный ID для блока
$id = 'section-advantages-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$section_title = get_field('section_title');
$advantages = get_field('advantages');
$background_color = get_field('background_color') ?: 'dark';
$columns_count = get_field('columns_count') ?: '2';

// Определяем классы на основе настроек
$section_class = 'section section-advantages';
$section_class .= $background_color === 'dark' ? ' bg-image text-white' : ' text-dark';

// Определяем класс для количества колонок
$columns_class = 'col-12';
if ($columns_count === '2') {
  $columns_class .= ' col-md-6';
} elseif ($columns_count === '3') {
  $columns_class .= ' col-md-6 col-lg-4';
} elseif ($columns_count === '4') {
  $columns_class .= ' col-md-6 col-lg-3';
}
?>

<section id="<?php echo esc_attr($id); ?>"
  class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?>">
  <div class="container text-center">
    <div class="section-title">
      <?php if (!empty($section_title)): ?>
        <h3 class="<?php echo $background_color === 'dark' ? 'text-white' : 'text-dark'; ?>">
          <?php echo esc_html($section_title); ?>
        </h3>
      <?php endif; ?>

      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png" class="img-fluid" alt="" />
    </div>

    <?php if (!empty($advantages) && is_array($advantages)): ?>
      <div class="row g-4 text-start section-content-grid">
        <?php foreach ($advantages as $advantage): ?>
          <div class="<?php echo esc_attr($columns_class); ?> d-flex">
            <?php if (!empty($advantage['icon'])): ?>
              <img src="<?php echo esc_url($advantage['icon']['url']); ?>"
                alt="<?php echo esc_attr($advantage['icon']['alt'] ?: 'Иконка'); ?>" width="70px" height="70px">
            <?php endif; ?>

            <div class="w-100">
              <?php if (!empty($advantage['title'])): ?>
                <h4 class="fw-bold mb-0"><?php echo esc_html($advantage['title']); ?></h4>
              <?php endif; ?>

              <?php if (!empty($advantage['description'])): ?>
                <p class="text-muted text-min mb-0"><?php echo wp_kses_post($advantage['description']); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>