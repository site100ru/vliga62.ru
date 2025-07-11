<?php
/**
 * Block Name: Секция Контакты
 * Description: Блок для отображения контактной информации компании
 */

// Создаем уникальный ID для блока
$id = 'section-contacts-' . $block['id'];

// Добавляем дополнительные классы, если они есть
$className = '';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

// Получаем данные из настроек сайта
$address = get_field('company_address', 'option');
$work_hours = get_field('company_work_hours', 'option');

// Телефоны
$main_phones = get_field('company_main_phones', 'option');
$department_phones = get_field('company_department_phones', 'option');

// Email
$emails = get_field('company_emails', 'option');

// Социальные сети
$social_links = get_field('company_social_links', 'option');

// Иконки
$points_image = get_field('points_image', 'option');
$location_icon = get_field('location_icon', 'option');
$clock_icon = get_field('clock_icon', 'option');
$phone_icon1 = get_field('phone_icon1', 'option');
$phone_icon2 = get_field('phone_icon2', 'option');
$email_icon = get_field('email_icon', 'option');
$callback_icon = get_field('callback_icon', 'option');

// Получаем настройки хлебных крошек
$show_breadcrumbs = get_field('show_breadcrumbs');
$breadcrumb_title = get_field('contacts_breadcrumb_title', 'option') ?: 'Контакты';

// Заголовок секции
$contacts_title = get_field('contacts_title', 'option') ?: 'Контакты';
?>

<section id="<?php echo esc_attr($id); ?>"
  class="section text-dark section-about section-grid <?php echo esc_attr($className); ?>">
  <div class="container">
    <?php if ($show_breadcrumbs): ?>
      <!-- Хлебные крошки -->
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 m-0">
          <li class="breadcrumb-item">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none text-secondary">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/breadcrumbs.svg"
                class="img-fluid" alt="Главная" loading="lazy" />
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?php echo esc_html($breadcrumb_title); ?>
          </li>
        </ol>
      </nav>
    <?php endif; ?>

    <div class="section-title text-center mb-5">
      <h3 class="text-dark"><?php echo esc_html($contacts_title); ?></h3>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico/points.png"
        class="img-fluid section-director-points" alt="" />
    </div>

    <!-- Контактный контент -->
    <div class="row mb-5 section-contacts">
      <!-- Первый блок - Основная информация -->
      <div class="col-12 col-md-6 col-xl-4 mb-0 mb-md-4">
        <?php if (!empty($address)): ?>
          <div class="d-flex align-items-center mb-3">
            <?php if (!empty($location_icon)): ?>
              <img src="<?php echo esc_url($location_icon['url']); ?>" alt="Адрес" class="me-3 img-fluid" />
            <?php endif; ?>
            <p class="mb-0 text-min-text"><?php echo esc_html($address); ?></p>
          </div>
        <?php endif; ?>

        <?php if (!empty($work_hours)): ?>
          <div class="d-flex align-items-center mb-3">
            <?php if (!empty($clock_icon)): ?>
              <img src="<?php echo esc_url($clock_icon['url']); ?>" alt="Часы работы" class="me-3 img-fluid" />
            <?php endif; ?>
            <p class="mb-0 text-min-text"><?php echo esc_html($work_hours); ?></p>
          </div>
        <?php endif; ?>

        <?php
        if (!empty($main_phones) && is_array($main_phones)):
          foreach ($main_phones as $index => $phone):
            $icon = ($index === 0 && !empty($phone_icon1)) ? $phone_icon1 : $phone_icon2;
            ?>
            <div class="d-flex align-items-center mb-3 flex-wrap">
              <?php if (!empty($icon)): ?>
                <img src="<?php echo esc_url($icon['url']); ?>" alt="Телефон" class="me-3 img-fluid" />
              <?php endif; ?>
              <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone['number'])); ?>"
                class="text-decoration-none">
                <?php echo esc_html($phone['number']); ?>
              </a>
              <?php if (!empty($phone['description'])): ?>
                <span><?php echo esc_html($phone['description']); ?></span>
              <?php endif; ?>
            </div>
          <?php endforeach; endif; ?>
      </div>

      <!-- Второй блок - Телефоны отделов -->
      <div class="col-12 col-md-6 col-xl-4 mb-0 mb-md-4">
        <?php
        if (!empty($department_phones) && is_array($department_phones)):
          foreach ($department_phones as $phone):
            ?>
            <div class="d-flex align-items-center mb-3 flex-wrap">
              <?php if (!empty($phone_icon2)): ?>
                <img src="<?php echo esc_url($phone_icon2['url']); ?>" alt="Телефон" class="me-3 img-fluid" />
              <?php endif; ?>
              <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone['number'])); ?>"
                class="text-decoration-none">
                <?php echo esc_html($phone['number']); ?>
              </a>
              <?php if (!empty($phone['description'])): ?>
                <span><?php echo esc_html($phone['description']); ?></span>
              <?php endif; ?>
            </div>
          <?php endforeach; endif; ?>
      </div>

      <!-- Третий блок - Email и кнопка обратного звонка -->
      <div class="col-12 col-md-12 col-xl-4 mb-0 mb-md-4">
        <?php
        if (!empty($emails) && is_array($emails)):
          foreach ($emails as $email):
            ?>
            <div class="d-flex align-items-center mb-3 flex-wrap">
              <?php if (!empty($email_icon)): ?>
                <img src="<?php echo esc_url($email_icon['url']); ?>" alt="Email" class="me-3 img-fluid" />
              <?php endif; ?>
              <a href="mailto:<?php echo esc_attr($email['email']); ?>" class="text-decoration-none">
                <?php echo esc_html($email['email']); ?>
              </a>
              <?php if (!empty($email['description'])): ?>
                <span><?php echo esc_html($email['description']); ?></span>
              <?php endif; ?>
            </div>
          <?php endforeach; endif; ?>

        <div class="d-flex align-items-center mb-3">
          <?php if (!empty($callback_icon)): ?>
            <img src="<?php echo esc_url($callback_icon['url']); ?>" alt="Обратный звонок" class="me-3 img-fluid" />
          <?php endif; ?>
          <button class="nav-link d-flex align-items-center gap-3 gap-md-2 gap-xl-3 lh-1" data-bs-toggle="modal"
            data-bs-target="#callbackModal">
            Обратный звонок
          </button>
        </div>
      </div>
    </div>

    <!-- Социальные сети -->
    <?php if (!empty($social_links) && is_array($social_links)): ?>
      <div class="d-flex justify-content-center gap-4 flex-wrap">
        <?php foreach ($social_links as $social): ?>
          <?php if (!empty($social['link']) && !empty($social['icon'])): ?>
            <a href="<?php echo esc_url($social['link']); ?>" target="_blank">
              <img src="<?php echo esc_url($social['icon']['url']); ?>"
                alt="<?php echo esc_attr($social['name'] ?: 'Социальная сеть'); ?>" style="width: 40px" />
            </a>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>