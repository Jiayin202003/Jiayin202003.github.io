<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>OrderRead</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>


<body>
    <?php
    include 'nav.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid bg-color justify-content-center">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3 text-warning">
                    <h2>Order Read</h2>
                </div>

                <!-- PHP read one record will be here -->
                <?php
                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

                //include database connection
                include 'config/database.php';

                // read current record's data
                try {

                    // prepare select query : order_summary
                    $query = "SELECT order_id, total_amount FROM order_summary WHERE order_id = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(1, $order_id);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $total_amount = $row['total_amount'];

                    // prepare select query : order_details
                    $query = "SELECT order_details_id, order_id, product_id, quantity, price_each FROM order_details WHERE order_id = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);
                    // this is the first question mark
                    $stmt->bindParam(1, $order_id);
                    // execute our query
                    $stmt->execute();
                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // values to fill up our form
                    $order_details_id = $row['order_details_id'];
                    $product_id = $row['product_id'];
                    $price_each = $row['price_each'];
                    $quantity = $row['quantity'];

                    // prepare select query : products
                    $query = "SELECT product_id,name FROM products WHERE product_id =:id ";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':id', $product_id);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $name = $row['name'];

                    $total_amount_each = (float)$price_each * (int)$quantity;
                }

                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
                ?>


                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price Each</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row"><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($price_each, ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($quantity, ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($total_amount_each, ENT_QUOTES); ?></td>
                        </tr>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Grand Total Amount</b></td>
                            <td><?php echo htmlspecialchars($total_amount, ENT_QUOTES); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end .container -->


</body>

</html>