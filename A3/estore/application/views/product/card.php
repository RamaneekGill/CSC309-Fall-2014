<h2>
  Card: <?php echo $product->name ?>
  <?php echo anchor('/catalogue', 'Back') ?>
</h2>

<p>ID = <?php echo $product->id ?></p>
<p>Name = <?php echo $product->name ?></p>
<p>Description = <?php echo $product->description ?></p>
<p>Price = <?php echo $product->price ?></p>
<p><img src="<?php echo base_url() . "images/product/" . $product->photo_url ?>" width="100"></p>
