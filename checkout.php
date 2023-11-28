<?php
ob_start();
session_start();
require_once 'config/connect.php';
if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
	header('location: login.php');
}
$uid = $_SESSION['customerid'];
$cart = $_SESSION['cart'];
if (isset($_SESSION['cart_total'])) {
    $total = $_SESSION['cart_total'];
} else {
	$total = 0;
}
if (isset($_POST) & !empty($_POST)) {
	if ($_POST['agree'] == true) {
		$fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
		$lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
		$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
		$address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
		$address2 = filter_var($_POST['address2'], FILTER_SANITIZE_STRING);
		$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
		$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
		$phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
		$payment = filter_var($_POST['payment'], FILTER_SANITIZE_STRING);
		$zip = filter_var($_POST['zipcode'], FILTER_SANITIZE_NUMBER_INT);

		$sql = "SELECT * FROM usersmeta WHERE uid=$uid";
		$res = mysqli_query($connection, $sql);
		$r = mysqli_fetch_assoc($res);
		$count = mysqli_num_rows($res);
		if ($count == 1) {
			//update data in usersmeta table
			$usql = "UPDATE usersmeta SET firstname='$fname', lastname='$lname', address1='$address1', address2='$address2', city='$city', state='$state',  zip='$zip', company='$company', mobile='$phone' WHERE uid=$uid";
			$ures = mysqli_query($connection, $usql) or die(mysqli_error($connection));
			if ($ures) {
				foreach ($cart as $key => $value) {
					//echo $key . " : " . $value['quantity'] ."<br>";
					$ordsql = "SELECT * FROM products WHERE product_id=$key";
					$ordres = mysqli_query($connection, $ordsql);
					$ordr = mysqli_fetch_assoc($ordres);

				}
				$invoice_number = mt_rand();
				echo $iosql = "INSERT INTO orders (uid, totalprice, invoice_number, total_products, orderstatus, paymentmode) 
				VALUES ('$uid', '$total','$invoice_number','$count', 'Order Placed', '$payment')";
				$iores = mysqli_query($connection, $iosql) or die(mysqli_error($connection));
				if ($iores) {
					//echo "Order inserted, insert order items <br>";
					$orderid = mysqli_insert_id($connection);
					foreach ($cart as $key => $value) {
						//echo $key . " : " . $value['quantity'] ."<br>";
						$ordsql = "SELECT * FROM products WHERE product_id=$key";
						$ordres = mysqli_query($connection, $ordsql);
						$ordr = mysqli_fetch_assoc($ordres);

						$pid = $ordr['product_id'];
						$productprice = $ordr['product_price'];
						$quantity = $value['quantity'];


						$orditmsql = "INSERT INTO orderitems (pid, orderid, productprice, pquantity) VALUES ('$pid', '$orderid', '$productprice', '$quantity')";
						$orditmres = mysqli_query($connection, $orditmsql) or die(mysqli_error($connection));
						//if($orditmres){
						//echo "Order Item inserted redirect to my account page <br>";
						//}
					}
				}
				foreach ($cart as $key => $value) {
					$ordsql = "SELECT * FROM products WHERE product_id=$key";
					$ordres = mysqli_query($connection, $ordsql);
					$ordr = mysqli_fetch_assoc($ordres);
				
					$pid = $ordr['product_id'];
					$productprice = $ordr['product_price'];
					$quantity = $value['quantity'];
					$deduct_stock_sql = "UPDATE products SET quantity = quantity - $quantity WHERE product_id = $pid";
					$deduct_stock_res = mysqli_query($connection, $deduct_stock_sql);
					if (!$deduct_stock_res) {
						echo "Error deducting stock for product ID: $pid";
					}
				}
				$uid = (int) $uid;
				$empty_cart = "DELETE FROM `cart_details` WHERE id = '$uid'";
				$result_delete = mysqli_query($connection, $empty_cart);

				if ($result_delete) {
					echo "<script>alert('Cart details deleted successfully.')</script>";
				} else {
					echo "Error deleting cart details: " . mysqli_error($connection);
				}
				unset($_SESSION['cart']);
				header("location: my-account.php");
			}
		} else {
			//insert data in usersmeta table
			$isql = "INSERT INTO usersmeta (firstname, lastname, address1, address2, city, state, zip, company, mobile, uid) VALUES ('$fname', '$lname', '$address1', '$address2', '$city', '$state', '$zip', '$company', '$phone', '$uid')";
			$ires = mysqli_query($connection, $isql) or die(mysqli_error($connection));
			if ($ires) {

				$total = 0;
				foreach ($cart as $key => $value) {
					//echo $key . " : " . $value['quantity'] ."<br>";
					$ordsql = "SELECT * FROM products WHERE product_id=$key";
					$ordres = mysqli_query($connection, $ordsql);
					$ordr = mysqli_fetch_assoc($ordres);

				}

				echo $iosql = "INSERT INTO orders (uid, totalprice, orderstatus, paymentmode) VALUES ('$uid', '$total', 'Order Placed', '$payment')";
				$iores = mysqli_query($connection, $iosql) or die(mysqli_error($connection));
				if ($iores) {
					//echo "Order inserted, insert order items <br>";
					$orderid = mysqli_insert_id($connection);
					foreach ($cart as $key => $value) {
						//echo $key . " : " . $value['quantity'] ."<br>";
						$ordsql = "SELECT * FROM products WHERE id=$key";
						$ordres = mysqli_query($connection, $ordsql);
						$ordr = mysqli_fetch_assoc($ordres);

						$pid = $ordr['id'];
						$productprice = $ordr['price'];
						$quantity = $value['quantity'];


						$orditmsql = "INSERT INTO orderitems (pid, orderid, productprice, pquantity) VALUES ('$pid', '$orderid', '$productprice', '$quantity')";
						$orditmres = mysqli_query($connection, $orditmsql) or die(mysqli_error($connection));
						//if($orditmres){
						//echo "Order Item inserted redirect to my account page <br>";
						//}
					}
				}
				$uid = (int) $uid;
				$empty_cart = "DELETE FROM `cart_details` WHERE id = '$uid'";
				$result_delete = mysqli_query($connection, $empty_cart);

				if ($result_delete) {
					echo "<script>alert('Cart details deleted successfully.')</script>";
				} else {
					echo "Error deleting cart details: " . mysqli_error($connection);
				}
				unset($_SESSION['cart']);
				header("location: my-account.php");
			}
		}
	}
}

