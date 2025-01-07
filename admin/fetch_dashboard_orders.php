<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    echo json_encode(['newOrders' => 0]);
    exit;
}

// Get today's new orders count
$ret = mysqli_query($con, "
    SELECT COUNT(IF(orderDate BETWEEN CURDATE() AND CONCAT(CURDATE(), ' 23:59:59'), 1, NULL)) AS todayorders
    FROM orders
");
$result = mysqli_fetch_array($ret);
$todayOrders = $result['todayorders'] ?? 0;

// Return the count as JSON
echo json_encode(['newOrders' => $todayOrders]);
exit;
?>
