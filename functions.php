<?php
/**
 * vliga functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package vliga
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function vliga_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on vliga, use a find and replace
	 * to change 'vliga' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('vliga', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'vliga_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'vliga_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vliga_content_width()
{
	$GLOBALS['content_width'] = apply_filters('vliga_content_width', 640);
}
add_action('after_setup_theme', 'vliga_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vliga_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'vliga'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'vliga'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'vliga_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function vliga_scripts()
{
	wp_enqueue_style('vliga-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('vliga-style', 'rtl', 'replace');

	wp_enqueue_script('vliga-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'vliga_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

require_once get_template_directory() . '/inc/class-bootstrap-walker-nav-menu.php';

/**
 * Подключение стилей и скриптов
 */
function theme_enqueue_styles_scripts()
{
	// Регистрация и подключение стилей
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '1.0');
	wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/css/theme.css', array('bootstrap'), '1.0');
	wp_enqueue_style('font-style', get_template_directory_uri() . '/assets/css/font.css', array(), '1.0');
	wp_enqueue_style('glide-core', 'https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css', array(), '1.0');

	// jQuery уже загружен в WordPress, поэтому отдельно загружать не надо

	// Регистрация и подключение скриптов
	wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script('inputmask', get_template_directory_uri() . '/assets/js/inputmask.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script('tel-mask', get_template_directory_uri() . '/assets/js/telMask.js', array('jquery', 'inputmask'), '1.0', true);
	wp_enqueue_script('menu-scroll', get_template_directory_uri() . '/assets/js/menu-scroll.js', array('jquery'), '1.0', true);

	// ScrollReveal для анимации
	wp_enqueue_script('scrollreveal', 'https://unpkg.com/scrollreveal', array(), '1.0', true);
	wp_enqueue_script('scrollreveal-init', get_template_directory_uri() . '/assets/js/scrollreveal-init.js', array('scrollreveal'), '1.0', true);

	// Общие скрипты темы
	wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/theme.js', array('jquery', 'bootstrap-bundle'), '1.0', true);

	// Инициализация jQuery в режиме $ (решение проблемы "$ is not a function")
	wp_add_inline_script('jquery-core', 'var $ = jQuery;');


	if (is_front_page()) {
		// Регистрируем скрипт
		wp_register_script('logo-switch', get_template_directory_uri() . '/assets/js/logo-switch.js', array('jquery'), '1.0', true);

		// Локализуем скрипт, передаем переменные
		wp_localize_script('logo-switch', 'themeVars', array(
			'templateUrl' => get_template_directory_uri(),
			'lightLogo' => get_template_directory_uri() . '/assets/img/logo-light.png',
			'darkLogo' => get_template_directory_uri() . '/assets/img/logo-dark.png'
		));

		// Подключаем скрипт
		wp_enqueue_script('logo-switch');
	}
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles_scripts');

/**
 * Регистрация меню сайта
 */
function theme_register_menus()
{
	register_nav_menus(array(
		'primary-menu' => __('Основное меню', 'your-theme'),
		'mobile-menu' => __('Мобильное меню', 'your-theme'),
		'footer-menu-1' => __('Первая колонка меню в подвале', 'your-theme'),
		'footer-menu-2' => __('Вторая колонка меню в подвале', 'your-theme'),
	));
}
add_action('init', 'theme_register_menus');

/**
 * Поддержка функций WordPress
 */
function theme_setup()
{
	// Добавление поддержки миниатюр записей
	add_theme_support('post-thumbnails');

	// Добавление поддержки title-tag
	add_theme_support('title-tag');

	// Добавление поддержки HTML5
	add_theme_support('html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));
}
add_action('after_setup_theme', 'theme_setup');

/**
 * Добавление body класса для разных страниц
 */
function theme_body_classes($classes)
{
	// Добавление класса для главной страницы
	if (is_front_page()) {
		$classes[] = 'home-page';
	}

	return $classes;
}
add_filter('body_class', 'theme_body_classes');

/**
 * Добавление класса для header на главной странице
 */
function theme_header_class()
{
	$header_class = 'header-top py-0';

	if (is_front_page()) {
		$header_class .= ' header-nav-index';
	}

	return $header_class;
}

/**
 * Обработчик формы обратного звонка
 */
function handle_callback_form()
{
	if (!isset($_POST['callback_nonce']) || !wp_verify_nonce($_POST['callback_nonce'], 'send_callback_nonce')) {
		wp_die('Ошибка проверки безопасности');
	}

	$name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
	$phone = isset($_POST['tel']) ? sanitize_text_field($_POST['tel']) : '';

	// Формирование текста сообщения
	$message = "Запрос на обратный звонок\n";
	$message .= "Имя: " . $name . "\n";
	$message .= "Телефон: " . $phone . "\n";

	// Адрес почты, куда отправляем письмо
	$to = get_option('admin_email');
	$subject = 'Заявка на обратный звонок с сайта ' . get_bloginfo('name');
	$headers = array('Content-Type: text/plain; charset=UTF-8');

	// Отправка письма
	$mail_sent = wp_mail($to, $subject, $message, $headers);

	// Перенаправление после отправки
	if ($mail_sent) {
		wp_redirect(add_query_arg('callback', 'success', wp_get_referer()));
	} else {
		wp_redirect(add_query_arg('callback', 'error', wp_get_referer()));
	}
	exit;
}
add_action('admin_post_send_callback', 'handle_callback_form');
add_action('admin_post_nopriv_send_callback', 'handle_callback_form');



/**
 * Регистрация кастомных блоков ACF
 */
add_action('acf/init', function () {
	if (function_exists('acf_register_block_type')) {
		// Section Hero Block
		acf_register_block_type([
			'name' => 'section-hero',
			'title' => 'Секция Hero',
			'description' => 'Главная секция с приветствием',
			'render_template' => get_template_directory() . '/template-parts/blocks/section-hero.php',
			'category' => 'custom-blocks',
			'icon' => 'align-full-width',
			'keywords' => ['hero', 'главная', 'приветствие'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
			],
		]);

		acf_register_block_type([
			'name' => 'section-image-texts',
			'title' => 'Секция с изображением и текстом',
			'description' => 'Блок с изображением и текстовым содержимым в разных вариантах расположения',
			'render_template' => get_template_directory() . '/template-parts/blocks/section-image-texts.php',
			'category' => 'custom-blocks',
			'icon' => 'align-pull-left',
			'keywords' => ['изображение', 'текст', 'секция', 'контент'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
				'jsx' => true
			],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'image_position' => 'left',
						'background_color' => 'light',
						'is_preview' => true
					]
				]
			]
		]);

		acf_register_block_type([
			'name' => 'section-director',
			'title' => 'Секция с информацией о директоре',
			'description' => 'Блок для отображения информации о директоре компании',
			'render_template' => get_template_directory() . '/template-parts/blocks/section-director.php',
			'category' => 'custom-blocks',
			'icon' => 'businessman',
			'keywords' => ['директор', 'руководитель', 'о компании'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
			],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview' => true
					]
				]
			]
		]);

		acf_register_block_type([
			'name' => 'two-columns-text',
			'title' => 'Двухколоночный текстовый блок',
			'description' => 'Блок с двумя колонками текста и настраиваемым фоном',
			'render_template' => get_template_directory() . '/template-parts/blocks/two-columns-text.php',
			'category' => 'custom-blocks',
			'icon' => 'columns',
			'keywords' => ['текст', 'колонки', 'двухколоночный'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
				'jsx' => true
			],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'background_color' => 'dark',
						'is_preview' => true
					]
				]
			]
		]);

		// Section Advantages Block
		acf_register_block_type([
			'name' => 'section-advantages',
			'title' => 'Секция с преимуществами',
			'description' => 'Блок для отображения преимуществ компании в колонках с иконками',
			'render_template' => get_template_directory() . '/template-parts/blocks/section-advantages.php',
			'category' => 'custom-blocks',
			'icon' => 'star-filled',
			'keywords' => ['преимущества', 'услуги', 'особенности'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
			],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview' => true
					]
				]
			]
		]);

		// Section Partners Block
		acf_register_block_type([
			'name' => 'section-partners',
			'title' => 'Секция с партнерами',
			'description' => 'Блок для отображения карусели с логотипами партнеров',
			'render_template' => get_template_directory() . '/template-parts/blocks/section-partners.php',
			'category' => 'custom-blocks',
			'icon' => 'networking',
			'keywords' => ['партнеры', 'карусель', 'слайдер', 'логотипы'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
			],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview' => true
					]
				]
			]
		]);

		// Section About Block
		acf_register_block_type([
			'name' => 'section-about',
			'title' => 'Секция о нас с заголовком',
			'description' => 'Блок с заголовком и несколькими строками текста и изображений',
			'render_template' => get_template_directory() . '/template-parts/blocks/section-about.php',
			'category' => 'custom-blocks',
			'icon' => 'info',
			'keywords' => ['о нас', 'about', 'секция', 'текст с изображениями'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
			],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'section_title' => 'О нас',
						'background_color' => 'light',
						'is_preview' => true
					]
				]
			]
		]);

		// Page Header Block
		acf_register_block_type([
			'name' => 'page-header',
			'title' => 'Заголовок страницы',
			'description' => 'Блок с заголовком страницы и фоновым изображением',
			'render_template' => get_template_directory() . '/template-parts/blocks/page-header.php',
			'category' => 'custom-blocks',
			'icon' => 'heading',
			'keywords' => ['заголовок', 'шапка', 'баннер'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
			],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview' => true
					]
				]
			]
		]);

		// Section Contacts Block
		acf_register_block_type([
			'name' => 'section-contacts',
			'title' => 'Секция Контакты',
			'description' => 'Блок для отображения контактной информации компании',
			'render_template' => get_template_directory() . '/template-parts/blocks/section-contacts.php',
			'category' => 'custom-blocks',
			'icon' => 'phone',
			'keywords' => ['контакты', 'телефон', 'адрес', 'email'],
			'mode' => 'preview',
			'supports' => [
				'align' => false,
				'mode' => true,
			],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview' => true
					]
				]
			]
		]);

		// Регистрируем блок Секция Проектов
		acf_register_block_type(array(
			'name' => 'projects-section',
			'title' => __('Секция Проектов', 'your-theme-domain'),
			'description' => __('Блок для отображения проектов из выбранной категории', 'your-theme-domain'),
			'render_template' => 'template-parts/blocks/projects-section.php',
			'category' => 'formatting',
			'icon' => 'portfolio',
			'keywords' => array('проекты', 'портфолио', 'работы', 'секция'),
			'supports' => array(
				'align' => true,
				'mode' => true,
				'jsx' => true
			),
			'example' => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'is_preview' => true
					)
				)
			),
		));

		// Регистрируем блок Яндекс.Карты
		acf_register_block_type(array(
			'name' => 'yandex-map',
			'title' => __('Яндекс Карта'),
			'description' => __('Блок с Яндекс Картой и маркером местоположения'),
			'render_template' => 'template-parts/blocks/yandex-map.php',
			'category' => 'custom-blocks',
			'icon' => 'location-alt',
			'keywords' => array('карта', 'яндекс', 'местоположение', 'map'),
			'mode' => 'preview',
			'supports' => array(
				'align' => true,
				'mode' => false, // Отключаем редактирование HTML
			),
			'example' => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'is_preview' => true
					)
				)
			),
		));

		// Регистрируем блок "Последние проекты"
		acf_register_block_type(array(
			'name' => 'recent-projects',
			'title' => __('Последние проекты'),
			'description' => __('Блок для отображения последних 6 проектов'),
			'render_template' => 'template-parts/blocks/recent-projects.php',
			'category' => 'custom-blocks',
			'icon' => 'portfolio',
			'keywords' => array('проекты', 'портфолио', 'работы', 'последние'),
			'supports' => array(
				'align' => false,
				'mode' => true,
			),
			'example' => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'section_title' => 'Наши работы',
						'is_preview' => true
					)
				)
			),
		));


		// Регистрируем блок "Сертификаты и лицензии"
		acf_register_block_type(array(
			'name' => 'certificates',
			'title' => __('Сертификаты и лицензии'),
			'description' => __('Блок для отображения сертификатов и лицензий в карусели'),
			'render_template' => 'template-parts/blocks/certificates.php',
			'category' => 'formatting',
			'icon' => 'id-alt',
			'keywords' => array('сертификаты', 'лицензии', 'карусель', 'галерея'),
			'supports' => array(
				'align' => false,
				'mode' => true,
			),
			'example' => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'section_title' => 'Наши лицензии и сертификаты',
						'is_preview' => true
					)
				)
			),
		));

		// Здесь можно добавить регистрацию других блоков
	}
});

