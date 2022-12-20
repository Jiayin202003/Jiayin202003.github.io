<!DOCTYPE HTML>
<html>

<head>
    <title>Create Order</title>
</head>

<body>

    <!-- container -->
    <div class="container">

        <div class="page-header">
            <h1>Create New Order</h1>
        </div>

        <!-- html form here where the product information will be entered -->
        <form action="" method="POST">

            <table>
                <tr>
                    <th>Products</th>
                    <th>Quantity</th>
                </tr>
                <tr class="pRow">
                    <td>
                        <select class="form-select rounded" name="id[]">
                            <option value="" selected>Choose your product </option>
                            <?php if ($num > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row); ?>
                                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name, ENT_QUOTES);
                                                                        if ($promotion_price == 0) {
                                                                            echo " (RM$price)";
                                                                        } else {
                                                                            echo " (RM$promotion_price)";
                                                                        } ?></option>
                            <?php }
                            } ?>
                        </select>

                    </td>
                    <td>
                        <input type='number' name='quantity[]' class='form-control' min=1 />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="Add More" class="add_one" />
                        <input type="button" value="Delete" class="delete_one" />
                    </td>
                    <td>
                        <input type='submit' value='Order' class='btn btn-success' />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.add_one')) {
                var element = document.querySelector('.pRow');
                var clone = element.cloneNode(true);
                element.after(clone);
            }
            if (event.target.matches('.delete_one')) {
                var total = document.querySelectorAll('.pRow').length;
                if (total > 1) {
                    var element = document.querySelector('.pRow');
                    element.remove(element);
                }
            }
        }, false);
    </script>
</body>

</html>