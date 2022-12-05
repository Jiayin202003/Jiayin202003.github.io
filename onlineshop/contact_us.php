<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>J_ContactUs</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="icon" href="img/logo_yellow.png" sizes="32x32" type="image/png">

<body>
    <?php
    include 'nav.php';
    ?>

    <!-- form container -->
    <div class="row fluid bg-color justify-content-center">
        <div class="col-md-9 mt-5">
            <div class="top_text m-3 mt-5 ps-3 text-warning">
                <h2>Contact</h2>
            </div>
            <div class="mb-3 ms-3 ps-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3 ms-3 ps-3">
                <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
            </div>
            <div class="web_btn float-end ms-3 pt-3">
                <button type="button" class="btn btn-outline-dark">Send</button>
            </div>

        </div> <!-- end .container -->
    </div>
    </div>
    </div>




</body>

</html>


</body>

</html>