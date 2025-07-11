<?php
/**
 * Bootstrap Walker для меню без попыток добавления разделителей
 * Нужно добавить в functions.php или include этот файл
 */
if (!defined('ABSPATH')) {
    exit; // Запрет прямого доступа
}
class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
    /**
     * Начало уровня меню
     */
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $parent_item_id = isset($args->parent_item_id) ? $args->parent_item_id : '';
        $aria_labelledby = !empty($parent_item_id) ? ' aria-labelledby="navbarDropdown' . $parent_item_id . '"' : '';
        
        $output .= "\n$indent<ul class=\"dropdown-menu dropdown-menu-light py-1\" style=\"border-radius: 5px\"$aria_labelledby>\n";
    }
    
    /**
     * Начало элемента
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        
        // Проверка активности пункта меню
        $is_active = in_array('current-menu-item', $classes);
        $is_ancestor_active = in_array('current-menu-ancestor', $classes) || in_array('current-menu-parent', $classes);
        $active_class = ($is_active || $is_ancestor_active) ? 'active' : '';
        
        // Проверка наличия дочерних элементов
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children && $depth === 0) {
            $classes[] = 'dropdown'; // Добавляем класс dropdown для корневых элементов с подменю
        }
        
        // Формирование классов для li
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        // Атрибуты ссылки
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '#'; // Используем # если URL пустой
        
        // Формирование классов для ссылки
        if ($depth === 0) {
            $atts['class'] = 'nav-link';
            
            if ($has_children) {
                $atts['class'] .= ' dropdown-toggle';
                $atts['data-bs-toggle'] = 'dropdown';
                $atts['aria-expanded'] = 'false';
                $atts['role'] = 'button';
                $atts['id'] = 'navbarDropdown' . $item->ID;
                
                // Сохраняем ID родительского элемента для атрибута aria-labelledby
                if (isset($args)) {
                    $args->parent_item_id = $item->ID;
                }
            }
            
            if ($active_class) {
                $atts['class'] .= ' ' . $active_class;
            }
        } else {
            $atts['class'] = 'dropdown-item';
            
            if ($active_class) {
                $atts['class'] .= ' ' . $active_class;
            }
            
            // Добавляем класс nav-item для подменю, как в исходном HTML
            $atts['class'] .= ' nav-item';
        }
        
        // Формирование атрибутов ссылки
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        // Формирование ссылки
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
