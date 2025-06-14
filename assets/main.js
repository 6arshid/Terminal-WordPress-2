// Terminal theme script

document.addEventListener('DOMContentLoaded', function () {
    const farshid_output = document.getElementById('farshid_terminal_output');
    const farshid_input = document.getElementById('farshid_terminal_input');
    const farshid_daynight_btn = document.getElementById('farshid_daynight_btn');

    if (!farshid_output || !farshid_input) {
        return;
    }

    const terminal_i18n = terminalData.i18n;
    const farshid_pages = terminalData.pages;
    const farshid_posts = terminalData.posts;
    const farshid_categories = terminalData.categories;

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
        resultLine.innerHTML = output;
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
            return terminal_i18n.no_posts;
        }
        let output = postsSlice
            .map(p => `- <a href="${p.link}" class='farshid_post_link' target='_blank'>${p.title}</a>`)
            .join('<br>');
        output += '<br>' + terminal_i18n.categories + ': ' + farshid_categories.map(c => c.name).join(', ');
        if (farshid_posts.length > farshid_posts_per_page) {
            output += '<br>' + terminal_i18n.navigate;
        }
        return output;
    }

    function farshid_handleCommand(cmd) {
        const lowerCmd = cmd.toLowerCase();
        if (cmd === 'help') {
            const pages = farshid_pages.map(p => p.title).join('\n');
            const cats = farshid_categories.map(c => c.name).join('\n');
            return terminal_i18n.help.replace('%PAGES%', pages).replace('%CATEGORIES%', cats);
        } else if (cmd === 'posts') {
            farshid_current_page = 0;
            return farshid_renderPosts();
        } else if (cmd === 'next') {
            if ((farshid_current_page + 1) * farshid_posts_per_page < farshid_posts.length) {
                farshid_current_page++;
                return farshid_renderPosts();
            }
            return terminal_i18n.no_more_posts;
        } else if (cmd === 'prev') {
            if (farshid_current_page > 0) {
                farshid_current_page--;
                return farshid_renderPosts();
            }
            return terminal_i18n.no_previous_posts;
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
                    farshid_addBlock(cmd, content ? content.textContent.trim() : terminal_i18n.no_content);
                });
            return '';
        } else if (farshid_categories.find(c => c.name.toLowerCase() === lowerCmd)) {
            const cat = farshid_categories.find(c => c.name.toLowerCase() === lowerCmd);
            fetch(cat.link)
                .then(r => r.text())
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const content = doc.querySelector('.farshid_terminal_output');
                    farshid_addBlock(cmd, content ? content.textContent.trim() : terminal_i18n.no_content);
                });
            return '';
        } else {
            return terminal_i18n.command_not_found.replace('%s', cmd);
        }
    }

    farshid_input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            const cmd = farshid_input.value.trim();
            if (cmd) {
                const output = farshid_handleCommand(cmd);
                const isWarning = output.startsWith(terminal_i18n.command_not_found.replace('%s', '').trim());
                if (output) {
                    farshid_addBlock(cmd, output, isWarning);
                }
                farshid_input.value = '';
            }
        }
    });

    if (farshid_daynight_btn) {
        farshid_daynight_btn.addEventListener('click', function () {
            document.body.classList.toggle('light-mode');
            if (document.body.classList.contains('light-mode')) {
                farshid_daynight_btn.innerHTML = '\u2600';
            } else {
                farshid_daynight_btn.innerHTML = '\u263D';
            }
        });
    }
});

