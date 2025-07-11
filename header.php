<?php
/**
 * Шапка сайта
 * T
 * Обновленный код для header.php с использованием новой структуры ACF полей
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<header class="d-none d-lg-block <?php echo theme_header_class(); ?>">
		<nav class="header-nav-top navbar navbar-expand-lg navbar-light d-none d-lg-block py-2">
			<div class="container">
				<div class="collapse navbar-collapse">
					<ul class="navbar-nav ms-auto align-items-center">
						<li class="nav-item me-3">
							<!-- Адрес -->
							<div class="d-flex align-items-center gap-3 lh-1 nav-link-text">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/location-ico.svg" />
								<span class="local">
									<?php the_field('company_address_min', 'option'); ?>
								</span>
							</div>
						</li>

						<li class="nav-item me-3">
							<!-- Время работы -->
							<div class="d-flex align-items-center gap-3 lh-1 nav-link-text">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/clock-ico.svg" />
								<span class="time">
									<?php the_field('company_work_hours', 'option'); ?>
								</span>
							</div>
						</li>
						<li class="nav-item me-3">
							<button class="nav-link d-flex align-items-center gap-3 lh-1 p-0" data-bs-toggle="modal"
								data-bs-target="#callbackModal">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/callback-ico.svg" />
								Обратный звонок
							</button>
						</li>

						<?php 
						// Выводим основные телефоны
						if(have_rows('company_main_phones', 'option')):
							$phone_count = 0;
							while(have_rows('company_main_phones', 'option') && $phone_count < 2): the_row();
								$phone_number = get_sub_field('number');
								$phone_clean = preg_replace('/\D/', '', $phone_number); // Очищаем от всех символов, кроме цифр
						?>
							<li class="nav-item me-3">
								<!-- Телефон <?php echo $phone_count + 1; ?> -->
								<a class="top-menu-tel nav-link d-flex align-items-center gap-3 lh-1" href="tel:<?php echo $phone_clean; ?>">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/mobile-phone-ico.svg" />
									<?php echo $phone_number; ?>
								</a>
							</li>
						<?php
								$phone_count++;
							endwhile;
						endif;
						?>

						<?php 
						// Выводим социальные сети в шапке
						if(have_rows('company_social_links', 'option')):
							while(have_rows('company_social_links', 'option')): the_row();
								$show_in_header = get_sub_field('show_in_header');
								if($show_in_header):
									$social_name = get_sub_field('name');
									$social_link = get_sub_field('link');
									$social_icon = get_sub_field('icon');
									
									if($social_icon && $social_link):
						?>
							<li class="nav-item">
								<a class="nav-link ico-button" href="<?php echo esc_url($social_link); ?>">
									<img src="<?php echo esc_url($social_icon['url']); ?>" alt="<?php echo esc_attr($social_name); ?>" />
								</a>
							</li>
						<?php
									endif;
								endif;
							endwhile;
						endif;
						?>
					</ul>
				</div>
			</div>
		</nav>

		<nav class="header-nav-bottom navbar navbar-expand-lg navbar-light py-0" id="header-nav-bottom">
			<div class="container ps-3">
				<a class="navbar-brand" href="<?php echo home_url('/'); ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-dark.png" />
				</a>

				<div class="d-flex d-lg-none flex-column top-menu-tel-wrapper gap-1 my-2">
					<?php 
					// Выводим телефоны для мобильной версии
					if(have_rows('company_main_phones', 'option')):
						$phone_count = 0;
						while(have_rows('company_main_phones', 'option') && $phone_count < 2): the_row();
							$phone_number = get_sub_field('number');
							$phone_clean = preg_replace('/\D/', '', $phone_number);
					?>
						<!-- Телефон <?php echo $phone_count + 1; ?> -->
						<a class="top-menu-tel nav-link" href="tel:<?php echo $phone_clean; ?>">
							<?php if($phone_count > 0): ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/mobile-phone-ico.svg" />
							<?php endif; ?>
							<?php echo $phone_number; ?>
						</a>
					<?php
							$phone_count++;
						endwhile;
					endif;
					?>

					<!-- Время работы -->
					<div class="d-flex align-items-center gap-3 lh-1 mb-0">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/clock-ico.svg" />
						<?php the_field('company_work_hours', 'option'); ?>
					</div>
				</div>

				<button class="navbar-toggler mx-3 me-0 mx-lg-auto mb-3 mb-sm-0" type="button" data-bs-toggle="collapse"
					data-bs-target="#mobail-header-collapse" aria-controls="mobail-header-collapse" aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="mobail-header-collapse">
					<?php
					// Вывод основного меню
					wp_nav_menu(array(
						'theme_location' => 'primary-menu',
						'menu_class' => 'navbar-nav align-items-start align-items-lg-center ms-auto mb-2 mb-lg-0',
						'container' => false,
						'fallback_cb' => false,
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'walker' => new Bootstrap_Walker_Nav_Menu(),
					));
					?>

					<!-- Mobile menu -->
					<ul class="navbar-nav d-lg-none">
						<li class="nav-item">
							<button class="nav-link text-dark" data-bs-toggle="modal" data-bs-target="#callbackModal">
								Обратный звонок
							</button>
						</li>
						<li class="nav-item d-lg-none text-dark">

							<!-- Адрес -->
							<div>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/location-ico.svg"
									style="width: 10px" class="me-1" />
								<?php the_field('company_address_min', 'option'); ?>
							</div>

							<?php 
							// Выводим первый телефон для мобильного меню
							if(have_rows('company_main_phones', 'option')):
								the_row();
								$phone_number = get_sub_field('number');
								$phone_clean = preg_replace('/\D/', '', $phone_number);
							?>
								<!-- Телефон 1 -->
								<a class="top-menu-tel nav-link fw-bold" href="tel:<?php echo $phone_clean; ?>">
									<?php echo $phone_number; ?>
								</a>
							<?php
								reset_rows();
							endif;
							?>

							<!-- Время работы -->
							<div class="mb-2 d-flex">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/clock-ico.svg" style="width: 10px"
									class="me-1" />
								<?php the_field('company_work_hours', 'option'); ?>
							</div>

						</li>
						<li class="nav-item d-lg-none pb-4">
							<?php 
							// Выводим социальные сети для мобильного меню
							if(have_rows('company_social_links', 'option')):
								while(have_rows('company_social_links', 'option')): the_row();
									$show_in_header = get_sub_field('show_in_header');
									if($show_in_header):
										$social_name = get_sub_field('name');
										$social_link = get_sub_field('link');
										$social_icon = get_sub_field('icon');
										
										if($social_icon && $social_link):
							?>
								<!-- <?php echo esc_html($social_name); ?> -->
								<a class="ico-button pe-2" href="<?php echo esc_url($social_link); ?>">
									<img src="<?php echo esc_url($social_icon['url']); ?>" alt="<?php echo esc_attr($social_name); ?>" />
								</a>
							<?php
										endif;
									endif;
								endwhile;
							endif;
							?>
						</li>
					</ul>
					<!-- End mobile menu -->
				</div>
			</div>
		</nav>
	</header>

	<header id="sliding-header" class="shadow">
		<!-- Header nav bottom -->
		<nav class="header-nav-bottom navbar navbar-expand-lg navbar-light py-lg-0">
			<div class="container">
				<a class="navbar-brand" href="<?php echo home_url('/'); ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-dark.png" />
				</a>

				<div class="d-none d-sm-block d-lg-none flex-column top-menu-tel-wrapper gap-1 my-2">
					<div class="d-flex d-lg-none flex-column top-menu-tel-wrapper gap-1 my-2">
						<?php 
						// Выводим телефоны для мобильной версии фиксированной шапки
						if(have_rows('company_main_phones', 'option')):
							$phone_count = 0;
							while(have_rows('company_main_phones', 'option') && $phone_count < 2): the_row();
								$phone_number = get_sub_field('number');
								$phone_clean = preg_replace('/\D/', '', $phone_number);
						?>
							<!-- Телефон <?php echo $phone_count + 1; ?> -->
							<a class="top-menu-tel nav-link" href="tel:<?php echo $phone_clean; ?>">
								<?php echo $phone_number; ?>
							</a>
						<?php
								$phone_count++;
							endwhile;
						endif;
						?>
					</div>
				</div>

				<button class="navbar-toggler mx-3 me-0 mx-lg-auto" type="button" data-bs-toggle="collapse"
					data-bs-target="#sliding-header-collapse" aria-controls="sliding-header-collapse" aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="sliding-header-collapse">
					<?php
					// Вывод основного меню для фиксированной шапки
					wp_nav_menu(array(
						'theme_location' => 'primary-menu',
						'menu_class' => 'navbar-nav align-items-start align-items-lg-center ms-auto mb-0 mb-lg-0',
						'container' => false,
						'fallback_cb' => false,
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'walker' => new Bootstrap_Walker_Nav_Menu(),
					));
					?>

					<!-- Mobile menu for sliding header -->
					<ul class="navbar-nav d-lg-none">
						<li class="nav-item">
							<button class="nav-link text-dark" data-bs-toggle="modal" data-bs-target="#callbackModal">
								Обратный звонок
							</button>
						</li>
						<li class="nav-item d-lg-none text-dark">
							<!-- Адрес -->
							<div>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/location-ico.svg"
									style="width: 10px" class="me-2" /><?php the_field('company_address_min', 'option'); ?></div>

							<?php 
							// Выводим первый телефон для мобильного меню фиксированной шапки
							if(have_rows('company_main_phones', 'option')):
								the_row();
								$phone_number = get_sub_field('number');
								$phone_clean = preg_replace('/\D/', '', $phone_number);
							?>
								<!-- Телефон 1 -->
								<a class="top-menu-tel nav-link" href="tel:<?php echo $phone_clean; ?>">
									<?php echo $phone_number; ?>
								</a>
							<?php
								reset_rows();
							endif;
							?>

							<!-- Время работы -->
							<div class="mb-2 d-flex pb-0 pb-mb-4">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/clock-ico.svg"
									style="width: 10px; position: relative; top: 2px" class="me-2 mb-2" />

								<span class="time" >
									<?php the_field('company_work_hours', 'option'); ?>
								</span>
							</div>

						</li>
						<li class="nav-item d-lg-none pb-0">
							<?php 
							// Выводим социальные сети для мобильного меню фиксированной шапки
							if(have_rows('company_social_links', 'option')):
								while(have_rows('company_social_links', 'option')): the_row();
									$show_in_header = get_sub_field('show_in_header');
									if($show_in_header):
										$social_name = get_sub_field('name');
										$social_link = get_sub_field('link');
										$social_icon = get_sub_field('icon');
										
										if($social_icon && $social_link):
							?>
								<a class="ico-button pe-2" href="<?php echo esc_url($social_link); ?>">
									<img src="<?php echo esc_url($social_icon['url']); ?>" alt="<?php echo esc_attr($social_name); ?>" />
								</a>
							<?php
										endif;
									endif;
								endwhile;
							endif;
							?>
						</li>
					</ul>
					<!-- End mobile menu for sliding header -->
				</div>
			</div>
		</nav>
		<!-- /Header nav bottom -->
	</header>