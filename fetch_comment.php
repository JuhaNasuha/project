<?php
$connect = new PDO('mysql:host=localhost;dbname=test','root','');
$query = "SELECT * FROM comment WHERE parent= '0' ORDER BY id DESC";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$output = '';
foreach ($statement as $row) {
	$output .='<div class="panel panel-default">
	<div class="panel-heading">By <b>'.$row["author"].'</b> on <i>'.$row["date"].'</i></div>
	<div class="panel-body">'.$row["comment"].'</div>
	<div class="panel-footer" align="right">
	<button type="button" class="btn btn-default reply" id="'.$row["id"].'">Reply</button>
	</div>
	</div>';
}
echo $output;
?>