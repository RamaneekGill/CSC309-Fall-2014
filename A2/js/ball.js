function Ball(ctx, x, y, size) {
  this.ctx    = ctx;
  this.x      = x;
  this.y      = y;
  this.size   = size;
  this.speed  = 1;

  this.dx = 2;
  this.dy = -4;

  this.hits      = 0;
  this.hitTop    = false;
  this.hitOrange = false;
  this.hitRed    = false;
}

Ball.prototype.reset = function() {
  this.x = canvas.width / 2;
  this.y = canvas.height - game.paddle.height;
  this.speed = 1;

  this.hits      = 0;
  this.hitTop    = false;
  this.hitOrange = false;
  this.hitRed    = false;
}

Ball.prototype.draw = function() {
  this.ctx.fillStyle = "#777";
  this.ctx.fillRect(this.x, this.y, this.size, this.size);
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

  this.testHit(this.x, this.y, dx, dy);
}

Ball.prototype.testHit = function(x, y, dx, dy) {
  // New coordinates
  var x = x + dx;
  var y = y + dy;

  // Hit a brick?
  var rowheight = game.bricks.brickHeight;
  var colwidth  = game.bricks.brickWidth;
  var row = Math.floor(y / rowheight);
  var col = Math.floor(x / colwidth);

  if (y < game.bricks.row * rowheight &&
        row >= 0 && row < game.bricks.row &&
        col >= 0 && col < game.bricks.col &&
        game.bricks.bricks[row][col] == 1) {

    this.dy = -this.dy;
    game.bricks.bricks[row][col] = 0;

    switch (row) {
      case 0:
      case 1:
        game.score += 7;
        game.updateScore();

        if (!this.hitRed) {
          this.hitRed = true;
          this.speed *= 1.1;
        }
        break;
      case 2:
      case 3:
        game.score += 5;
        game.updateScore();

        if (!this.hitOrange) {
          this.hitOrange = true;
          this.speed *= 1.1;
        }
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

    if (this.hits < 12)
      this.hits++;

    if (this.hits == 4 || this.hits == 12)
      this.speed *= 1.1;

    if (game.bricks.isEmpty()) {
      if (game.level == 1) {
        game.level = 2;
        game.bricks.resetBricks();
        game.paddle.reset();
      } else {
        alert('Game over!');
        clearInterval(game.anim);
      }
    }
  }

  // Bottom edge
  if (y + this.size > canvas.height - game.paddle.height) {
    // Hit paddle: bounce
    if (x > game.paddle.x && x < game.paddle.x + game.paddle.width) {
      this.dy = -this.dy;

      if (x > game.paddle.x && x < game.paddle.x + game.paddle.width / 2)
        this.dx = -Math.abs(this.dx % 5);
      else
        this.dx = Math.abs(this.dx % 5);
    }
  }

  // Or die
  if (y + this.size > canvas.height) {
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
  if (!this.hitTop && y - this.size < 0) {
    this.hitTop = true;
    game.paddle.width /= 2;
  }

  this.x += dx;
  this.y += dy;
}
