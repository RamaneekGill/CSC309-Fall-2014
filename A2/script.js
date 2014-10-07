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

// Colours for the rows of bricks
var colours = ["#d63912", "#eda703", "#fbdd0b", "#64ac02",
               "#04ce92", "#04a5fb", "#6f17ff", "#b501c9"];

function clearCanvas(ctx) {
  // Store the current transformation matrix
  ctx.save();

  // Use the identity matrix while clearing the canvas
  ctx.setTransform(1, 0, 0, 1, 0, 0);
  ctx.clearRect(0, 0, cvsWidth, cvsHeight);

  // Restore the transform
  ctx.restore();
}

/**
 * Draws the ball at location (x, y). The ball has a radius of 10px.
 */
function drawBall(ctx, x, y) {
  ctx.fillStyle = "#777777";
  ctx.beginPath();
  ctx.arc(x, y, 10, 0, 2 * Math.PI);
  ctx.fill();
}

/**
 * Draws the paddle at location (x, y). The paddle is the same width as a brick,
 * but half the height.
 */
function drawPaddle(ctx, x, y) {
  ctx.fillStyle = "#ffffff";
  ctx.fillRect(x, y, brickWidth, brickHeight / 2);
}

/**
 * Draws everything to start the game -- the bricks, paddle, and ball.
 */
function draw() {
  clearCanvas(ctx);

  // The bricks
  var bricks = game.getBricks();
  for (var row = 0; row < bricks.length; row++) {
    ctx.fillStyle = colours[row];

    for (var col = 0; col < bricks[row].length; col++) {

      // Only draw the bricks that haven't been hit!
      if (bricks[row][col] == 1) {
        ctx.fillRect(col * brickWidth + (col + 1) * 10,
                     row * brickHeight + (row + 1) * 10,
                     brickWidth,
                     brickHeight);
      }
    }
  }

  // // The paddle
  // new Paddle(ctx,
  //            cvsWidth / 2 - brickWidth / 2 + game.paddleOffset,
  //            cvsHeight - brickHeight.
  //            brickWidth,
  //            brickHeight / 2);

  // // The ball
  // new Ball(ctx, cvsWidth / 2, cvsHeight - brickHeight - 10, 10);
}


/**
 * Handle window resizing, so the canvas always takes up the available space.
 */
window.addEventListener('resize', resizeCanvas, false);

function resizeCanvas() {
  canvas.width  = window.innerWidth;
  canvas.height = window.innerHeight - document.getElementById('game-nav').offsetHeight;

  cvsWidth  = canvas.width;
  cvsHeight = canvas.height;

  brickWidth  = window.innerWidth / 10 - 11;
  brickHeight = cvsHeight / 25;

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
  game = new GameState(canvas, 30);

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
