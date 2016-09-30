<?php

require_once('dbconfig.php');

class TASK
{	

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

	private function engage($uname){
		try
		{
			$stmt = $this->conn->prepare("UPDATE user SET engaged = '1' WHERE user_id = :uname");

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
			$stmt = $this->conn->prepare("UPDATE user SET engaged = '0' WHERE user_id = :uname");

			$stmt->bindparam(":uname",$uname);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	private function createCardsForAssigned()
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user.full_name, task.task_desc, task.completed, task.date_completed, user.user_id FROM  task JOIN user on (user.user_id = task.task_for) WHERE task.completed='0' AND user.head='0'");
			$stmt->execute();
			if($stmt->rowCount()){
				while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
					echo "
					<div class='col l4'>
						<div class='card'>
				          <div class='card blue darken-3'>
				            <div class='card-content white-text'>
				              <span class='card-title'>$taskRow->full_name</span>
				              <p>$taskRow->task_desc</p>
				            </div>
				            <div class='card-action blue darken-4'>

				            <button name='edit'  class='waves-effect waves-light deep-purple darken-2 btn edit' id='edit".$taskRow->user_id."' onclick='showEdit(".$taskRow->user_id.")'>Edit</button>
							

							<div id='editForm".$taskRow->user_id."' class='editForm'  style='display:none;'>

								<form method='post'>

									<h4 class='form-signin-heading' style='color:#673ab7;'>Edit</h4>

									<input type='text' class='form-control' name='txt_shid' value='".$taskRow->user_id."' style='display:none;' />		


									<input type='text' class='form-control' name='txt_task' value='".$taskRow->task_desc."' />


									<input type='date' class='datepicker' name='txt_date' value='".$taskRow->date_completed."'/>

									<button type='submit' name='btn-save' class='waves-effect waves-light deep-purple darken-2 btn'>
									    Save
									</button>

									<button name='btn-delete'  class='waves-effect waves-light deep-purple darken-2 btn'>
										Delete
									</button>

								</form>
							</div>	






				            </div>
				          </div>
			        	</div>
		        	</div>
		        	";
				}
			}
		}

		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}

	private function createCardsForAvailable()
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT full_name, user_id FROM user WHERE engaged='0' AND head='0'");
			$stmt->execute();
			if($stmt->rowCount()){
				while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){	
					echo "
					<div class='col l4'>
						<div class='card'>
				          <div class='card blue darken-3'>
				            <div class='card-content white-text'>
				              <span class='card-title'>$taskRow->full_name</span>
				              <p>No Current Assignments</p>
				            </div>

				            <div class='card-action blue darken-4'>

				               <button name='assign'  class='waves-effect waves-light deep-purple darken-2 btn assign".$taskRow->user_id."' onclick='showAssign(".$taskRow->user_id.")'>Assign</button>
								

								<div id='assignForm".$taskRow->user_id."' class='assignForm' style='display:none;'>
									<form method='post'>

									<h4 class='form-signin-heading' style='color:#673ab7;'>Assign</h4>

									<input type='text' class='form-control' name='txt_shid' value='".$taskRow->user_id."' style='display:none;' />		


									<input type='text' class='form-control' name='txt_task' placeholder='Task' />


									<input type='date' class='datepicker' name='txt_date' placeholder='Date' />

									<button type='submit' name='btn-assign' class='waves-effect waves-light deep-purple darken-2 btn'>
									    Assign
									</button>

									</form>
								</div>
				              


				            </div>
				          </div>
			        	</div>
		        	</div>
		        	";
				}
			}
		}

		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}

	public function createCards(){
		$this->createCardsForAssigned();
		$this->createCardsForAvailable();
	}



	// public function busy($shname){
	// 		try
	// 	{
	// 		$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc , user.full_name FROM task JOIN user on (user.user_id = task.task_by) WHERE task.task_for='$shname' AND task.completed=0");
	// 		$stmt->execute();
	// 		$taskRow=$stmt->fetch(PDO::FETCH_OBJ);
	// 		if($taskRow){
	// 		return true;
	// 	}
	// 	else {
	// 		return false;
	// 	}
	// 	}
	// 	catch(PDOException $e)
	// 	{
	// 		echo $e->getMessage();
	// 	}
	// }


	// public function getMyTasks($shname)
	// {
	// 	try
	// 	{
	// 		$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc , user.full_name FROM task JOIN user on (user.user_id = task.task_by) WHERE task.task_for='$shname' AND task.completed=0");
	// 		$stmt->execute();
	// 		$taskRow=$stmt->fetch(PDO::FETCH_OBJ);
	// 		if($taskRow){
	// 		echo $taskRow->full_name." assigned the task: ".$taskRow->task_desc, '<br>';
	// 	}
	// 	}
	// 	catch(PDOException $e)
	// 	{
	// 		echo $e->getMessage();
	// 	}
	// }


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

	public function assignTask($hname, $shid, $task, $adate, $ddate)
	{

		try
		{
			$stmt = $this->conn->prepare("INSERT INTO task(task_by,task_for,task_desc,date_assigned,date_completed) 
		                                               VALUES(:hname, :shid, :task, :adate, :ddate)");
				  
			$stmt->bindparam(":hname", $hname);
			$stmt->bindparam(":shid", $shid);
			$stmt->bindparam(":task", $task);
			$stmt->bindparam(":adate", $adate);
			$stmt->bindparam(":ddate", $ddate);
													  
				
			$stmt->execute();
			$this->engage($shid);
			return $stmt;
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function editTask($task,$shid,$ddate)
	{

		try  
		{
			$stmt = $this->conn->prepare("UPDATE task SET task_desc=:task, date_completed=:ddate WHERE task_for=:shid AND completed=0");
												  
			$stmt->bindparam(":task", $task);
			$stmt->bindparam(":shid", $shid);
			$stmt->bindparam(":ddate", $ddate);

			$stmt->execute();
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