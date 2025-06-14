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

function terminal_enqueue_assets() {
    wp_enqueue_style('terminal-style', get_stylesheet_uri());
    wp_enqueue_script('terminal-script', get_template_directory_uri() . '/assets/main.js', array(), null, true);

    $pages = get_pages();
    $page_data = array_map(function($p){ return array('title' => $p->post_title, 'link' => get_page_link($p->ID)); }, $pages);

    $posts_query = new WP_Query(array('posts_per_page' => 100));
    $posts_data = array();
    if ($posts_query->have_posts()) {
        while ($posts_query->have_posts()) {
            $posts_query->the_post();
            $posts_data[] = array(
                'title' => get_the_title(),
                'link' => get_permalink(),
                'categories' => wp_get_post_categories(get_the_ID(), array('fields' => 'names')),
            );
        }
        wp_reset_postdata();
    }

    $categories = get_categories(array('hide_empty' => 0));
    $cat_data = array_map(function($c){ return array('name' => $c->name, 'link' => get_category_link($c->term_id)); }, $categories);

    $i18n = array(
        'no_posts' => __('No posts', 'terminal'),
        'categories' => __('Categories', 'terminal'),
        'navigate' => __('Type "next" or "prev" to navigate.', 'terminal'),
        'help' => __('Pages:\n%PAGES%\nCategories:\n%CATEGORIES%\nCommands:\nhelp - list pages\nposts - show recent posts', 'terminal'),
        'no_more_posts' => __('No more posts', 'terminal'),
        'no_previous_posts' => __('No previous posts', 'terminal'),
        'no_content' => __('No content', 'terminal'),
        'command_not_found' => __('Command not found: %s', 'terminal'),
    );

    wp_localize_script('terminal-script', 'terminalData', array(
        'i18n' => $i18n,
        'pages' => $page_data,
        'posts' => $posts_data,
        'categories' => $cat_data,
    ));
}
add_action('wp_enqueue_scripts', 'terminal_enqueue_assets');
