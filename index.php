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
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post'])) {
		$postdata = $user->savePostData($_POST);

	}

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
	<?php
	if (isset($postdata)) {
		echo $postdata;
	}

	?>
	<br>
	<h5><b>POSTS</b></h>
	<br><br>
	<?php
		$catdata = $user->getCategoryData();
		$getdata = $user->getPostData();
	?>

	<div class="form-group">
		<form action="" method="POST">
			<select name="category" class="form-control">
				<option>- Category -</option>
				<?php
					foreach ($catdata as $data) {
				?>
				<option value="<?php echo $data['name']; ?>"><?php echo $data['name']; ?></option>
				<?php }?>
			</select>
			
			</div>
			<div class="form-group">
				<br>
			<label>YOUR POST</label>
			

			<textarea rows="4" id="post" name="content" placeholder="Write here" class="form-control"></textarea>

			</div>
			<div class="form-group"><br>
				<button type="submit" name="post" class="btn btn-success">POST</button>
			</div>
	   </from>
<div class="wrapper">
	
		<?php
			foreach ($getdata as $data) { ?>
		<div class="page-data">
			<h3>
				<?php echo $data['category']; ?>
			</h3>
			<p>
				<?php echo $data['content']; ?>
			</p>
		</div>
		
		<div class="comment-wrapper">
			<h3 class="comment-title">User feedback</h3>
			<div class="comment-list">
				<form method="POST" id="comment_form">
				<ul class="comments-holder-ul">
				<input type="text" id="comment_name" name="comment_name" class="form-control" placeholder="Enter Name"/>
				<textarea rows="2" id="comment_content" name="comment_content" class="form-control" placeholder="Write a Comment"></textarea>
				<input type="submit" name="submit" id="submit" value="submit" class="btn btn-info" value="submit"/>
				<span id="Comment_massage"></span>
				<li class="comment-holder" id="display_comment"></li>



				</ul>
				</form>
			</div>
		</div>
		<?php } ?>
</div>
<script>
$(document).ready(function(){
	$('comment_form').on('submit',function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		console.log("i am from comment submit");
		$.ajax({
			url:"add_comment.php",
			method:"POST",
			data:form_data,
			dataType:"JSON",
			success:function(data)
			{
				if (data.error !='') {
					$('#comment_form')[0].reset();
					$('#Comment_massage').html(data.error);
				}

			}
		})
	});
	load_comment(); 
	function load_comment(){
		$.ajax({
			url:"fetch_comment.php",
			method: "POST",
			success:function(data)
			{
				$('#display_comment').html(data);
			}
		})
	}

});

</script>

<?php

include '../controller/Footer.php';

?>