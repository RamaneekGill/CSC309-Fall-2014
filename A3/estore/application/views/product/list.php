<div id='cards-list'>
  <h2>
    Catalogue
    <?php
      if ($isAdmin) {
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
          if ($isAdmin) {
            echo anchor("/delete/$product->id", 'Delete', "onClick='return confirm(\"Do you really want to delete this record?\");'");
            echo anchor("/edit/$product->id", 'Edit');
          }
          if ($isLoggedIn) {
            echo anchor("/cart/add/$product->id", 'Add to cart');
          }
        ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div id='admin-tasks'>
  <?php if ($isAdmin): ?>
    <h2>Admin tasks</h2>
    <h3>Finalized orders:</h3>
    <div class="admin-table">
      <table>
        <thead>
          <tr>
            <th>Customer ID</th>
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
                <td><?php echo $order->creditcard_number . ' (Expires ' . $order->creditcard_month . '/' . $order->creditcard_year . ')' ?></td>
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

    <h3>Registered customers:</h3>
    <div class="admin-table">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php if (is_array($customers) && !empty($customers)): ?>
            <?php foreach ($customers as $customer): ?>
              <tr>
                <td><?php echo $customer->id ?></td>
                <td><?php echo $customer->login ?></td>
                <td><?php echo $customer->last . ', ' . $customer->first ?></td>
                <td><?php echo $customer->email ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">No registered customers</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <h3>Delete data:</h3>
    <?php echo anchor("/user/delete_data", 'Delete all customer and order information', "onClick='return confirm(\"Do you really want to delete all data?\");'"); ?>
  <?php endif; ?>
</div>
