<?php
include '../controller/Header.php';

include '../controller/User.php';
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
<div class="panel-body">
	<table class = "table table-striped">
		<th width="20%">Serial</th>
		<th width="20%">Name</th>
		<th width="20%">Email</th>
		<th width="20%">ocupation</th>
		<th width="20%">institution</th>
		<th width="10%">Action</th>
		<?php
		$user =new User();
		$userdata = $user->getUserData();
		if ($userdata) {
			$i=0;
			foreach ($userdata as $data) {
				$i++;
		?>


		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $data['name']; ?></td>
			<td><?php echo $data['email']; ?></td>
			<td><?php echo $data['ocu']; ?></td>
			<td><?php echo $data['ins']; ?></td>
			<td>
				<a class="btn btn-primary" href="../controller/Profile.php?id=<?php echo $data['Id'];?>">View</a>
			</td>
		</tr>
<?php }}else{ ?>
<tr><td colspan="5"><h2>No user data found.........</h2></td></tr>
	<?php } ?>
	</table>

</div>


<?php

include '../controller/Footer.php';

?>