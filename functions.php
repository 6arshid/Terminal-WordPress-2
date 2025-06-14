<?php
function terminal_setup() {
    load_theme_textdomain('terminal', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'terminal_setup');

function terminal_customize_register($wp_customize) {
    $wp_customize->add_setting('terminal_bg_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'terminal_bg_color_control', array(
        'label' => __('Background Color', 'terminal'),
        'section' => 'colors',
        'settings' => 'terminal_bg_color',
    )));

    $wp_customize->add_setting('terminal_text_color', array(
        'default' => '#00ff00',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'terminal_text_color_control', array(
        'label' => __('Text Color', 'terminal'),
        'section' => 'colors',
        'settings' => 'terminal_text_color',
    )));
}
add_action('customize_register', 'terminal_customize_register');

function terminal_customizer_css() {
    $bg = get_theme_mod('terminal_bg_color', '#000000');
    $text = get_theme_mod('terminal_text_color', '#00ff00');
    echo '<style>body{--terminal-bg-color:' . esc_attr($bg) . ';--terminal-text-color:' . esc_attr($text) . ';}</style>';
}
add_action('wp_head', 'terminal_customizer_css');
