<?php
session_start();
require_once 'config/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Products || Straich De Jyal </title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- CSS  -->
  <link rel="stylesheet" type="text/css" href="style/main.css" />
  <link rel="stylesheet" type="text/css" href="style/header.css" />
  <link rel="stylesheet" type="text/css" href="style/product.css" />
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
      <a class=" text-decoration-none" href="index.php">Home</a>
      <a class=" text-decoration-none" href="about.html">About</a>
      <div class="dropdown">
        <a class="active text-decoration-none" href="product.php">Products</a>
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
  <section id="homepage-header">
    <h1>Straich De Jyal</h1>
    <h1>Products</h1>
  </section>
  <section id="banner" class="section-m1">
    <div class="text-center">
    <h1>PRODUCTS</h1>
    <h2>Feel your fashion</h2>
    </div>
  </section>
  <section class="section-p1">
    <div class="row px-1">
      <div class="m-auto">
        <div class="row">
          <?php
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
          global $connection;
          $sql = "SELECT * FROM products";
          if (isset($_GET['product_id']) & !empty($_GET['product_id'])) {
            $id = $_GET['product_id'];
            $sql .= " WHERE category=$id";
          }
          $res = mysqli_query($connection, $sql);
          while ($r = mysqli_fetch_assoc($res)) {
            $img = $r['product_image1'];
            $path = 'images/' . $r["product_id"] . ".jpg";
            blobToImage($img, $path);
            $itemId = $r['product_id'];
          ?>
            <div class='col-md-4 mb-4'>
              <div class='card'>
                <div class="image-container">
                  <a href='single.php?product_id=<?php echo $itemId; ?>'>
                    <img src="<?php echo $path; ?>" class='card-img-top' width="250px" alt="">
                    <div class="view-more-text" onclick="redirectToLink()">View More</div>
                </div>
                <div class='card-body'>
                  <div class="rating">
                    <span class="fa fa-star act"></span>
                    <span class="fa fa-star act"></span>
                    <span class="fa fa-star act"></span>
                    <span class="fa fa-star act"></span>
                    <span class="fa fa-star act"></span>
                  </div>
                  <h5><a class="card-title text-decoration-none" href="single.php?product_id=<?php echo $r['product_id']; ?>"><?php echo $r['product_name']; ?></a></h5>
                  <p class="card-text">$<?php echo $r['product_price']; ?>.00/-<span></span></p>
                  <a href='single.php?product_id=<?php echo $itemId; ?>' class='btn btn-info'>View More</a>
                  <a href="addtocart.php?product_id=<?php echo $r['product_id']; ?>" class='btn btn-info'>Add to Cart</a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    </div>
    </div>
  </section>
  <footer class="section-p1">
    <div class="col">
      <h2 class="logo">Straich De Jyal</h2>
      <h4>Contact</h4>
      <p><strong>Address:</strong> Street 28, Champs Élysées, Paris, France</p>
      <p><strong>Phone:</strong> +20 2933 1029 8954 / +91 2389 0923 1094</p>
      <div class="social-links">
        <h4>Follow us</h4>
        <div class="icons">
          <i class='bx bxl-instagram'></i>
          <i class='bx bxl-facebook-circle'></i>
          <i class='bx bxl-linkedin'></i>
        </div>
      </div>
    </div>
    <div class="col">
      <h4>About</h4>
      <a href="#">About us</a>
      <a href="#">Privacy Policy</a>
      <a href="#">Contact us</a>
    </div>
    <div class="col install">
      <h4>Install app</h4>
      <P>From Google Play Store or App Store</P>
      <div class="row">
        <img src="images/google.png">
        <img src="images/app.png">
      </div>
    </div>
    <div class="copyright">
      <p>2023, Ecommerce - SOUTHLAND COLLEGE</p>
    </div>
  </footer>
  <script src="main.js"></script>
</body>
</html>