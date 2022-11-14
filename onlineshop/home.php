<!DOCTYPE HTML>
<html>

<head>
    <title>J_Home</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <nav class="navbar navbar-expand-lg bg-warning">
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
                        <a class="nav-link" href="product_list.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer_list.php">Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- img carousel -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/coffee1-01.jpg" class="d-block w-100 h-70" alt="...">
                <div class="carousel-caption">
                    <h5>Jan's Online Coffee</h5>
                    <p>Success is best when it's shared.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/coffee2-01.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption">
                    <h5>Jan's Online Coffee</h5>
                    <p>Success is best when it's shared.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/coffee3-01.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption">
                    <h5>Jan's Online Coffee</h5>
                    <p>Success is best when it's shared.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/coffee4-01.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption">
                    <h5>Jan's Online Coffee</h5>
                    <p>Success is best when it's shared.</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


</body>

</html>