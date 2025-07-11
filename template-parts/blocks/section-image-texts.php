<?php
/**
 * Block Name: Секция с изображением и текстом
 * Description: Блок с изображением и текстом в разных вариантах расположения
 */

// Создаем уникальный ID для блока
$id = 'section-image-text-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$image_position = get_field('image_position') ?: 'left';
$background_color = get_field('background_color') ?: 'light';
$image = get_field('image');
$content = get_field('content');

// Получаем данные хлебных крошек
$breadcrumbs_group = get_field('breadcrumbs_group');

// Определяем классы на основе настроек
$section_class = 'section';
$section_class .= $background_color === 'dark' ? ' bg-image text-white' : ' text-dark section-about';
$section_class .= $image_position === 'left' ? ' section-grid-left' : ' section-grid-right';

// Определяем порядок колонок
$image_order_mobile = $image_position === 'left' ? 'order-3' : '';
$image_order_desktop = $image_position === 'left' ? 'order-md-1' : '';
$content_order_mobile = $image_position === 'left' ? 'order-1' : '';
$content_order_desktop = $image_position === 'left' ? 'order-md-3' : '';
?>

<section id="<?php echo esc_attr($id); ?>"
    class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?> section-grid section-grid-ul">
    <div class="container">
        <?php
        // Отображаем хлебные крошки
        if (is_array($breadcrumbs_group) && !empty($breadcrumbs_group['show_breadcrumbs'])) {
            $show_breadcrumbs = $breadcrumbs_group['show_breadcrumbs'];
            $breadcrumbs = isset($breadcrumbs_group['breadcrumbs']) ? $breadcrumbs_group['breadcrumbs'] : [];

            if (!empty($show_breadcrumbs)) {
                ?>
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none text-secondary">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/breadcrumbs.svg" />
                            </a>
                        </li>
                        <?php
                        if (!empty($breadcrumbs) && is_array($breadcrumbs)) {
                            $count = count($breadcrumbs);
                            $i = 0;
                            foreach ($breadcrumbs as $crumb) {
                                $i++;
                                $is_last = ($i === $count);
                                $current = $is_last ? ' active" aria-current="page' : '';
                                ?>
                                <li class="breadcrumb-item<?php echo $current; ?>">
                                    <?php if (!$is_last && !empty($crumb['link'])): ?>
                                        <a href="<?php echo esc_url($crumb['link']); ?>" class="text-decoration-none text-secondary">
                                            <?php echo esc_html($crumb['label']); ?>
                                        </a>
                                    <?php else: ?>
                                        <?php echo esc_html($crumb['label']); ?>
                                    <?php endif; ?>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ol>
                </nav>
                <?php
            }
        }
        ?>

        <div
            class="row align-items-start <?php echo $image_position === 'left' ? 'section-grid-left' : 'section-grid-right'; ?> section-grid-ul">

            <?php if ($image_position === 'left'): ?>
                <!-- Изображение (слева) -->
                <div
                    class="col-12 col-md-6 col-xl-6 <?php echo esc_attr($image_order_mobile . ' ' . $image_order_desktop); ?> section-image">
                    <div class="img-wrapper">
                        <?php if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                                class="img-fluid">
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Пустая колонка -->
                <div class="d-none d-xl-block col-xl-1 order-md-2"></div>
                <!-- Текст -->
                <div
                    class="col-12 col-md-6 col-xl-5 <?php echo esc_attr($content_order_mobile . ' ' . $content_order_desktop); ?> mb-4 mb-md-0">
                    <?php echo $content; ?>
                </div>
            <?php else: ?>
                <!-- Текст -->
                <div class="col-12 col-md-6 col-xl-5 mb-4 mb-md-0">
                    <?php echo $content; ?>
                </div>
                <!-- Пустая колонка -->
                <div class="d-none d-xl-block col-xl-1"></div>
                <!-- Изображение (справа) -->
                <div class="col-12 col-md-6 col-xl-6 text-center section-image">
                    <div class="img-wrapper">
                        <?php if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                                class="img-fluid">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>