/**
 * Создаем категорию 'custom-blocks' для наших кастомных блоков, если она еще не существует
 */
add_filter('block_categories_all', function ($categories) {
	// Проверяем, существует ли уже категория custom-blocks
	$category_slugs = wp_list_pluck($categories, 'slug');

	if (!in_array('custom-blocks', $category_slugs)) {
		// Если не существует, добавляем новую категорию
		$categories[] = [
			'slug' => 'custom-blocks',
			'title' => 'Кастомные блоки',
			'icon' => null,
		];
	}

	return $categories;
}, 10, 1);

/**
 * Подключение библиотеки Glide.js
 */
add_action('wp_enqueue_scripts', function () {
	// Подключаем Glide.js только на страницах, где есть блок с партнерами
	if (has_block('acf/section-partners')) {
		// CSS файл Glide.js
		wp_enqueue_style(
			'glide-core',
			'https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css',
			[],
			'3.6.0'
		);

		// JavaScript файл Glide.js
		wp_enqueue_script(
			'glide-js',
			'https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js',
			[],
			'3.6.0',
			true
		);
	}
});

/**
 * Дополнительный код для поддержки предпросмотра блока
 */
add_filter('acf/pre_load_value', function ($value, $post_id, $field) {
	if (empty($_GET['post']) && $field['name'] === 'is_preview' && isset($field['key']) && $field['key'] === 'field_block_is_preview') {
		return true;
	}
	return $value;
}, 10, 3);




