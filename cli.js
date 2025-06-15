const readline = require('readline');
readline.emitKeypressEvents(process.stdin);
if (process.stdin.isTTY) process.stdin.setRawMode(true);

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
  prompt: 'type your command> '
});

const history = [];
let historyIndex = 0;

console.log('Simple CLI. Press up/down to navigate the last 10 commands.');
rl.prompt();

process.stdin.on('keypress', (str, key) => {
  if (key.name === 'up') {
    if (historyIndex > 0) historyIndex--;
    const cmd = history[historyIndex] || '';
    rl.write(null, { ctrl: true, name: 'u' });
    rl.write(cmd);
  } else if (key.name === 'down') {
    if (historyIndex < history.length) historyIndex++;
    const cmd = history[historyIndex] || '';
    rl.write(null, { ctrl: true, name: 'u' });
    rl.write(cmd);
  } else if (key.sequence === '\u0003') {
    rl.close();
  }
});

rl.on('line', line => {
  const trimmed = line.trim();
  if (trimmed) {
    history.push(trimmed);
    if (history.length > 10) history.shift();
  }
  historyIndex = history.length;
  console.log(`You typed: ${line}`);
  rl.prompt();
}).on('close', () => {
  console.log('Session ended');
  process.exit(0);
});
