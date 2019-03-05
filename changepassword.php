<?php
include 'Header.php';
include 'user.php';
Session::checkSession();
$user = new User();
?>
<?php
	if (isset($_GET['id'])) {
		$userid = (int)$_GET['id'];
	}
		$SessionId= Session::get("id");
		if ($userid != $SessionId) {
			Header("Location: index.php");
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatepass'])) {
		$updatepass = $user->updatePassword($userid, $_POST);
	}
?>

<div class="panel panel-default">
<div class="panel-heading">
	<h2>Privacy<span class="pull-right"><a class="btn btn-primary"href="Profile.php?id=<?php echo $userid ; ?>">Back</a></span></h2>

</div>
<div class="panel-body">
	<div style="max-width:600px; margin:0 auto">
		<?php 
			if (isset($updatepass)) {
				echo $updatepass;
			} 
		?>
		
	<form action="" method="POST">
		<div class="form-group">
			<label for="old_password">Old Password</label>
			<input type="password" id="old_password" name="old_password" class="form-control" value="<?php 
			?>"/>
		</div>
		<div class="form-group">
			<label for="password">New Password</label>
			<input type="password" id="password" name="password" class="form-control" value="<?php 
			 ?>"/>
		</div>
		
		<button type="submit" name = "updatepass" class="btn btn-info">Update Password</button>
		</from>
	</div>
</div>

<?php

include 'Footer.php';


?>