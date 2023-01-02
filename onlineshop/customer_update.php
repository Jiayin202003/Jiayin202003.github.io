<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>CustomerEdit</title>
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
                    <h2>Edit Customer Details</h2>
                </div>

                <!-- PHP read one record will be here -->
                <?php

                //include database connection
                include 'config/database.php';

                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                //shortcut for if else, pass 'id' to database through URL
                $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die('ERROR: Record ID not found.');

                // read current record's data
                // read data > insert to text fill, update it
                try {
                    $query = "SELECT customer_id, username, password, first_name, last_name, gender, date_of_birth FROM customer WHERE customer_id = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);

                    // this is the first question mark
                    $stmt->bindParam(1, $customer_id);

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // get values to fill up our form from database 
                    $customer_id = $row['customer_id'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $gender = $row['gender'];
                    $date_of_birth = $row['date_of_birth'];
                }

                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
                ?>

                <?php
                // check if form was submitted, after submit
                if ($_POST) {

                    // alert signal
                    $flag = false;

                    // take form posted values, user wrote
                    $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                    $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                    $gender = htmlspecialchars(strip_tags($_POST['gender']));
                    $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));


                    //checking, if password column are filled 
                    if (!empty($_POST['old_password'])) {

                        //compare '$old_pass' with '$password(in database)' 
                        if (md5($_POST['old_password']) == $password) {

                            //compare '$new_pass' with '$password(in database)'
                            if (md5($_POST['password']) == md5($_POST['old_password'])) {
                                echo "<div class='alert alert-danger'>New password should not be same with Old password.</div>";
                                $flag = true;
                            } else {
                                $password = md5($_POST['password']);
                            }

                            //if comfirm_password empty
                            if (empty($_POST['confirm_password'])) {
                                echo "<div class='alert alert-danger'>Please confirm password.</div>";
                                $flag = true;
                            } else {
                                $confirm_password = ($_POST['confirm_password']);
                                //if '$new_pass' does not match with '$confirm_pass'
                                if (($_POST['password']) != ($_POST['confirm_password'])) {
                                    echo "<div class='alert alert-danger'>New password and Confrim password should be the same.</div>";
                                    $flag = true;
                                }
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Password not correct.</div>";
                            $flag = true;
                        }
                    }

                    if ($flag == false) {
                        //if no error, process to UPDATE, bind the parameters

                        try {
                            // write update query
                            // in this case, it seemed like we have so many fields to pass and
                            // it is better to label them and not use question marks
                            $query = "UPDATE customer SET password=:password, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth WHERE customer_id=:customer_id";

                            // prepare query for excecution
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':customer_id', $customer_id);
                            $stmt->bindParam(':password', $password);
                            $stmt->bindParam(':first_name', $first_name);
                            $stmt->bindParam(':last_name', $last_name);
                            $stmt->bindParam(':gender', $gender);
                            $stmt->bindParam(':date_of_birth', $date_of_birth);

                            // Execute the query
                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success'>Record was updated.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                            }
                        }
                        // show errors
                        catch (PDOException $exception) {
                            die('ERROR: ' . $exception->getMessage());
                        }
                    }
                } ?>

                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <!-- PHP post to update record will be here -->
                <!--we have our html form here where new record information can be updated-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?customer_id={$customer_id}"); ?>" method="post">
                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td>Username</td>
                            <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
                        </tr>
                        <tr>
                            <td>Old Password</td>
                            <td><input type='password' name='old_password' class='form-control' value='<?php
                                                                                                        if (isset($_POST['old_password'])) {
                                                                                                            echo $_POST['old_password'];
                                                                                                        }
                                                                                                        ?>' /></td>
                        </tr>
                        <tr>
                            <td>New Password</td>
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
                            <td><textarea name='first_name' class='form-control'><?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?></textarea></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td><input type='radio' id="gender" name='gender' value='Male' <?php
                                                                                            if ($gender == 'Male') {
                                                                                                echo "checked";
                                                                                            }
                                                                                            ?> /> <label for='Male'>Male</label>

                                <input type='radio' id="gender" name='gender' value='Female' <?php
                                                                                                if ($gender == 'Female') {
                                                                                                    echo "checked";
                                                                                                }
                                                                                                ?> /> <label for='Female'>Female</label>

                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type='submit' value='Save Changes' class='btn btn-primary' />
                                <a href='customer_list.php' class='btn btn-danger'>Back to read customer</a>
                            </td>
                        </tr>
                    </table>
            </div>
        </div>
    </div> <!-- end .container -->


</body>

</html>