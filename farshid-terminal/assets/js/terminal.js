const farshid_output = document.getElementById('farshid_terminal_output');
const farshid_input = document.getElementById('farshid_terminal_input');
const farshid_daynight_btn = document.getElementById('farshid_daynight_btn');
const farshid_search = document.querySelector('.farshid_search');
let blogPage = 1;

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

function listPages() {
    fetch('/wp-json/wp/v2/pages?per_page=100')
        .then(r => r.json())
        .then(pages => {
            const names = pages.map(p => p.slug).join('\n');
            farshid_addBlock('help', `Pages:\n${names}`);
        });
}

function listPosts(page) {
    fetch(`/wp-json/wp/v2/posts?per_page=10&page=${page}`)
        .then(r => r.json())
        .then(posts => {
            const titles = posts.map(p => `${p.id}: ${p.title.rendered}`).join('\n');
            farshid_addBlock(`help blog ${page}`, `Posts:\n${titles}`);
        });
}

function openPage(slug) {
    fetch(`/wp-json/wp/v2/pages?slug=${slug}`)
        .then(r => r.json())
        .then(pages => {
            if (pages.length) {
                farshid_addBlock(`open ${slug}`, pages[0].content.rendered.replace(/<[^>]+>/g, ''));
            } else {
                farshid_addBlock(`open ${slug}`, 'Page not found', true);
            }
        });
}

function openPost(id) {
    window.open(`/index.php?p=${id}`, '_blank');
}

function farshid_handleCommand(cmd) {
    if (cmd === 'help') {
        listPages();
    } else if (cmd.startsWith('help blog')) {
        const parts = cmd.split(' ');
        blogPage = parseInt(parts[2]) || 1;
        listPosts(blogPage);
    } else if (cmd.startsWith('open ')) {
        const slug = cmd.substring(5);
        openPage(slug);
    } else if (cmd.startsWith('open-post ')) {
        const id = cmd.substring(10);
        openPost(id);
    } else if (cmd === 'clear') {
        farshid_output.innerHTML = '';
    } else {
        farshid_addBlock(cmd, `Command not found: ${cmd}`, true);
    }
}

farshid_input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        const cmd = farshid_input.value.trim();
        if (cmd) {
            farshid_handleCommand(cmd);
            farshid_input.value = '';
        }
    }
});

farshid_daynight_btn.addEventListener('click', function () {
    document.body.classList.toggle('light-mode');
    if (document.body.classList.contains('light-mode')) {
        farshid_daynight_btn.innerHTML = '&#9728;';
    } else {
        farshid_daynight_btn.innerHTML = '&#9790;';
    }
});

farshid_search.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        const term = farshid_search.value.trim();
        if (term) {
            fetch(`/wp-json/wp/v2/search?search=${encodeURIComponent(term)}`)
                .then(r => r.json())
                .then(results => {
                    const out = results.map(r => r.title).join('\n');
                    farshid_addBlock('search', out);
                });
        }
    }
});
