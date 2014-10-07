/**
 * Keeps track of the game state.
 */

function GameState(canvas, interval) {
  this.state = this;
  this.interval = interval || 30;
  // setInterval(function() { state.draw(); }, state.interval);

  this.lives = 5;
  this.score = 0;

  this.cvsWidth  = canvas.width;
  this.cvsHeight = canvas.height;

  this.bricks = new Bricks();
  this.paddle = new Paddle();
  this.ball   = new Ball();
}

GameState.prototype.draw = function() {
  var ctx = this.ctx;

  // clear();
}

GameState.prototype.getBricks = function() {
  return this.bricks.getBricks();
}


/**
 *
 */

function Bricks() {
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
}

Bricks.prototype.getBricks = function() {
  return this.bricks;
}

Bricks.prototype.resetBricks = function() {
  for (var i = 0; i < this.bricks.length; i++) {
    for (var j = 0; j < this.bricks[j].length; j++) {
      this.bricks[i][j] = 1;
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
  ctx.fillRect(x, y, width, height);
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
  ctx.arc(x, y, radius, 0, 2 * Math.PI);
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
