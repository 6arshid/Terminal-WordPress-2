# Terminal Utilities

This repository contains a simple Node.js command-line tool.

## CLI with History

Run `node cli.js` to start an interactive prompt showing the placeholder
**"type your command"**. Each command you enter is stored in a history stack of
up to 10 items. Press the **up** arrow to recall earlier commands and the
**down** arrow to navigate forward. Press **Ctrl+C** to exit.

## Browser Terminal Input

The WordPress theme includes an input field with the same "type your command"
placeholder. Up to 10 commands are stored per browser session using
`sessionStorage`. Use the ArrowUp and ArrowDown keys to cycle through previous
commands just like a terminal.
