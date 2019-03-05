<?php
include 'Header.php';
include 'User.php';
Session::checkLogin();

?>
<?php
	$user = new User();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Login'])) {
		$usrLogin = $user->userLogin($_POST); 
	}

 ?>

<div class="panel panel-default">
<div class="panel-heading">
	<h2>User Log In</h2>

</div>

<div class="panel-body">
	<div style="max-width:600px; margin:0 auto">
	<?php
	if (isset($usrLogin)) {
		echo $usrLogin;
	}
	?>
	<form action="" method="POST">
		<div class="form-group">
			<label for="email">User Id/Email Address</label>
			<input type="text" id="email" name="email" class="form-control"/>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" id="password" name="password" class="form-control"/>
		</div>
		<button type="submit" name="Login" class="btn btn-success">LogIn</button>

	</form>
	</div>
</div>


<?php

include 'Footer.php';


?>