for ($x = 0; $x < count($order_details_id); $x++) {

if ($order_details_id[$x] != '') { ?>

    <tbody>
        <tr>
            <td scope="row"><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($price_each, ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($quantity, ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($total_amount_each, ENT_QUOTES); ?></td>
        </tr>
        </tr>
        <tr>
            <td colspan="3"><b>Grand Total Amount</b></td>
            <td><?php echo htmlspecialchars($total_amount, ENT_QUOTES); ?></td>
        </tr>
    </tbody>
<?php } ?>
<?php } ?>
<?php } ?>