<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>OrderCreate</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
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
                    <h2>Order Create</h2>
                </div>

                <!-- html form to create product will be here -->
                <!-- PHP insert code will be here -->
                <?php
                include 'config/database.php'; // include database connection
                $Err_msg = '';

                // check if form was submitted
                if ($_POST) {

                    $product = $_POST["product"];
                    $value = array_count_values($product);
                    $quantity = $_POST["quantity"];

                    if (empty($_POST["username"])) {
                        $Err_msg = "<div class='alert alert-danger'>Username is required*</div>";
                    } else {
                        $customer_id = htmlspecialchars(strip_tags($_POST['username']));
                    }

                    for ($x = 0; $x < count($product); $x++) {

                        if (empty($product[0])) {
                            $Err_msg .= "<div class='alert alert-danger'>Please choose Product with quatity *</div>";
                        }

                        if ($product[$x] != "") {
                            if ($quantity[$x] == "") {
                                $Err_msg .= "<div class='alert alert-danger'>Please choose Product with quatity *</div>";
                            }
                            if ($value[$product[$x]] > 1) {
                                $Err_msg .= "<div class='alert alert-danger'>No Duplicate Product allowed *</div>";
                            }
                        }
                    }

                    echo $Err_msg;

                    if (empty($Err_msg)) {
                        $total_amount = 0;

                        //set rule/conditions
                        //run loop 3 times
                        for ($x = 0; $x < count($product); $x++) {

                            $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':id', $product[$x]);
                            $stmt->execute();
                            $num = $stmt->rowCount();
                            $price = 0;

                            //if database pro price is 0/no promo, price = row price
                            if ($num > 0) {

                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                if ($row['promotion_price'] == 0) {
                                    $price = $row['price'];
                                } else {
                                    $price = $row['promotion_price'];
                                }
                            }
                            //combine prvious total_amount with new ones, loop (3 times)
                            $total_amount = $total_amount + ((float)$price * (int)$quantity[$x]);
                        }

                        /* echo $total_amount; */

                        $order_date = date('Y-m-d H:i:s');
                        $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date, total_amount=:total_amount";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(':customer_id', $customer_id);
                        $stmt->bindParam(':order_date', $order_date);
                        $stmt->bindParam(':total_amount', $total_amount);

                        //send data to 'order_summary' table in myphp
                        if ($stmt->execute()) {
                            //if success, put 'order_id' that created > 'order details' table
                            //autoincreatment to create 'order_id'
                            //$lastid = $order_id
                            $order_id = $con->lastInsertId();
                            for ($x = 0; $x < count($product); $x++) {

                                if ($product[$x] !== "") {

                                    $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                    $stmt = $con->prepare($query);
                                    //bind user choose product(id) with order details product id
                                    $stmt->bindParam(':id', $product[$x]);
                                    $stmt->execute();
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $num = $stmt->rowCount();

                                    if ($num > 0) {
                                        if ($row['promotion_price'] == 0) {
                                            $price = $row['price'];
                                        } else {
                                            $price = $row['promotion_price'];
                                        }
                                    }
                                    $price_each = ((float)$price * (int)$quantity[$x]);

                                    //send data to 'order_details' table in myphp
                                    $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:order_id, price_each=:price_each";
                                    $stmt = $con->prepare($query);

                                    //product & quantity are array, [0,1,2]
                                    $stmt->bindParam(':product_id', $product[$x]);
                                    $stmt->bindParam(':quantity', $quantity[$x]);
                                    $stmt->bindParam(':order_id', $order_id);
                                    $stmt->bindParam(':price_each', $price_each);
                                    if ($stmt->execute()) {
                                        header("Location: http://localhost/webdev/onlineshop/order_list.php?action=success");
                                    }
                                }
                            }
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Unable to create order.</div>";
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
                        <div class="col-8 mb-4 mt-2">
                            <select class="form-select" name="username" aria-label="form-select-lg example">
                                <option value='' selected>Choose Username</option>
                                <?php
                                //if more then 0, value="01">"username"</option>
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row); ?>
                                        <option value="<?php echo $customer_id; ?>"><?php echo htmlspecialchars($username, ENT_QUOTES); ?><?php
                                                                                                                                            if (isset($_POST['username'])) {
                                                                                                                                                echo $_POST['username'];
                                                                                                                                            } ?></option>
                                <?php }
                                }
                                ?>
                            </select>
                        </div>

                        <?php
                        // select pro_id + name
                        $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        // this is how to get number of rows returned
                        $num = $stmt->rowCount();
                        ?>

                        <div class="pRow">
                            <div class="row">
                                <div class="col-8 mb-2 ">
                                    <label class="order-form-label">Product</label>
                                </div>

                                <div class="col-4 mb-2"><label class="order-form-label">Quantity</label>
                                </div>
                                <div class="col-8 mb-2">
                                    <select class="form-select mb-3" id="" name="product[]" aria-label="form-select-lg example">
                                        <option value='' selected>Choose your product </option>

                                        <?php if ($num > 0) {
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row); ?>
                                                <option value="<?php echo $id; ?>">
                                                    <?php echo htmlspecialchars($name, ENT_QUOTES);
                                                    if ($promotion_price == 0) {
                                                        echo " (RM$price)";
                                                    } else {
                                                        echo " (RM$promotion_price)";
                                                    } ?>

                                                </option>
                                        <?php }
                                        }
                                        ?>

                                    </select>

                                </div>

                                <div class="col-4 mb-3">
                                    <input type='number' id='quantity[]' name='quantity[]' class='form-control' min=1 />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <input type="button" value="Add More" class="add_one btn btn-warning" />
                            <input type="button" value="Delete" class="delete_one btn btn-warning" />
                            <input type='submit' value='Order' class=' btn btn-danger' />
                        </div>



                    </table>

                </form>

            </div>
        </div>
        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var element = document.querySelector('.pRow');
                    var clone = element.cloneNode(true);
                    element.after(clone);
                }
                if (event.target.matches('.delete_one')) {
                    var total = document.querySelectorAll('.pRow').length;
                    if (total > 1) {
                        var element = document.querySelector('.pRow');
                        element.remove(element);
                    }
                }
            }, false);
        </script>
        <!-- confirm delete record will be here -->
    </div><!-- end .container -->
</body>

</html>