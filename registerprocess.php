<?php 
session_start();
require_once 'config/connect.php'; 
if(isset($_POST) & !empty($_POST)){

	//$email = mysqli_real_escape_string($connection, $_POST['email']);
	$customer_fname = filter_var($_POST['firstname'], FILTER_SANITIZE_EMAIL);
	$customer_lname = filter_var($_POST['lastname'], FILTER_SANITIZE_EMAIL);
	$customer_address = filter_var($_POST['address'], FILTER_SANITIZE_EMAIL);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	//$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	echo $sql = "INSERT INTO users (`customer_fname`, `customer_lname`, `customer_address`, email, password)
	 VALUES ('$customer_fname','$customer_lname','$customer_address','$email', '$password')";
	$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
	if($result){
		$_SESSION['customer'] = $email;
		$_SESSION['customer_fname'] = $customer_fname;
		$_SESSION['customerid'] = mysqli_insert_id($connection);
		header("location: login.php");
	}else{
		//$fmsg = "Invalid Login Credentials";
		header("location: login.php?message=2");
	}
}

?>