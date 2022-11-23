
<?php
session_start();
if (!isset($_SESSION['user'])) {
    //login sucessful
    header("Location: http://localhost/webdev/onlineshop/login.php");
}
?>