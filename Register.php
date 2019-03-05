<?php
include 'Header.php';

include 'User.php';
?>
<?php
	$user = new User();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
		$usrRegi = $user->userRegistration($_POST);

	}

 ?>
<div class="panel panel-default">
<div class="panel-heading"> 
	<h2>User Registration</h2>

</div>
<div class="panel-body">
	<div style="max-width:600px; margin:0 auto">
	<?php
	if (isset($usrRegi)) {
		echo $usrRegi;
	}

	?>


	<form action="" method="POST">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" id="name" name="name" class="form-control"/>
		</div>
		<div class="form-group">
			<label for="ocu">Ocupation</label>
			<input type="text" id="ocu" name="ocu" class="form-control"/>
		</div>
		<div class="form-group">
			<label for="ins">Institution</label>
			<input type="text" id="ins" name="ins" class="form-control"/>
		</div>
		<div class="form-group">
			<label for="email">Email Address</label>
			<input type="text" id="email" name="email" class="form-control"/>
		</div>
		<div class="form-group">
			<label for="birth">Date of Birth</label>
			<input type="date" id="birth" name="birth" class="form-control"/>
		</div>
		<button type="image" name="image" class="btn btn-primary">Image</button>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="text" id="password" name="password" class="form-control"/>
		</div>
		<button type="submit" name="register" class="btn btn-success">Register</button>

	</form>
	</div>
</div>




<?php

include 'Footer.php';


?>