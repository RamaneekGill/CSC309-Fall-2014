CSC309 A2
=========
2014-11-27
Eugene Yue-Hin Cheung    g3cheunh
Ramaneek Gill            g3gillra


### AMI ID:



### Location of files:
/var/www/html/estore


### Instructions for starting Apache:

Apache is already installed, configured for the files in /var/www/html, and running!
Just launch the instance, configure it with a Custom TCP rule that allows anyone to
connect to port 80, then visit the instance's Public DNS address in your local browser.

To SSH into the instance, you'll need to use the username "ubuntu", since the AMI is
based on an Ubuntu instance.


### Browser details:

The game should work in relatively updated versions of both Chrome and Firefox. It was
tested in Chrome 38 and Firefox 33 (in an Ubuntu-based distribution).


### Website documentation:

The main user-defined objects used for the gameplay are in the game/ folder. The
script.js file is used to handle UI elements, such as the menu, keyboard events (for
moving the paddle), and window resizing.

A GameState prototype (game.js) is used to keep track of general game information,
including the bricks (bricks.js), ball (ball.js), paddle (paddle.js), lives, levels,
and score. Each of the game-related prototypes contain draw() functions that handle
the drawing of the respective items and resetting, which is used when the game is
restarted, or the user dies and the ball/paddle is reset, or a new level is started
(for the bricks).
