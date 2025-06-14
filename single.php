<?php get_header(); ?>
<div class="farshid_terminal_output">
<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        echo '<h1>' . get_the_title() . '</h1>';
        the_content();
        comments_template();
    endwhile;
endif;
?>
</div>
<?php get_footer(); ?>
