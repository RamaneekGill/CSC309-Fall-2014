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

  // Initialize all the game elements (needs to be in order)
  this.bricks = new Bricks(ctx,
                           window.innerWidth / 10 - 11,
                           this.cvsHeight / 25);

  this.ball   = new Ball(ctx,
                         this.cvsWidth / 2,
                         this.cvsHeight - this.bricks.getBrickHeight() - 10,
                         10);

  this.paddle = new Paddle(ctx,
                           this.cvsWidth / 2 - this.bricks.getBrickWidth() / 2,
                           this.cvsHeight - this.bricks.getBrickHeight(),
                           this.bricks.getBrickWidth(),
                           6,
                           this.ball);
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

  this.clearCanvas();

  this.bricks.draw();
  this.paddle.draw();
  this.ball.draw();
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
