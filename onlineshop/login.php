<!DOCTYPE HTML>
<html>

<head>
    <title>Log in</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<!-- container -->
<div class="container">
    <div class="row fluid bg-color justify-content-center">
        <div class="col-md-3 mt-5">

            <!-- Custom styles for this template -->
            <link rel="icon" href="img/logo_yellow.png" sizes="32x32" type="image/png">
            <link href="signin.css" rel="stylesheet">
            </head>

            <body class="text-center">
                <?php
                //set var Error message
                $useErr =  $pasErr = $statusErr = "";

                // post, to send out, check is it using same way (post/get)
                if ($_POST) {

                    // include database connection, locate file and connect
                    include 'config/database.php';

                    //find username, posted values, label to same var
                    $username = htmlspecialchars(strip_tags($_POST['username']));

                    // insert query, to deal with database, send in 
                    $query = "SELECT password, acc_status FROM customer WHERE username=:username";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    // Execute the query
                    $stmt->execute();
                    $num = $stmt->rowCount();

                    //if num 1 = found username from database
                    if ($num > 0) {

                        // store retrieved row to a variable
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        // values to fill up our form
                        $password = $row['password'];
                        $acc_status = $row['acc_status'];

                        if ($password == md5($_POST['password'])) {
                            if ($acc_status == 'Active') {
                                header("Location: http://localhost/webdev/onlineshop/home.php");
                            } else {
                                $statusErr = "Your Account is Suspended*";
                            }
                        } else {
                            $pasErr = "Incorrect Password*";
                        }
                    } else {
                        $useErr = "User not found*";
                    }
                }
                ?>

                <!--HTML, result will be displayed-->
                <main class="form-signin">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="display-flex pt-5 mt-5">
                            <div>
                                <img src="img/logo_yellow.png" alt="Logo" width="50" height="50">
                                <h1 class="h5 mt-3 mb-3 fw-normal">Please Sign-in.</h1>

                                <!--echo error msg-->
                                <span class="error"><?php echo $useErr; ?></span>
                                <span class="error"><?php echo $pasErr; ?></span>
                                <span class="error"><?php echo $statusErr; ?></span>

                                <div class="form-floating">
                                    <input type="text" class="form-control" name="username" value='<?php if (isset($_POST['username'])) {
                                                                                                        echo $_POST['username'];
                                                                                                    } ?>'>
                                    <label for="username">Username</span></label>
                                </div>

                                <div class="form-floating mt-2">
                                    <input type="password" class="form-control" name="password" value='<?php if (isset($_POST['password'])) {
                                                                                                            echo $_POST['password'];
                                                                                                        } ?>'>
                                    <label for="password ">Password</label>
                                </div>

                                <div class="form-check mt-3">
                                    <input type="checkbox" value="remember-me" />
                                    <label>Remember Me</label>
                                </div>

                                <div class="form-floating">
                                    <button class="w-100 btn btn-lg btn-warning mt-3" type="submit">Sign in</button>
                                </div>

                            </div>

                            <p class="mt-5 text-muted">&copy; 2017–2021</p>
                    </form>
        </div>
        </main>

        </body>

</html>