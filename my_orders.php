<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Straich De Jyal || Official Home Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="main.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleawpis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
  <link rel="icon" type="image/gif" href="images/straich de jyal.svg">
</head>

<body>
  <h3 class="text-center">ORDERS</h3>
  <table class="table table-bordered mt-5 text-center">
    <thead>
      <tr>
        <th>Order</th>
        <th>Date</th>
        <th>Status</th>
        <th>Payment Mode</th>
        <th>Invoice Number</th>
        <th>Products</th>
        <th>Total</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $ordsql = "SELECT * FROM orders WHERE uid='$uid'";
      $ordres = mysqli_query($connection, $ordsql);
      $number = 1;
      while ($ordr = mysqli_fetch_assoc($ordres)) {
        $order_id = $ordr['id'];
        $date = $ordr['timestamp'];
        $status = $ordr['orderstatus'];
        $invoice_number = $ordr['invoice_number'];
        $total_products = $ordr['total_products'];
        $payment = $ordr['paymentmode'];
        $price = $ordr['totalprice'];
        echo "
        <tr>
          <td>$number</td>
          <td>$date</td>
          <td>$status</td>
          <td>$payment</td>
          <td>$invoice_number</td>
          <td>$total_products</td>
          <td>$price</td>
          <td>";

        $number++;

        // Display actions based on order status
        if ($status != 'Received' && $status != 'Cancelled') {
          echo "<a href='confirm_payment.php?id=$order_id'>Receive</a> | ";
        }

        echo "<a href='view-order.php?id=$order_id'>View</a>";

        if ($status != 'Received' && $status != 'Cancelled') {
          echo " | <a href='cancel-order.php?id=$order_id'>Cancel</a>";
        }

        echo "</td></tr>";
      }
      ?>
    </tbody>
  </table>
</body>

</html>