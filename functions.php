<?php
function terminal_setup() {
    load_theme_textdomain('terminal', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'terminal_setup');
