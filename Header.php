<?php
	$filepath =realpath(dirname(__FILE__));
	include_once $filepath.'/Session.php';
	Session::init();
?>
<!doctype html>
<html>
<head>
<title>stack over flow</title>
<link rel="stylesheet" type="text/css" href="../includes/css/bootstrap.min.css"/>
<script src="../includes/js/bootstrap.min.js"></script>
<script src="../includes/jquery.min.js"></script>
</head>
<?php
if (isset($_GET['action']) && $_GET['action']=="Logout"){
	Session::destroy();
}

?>

<body>

	<div class= "container" >
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class ="navbar-brand" href="index.php"><strong>Query Desk</strong></a>
			</div>
			<ul class="nav navbar-nav pull-right">
				<?php
					$id = Session_get("id");
					$userLogin== Session::get("Login");
					if ($userLogin == true) {
				?>
				<li><a href="Profile.php?id=<?echo $id;?>">Profile</a></li>
				<li><a href="index.php">Logout</a></li>
				<?php }else{ ?>
				<li><a href="login.php">LogIn</a></li>
				<li><a href="register.php">Register</a></li>
				<?php } ?>


			</ul>
		</div>

	</nav>