/**
 * Handle menu stuff.
 */
var btnPlay = document.getElementById('game-menu-play');

btnPlay.onclick = function() {
  document.body.className = 'game';
}

document.getElementById('game-pause').onclick = function() {
  document.body.className = '';
}


/**
 * Actual game canvas logic.
 */
// Canvas object and the context.
var canvas, ctx;

var nav   = document.getElementById('game-nav');
var score = document.getElementById('game-score-num');

// GameState object
var game;


/**
 * Draws everything -- the bricks, paddle, and ball.
 */
function draw() {
  game.clearCanvas();

  game.getBricks().draw();
  game.getPaddle().draw();
  game.getBall().draw();
}


/**
 * Handle window resizing, so the canvas always takes up the available space,
 * and everything scales properly.
 */
window.addEventListener('resize', resizeCanvas, false);

function resizeCanvas() {
  canvas.width  = window.innerWidth;
  canvas.height = window.innerHeight - nav.offsetHeight;

  game.updateCanvasDim(canvas);
  draw();
}


/**
 * Keyboard events
 */
document.body.onkeydown = function(event) { keyEvent(event); };

// Keyboard events
function keyEvent(event) {
  var key = event.keyCode || event.which;

  var skip = game.getCanvasWidth() / 50;
  var cvsWidth = game.getCanvasWidth();
  var cvsHeight = game.getCanvasHeight();
  var brickWidth = game.getBricks().getBrickWidth();
  var brickHeight = game.getBricks().getBrickHeight();

  if (key == 13) {
    // Enter key
    document.body.className = (document.body.className == '') ? 'game' : '';
  }

  if (key == 37) {
    // Left arrow key
    // game.paddleOffset -= skip;

    // if (game.paddleOffset + (cvsWidth / 2) - (brickWidth / 2) < 0) {
    //   game.paddleOffset = 1 - (cvsWidth / 2) + (brickWidth / 2);
    // }

  } else if (key == 39) {
    // Right arrow key
    // game.paddleOffset += skip;

    // if (game.paddleOffset + (cvsWidth / 2) + (brickWidth / 2) > cvsWidth) {
    //   game.paddleOffset = (cvsWidth / 2) - (brickWidth / 2);
    // }

  }

  draw();
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
  ctx = canvas.getContext('2d');
  game = new GameState(canvas, ctx, 30);

  resizeCanvas();
}
