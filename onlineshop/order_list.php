<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>OrderList</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="icon" href="img/logo_yellow.png" sizes="32x32" type="image/png">

<body>
    <?php
    include 'nav.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid bg-color justify-content-center">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3 text-warning">
                    <h2>Read Order</h2>
                </div>

                <!-- html form to create product will be here -->
                <!-- PHP insert code will be here -->
                <?php
                // include database connection
                include 'config/database.php';

                // delete message prompt will be here
                // isset() is a PHP function used to verify if a value is there or not
                $action = isset($_GET['action']) ? $_GET['action'] : "";
                // if it was redirected from delete.php
                if ($action == 'deleted') {
                    echo "<div class='alert alert-success'>Record was deleted.</div>";
                }

                // select all data
                $query = "SELECT order_id, customer_id, order_date, total_amount FROM order_summary ORDER BY order_id DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();

                // link to create record form
                echo "<a href='order_create.php' class='btn btn-warning m-b-1em mb-3'>Create New Order</a>";

                //check if more than 0 record found
                if ($num > 0) {

                    // data from database will be here
                    echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                    //creating our table heading
                    echo "<tr>";
                    echo "<th>Order ID</th>";
                    echo "<th>Customer ID</th>";
                    echo "<th>Order Date</th>";
                    echo "<th>Total Order Amount</th>";
                    echo "<th></th>";
                    echo "</tr>";

                    // table body will be here
                    // retrieve our table contents
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // extract row
                        // this will make $row['firstname'] to just $firstname only
                        extract($row);
                        // creating new table row per record
                        echo "<tr>";
                        echo "<td>{$order_id}</td>";
                        echo "<td>{$customer_id}</td>";
                        echo "<td>{$order_date}</td>";
                        echo "<td>{$total_amount}</td>";
                        echo "<td>";
                        // read one record
                        echo "<a href='order_read.php?order_id={$order_id}' class='btn btn-info'>Read</a>";

                        // we will use this links on next part of this post
                        echo "<a href='#' onclick='delete_user({$order_id});'  class='btn btn-danger ms-1'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    // end table
                    echo "</table>";
                }
                // if no records found
                else {
                    echo "<div class='alert alert-danger'>No records found.</div>";
                }
                ?>

            </div> <!-- end .container -->

            <!-- confirm delete record will be here -->
            <script type='text/javascript'>
                // confirm record deletion
                function delete_user(order_id) {
                    var answer = confirm('Are you sure? ');
                    if (answer) {
                        // if user clicked ok,
                        // pass the id to delete.php and execute the delete query
                        window.location = 'order_delete.php?order_id=' + order_id;
                    }
                }
            </script>

</body>

</html>