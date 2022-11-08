<!DOCTYPE html>

<html>

<head>
    <title>Rand_Num</title>
    <style>
        .qes1 {
            font-style: italic;
            color: green;
        }

        .qes2 {
            font-style: italic;
            color: blue;
        }

        .qes3 {
            font-weight: bold;
            color: red;
        }

        .qes4 {
            font-weight: bold;
            font-style: italic;
            color: black;
        }
    </style>
</head>

<body>

    <?php
    $a =  rand(100, 200);
    $b =  rand(100, 200);

    echo "<span class=\"qes1\">";
    echo $a;
    echo "</span> <br>";

    echo "<span class=\"qes2\">";
    echo $b;
    echo "</span> <br>";

    echo "<span class=\"qes3\">";
    echo ($a + $b);
    echo "</span> <br>";

    echo "<span class=\"qes4\">";
    echo ($a * $b);
    echo "</span> <br>";
    ?>

</body>

</html>