<?php
session_start();
require_once 'config/connect.php';
$cart = $_SESSION['cart'];
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
	<section class="section-p1 section-m1">
		<div class="container">
			<div class="row">
				<table class="cart-table table-bordered text-center">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>Product</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>

						<?php
						function isUserLoggedIn()
						{
							return isset($_SESSION['customerid']);
						}
						function blobToImage($blobData, $outputPath)
						{
							$image = imagecreatefromstring($blobData);
							if ($image !== false) {
								$result = imagejpeg($image, $outputPath, 100);
								imagedestroy($image);
								if ($result) {
									return true;
								} else {
									return false;
								}
							} else {
								return false;
							}
						}
						if (isUserLoggedIn()) {
							// Assuming you have a database connection
							global $connection;

							if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
								// Fetch product details for items in the cart in a single query
								$cartIds = array_keys($_SESSION['cart']);
								$cartIds = array_filter($cartIds);

								if (!empty($cartIds)) {
									$cartIdsString = implode(",", $cartIds);
									$cartsql = "SELECT product_id, product_name, product_price, product_image1 FROM products WHERE product_id IN ($cartIdsString)";
									$cartres = mysqli_query($connection, $cartsql);

									// Check for query execution errors
									if (!$cartres) {
										echo "Error in executing the cart query: " . mysqli_error($connection);
									} else {
										$total = 0;

										while ($cartr = mysqli_fetch_assoc($cartres)) {
											$img = $cartr['product_image1'];
											$path = 'images/' . $cartr["product_id"] . ".jpg";
											blobToImage($img, $path);
											$product_name = $cartr['product_name'];
											$product_id = $cartr['product_id'];
											$product_price = $cartr['product_price'];
											$quantity = $_SESSION['cart'][$product_id]['quantity'];

											$itemTotal = $product_price * $quantity;
											$total += $itemTotal;

						?>
											<form id="updateCartForm" method="post" action="update_total.php">
												<tr>
													<td><a class="remove" href="delcart.php?id=<?php echo $product_id; ?>"><i class='bx bx-x'></i></a></td>
													<td><a href="#"><img src="<?php echo $path; ?>" alt="" height="90" width="90"></a></td>
													<td><?php echo $product_name; ?></td>
													<td><span class="amount">$<?php echo $product_price; ?>.00/-</span></td>
													<td>
														<div class="quantity">
															<input type="number" name="quantity" value="<?php echo $quantity; ?>" data-product-id="<?php echo $product_id; ?>" data-product-price="<?php echo $product_price; ?>" class="quantity-input text-center">
														</div>
													</td>
													<td><span id="total-<?php echo $product_id; ?>" class="amount">$<?php echo $itemTotal; ?>.00/-</span></td>
												</tr>
											</form>
										<?php
										}

										// Free the result set
										mysqli_free_result($cartres);
										?>

										<tr>

											<td colspan="6" class="actions">
												<div class="col-md-6">
												</div>
												<div class="col-md-6 p-2">
													<div class="cart-btn">
														<button class='btn btn-info px-3 py-2'><a href='checkout.php' class='text-light
                					  text-decoration-none'>Checkout</button>";
													</div>
												</div>
											</td>
										</tr>
					</tbody>
				</table>
				<div class="cart_totals">
					<div class="push-md-6 no-padding">
						<h4 class="heading">Cart Totals</h4>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th>Cart Subtotal</th>
									<td id="cart-subtotal"><span class="amount">$ <?php echo $total; ?>.00/-</span></td>
								</tr>
								<tr>
									<th>Shipping and Handling</th>
									<td>
										Free Shipping
									</td>
								</tr>
								<tr>
								<tr>
									<th>Order Total</th>
									<td id="order-total"><strong><span class="amount">$ <?php echo $total; ?>.00/-</span></strong></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
<?php
									}
									$_SESSION['cart_total'] = $total;
								}
							} else {
								echo "Cart is empty.";
							}
						} else {
							echo "Cart is empty.";
						}
?>

			</div>
		</div>
		</div>
		</div>
		<script src="main.js"></script>
		<script>
			$(document).ready(function() {
				// Listen for quantity change event
				$('.quantity-input').on('input', function() {
					// Get the updated quantity, product ID, and price
					var quantity = $(this).val();
					var productId = $(this).data('product-id');
					var price = $(this).data('product-price');

					// Update the total dynamically
					updateTotal(productId, quantity, price);

					// Update cart totals dynamically
					updateCartTotals();
				});

				// Function to update total dynamically using AJAX
				function updateTotal(productId, quantity, price) {
					$.ajax({
						url: 'update_total.php',
						method: 'POST',
						data: {
							productId: productId,
							quantity: quantity,
							price: price
						},
						success: function(response) {
							// Assuming the response contains the updated total
							// Update the total on the page
							$('#total-' + productId).html(response);
						}
					});
				}

				// Function to update cart totals dynamically
				function updateCartTotals() {
					// Calculate the updated cart subtotal based on the updated product totals
					var updatedCartSubtotal = 0;
					$('.quantity-input').each(function() {
						var quantity = $(this).val();
						var price = $(this).data('product-price');
						updatedCartSubtotal += quantity * price;
					});

					// Update the cart subtotal dynamically
					$('#cart-subtotal').html('$' + updatedCartSubtotal.toFixed(2) + '/-');

					// For demonstration purposes, assume shipping is free
					var shipping = 0;

					// Calculate the updated order total
					var updatedOrderTotal = updatedCartSubtotal + shipping;

					// Update the order total dynamically
					$('#order-total').html('<strong>$' + updatedOrderTotal.toFixed(2) + '/-</strong>');
				}
			});
		</script>
	</section>