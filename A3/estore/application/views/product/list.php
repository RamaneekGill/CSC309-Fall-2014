<div id='cards-list'>
  <h2>
    Catalogue
    <?php echo anchor('/add', 'Add new card'); ?>
  </h2>

  <?php
    foreach ($products as $product) {
      echo anchor("/card/$product->id",
        '<div class="product-card">
           <img src=' . base_url() . 'images/product/' . $product->photo_url . ' />
           <h2>' . $product->name . '</h2>
           <p>$' . $product->price . '</p>
           <p>' . $product->description . '</p>
           <div class="product-card-actions">'
             . anchor("/delete/$product->id", 'Delete', "onClick='return confirm(\"Do you really want to delete this record?\");'")
             . anchor("/edit/$product->id", 'Edit')
             . anchor("/cart/add/$product->id", 'Add to cart')
           . '</div>
        </div>');
    }
  ?>
</div>

<div id='admin-tasks'>
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
  <?php echo anchor("/customer/delete_all", 'Delete all customer and order information'); ?>
</div>