/**
 * Автоматическая транслитерация кириллических символов в латиницу при создании ярлыков
 */
function custom_transliterate_slug($slug, $post_ID = null, $post_status = null, $post_type = null, $post_parent = null, $original_slug = null)
{
	// Если слаг уже задан вручную и содержит только латинские символы, оставляем как есть
	if (!empty($slug) && !preg_match('/[А-Яа-яЁё]/u', $slug)) {
		return $slug;
	}

	// Получаем название поста/термина если слаг пустой
	if (empty($slug)) {
		// Проверяем, является ли это термином (категорией)
		if (isset($_POST['tag-name'])) {
			$slug = $_POST['tag-name'];
		} elseif (isset($_POST['name'])) {
			$slug = $_POST['name'];
		} elseif ($post_ID) {
			$post = get_post($post_ID);
			if ($post) {
				$slug = $post->post_title;
			}
		}
	}

	if (empty($slug)) {
		return $slug;
	}

	// Таблица транслитерации
	$converter = array(
		'а' => 'a',
		'б' => 'b',
		'в' => 'v',
		'г' => 'g',
		'д' => 'd',
		'е' => 'e',
		'ё' => 'e',
		'ж' => 'zh',
		'з' => 'z',
		'и' => 'i',
		'й' => 'y',
		'к' => 'k',
		'л' => 'l',
		'м' => 'm',
		'н' => 'n',
		'о' => 'o',
		'п' => 'p',
		'р' => 'r',
		'с' => 's',
		'т' => 't',
		'у' => 'u',
		'ф' => 'f',
		'х' => 'kh',
		'ц' => 'ts',
		'ч' => 'ch',
		'ш' => 'sh',
		'щ' => 'sch',
		'ъ' => '',
		'ы' => 'y',
		'ь' => '',
		'э' => 'e',
		'ю' => 'yu',
		'я' => 'ya',

		'А' => 'A',
		'Б' => 'B',
		'В' => 'V',
		'Г' => 'G',
		'Д' => 'D',
		'Е' => 'E',
		'Ё' => 'E',
		'Ж' => 'Zh',
		'З' => 'Z',
		'И' => 'I',
		'Й' => 'Y',
		'К' => 'K',
		'Л' => 'L',
		'М' => 'M',
		'Н' => 'N',
		'О' => 'O',
		'П' => 'P',
		'Р' => 'R',
		'С' => 'S',
		'Т' => 'T',
		'У' => 'U',
		'Ф' => 'F',
		'Х' => 'Kh',
		'Ц' => 'Ts',
		'Ч' => 'Ch',
		'Ш' => 'Sh',
		'Щ' => 'Sch',
		'Ъ' => '',
		'Ы' => 'Y',
		'Ь' => '',
		'Э' => 'E',
		'Ю' => 'Yu',
		'Я' => 'Ya',
	);

	// Дополнительная замена для предлогов и союзов
	$words_map = array(
		'и' => 'and',
		'в' => 'in',
		'с' => 'with',
		'по' => 'by',
		'за' => 'for',
		'на' => 'on',
		'под' => 'under',
		'над' => 'above',
	);

	// Преобразуем предлоги и союзы
	foreach ($words_map as $cyr_word => $lat_word) {
		// Слово целиком
		$slug = preg_replace('/\b' . $cyr_word . '\b/u', $lat_word, $slug);
	}

	// Транслитерация оставшихся символов
	$slug = strtr($slug, $converter);

	// WordPress стандартная фильтрация слага
	$slug = sanitize_title_with_dashes($slug, '', 'save');

	return $slug;
}

