<!DOCTYPE HTML>
<html>

<head>
    <title>J_CustomerList</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <?php
    include 'nav.php';
    include 'session.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid bg-color justify-content-center">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3 text-warning">
                    <h2>Read Customers</h2>
                </div>

                <!-- html form to create product will be here -->
                <!-- PHP insert code will be here -->
                <?php
                // include database connection
                include 'config/database.php';

                // delete message prompt will be here

                // select all data
                $query = "SELECT username, first_name, last_name, gender, date_of_birth, registration FROM customer ORDER BY username DESC";

                $stmt = $con->prepare($query);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();

                // link to create record form
                echo "<a href='customer_create.php' class='btn btn-warning m-b-1em mb-3'>Create New Customer</a>";

                //check if more than 0 record found
                if ($num > 0) {

                    // data from database will be here
                    echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                    //creating our table heading
                    echo "<tr>";
                    echo "<th>Username</th>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>Gender</th>";
                    echo "<th>Date of Birth</th>";
                    echo "<th>Registration Date & Time</th>";
                    echo "<th>Account Status</th>";
                    echo "</tr>";

                    // table body will be here
                    // retrieve our table contents
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // extract row
                        // this will make $row['firstname'] to just $firstname only
                        extract($row);
                        // creating new table row per record
                        echo "<tr>";
                        echo "<td>{$username}</td>";
                        echo "<td>{$first_name}</td>";
                        echo "<td>{$last_name}</td>";
                        echo "<td>{$gender}</td>";
                        echo "<td>{$date_of_birth}</td>";
                        echo "<td>{$registration}</td>";
                        echo "<td>";
                        // read one record
                        echo "<a href='customer_read.php?username={$username}' class='btn btn-info m-r-1em'>Read</a>";

                        // we will use this links on next part of this post
                        echo "<a href='update.php?username={$username}' class='btn btn-primary m-r-1em'>Edit</a>";

                        // we will use this links on next part of this post
                        echo "<a href='#' onclick='delete_user({$username});'  class='btn btn-danger'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    // end table
                    echo "</table>";
                }
                // if no records found
                else {
                    echo "<div class='alert alert-danger'>No records found.</div>";
                }
                ?>
            </div> <!-- end .container -->

            <!-- confirm delete record will be here -->
        </div>
    </div>
</body>

</html>