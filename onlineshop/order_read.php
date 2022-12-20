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

                // select id, quantity, price each from order_detail
                $query = "SELECT quantity, price_each, name, price, promotion_price, total_amount FROM order_details o INNER JOIN products p ON o.product_id = p.id INNER JOIN order_summary s ON o.order_id = s.order_id WHERE o.order_id = ?";

                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $order_id);
                $stmt->execute();
                $num = $stmt->rowCount();

                ?>

                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price Each (RM)</th>
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
                                    <td><?php if ($promotion_price == 0) {
                                            echo number_format((float)htmlspecialchars($price, ENT_QUOTES), 2, '.', '');
                                        } else {
                                            echo number_format((float)htmlspecialchars($promotion_price, ENT_QUOTES), 2, '.', '');
                                        } ?></td>
                                    <td><?php echo htmlspecialchars($quantity, ENT_QUOTES); ?></td>
                                    <td><?php echo number_format((float)htmlspecialchars($price_each, ENT_QUOTES), 2, '.', ''); ?></td>
                                </tr>
                        <?php }
                        } ?>
                        <tr>
                            <th colspan="3">Grand Total (RM)</th>
                            <td><?php echo number_format((float)htmlspecialchars($total_amount, ENT_QUOTES), 2, '.', ''); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end .container -->


</body>

</html>