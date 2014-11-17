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
    <?php if (is_array($cart_items) && !empty($cart_items)): ?>
      <?php foreach ($cart_items as $item): ?>
        <tr>
          <td><?php echo $item["name"] ?></td>
          <td><?php echo $item["quantity"] ?> (<?php echo anchor("cart/update/$item[id]/1", '+1') ?> / <?php echo anchor("cart/update/$item[id]/-1", '-1') ?>)</td>
          <td><?php echo anchor("cart/remove/$item[id]", 'Remove') ?></td>
          <td class="table-price">$<?php echo $item["price"] ?></td>
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
      <td>$<?php echo $cart_total ?></td>
    </tr>
  </tfoot>
</table>

<?php if (is_array($cart_items) && !empty($cart_items)): ?>
  <div id="checkout-actions">
    <?php echo anchor('/cart/clear', 'Clear cart', 'class="checkout-btn"') ?>
    <?php echo anchor('/cart/checkout', 'Checkout', 'class="checkout-btn"') ?>
  </div>
<?php endif; ?>
