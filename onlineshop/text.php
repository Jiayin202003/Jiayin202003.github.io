<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>J_OrderCreate</title>
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
                    <h2>Order Create</h2>
                </div>

                <!-- html form to create product will be here -->
                <!-- PHP insert code will be here -->

                <?php
                // check if form was submitted

                include 'config/database.php'; // include database connection
                $flag = false;

                $Err_msg = '';

                if ($_POST) {
                    $customer_id = htmlspecialchars(strip_tags($_POST['username']));
                    $product = $_POST['product'];
                    $quantity = $_POST['quantity'];
                    $no_of_occ = array_count_values($product); //check the number of occurrences of each element

                    //STEP 1: Check if username is selected 
                    if (empty($_POST['username'])) {
                        $Err_msg .= "<div class='alert alert-danger'>Username is required*</div>";
                    }

                    //STEP 2: Check if product+quantity is already selected & duplicatee product
                    for ($x = 0; $x < count($product); $x++) {

                        if ($product[$x] == '' && $quantity[$x] == '') {
                            $Err_msg .= "<div class='alert alert-danger'>Please choose quantity of your product $product[0]*</div>";
                        }

                        if ($no_of_occ[$product[$x]] > 1) {
                            $Err_msg .= "<div class='alert alert-danger'>No duplicate product $product[0] allowed*</div>";
                        }
                    }

                    //STEP 3: If nothing wrong, then proceed the INSERT query
                    //send data to 'order_summary' table in myphp
                    if (empty($Err_msg)) {
                        $order_date = date('Y-m-d');
                        $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(':customer_id', $customer_id);
                        $stmt->bindParam(':order_date', $order_date);

                        if ($stmt->execute()) {
                            //if success, put 'order_id' that created > 'order details' table
                            //autoincreatment to create 'order_id'
                            //$lastid = $order_id
                            $order_id = $con->lastInsertId();

                            for ($x = 0; $x < count($product); $x++) {

                                //send data to 'order_details' table in myphp
                                $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:order_id";
                                $stmt = $con->prepare($query);
                                //product & quantity are array, [0,1,2]
                                $stmt->bindParam(':product_id', $product[$x]);
                                $stmt->bindParam(':quantity', $quantity[$x]);
                                $stmt->bindParam(':order_id', $order_id);
                                $stmt->execute();
                            }
                            echo "<div class='alert alert-success'>Create order successful.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>$Err_msg</div>";
                    }
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                    <?php
                    // select customer
                    $query = "SELECT customer_id, username FROM customer ORDER BY customer_id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();
                    ?>


                    <table class='table table-hover table-responsive table-bordered mb-5'>
                        <div class="row">
                            <label class="order-form-label">Username</label>
                        </div>
                        <div class="col-6 mb-3 mt-2">
                            <select class="form-select" name="username" aria-label="form-select-lg example">
                                <option value='' selected>Choose Username</option>
                                <?php
                                //if more then 0, value="01">"username"</option>
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row); ?>
                                        <option value="<?php echo $customer_id; ?>"><?php echo htmlspecialchars($username, ENT_QUOTES); ?><?php if (isset($_POST['username'])) {
                                                                                                                                                echo $_POST['username'];
                                                                                                                                            } ?></option>
                                <?php }
                                }
                                ?>
                            </select>
                        </div>

                        <?php
                        //forloop, for 3 product(box)
                        for ($x = 0; $x < 3; $x++) {
                            // select pro_id + name
                            $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();
                        ?>

                            <div class="row">
                                <label class="order-form-label">Product</label>
                                <div class="col-3 mb-2 mt-2">
                                    <select class="form-select" name="product[]" aria-label="form-select-lg example">
                                        <option value='' selected>Choose Product</option>
                                        <?php
                                        if ($num > 0) {
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row); ?>
                                                <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name, ENT_QUOTES);
                                                                                    if ($promotion_price == 0) {
                                                                                        echo " (RM$price)";
                                                                                    } else {
                                                                                        echo " (RM$promotion_price)";
                                                                                    } ?><?php if (isset($_POST['product[]'])) {
                                                                                            echo $_POST['product[]'];
                                                                                        } ?></option>
                                        <?php }
                                        }
                                        ?>

                                    </select>
                                </div>

                                <input class="col-1 mb-2 mt-2" type="number" id="quantity[]" name="quantity[]" min=1>

                            </div>
                        <?php } ?>
                    </table>

                    <input type="submit" class="btn btn-primary" />
                </form>

            </div> <!-- end .container -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
            <!-- confirm delete record will be here -->