// Хуки для применения транслитерации
add_filter('sanitize_title', 'custom_transliterate_slug', 9, 1);
add_filter('name_save_pre', 'custom_transliterate_slug', 9, 1);

// Для терминов (категорий, тегов и т.д.)
function custom_transliterate_term_slug($slug, $term)
{
	return custom_transliterate_slug($slug);
}
add_filter('pre_term_slug', 'custom_transliterate_term_slug', 10, 2);

// Регистрация типа записи "Проекты"
function register_projects_post_type()
{
	$labels = array(
		'name' => 'Наши выполненные проекты',
		'singular_name' => 'Проект',
		'menu_name' => 'Наши проекты',
		'add_new' => 'Добавить новый',
		'add_new_item' => 'Добавить новый проект',
		'edit_item' => 'Редактировать проект',
		'new_item' => 'Новый проект',
		'view_item' => 'Просмотр проекта',
		'search_items' => 'Поиск проектов',
		'not_found' => 'Проекты не найдены',
		'not_found_in_trash' => 'Нет проектов в корзине',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'projects'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-portfolio',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
		'show_in_rest' => false, // Включаем поддержку Gutenberg
	);

	register_post_type('project', $args);

	// Регистрация таксономии "Категории проектов"
	$tax_labels = array(
		'name' => 'Категории проектов',
		'singular_name' => 'Категория проекта',
		'search_items' => 'Искать категории',
		'popular_items' => 'Популярные категории',
		'all_items' => 'Все категории',
		'parent_item' => 'Родительская категория',
		'parent_item_colon' => 'Родительская категория:',
		'edit_item' => 'Редактировать категорию',
		'update_item' => 'Обновить категорию',
		'add_new_item' => 'Добавить новую категорию',
		'new_item_name' => 'Новое имя категории',
		'separate_items_with_commas' => 'Разделите категории запятыми',
		'add_or_remove_items' => 'Добавить или удалить категории',
		'choose_from_most_used' => 'Выбрать из наиболее используемых',
		'menu_name' => 'Категории проектов',
	);

	$tax_args = array(
		'hierarchical' => true,
		'labels' => $tax_labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'project-category'),
		'show_in_rest' => true, // Включаем поддержку Gutenberg
	);

	register_taxonomy('project_category', 'project', $tax_args);
}
add_action('init', 'register_projects_post_type');



