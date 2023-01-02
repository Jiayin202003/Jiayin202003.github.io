<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>ProductDelete</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="icon" href="img/buzz.png" sizes="32x32" type="image/png">

<body>
    <?php
    include 'nav.php';
    ?>

    <!-- container -->
    <!-- PHP read one record will be here -->
    <?php
    // get passed parameter value, in this case, the record ID

    //include database connection
    include 'config/database.php';

    // read current record's data
    try {
        // get record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        // o.pro : order details table
        // p.pro : products table
        $query = "SELECT o.product_id, p.product_id FROM order_details o INNER JOIN products p ON o.product_id = p.product_id WHERE o.product_id = ? LIMIT 0,1";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $num = $stmt->rowCount();

        //if num > 0 means it found related info in database
        if ($num > 0) {
            header('Location:product_list.php?action=failed');
        } else {
            $query = "DELETE FROM products WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $id);

            if ($stmt->execute()) {
                header('Location:product_list.php?action=deleted');
            } else {
                die('Unable to delete record.');
            }
        }
    }

    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }

    ?>
    <!-- end .container -->


</body>

</html>