// posted values, values to fill up our form
$name = $row['name'];
$description = $row['description'];
$price = $row['price'];
$promotion_price = $row['promotion_price'];
$manufacture_date = $row['manufacture_date'];
$expired_date = $row['expired_date'];

// bind the parameters
$stmt->bindParam(':name', $name);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':price', $price);
$stmt->bindParam(':promotion_price', $promotion_price);
$stmt->bindParam(':manufacture_date', $manufacture_date);
$stmt->bindParam(':expired_date', $expired_date);
$stmt->bindParam(':id', $id);