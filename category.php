<?php get_header(); ?>
<div class="farshid_terminal_output">
<h1><?php single_cat_title(); ?></h1>
<?php if ( have_posts() ) : ?>
    <ul>
    <?php while ( have_posts() ) : the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php endwhile; ?>
    </ul>
    <?php the_posts_pagination(); ?>
<?php else : ?>
    <p><?php _e('No posts found', 'terminal'); ?></p>
<?php endif; ?>
</div>
<?php get_footer(); ?>
