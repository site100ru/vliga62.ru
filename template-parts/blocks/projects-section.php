<?php
/**
 * Block Name: Секция Проектов
 * Description: Блок для отображения проектов из выбранной категории
 */

// Создаем уникальный ID для блока
$id = 'projects-section-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// Получаем данные полей из ACF
$category = get_field('category');
$background_color = get_field('background_color') ?: 'light';
$posts_per_page = get_field('posts_per_page') ?: -1;

// Получаем название категории для использования в заголовке
$section_title = '';
if (!empty($category)) {
	// Проверяем, является ли значение числом (ID) или строкой (slug)
    if (is_numeric($category)) {
        // Получаем термин по ID
        $term = get_term($category, 'project_category');
    } else {
        // Получаем термин по slug
        $term = get_term_by('slug', $category, 'project_category');
    }
	
    // Проверяем, что термин существует и нет ошибки
    if ($term && !is_wp_error($term)) {
        $section_title = $term->name;
    } else {
        // Если термин не найден, используем значение категории как запасной вариант
        $section_title = ucfirst(str_replace('-', ' ', $category));
    }
}

// Получаем данные хлебных крошек
$breadcrumbs_group = get_field('breadcrumbs_group');

// Определяем классы на основе настроек
$section_class = 'section section-works';
$section_class .= $background_color === 'dark' ? ' bg-image text-white' : '';
$title_class = $background_color === 'dark' ? 'text-white' : 'text-dark';

// Определяем классы для колонок в зависимости от настроек
$column_class = 'col-12';
$column_class .= ' col-md-' . (12 / 2);
$column_class .= ' col-xl-' . (12 / 3);

// Формируем параметры запроса к WordPress
$args = array(
    'post_type'      => 'project', 
    'posts_per_page' => $posts_per_page,
    'post_status'    => 'publish'
);

// Добавляем таксономию, если выбрана категория
if (!empty($category)) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'project_category',
            'field'    => 'term_id',
            'terms'    => $category,
        ),
    );
}

// Получаем проекты
$projects_query = new WP_Query($args);
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($section_class); ?> <?php echo esc_attr($className); ?>">
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
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/breadcrumbs.svg" loading="lazy" />
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

        <?php if (!empty($section_title)) : ?>
        <div class="section-title text-center mb-5">
            <h3 class="<?php echo esc_attr($title_class); ?>"><?php echo esc_html($section_title); ?></h3>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png" alt="Декоративные точки" class="img-fluid" />
        </div>
        <?php endif; ?>

        <?php if ($projects_query->have_posts()) : ?>
        <div class="row g-4 justify-content-center">
            <?php while ($projects_query->have_posts()) : $projects_query->the_post(); 
                $project_url = get_permalink();
                $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/assets/img/portfolio-card.jpg';
                $excerpt = get_the_excerpt();
                // Ограничиваем длину описания
                $excerpt = wp_trim_words($excerpt, 10, '...');
            ?>
            <div class="<?php echo esc_attr($column_class); ?>">
                <a href="<?php echo esc_url($project_url); ?>" class="work-item position-relative d-block overflow-hidden bg-linear-gradient">
                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid work-image w-100" />
                    <div class="work-text text-white">
                        <p><?php echo esc_html($excerpt); ?></p>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else : ?>
        <div class="alert alert-info">
            Проекты не найдены. Пожалуйста, выберите другую категорию или добавьте проекты.
        </div>
        <?php endif; 
        wp_reset_postdata(); // Сбрасываем данные запроса
        ?>
    </div>
</section>