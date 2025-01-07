<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin']) == 0) {
    echo json_encode([]);
    exit;
}

$f1 = "00:00:00";
$from = date('Y-m-d') . " " . $f1;
$t1 = "23:59:59";
$to = date('Y-m-d') . " " . $t1;

$query = mysqli_query($con, "SELECT 
    users.name as username,
    users.email as useremail,
    users.contactno as usercontact,
    products.productName as productname,
    orders.orderDate as orderdate,
    orders.id as id 
FROM orders 
JOIN users ON orders.userId = users.id 
JOIN products ON products.id = orders.productId 
WHERE orders.orderDate BETWEEN '$from' AND '$to'");

$orders = [];
while($row = mysqli_fetch_assoc($query)) {
    $orders[] = $row;
}

echo json_encode($orders);
exit;
?>