/**
 * Функция для добавления JavaScript для разделителей в меню
 */
function add_menu_separators_js()
{
	?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			// Массив ID меню, к которым нужно применить разделители
			const menuIds = ['menu-main-menu', 'menu-main-menu-1', 'menu-main-menu-2'];

			// Проверяем и исправляем активные классы для родительских пунктов меню с активными подпунктами
			menuIds.forEach(function (menuId) {
				const menu = document.querySelector('#' + menuId);
				if (!menu) return;

				// Находим все активные пункты подменю
				const activeSubmenuItems = menu.querySelectorAll('ul.dropdown-menu li.nav-item a.dropdown-item.active');

				// Для каждого активного подпункта находим родительский пункт меню и делаем его активным
				activeSubmenuItems.forEach(function (activeItem) {
					const parentDropdown = activeItem.closest('li.dropdown') || activeItem.closest('li.menu-item-has-children');
					if (parentDropdown) {
						const parentLink = parentDropdown.querySelector('a.nav-link');
						if (parentLink && !parentLink.classList.contains('active')) {
							parentLink.classList.add('active');
						}
					}
				});
			});

			// Применяем изменения ко всем меню в массиве для добавления разделителей
			menuIds.forEach(function (menuId) {
				// Находим меню по ID
				const menu = document.querySelector('#' + menuId);
				if (!menu) return;

				// Находим все элементы первого уровня
				const topLevelItems = menu.querySelectorAll(':scope > li.nav-item');
				if (!topLevelItems.length) return;

				// Массив для отслеживания уже обработанных элементов
				const processedElements = new Set();

				// Проходим по всем элементам
				for (let i = 0; i < topLevelItems.length - 1; i++) {
					const currentItem = topLevelItems[i];

					// Пропускаем, если элемент уже обработан
					if (processedElements.has(currentItem)) continue;

					// Пропускаем добавление разделителя, если текущий элемент имеет класс dropdown или menu-item-has-children
					if (currentItem.classList.contains('dropdown') ||
						currentItem.classList.contains('menu-item-has-children')) {
						processedElements.add(currentItem);
						continue;
					}

					// Создаем элемент разделителя
					const separator = document.createElement('li');
					separator.className = 'nav-item d-none d-lg-inline';

					// Создаем изображение-разделитель
					const img = document.createElement('img');
					img.className = 'nav-link';
					img.src = '<?php echo get_template_directory_uri(); ?>/assets/img/ico/menu-decoration-point.svg';

					// Добавляем изображение в разделитель
					separator.appendChild(img);

					// Вставляем разделитель после текущего элемента меню
					if (currentItem.nextSibling) {
						menu.insertBefore(separator, currentItem.nextSibling);
					} else {
						menu.appendChild(separator);
					}

					// Отмечаем элемент как обработанный
					processedElements.add(currentItem);
				}
			});
		});
	</script>
	<?php
}
add_action('wp_footer', 'add_menu_separators_js');

