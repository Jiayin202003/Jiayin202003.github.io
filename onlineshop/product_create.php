<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>ProductCreate</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="icon" href="img/buzz.png" sizes="32x32" type="image/png">

<body>
    <?php
    include 'nav.php';
    date_default_timezone_set("Asia/Kuala_Lumpur");
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid bg-color justify-content-center">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3 text-warning">
                    <h2>Create Product</h2>
                </div>

                <!-- html form to create product will be here -->
                <!-- PHP insert code will be here -->
                <?php
                // post, to send out, check is it using same way (post/get)
                if ($_POST) {
                    // include database connection, locate file and connect
                    include 'config/database.php';
                    try {

                        // alert signal
                        $flag = false;

                        // posted values, label to same var
                        $name = htmlspecialchars(strip_tags($_POST['name']));
                        $description = htmlspecialchars(strip_tags($_POST['description']));
                        $price = htmlspecialchars(strip_tags($_POST['price']));
                        $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                        if (isset($_POST['manufacture_date'])) $manufacture_date = $_POST['manufacture_date'];
                        if (isset($_POST['expired_date'])) $expired_date = $_POST['expired_date'];

                        // True because $a is empty
                        if (empty($name)) {
                            echo "<div class='alert alert-danger'>Please insert the Name.</div>";
                            $flag = true;
                        } elseif (empty($price)) {
                            echo "<div class='alert alert-danger'>Please insert the Price.</div>";
                            $flag = true;
                        } elseif (empty($manufacture_date)) {
                            echo "<div class='alert alert-danger'>Please insert the Manufacture Date.</div>";
                            $flag = true;
                        }

                        // promotion price
                        if (empty($promotion_price)) {
                            $promotion_price = NULL;
                        } else if (($_POST["promotion_price"]) > ($_POST['price'])) {
                            $proErr = "<div class='alert alert-danger'>Promotion price should be cheaper than original price.</div>";
                            $flag = true;
                            echo $proErr;
                        } else {
                            $promotion_price = $_POST['promotion_price'];
                        }

                        // expired date
                        if (empty($expired_date)) {
                            $expired_date = NULL;
                        } else if (($_POST["expired_date"]) < ($_POST["manufacture_date"])) {
                            $expErr = "<div class='alert alert-danger'>Expired date should be later than manufacture date.</div>";
                            $flag = true;
                            echo $expErr;
                        } else {
                            $expired_date = $_POST['expired_date'];
                        }

                        if ($flag == false) {
                            // insert query, to deal with database, send in 
                            $query = "INSERT INTO products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date, created=:created";
                            // prepare query for execution
                            $stmt = $con->prepare($query);
                            // bind the parameters
                            $stmt->bindParam(':name', $name);
                            $stmt->bindParam(':description', $description);
                            $stmt->bindParam(':price', $price);
                            $stmt->bindParam(':promotion_price', $promotion_price);
                            $stmt->bindParam(':manufacture_date', $manufacture_date);
                            $stmt->bindParam(':expired_date', $expired_date);
                            // specify when this record was inserted to the database

                            $created = date('Y-m-d H:i:s');
                            $stmt->bindParam(':created', $created);

                            // Execute the query
                            if ($stmt->execute()) {
                                header("Location: http://localhost/webdev/onlineshop/product_list.php?action=success");
                            } else {
                                echo "<div class='alert alert-danger'>Unable to save record.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Makesure date are correct.</div>";
                        }
                    }

                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }

                ?>
                <!-- TABLE form -->
                <!-- html form here where the product information will be entered -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <table class='table table-hover table-responsive table-bordered mb-5'>
                        <tr>
                            <td>Name</td>
                            <td><input type='text' name='name' class='form-control' value='<?php if (isset($_POST['name'])) {
                                                                                                echo $_POST['name'];
                                                                                            } ?>' />
                            </td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><textarea name='description' class='form-control' rows="4" cols="50"><?php if (isset($_POST['description'])) {
                                                                                                            echo $_POST['description'];
                                                                                                        } ?> </textarea>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td><input type='text' name='price' class='form-control' value='<?php if (isset($_POST['price'])) {
                                                                                                echo $_POST['price'];
                                                                                            } ?>' /></td>
                        </tr>
                        <tr>
                            <td>Promotion Price</td>
                            <td><input type='text' name='promotion_price' class='form-control' value='<?php if (isset($_POST['promotion_price'])) {
                                                                                                            echo $_POST['promotion_price'];
                                                                                                        } ?>' /></td>
                        </tr>
                        <tr>
                            <td>Manufacture Date</td>
                            <td><input type='date' name='manufacture_date' class='form-control' value='<?php if (isset($_POST['manufacture_date'])) {
                                                                                                            echo $_POST['manufacture_date'];
                                                                                                        } ?>' /></td>
                        </tr>
                        <tr>
                            <td>Expired Date</td>
                            <td><input type='date' name='expired_date' class='form-control' value='<?php if (isset($_POST['expired_date'])) {
                                                                                                        echo $_POST['expired_date'];
                                                                                                    } ?>' /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type='submit' value='Save' class='btn btn-primary' />
                                <a href='product_list.php' class='btn btn-danger'>Back to Read Products</a>
                            </td>
                        </tr>
                    </table>
                </form>

            </div>
        </div>
    </div>
    <!-- end .container -->
</body>

</html>