<?php
function farshid_terminal_scripts() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_style('farshid-terminal', get_stylesheet_uri());
    wp_enqueue_script('farshid-terminal', get_template_directory_uri() . '/assets/js/terminal.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'farshid_terminal_scripts');