$sql = "SELECT * FROM usersmeta WHERE uid=$uid";
$res = mysqli_query($connection, $sql);
$r = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Checkout || Straich De Jyal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- CSS  -->
  <link rel="stylesheet" type="text/css" href="style/main.css" />
  <link rel="stylesheet" type="text/css" href="style/header.css" />
  <link rel="stylesheet" type="text/css" href="style/checkout.css" />
  <link rel="stylesheet" type="text/css" href="style/footer.css" />
  <!-- ICONS -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleawpis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="icon" type="image/gif" href="images/straich de jyal.svg">
</head>
  <header class="header">
      <div class="logo" href="#">
       <img src="images/straich de jyal.svg">
      </div>
      <nav class="nav-bar">
        <a class=" active text-decoration-none" href="index.php">Home</a>
        <a class=" text-decoration-none" href="about.html">About</a>
        <div class="dropdown">
        <a class="text-decoration-none" href="product.php">Products</a>
        <div class="dropdown-content">
        <?php
							$catsql = "SELECT * FROM category";
							$catres = mysqli_query($connection, $catsql);
							while($catr = mysqli_fetch_assoc($catres)){
						 ?>
							<a class="text-decoration-none" href="index.php?id=<?php echo $catr['id']; ?>"><?php echo $catr['name']; ?></a>
            <?php } ?>
        </div>
    </div>
        <a class=" text-decoration-none" href="contact.php">Contact</a>
      </nav>
      <div class="side-bar">
        <div class="bx bx-search-alt-2" id="search-btn"></div>
        
        <?php 
        if (isset($_SESSION['customerid'])) {
          // Access 'customerid' here
          $customer_id = $_SESSION['customerid'];
          $cart_query = "SELECT product_id, quantity FROM cart_details WHERE id = '$customer_id'";
          $cart_result = mysqli_query($connection, $cart_query);
          if ($cart_result) {
              $cart = array();
              while ($row = mysqli_fetch_assoc($cart_result)) {
                  $cart[$row['product_id']] = array('quantity' => $row['quantity']);
              }
              $_SESSION['cart'] = $cart;
          } else {
              echo "Error in executing the cart query: " . mysqli_error($connection);
          }
      }
          else {
            // 'customerid' index does not exist in the session
        }
                  ?>
        <a href="cart.php"><div class="bx bx-cart" id="cart-btn"><i><sup>
        <?php 
				 if(isset($_SESSION['cart'])){
					  $cart = $_SESSION['cart']; 
								echo count($cart); 
         } else {
          echo "0";
         }?>
                </sup></i></div></a>
        <div class="bx bx-menu" id="menu-btn"></div>    
        <div class="bx bx-user-circle" id="profile-btn"></div>
        <div class="profile-menu">  
            <?php 
                   if(!isset($_SESSION['customer'])){
                    echo "<h2> <a class='text-decoration-none' href='login.php'>Please Sign in</a></h2>";
                   }
                else {
                  echo "<h2> <a class='text-decoration-none' href='my-account.php'>Welcome, ", $_SESSION['customer'];"</a></h2>";
                  echo "<ul>
                  <li><a href='my-account.php'>Profile</a></li>
                  <li><a href='cart.php'>Cart</a></li>
                  <li><a href='cart.php'>Wishlist</a></li>";
                }   
                ?>  
              <?php
              if(isset($_SESSION['customer'])){
                     echo " <li><a href='logout.php'>Logout</a></li> ";
              }
              else {        
                    echo " <ul>
                     <li><a href='login.php'>Login</a></li> ";
              }
              ?>
          </ul>
        </div>
      </div> 
        <div class="search-form" >
        <input type="search" id="search-box" placeholder="search"  name="search_data" />
        <label for="search-box" class="fas fa-search"></label>
      </div>
