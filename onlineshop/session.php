
<?php
session_start();
//isset = exist
//!isset = does not exist
if (!isset($_SESSION['user'])) {
    //login unsucessful
    header("Location: http://localhost/webdev/onlineshop/login.php");
}
?>