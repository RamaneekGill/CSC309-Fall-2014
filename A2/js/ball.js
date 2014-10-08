function Ball(ctx, x, y, radius) {
  this.ctx    = ctx;
  this.x      = x;
  this.y      = y;
  this.radius = radius;
  this.speed  = 1;

  this.dx = 2;
  this.dy = -4;
}

Ball.prototype.draw = function() {
  var ctx = this.ctx;

  ctx.fillStyle = "#777777";
  ctx.beginPath();
  ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI);
  ctx.fill();
}

Ball.prototype.move = function() {
  var dx = this.speed * this.dx;
  var dy = this.speed * this.dy;

  // Bounce off of walls
  if (this.x + dx + this.radius > canvas.width ||
        this.x + dx - this.radius < 0)
    this.dx = -this.dx;
  if (this.y + dy + this.radius > canvas.height ||
    this.y + dy - this.radius < 0)
    this.dy = -this.dy;

  this.x += dx;
  this.y += dy;

  this.testHit();
}

Ball.prototype.testHit = function() {
  // Paddle
  if (this.y + this.radius >= game.getPaddle().y) {
    if (this.x > game.getPaddle().x && this.x < game.getPaddle().x + game.getPaddle().width) {
      dy = -dy;
    }
  }

  // Top edge
  if (this.y - this.radius < 0) {

  }

  // Bottom edge: die
  if (this.y + this.radius > canvas.height) {
    // Reset position
    this.x = canvas.width / 2;
    this.y = canvas.height - 10;

    this.dx = -this.dx;

    // Reset paddle position


    // Decrement lives, pause for a second (or Game Over)
    game.playing = false;
    game.lives--;

    game.updateScore();

    if (game.lives == 0) {
      alert('Game over!');
      clearInterval(game.anim);
    } else {
      setTimeout(function() { game.playing = true; }, 1000);
    }
  }

  // Hit the paddle?

  // Hit a brick?
}
