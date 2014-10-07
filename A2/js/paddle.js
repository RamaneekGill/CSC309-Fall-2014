/**
 *
 */

function Paddle(ctx, x, y, width, height, ball) {
  this.ctx    = ctx;
  this.x      = x;
  this.y      = y;
  this.width  = width;
  this.height = height;
  this.ball   = ball;
}

Paddle.prototype.draw = function() {
  var ctx = this.ctx;

  ctx.fillStyle = "#ffffff";
  ctx.fillRect(this.x, this.y, this.width, this.height);
}

Paddle.prototype.move = function(amount) {
  // Take into consideration the window boundaries
  if (this.x + amount <= 0) {
    this.x = 0;

    if (this.ball.sticky) { this.ball.x = this.width / 2; }
  } else if (this.x + amount >= window.innerWidth - this.width) {
    this.x = window.innerWidth - this.width;

    if (this.ball.sticky) { this.ball.x = this.x + this.width / 2; }
  } else {
    this.x += amount;

    if (this.ball.sticky) { this.ball.x += amount; }
  }
}