</header>
<section id="content" class="section-m1">
	<div class="content-blog">			 
		<form method="post">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="billing-details mt-5">
						<h3 class="uppercase text-center">Billing Details</h3>
							<div class="row">
								<div class="col-md-6">
									<label>First Name </label>
									<input name="fname" class="form-control" placeholder="" value="<?php if(!empty($r['firstname'])){ echo $r['firstname']; } elseif(isset($fname)){ echo $fname; } ?>" type="text">
								</div>
								<div class="col-md-6">
									<label>Last Name </label>
									<input name="lname" class="form-control" placeholder="" value="<?php if(!empty($r['lastname'])){ echo $r['lastname']; }elseif(isset($lname)){ echo $lname; } ?>" type="text">
								</div>
							</div>
							<div class="clearfix space20"></div>
							<label>Company Name</label>
							<input name="company" class="form-control" placeholder="" value="<?php if(!empty($r['company'])){ echo $r['company']; }elseif(isset($company)){ echo $company; } ?>" type="text">
							<div class="clearfix space20"></div>
							<label>Address </label>
							<input name="address1" class="form-control" placeholder="Street address" value="<?php if(!empty($r['address1'])){ echo $r['address1']; } elseif(isset($address1)){ echo $address1; } ?>" type="text"><br>
							<div class="clearfix space20"></div>
							<input name="address2" class="form-control" placeholder="Apartment, suite, unit etc. (optional)" value="<?php if(!empty($r['address2'])){ echo $r['address2']; }elseif(isset($address2)){ echo $address2; } ?>" type="text">
							<div class="clearfix space20"></div>
							<div class="row">
								<div class="col-md-4">
									<label>City </label>
									<input name="city" class="form-control" placeholder="City" value="<?php if(!empty($r['city'])){ echo $r['city']; }elseif(isset($city)){ echo $city; } ?>" type="text">
								</div>
								<div class="col-md-4">
									<label>State</label>
									<input name="state" class="form-control" value="<?php if(!empty($r['state'])){ echo $r['state']; }elseif(isset($state)){ echo $state; } ?>" placeholder="State" type="text">
								</div>
								<div class="col-md-4">
									<label>Postcode </label>
									<input name="zipcode" class="form-control" placeholder="Postcode / Zip" value="<?php if(!empty($r['zip'])){ echo $r['zip']; }elseif(isset($zip)){ echo $zip; } ?>" type="text">
								</div>
							</div>
							<div class="clearfix space20"></div>
							<label>Phone </label>
							<input name="phone" class="form-control" id="billing_phone" placeholder="" value="<?php if(!empty($r['mobile'])){ echo $r['mobile']; }elseif(isset($phone)){ echo $phone; } ?>" type="text">
						
					</div>
				</div>
				
			</div>
			
			<div class="space30"></div>
			<h4 class="heading">Your order</h4>
			
			<table class="table table-bordered extra-padding">
				<tbody>
					<tr>
						<th>Cart Subtotal</th>
						<td><span class="amount"><?php echo $total; ?></span></td>
						
					</tr>
					<tr>
						<th>Shipping and Handling</th>
						<td>
							Free Shipping				
						</td>
					</tr>
					<tr>
						<th>Order Total</th>
						<td><strong><span class="amount">£190.00</span></strong> </td>
					</tr>
				</tbody>
			</table>
			
			<div class="clearfix space30"></div>
			<h4 class="heading text-center p-2">Payment Method</h4>
			<div class="clearfix space20"></div>
			
			<div class="payment-method">
				<div class="row">
						<div class="alig-self-center">
							<input name="payment" id="radio1" class="css-checkbox" type="radio" value="cod"><span class="m-2">Cash On Delivery</span>
							<div class="space20"></div>
							<p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won't be shipped until the funds have cleared in our account.</p>
						</div>
				</div>
				<div class="space30"></div>				
					<input name="agree" id="checkboxG2" class="css-checkbox" type="checkbox" value="true"><span>I've read and accept the <a href="#">terms &amp; conditions</a></span>
				<div class="space30"></div>
				<input type="submit" class='btn btn-info' value="Pay Now">
			</div>
		</div>		
		</form>		
		</div>
	</section>
<script src="main.js"></script>
	</body>
	</html>
