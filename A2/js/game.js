/**
 * Keeps track of the game state.
 */

function GameState(canvas, ctx, interval) {
  this.cvsWidth  = canvas.width;
  this.cvsHeight = canvas.height;
  this.ctx = ctx;

  var state = this;
  this.interval = interval || 10;
  setInterval(function() { state.draw(); }, state.interval);

  this.playing = false;
  this.lives   = 3;
  this.score   = 0;

  this.hits    = 0;

  // Initialize all the game elements (needs to be in this order!)
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
  this.lives   = 3;
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
  this.clearCanvas();

  this.ball.move();

  this.bricks.draw();
  this.paddle.draw();
  this.ball.draw();
}

GameState.prototype.clearCanvas = function() {
  this.ctx.clearRect(0, 0, this.cvsWidth, this.cvsHeight);
}

GameState.prototype.getBricks = function() {
  return this.bricks;
}

GameState.prototype.getPaddle = function() {
  return this.paddle;
}

GameState.prototype.getBall = function() {
  return this.ball;
}
