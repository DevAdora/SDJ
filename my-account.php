<?php
ob_start();
session_start();
require_once 'config/connect.php';
if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
  header('location: login.php');
}
$uid = $_SESSION['customerid'];
if (isset($_SESSION['cart'])) {
  $cart = $_SESSION['cart'];
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
  <link rel="stylesheet" type="text/css" href="style/profile.css" />
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
  <style>
    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.8rem 7%;
      top: 0;
      left: 0;
      right: 0;
      background-color: white;
      position: fixed;
      border-bottom: 1px solid var(--primary-color);
      z-index: 10;
    }
  </style>
  <header class="header">
    <div class="logo" href="#">
      <img src="images/straich de jyal.svg">
    </div>
    <nav class="nav-bar">
      <a class=" text-decoration-none" href="index.php">Home</a>
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
      <a href="cart.php">
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
      <!-- <div class="bx bx-user-circle" id="profile-btn"></div> -->
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
  <div class="sidebar">
    <ul class="sidebar-menu">
      <div class="user-wrapper">
        <?php
        if (!isset($_SESSION['customer'])) {
          echo "<a class='text-decoration-none' href=''>Please Sign in</a>";
        } else {
          echo "<a class='text-decoration-none ' href='my-account.php'><h2><i class='bx bx-user-circle'></i>", $_SESSION['customer'];
          "</h2></a>";
        }
        ?>
      </div>
      <li><a href="my-account.php?my_orders"><i class='bx bx-package'></i></i><span class="">Pending Orders</span></a></li>
      <li><a href="my-account.php?view-order"><i class='bx bx-food-menu'></i><span class="">Purchase History</span></a></li>
      <li><a href="my-account.php?edit_account"><i class='bx bx-cog'></i><span class="">Edit Account</span></a></li>
      <li><a href="my-account.php?delete_account"><i class='bx bxs-user-x'></i><span class="">Delete Account</span></a></li>
      <li><a href="logout.php"><i class='bx bx-log-out'></i><span class="">Logout</span></a></li>
    </ul>
  </div>
  <div class="main-content">
    <div class="">
      <?php
      if (isset($_GET['edit_account'])) {
        include('edit_account.php');
      }
      if (isset($_GET['my_orders'])) {
        include('my_orders.php');
      }
      if (isset($_GET['view-order'])) {
        include('order_history.php');
      }
      if (isset($_GET['delete_account'])) {
        include('delete_account.php');
      }
      ?>
    </div>
  </div>
  <script src="main.js"></script>
</body>

</html>