</body>

</html>

<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .scrollable-menu {
            height: auto;
            max-height: 200px;
            overflow-x: hidden;
        }
    </style>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create New Order</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->

        <?php
        // include database connection
        include 'config/database.php';
        $err_msg = "";

        if ($_POST) {

            $product_id = $_POST["product_id"];
            $value = array_count_values($product_id);
            $quantity = $_POST["quantity"];

            if (empty($_POST["username"])) {
                $err_msg .= "<div class='alert alert-danger'>Select Customer</div>";
            } else {
                $customer_id = htmlspecialchars(strip_tags($_POST['username']));
            }

            for ($i = 0; $i < count($product_id); $i++) {

                if ($product_id[$i] != "") {
                    if ($quantity[$i] == "") {
                        $err_msg .= "<div class='alert alert-danger'>Choose Product $i with quatity</div>";
                    }
                    if ($value[$product_id[$i]] > 1) {
                        $err_msg .= "<div class='alert alert-danger'>No Duplicate Product $i allowed</div>";
                    }
                }
            }


            if (empty($err_msg)) {
                $order_date = date('Y-m-d');
                $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':customer_id', $customer_id);
                $stmt->bindParam(':order_date', $order_date);
                if ($stmt->execute()) {
                    $order_id = $con->lastInsertId();
                    for ($i = 0; $i < count($product_id); $i++) {

                        //send data to 'order_details' table in myphp
                        $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:order_id";
                        $stmt = $con->prepare($query);

                        $stmt->bindParam(':product_id', $product_id[$i]);
                        $stmt->bindParam(':quantity', $quantity[$i]);
                        $stmt->bindParam(':order_id', $order_id);
                        $stmt->execute();
                    }
                    echo "<div class='alert alert-success'>Order Successful.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>.$err_msg.</div>";
            }
        }


        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <?php
            // select customer
            $query = "SELECT customer_id, username FROM customer ORDER BY customer_id DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();

            $num = $stmt->rowCount();
            ?>


            <table class='table table-hover table-responsive table-bordered mb-5'>
                <div class="row">
                    <label class="order-form-label">Username</label>
                </div>

                <div class="col-6 mb-3 mt-2">
                    <select class="form-select" name="username" aria-label="form-select-lg example">
                        <option value='' selected>Customer Name</option>
                        <?php
                        //if more then 0, value="01">"username"</option>
                        if ($num > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row); ?>
                                <!--1 for database, 1 for user-->
                                <option value="<?php echo $customer_id; ?>"><?php echo htmlspecialchars($username, ENT_QUOTES); ?></option>
                        <?php }
                        }
                        ?>

                    </select>

                </div>

                <?php
                //forloop, for 3 product
                for ($x = 0; $x < 3; $x++) {
                    // select product
                    $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();
                ?>

                    <div class="row">
                        <label class="order-form-label">Product</label>

                        <div class="col-3 mb-2 mt-2">
                            <select class="form-select bg-primary" name="product_id[]" aria-label="form-select-lg example">
                                <option value='' selected>Choose Product</option>
                                <?php
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row); ?>
                                        <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name, ENT_QUOTES);
                                                                            if ($promotion_price == 0) {
                                                                                echo " (RM$price)";
                                                                            } else {
                                                                                echo " (RM$promotion_price)";
                                                                            } ?></option>
                                <?php }
                                }
                                ?>

                            </select>
                        </div>

                        <input class="col-1 mb-2 mt-2" type="number" id="quantity[]" name="quantity[]" min=1>
                    </div>
                <?php } ?>


            </table>
            <input type="submit" class="btn btn-danger" />
        </form>

    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- confirm delete record will be here -->

</body>

</html>