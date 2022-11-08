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
                    <h2>Create Customer</h2>
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
                        $username = htmlspecialchars(strip_tags($_POST['username']));
                        $password = htmlspecialchars(strip_tags($_POST['password']));
                        $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                        $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                        $gender = htmlspecialchars(strip_tags($_POST['gender']));
                        $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));


                        // True because $a is empty
                        if (empty($username)) {
                            echo "<div class='alert alert-danger'>Please insert the Username.</div>";
                            $flag = true;
                        } elseif (empty($password)) {
                            echo "<div class='alert alert-danger'>Please insert the Password.</div>";
                            $flag = true;
                        } elseif (empty($first_name)) {
                            echo "<div class='alert alert-danger'>Please insert the First Name.</div>";
                            $flag = true;
                        } elseif (empty($last_name)) {
                            echo "<div class='alert alert-danger'>Please insert the Last Name.</div>";
                            $flag = true;
                        } elseif (empty($gender)) {
                            echo "<div class='alert alert-danger'>Please insert the Gender.</div>";
                            $flag = true;
                        } elseif (empty($date_of_birth)) {
                            echo "<div class='alert alert-danger'>Please insert the Date of Birth.</div>";
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
                            <td>Username</td>
                            <td><input type='text' name='username' minlength="6" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type='password' name='password' class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td><input type='text' name='first_name' class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><input type='text' name='last_name' class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td><input type="radio" name="gender" value="male"> Male<br>
                                <input type="radio" name="gender" value="female"> Female
                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td><input type='date' name='date_of_birth' class='form-control' /></td>
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