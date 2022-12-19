<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>CustomerRead</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <?php
    include 'nav.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid bg-color justify-content-center">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3 text-warning">
                    <h2>Read Customer</h2>
                </div>

                <!-- PHP read one record will be here -->
                <?php

                //include database connection
                include 'config/database.php';

                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die('ERROR: Record ID not found.');

                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT customer_id, username, first_name, last_name, gender, date_of_birth, registration FROM customer WHERE customer_id = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);

                    // this is the first question mark
                    $stmt->bindParam(1, $customer_id);

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // values to fill up our form
                    $customer_id = $row['customer_id'];
                    $username = $row['username'];
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $gender = $row['gender'];
                    $date_of_birth = $row['date_of_birth'];
                    $registration = $row['registration'];
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
                        <td>Username</td>
                        <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td><?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td><?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>Registration Date & Time</td>
                        <td><?php echo htmlspecialchars($registration, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href='customer_list.php' class='btn btn-danger'>Back to Read Customer</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div> <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>

</body>

</html>