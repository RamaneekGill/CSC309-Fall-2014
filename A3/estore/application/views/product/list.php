<div id='cards-list'>
  <h2>
    Catalogue
    <?php
      if ($is_admin) {
        echo anchor('/add', 'Add new card');
      }
    ?>
  </h2>

  <?php foreach ($products as $product): ?>
    <div class="product-card">
      <img src='<?php echo base_url() ?>images/product/<?php echo $product->photo_url?>' />
      <h2><?php echo $product->name ?></h2>
      <p>$<?php echo $product->price ?></p>
      <p class="product-card-description"><?php echo $product->description ?></p>
      <div class="product-card-actions">
        <?php
          if ($is_admin) {
            echo anchor("/delete/$product->id", 'Delete', "onClick='return confirm(\"Do you really want to delete this record?\");'");
            echo anchor("/edit/$product->id", 'Edit');
          }
          if ($logged_in) {
            echo anchor("/cart/add/$product->id", 'Add to cart');
          }
        ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div id='admin-tasks'>
  <?php if ($is_admin): ?>
    <h2>Admin tasks</h2>
    <h3>Finalized orders:</h3>
    <div id="orders">
      <table>
        <thead>
          <tr>
            <th>Customer</th>
            <th>Order date/time</th>
            <th>Total</th>
            <th>Creditcard info</th>
          </tr>
        </thead>
        <tbody>
          <?php if (is_array($orders) && !empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
              <tr>
                <td><?php echo $order->customer_id ?></td>
                <td><?php echo $order->order_date . ' ' . $order->order_time ?></td>
                <td>$<?php echo $order->total ?></td>
                <td><?php echo $order->creditcard_number . ' (' . $order->creditcard_month . '/' . $order->creditcard_year . ')' ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">No finalized orders</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <h3>Delete data:</h3>
    <?php echo anchor("/admin/delete_data", 'Delete all customer and order information', "onClick='return confirm(\"Do you really want to delete all data?\");'"); ?>
  <?php endif; ?>
</div>
