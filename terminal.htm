<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Farshid Terminal</title>
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
    <div class="farshid_logo">Farshid Terminal</div>
    <div class="farshid_header_controls">
        <input type="text" class="farshid_search" placeholder="Search...">
        <button id="farshid_daynight_btn" class="farshid_daynight_btn">&#9790;</button>
    </div>
</header>

<div class="farshid_terminal_help">Type 'help' to see available commands</div>

<div id="farshid_terminal_output" class="farshid_terminal_output"></div>

<div class="farshid_terminal_input_row">
    <div class="farshid_terminal_prompt">&gt;</div>
    <input id="farshid_terminal_input" class="farshid_terminal_input" type="text" placeholder="Type your command...">
</div>

<footer>
    © 2025 Farshid Terminal. All rights reserved.
</footer>

<script>
    const farshid_output = document.getElementById('farshid_terminal_output');
    const farshid_input = document.getElementById('farshid_terminal_input');
    const farshid_daynight_btn = document.getElementById('farshid_daynight_btn');

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

    function farshid_handleCommand(cmd) {
        if (cmd === 'help') {
            return 'Available commands:\nhelp - show this message\nclear - clear the terminal';
        } else if (cmd === 'clear') {
            farshid_output.innerHTML = '';
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
                if (cmd !== 'clear') {
                    const isWarning = output.startsWith('Command not found');
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
