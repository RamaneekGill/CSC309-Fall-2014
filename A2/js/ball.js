function Ball(ctx, x, y, size) {
  this.ctx    = ctx;
  this.x      = x;
  this.y      = y;
  this.size   = size;
  this.speed  = 1;

  this.dx = 2;
  this.dy = -4;

  this.hits = 0;
  this.hitTop = false;
}

Ball.prototype.draw = function() {
  var ctx = this.ctx;

  ctx.fillStyle = "#777777";
  ctx.fillRect(this.x, this.y, this.size, this.size);
}

Ball.prototype.move = function() {
  var dx = this.speed * this.dx;
  var dy = this.speed * this.dy;

  // Bounce off of walls
  if (this.x + dx + this.size > canvas.width ||
        this.x + dx - this.size < 0)
    this.dx = -this.dx;
  if (this.y + dy + this.size > canvas.height ||
    this.y + dy - this.size < 0)
    this.dy = -this.dy;

  this.x += dx;
  this.y += dy;

  this.testHit();
}

Ball.prototype.testHit = function() {

  // Hit a brick?
  var rowheight = game.bricks.brickHeight;
  var colwidth  = game.bricks.brickWidth;
  var row = Math.floor(this.y / rowheight);
  var col = Math.floor(this.x / colwidth);

  if (this.y < 8 * rowheight + game.bricks.offset &&
        row >= 0 && col >= 0 &&
        game.bricks.bricks[row][col] == 1) {

    this.dy = -this.dy;
    game.bricks.bricks[row][col] = 0;

    switch (row) {
      case 0:
      case 1:
        game.score += 7;
        game.updateScore();
        break;
      case 2:
      case 3:
        game.score += 5;
        game.updateScore();
        break;
      case 4:
      case 5:
        game.score += 3;
        game.updateScore();
        break;
      case 6:
      case 7:
        game.score++;
        game.updateScore();
        break;
    }

    if (game.bricks.isEmpty()) {
      if (game.level == 1) {
        game.bricks.resetBricks();
        game.paddle.reset();
      } else {
        this.hits++;

        if (this.hits == 4 || this.hits == 12) {
          this.speed++;
        }
      }
    }
  }

  // SPEED INCREASES: 4 hits, 12 hits, contact w/ orange and red rows

  // Bottom edge
  if (this.y + this.size > canvas.height - 3) {
    // Hit paddle: bounce
    if (this.x > game.paddle.x && this.x < game.paddle.x + game.paddle.width) {
      this.dy = -this.dy;
    }
  }

  // Or die
  if (this.y + this.size > canvas.height) {
    // Reset position
    game.paddle.reset();

    this.dx = -this.dx;

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

  // Top edge: first time hitting this reduces the paddle with to half size
  if (!this.hitTop && this.y - this.size < 0) {
    this.hitTop = true;
    game.paddle.width /= 2;
  }
}