/**
 * Дополнительно: Добавляем классы current-menu-parent и current-menu-ancestor
 * для правильной обработки активных состояний
 */
function add_menu_parent_class($classes, $item)
{
	global $post;

	if (!$post)
		return $classes;

	// Получаем все дочерние пункты текущего пункта меню
	$children = get_posts(array(
		'post_type' => 'nav_menu_item',
		'meta_query' => array(
			array(
				'key' => '_menu_item_menu_item_parent',
				'value' => $item->ID,
				'compare' => '='
			)
		)
	));

	// Проверяем, есть ли среди дочерних пунктов текущая страница
	if ($children) {
		foreach ($children as $child) {
			$child_object = get_post_meta($child->ID, '_menu_item_object_id', true);

			if (intval($child_object) === $post->ID) {
				$classes[] = 'current-menu-parent';
				$classes[] = 'current-menu-ancestor';
				break;
			}
		}
	}

	return $classes;
}
add_filter('nav_menu_css_class', 'add_menu_parent_class', 10, 2);


/**
 * Добавляем дополнительные классы для header и nav на главной странице
 */
function add_home_page_classes()
{
	if (is_front_page() || is_home()) {
		?>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				// Добавляем класс bg-transparent для nav элементов на главной странице
				const navElements = document.querySelectorAll('.header-nav-top');
				const headerNavBottom = document.getElementById('header-nav-bottom');

				navElements.forEach(function (navElement) {
					if (navElement && !navElement.classList.contains('bg-transparent')) {
						navElement.classList.add('bg-transparent');
					}
				});

				if (headerNavBottom && !headerNavBottom.classList.contains('bg-transparent')) {
					headerNavBottom.classList.add('bg-transparent');
				}
			});
		</script>
		<?php
	}
}
add_action('wp_footer', 'add_home_page_classes');
