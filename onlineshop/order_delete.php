<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>OrderDelete</title>
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
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        // delete query
        $query = "DELETE FROM order_summary WHERE order_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $order_id);
        if ($stmt->execute()) {
            $query = "DELETE FROM order_details WHERE order_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $order_id);
            if ($stmt->execute()) {
                // redirect to read records page and tell the user record was deleted
                header('Location: order_list.php?action=deleted');
            } else {
                die('Unable to delete order detaisls record.');
            }
        } else {
            die('Unable to delete order summary record.');
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