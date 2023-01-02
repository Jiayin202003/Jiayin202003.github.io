<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>ProductList</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="icon" href="img/buzz.png" sizes="32x32" type="image/png">

<body>
    <?php
    include 'nav.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid bg-color justify-content-center">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3 text-warning">
                    <h2>Product List</h2>
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
                    echo "<div class='alert alert-success'>Product Record was Deleted.</div>";
                }
                if ($action == 'failed') {
                    echo "<div class='alert alert-danger'>Unable to Delete due Someone has ordered product.</div>";
                }
                if ($action == 'success') {
                    echo "<div class='alert alert-success'>Product create sucessful.</div>";
                }


                // select all data
                $query = "SELECT id, name, description, price, promotion_price FROM products ORDER BY id DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();
                echo "<a href='product_create.php' class='btn btn-warning m-b-1em mb-3'>Create New Product</a>";
                if ($num > 0) {

                    echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                    echo "<tr>";
                    echo "<th>Product ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Description</th>";
                    echo "<th>Price (RM)</th>";
                    echo "<th>Promotion Price (RM)</th>";
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
                        echo "<td>{$id}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td class= \"col-3\">{$description}</td>";
                        echo "<td class= \"col-1 text-end\" >" . ($price) . "</td>";
                        echo "<td class= \"col-2 text-end\" >" . ($promotion_price) . "</td>";
                        echo "<td>";

                        //btn link to other pages
                        echo "<a href='product_read.php?id={$id}' class='btn btn-info'>Read</a>";
                        echo "<a href='product_update.php?id={$id}' class='btn btn-primary ms-1'>Edit</a>";
                        echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger ms-1'>Delete</a>";
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

            </div>
        </div>
    </div> <!-- end .container -->

    <?php
    include 'footer.php';
    ?>

    <!-- confirm delete record will be here -->
    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(id) {
            var answer = confirm('Are you sure? ');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'product_delete.php?id=' + id;
            }
        }
    </script>

</body>

</html>