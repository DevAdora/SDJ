<?php 
ob_start();
session_start();
require_once 'config/connect.php';

 function blobToImage($blobData, $outputPath){
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
if(isset($_GET['product_id']) & !empty($_GET['product_id'])){
	$id = $_GET['product_id'];
	$prodsql = "SELECT * FROM products WHERE product_id=$id";
	$prodres = mysqli_query($connection, $prodsql);
	$prodr = mysqli_fetch_assoc($prodres);
		$img = $prodr['product_image1'];
		$path = 'images/' . $prodr["product_id"] . ".jpg";
		blobToImage($img, $path);
}else{
	header('location: index.php');
}

$uid = $_SESSION['customerid'];
if(isset($_POST) & !empty($_POST)){
	$review = filter_var($_POST['review'], FILTER_SANITIZE_STRING);
	$revsql = "INSERT INTO reviews (pid, uid, review) VALUES ($id, $uid, '$review')";
	$revres = mysqli_query($connection, $revsql);
	if($revres){
		$smsg = "Review Submitted Successfully";
		echo "<script>window.open('_self')</script>'";
	}else{
		$fmsg = "Failed to Submit Review";
	}
}
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
  <link rel="stylesheet" type="text/css" href="style/single.css" />
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
<div class="container section-m1">
	<div class="row mt-10">	
		<div class="col-md-10 col-md-offset-1">
			<?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
			<?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
					<div class="row">
						<div class="col-md-5">
							<div class="gal-wrap">
								<div id="gal-slider" class="flexslider">
									<ul class="slides">
										<img src="<?php echo $path; ?>" class="card-img-top" alt=""/>
									</ul>
								</div>		 
								<div class="clearfix"></div>
							</div>
							</div>
						<div class="col-md-7 product-single">
							<h2 class="product-single-title no-margin"><?php echo $prodr['product_name']; ?></h2>
							<div class="space10"></div>
							<div class="p-price">$ <?php echo $prodr['product_price']; ?>.00/-</div>
							<p><?php echo $prodr['product_desc']; ?></p>
							<form method="get" action="addtocart.php">
							<div class="product-quantity">
								<span>Quantity:</span> 
									<input type="hidden" name="id" value="<?php echo $prodr['product_id']; ?>">
									<input type="text" name="quant" placeholder="1">
							</div>
							<div class="row">
								<div class="col-sm-4">
								<div class="shop-btn-wrap">
								<input type="submit" class="btn btn-info" value="Add to Cart">
							</div>
								</div>
								<div class="col-sm-6">
								<a href="addtowishlist.php?product_id=<?php echo $prodr['product_id']; ?>" class='btn btn-info'>Add to WishList</a>
								</div>
							</div>
							</form>
							<div class="product-meta">
								<span>Categories: 
								<?php 
								$prodcatsql = "SELECT * FROM category WHERE id={$prodr['category']}"; 
								$prodcatres = mysqli_query($connection, $prodcatsql);
								$prodcatr = mysqli_fetch_assoc($prodcatres);
								?>
								<a href="#" class="text-decoration-none"><?php echo $prodcatr['name']; ?></a></span><br>
							</div>
						</div>
					</div>
					<div class="clearfix space30"></div>
					<div class="tab-style3">
						<!-- Nav Tabs -->
						<div class="tabs">
								<div class="tab" onclick="showContent('description')">Description</div>
								<div class="tab" onclick="showContent('review')">Review</div>
							</div>

							<div class="content" id="description">
							<p><?php echo $prodr['product_desc']; ?></p>
							</div>
							<div class="content" id="review">
							
								<div class="col-md-12">
								<?php
									$revcountsql = "SELECT count(*) AS count FROM reviews r WHERE r.pid=$id";
									$revcountres = mysqli_query($connection, $revcountsql);
									$revcountr = mysqli_fetch_assoc($revcountres);

								 ?>
									<h4 class="uppercase space35"><?php echo $revcountr['count']; ?> Reviews for <?php echo substr($prodr['product_name'], 0, 20); ?></h4>
									<ul class="comment-list">
									<?php 
										$selrevsql = "SELECT u.firstname, u.lastname, r.`timestamp`, r.review FROM reviews r JOIN usersmeta u WHERE r.uid=u.uid AND r.pid=$id";
										$selrevres = mysqli_query($connection, $selrevsql);
										while($selrevr = mysqli_fetch_assoc($selrevres)){
									?>
										<li>
											<a class="pull-left" href="#"><img class="comment-avatar" src="images/blank.png" alt="" height="50" width="50"></a>
											<div class="comment-meta">
												<a href="#" class="text-decoration-none"><?php echo $selrevr['firstname']." ". $selrevr['lastname']; ?></a>
												<span>
												<em><?php echo $selrevr['timestamp']; ?></em>
												</span>
											</div>
										<!--	<div class="rating2">
												<span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
											</div> -->
											<p class="content-review">
												<?php echo $selrevr['review']; ?>
											</p>
										</li>
									<?php } ?>
									</ul>
									<?php 
										$chkrevsql = "SELECT count(*) reviewcount FROM reviews r WHERE r.uid=$uid";
										$chkrevres = mysqli_query($connection, $chkrevsql);
										$chkrevr = mysqli_fetch_assoc($chkrevres);
										if($chkrevr['reviewcount'] >= 1){
											echo "<h4 class='uppercase space20'>You have already Reviewed This Product...</h4>";
										}else{
									?>
									<h4 class="uppercase space20">Add a review</h4>
									<form id="form" class="review-form" method="post">
									<?php
										$usersql = "SELECT u.email, u1.firstname, u1.lastname FROM users u JOIN usersmeta u1 WHERE u.id=u1.uid AND u.id=$uid";
										$userres = mysqli_query($connection, $usersql);
										$userr = mysqli_fetch_assoc($userres);
									 ?>
										<div class="row">
											<div class="col-md-6 space20">
												<input name="name" class="input-md form-control" placeholder="Name *" maxlength="100" required="" type="text" value="<?php echo $userr['firstname'] . " " . $userr['lastname'];?>" disabled>
											</div>
											<div class="col-md-6 space20">
												<input name="email" class="input-md form-control" placeholder="Email *" maxlength="100" required="" type="email" value="<?php echo $userr['email']; ?>" disabled>
											</div>
										</div>
									<!--	<div class="space20">
											<span>Your Ratings</span>
											<div class="clearfix"></div>
											<div class="rating3">
												<span>&#9734;</span><span>&#9734;</span><span>&#9734;</span><span>&#9734;</span><span>&#9734;</span>
											</div>
											<div class="clearfix space20"></div>
										</div> -->
										<div class="space20">
											<textarea name="review" id="text" class="input-md form-control" rows="6" placeholder="Add review.." maxlength="400"></textarea>
										</div>
										<button type="submit" class="btn btn-info">
										Submit Review
										</button>
									</form>
									<?php } ?>
								</div>
							</div>
								<div class="clearfix space30"></div>
							</div>
				
					<div class="space30"></div>
						<h4 class="heading text-center p-5">Related Products</h4>
						<div class="col-md-10 m-auto">
       					 <div class="row">
							<?php
								$relsql = "SELECT * FROM products WHERE product_id != $id ORDER BY rand() LIMIT 3";
								$relres = mysqli_query($connection, $relsql);
								while($relr = mysqli_fetch_assoc($relres)){
									$img = $relr['product_image1'];
									$path = 'images/' . $relr["product_id"] . ".jpg";
									blobToImage($img, $path);
							 ?>
									<div class='col-md-4 mb-4'>
              							<div class='card'>
											<img src="<?php echo $path; ?>" class="card-img-top" alt="">	
										
										<div class='card-body'>											
										<div class="rating">
											<span class="fa fa-star act"></span>
											<span class="fa fa-star act"></span>
											<span class="fa fa-star act"></span>
											<span class="fa fa-star act"></span>
											<span class="fa fa-star act"></span>
											<span>
												<a href="single.php?product_id=<?php echo $relr['product_id']; ?>" class="fa fa-link"></a>
												<a href="#" class="fa fa-shopping-cart"></a>
												</span>				
										</div>
										
										<h5><a class="card-title text-decoration-none" href="single.php?product_id=<?php echo $relr['id']; ?>">
										<?php echo $relr['product_name']; ?></a></h2>
										<p class="card-text">$<?php echo $relr['product_price']; ?>.00/-<span></span></p>
										<a href='single.php?product_id=<?php echo $relr['product_id']; ?>' class='btn btn-info'>View More</a>
                   						 <a href="addtocart.php?product_id=<?php echo $relr['product_id']; ?>" class='btn btn-info'>Add to Cart</a>
									</div>
									</div>
									</div>
							<?php } ?>
								 </div>
								</div>
								</div>
					</div>
							</div>
	
			<script src="main.js"></script>
  </body>
</html>
