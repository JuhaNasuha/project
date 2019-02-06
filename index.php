<?php
include '../controller/Header.php';
include 'user.php';
Session::checkSession();
$user = new User();

?>
<?php
	$loginmsg = Session::get("loginmsg");
	if (isset($loginmsg)) {
		echo $loginmsg;
	}
	Session::set("loginmsg",Null);

	?>

<div class="panel panel-default">
<div class="panel-heading">
	<h3>Welcome to Query Desk!<span class="pull-right">Get Register First</span></h3>
	<?php
		$name = Session::get("name");
		if (isset($name)) {
			echo $name;
		}
	?>
</div>
<div class="panel-body">
	

</div>


<?php

include '../controller/Footer.php';

?>