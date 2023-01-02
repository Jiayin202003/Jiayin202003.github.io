<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="icon" href="img/buzz.png" sizes="32x32" type="image/png">

<body>
    <?php
    include 'nav.php';
    include 'config/database.php';

    $query = "SELECT * FROM customer";
    $stmt = $con->prepare($query);
    $stmt->execute();
    // this is how to get number of rows returned
    $total_customer = $stmt->rowCount();

    $query = "SELECT * FROM products";
    $stmt = $con->prepare($query);
    $stmt->execute();
    // this is how to get number of rows returned
    $total_product = $stmt->rowCount();

    $query = "SELECT * FROM order_summary";
    $stmt = $con->prepare($query);
    $stmt->execute();
    // this is how to get number of rows returned
    $total_order = $stmt->rowCount();
    // this is how to get number of rows returned
    ?>

    <!-- dashboard container -->
    <div class="d-flex justify-content-center">
        <div class="col-md-9">
            <div class="top_text mt-5 mb-3 text-warning">
                <h1>Dashboard</h1>
            </div>
            <div class="card mt-4 bg-dark">
                <div class="card-body ">
                    <blockquote class="blockquote">
                        <div class="blockquote text-light m-4">
                            <h1>Welcome to <b class="text-warning">Buzz System</h1>
                        </div>
                        <div class="lead text-secondary m-4 ">
                            <p><em>Online Coffee Shop system to create, edit and check data.</em></p></cite>
                        </div>
                    </blockquote>
                </div>
            </div>

            <div class="row mb-4 mt-4">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Customer</h4>
                            <hr class="bg-warning border-3 border-top border-warning">
                            <h6 class="card-subtitle mb-2 text-muted">Total number of Customer</h6>
                            <p class="card-text text-dark"><?php echo $total_customer ?> user has been resgister</p>
                            <a href="customer_list.php" class="btn btn-warning">Customer List</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Products</h4>
                            <hr class="bg-warning border-3 border-top border-warning">
                            <h6 class="card-subtitle mb-2 text-muted">Total number of Products</h6>
                            <p class="card-text text-dark"><?php echo $total_product ?> product has added</p>
                            <a href="product_list.php" class="btn btn-warning">Products List</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Order</h4>
                            <hr class="bg-warning border-3 border-top border-warning">
                            <h6 class="card-subtitle mb-2 text-muted">Total number of Order</h6>
                            <p class="card-text text-dark"><?php echo $total_order ?> order has purchased</p>
                            <a href="order_list.php" class="btn btn-warning">Order List</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="coffee_img">
                <img src="img/coffee6.jpg" class="img-fluid rounded">
            </div>

            <div class="card mt-4">
                <div class="card-body mt-4 mb-4">
                    <h4 class="card-title">Latest Order ID & Summary</h4>
                    <hr class="bg-warning border-3 border-top border-warning">
                    <p class="card-text">
                        <?php
                        //Lastest
                        $query = "SELECT c.first_name, c.last_name, c.username, o.order_date, o.total_amount 
                                        FROM order_summary o 
                                        INNER JOIN customer c 
                                        ON c.customer_id = o.customer_id 
                                        ORDER BY order_id DESC";

                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        // values to fill up our form
                        $username = $row['username'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $order_date = $row['order_date'];
                        $total_amount = $row['total_amount'];
                        ?>

                    <div class="card-subtitle mb-2 text-muted">
                        <h6><?php echo "<b>Username: </b> $username" ?></h6>
                        <h6><?php echo "<b>Customer Name: </b>$first_name $last_name" ?></h6>
                        <h6><?php echo "<b>Total Amount: </b>RM $total_amount" ?></h6>
                        <h6><?php echo "<b>Transaction Date: </b>$order_date" ?></h6>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body mt-4 mb-2">
                    <h4 class="card-title">Top 5 selling Products</h4>
                    <hr class="bg-warning border-3 border-top border-warning">
                    <p class="card-text">
                    <div class="card-subtitle text-muted">
                        <h6><?php
                            $query = "SELECT o.product_id, SUM(o.quantity) as totalquantity ,p.name as productname FROM order_details o 
                                        INNER JOIN products p ON o.product_id = p.id
                                        GROUP BY o.product_id 
                                        ORDER BY totalquantity DESC LIMIT 5";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();

                            if ($num > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                                    echo $productname . ' : ' . $totalquantity . " pcs <br>";
                                    echo "<br>";
                                }
                            } ?></p>
                        </h6>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body mt-4 mb-4">
                    <h4 class="card-title">Order Summary with highest purchased amount</h4>
                    <hr class="bg-warning border-3 border-top border-warning">
                    <p class="card-text">
                        <?php
                        $query = "SELECT c.first_name, c.last_name, c.username, SUM(o.total_amount) as total_amount
                        FROM order_summary o 
                        INNER JOIN customer c 
                        ON c.customer_id = o.customer_id 
                        ORDER BY total_amount DESC";
                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        // values to fill up our form
                        $username = $row['username'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $total_amount = $row['total_amount'];
                        ?>

                    <div class="card-subtitle mb-2 text-muted">
                        <h6><?php echo "<b>Username: </b >$username" ?></h6>
                        <h6><?php echo "<b>Customer Name: </b> $first_name $last_name" ?></h6>
                        <h6><?php echo "<b>Total Amount: </b> RM $total_amount" ?></h6>
                    </div>
                    </p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body mt-4 mb-4">
                    <h4 class="card-title">3 Products that never purchased</h4>
                    <hr class="bg-warning border-3 border-top border-warning">
                    <p class="card-text">
                    <div class="card-subtitle mb-3 text-muted">
                        <h6><?php
                            $query = "SELECT p.name FROM products p
                        LEFT JOIN order_details o ON o.product_id = p.id
                        WHERE o.product_id iS NULL LIMIT 3";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $num = $stmt->rowCount();

                            if ($num > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                                    echo $name . "</br>" . "</br>";
                                }
                            }
                            ?></h6>
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div> <!-- end .container -->

    <?php
    include 'footer.php';
    ?>

</body>

</html>