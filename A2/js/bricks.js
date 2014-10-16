function Bricks(ctx, col, row, brickWidth, brickHeight) {
  this.ctx = ctx;
  this.brickWidth  = brickWidth;
  this.brickHeight = brickHeight;
  this.offset = this.brickHeight * 2;

  this.col = col;
  this.row = row;

  // Holds the status of the bricks (8 rows of 10 bricks each).
  // A 1 means that it's still there, 0 means it's been hit.
  this.bricks = [];

  for (var i = 0; i < this.row; i++) {
    this.bricks.push([]);
    for (var j = 0; j < this.col; j++) {
      this.bricks[i].push(1);
    }
  }

  // Colours for the rows of bricks
  this.colours = ["#d63912", "#d63912", "#f5ad03", "#f5ad03",
                  "#64ac02", "#64ac02", "#fbf537", "#fbf537"];
}

Bricks.prototype.reset = function() {
  for (var i = 0; i < this.bricks.length; i++) {
    for (var j = 0; j < this.bricks[i].length; j++) {
      this.bricks[i][j] = 1;
    }
  }
}

Bricks.prototype.isEmpty = function() {
  for (var i = 0; i < this.bricks.length; i++) {
    if (this.bricks[i].indexOf(1) > -1) {
      return false;
    }
  }

  return true;
}

Bricks.prototype.updateBricksDim = function(brickWidth, brickHeight) {
  this.brickWidth  = brickWidth;
  this.brickHeight = brickHeight;
}

Bricks.prototype.draw = function() {
  var bricks = this.bricks;

  for (var row = 0; row < bricks.length; row++) {
    this.ctx.fillStyle = this.colours[row];

    for (var col = 0; col < bricks[row].length; col++) {

      // Only draw the bricks that haven't been hit!
      if (bricks[row][col] == 1) {
        this.ctx.fillRect(col * this.brickWidth,
                          row * this.brickHeight + this.offset,
                          this.brickWidth,
                          this.brickHeight);
      }
    }
  }
}
