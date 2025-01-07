<?php 
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if(strlen($_SESSION['login']) == 0) {   
    header('location:login.php');
    exit();
}

// Assuming the username is stored in the session
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Contact Us</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
   <!--TRIED LINks-->
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/red.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<link rel="stylesheet" href="21LOGO.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		<!-- Demo Purpose Only. Should be removed in production -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("EcomClip.jpg");
            color: #333;
        }
        .navbar {
            background-color: #343a40;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin: 0 10px;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            margin-bottom:15px;
            background-color: white;
            border-radius: 18px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="index.php">Home</a>
        <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1>Contact Us</h1>
        <table class="table">
            <tr>
                <th width="200">Address</th>
                <td width="500">
                shop no. 21 upstairs <br />
                Downtown mall,<br />
                Kamwala Area,Lusaka, <br />
                    Zambia
                </td>
            </tr>
            <tr>
                <th>Contact no</th>
                <td>0777552399, 0965873686</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>cnkandu227@gmail.com</td>
            </tr>
            <tr>
    <!--21chabzyMedia links-->
<div class="row">
	<div class='box box-solid'>
	  	<div class='box-header with-border'>
	    	<h3 class='box-title'><b>Follow us on Social Media</b></h3>
	  	</div>
	  	<div class='box-body'>
	    	<a class="btn btn-social-icon btn-facebook" href="https://www.facebook.com/chabzynkandu"><i class="fa fa-facebook"></i></a>
	    	<a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
	    	<a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
	    	<a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
	    	<a class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>
	  	</div>
	</div>
</div>
<!--Media links end-->
        </tr>
        </table>
        
    </div>
</body>
</html>
