<?php
include_once 'Session.php';
include 'Database.php';


class User  
{ 
	private $db;
	public function __construct()
	{ 
		$this->db = new Database();

	}
	public function userRegistration($data)
	{
		$name=$data['name'];
		$ocu=$data['ocu'];
		$ins=$data['ins'];
		$email=$data['email'];
		$birth=$data['birth'];
		$password=$data['password'];
		$chk_email=$this->emailCheck($email);


		if ($name == "" OR $ocu =="" OR $ins=="" OR $email == "" OR $birth == "" OR $password == "") {
			$msg ="<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
			return $msg;
		}
		if (strlen($name) < 3) {
			$msg = "<div class='alert alert-danger'><strong>Error !</strong>Name is too short</div>";
		return $msg;
		}elseif (preg_match('/[^a-z0-9_-]+/i', $name)) {
			$msg = "<div class='alert alert-danger'><strong>Error !</strong>Name must only contain alphanumerical, dashes and underscores</div>";
		return $msg;
		}
		if (filter_var($email,FILTER_VALIDATE_EMAIL)===False) {
		$msg = "<div class= 'alert alert-danger'><stong>Error ! </strong> the email address is not valid !</div> ";
		return $msg ;

		}
		if ($chk_email == true) {
			$msg = "<div class='alert alert-danger'><strong> Error !</strong>The email address already exist !</div>";
			return $msg;
		}
		$password=md5($data['password']);

		$sql = "INSERT INTO info (name,ocu,ins,email,birth,password) VALUES(:name,:ocu,:ins,:email,:birth,:password)";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':name',$name);
		$query->bindValue(':email',$email);
		$query->bindValue(':ocu',$ocu);
		$query->bindValue(':ins',$ins);
		$query->bindValue(':birth',$birth);
		$query->bindValue(':password',$password);
		$result=$query->execute();
		if ($result) {
			$msg = "<div class='alert alert-success'><strong>Success !</strong> Thank you,You have been Registerd. </div>";
			return $msg;
		}else{
			$msg ="<div class='alert alert-danger'><strong>There has been problem inserting your details.</strong></div>";
			return $msg;

		}
	}
	public function emailCheck($email){
		$sql = "SELECT email FROM info WHERE email = :email";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':email', $email);
		$query->execute();
		if ($query->rowCount()>3) {
			return true;
		}else{
			return false;
		}
	}


	public function getLoginUser($email,$password){
		$sql = "SELECT * FROM info WHERE email = :email AND password=:password LIMIT 1";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':email', $email);
		$query->bindValue(':password', $password);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		return $result;
	}


	public function userLogin($data)
	{

		$email=$data['email'];
		$password=md5($data['password']);
		$chq_email=$this->mailCheck($email);


		if ($email == "" OR $password == "") {
			$msg ="<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
			return $msg;
		}
		if (filter_var($email,FILTER_VALIDATE_EMAIL)===False) {
			$msg = "<div class= 'alert alert-danger'><stong>Error ! </strong> the email address is not valid !</div> ";
			return $msg ;

		}
		if ($chq_email == true) {
			$msg = "<div class='alert alert-danger'><strong> Error !</strong>Wrong email address  !</div>";
			return $msg;
		}
		$result = $this->getLoginUser($email, $password);

		

		if($result) {
			Session::init();
			Session::set("Login", true);
			Session::set("email", $result->email);
			Session::set("name", $result->name);
			Session::set("id", $result->Id);
			Session::set("Loginmsg", "<div class='alert alert-success'><strong>
				Success!</strong>You are logged in!</div>");
			header("Location: index.php");
			}else{
				$msg="<div class='alert alert-danger'><strong>Error!</strong>Data not found!</div>";
				return $msg;
			}
	}

	public function mailCheck($email){
		$sql = "SELECT email FROM info WHERE email = :email";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':email', $email);
		$query->execute();
		
		if ($query->rowCount()<0) {
			return true;
		}else{
			return false;
		}
	}
	public function getUserData(){
		$sql = "SELECT * FROM info ORDER BY Id";
		$query = $this->db->pdo->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}
	public function getUserById($id){
		$sql = "SELECT * FROM info WHERE Id=:Id LIMIT 1";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':Id', $id);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		return $result;
	}
	public function updateUserData($id, $data){
		$name  = $data['name'];
		$ocu   = $data['ocu'];
		$ins   = $data['ins'];
		$email = $data['email'];
		$birth = $data['birth'];
		 if ($name == "" OR $ocu =="" OR $ins=="" OR $email == "" OR $birth == "" ) {
			$msg ="<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
			return $msg;
		}
		$sql = "UPDATE info set
				name  = :name,
				email = :email,
				ocu   = :ocu,
				ins   = :ins,
				birth = :birth
				WHERE Id = :id ";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':name',$name);
		$query->bindValue(':email',$email);
		$query->bindValue(':ocu',$ocu);
		$query->bindValue(':ins',$ins);
		$query->bindValue(':birth',$birth);
		$query->bindValue(':id',$id);
		$result=$query->execute();
		if ($result) {
			$msg = "<div class='alert alert-success'><strong>Success !</strong> User Data Updated Successfully. </div>";
			return $msg;
		}else{
			$msg ="<div class='alert alert-danger'><strong>Not Updated.</strong></div>";
			return $msg;

			}
		}
		private function CheckPassword($id, $old_password){
			$password = md5($old_password);
			$sql = "SELECT password FROM info WHERE Id=:id AND password = :password  " ;
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':id', $id);
			$query->bindValue(':password', $password);
			$query->execute();
			if ($query->rowCount()>0) {
				return true;
			}else{
				return false;
			}

		}
		public function updatePassword($id, $data){
			$old_password = $data['old_password'];
			$new_password = $data['password'];
			$chk_pass = $this->CheckPassword($id, $old_password);

			if($old_password == "" OR $new_password == "" ){
				$msg = "<div class='alert alert-danger'><strong>Error !</strong>Field must not be empty. </div>";
				return $msg;
			}
			if ($chk_pass == false) {
			 	$msg = "<div class='alert alert-danger'><strong>Error !</strong>password not exist . </div>";
			 	return $msg;
			}
			if (strlen($new_password) < 6) {
			 	$msg = "<div class='alert alert-danger'><strong>Error !</strong>password is too short. </div>";
			 	return $msg;
			}
			$password = md5($new_password);
			$sql = "UPDATE info set
					password = :password
					WHERE Id = :id ";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':password',$password);
			$query->bindValue(':id',$id);
			$result=$query->execute();
			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Success !</strong> Password Updated Successfully. </div>";
				return $msg;
			}else{
				$msg ="<div class='alert alert-danger'><strong>Password Not Updated.</strong></div>";
				return $msg;

				}
		}

	
	public function userCategory($data){
		$name=$data['name'];
		if ($name == "" ) {
			$msg ="<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
			return $msg;
		}
		$sql = "INSERT INTO category(name) VALUES(:name)";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':name',$name);
		$result=$query->execute();
		if ($result) {
			$msg = "<div class='alert alert-success'><strong>Success !</strong> Thank you,New Category saved. </div>";
			return $msg;
		}else{
			$msg ="<div class='alert alert-danger'><strong>There has been problem.</strong></div>";
			return $msg;

		}
	}
	public function getCategoryData(){
		$sql = "SELECT * FROM category ORDER BY id";
		$query = $this->db->pdo->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}
	public function savePostData($data){
		$category=$data['category'];
		$content=$data['content'];
		if ($category == "" OR $content =="") {
			$msg ="<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
			return $msg;
		}
		$sql = "INSERT INTO post(category,content) VALUES(:category,:content)";
		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':category',$category);
		$query->bindValue(':content',$content);
		$result=$query->execute();
		if ($result) {
			$msg = "<div class='alert alert-success'><strong>Success !</strong> Thank you,Your post have taken. </div>";
			return $msg;
		}else{
			$msg ="<div class='alert alert-danger'><strong>There has been problem.</strong></div>";
			return $msg;

		}
	}
	public function getPostData(){
		$sql = "SELECT * FROM post ORDER BY id";
		$query = $this->db->pdo->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}
}
?>