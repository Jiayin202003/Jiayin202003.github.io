<!doctype html>
<html lang="en">

<head>
    <title>Date_today</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>

    </style>
</head>

<body>
    <?php date_default_timezone_set("Asia/Kuala_Lumpur"); ?>

    <div class="row justify-content-center p-5">
        <div class="col-2 ">
            <select class="form-select form-select-lg mb-3 bg-info text-light " aria-label=".form-select-lg example">
                <option selected>
                    <?php echo date("d"); ?>
                </option>

                <?php
                for ($i = 1; $i <= 31; $i++) {
                ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>

                <?php
                }
                ?>

            </select>
        </div>

        <div class="col-2 ">
            <select class="form-select form-select-lg mb-3 bg-warning text-light " aria-label=".form-select-lg example">
                <option selected>
                    <?php echo date("F"); ?>
                </option>

                <?php
                $months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November",  "December");
                foreach ($months as $m) {
                    echo "<option value=\"" . $m . "\">" . $m . "</option>";
                }
                ?>

            </select>
        </div>

        <div class="col-2 ">
            <select class="form-select form-select-lg mb-3 bg-danger text-light " aria-label=".form-select-lg example">
                <option selected>
                    <?php echo date("Y"); ?>
                </option>

                <?php
                for ($y = 1900; $y <= 2022; $y++) {
                ?>
                    <option value="<?php echo $y; ?>"><?php echo $y; ?></option>

                <?php
                }
                ?>

            </select>
        </div>
    </div>

</body>

</html>