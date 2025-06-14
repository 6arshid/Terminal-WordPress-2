<?php get_header(); ?>

<div id="farshid_terminal_output" class="farshid_terminal_output"></div>

<div class="farshid_terminal_input_row">
    <div class="farshid_terminal_prompt">&gt;</div>
    <input id="farshid_terminal_input" class="farshid_terminal_input" type="text" placeholder="Type your command...">
</div>

<footer>
    © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
</footer>

<script>
    const farshid_output = document.getElementById('farshid_terminal_output');
    const farshid_input = document.getElementById('farshid_terminal_input');
    const farshid_daynight_btn = document.getElementById('farshid_daynight_btn');

    const farshid_pages = <?php
        $pages = get_pages();
        $page_data = array_map(function($p){ return ['title' => $p->post_title, 'link' => get_page_link($p->ID)]; }, $pages);
        echo json_encode($page_data);
    ?>;
    const farshid_posts = <?php
        $posts_query = new WP_Query(['posts_per_page' => 100]);
        $posts_data = [];
        if ($posts_query->have_posts()):
            while ($posts_query->have_posts()): $posts_query->the_post();
                $posts_data[] = [
                    'title' => get_the_title(),
                    'link' => get_permalink(),
                    'categories' => wp_get_post_categories(get_the_ID(), ['fields' => 'names'])
                ];
            endwhile;
            wp_reset_postdata();
        endif;
        echo json_encode($posts_data);
    ?>;
    const farshid_categories = <?php
        $categories = get_categories(['hide_empty' => 0]);
        $cat_data = array_map(function($c){ return ['name' => $c->name, 'link' => get_category_link($c->term_id)]; }, $categories);
        echo json_encode($cat_data);
    ?>;
    let farshid_current_page = 0;
    const farshid_posts_per_page = 10;

    function farshid_addBlock(command, output, isWarning = false) {
        const block = document.createElement('div');
        block.className = 'farshid_terminal_block';

        const cmdLine = document.createElement('div');
        cmdLine.className = 'farshid_terminal_command';
        cmdLine.textContent = `> ${command}`;

        const resultLine = document.createElement('div');
        resultLine.className = 'farshid_terminal_result';
        resultLine.textContent = output;
        if (isWarning) {
            resultLine.style.color = 'yellow';
        }

        block.appendChild(cmdLine);
        block.appendChild(resultLine);

        farshid_output.appendChild(block);
        farshid_output.scrollTop = farshid_output.scrollHeight;
    }

    function farshid_renderPosts() {
        const start = farshid_current_page * farshid_posts_per_page;
        const end = start + farshid_posts_per_page;
        const postsSlice = farshid_posts.slice(start, end);
        if (postsSlice.length === 0) {
            return 'No posts';
        }
        let output = postsSlice.map(p => `- <a href="${p.link}" class="farshid_post_link">${p.title}</a>`).join('\n');
        output += '\nCategories: ' + farshid_categories.map(c => c.name).join(', ');
        if (farshid_posts.length > farshid_posts_per_page) {
            output += '\nType "next" or "prev" to navigate.';
        }
        return output;
    }

    function farshid_handleCommand(cmd) {
        const lowerCmd = cmd.toLowerCase();
        if (cmd === 'help') {
            const pages = farshid_pages.map(p => p.title).join('\n');
            const cats = farshid_categories.map(c => c.name).join('\n');
            return 'Pages:\n' + pages + '\nCategories:\n' + cats + '\nCommands:\nhelp - list pages\nposts - show recent posts';
        } else if (cmd === 'posts') {
            farshid_current_page = 0;
            return farshid_renderPosts();
        } else if (cmd === 'next') {
            if ((farshid_current_page + 1) * farshid_posts_per_page < farshid_posts.length) {
                farshid_current_page++;
                return farshid_renderPosts();
            }
            return 'No more posts';
        } else if (cmd === 'prev') {
            if (farshid_current_page > 0) {
                farshid_current_page--;
                return farshid_renderPosts();
            }
            return 'No previous posts';
        } else if (farshid_posts.find(p => p.title.toLowerCase() === lowerCmd)) {
            const post = farshid_posts.find(p => p.title.toLowerCase() === lowerCmd);
            window.location = post.link;
            return '';
        } else if (farshid_pages.find(p => p.title.toLowerCase() === lowerCmd)) {
            const page = farshid_pages.find(p => p.title.toLowerCase() === lowerCmd);
            fetch(page.link)
                .then(r => r.text())
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const content = doc.querySelector('.farshid_terminal_output');
                    farshid_addBlock(cmd, content ? content.textContent.trim() : 'No content');
                });
            return '';
        } else if (farshid_categories.find(c => c.name.toLowerCase() === lowerCmd)) {
            const cat = farshid_categories.find(c => c.name.toLowerCase() === lowerCmd);
            fetch(cat.link)
                .then(r => r.text())
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const content = doc.querySelector('.farshid_terminal_output');
                    farshid_addBlock(cmd, content ? content.textContent.trim() : 'No content');
                });
            return '';
        } else {
            return `Command not found: ${cmd}`;
        }
    }

    farshid_input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            const cmd = farshid_input.value.trim();
            if (cmd) {
                const output = farshid_handleCommand(cmd);
                const isWarning = output.startsWith('Command not found');
                if (output) {
                    farshid_addBlock(cmd, output, isWarning);
                }
                farshid_input.value = '';
            }
        }
    });

    // Day/Night mode toggle
    farshid_daynight_btn.addEventListener('click', function () {
        document.body.classList.toggle('light-mode');
        if (document.body.classList.contains('light-mode')) {
            farshid_daynight_btn.innerHTML = '&#9728;'; // sun
        } else {
            farshid_daynight_btn.innerHTML = '&#9790;'; // moon
        }
    });
</script>
<?php get_footer(); ?>
