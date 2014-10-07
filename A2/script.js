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
// Canvas object, its width/height, and the context.
var canvas, cvsWidth, cvsHeight, ctx;

var score;
score = document.getElementById('game-score-num');

// Game object
var game;

// Brick width/height
var brickWidth, brickHeight;


/**
 * Draws everything to start the game -- the bricks, paddle, and ball.
 */
function draw() {
  game.clearCanvas();

  game.getBricks().draw();
  // game.getPaddle().draw();
  // game.getBall().draw();
}


/**
 * Handle window resizing, so the canvas always takes up the available space.
 */
window.addEventListener('resize', resizeCanvas, false);

function resizeCanvas() {
  canvas.width  = window.innerWidth;
  canvas.height = window.innerHeight - document.getElementById('game-nav').offsetHeight;

  game.updateCanvasDim(canvas);

  brickWidth  = window.innerWidth / 10 - 11;
  brickHeight = game.cvsHeight / 25;

  // So the canvas isn't cleared upon resizing the browser window.
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

  // If all is well, let's get the context for the canvas and get on our way.
  ctx = canvas.getContext('2d');
  game = new GameState(canvas, ctx, 30);

  resizeCanvas();
}


var skip = cvsWidth / 50;

// Keyboard events
function keyEvent(event) {
  var key = event.keyCode || event.which;

  if (key == 37) {
    // left arrow
    game.paddleOffset -= skip;

    if (game.paddleOffset + (cvsWidth / 2) - (brickWidth / 2) < 0) {
      game.paddleOffset = 1 - (cvsWidth / 2) + (brickWidth / 2);
    }

  } else if (key == 39) {
    // right arrow
    game.paddleOffset += skip;

    if (game.paddleOffset + (cvsWidth / 2) + (brickWidth / 2) > cvsWidth) {
      game.paddleOffset = (cvsWidth / 2) - (brickWidth / 2);
    }

  }

  draw();
}

document.body.onkeydown = function(event) { keyEvent(event); };
