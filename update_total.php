<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $productId = $_POST['productId'];
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];
  $updatedTotal = $quantity * $price;
  echo '$' . $updatedTotal . '.00/-';
  // $update_quantity_sql = "UPDATE products SET quantity = $quantity WHERE product_id = $productId";
  // $update_quantity_res = mysqli_query($connection, $update_quantity_sql);
  
  // if ($update_quantity_res) {
  //   // Calculation for updated total
  //   $updatedTotal = $quantity * $price;
  //   echo '$' . $updatedTotal . '.00/-';
  // } else {
  //   echo "Error updating quantity for product ID: $productId";
  // }
}
?>