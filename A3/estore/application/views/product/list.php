<div id='cards-list'>
  <h2>
    Catalogue
    <?php echo anchor('/add', 'Add new card'); ?>
  </h2>

  <?php foreach ($products as $product): ?>
    <div class="product-card">
      <img src='<?php echo base_url() ?>images/product/<?php echo $product->photo_url?>' />
      <h2><?php echo $product->name ?></h2>
      <p>$<?php echo $product->price ?></p>
      <p><?php echo $product->description ?></p>
      <div class="product-card-actions">
        <?php echo anchor("/delete/$product->id", 'Delete', "onClick='return confirm(\"Do you really want to delete this record?\");'") ?>
        <?php echo anchor("/edit/$product->id", 'Edit') ?>
        <?php echo anchor("/cart/add/$product->id", 'Add to cart') ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div id='admin-tasks'>
  <?php if ($is_admin): ?>
    <h2>Admin tasks</h2>
    <h3>Finalized orders:</h3>
    <div id="orders">
      <?php
        foreach ($orders as $order) {
          echo $order->id;
        }

        if (empty($orders)) {
          echo '<p>No finalized orders</p>';
        }
      ?>
    </div>

    <h3>Delete data:</h3>
    <?php echo anchor("/delete_data", 'Delete all customer and order information'); ?>
  <?php endif; ?>
</div>
