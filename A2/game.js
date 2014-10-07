/**
 * Keeps track of the game state.
 */

function GameState(canvas, ctx, interval) {
  this.cvsWidth  = canvas.width;
  this.cvsHeight = canvas.height;
  this.ctx = ctx;

  this.state = this;
  this.interval = interval || 50;
  // setInterval(function() { state.draw(); }, state.interval);

  this.playing = false;
  this.lives   = 5;
  this.score   = 0;

  // Initialize all the game elements
  this.bricks = new Bricks(ctx,
                           window.innerWidth / 10 - 11,
                           this.cvsHeight / 25);

  this.paddle = new Paddle(ctx,
                           this.cvsWidth / 2 - this.bricks.getBrickWidth() / 2,
                           this.cvsHeight - this.bricks.getBrickHeight(),
                           this.bricks.getBrickWidth(),
                           6);

  this.ball   = new Ball(ctx,
                         this.cvsWidth / 2,
                         this.cvsHeight - this.bricks.getBrickHeight() - 10,
                         10);
}

GameState.prototype.restart = function() {
  this.playing = true;
  this.lives   = 5;
  this.score   = 0;
}

GameState.prototype.updateCanvasDim = function(canvas) {
  this.cvsWidth  = canvas.width;
  this.cvsHeight = canvas.height;

  this.bricks.updateBricksDim(window.innerWidth / 10 - 11, this.cvsHeight / 25)
}

GameState.prototype.getCanvasWidth = function() {
  return this.cvsWidth;
}

GameState.prototype.getCanvasHeight = function() {
  return this.cvsHeight;
}

GameState.prototype.draw = function() {
  var ctx = this.ctx;

  // clear();
}

GameState.prototype.clearCanvas = function() {
  var ctx = this.ctx;

  // Store the current transformation matrix
  ctx.save();

  // Use the identity matrix while clearing the canvas
  ctx.setTransform(1, 0, 0, 1, 0, 0);
  ctx.clearRect(0, 0, this.cvsWidth, this.cvsHeight);

  // Restore the transform
  ctx.restore();
}

GameState.prototype.getBricks = function() {
  return this.bricks;
}

GameState.prototype.getPaddle = function() {
  return this.paddle;;
}

GameState.prototype.getBall = function() {
  return this.ball;
}


/**
 *
 */

function Bricks(ctx, brickWidth, brickHeight) {
  this.ctx = ctx;
  this.brickWidth  = brickWidth;
  this.brickHeight = brickHeight;

  // Holds the status of the bricks (8 rows of 10 bricks each).
  // A 1 means that it's still there, 0 means it's been hit.
  this.bricks = [[1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                 [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                 [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                 [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                 [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                 [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                 [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                 [1, 1, 1, 1, 1, 1, 1, 1, 1, 1]];

  // Colours for the rows of bricks
  this.colours = ["#d63912", "#eda703", "#fbdd0b", "#64ac02",
                  "#04ce92", "#04a5fb", "#6f17ff", "#b501c9"];
}

Bricks.prototype.getBricks = function() {
  return this.bricks;
}

Bricks.prototype.getBrickWidth = function() {
  return this.brickWidth;
}

Bricks.prototype.getBrickHeight = function() {
  return this.brickHeight;
}

Bricks.prototype.resetBricks = function() {
  for (var i = 0; i < this.bricks.length; i++) {
    for (var j = 0; j < this.bricks[j].length; j++) {
      this.bricks[i][j] = 1;
    }
  }
}

Bricks.prototype.updateBricksDim = function(brickWidth, brickHeight) {
  this.brickWidth  = brickWidth;
  this.brickHeight = brickHeight;
}

Bricks.prototype.draw = function() {
  var bricks = this.bricks;
  var ctx    = this.ctx;

  for (var row = 0; row < bricks.length; row++) {
    ctx.fillStyle = this.colours[row];

    for (var col = 0; col < bricks[row].length; col++) {

      // Only draw the bricks that haven't been hit!
      if (bricks[row][col] == 1) {
        ctx.fillRect(col * this.brickWidth + (col + 1) * 10,
                     row * this.brickHeight + (row + 1) * 10,
                     this.brickWidth,
                     this.brickHeight);
      }
    }
  }
}


/**
 *
 */

function Paddle(ctx, x, y, width, height) {
  this.ctx    = ctx;
  this.x      = x;
  this.y      = y;
  this.width  = width;
  this.height = height;
}

Paddle.prototype.draw = function() {
  var ctx = this.ctx;

  ctx.fillStyle = "#ffffff";
  ctx.fillRect(this.x, this.y, this.width, this.height);
}


/**
 *
 */

function Ball(ctx, x, y, radius) {
  this.ctx    = ctx;
  this.x      = x;
  this.y      = y;
  this.radius = radius;
}

Ball.prototype.draw = function() {
  var ctx = this.ctx;

  ctx.fillStyle = "#777777";
  ctx.beginPath();
  ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI);
  ctx.fill();
}

Ball.prototype.testHit = function() {
  // Hit an edge?
  // Left edge
  // if (this.x <= )

  // // Right edge
  // if (this.x >= )

  // // Top edge
  // if (this.y <= )

  // // Bottom edge: die
  // if (this.y >= )

  // Hit the paddle?

  // Hit a brick?
}
