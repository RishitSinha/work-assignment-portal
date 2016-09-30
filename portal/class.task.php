<?php

require_once('dbconfig.php');

class TASK
{	

	private $conn;
	private function engage($uname){
		try
		{
			$stmt = $this->conn->prepare("UPDATE user SET engaged = '1' WHERE user_name = :uname");

			$stmt->bindparam(":uname",$uname);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	private function disengage($uname){
		try
		{
			$stmt = $this->conn->prepare("UPDATE user SET engaged = '0' WHERE user_name = :uname");

			$stmt->bindparam(":uname",$uname);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	public function getName($userid)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, full_name FROM  user  WHERE user_id=$userid ");
			$stmt->execute();
			$taskRow=$stmt->fetch(PDO::FETCH_OBJ);
			echo $taskRow->full_name;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function busy($shname){
			try
		{
			$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc , user.full_name FROM task JOIN user on (user.user_id = task.task_by) WHERE task.task_for='$shname' AND task.completed=0");
			$stmt->execute();
			$taskRow=$stmt->fetch(PDO::FETCH_OBJ);
			if($taskRow){
			return true;
		}
		else {
			return false;
		}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function getMyTasks($shname)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc , user.full_name FROM task JOIN user on (user.user_id = task.task_by) WHERE task.task_for='$shname' AND task.completed=0");
			$stmt->execute();
			$taskRow=$stmt->fetch(PDO::FETCH_OBJ);
			if($taskRow){
			echo $taskRow->full_name." assigned the task: ".$taskRow->task_desc,'<br>';
			return true;
		}
		else {
			return false;
		}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function getActiveTasks()
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc , task.task_for , user.full_name FROM task JOIN user on (user.user_id = task.task_by) WHERE task.completed=0");
			$stmt->execute();
			while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
				echo $taskRow->full_name." assigned the task: ".$taskRow->task_desc." to ".$taskRow->task_for,'<br>';
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function getCompletedTasks()
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc , task.task_for , user.user_name FROM task JOIN user on (user.user_id = task.task_by) WHERE task.completed=1");
			$stmt->execute();
			while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
				echo $taskRow->user_name." assigned the task: ".$taskRow->task_desc." to ".$taskRow->task_for,'<br>';
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function deleteTask($shname)
	{

		try
		{
			$stmt = $this->conn->prepare("DELETE FROM task WHERE task_for='$shname' AND completed=0");
			$stmt->execute();
			$this->disengage($shname);
			return $stmt;
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function assignTask($hname, $shname, $task, $adate, $ddate)
	{

		try
		{
			$stmt = $this->conn->prepare("INSERT INTO task(task_by,task_for,task_desc,date_assigned,date_completed) 
		                                               VALUES(:hname, :shname, :task, :adate, :ddate)");
												  
			$stmt->bindparam(":hname", $hname);
			$stmt->bindparam(":shname", $shname);
			$stmt->bindparam(":task", $task);
			$stmt->bindparam(":adate", $adate);
			$stmt->bindparam(":ddate", $ddate);
													  
				
			$stmt->execute();
			$this->engage($shname);
			return $stmt;
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function edit($task,$shname)
	{

		try
		{
			$stmt = $this->conn->prepare("UPDATE task(task_desc) 
		                                               VALUES(:task) WHERE task_for='$shname' AND completed=0");
												  
			$stmt->bindparam(":task", $task);

			$stmt->execute();
			$this->engage($shname);
			return $stmt;
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
}
?>