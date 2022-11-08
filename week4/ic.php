<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div class="row p-4 col-md-2">
        <?php
        $month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        ?>


        <?php
        $IC = "020720-14-1276";
        echo "$IC";
        echo "<br>";
        $DOB = substr($IC, 0, 6);
        ?>

        <?php
        //print out gender
        $g = substr($IC, -1);
        if ($g % 2 == 0) {
            echo "Mrs. <br>";
        } else {
            echo "Mr. <br>";
        }
        ?>

        <?php
        //print out month
        $icDOB = date_create_from_format("ymd", $DOB);
        echo date_format($icDOB, "M d, Y");
        echo "<br>";
        ?>


        <?php
        //print out date
        //echo substr($IC, 4, 2);
        //echo ", ";
        ?>

        <?php
        //print out year
        //$y = substr($IC, 0, 2);
        //if ($y > "22" and $y <= "99") {
        //    echo "19";
        //    echo substr($IC, 0, 2);
        //    echo "<br>";
        // } else if ($y >= "00" and $y <= "22") {
        //    echo "20";
        //    echo substr($IC, 0, 2);
        //    echo "<br>";
        // }

        //create variable for "day" 
        $d = substr($IC, 4, 2);

        //print out zodiac 
        $m = substr($IC, 2, 2);
        if ($m == "12") {
            if ($d < 22) echo "Sagittarius <img src=\"img/Sagittarius.png\" alt=\"Sagittarius\">";
            else echo "Capricornus <img src=\"Capricornus.png\" alt=\"Capricornus\">";
        } else if ($m == "01") {
            if ($d < 20) echo "Capricornus <img src=\"img/Capricornus.png\" alt=\"Capricornus\">";
            else
                echo "Aquarius <img src=\"img/Aquarius.png\" alt=\"Aquarius\">";
        } else if ($m == "02") {
            if ($d < 19) echo "Aquarius <img src=\"img/Aquarius.png\" alt=\"Aquarius\">";
            else
                echo "Pisces <img src=\"img/Pisces.png\" alt=\"Pisces\">";
        } else if ($m == "03") {
            if ($d < 21) echo "Pisces <img src=\"img/Pisces.png\" alt=\"Pisces\">";
            else
                echo "Aries <img src=\"img/Aries.png\" alt=\"Aries\">";
        } else if ($m == "04") {
            if ($d < 20) echo "Aries <img src=\"img/Aries.png\" alt=\"Aries\">";
            else
                echo "Taurus <img src=\"img/Taurus.png\" alt=\"Taurus\">";
        } else if ($m == "05") {
            if ($d < 21) echo "Taurus <img src=\"img/Taurus.png\" alt=\"Taurus\">";
            else
                echo "Gemini <img src=\"img/Gemini.png\" alt=\"Gemini\">";
        } else if ($m == "06") {
            if ($d < 21) echo "Gemini <img src=\"img/Gemini.png\" alt=\"Gemini\">";
            else
                echo "Cancer <img src=\"img/Cancer.png\" alt=\"Cancer\">";
        } else if ($m == "07") {
            if ($d < 23) echo "Cancer <img src=\"img/Cancer.png\" alt=\"Cancer\">";
            else
                echo "Leo <img src=\"img/Leo.png\" alt=\"Leo\">";
        } else if ($m == "08") {
            if ($d < 23) echo "Leo <img src=\"img/Leo.png\" alt=\"Leo\">";
            else
                echo "Virgo <img src=\"img/Virgo.png\" alt=\"Virgo\">";
        } else if ($m == "09") {
            if ($d < 23) echo "Virgo <img src=\"img/Virgo.png\" alt=\"Virgo\">";
            else
                echo "Libra <img src=\"img/Libra.png\" alt=\"Libra\">";
        } else if ($m == "10") {
            if ($d < 23) echo "Libra <img src=\"img/Libra.png\" alt=\"Libra\">";
            else
                echo "Scorpio <img src=\"img/Scorpius.png\" alt=\"Scorpio\">";
        } else if ($m == "11") {
            if ($d < 22) echo "Scorpio <img src=\"img/Scorpius.png\" alt=\"Scorpio\">";
            else
                echo "Sagittarius <img src=\"img/Sagittarius.png\" alt=\"Sagittarius\">";
        }
        ?>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>