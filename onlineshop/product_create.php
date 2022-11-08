<!DOCTYPE HTML>
<html>

<head>
    <title>J_ProductCreate</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <!-- navigation menu -->
    <nav class="navbar navbar-expand-lg bg-warning mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="img/logo.png" alt="Logo" width="30" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product_create.php">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer_create.php">Create Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
                        $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                        $expired_date = htmlspecialchars(strip_tags($_POST['expired_date']));

                        // True because $a is empty
                        if (empty($name)) {
                            echo "<div class='alert alert-danger'>Please insert the Name.</div>";
                            $flag = true;
                        } elseif (empty($description)) {
                            echo "<div class='alert alert-danger'>Please insert the Description.</div>";
                            $flag = true;
                        } elseif (empty($price)) {
                            echo "<div class='alert alert-danger'>Please insert the Price.</div>";
                            $flag = true;
                        } elseif (empty($promotion_price)) {
                            echo "<div class='alert alert-danger'>Please insert the Promotion Price.</div>";
                            $flag = true;
                        } elseif (empty($manufacture_date)) {
                            echo "<div class='alert alert-danger'>Please insert the Manufacture Date.</div>";
                            $flag = true;
                        } elseif (empty($expired_date)) {
                            echo "<div class='alert alert-danger'>Please insert the Expired Date.</div>";
                            $flag = true;
                        }

                        // promo price 
                        if (($_POST["promotion_price"]) > ($_POST['price'])) {
                            $proErr = "<div class='alert alert-danger'>Promotion price should be cheaper than original price.</div>";
                            $flag = true;
                            echo $proErr;
                        } else {
                            $promotion_price = $_POST['price'];
                        }

                        // expired date
                        if (empty($_POST["expired_date"])) {
                            $expErr = "<div class='alert alert-danger'>Please enter the expired date.</div>";
                            $flag = true;
                            echo $expErr;
                        } else {
                            $expired_date = $_POST["expired_date"];
                            if (($_POST["expired_date"]) < ($_POST["manufacture_date"])) {
                                $expErr = "<div class='alert alert-danger'>Expired date should be later than manufacture date.</div>";
                                $flag = true;
                                echo $expErr;
                            }
                        }

                        if ($flag == false) {
                            // insert query, to deal with database, send in 
                            $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date";
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
                                echo "<div class='alert alert-success'>Record was saved.</div>";
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

                <!-- html form here where the product information will be entered -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <table class='table table-hover table-responsive table-bordered mb-5'>
                        <tr>
                            <td>Name</td>
                            <td><input type='text' name='name' class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><textarea name='description' class='form-control' rows="4" cols="50"></textarea></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td><input type='text' name='price' class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Promotion Price</td>
                            <td><input type='text' name='promotion_price' class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Manufacture Date</td>
                            <td><input type='text' name='manufacture_date' class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Expired Date</td>
                            <td><input type='text' name='expired_date' class='form-control' /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type='submit' value='Save' class='btn btn-primary' />
                                <a href='index.php' class='btn btn-danger'>Back to read products</a>
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