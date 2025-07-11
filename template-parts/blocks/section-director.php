<?php
/**
 * Block Name: Секция с информацией о директоре
 * Description: Блок для отображения информации о директоре компании
 */

// Создаем уникальный ID для блока
$id = 'section-director-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// Определяем источник данных
$data_source = get_field('data_source') ?: 'block';

// Получаем данные в зависимости от источника
if ($data_source === 'block') {
    // Данные из блока
    $director_name = get_field('director_name');
    $director_position = get_field('director_position');
    $director_text = get_field('director_text');
    $director_image = get_field('director_image');
    $director_points_image = get_field('director_points_image');
} else {
    // Данные из настроек сайта (ACF Options Page)
    $director_name = get_field('director_name', 'option');
    $director_position = get_field('director_position', 'option');
    $director_text = get_field('director_text', 'option');
    $director_image = get_field('director_image', 'option');
    $director_points_image = get_field('director_points_image', 'option');
}

// Получаем настройки фона
$background_color = get_field('background_color') ?: 'dark';
$section_class = 'section section-director';
$section_class .= $background_color === 'dark' ? ' bg-image text-white' : ' text-dark';

// Получаем настройки выравнивания текста
$text_alignment = get_field('text_alignment') ?: 'right';
$text_class = $text_alignment === 'right' ? 'text-md-end' : 'text-md-start';
?>

<section id="<?php echo esc_attr($id); ?>" 
    class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="row align-items-stretch">
            <?php if ($text_alignment === 'right'): ?>
                <!-- Контент (заголовок, подзаголовок, изображение, текст) -->
                <div class="align-content-center col-12 col-lg-6 col-xl-5 <?php echo esc_attr($text_class); ?> text-center mb-4 mb-md-0">
                    <?php if (!empty($director_name)): ?>
                        <h2 class="section-director-name"><?php echo esc_html($director_name); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($director_position)): ?>
                        <h4 class="section-director-position"><?php echo esc_html($director_position); ?></h4>
                    <?php endif; ?>
					
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png"
                        class="img-fluid section-director-points" alt="" />

                    <?php if (!empty($director_text)): ?>
                        <div class="section-director-text">
                            <?php echo $director_text; ?>
                        </div>
                    <?php endif; ?>
                </div>
			
				<!-- Центральная пустая колонка -->
                <div class="col-xl-1 d-none d-xl-block"></div>

                <!-- Изображение директора -->
                <div class="col-12 col-lg-6 col-xl-6 text-center section-director-img">
                    <?php if (!empty($director_image)): ?>
                        <img src="<?php echo esc_url($director_image['url']); ?>"
                            alt="<?php echo esc_attr($director_image['alt'] ?: 'Директор'); ?>" class="img-fluid h-100" />
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- Левая пустая колонка -->
                <div class="col-xl-1 d-none d-xl-block"></div>

                <!-- Изображение директора -->
                <div class="col-12 col-lg-6 col-xl-4 text-center section-director-img">
                    <?php if (!empty($director_image)): ?>
                        <img src="<?php echo esc_url($director_image['url']); ?>"
                            alt="<?php echo esc_attr($director_image['alt'] ?: 'Директор'); ?>" class="img-fluid h-100" />
                    <?php endif; ?>
                </div>

                <!-- Центральная пустая колонка -->
                <div class="col-xl-1 d-none d-xl-block"></div>

                <!-- Контент (заголовок, подзаголовок, изображение, текст) -->
                <div class="col-12 col-lg-6 col-xl-5 <?php echo esc_attr($text_class); ?> text-center mb-4 mb-md-0">
                    <?php if (!empty($director_name)): ?>
                        <h2 class="section-director-name"><?php echo esc_html($director_name); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($director_position)): ?>
                        <h4 class="section-director-position"><?php echo esc_html($director_position); ?></h4>
                    <?php endif; ?>

                    <?php if (!empty($director_points_image)): ?>
                        <img src="<?php echo esc_url($director_points_image['url']); ?>"
                            alt="<?php echo esc_attr($director_points_image['alt'] ?: 'Иллюстрация'); ?>"
                            class="img-fluid section-director-points" />
                    <?php endif; ?>

                    <?php if (!empty($director_text)): ?>
                        <div class="section-director-text">
                            <?php echo $director_text; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Правая пустая колонка -->
                <div class="col-xl-1 d-none d-xl-block"></div>
            <?php endif; ?>
        </div>
    </div>
</section>