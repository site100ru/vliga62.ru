<?php
/**
 * Block Name: Двухколоночный текстовый блок
 * Description: Блок с двумя колонками текста и настраиваемым фоном
 */

// Создаем уникальный ID для блока
$id = 'two-columns-text-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$background_color = get_field('background_color') ?: 'dark';
$left_column_text = get_field('left_column_text');
$right_column_text = get_field('right_column_text');

// Очищаем от внешних div-ов, которые может добавить WYSIWYG редактор
$left_column_text = preg_replace('/<div[^>]*>(.*?)<\/div>/is', '$1', $left_column_text);
$right_column_text = preg_replace('/<div[^>]*>(.*?)<\/div>/is', '$1', $right_column_text);

// Определяем классы на основе настроек
$section_class = 'section section-two-columns-text';
$section_class .= $background_color === 'dark' ? ' bg-image text-white' : ' text-dark';
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="row align-items-start section-grid-left section-grid-ul">
            <!-- Левая колонка с текстом -->
            <div class="col-12 col-md-6 col-xl-6 left-column">
                <?php echo $left_column_text; ?>
            </div>

            <!-- Правая колонка с текстом -->
            <div class="col-12 col-md-6 col-xl-6 right-column mb-4 mb-md-0">
                <?php echo $right_column_text; ?>
            </div>
        </div>
    </div>
</section>