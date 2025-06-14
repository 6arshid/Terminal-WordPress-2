<?php get_header(); ?>
<div class="farshid_terminal_output farshid_search_results">
    <h1><?php printf( __('Search Results for: %s'), get_search_query() ); ?></h1>
    <?php if ( have_posts() ) : ?>
        <ul class="farshid_terminal_list">
        <?php while ( have_posts() ) : the_post(); ?>
            <li>
                - <a href="<?php the_permalink(); ?>" class="farshid_post_link"><?php the_title(); ?></a>
                <span class="farshid_search_excerpt"><?php echo strip_tags( get_the_excerpt() ); ?></span>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <div class="farshid_terminal_block">
            <div class="farshid_terminal_result"><?php _e('No posts found'); ?></div>
        </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
