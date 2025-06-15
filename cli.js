const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
  historySize: 10,
  prompt: '> '
});

console.log('Simple CLI. Press up/down to navigate command history (max 10).');
rl.prompt();

rl.on('line', (line) => {
  console.log(`You typed: ${line}`);
  rl.prompt();
}).on('close', () => {
  console.log('Session ended');
  process.exit(0);
});

