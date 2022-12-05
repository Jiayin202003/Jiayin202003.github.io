<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table class='table table-hover table-responsive table-bordered mb-5'>
        <div class="row">
            <label class="order-form-label">Username</label>
        </div>

        <div class="col-6 mb-2">
            <span class="error"><?php echo $userErr; ?></span>
            <select class="form-select" name="customer_id" aria-label="form-select-lg example">
                <opyion selected>Choose Username</option>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row); ?>
                        <option value="<?php $customer_id; ?>"><?php echo htmlspecialchars($username, ENT_QUOTES); ?></option>
                    <?php }
                    ?>

            </select>
        </div>
    </table>
</form>