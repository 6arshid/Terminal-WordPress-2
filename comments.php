<?php if (post_password_required()) return; ?>
<div id="comments" class="farshid_comments">
<?php if (have_comments()): ?>
    <h2><?php comments_number(); ?></h2>
    <ol class="comment-list">
        <?php wp_list_comments(); ?>
    </ol>
<?php endif; ?>
<?php comment_form(); ?>
</div>

