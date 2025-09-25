<?php
/**
 * Шорткод для кнопки входа
 * Использование: [authorization_btn]
 */
function authorization_button_shortcode($atts) {
    
    if (is_user_logged_in()) {
        return '';
    }
    
    $atts = shortcode_atts(array(
        'text' => 'Авторизация',
        'url' => '/authorization',
        'class' => 'custom-btn white',
        'target' => '_self'
    ), $atts);
    
    return sprintf(
        '<a href="%s" class="%s" target="%s">%s</a>',
        esc_url($atts['url']),
        esc_attr($atts['class']),
        esc_attr($atts['target']),
        esc_html($atts['text'])
    );
}
add_shortcode('authorization_btn', 'authorization_button_shortcode');

/**
 * Шорткод для кнопки "личный кабинет"
 * Использование: [account_btn]
 */

function account_button_shortcode($atts) {

    $atts = shortcode_atts(array(
        'text' => 'ЗАКАЗЫ',
        'url' => '/account',
        'class' => 'custom-btn white',
        'target' => '_self'
    ), $atts);
    
    return sprintf(
        '<a href="%s" class="%s" target="%s">%s</a>',
        esc_url($atts['url']),
        esc_attr($atts['class']),
        esc_attr($atts['target']),
        esc_html($atts['text'])
    );
}
add_shortcode('account_btn', 'account_button_shortcode');
?>