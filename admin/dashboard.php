<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
} else { 
//Dashboard COunt
$ret = mysqli_query($con, "
    SELECT 
        COUNT(id) AS totalorders,
        COUNT(IF(orderStatus = '' OR orderStatus IS NULL, 1, NULL)) AS neworders,
        COUNT(IF(orderStatus = 'Pending', 1, NULL)) AS neworders,
        COUNT(IF(orderDate BETWEEN CURDATE() AND CONCAT(CURDATE(), ' 23:59:59'), 1, NULL)) AS todayorders,
        COUNT(IF(orderStatus = 'Packed', 1, NULL)) AS packedorders,
        COUNT(IF(orderStatus = 'Dispatched', 1, NULL)) AS dispatchedorders,
        COUNT(IF(orderStatus = 'In Transit', 1, NULL)) AS intransitorders,
        COUNT(IF(orderStatus = 'Out For Delivery', 1, NULL)) AS outfdorders,
        COUNT(IF(orderStatus = 'Delivered', 1, NULL)) AS deliveredorders,
        COUNT(IF(orderStatus = 'Cancelled', 1, NULL)) AS cancelledorders
    FROM orders
");
$results = mysqli_fetch_array($ret);
$torders = $results['totalorders'];
$norders = $results['neworders'];
$todayorders = $results['todayorders'];
$porders = $results['packedorders'];
$dtorders = $results['dispatchedorders'];
$intorders = $results['intransitorders'];
$otforders = $results['outfdorders'];
$deliveredorders = $results['deliveredorders'];
$cancelledorders = $results['cancelledorders'];

//COde for Registered users
$ret1=mysqli_query($con,"select count(id) as totalusers from users;");
$results1=mysqli_fetch_array($ret1);
$tregusers=$results1['totalusers'];
//CODE FOR TOTAL REVENUE
$ret_total_amount = mysqli_query($con, "
    SELECT SUM(products.productPrice * orders.quantity) AS totalamount
    FROM orders
    JOIN products ON orders.productId = products.id
    WHERE orders.orderStatus = 'Delivered'
");
$result_total_amount = mysqli_fetch_array($ret_total_amount);
$total_amount = $result_total_amount['totalamount'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shooping Portal | Admin Dashboard</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script>
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseover', () => {
            card.style.cursor = 'pointer';
        });
    });
});


</script>
<style>
/* Dashboard Container Styling */
.dashboard-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    justify-content: space-between;
    padding: 20px;
}

.card {
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.card-body {
    padding: 10px;
}

.card-footer {
    padding: 15px;
    text-align: center;
}

.bg-primary {
    background-color: #071d35 !important;
}

.bg-danger {
    background-color:#b62948 !important;
}

.bg-success {
    background-color: #094d31 !important;
}

.bg-black {
    background-color: #071d35  !important;
}

.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}

/* Adjust Text and Card Sizes */
.text-lg {
    font-size: 25px;
    font-weight: bold;
    color:white
  
}

.dashboard-title {
    font-size: 15px;
    margin-bottom: 20px;
    text-align: center;
    color: white;
}
.linkButton {
    background-color:lightblue;
    text-align: center;
    padding:5px 10px;
    text-decoration:none;
    display:inline-block;
    border-radius:15px;
    color:black;
}

</style>
<!---AJAX-->
<script>
    function fetchNewOrders() {
        $.ajax({
            url: 'fetch_dashboard_orders.php', // Endpoint to fetch new orders count
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Update the New Orders card with the new count
                $('.new-orders-count').text(data.newOrders);
            },
            error: function(err) {
                console.error('Error fetching new orders:', err);
            }
        });
    }

    // Fetch New Orders every 30 seconds
    setInterval(fetchNewOrders, 30000); // 30 seconds
    $(document).ready(fetchNewOrders); // Fetch immediately on page load
</script>
<!--SoundJavascript-->
<script>
    // Keep track of the previous count of new orders
    let previousNewOrders = <?php echo $todayorders; ?>; 

    function playAlarmSound() {
        const audio = new Audio('sounds/alarm.ogg');
        audio.play();
    }

    function fetchNewOrders() {
        $.ajax({
            url: 'fetch_dashboard_orders.php', // Endpoint to fetch new orders count
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const newOrdersCount = data.newOrders;

                // Update the New Orders card
                $('.new-orders-count').text(newOrdersCount);

                // Check if there's an increase in new orders
                if (newOrdersCount > previousNewOrders) {
                    playAlarmSound(); // Play alarm sound
                }

                // Update the previous count
                previousNewOrders = newOrdersCount;
            },
            error: function(err) {
                console.error('Error fetching new orders:', err);
            }
        });
    }

    // Fetch New Orders every 30 seconds
    setInterval(fetchNewOrders, 30000); // 30 seconds
    $(document).ready(fetchNewOrders); // Fetch immediately on page load
</script>



    </head>
    <body class="sb-nav-fixed">
    <?php include('include/header.php');?>
    <div class="wrapper">
		<div class="container">
			<div class="row">
        <?php include('include/sidebar.php');?>	
        <div class="span9">
					<div class="content">

	<div class="module">
							<div class="module-head">
								<h3>Dashboard</h3>
							</div>
           
                            <div class="dashboard-container">
    <!-- Total Orders -->
    <div class="card bg-primary text-white">
        <div class="card-body">
            <div class="dashboard-title">Total Orders</div>
            <div class="text-lg fw-bold"><?php echo $torders; ?></div>
        </div>
        
    </div>
<!-- Total Revenue -->
<div class="card bg-primary text-white">
    <div class="card-body">
        <div class="dashboard-title mt-3">Total Revenue</div>
        <div class="text-lg fw-bold">K <?php echo number_format($total_amount, 2); ?></div>
    </div>
    <div class="card-footer">
        <a class="linkButton" href="payment-records.php">View Payment Records</a>
    </div>
</div>


    <!-- New Orders -->
    <div class="card bg-danger text-white">
    <div class="card-body">
        <div class="dashboard-title">New Orders</div>
        <div class="text-lg fw-bold new-orders-count"><?php echo $todayorders; ?></div>
    </div>
    <div class="card-footer">
        <a class="linkButton" href="todays-orders.php">View Details</a>
    </div>
</div>




    
    <!-- Delivered Orders -->
<div class="card bg-success text-white">
    <div class="card-body">
        <div class="dashboard-title">Delivered Orders</div>
        <div class="text-lg fw-bold"><?php echo $deliveredorders; ?></div>
        
    </div>
    <div class="card-footer">
        <a class="linkButton" href="delivered-orders.php">View Details</a>
    </div>
</div>


    <!-- Registered Users -->
    <div class="card bg-black text-white">
        <div class="card-body">
            <div class="dashboard-title">Registered Users</div>
            <div class="text-lg fw-bold"><?php echo $tregusers; ?></div>
        </div>
        <div class="card-footer">
            <a class="linkButton" href="manage-users.php">View Requests</a>
        </div>
    </div>

    <!-- Cancelled Orders -->
    <div class="card bg-danger text-white">
        <div class="card-body">
            <div class="dashboard-title">Cancelled Orders</div>
            <div class="text-lg fw-bold"><?php echo $cancelledorders; ?></div>
        </div>
        <div class="card-footer">
            <a class="linkButton" href="cancelled-orders.php">View Details</a>
        </div>
    </div>
</div>

                                  




                    </div>
                </main>
   <?php include_once('includes/footer.php');?>
            </div>
        </div>
        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
    </body>
</html>
<?php } ?>
