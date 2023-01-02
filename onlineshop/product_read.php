<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>ProductRead</title>
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
                    <h2>Read Product</h2>
                </div>

                <!-- PHP read one record will be here -->
                <?php
                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

                //include database connection
                include 'config/database.php';

                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT id, name, description, price, promotion_price, manufacture_date, expired_date FROM products WHERE id = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);

                    $stmt->bindParam(1, $id);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // values to fill up our form
                    $name = $row['name'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $promotion_price = $row['promotion_price'];
                    $manufacture_date = $row['manufacture_date'];
                    $expired_date = $row['expired_date'];
                }

                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
                ?>


                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Promotion Price</td>
                        <td><?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Manufacture Date</td>
                        <td><?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Expired Date</td>
                        <td><?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href='product_list.php' class='btn btn-danger'>Back to Read Products</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div> <!-- end .container -->


</body>

</html>