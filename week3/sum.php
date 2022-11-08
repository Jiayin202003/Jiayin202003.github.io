<!DOCTYPE html>

<html>

<head>
    <title>Sum</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>

    </style>
</head>

<body>
    <div class="text-primary">
        <?php
        $sum = 0;

        for ($x = 1; $x <= 100; $x++) {
            $sum += $x;

            if ($x % 2 == 0) {
                echo "<strong>" . $x . "</strong>";
                if ($x < 100) {
                    echo "+";
                }
            } else {
                echo $x, "+";
            }
        }

        echo "=" . $sum;
        ?>
    </div>

</body>

</html>