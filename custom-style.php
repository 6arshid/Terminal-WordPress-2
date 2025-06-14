<?php
header('Content-Type: text/css; charset=utf-8');
require_once dirname(__FILE__, 3) . '/wp-load.php';
$bg = get_theme_mod('terminal_bg_color', '#000000');
$text = get_theme_mod('terminal_text_color', '#00ff00');
?>
:root{
    --terminal-bg-color: <?php echo esc_attr($bg); ?>;
    --terminal-text-color: <?php echo esc_attr($text); ?>;
}
