<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>CustomerCreate</title>
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
                    <h2>Create Customer</h2>
                </div>

                <!-- html form to create product will be here -->
                <!-- PHP insert code will be here -->
                <?php

                // get = viewable in url, post is private (use for sensitive data)
                if (isset($_GET["action"])) {
                    if ($_GET["action"] == "success") {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    }
                }

                // post, to send out, check is it using same way (post/get)
                if ($_POST) {
                    // include database connection, locate file and connect
                    include 'config/database.php';
                    try {

                        // alert signal
                        $flag = false;

                        // posted values, label to same var
                        // blue: database, orange: user wrote 
                        $username = htmlspecialchars(strip_tags($_POST['username']));
                        $password = md5($_POST['password']);
                        $confirm_pass = md5($_POST['confirm_password']);
                        $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                        $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                        if (isset($_POST["gender"])) $gender = ($_POST['gender']);
                        $date_of_birth = $_POST['date_of_birth'];

                        // True because $a is empty
                        if (empty($username)) {
                            echo "<div class='alert alert-danger'>Please insert the Username.</div>";
                            $flag = true;
                        }
                        // section1:password
                        if (empty($password)) {
                            echo "<div class='alert alert-danger'>Please insert the Password.</div>";
                            $flag = true;
                        }
                        // section2:confirm password
                        if (empty($confirm_pass)) {
                            echo "<div class='alert alert-danger'>Please confirm the Password.</div>";
                            $flag = true;
                            // compare 'sec1' + 'sec2' = izzit the same
                        } else if ($_POST['password'] == $_POST['confirm_password']) {
                            $password = md5($_POST['password']);
                        } else {
                            // if is not same 
                            echo "<div class='alert alert-danger'>Password not match.</div>";
                            $flag = true;
                        }
                        if (empty($first_name)) {
                            echo "<div class='alert alert-danger'>Please insert the First Name.</div>";
                            $flag = true;
                        }
                        if (empty($last_name)) {
                            echo "<div class='alert alert-danger'>Please insert the Last Name.</div>";
                            $flag = true;
                        }
                        if (empty($gender)) {
                            echo "<div class='alert alert-danger'>Please insert the Gender.</div>";
                            $flag = true;
                        }
                        if (empty($date_of_birth)) {
                            echo "<div class='alert alert-danger'>Please insert the Date of Birth.</div>";
                            $flag = true;
                        } else {
                            $date_of_birth = $_POST["date_of_birth"];
                            $date2 = date("Y-m-d");
                            //strtotime = text -> date format
                            $diff = (strtotime($date2) - strtotime($date_of_birth));
                            $years = floor($diff / (365 * 60 * 60 * 24));

                            //must be 18yrold and above, if not: 
                            if ($years < 18) {
                                echo "<div class='alert alert-danger'>You have to be 18 years old and above.*</div>";
                                $flag = true;
                            }
                        }

                        $query = "SELECT username FROM customer WHERE username=:username";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(':username', $username);
                        $stmt->execute();
                        $num = $stmt->rowCount();

                        //if num 1 = found username from database
                        if ($num > 0) {
                            echo "<div class='alert alert-danger'>Username has been taken.</div>";
                            $flag = true;
                        }

                        if ($flag == false) {
                            // insert query, to deal with database, send in 
                            $query = "INSERT INTO customer SET username=:username, password=:password, first_name=:first_name, last_name=:last_name, gender=:gender,date_of_birth=:date_of_birth, registration=:registration";

                            // prepare query for execution
                            $stmt = $con->prepare($query);
                            // bind the parameters
                            $stmt->bindParam(':username', $username);
                            $stmt->bindParam(':password', $password);
                            $stmt->bindParam(':first_name', $first_name);
                            $stmt->bindParam(':last_name', $last_name);
                            $stmt->bindParam(':gender', $gender);
                            $stmt->bindParam(':date_of_birth', $date_of_birth);

                            // specify when this record was inserted to the database
                            $registration = date('Y-m-d H:i:s');
                            $stmt->bindParam(':registration', $registration);

                            // Execute the query
                            if ($stmt->execute()) {
                                header("Location: http://localhost/webdev/onlineshop/customer_list.php?action=success");
                            } else {
                                echo "<div class='alert alert-danger'>Unable to save record.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Makesure data are correct.</div>";
                        }
                    }

                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
                ?>

                <!-- TABLE form-->
                <!-- html form here where the product information will be entered -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <table class='table table-hover table-responsive table-bordered mb-5'>
                        <tr>
                            <td>Username</td>
                            <td><input type='text' name='username' minlength="6" class='form-control' value='<?php if (isset($_POST['username'])) {
                                                                                                                    echo $_POST['username'];
                                                                                                                } ?>' /></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type='password' name='password' class='form-control' value='<?php
                                                                                                    if (isset($_POST['password'])) {
                                                                                                        echo $_POST['password'];
                                                                                                    }
                                                                                                    ?>' /></td>
                        </tr>
                        <tr>
                            <td>Confirm Password</td>
                            <td><input type='password' name='confirm_password' class='form-control' value='<?php
                                                                                                            if (isset($_POST['confirm_password'])) {
                                                                                                                echo $_POST['confirm_password'];
                                                                                                            }
                                                                                                            ?>' /></td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td><input type='text' name='first_name' class='form-control' value='<?php
                                                                                                    if (isset($_POST['first_name'])) {
                                                                                                        echo $_POST['first_name'];
                                                                                                    }
                                                                                                    ?> ' /></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><input type='text' name='last_name' class='form-control' value='<?php
                                                                                                if (isset($_POST['last_name'])) {
                                                                                                    echo $_POST['last_name'];
                                                                                                }
                                                                                                ?> ' /></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td><input type='radio' id="gender" name='gender' value='male' <?php
                                                                                            if (isset($_POST['gender'])) {
                                                                                                if ($_POST['gender'] == "male")
                                                                                                    echo "checked";
                                                                                            }
                                                                                            ?> />
                                <label for="male">Male</label><br>

                                <input type='radio' id="gender" name='gender' value='female' <?php
                                                                                                if (isset($_POST["gender"])) {
                                                                                                    if ($_POST['gender'] == "female")
                                                                                                        echo "checked";
                                                                                                }
                                                                                                ?> />
                                <label for="female">Female</label><br>

                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td><input type='date' name='date_of_birth' class='form-control' value='<?php
                                                                                                    if (isset($_POST['date_of_birth'])) {
                                                                                                        echo $_POST['date_of_birth'];
                                                                                                    } ?>' />
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type='submit' value='Save' class='btn btn-primary' />
                                <a href='customer_list.php' class='btn btn-danger'>Back to Read Customer</a>
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