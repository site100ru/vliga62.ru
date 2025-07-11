<?php
/**
 * Template Name: Privacy Policy Popup
 * Description: Всплывающая форма политики конфиденциальности с cookie
 * 
 */

// Предотвращаем прямой доступ к файлу
if (!defined('ABSPATH')) {
  exit;
}
?>

<!-- Всплывающая форма Политики конфиденциальности -->
<div class="popup-form" id="popupForm">
  <div class="form-content container p-0">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-9">
        <p class="mb-md-0 text-dark">
          На нашем сайте используются cookie-файлы, в том числе сервисов веб-аналитики. Используя сайт, вы
          соглашаетесь на <a
            href="<?php echo get_template_directory_uri(); ?>/docs/Consent-to-the-processing-of-personal-data.pdf"
            target="_blank">обработку персональных данных</a> при помощи cookie-файлов. Подробнее об обработке
          персональных
          данных вы можете узнать в&nbsp;<a href="<?php echo get_template_directory_uri(); ?>/docs/Privacy-Policy.pdf"
            target="_blank">Политике
            конфиденциальности.</a>
        </p>
      </div>
      <div class="col-md-3 text-md-center">
        <button id="closeBtn" class="btn btn-primary px-4 py-2">Понятно</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const popupForm = document.getElementById('popupForm');
    const closeBtn = document.getElementById('closeBtn');

    // Проверяем нужно ли показывать форму
    function shouldShowPopup() {
      const lastClosed = localStorage.getItem('popupLastClosed');

      // Если пользователь никогда не закрывал форму
      if (!lastClosed) return true;

      // Если прошло более 24 часов (43200000 миллисекунд) с последнего закрытия
      const now = new Date().getTime();
      const twelveHoursInMs = 24 * 60 * 60 * 1000; // 24 часов = 86400000 миллисекунд
      return (now - parseInt(lastClosed)) > twelveHoursInMs;
    }

    // Показываем форму если нужно
    if (shouldShowPopup()) {
      setTimeout(() => {
        popupForm.classList.add('active');
      }, 3000);
    }

    // Функция закрытия формы
    function closePopup() {
      popupForm.classList.remove('active');

      // Сохраняем время закрытия
      localStorage.setItem('popupLastClosed', new Date().getTime().toString());
    }

    // Закрытие по кнопке
    closeBtn.addEventListener('click', closePopup);

    // Закрытие по клику вне формы (опционально)
    popupForm.addEventListener('click', function (e) {
      if (e.target === popupForm) {
        closePopup();
      }
    });
  });
</script>

<!-- Стили для всплывающей формы -->
<style>
  /*** Всплывающая форма Политики конфиденциальности ***/
  .popup-form {
    position: fixed;
    bottom: -500px;
    /* Форма скрыта за пределами экрана */
    left: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(8px);
    /* Размытие фона */
    -webkit-backdrop-filter: blur(8px);
    /* Для Safari */
    box-shadow: 0 -2px 20px rgba(0, 0, 0, 0.2);
    padding: 10px;
    box-sizing: border-box;
    transition: bottom 0.5s ease-out;
    z-index: 1000;
    max-width: 100%;
  }

  .popup-form.active {
    bottom: 0;
  }

  .popup-form a {
    text-decoration: underline;
    font-size: 1rem;
  }

  .popup-form p {
    font-size: 1rem;
    margin-right: 1rem;
  }
</style>

<!-- /Всплывающая форма Политики конфиденциальности -->