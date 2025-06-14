<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php bloginfo('name'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel='stylesheet' href='<?php echo esc_url( get_stylesheet_uri() ); ?>'>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="farshid_terminal_header">
    <div class="farshid_logo"><?php bloginfo('name'); ?></div>
    <div class="farshid_header_controls">
        <form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input class="farshid_search" type="text" name="s" placeholder="Search..." value="<?php echo get_search_query(); ?>" />
        </form>
        <button id="farshid_daynight_btn" class="farshid_daynight_btn">&#9790;</button>
    </div>
</header>
