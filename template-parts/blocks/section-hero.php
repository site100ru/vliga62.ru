<?php
/**
 * Block Name: Секция Hero
 * Description: Главная секция с приветствием и каруселью
 */

// Создаем уникальный ID для блока
$id = 'hero-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$slides = get_field('slides');

// Регистрируем и подключаем JS скрипт для анимации карусели
// Используем случайное число, чтобы избежать кэширования
$random = wp_rand();
wp_enqueue_script('hero-carousel-animation', get_template_directory_uri() . '/assets/js/home.js', array('jquery'), $random, true);
?>


<div id="<?php echo esc_attr($id); ?>" class="section-hero <?php echo esc_attr($className); ?>">
	<div id="carouselMain" class="carousel slide" data-bs-ride="carousel">        
		<div class="carousel-inner">
            <?php 
            if ($slides && is_array($slides)) : 
                foreach ($slides as $index => $slide) :
                    $active = $index === 0 ? 'active' : '';
                    $background_image = isset($slide['background_image']) ? $slide['background_image'] : '';
                    $center_image = isset($slide['center_image']) ? $slide['center_image'] : '';
                    $heading = isset($slide['heading']) ? $slide['heading'] : '';
                    $heading_tag = $index === 0 ? 'h1' : 'h2';
            ?>
                <div class="carousel-item <?php echo esc_attr($active); ?>">
                    <div 
                        class="carousel-background" 
                        style="background-image: url(<?php echo esc_url($background_image); ?>)"
                    ></div>
                    <div class="carousel-content">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col text-center">
                                    <?php if ($center_image) : ?>
                                    <img 
                                        src="<?php echo esc_url($center_image); ?>" 
                                        alt="<?php echo esc_attr(isset($slide['center_image_alt']) ? $slide['center_image_alt'] : 'Центральное изображение'); ?>" 
                                        class="carousel-center-image animate-up delay-1"
                                    />
                                    <?php endif; ?>
                                    
                                    <?php if ($heading) : ?>
                                    <<?php echo $heading_tag; ?> class="carousel-title animate-up delay-2">
                                        <?php echo $heading; ?>
                                    </<?php echo $heading_tag; ?>>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach; 
            endif; 
            ?>
        </div>
        
        <?php if ($slides && count($slides) > 1) : ?>
        <button 
            class="carousel-control-prev" 
            type="button" 
            data-bs-target="#carouselMain" 
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Предыдущий</span>
        </button>
        <button 
            class="carousel-control-next" 
            type="button" 
            data-bs-target="#carouselMain" 
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Следующий</span>
        </button>
        <?php endif; ?>
    </div>
</div>