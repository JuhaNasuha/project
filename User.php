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
		$password=md5($data['password']);
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
}

?>