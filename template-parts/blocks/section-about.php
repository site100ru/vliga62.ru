<?php
/**
 * Block Name: Секция о нас с заголовком
 * Description: Блок с заголовком и несколькими строками текста и изображений
 */

// Создаем уникальный ID для блока
$id = 'section-about-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$section_title = get_field('section_title');
$background_color = get_field('background_color') ?: 'light';
$rows = get_field('rows');

// Определяем классы на основе настроек
$section_class = 'section section-about section-grid';
$section_class .= $background_color === 'dark' ? ' bg-image text-white' : ' text-dark';

/**
 * Функция для очистки контента от нежелательной HTML-разметки
 */
if (!function_exists('clean_wysiwyg_content')) {
  function clean_wysiwyg_content($content)
  {
    // Удаляем секции, контейнеры и строки (полная очистка от структурной разметки)
    $patterns = [
      '/<section[^>]*>.*?<\/section>/is',
      '/<div class=["\']container[^>]*>.*?<\/div>/is',
      '/<div class=["\']row[^>]*>.*?<\/div>/is',
      '/<div class=["\']col[^>]*>|<\/div>/is'
    ];

    // Сначала сохраняем только текстовое содержимое абзацев, списков и т.д.
    $content_only = '';
    preg_match_all('/<p>.*?<\/p>|<ul>.*?<\/ul>|<ol>.*?<\/ol>|<h[1-6]>.*?<\/h[1-6]>/is', $content, $matches);

    if (!empty($matches[0])) {
      $content_only = implode("\n", $matches[0]);
    } else {
      // Если не нашлось структурированных элементов, берем весь контент
      $content_only = $content;
    }

    // Удаляем оставшиеся нежелательные элементы
    foreach ($patterns as $pattern) {
      $content_only = preg_replace($pattern, '', $content_only);
    }

    return trim($content_only);
  }
}
?>

<section id="<?php echo esc_attr($id); ?>"
  class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?>">
  <div class="container">
    <?php if (!empty($section_title)): ?>
      <!-- Заголовок секции -->
      <div class="section-title text-center mb-5">
        <?php if (!empty($section_title)): ?>
          <h3 class="<?php echo $background_color === 'dark' ? 'text-white' : 'text-dark'; ?>">
            <?php echo esc_html($section_title); ?>
          </h3>
        <?php endif; ?>

        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png"
          class="img-fluid section-director-points" alt="" />
      </div>
    <?php endif; ?>

    <?php
    if ($rows && is_array($rows)):
      $last_index = count($rows) - 1;
      foreach ($rows as $index => $row):
        $image_position = $row['image_position'];
        $content = $row['content'];
        $image = $row['image'];
        $is_last = ($index === $last_index);

        // Очищаем контент от нежелательной разметки
        $clean_content = clean_wysiwyg_content($content);

        // Определяем классы для строки
        $row_class = 'row align-items-start';
        $row_class .= $image_position === 'left' ? ' section-grid-left' : ' section-grid-right';
        if (!$is_last) {
          $row_class .= ' mb-5';
        }

        // Определяем порядок колонок для мобильных устройств
        $image_order_mobile = $image_position === 'left' ? 'order-3' : '';
        $image_order_desktop = $image_position === 'left' ? 'order-md-1' : '';
        $content_order_mobile = $image_position === 'left' ? 'order-1' : '';
        $content_order_desktop = $image_position === 'left' ? 'order-md-3' : '';
        ?>
        <!-- Строка: <?php echo $image_position === 'left' ? 'изображение слева, текст справа' : 'текст слева, изображение справа'; ?> -->
        <div class="<?php echo esc_attr($row_class); ?>">
          <?php if ($image_position === 'left'): ?>
            <!-- Изображение (слева) -->
            <div
              class="col-12 col-md-6 col-xl-6 text-center <?php echo esc_attr($image_order_mobile . ' ' . $image_order_desktop); ?> section-image">
              <?php if (!empty($image)): ?>
                <div class="img-wrapper">
                  <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: 'Изображение'); ?>"
                    class="img-fluid" />
                </div>
              <?php endif; ?>
            </div>

            <!-- Пустая колонка -->
            <div class="d-none d-xl-block col-xl-1 order-2 order-md-2"></div>

            <!-- Текст (справа) -->
            <div
              class="col-12 col-md-6 col-xl-5 <?php echo esc_attr($content_order_mobile . ' ' . $content_order_desktop); ?> mb-4 mb-md-0">
              <?php echo $clean_content; ?>
            </div>
          <?php else: ?>
            <!-- Текст (слева) -->
            <div class="col-12 col-md-6 col-xl-5 mb-4 mb-md-0">
              <?php echo $clean_content; ?>
            </div>

            <!-- Пустая колонка -->
            <div class="d-none d-xl-block col-xl-1"></div>

            <!-- Изображение (справа) -->
            <div class="col-12 col-md-6 col-xl-6 text-center section-image">
              <?php if (!empty($image)): ?>
                <div class="img-wrapper">
                  <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: 'Изображение'); ?>"
                    class="img-fluid" />
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; endif; ?>

  </div>
</section>