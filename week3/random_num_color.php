<!DOCTYPE html>

<html>

<head>
    <title>Rand_Num_Color</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row text-center mt-5">
            <div class="col p-3 bg-info">
                <?php
                $a =  rand(10, 99);
                $b =  rand(10, 99);

                if ($a > $b) {
                    echo "<span class=\"bold\">";
                    echo $a;
                    echo "</span>";
                } else {
                    echo $a;
                }
                ?>
            </div>
            <div class="col p-3 bg-warning">
                <?php

                if ($a < $b) {
                    echo "<span class=\"bold\">";
                    echo $b;
                    echo "</span>";
                } else {
                    echo $b;
                }
                ?>
            </div>
        </div>


</body>

</html>