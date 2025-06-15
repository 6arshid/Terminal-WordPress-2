<footer>
    <?php printf( esc_html__('© %1$s %2$s. All rights reserved.', 'terminal'), date('Y'), get_bloginfo('name') ); ?>
</footer>

<script src="<?php echo esc_url( get_template_directory_uri() . '/assets/main.js' ); ?>"></script>
<script src="<?php echo esc_url( get_template_directory_uri() . '/assets/hamburger.js' ); ?>"></script>
<?php wp_footer(); ?>
</body>
</html>
