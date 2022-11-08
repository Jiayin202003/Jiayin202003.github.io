<?php
// used to connect to the database
$host = "localhost";
$db_name = "onlineshop";
$username = "onlineshop";
$password = "Bw)5O(Q[qHW)5X2/";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    //echo "Connected successfully";
}

// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
