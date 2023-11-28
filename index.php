<?php
session_start();
require_once 'config/connect.php';
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
  <style>
    .card {
      border: 1px solid var(--primary-color);
    }
    footer {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    footer .col {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      margin-bottom: 20px;
    }

    footer .logo {
      margin-bottom: 30px;
      font-size: 2rem;
    }

    footer h4 {
      font-size: 1.5rem;
      padding-bottom: 20px;
    }

    footer p {
      font-size: 1rem;
      margin: 0 0 8px 0;
    }

    footer a {
      text-decoration: none;
      font-size: 16px;
      color: #3a4f50;
      margin-bottom: 16px;
    }

    footer .social-links {
      margin-top: 20px;
    }

    footer .social-links i {
      color: #3a4f50;
      padding-right: 4px;
      cursor: pointer;
      font-size: 20px;
    }

    footer .install .row img {
      border-radius: 6px;
      object-fit: contain;
    }

    footer .install .row {
      padding: 10px 0 0 20px;
    }

    footer .install img {
      margin: 10px 10px 15px 0;
      width: 150px;
      height: 100px;
    }

    footer .follow i:hover,
    footer a:hover {
      color: #9d5248;
    }

    footer .copyright {
      width: 100%;
      text-align: center;
    }
  </style>
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
  <section class="homepage">
    <div class="content">
      <div class="content-text">
        <div class="content-title">
          <h1>Straich De Jyal</h1>
        </div>
        <div class="content-desc">
          <h4>Fashion is all that matters</h4>
          <button>Shop Collection</button>
        </div>
      </div>
    </div>
  </section>
  <!-- <section id="feature" class="section-p1">
  <div class="fe-box">
    <i class='bx bxs-truck'></i>
    <h6>Discounted Shipping</h6>
  </div>
  <div class="fe-box">
    <i class='bx bxs-package'></i>
    <h6>Warranty</h6>
  </div>
  <div class="fe-box">
    <i class='bx bxs-shield-plus'></i>
    <h6>Secure</h6>
  </div>
  <div class="fe-box">
    <i class='bx bxl-go-lang'></i>
    <h6>Fast Shipping</h6>
  </div>
</section> -->
  <section id="banner" class="section-p1">
    <div class="text-center">
      <h1>NEW ARRIVAL</h1>
      <h2>Feel your fashion</h2>
    </div>
  </section>
  <section id="prodetails" class="section-p1">
    <div class="single-pro-image">
      <img src="images/Plain Black Tshirt.png" width="100%" id="MainImg" alt="" />
    </div>
    <div class="single-pro-details">
      <h6>Home / T-Shirt</h6>
      <h4>SDJ's Basic Tee</h4>
      <h2>$78.00</h2>
      <select>
        <option>Select Size</option>
        <option>Small</option>
        <option>Medium</option>
        <option>Large</option>
        <option>Extra Large</option>
      </select>
      <input type="number" value="1" />
      <button class="normal">Add to Cart</button>
      <h4>Product Details</h4>k
      <span>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Autem id
        vel placeat! Ex in perspiciatis sequi reprehenderit. Minus, eius ipsam
        temporibus ducimus adipisci unde possimus provident, sunt officiis
        quod culpa.</span>
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
            $product_image = 'products' . $r['product_id'] . '.jpg';
            $itemId = $r['product_id'];
            $productQuantity = $r['quantity'];
            $product_desc = $r['product_desc'];
            $product_name = $r['product_name'];
            $product_price = $r['product_price'];
            echo "
            <div class='col-md-4 mb-4'>
              <div class='card border-none'>
                <div class='image-container'>
                  <a href='single.php?product_id=$itemId'>
                    <img src=$path class='card-img-top' width='250px' alt=''>";
            echo "Product ID: " . $r['product_id'] . " - Quantity: " . $productQuantity . "<br>";

            if ($productQuantity == 0) {
              echo "<span class='out-of-stock'>Out of Stock</span>";
            }
            echo "
                    <div class='view-more-text' onclick='redirectToLink()'>View More</div>
                </div>
                <div class='card-body'>
                  <div class='rating'>
                    <span class='fa fa-star act'></span>
                    <span class='fa fa-star act'></span>
                    <span class='fa fa-star act'></span>
                    <span class='fa fa-star act'></span>
                    <span class='fa fa-star act'></span>
                  </div>
                  <h5 class='text-center'><a class='card-title text-decoration-none' href='single.php?product_id=$itemId'>$product_name</a></h5>
                  <p class='card-text'>$product_desc </p>
                  <p class='card-text'>$ $product_price .00/-<span></span></p>
                  <a href='single.php?product_id= $itemId;' class='btn btn-info'>View More</a>
                  <button type='button' class='btn btn-info open-modal' data-toggle='modal' data-target='#addToCartModal' data-itemid='$itemId' data-path='$path'>
                    Add to Cart
                  </button>'
                  </div>
                  </div>
              </div>
            <div class='modal fade' id='addToCartModal' tabindex='-1' role='dialog' aria-labelledby='addToCartModalLabel' aria-hidden='true'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h5 class='modal-title' id='addToCartModalLabel'>Choose Size and Quantity</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                    </button>
                  </div>
                  <div class='modal-body'>
                    <div class='modal-body'>
                      <a href='single.php?product_id=$itemId'>
                        <img src='$path' class='card-img-top' width='250px' alt=''>";
            if ($productQuantity == 0) {
              echo "'<span class='out-of-stock'>Out of Stock</span>
                      '";
            }
            echo "
                        <div class='view-more-text'>View More</div>
                      </a>
                    </div>
                    <form id='addToCartForm' action='addtocart' method='get'>
                      <div class='form-group'>
                        <label for='sizeSelect'>Select Size:</label>
                        <select class='form-control' id='sizeSelect' name='size'>
                          <option value='small'>Small</option>
                          <option value='medium'>Medium</option>
                          <option value='large'>Large</option>
                        </select>
                      </div>
                      <div class='form-group'>
                        <label for='quantityInput'>Quantity:</label>
                        <input type='number' class='form-control' id='quantityInput' name='quantity' value='1' min='1'>
                      </div>
                      <p class='text-decoration-none'>Stock : $productQuantity</p>
                      <?PHP echo 'Product ID: ' . $itemId . ' - Quantity: ' . $productQuantity . '<br>';
                      ?>
                    </form>
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                    <button type='button' class='btn btn-info' id='addToCartBtn'>Add to Cart</button>
                  </div>
                </div>
              </div>
            </div>
        
";
          } ?>

        </div>
      </div>
    </div>
  </section>
  <section id="banner" class="section-m1">
    <h4>Feel your Fashion</h4>
    <h2>High Quality that brings taste to your appearance</h2>
    <button class="normal">Explore More</button>
  </section>
  <section id="sdj-banner" class="section-p1">
    <div class="banner-box">
      <h4>Spring Season</h4>
      <h2>Discounted Offers</h2>
      <span>The best apparel store in the country</span>
      <button class="white">Learn More</button>
    </div>
    <div class="banner-box banner-box-2">
      <h4>Spring Season</h4>
      <h2>Discounted Offers</h2>
      <span>The best apparel store in the country</span>
      <button class="white">Learn More</button>
    </div>
  </section>
  <section id="banner3">
    <div class="banner-box">
      <h2>SEASONAL SALE</h2>
      <h3>Spring Season Sale -30% OFF</h3>
    </div>
    <div class="banner-box banner-box-2">
      <h2>SEASONAL SALE</h2>
      <h3>Spring Season Sale -30% OFF</h3>
    </div>
    <div class="banner-box banner-box-3">
      <h2>SEASONAL SALE</h2>
      <h3>Spring Season Sale -30% OFF</h3>
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
  <script>
    $(document).ready(function() {
      $('.open-modal').on('click', function(event) {
        var button = $(event.currentTarget);
        var itemId = button.data('itemid');
        var path = button.data('path');

        // Update modal content
        var modal = $('#addToCartModal');
        modal.find('.modal-body img').attr('src', path);
        modal.find('#addToCartBtn').data('itemid', itemId); // Set data-itemid for the button

        modal.find('#addToCartBtn').off('click').on('click', function() {
          var size = $('#sizeSelect').val();
          var quantity = $('#quantityInput').val();
          var currentItemId = $(this).data('itemid'); // Retrieve current product ID from the button

          $.ajax({
            type: 'GET',
            url: 'addtocart.php',
            data: {
              product_id: currentItemId,
              size: size,
              quantity: quantity
            },
            success: function(response, status, xhr) {
              // Check for successful response
              alert('Item added to the cart');
              window.open('index.php', '_self');
            },
            error: function(xhr, status, error) {
              if (xhr.status === 401) {
                // User is not logged in, prompt to log in
                if (window.confirm('To add this item to your cart, please log in. Do you want to log in now?')) {
                  window.location.href = 'login.php';
                } else {
                  // Optionally handle if the user chooses not to log in
                  // For example, show a message or take other actions
                }
              } else {
                // Handle other errors if needed
                console.error('Error adding item to cart:', error);
              }
            }
          });
        });
      });
    });
  </script>
</body>

</html>