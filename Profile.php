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
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
		$updateusr = $user->updateUserData($userid, $_POST);
	}
?>

<div class="panel panel-default">
<div class="panel-heading">
	<h2>User Profile <span class="pull-right"><a class="btn btn-primary"href="index.php">Back</a></span></h2>

</div>
<div class="panel-body">
	<div style="max-width:600px; margin:0 auto">
		<?php 
			if (isset($updateusr)) {
				echo $updateusr;
			}
		?>
		<?php
 			$userdata = $user->getUserById($userid);
 			if ($userdata) {
		?>
	<form action="" method="POST">
		<div class="form-group">
			<label for="name">Your Name</label>
			<input type="text" id="name" name="name" class="form-control" value="<?php 
			echo $userdata->name; ?>"/>
		</div>
		<div class="form-group">
			<label for="ocu">Ocupation</label>
			<input type="text" id="ocu" name="ocu" class="form-control" value="<?php 
			echo $userdata->ocu; ?>"/>
		</div>
		<div class="form-group"> 
			<label for="ins">Institution</label>
			<input type="text" id="ins" name="ins" class="form-control" value="<?php 
			echo $userdata->ins; ?>"/>
		</div>
		<div class="form-group">
			<label for="email">Email Address</label>
			<input type="text" id="email" name="email" class="form-control" value="<?php 
			echo $userdata->email; ?>"/>
		</div>
		<div class="form-group">
			<label for="birth">Date of Birth</label>
			<input type="date" id="birth" name="birth" class="form-control" value="<?php 
			echo $userdata->birth; ?>"/>
		</div>
		<button type="image" name="image" class="btn btn-primary">Image</button>
		<?php
			$SessionId= Session::get("id");
			if ($userid == $SessionId) {
		?>
		<button type="submit" name="update" class="btn btn-info">Update</button>
		<a class="btn btn-info" href="changepassword.php?id=<?php echo $userid; ?>">Password change</a>
<?php }?>
	</form>
	<?php }?>
	</div>
</div>




<?php

include 'Footer.php';


?>