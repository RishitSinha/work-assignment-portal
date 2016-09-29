<?php
try {
	$connect = new PDO('mysql: host=127.0.0.1;dbname=portal','root','');
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $exception) {
echo $exception->getMessage();
die();
}
/*class workPortal {
public $userName, $fullName, $work,$message, $head, $subhead;
public function __construct(){
			if($this->userName=="head"){
			$this->head="{$this->fullName}";
		}
			if($this->userName=="subhead")
			{
				$this->subhead="{$this->fullName}";	
			}
}
}
class workAssign extends workPortal{
	public function __construct(){
		parent::__construct();
		$this->message="{$this->head} assigned {$this->work} to {$this->subhead}" ;
	}
}
if(isset($_POST['username'])&&isset($_POST['password'])){
	$By=$_POST['username'];
	$To=$_POST['password'];
$query=$connect->query('SELECT * FROM `login`,`detail` WHERE `ID`="$By" OR `ID`="$To"');
$query->setFetchMode(PDO::FETCH_CLASS, 'workAssign');
while($r=$query->fetch()){
echo $r->message, '<br>';
}
}
?>
<html>
<body>
<h1>Welcome </h1><br>
<div>
<h1>Login</h1><br>
<form action="connect.php" method="POST" ">
Username:<input type="text" name="username" id="T1" placeholder="*""><br><br>
Password:<input type="password" name="password" id="T2" placeholder="*"><br><br>
<input type="submit" value="Submit" id="b1"></input>
</form>
</div>
</body>
</html>
*/