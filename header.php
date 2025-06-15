<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="farshid_terminal_header">
    <button id="farshid_hamburger" class="farshid_hamburger">&#9776;</button>
    <div class="farshid_logo">
        <?php
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                the_custom_logo();
                echo '<span class="farshid_blogname">' . get_bloginfo('name') . '</span>';
            } else {
                bloginfo('name');
            }
        ?>
    </div>
    <div class="farshid_header_controls">
        <form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input class="farshid_search" type="text" name="s" placeholder="<?php esc_attr_e('Search...', 'terminal'); ?>" value="<?php echo get_search_query(); ?>" />
        </form>
        <button id="farshid_daynight_btn" class="farshid_daynight_btn">&#9790;</button>
    </div>
</header>

<nav id="farshid_sidebar" class="farshid_sidebar">
    <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'farshid_sidebar_menu',
        ) );
    ?>
</nav>
