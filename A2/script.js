/**
 * Handle menu stuff.
 */
var btnPlay = document.getElementById('game-menu-play');

btnPlay.onclick = function() {
  document.body.className = 'game';
  game.playing = true;
}

document.getElementById('game-pause').onclick = function() {
  document.body.className = '';
  game.playing = false;
}


/**
 * Actual game canvas logic.
 */

var canvas, ctx;

var nav   = document.getElementById('game-nav');
var lives = document.getElementById('game-score-lives');
var score = document.getElementById('game-score-num');

// GameState object
var game;


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

  var cvsWidth    = game.getCanvasWidth();
  var cvsHeight   = game.getCanvasHeight();
  var skip        = cvsWidth / 50;
  var brickWidth  = game.getBricks().getBrickWidth();
  var brickHeight = game.getBricks().getBrickHeight();

  if (key == 13 || key == 27 || key == 32) {
    // Enter/Escape/Space keys
    var is_menu = document.body.className == '';
    document.body.className = is_menu ? 'game' : '';
    game.playing = is_menu;
  }

  if (game.playing) {
    if (key == 37) {
      // Left arrow key
      game.getPaddle().move(-skip);
    } else if (key == 39) {
      // Right arrow key
      game.getPaddle().move(skip);
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
  game = new GameState(canvas, ctx, 15, lives, score);

  resizeCanvas();
}
