/**
 * Handle menu stuff.
 */
var btnPlay    = document.getElementById('game-menu-play');
var btnResume  = document.getElementById('game-menu-resume');
var btnRestart = document.getElementById('game-menu-restart');

btnPlay.onclick   = toggleMenu;
btnResume.onclick = toggleMenu;
document.getElementById('game-pause').onclick = toggleMenu;

function toggleMenu() {
  var is_playing = document.body.className == '';
  document.body.className = is_playing ? 'game' : '';
  game.playing = is_playing;

  if (!is_playing && !game.started) {
    btnPlay.style.display = 'none';
    document.getElementById('game-menu-restart').style.display = 'block';
    document.getElementById('game-menu-resume').style.display = 'block';
    game.started = true;
  }
}

btnRestart.onclick = restartGame;

function restartGame() {
  game.restart();
  toggleMenu();
}


/**
 * Actual game canvas logic.
 */
var canvas, ctx;
var game;

var nav   = document.getElementById('game-nav');
var lives = document.getElementById('game-score-lives');
var score = document.getElementById('game-score-num');


/**
 * Handle window resizing, so the canvas always takes up the available space,
 * and everything scales properly.
 */
window.addEventListener('resize', resizeCanvas, false);

function resizeCanvas() {
  canvas.width  = window.innerWidth;
  canvas.height = window.innerHeight - nav.offsetHeight;

  game.updateCanvasDim(canvas);
  game.draw();
}


/**
 * Keyboard events
 */
window.addEventListener('keydown', function(e) { keyEvent(e); }, false);

// Keyboard events
function keyEvent(e) {
  var key = e.keyCode || e.which;

  // Enter/Escape/Space keys
  if (key == 13 || key == 27 || key == 32) {
    toggleMenu();
  }

  // R key
  if (key == 82) {
    game.restart();
    document.body.className = 'game';
    game.playing = true;
  }

  var skip = game.cvsWidth / 50;

  if (game.playing) {
    if (key == 37) {
      // Left arrow key
      game.paddle.move(-skip);
    } else if (key == 39) {
      // Right arrow key
      game.paddle.move(skip);
    }

    game.draw();
  }
}


/**
 * Runs on load.
 */
canvas = document.getElementById('game');

if (!canvas.getContext) {

  // Canvas is unsupported, so display a message and prevent the game from starting.
  btnPlay.onclick   = null;
  btnPlay.innerHTML = 'Canvas is not supported in this browser.';

} else {

  // Resize the canvas properly first
  canvas.width  = window.innerWidth;
  canvas.height = window.innerHeight - nav.offsetHeight;

  // If all is well, let's get the context for the canvas and get on our way.
  ctx  = canvas.getContext('2d');
  game = new GameState(canvas, ctx, 10, lives, score);

  resizeCanvas();
}
