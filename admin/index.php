<?php
session_start();
error_reporting(0);
include("include/config.php");
if(isset($_POST['submit']))
{
	$username=$_POST['username'];
	$password=md5($_POST['password']);
$ret=mysqli_query($con,"SELECT * FROM admin WHERE username='$username' and password='$password'");
$num=mysqli_fetch_array($ret);
if($num>0)
{
$extra="change-password.php";
$_SESSION['alogin']=$_POST['username'];
$_SESSION['id']=$num['id'];

header("location:dashboard.php");
exit();
}
else
{
$_SESSION['errmsg']="Invalid username or password";
header("location:index.php");
exit();
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Twenty-one stores | Admin login</title>
	<link type="text/css" href="css/logincss.css"  rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body  >

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="login-container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="../index.php">
				  <h3>Twenty-<span style="font-weight:1;">one </span>stores&trade;</h3>
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
				
					<ul class="nav pull-right">

						<li><a href="http://localhost/shopping/">
						Back to Portal
						
						</a></li>

						

						
					</ul>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->



	<div class="wrapper" style="background-color: #031d14b5;">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4" style=" background-color: #97aeaab5;
    
    border-radius: 5px;
    ">
					<form class="form-vertical" method="post">
						<div class="module-head">
							<h2>Sign In</h2>
						</div>
						<span style="color:red;" ><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="text" id="inputEmail" name="username" placeholder="Username">
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
						<input class="span12" type="password" id="inputPassword" name="password" placeholder="Password">
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" class="btn btn-primary pull-right" name="submit">Login</button>
									
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			 

			<b class="copyright"> <span>Twenty-<span style="font-weight:1;">one </span>stores&trade;</span></h3></b>
		</div>
	</div>
	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>