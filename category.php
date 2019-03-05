<?php
include 'Header.php';
include 'user.php';
Session::checkSession();
$user = new User();

?>
<?php
	$loginmsg = Session::get("loginmsg");
	if (isset($loginmsg)) {
		echo $loginmsg;
	}
	Session::set("loginmsg",NULL);

	?>

<div class="panel panel-default">
<div class="panel-heading">
	<h3>Welcome to Query Desk!<span class="pull-right"><strong>Welcome!
	<?php
		$name = Session::get("name");
		if (isset($name)) {
			echo $name;   
		}
	?></strong>
</span></h3>
</div>
<?php
	$user = new User();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['category'])) {
		$usrCat = $user->userCategory($_POST);

	}

 ?>
<div class="panel-body">
<div style="max-width:600px; margin:0 auto">
	<?php
	if (isset($usrCat)) {
		echo $usrCat;
	}

	?>
	<form action="" method="POST">
		<div class="form-group">
			<label for="name">Category Name</label>
			<input type="text" id="name" name="name" class="form-control"/>
		</div>
		
		<button type="submit" name="category" class="btn btn-success">Save</button>


	</form>
	</div>
</div>


<?php

include '../controller/Footer.php';

?>