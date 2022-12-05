<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>J_CustomerEdit</title>
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
                    <h2>Edit Customer Details</h2>
                </div>

                <!-- PHP read one record will be here -->
                <?php

                //include database connection
                include 'config/database.php';

                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                $username = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record ID not found.');

                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT username, password, first_name, last_name, gender, date_of_birth, registration FROM customer WHERE username = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);

                    // this is the first question mark
                    $stmt->bindParam(1, $username);

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // get values to fill up our form from database 
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
                // check if form was submitted
                if ($_POST) {
                    try {

                        // alert signal
                        $flag = false;

                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE customer SET password=:password, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth WHERE username=:username";

                        // prepare query for excecution
                        $stmt = $con->prepare($query);

                        // posted values
                        $username = htmlspecialchars(strip_tags($_POST['username']));
                        $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                        $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                        $gender = htmlspecialchars(strip_tags($_POST['gender']));
                        $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));


                        if (empty(md5($_POST['new_password']))) {

                            //compare '$old_pass' with '$password(in database)' 
                            if (md5($_POST['old_password']) == $password) {

                                // compare = izzit the same
                                if (md5($_POST['new_password']) == md5($_POST['confirm_password'])) {
                                    $password = md5($_POST['new_password']);
                                } else {
                                    // if is not same 
                                    echo "<div class='alert alert-danger'>Password not match.</div>";
                                    $flag = true;
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Password not correct.</div>";
                                $flag = true;
                            }
                        }

                        if ($flag == false) {
                            // bind the parameters
                            $stmt->bindParam(':username', $username);
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
                    }
                    // show errors
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                } ?>

                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <!-- PHP post to update record will be here -->
                <!--we have our html form here where new record information can be updated-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?username={$username}"); ?>" method="post">
                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td>Username</td>
                            <td><input type='text' name='username' value="<?php echo htmlspecialchars($username, ENT_QUOTES);  ?>" class='form-control' /></td>
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
                            <td><input type='password' name='new_password' class='form-control' value='<?php
                                                                                                        if (isset($_POST['new_password'])) {
                                                                                                            echo $_POST['new_password'];
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