<!DOCTYPE html>

<html>

<body>
    <div class="timezone">

        <?php
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $t = date("H");
        echo $t . "<br>";

        if ($t >= "06" and $t < "12") {
            echo "Good Morning";
        } else if ($t >= "12" and $t < "18") {
            echo "Good Afternoon";
            if ($t == "12") {
                echo "lunch time";
            }
        } else {
            echo "Good Night";
        }
        ?>
    </div>
</body>



</html>