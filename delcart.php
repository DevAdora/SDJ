<?php
session_start();
if(isset($_GET['id']) & !empty($_GET['id'])){
	$id = $_GET['id'];
	unset($_SESSION['cart'][$id]);
	$connection = mysqli_connect('localhost', 'root', '', 'chechedb');

	if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
    // Get the customer ID from the session
    $customer_id = isset($_SESSION['customerid']) ? $_SESSION['customerid'] : null;

    // Delete the product from the cart_details table
 
		if ($customer_id) {
			$customer_id = (int) $customer_id;
			$id = (int) $id;
			$delete_query = "DELETE FROM cart_details WHERE id = '$customer_id' AND product_id = '$id'";
			echo "Debug: $delete_query"; // Add this line for debugging
			$delete_result = mysqli_query($connection, $delete_query);
		
			if (!$delete_result) {
				echo "Error in executing the delete query: " . mysqli_error($connection);
			} else {
				echo "Product successfully deleted from the database.";
			}
		}
	header('location: cart.php');
}
?>