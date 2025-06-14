<?php get_header(); ?>
<div class="farshid_terminal_output">
<h1><?php the_archive_title(); ?></h1>
<?php if (have_posts()): while (have_posts()): the_post(); ?>
    <div><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
<?php endwhile; the_posts_pagination(); endif; ?>
</div>
<?php get_footer(); ?>
