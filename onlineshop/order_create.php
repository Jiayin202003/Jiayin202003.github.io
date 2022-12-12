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
    include 'config/database.php'; // include database connection
    $flag = false;

    $userErr = '';
    $proErr = '';
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

                if ($_POST) {
                    if (empty($_POST["username"])) {
                        echo $userErr = "<div class='alert alert-danger'>Username is required*</div>";

                        $flag = true;
                    } else {
                        $customer_id = htmlspecialchars(strip_tags($_POST['username']));
                    }

                    //submit user fill in de product and quantity
                    //product_id (array), 3 into 1 

                    $product = $_POST["product"];
                    $value = array_count_values($product);
                    $quantity = $_POST["quantity"];

                    /* var_dump($product);
                    echo "<br>";
                    var_dump($quantity);
                    echo "<br>";
                    echo print_r($value);

                    'array(3) { [0]=> string(2) "38" [1]=> string(2) "38" [2]=> string(2) "37" }
                    array(3) { [0]=> string(1) "2" [1]=> string(1) "1" [2]=> string(1) "3" }
                    Array ( [38] => 2 [37] => 1 ) 1' */

                    //if empty
                    if ($product[0] == "" && $product[1] == "" && $product[2] == "") {
                        echo "<div class='alert alert-danger'>Please at least choose a product *</div>";
                    } else {

                        //if product != empty, quatity = empty
                        if ((!empty($product[0]) && empty($quantity[0])) or (!empty($product[1]) && empty($quantity[1])) or (!empty($product[2]) && empty($quantity[2]))) {
                            echo "<div class='alert alert-danger'>Please type the quantity of your product *</div>";
                        } else {


                            //error if more than 1 (duplicate)
                            for ($x = 0; $x < count($product); $x++) {
                                if (!empty($product[$x]) && !empty($quantity[$x])) {

                                    if ($value[$product[$x]] == 1) {
                                        if ($flag == false) {

                                            //send data to 'order_summary' table in myphp
                                            $order_date = date('Y-m-d');
                                            $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date";
                                            $stmt = $con->prepare($query);
                                            $stmt->bindParam(':customer_id', $customer_id);
                                            $stmt->bindParam(':order_date', $order_date);

                                            if ($stmt->execute()) {

                                                echo "<div class='alert alert-success'>Create order successful.</div>";
                                                //if success, put 'order_id' that created > 'order details' table
                                                //autoincreatment to create 'order_id'
                                                //$lastid = $order_id
                                                $order_id = $con->lastInsertId();

                                                //send data to 'order_details' table in myphp
                                                $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:order_id";
                                                $stmt = $con->prepare($query);
                                                //product & quantity are array, [0,1,2]
                                                $stmt->bindParam(':product_id', $product[$x]);
                                                $stmt->bindParam(':quantity', $quantity[$x]);
                                                $stmt->bindParam(':order_id', $order_id);
                                                $stmt->execute();
                                            } else {
                                                echo "<div class='alert alert-danger'>Unable to create order.</div>";
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger'>Unable to create order.</div>";
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger'>Please select different product.</div>";
                                    }
                                }
                            }
                        }
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