/**
 * Keeps track of the game state.
 */

function GameState(canvas, ctx, interval, elLives, elScore) {
  this.cvsWidth  = canvas.width;
  this.cvsHeight = canvas.height;
  this.ctx = ctx;

  var state = this;
  this.interval = interval || 20;
  this.anim = setInterval(function() { state.draw(); }, state.interval);

  this.elLives = elLives;
  this.elScore = elScore;

  this.started = false;
  this.playing = false;
  this.lives   = 3;
  this.score   = 0;
  this.level   = 1;

  // Initialize all the game elements (needs to be in this order!)
  this.bricks = new Bricks(ctx,
                           8, 8,
                           window.innerWidth / 8,
                           this.cvsHeight / 25);

  this.ball   = new Ball(ctx,
                         this.cvsWidth / 2,
                         this.cvsHeight - this.bricks.brickHeight - 10,
                         10);

  this.paddle = new Paddle(ctx,
                           this.cvsWidth / 2 - this.bricks.brickWidth / 2,
                           this.cvsHeight - 6,
                           this.bricks.brickWidth,
                           6,
                           this.ball);
}

GameState.prototype.restart = function() {
  this.playing = true;
  this.lives   = 3;
  this.score   = 0;
  this.level   = 1;

  this.updateScore();
  this.bricks.reset();
  this.paddle.reset();
  this.ball.reset();
}

GameState.prototype.updateScore = function() {
  this.elScore.innerHTML = this.score;

  switch (this.lives) {
    case 0:
      this.elLives.innerHTML = 'x x x';
      break;

    case 1:
      this.elLives.innerHTML = 'x x o';
      break;

    case 2:
      this.elLives.innerHTML = 'x o o';
      break;

    case 3:
      this.elLives.innerHTML = 'o o o';
      break;

    default:
      break;
  }
}

GameState.prototype.updateCanvasDim = function(canvas) {
  this.cvsWidth  = canvas.width;
  this.cvsHeight = canvas.height;

  this.bricks.updateBricksDim(window.innerWidth / this.bricks.col, this.cvsHeight / 25);
}

GameState.prototype.clearCanvas = function() {
  this.ctx.clearRect(0, 0, this.cvsWidth, this.cvsHeight);
}


GameState.prototype.draw = function() {
  if (this.playing) {
    this.ball.move();
  }

  this.clearCanvas();

  this.bricks.draw();
  this.paddle.draw();
  this.ball.draw();
}
