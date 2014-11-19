<h1>Thank you!</h1>

<h2>
  Receipt
  <a id="print-btn" href="#">Print</a>
</h2>

<?php include('application/views/cart/receipt_info.php') ?>

<em id="receipt-email-notice">This receipt has also been sent to your email. Please check your junk folder.</em>

<script type="text/javascript">
  document.getElementById('print-btn').onclick = function() {
    window.print();
  }
</script>
