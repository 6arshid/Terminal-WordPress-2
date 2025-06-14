<?php get_header(); ?>
<div class="farshid_terminal_help"><?php esc_html_e("Type 'help' for pages or 'posts' to view posts", 'terminal'); ?></div>
<div id="farshid_terminal_output" class="farshid_terminal_output"></div>

<div class="farshid_terminal_input_row">
    <div class="farshid_terminal_prompt">&gt;</div>
    <input id="farshid_terminal_input" class="farshid_terminal_input" type="text" placeholder="<?php esc_attr_e('Type your command...', 'terminal'); ?>">
</div>



<?php get_footer(); ?>
