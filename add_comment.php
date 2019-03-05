<?php
$connect = new PDO('mysql:host=localhost;dbname=test','root','');
$error = '';
$comment_name = '';
$comment_content = '';
echo "I am running";
if (empty($_POST["comment_name"])) {
	$error .= '<p class="text-danger">Name is required</p>'
}
else{
	$comment_name = $_POST["comment_name"];
}
if (empty($_POST["comment_content"])) {
	$error .= '<p class="text-danger">Comment is Required</p>'
} else {
	$comment_content = $_POST["comment_content"];
}
if ($error == '') {
	$query = "INSERT INTO comment(parent, comment, author) VALUES(:parent, :comment, :author)";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':parent' => '0',
			':comment' => $comment_content,
			':author' =>$comment_name
			 )
		);
	$error = '<label class="text-success">Comment Added</label>';
}
$data = array(
'error' => $error
	);
echo json_encode($data);
?>