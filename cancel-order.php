<?php
ob_start();
session_start();
require_once 'config/connect.php';
if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
	header('location: login.php');
}

$uid = $_SESSION['customerid'];
$cart = $_SESSION['cart'];

if (isset($_POST) & !empty($_POST)) {
	$cancel = filter_var($_POST['cancel'], FILTER_SANITIZE_STRING);
	$id = filter_var($_POST['orderid'], FILTER_SANITIZE_NUMBER_INT);

	$cansql = "INSERT INTO ordertracking (orderid, status, message) VALUES ('$id', 'Cancelled', '$cancel')";
	$canres = mysqli_query($connection, $cansql) or die(mysqli_error($connection));
	if ($canres) {
		$ordupd = "UPDATE orders SET orderstatus='Cancelled' WHERE id=$id";
		if (mysqli_query($connection, $ordupd)) {
			header('location: my-account.php');
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
	<title>Straich De Jyal || Official Home Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- CSS  -->
	<link rel="stylesheet" type="text/css" href="style/main.css" />
	<link rel="stylesheet" type="text/css" href="style/header.css" />
	<link rel="stylesheet" type="text/css" href="style/index.css" />
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

<body>
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
					while ($catr = mysqli_fetch_assoc($catres)) {
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
			} else {
			}
			?>
			<a href="cart.php" class="text-decoration-none">
				<div class="bx bx-cart" id="cart-btn"><i><sup>
							<?php
							if (isset($_SESSION['cart'])) {
								$cart = $_SESSION['cart'];
								echo count($cart);
							} else {
								echo "0";
							} ?>
						</sup></i></div>
			</a>
			<div class="bx bx-menu" id="menu-btn"></div>
			<div class="bx bx-user-circle" id="profile-btn"></div>
			<div class="profile-menu">
				<?php
				if (!isset($_SESSION['customer'])) {
					echo "<h2> <a class='text-decoration-none' href='login.php'>Please Sign in</a></h2>";
				} else {
					echo "<h2> <a class='text-decoration-none' href='my-account.php'>Welcome, ", $_SESSION['customer'];
					"</a></h2>";
					echo "<ul>
                  <li><a href='my-account.php'>Profile</a></li>
                  <li><a href='cart.php'>Cart</a></li>
                  <li><a href='cart.php'>Wishlist</a></li>";
				}
				?>
				<?php
				if (isset($_SESSION['customer'])) {
					echo " <li><a href='logout.php'>Logout</a></li> ";
				} else {
					echo " <ul>
                     <li><a href='login.php'>Login</a></li> ";
				}
				?>
				</ul>
			</div>
		</div>
		<div class="search-form">
			<input type="search" id="search-box" placeholder="search" name="search_data" />
			<label for="search-box" class="fas fa-search"></label>
		</div>
	</header>
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">

			<form method="post">
				<div class="container">
					<div class="row">
						<div class=" col-md-offset-3">
							<div class="billing-details">
								<h3 class="uppercase text-center py-2">Cancel Order</h3>

								<table class="cart-table account-table table table-bordered">
									<thead>
										<tr>
											<th>Order</th>
											<th>Date</th>
											<th>Status</th>
											<th>Payment Mode</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>

										<?php
										if (isset($_GET['id']) & !empty($_GET['id'])) {
											$oid = $_GET['id'];
										} else {
											header('location: my-account.php');
										}
										$ordsql = "SELECT * FROM orders WHERE id='$oid'";
										$ordres = mysqli_query($connection, $ordsql);
										while ($ordr = mysqli_fetch_assoc($ordres)) {
										?>
											<tr>
												<td>
													<?php echo $ordr['id']; ?>
												</td>
												<td>
													<?php echo $ordr['timestamp']; ?>
												</td>
												<td>
													<?php echo $ordr['orderstatus']; ?>
												</td>
												<td>
													<?php echo $ordr['paymentmode']; ?>
												</td>
												<td>
													INR <?php echo $ordr['totalprice']; ?>/-
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>

								<div class="space30"></div>


								<div class="clearfix space20"></div>
								<label>Reason :</label>
								<textarea class="form-control" name="cancel" cols="10"> </textarea>

								<input type="hidden" name="orderid" value="<?php echo $_GET['id']; ?>">
								<div class="space30"></div>
								<input type="submit" class="button btn-lg" value="Cancel Order">
							</div>
						</div>

					</div>

				</div>
			</form>
		</div>
	</section>

</body>

</html>