<?php 
	ob_start();
	session_start();
	require_once 'config/connect.php';
	if(!isset($_SESSION['customer']) & empty($_SESSION['customer'])){
		header('location: login.php');
	}
$uid = $_SESSION['customerid'];
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
<body>	
	<section id="content" class="section-m1">
		<div class="content-blog content-account">
			<div class="container">
				<div class="row">
					<div class="page_header text-center">
						<h2>My Account</h2>
					</div>
					<div class="col-md-12">

			<h3>Recent Orders</h3>
			<br>
            <table class="table table-bordered mt-5 text-center">
				<thead>
					<tr>
						<th>Product Name</th>
						<th>Quantity</th>
						<th>Price</th>
						<th></th>
						<th>Total Price</th>
					</tr>
				</thead>
				<tbody>
				<?php
					if(isset($_GET['id']) & !empty($_GET['id'])){
						$oid = $_GET['id'];
					}else{
						header('location: my-account.php');
					}
					$ordsql = "SELECT * FROM orders WHERE uid='$uid' AND id='$oid'";
					$ordres = mysqli_query($connection, $ordsql);
					$ordr = mysqli_fetch_assoc($ordres);

					$orditmsql = "SELECT * FROM orderitems o JOIN products p WHERE o.orderid=".$oid." AND o.pid=p.product_id";
					$orditmres = mysqli_query($connection, $orditmsql);
					while($orditmr = mysqli_fetch_assoc($orditmres)){
				?>
					<tr>
						<td>
							<a class="text-decoration-none" href="single.php?id=<?php echo $orditmr['product_id']; ?>"><?php echo substr($orditmr['product_name'], 0, 25); ?></a>
						</td>
						<td>
							<?php echo $orditmr['quantity']; ?>
						</td>
						<td>
							INR <?php echo $orditmr['product_price']; ?>/-
						</td>
						<td>
							
						</td>
						<td>
							INR <?php echo $orditmr['product_price']*$orditmr['quantity']; ?>/-
						</td>
					</tr>
				<?php } ?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>
							Order Total
						</td>
						<td>
							<?php echo $ordr['totalprice']; ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>
							Order Status
						</td>
						<td>
							<?php echo $ordr['orderstatus']; ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>
							Order Placed On
						</td>
						<td>
							<?php echo $ordr['timestamp']; ?>
						</td>
					</tr>
				</tbody>
			</table>		

			<br>
			<br>
			<br>

			<div class="ma-address">
						<h3>My Addresses</h3>
						<p>The following addresses will be used on the checkout page by default.</p>

			<div class="row">
				<div class="col-md-6">
								<h4>My Address <a href="edit-address.php">Edit</a></h4>
					<?php
						$csql = "SELECT u1.firstname, u1.lastname, u1.address1, u1.address2, u1.city, u1.state, u1.country, u1.company, u.email, u1.mobile, u1.zip FROM users u JOIN usersmeta u1 WHERE u.id=u1.uid AND u.id=$uid";
						$cres = mysqli_query($connection, $csql);
						if(mysqli_num_rows($cres) == 1){
							$cr = mysqli_fetch_assoc($cres);
							echo "<p>".$cr['firstname'] ." ". $cr['lastname'] ."</p>";
							echo "<p>".$cr['address1'] ."</p>";
							echo "<p>".$cr['address2'] ."</p>";
							echo "<p>".$cr['city'] ."</p>";
							echo "<p>".$cr['state'] ."</p>";
							echo "<p>".$cr['country'] ."</p>";
							echo "<p>".$cr['company'] ."</p>";
							echo "<p>".$cr['zip'] ."</p>";
							echo "<p>".$cr['mobile'] ."</p>";
							echo "<p>".$cr['email'] ."</p>";
						}
					?>
				</div>

				<div class="col-md-6">

				</div>
			</div>



			</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	
    </body>
</html>

