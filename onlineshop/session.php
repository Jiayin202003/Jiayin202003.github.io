
<?php
session_start();
//isset = exist
//!isset = does not exist
if (!isset($_SESSION['user'])) {
    //ascess pass tak boleh
    header("Location: index.php?action=declined");
    //+ action, echo not authorise login 
}
?>