<div id="receipt-info">
  <p>Name: <?php echo $customer_name ?></p>
  <p>Ordered at: <?php echo $order->order_date . " " . $order->order_time ?></p>
  <p>Creditcard: XXXXXXXXXXXX<?php echo substr($order->creditcard_number, 12, 4) . " (Expires " . $order->creditcard_month . "/" . $order->creditcard_year . ")" ?></p>
</div>

<table>
  <thead>
    <tr>
      <th>Item</th>
      <th>Quantity</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cart_items as $item): ?>
      <tr>
        <td><?php echo $item["name"] ?></td>
        <td><?php echo $item["quantity"] ?></td>
        <td class="table-price">$<?php echo $item["price"] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2">Total</td>
      <td>$<?php echo $order->total ?></td>
    </tr>
  </tfoot>
</table>
