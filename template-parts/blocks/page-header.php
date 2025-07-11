<?php
/**
 * Block Name: Заголовок страницы
 * Description: Блок с заголовком страницы и фоновым изображением
 */

// Создаем уникальный ID для блока
$id = 'page-header-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$title = get_field('title');
$background_image = get_field('background_image');

// Стиль для внутреннего div с фоном
$background_style = '';
if (!empty($background_image)) {
  $background_style = 'background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.75) 0%,
        rgba(0, 0, 0, 0.5) 35%,
        rgba(0, 0, 0, 0.5) 100%
    ), url(' . esc_url($background_image['url']) . ');     background-position-y: 50%;';
} else {
  $background_style = 'background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.75) 0%,
        rgba(0, 0, 0, 0.5) 35%,
        rgba(0, 0, 0, 0.5) 100%
    );
        background-position-y: 50%;
    ';
}
?>

<section id="<?php echo esc_attr($id); ?>" class="hero-section <?php echo esc_attr($className); ?>">
  <div class="single-service-page-1" style="<?php echo $background_style; ?>">
    <div class="container position-relative">
      <div class="row">
        <div class="col hero-content">
          <?php if (!empty($title)): ?>
            <h1><?php echo esc_html($title); ?></h1>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>