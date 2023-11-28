<?php 
if(isset($_GET['edit_account'])){
    $user_session_name = $_SESSION['customer'];
    $select_query = "Select * from `users` where email = '$user_session_name'";
    $result_query = mysqli_query($connection, $select_query);
    $row_fetch = mysqli_fetch_assoc($result_query);
    $customer_id = $row_fetch['id'];
    $customer_email = $row_fetch['email'];
    $customer_password = $row_fetch['password'];
    $storedHashedPassword = "hashed_password_from_database";
}
    if(isset($_POST['user_update'])){
        $update_id = $customer_id;
        $customer_email = $_POST['email'];
        $customer_password = $_POST['password'];


        $update_data = "Update `users` set email='$customer_email', password='$customer_password'";
        $result_query_update = mysqli_query($connection, $update_data);
        if($result_query_update){
            echo "<script>alert('Updated Successfully')</script>";
            echo "<script>window.open('logout.php','_self')</script>";
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
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleawpis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link rel="icon" type="image/gif" href="images/straich de jyal.svg">
  </head>
<h3 class="text-center mb-4">Edit Account</h3>
    <form class="form" action="" method="post">
        <div class="flex">
        <label>Email
            <input class="input" type="text" name="firstname" placeholder="Firstname" value="<?php echo $customer_email ?>" 
            required="" autocomplete="off">
        </label>
        <label>Password
        <input class="input" type="text" name="password" placeholder="Password" value="<?php echo $customer_password ?>"
        required="" autocomplete="off">
    </label>
        </div>
    <button class="submit" name="user_update" value="register">Update</button>
    </form>
</body>
</html>