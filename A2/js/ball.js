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
  // Bounce off of walls
  if (this.x + this.dx > canvas.width - this.radius ||
        this.x + this.dx < this.radius)
    this.dx = -this.dx;
  if (this.y + this.dy > canvas.height - this.radius ||
    this.y + this.dy < this.radius)
    this.dy = -this.dy;

  this.x += this.speed * this.dx;
  this.y += this.speed * this.dy;

  this.testHit();
}

Ball.prototype.testHit = function() {
  // Hit an edge?
  // Left edge
  if (this.x <= 0) {

  }

  // Right edge
  if (this.x - this.radius >= window.innerWidth) {

  }

  // Top edge
  if (this.y <= 0) {

  }

  // Bottom edge: die
  if (this.y - this.radius >= window.innerHeight) {

  }

  // Hit the paddle?

  // Hit a brick?
}
