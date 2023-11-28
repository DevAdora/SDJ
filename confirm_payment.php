<?php 
include('config/connect.php');
session_start();
if(isset($_GET['id'])){
    $order_id = $_GET['id'];
    $select_data = "Select * from `orders` where id = '$order_id'";
    $result = mysqli_query($connection, $select_data);
    $row_fetch = mysqli_fetch_assoc($result);
    $invoice_number = $row_fetch['invoice_number'];
    $amount_due = $row_fetch['totalprice'];
}

if(isset($_POST['confirm_payment'])){
    $invoice_number = $_POST['invoice_number'];
    $amount = $_POST['amount'];
    $payment_mode = $_POST['payment_mode'];
    $insert_query = "Insert into `customer_payments` (order_id, invoice_number, amount, payment_mode)
    VALUES($order_id, $invoice_number, $amount, '$payment_mode')";
    $result = mysqli_query($connection, $insert_query);
    if($result){
        echo "<h3 class='text-center'>Successfully completed the payment</h3>";
        echo "<script>window.open('my-account.php?my_orders','_self')</script>";
    }
    $update_orders = "update `orders` set orderstatus = 'Received' where id=$order_id";
    $result_orders = mysqli_query($connection, $update_orders);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Payment Page || Straich De Jyal </title>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Confirm Payment</h1>
        <form action="" method="post">
            <div class="form-outline my-4 text-center w-50 m-auto">
                <input type="text" class="form-control w-50 m-auto" name="invoice_number" 
                value="<?php echo $invoice_number ?>">
            </div>
            <div class="form-outline my-4 text-center w-50 m-auto">
            <label>Amount</label>
                <input type="text" class="form-control w-50 m-auto" name="amount"
                value="<?php echo $amount_due ?>">
            </div>       
            <div class="form-outline my-4 text-center w-50 m-auto">
                <select name="payment_mode" class="form-select w-50 m-auto">
                    <option>Select Payment Mode</option>
                    <option>Bank</option>
                    <option>Cash on Delivery</option>
                    <option>Online</option>
                </select>
            </div>
            <div class="form-outline my-4 text-center w-50 m-auto">
                <input type="submit" class="py-2 px-3 border-0" value="Confirm" name="confirm_payment">
            </div>      
        </form>
    </div>
</body>
</html>