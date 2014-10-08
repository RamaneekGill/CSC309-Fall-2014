function Bricks(ctx, brickWidth, brickHeight) {
  this.ctx = ctx;
  this.brickWidth  = brickWidth;
  this.brickHeight = brickHeight;

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

  // Colours for the rows of bricks
  this.colours = ["#d63912", "#eda703", "#fbdd0b", "#64ac02",
                  "#04ce92", "#04a5fb", "#6f17ff", "#b501c9"];
  // this.colours = ["#d63912", "#d63912", "#f5ad03", "#f5ad03",
  //                 "#64ac02", "#64ac02", "#fbf537", "#fbf537"];

  // yellow: 1, green: 3, orange: 5, red: 7
  // paddle width shrinks to half size after ball broken through red row and hit the upper wall
  // ball speed increases: 4 hits, 12 hits, contact w/ orange and red rows
}

Bricks.prototype.getBricks = function() {
  return this.bricks;
}

Bricks.prototype.getBrickWidth = function() {
  return this.brickWidth;
}

Bricks.prototype.getBrickHeight = function() {
  return this.brickHeight;
}

Bricks.prototype.resetBricks = function() {
  for (var i = 0; i < this.bricks.length; i++) {
    for (var j = 0; j < this.bricks[j].length; j++) {
      this.bricks[i][j] = 1;
    }
  }
}

Bricks.prototype.updateBricksDim = function(brickWidth, brickHeight) {
  this.brickWidth  = brickWidth;
  this.brickHeight = brickHeight;
}

Bricks.prototype.draw = function() {
  var bricks = this.bricks;
  var ctx    = this.ctx;

  for (var row = 0; row < bricks.length; row++) {
    ctx.fillStyle = this.colours[row];

    for (var col = 0; col < bricks[row].length; col++) {

      // Only draw the bricks that haven't been hit!
      if (bricks[row][col] == 1) {
        ctx.fillRect(col * this.brickWidth + (col + 1) * 10,
                     row * this.brickHeight + (row + 1) * 10,
                     this.brickWidth,
                     this.brickHeight);
      }
    }
  }
}
