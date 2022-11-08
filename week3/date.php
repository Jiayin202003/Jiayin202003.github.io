<!DOCTYPE html>

<html lang="en">

<head>
    <title>Date</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .scrollable-menu {
            height: auto;
            max-height: 150px;
            overflow-x: hidden;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
    echo "<div class=\"container text-center\">";
    echo "<div class=\"btn-group pt-3 gap-5\">";
    echo "<button class=\"btn btn-info btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
    echo "Day";
    echo "</button>";
    echo "<ul class=\"dropdown-menu scrollable-menu\">";
    for ($i = 1; $i <= 31; $i++) {
    ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php
    }
    echo "</ul>";

    echo "<div class=\"container text-center\">";
    echo "<div class=\"btn-group pt-2 gap-5\">";
    echo "<button class=\"btn btn-warning btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
    echo "Month";
    echo "</button>";
    echo "<ul class=\"dropdown-menu scrollable-menu\">";
    for ($i = 1; $i <= 12; $i++) {
    ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php
    }
    echo "</ul>";

    echo "<div class=\"container text-center\">";
    echo "<div class=\"btn-group pt-1 gap-5\">";
    echo "<button class=\"btn btn-primary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
    echo "Year";
    echo "</button>";
    echo "<ul class=\"dropdown-menu scrollable-menu\">";
    for ($i = 1990; $i <= 2022; $i++) {
    ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php
    }
    echo "</ul>";
    echo "</div>";
    echo "</div>";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>