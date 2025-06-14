<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title><?php bloginfo('name'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    body {
        background-color: #000;
        color: #0f0;
        font-family: monospace;
    }

    .farshid_terminal_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
        background-color: #111;
        color: #0f0;
    }

    .farshid_logo {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .farshid_header_controls {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }

    .farshid_search {
        border: 1px solid #0f0;
        background: transparent;
        color: #0f0;
        padding: 0.3rem 0.6rem;
        border-radius: 0.25rem;
    }

    .farshid_daynight_btn {
        cursor: pointer;
        background: none;
        border: none;
        color: #0f0;
        font-size: 1.2rem;
    }

    .farshid_terminal_output {
        flex: 1;
        overflow-y: auto;
        white-space: pre-wrap;
        display: flex;
        flex-direction: column;
        padding: 1rem;
    }

    .farshid_terminal_block {
        margin-bottom: 0.3rem;
    }

    .farshid_terminal_command {
        color: cyan;
    }

    .farshid_terminal_result {
        color: #0f0;
    }

    .farshid_terminal_input_row {
        display: flex;
        align-items: center;
        padding: 0 1rem 1rem;
    }

    .farshid_terminal_prompt {
        margin-right: 0.5rem;
    }

    .farshid_terminal_input {
        border: none;
        outline: none;
        background: transparent;
        color: #0f0;
        flex: 1;
        font-family: monospace;
    }

    .farshid_terminal_help {
        padding: 0 1rem;
        color: #0f0;
        margin-top: 0.5rem;
        font-size: 0.9rem;
    }

    footer {
        background: #111;
        color: #0f0;
        text-align: center;
        padding: 0.5rem;
        font-size: 0.85rem;
    }

    .dark-mode {
        background-color: #000 !important;
        color: #0f0 !important;
    }

    .light-mode {
        background-color: #f0f0f0 !important;
        color: #000 !important;
    }

    .light-mode input.farshid_search,
    .light-mode .farshid_terminal_input {
        color: #000 !important;
        border-color: #000 !important;
    }

    .light-mode footer {
        background: #ccc !important;
        color: #000 !important;
    }

    .light-mode .farshid_terminal_header {
        background-color: #ddd !important;
        color: #000 !important;
    }
</style>
</head>

<body>
<header class="farshid_terminal_header">
    <div class="farshid_logo"><?php bloginfo('name'); ?></div>
    <div class="farshid_header_controls">
        <form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input class="farshid_search" type="text" name="s" placeholder="Search..." value="<?php echo get_search_query(); ?>" />
        </form>
        <button id="farshid_daynight_btn" class="farshid_daynight_btn">&#9790;</button>
    </div>
</header>

<div class="farshid_terminal_help">Type 'help' for pages or 'posts' to view posts</div>

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
        $page_titles = array_map(function($p){ return $p->post_title; }, $pages);
        echo json_encode($page_titles);
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
        $cat_names = array_map(function($c){ return $c->name; }, $categories);
        echo json_encode($cat_names);
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
        let output = postsSlice.map(p => `- ${p.title} (${p.link})`).join('\n');
        output += '\nCategories: ' + farshid_categories.join(', ');
        if (farshid_posts.length > farshid_posts_per_page) {
            output += '\nType "next" or "prev" to navigate.';
        }
        return output;
    }

    function farshid_handleCommand(cmd) {
        if (cmd === 'help') {
            const pages = farshid_pages.join('\n');
            return 'Pages:\n' + pages + '\nCommands:\nhelp - list pages\nposts - show recent posts';
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
</body>
</html>
