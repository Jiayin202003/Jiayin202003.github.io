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
                    <h2>Order Read</h2>
                </div>

                <!-- PHP read one record will be here -->
                <?php
                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

                //include database connection
                include 'config/database.php';

                // select id, quantity, price each from order_detail
                $query = "SELECT product_id, quantity, price_each, id, name, price, promotion_price, total_amount, c.customer_id, c.first_name, c.last_name, s.order_date
                FROM order_details o 
                INNER JOIN products p
                ON o.product_id = p.id
                INNER JOIN order_summary s
                ON o.order_id = s.order_id
                INNER JOIN customer c
                ON s.customer_id = c.customer_id
                WHERE o.order_id = ?";

                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $order_id);
                $stmt->execute();
                $num = $stmt->rowCount();

                ?>

                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <!-- TABLE form -->
                <table class="table table-bordered mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price Each (RM)</th>
                            <th scope="col">Promotion Price (RM)</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Amount (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($num > 0) {

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row); ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
                                    <td><?php echo "<div class = \"text-end\">" . htmlspecialchars($price, ENT_QUOTES); ?></td>
                                    <td>
                                        <?php if (htmlspecialchars($promotion_price, ENT_QUOTES) == NULL) {
                                            echo "<div class = \"text-end\">-";
                                        } else {
                                            echo "<div class = \"text-end\">$promotion_price";
                                        }; ?>
                                    </td>
                                    <td><?php echo "<div class = \"text-end\">" . htmlspecialchars($quantity, ENT_QUOTES); ?></td>
                                    <td><?php echo "<div class = \"text-end\">" . htmlspecialchars($price_each, ENT_QUOTES); ?></td>
                                </tr>
                        <?php }
                            echo "<b>Order ID :</b> $order_id<br>";
                            echo "<b>Customer Name :</b> $first_name $last_name<br>";
                            echo "<b>Order Date :</b> $order_date";
                        } ?>

                        <tr>
                            <th colspan="4">Grand Total (RM)</th>
                            <td><?php echo "<div class = \"text-end\">" . htmlspecialchars($total_amount, ENT_QUOTES); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end .container -->


</body>

</html>