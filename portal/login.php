<?php
require_once("connect.php");
if(isset($_POST['username'])&&isset($_POST['password'])){
		$userName=$_POST['username'];
		$password=$_POST['password'];
		class USER{
		public function Login()
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT userName, password FROM `login` WHERE userName=:uname OR password=:pass ");
			$stmt->execute(array(':uname'=>$userName, ':pass'=>$password));
			$uRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
					$_SESSION['user_session'] = $uRow['ID'];
					return true;
				}
				else
				{
					return false;
				}
			}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
}
?>
<html>
<body>
<h1>Welcome </h1><br>
<div>
<h1>Login</h1><br>
<form action="<?php echo $current_file; ?>" method="POST" ">
Username:<input type="text" name="username" id="T1" placeholder="*" "><br><br>
Password:<input type="password" name="password" id="T2" placeholder="*"><br><br>
<input type="submit" value="Submit" id="b1"></input>
</form>
</body>
</html>