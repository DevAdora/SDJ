<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config/connect.php';
session_start();
if (!isset($_SESSION['customer'])) {
	http_response_code(401); // Unauthorized status code
    echo json_encode(array("error" => "User not logged in"));
    exit();
}

// Check if the user is not logged in
function getCustomerId()
{
	// Check if the user is logged in
	if (isset($_SESSION['customerid'])) {
		return $_SESSION['customerid'];
	} else {
		return null;
	}
}

if (isset($_GET) && !empty($_GET)) {
	// Make sure $connection is defined and points to your database
	global $connection;

	$get_customer_id = getCustomerId();
	$id = $_GET['product_id'];
	$quant = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
	$size = $_GET['size'];

	if(isset($_GET['quantity']) & !empty($_GET['quantity'])) {
		$quant = $_GET['quantity'];
	} else {
		$quant = 1;
	}
	$_SESSION['cart'][$id] = array("quantity" => $quant);
	if ($id !== null  && $quant > 0) {
		$_SESSION['cart'][$id] = array("quantity" => $quant);
	}
	$insert_query = "INSERT INTO `cart_details` (product_id, id, quantity, size) VALUES (?, ?, ?, ?)";
	$stmt = mysqli_prepare($connection, $insert_query);

	if ($stmt) {
		mysqli_stmt_bind_param($stmt, "iiis", $id, $get_customer_id, $quant, $size);
		mysqli_stmt_execute($stmt);

		// Check for errors
		if (mysqli_stmt_error($stmt)) {
			echo "SQL Error: " . mysqli_stmt_error($stmt);
		} else {
			echo "Data successfully inserted into the database.";
		}

		mysqli_stmt_close($stmt);
	} else {
		// Handle the error as needed
		echo "Error in preparing the SQL statement: " . mysqli_error($connection);
	}

	header('location: index.php');

} else {
	header('location: index.php');
}