<footer>
    <?php printf( esc_html__('© %1$s %2$s. All rights reserved.', 'terminal'), date('Y'), get_bloginfo('name') ); ?>
</footer>

<script>
    const farshid_daynight_btn = document.getElementById('farshid_daynight_btn');
    if (farshid_daynight_btn) {
        farshid_daynight_btn.addEventListener('click', function () {
            document.body.classList.toggle('light-mode');
            if (document.body.classList.contains('light-mode')) {
                farshid_daynight_btn.innerHTML = '&#9728;';
            } else {
                farshid_daynight_btn.innerHTML = '&#9790;';
            }
        });
    }
</script>
<?php wp_footer(); ?>
</body>
</html>
