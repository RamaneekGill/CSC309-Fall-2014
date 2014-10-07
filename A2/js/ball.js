/**
 *
 */

function Ball(ctx, x, y, radius) {
  this.ctx    = ctx;
  this.x      = x;
  this.y      = y;
  this.radius = radius;
  this.sticky = true;
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
