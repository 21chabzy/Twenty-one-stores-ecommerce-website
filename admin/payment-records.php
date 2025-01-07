<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Payment Records</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    </head>
    <body>
    <?php include('include/header.php'); ?>

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php include('include/sidebar.php'); ?>
                <div class="span9">
                    <div class="content">

                        <div class="module">
                            <div class="module-head">
                                <h3>Payment Records</h3>
                            </div>
                            <div class="module-body">
                                
                                
                                <!-- Download Button -->
                                <a href="download-payment-records.php" class="btn btn-success pull-right" style="margin-top: 20px;">Download PDF</a>

                                <br /><br />

                                <div class="table-responsive">
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display">
                                        <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Username</th>
                                            <th>Product</th>
                                            <th>Payment Method</th>
                                            <th>Payment Date</th>
                                            <th>Grand Total</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $search_query = isset($_GET['search_query']) ? mysqli_real_escape_string($con, $_GET['search_query']) : '';

                                        // Base query
                                        $query = "SELECT orders.id as oid, users.name as username, products.productName as productname, 
                                                  orders.paymentMethod as paymentmethod, orders.orderDate as paymentdate, 
                                                  (orders.quantity * products.productPrice + products.shippingCharge) as grandtotal 
                                                  FROM orders 
                                                  JOIN users ON orders.userId = users.id 
                                                  JOIN products ON orders.productId = products.id";

                                        // Add search condition
                                        if (!empty($search_query)) {
                                            $query .= " WHERE users.name LIKE '%$search_query%' 
                                                        OR orders.paymentMethod LIKE '%$search_query%' 
                                                        OR DATE_FORMAT(orders.orderDate, '%Y-%m-%d') LIKE '%$search_query%'";
                                        }

                                        // Execute the query
                                        $result = mysqli_query($con, $query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row['oid']); ?></td>
                                                    <td><?php echo htmlentities($row['username']); ?></td>
                                                    <td><?php echo htmlentities($row['productname']); ?></td>
                                                    <td><?php echo htmlentities($row['paymentmethod']); ?></td>
                                                    <td><?php echo htmlentities($row['paymentdate']); ?></td>
                                                    <td><?php echo htmlentities($row['grandtotal']); ?></td>
                                                    <td>
                                                        <a href="order-details.php?oid=<?php echo htmlentities($row['oid']); ?>" class="btn btn-info">View</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No payment records found.</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->

    <?php include('include/footer.php'); ?>

    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/datatables/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('.datatable-1').dataTable();
            $('.dataTables_paginate').addClass("btn-group datatable-pagination");
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        });
    </script>
    </body>
    </html>
    <?php
}
?>
