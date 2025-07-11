<?php
/**
 * Подвал сайта с использованием обновленных ACF полей
 * Для файла footer.php
 */
?>
<!-- CONTACTS SECTION 4 -->
<section class="footer bg-dark">
	<!-- Desktop version -->
	<div class="container py-5 d-none d-xl-block">
		<div class="row align-items-center">
			<div class="col-xl-2">
				<a href="<?php echo home_url('/'); ?>">
					<img id="navbar-brand-img" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-light.png"
						class="img-fluid" />
				</a>
			</div>
			<div class="col-xl-8">
				<div class="navbar-collapse">
					<?php
					// Вывод основного меню в подвале
					wp_nav_menu(array(
						'theme_location' => 'primary-menu',
						'menu_class' => 'navbar-nav ms-auto mb-3 mb-lg-0 d-flex flex-row justify-content-center align-items-center',
						'container' => false,
						'fallback_cb' => false,
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'walker' => new Bootstrap_Walker_Nav_Menu(),
					));
					?>
				</div>
			</div>
			<div class="col-xl-2 text-end">
				<?php 
				$main_phones = get_field('company_main_phones', 'option');
				if($main_phones && is_array($main_phones) && count($main_phones) > 0): 
					$phone = $main_phones[0]['number']; // Берем первый номер
				?>
				<a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="top-menu-tel nav-link">
					<?php 
					// Получаем иконку телефона, если есть
					$phone_icon = get_field('phone_icon1', 'option');
					if($phone_icon && is_array($phone_icon)): 
					?>
						<img src="<?php echo esc_url($phone_icon['url']); ?>" alt="<?php echo esc_attr($phone_icon['alt']); ?>" class="d-xl-none d-xxl-inline me-2" style="position: relative; bottom: 1px" />
					<?php else: // Запасной вариант, если иконки нет ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/mobile-phone-ico.svg" class="me-2" style="position: relative; bottom: 1px" />
					<?php endif; ?>
					<?php echo $phone; ?>
				</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="row">
			<div class="col py-4 d-flex justify-content-center align-items-center">
				<ul class="nav footer-nav align-items-center">
					<?php if(get_field('company_address_min', 'option')): ?>
					<li class="nav-item me-3">
						<div class="d-flex align-items-center gap-3 lh-1" style="color: #c8c8c8">
							<?php 
							// Получаем иконку адреса, если есть
							$location_icon = get_field('location_icon', 'option');
							if($location_icon && is_array($location_icon)): 
							?>
								<img src="<?php echo esc_url($location_icon['url']); ?>" alt="<?php echo esc_attr($location_icon['alt']); ?>" />
							<?php else: // Запасной вариант, если иконки нет ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/location-ico.svg" />
							<?php endif; ?>
							
							<span class="local">
								<?php echo nl2br(get_field('company_address_min', 'option')); ?>
							</span>
						</div>
					</li>
					<?php endif; ?>
					
					<?php if(get_field('company_work_hours', 'option')): ?>
					<li class="nav-item me-3">
						<div class="d-flex align-items-center gap-3 lh-1" style="color: #c8c8c8">
							<?php 
							// Получаем иконку часов, если есть
							$clock_icon = get_field('clock_icon', 'option');
							if($clock_icon && is_array($clock_icon)): 
							?>
								<img src="<?php echo esc_url($clock_icon['url']); ?>" alt="<?php echo esc_attr($clock_icon['alt']); ?>" />
							<?php else: // Запасной вариант, если иконки нет ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/clock-ico.svg" />
							<?php endif; ?>
							<span class="time">
								<?php echo nl2br(get_field('company_work_hours', 'option')); ?>	
							</span>
						</div>
					</li>
					<?php endif; ?>
					
					<?php 
					$emails = get_field('company_emails', 'option');
					if($emails && is_array($emails) && count($emails) > 0): 
						$email = $emails[0]['email']; // Берем первый email
					?>
						<li class="nav-item me-3">
							<a href="mailto:<?php echo esc_attr($email); ?>" class="nav-link d-flex align-items-center gap-3 lh-1">
								<?php 
								// Получаем иконку email, если есть
								$email_icon = get_field('email_icon', 'option');
								if($email_icon && is_array($email_icon)): 
								?>
									<img src="<?php echo esc_url($email_icon['url']); ?>" alt="<?php echo esc_attr($email_icon['alt']); ?>" />
								<?php else: // Запасной вариант, если иконки нет ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/email-ico.svg" />
								<?php endif; ?>
								<?php echo $email; ?>
								<?php if(!empty($emails[0]['description'])): ?>
									<span class="email-desc">(<?php echo $emails[0]['description']; ?>)</span>
								<?php endif; ?>
							</a>
						</li>
					<?php endif; ?>

					<li class="nav-item me-3">
						<button class="nav-link d-flex align-items-center gap-3 lh-1" data-bs-toggle="modal"
							data-bs-target="#callbackModal">
							<?php 
							// Получаем иконку обратного звонка, если есть
							$callback_icon = get_field('callback_icon', 'option');
							if($callback_icon && is_array($callback_icon)): 
							?>
								<img src="<?php echo esc_url($callback_icon['url']); ?>" alt="<?php echo esc_attr($callback_icon['alt']); ?>" />
							<?php else: // Запасной вариант, если иконки нет ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/callback-ico.svg" />
							<?php endif; ?>
							<span>Обратный звонок</span>
						</button>
					</li>
				</ul>
			</div>
		</div>

		<div class="row justify-content-center footer-icon">
			<div class="col">
				<ul class="nav justify-content-center">
					<?php 
					$social_links = get_field('company_social_links', 'option');
					if($social_links && is_array($social_links)): 
						foreach($social_links as $social): 
							if(!empty($social['show_in_footer']) && $social['show_in_footer']):
					?>
						<li class="nav-item">
							<a class="nav-link ico-button px-2" href="<?php echo esc_url($social['link']); ?>" title="<?php echo esc_attr($social['name']); ?>">
								<?php if($social['icon'] && is_array($social['icon'])): ?>
									<img src="<?php echo esc_url($social['icon']['url']); ?>" alt="<?php echo esc_attr($social['name']); ?>" />
								<?php else: ?>
									<?php echo esc_html($social['name']); ?>
								<?php endif; ?>
							</a>
						</li>
					<?php 
							endif;
						endforeach;
					endif; 
					?>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Desktop version -->

	<!-- Mobile version -->
	<div class="container d-xl-none">
		<div class="row">
			<div class="col py-5">
				<a href="<?php echo home_url('/'); ?>">
					<img id="navbar-brand-img" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-light.png"
						class="img-fluid" />
				</a>
				<ul class="ps-0 pt-5 pt-md-3 pb-2 navbar-nav">
					<?php if(get_field('company_address_min', 'option')): ?>
					<li class="nav-item">
						<div class="nav-link ps-0 pb-2">
							<?php 
							// Получаем иконку адреса, если есть
							$location_icon = get_field('location_icon', 'option');
							if($location_icon && is_array($location_icon)): 
							?>
								<img src="<?php echo esc_url($location_icon['url']); ?>" alt="<?php echo esc_attr($location_icon['alt']); ?>" class="me-2" />
							<?php else: // Запасной вариант, если иконки нет ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/location-ico.svg" class="me-2" />
							<?php endif; ?>
							<span><?php echo get_field('company_address_min', 'option'); ?></span>
						</div>
					</li>
					<?php endif; ?>

					<?php if(get_field('company_work_hours', 'option')): ?>
					<li class="nav-item">
						<div class="nav-link ps-0 py-2">
							<?php 
							// Получаем иконку часов, если есть
							$clock_icon = get_field('clock_icon', 'option');
							if($clock_icon && is_array($clock_icon)): 
							?>
								<img src="<?php echo esc_url($clock_icon['url']); ?>" alt="<?php echo esc_attr($clock_icon['alt']);  ?>" class="me-2" />
							<?php else: // Запасной вариант, если иконки нет ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/clock-ico.svg" class="me-2" />
							<?php endif; ?>
							<span><?php echo nl2br(get_field('company_work_hours', 'option')); ?></span>
						</div>
					</li>
					<?php endif; ?>
					
					<?php 
					$emails = get_field('company_emails', 'option');
					if($emails && is_array($emails) && count($emails) > 0): 
						$email = $emails[0]['email']; // Берем первый email
					?>
						<li class="nav-item">
							<a href="mailto:<?php echo esc_attr($email); ?>" class="nav-link ps-0 py-2" style="text-transform: lowercase">
								<?php 
								// Получаем иконку email, если есть
								$email_icon = get_field('email_icon', 'option');
								if($email_icon && is_array($email_icon)): 
								?>
									<img src="<?php echo esc_url($email_icon['url']); ?>" alt="<?php echo esc_attr($email_icon['alt']); ?>" class="me-2" />
								<?php else: // Запасной вариант, если иконки нет ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/email-ico.svg" class="me-2" />
								<?php endif; ?>
								<?php echo $email; ?>
								<?php if(!empty($emails[0]['description'])): ?>
									<span class="email-desc">(<?php echo $emails[0]['description']; ?>)</span>
								<?php endif; ?>
							</a>
						</li>
					<?php endif; ?>
				
					<li class="nav-item">
						<button class="nav-link ps-0 pt-2" data-bs-toggle="modal" data-bs-target="#callbackModal">
							<?php 
							// Получаем иконку обратного звонка, если есть
							$callback_icon = get_field('callback_icon', 'option');
							if($callback_icon && is_array($callback_icon)): 
							?>
								<img src="<?php echo esc_url($callback_icon['url']); ?>" alt="<?php echo esc_attr($callback_icon['alt']); ?>" class="me-2" />
							<?php else: // Запасной вариант, если иконки нет ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/callback-ico.svg" class="me-2" />
							<?php endif; ?>
							Обратный звонок
						</button>
					</li>
				</ul>
				
				<?php 
				
				$main_phones = get_field('company_main_phones', 'option');
				if($main_phones && is_array($main_phones) && count($main_phones) > 0): 
					$phone = $main_phones[0]['number']; // Берем первый номер
				?>
				<a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="top-menu-tel nav-link active">
					<?php 
					// Получаем иконку телефона, если есть
					$phone_icon = get_field('phone_icon1', 'option');
					if($phone_icon && is_array($phone_icon)): 
					?>
						<img src="<?php echo esc_url($phone_icon['url']); ?>" alt="<?php echo esc_attr($phone_icon['alt']); ?>" class="me-2" style="position: relative; bottom: 1px" />
					<?php else: // Запасной вариант, если иконки нет ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/mobile-phone-ico.svg" class="me-2" style="position: relative; bottom: 1px" />
					<?php endif; ?>
					<?php echo $phone; ?>
				</a>
				<?php endif; ?>
				
				<ul class="nav pt-4 pb-3">
					<?php 
					$social_links = get_field('company_social_links', 'option');
					if($social_links && is_array($social_links)): 
						foreach($social_links as $social): 
							if(!empty($social['show_in_footer']) && $social['show_in_footer']):
					?>
						<li class="nav-item">
							<a class="nav-link ico-button px-2" href="<?php echo esc_url($social['link']); ?>" title="<?php echo esc_attr($social['name']); ?>">
								<?php if($social['icon'] && is_array($social['icon'])): ?>
									<img src="<?php echo esc_url($social['icon']['url']); ?>" alt="<?php echo esc_attr($social['name']); ?>" />
								<?php else: ?>
								
															<span><?php echo nl2br(get_field('company_work_hours', 'option')); ?></span>

									
								<?php endif; ?>
							</a>
						</li>
					<?php 
							endif;
						endforeach;
					endif; 
					?>
				</ul>
                
				<div class="row footer-menu">
					<div class="col-6">
						<?php
						// Первая колонка меню в футере
						wp_nav_menu(array(
							'theme_location' => 'footer-menu-1',
							'menu_class' => 'nav flex-column',
							'container' => false,
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'walker' => new Bootstrap_Walker_Nav_Menu(),
							'depth' => 2, // Ограничиваем глубину меню для мобильной версии
						));
						?>
					</div>
					<div class="col-6">
						<?php
						// Вторая колонка меню в футере
						wp_nav_menu(array(
							'theme_location' => 'footer-menu-2',
							'menu_class' => 'nav flex-column',
							'container' => false,
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'walker' => new Bootstrap_Walker_Nav_Menu(),
							'depth' => 2, // Ограничиваем глубину меню для мобильной версии
						));
						?>
					</div>
				</div>

			</div>
		</div>
	</div>

	<hr />

	<!-- Footer -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col text-start text-md-center">
					<div id="company-in-footer">
						©<?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?> | ИНН <?php the_field('company_inn', 'option'); ?>
					</div>
					<div id="im-in-footer">
						Создание, продвижение и поддержка:
						<a href="https://сайт100.рф/" class="text-light">сайт100.рф</a>
					</div>
				</div>
			</div>
		</div>
	</footer>

</section>

<!-- Callback Modal -->
<div class="modal fade" id="callbackModal" tabindex="-1" aria-labelledby="callbackModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<?php if (function_exists('wpcf7_contact_form')): ?>
			<?php echo do_shortcode('[contact-form-7 id="09bedbc" title="Контактная форма 1"]'); ?>
		<?php endif; ?>
	</div>
</div>
<!-- /Callback Modal -->

<?php wp_footer(); ?>

<!-- Подключение дополнительных скриптов -->
<script>
	// Маска для телефона
	document.addEventListener('DOMContentLoaded', function () {
		if (typeof Inputmask !== 'undefined') {
			var telInputs = document.querySelectorAll('.telMask');
			var im = new Inputmask('+7 (999) 999-99-99');
			telInputs.forEach(function (input) {
				im.mask(input);
			});
		}
	});
</script>
</body>

</html>