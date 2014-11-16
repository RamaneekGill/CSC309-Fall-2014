<h2>
  Shopping Cart
  <?php echo anchor('/', 'Keep shopping') ?>
</h2>

<table>
  <thead>
    <tr>
      <th>Item</th>
      <th>Quantity</th>
      <th>Remove</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
    <?php if (is_array($cart_items)): ?>
      <?php foreach ($cart_items as $item): ?>
        <tr>
          <td><?php echo $item->name ?></td>
          <td><?php echo $item->quantity ?></td>
          <td><?php echo anchor("cart/remove/$item->id") ?></td>
          <td><?php echo $item->price ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="4">No items in cart</td>
      </tr>
    <?php endif; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3">Total</td>
      <td>$0.00</td>
    </tr>
  </tfoot>
</table>

<?php echo anchor('/cart/checkout', 'Checkout', 'id="checkout-btn"') ?>

For unfinalized orders, store shopping cart information on the server using a PHP session.
