<!DOCTYPE html>

<html>

<head>
    <style>
        .red {
            color: red;
        }

        .blue {
            color: blue;
        }
    </style>
</head>

<body>
    <?php
    echo "My first <b>PHP</b> script!<br>";

    echo "<span class=\"red\">";
    echo date("jS");
    echo "</span> ";

    echo date("M ");

    echo "<span class=\"blue\">";
    echo date("Y");
    echo "</span> ";
    ?>
</body>

</html>