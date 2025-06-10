<?php get_header(); ?>
<main class="container py-5">
<?php
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        echo '<h1>' . get_the_title() . '</h1>';
        the_content();
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
    }
}
?>
</main>
<?php get_footer(); ?>
