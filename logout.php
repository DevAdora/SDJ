<?php
session_start();
unset($_SESSION['cart']);
unset($_SESSION['customer']);
session_unset();
echo "<script>alert('Logged out successfully'); setTimeout(function(){ window.location.href='index.php'; }, 1000);</script>";

?>