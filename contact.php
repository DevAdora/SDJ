<?php
require_once 'config/connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Staich De Jyal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="style/main.css" />
  <link rel="stylesheet" type="text/css" href="style/header.css" />
  <link rel="stylesheet" type="text/css" href="style/contact.css" />
  <link rel="stylesheet" type="text/css" href="style/footer.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
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
  <section class="contact" id="contact">
    <div class="container">
      <div class="title">
        <h2>
          CON<br>
          TACT<br>
          US</h2>
        <div class="contact-links">
          <i class='bx bxl-instagram'></i>
          <i class='bx bxl-facebook-circle'></i>
          <i class='bx bxl-linkedin'></i>
        </div>
      </div>
      <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10497.878822400353!2d2.298476655532113!3d48.8683217560965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc518637631%3A0x7c6b92d2c2465999!2zQ2hhbXBzLcOJbHlzw6llcywgUGFyaXMsIEZyYW5jZQ!5e0!3m2!1sen!2sph!4v1699061598404!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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