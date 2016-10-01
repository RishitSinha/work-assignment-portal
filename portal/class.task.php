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
	private function removeFromGroup($uname){
		try
		{
			$stmt = $this->conn->prepare("UPDATE task SET group_no = '0' WHERE task_for = :uname");

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
			$stmt = $this->conn->prepare("SELECT user.full_name, task.task_desc, task.completed,task.task_by, task.date_completed, user.user_id FROM  task JOIN user on (user.user_id = task.task_for) WHERE task.completed='0' AND user.head='0' AND task.group_no='0'");
			$stmt->execute();
			if($stmt->rowCount()){
				while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
					echo "
					<div class='col l4'>
						<div class='card'>
				          <div class='card blue darken-3'>
				            <div class='card-content white-text'>
				              <span class='card-title'>$taskRow->full_name</span>
				              <p>".$taskRow->task_by." Assigned task: $taskRow->task_desc</p>
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

				               <button name='assign'  class='waves-effect waves-light deep-purple darken-2 btn assign".$taskRow->user_id."' onclick='showAssign(".$taskRow->user_id.")'>Assign</button><br><br>
								

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
	private function createCardsForGroup()
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user.full_name, task.task_desc, task.completed,task.task_by, task.date_completed, user.user_id,task.group_no FROM  task JOIN user on (user.user_id = task.task_for) WHERE task.completed='0' AND user.head='0' AND task.group_no!='0'");
			$stmt->execute();
			if($stmt->rowCount()){
				while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
					echo "
					<div class='col l4'>
					Group No :".$taskRow->group_no." 
						<div class='card'>
				          <div class='card blue darken-3'>
				            <div class='card-content white-text'>
				              <span class='card-title'>$taskRow->full_name</span>
				              <p>".$taskRow->task_by." Assigned task: $taskRow->task_desc</p>
				            </div>
				            <div class='card-action blue darken-4'>
				            <form method='post'>

									<input type='text' class='form-control' name='txt_shid' value='".$taskRow->user_id."' style='display:none;' />		


									<button name='btn-delete'  class='waves-effect waves-light deep-purple darken-2 btn'>
										Remove From Group
									</button>

								</form>
							
							
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
	public function createGroup(){
		echo "<hr>";
		$this->createCardsForGroup();
	}

	public function assignInGroup(){
		try
		{
			$stmt = $this->conn->prepare("SELECT full_name, user_id FROM user WHERE engaged='0' AND head='0'");
			$stmt->execute();
			if($stmt->rowCount()){
				echo "<button name='assign'  class='waves-effect waves-light deep-purple darken-2 btn assign' onclick=showAssign('0')>Assign In Group</button><br><br>
				<div id='assignForm0' class='assignForm' style='display:none;'>
                  <form method='post'>

                  <h4 class='form-signin-heading' style='color:#673ab7;'>Assign For Group</h4>
					";
				while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){	
			echo "
                  <input type='text' class='form-control' name='txt_shid' value='$taskRow->full_name' style='display:none;' />    <input type='checkbox' id='checkbox".$taskRow->user_id."' name='checklist[]' value='".$taskRow->user_id."' class='checkbox' />
              						<label for='checkbox".$taskRow->user_id."'>".$taskRow->full_name."</label><br>
              						";
              }
              echo "
                  <input type='text' class='form-control' name='txt_task' placeholder='Task' />

                  <input type='text' class='form-control' name='txt_group' placeholder='Group No' />

                  <input type='date' class='datepicker' name='txt_date' placeholder='Date' />

                  <button type='submit' name='btn-groupassign' class='waves-effect waves-light deep-purple darken-2 btn'>
                      Assign
                  </button>

                  </form>
                </div>";
            }
        
	}
	catch(PDOException $e)
		{
			echo $e->getMessage();
		}

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


	public function getMyTasks($shid)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc ,task.date_assigned,task.date_completed,task.completed, user.full_name,user.user_id FROM task JOIN user on (user.user_id = task.task_for) WHERE task.task_for=:shid");
			$stmt->bindparam(":shid", $shid);
			$stmt->execute();
			while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
				if($taskRow->completed){
			echo "<tr style='color:green'>
	          <td data-title='assingedby'>".$taskRow->task_by."</td>
	          <td data-title='task'>".$taskRow->task_desc."</td>
	          <td data-title='Name'>".$taskRow->full_name."</td>
	          <td data-title='adate'>".$taskRow->date_assigned."</td>
	          <td data-title='ddate'>".$taskRow->date_completed."</td> 
	          <td data-title='Status'>Completed</td>

	        </tr>";
		}
		else{
			echo "<tr style='color:red'>
          <td data-title='assingedby'>".$taskRow->task_by."</td>
          <td data-title='task'>".$taskRow->task_desc."</td>
          <td data-title='Name'>".$taskRow->full_name."</td>
          <td data-title='adate'>".$taskRow->date_assigned."</td>
          <td data-title='ddate'>".$taskRow->date_completed."</td> 
          <td data-title='Status'>Not Completed</td>
          <td data-title='check'>
	            	<input type='checkbox' id='checkbox".$taskRow->user_id."' name='check' class='checkbox' />
	              		<label for='checkbox".$taskRow->user_id."'></label><br>
	           </td>
        </tr>";
			
		}}}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	
public function getChecked($shid)
{
try{
	$stmt = $this->conn->prepare("UPDATE task SET completed='1' WHERE task_for=:shid");
	$stmt->bindparam(":shid", $shid);
	$stmt->execute();
	$this->disengage($shid);

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
			$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc ,task.date_assigned,task.date_completed, task.task_for , user.full_name FROM task JOIN user on (user.full_name = task.task_by) WHERE task.completed=0");
			$stmt->execute();
			while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
				echo "<tr style='color:red'>
          <td data-title='assingedby'>".$taskRow->full_name."</td>
          <td data-title='task'>".$taskRow->task_desc."</td>
          <td data-title='Name'>".$this->getName($taskRow->task_for)."</td>
          <td data-title='adate'>".$taskRow->date_assigned."</td>
          <td data-title='ddate'>".$taskRow->date_completed."</td> 
          <td data-title='Status'>Not Completed</td>
        </tr>";
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


 		//$taskRow->full_name." assigned the task: ".$taskRow->task_desc." to ".$this->getName($taskRow->task_for),'<br>';

	private function getName($uid){
		try
		{
			$stmt = $this->conn->prepare("SELECT user.user_id, task.task_for , user.full_name FROM task JOIN user on (user.user_id = task.task_for) WHERE user.user_id =:uid");
			$stmt->bindparam(":uid", $uid);
			$stmt->execute();
		
		while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
				return $taskRow->full_name;
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
			$stmt = $this->conn->prepare("SELECT task.task_by , task.task_desc ,task.date_assigned,task.date_completed, task.task_for , user.full_name FROM task JOIN user on (user.full_name = task.task_by) WHERE task.completed=1");
			$stmt->execute();
			while($taskRow=$stmt->fetch(PDO::FETCH_OBJ)){
				echo "<tr style='color:green'>
          <td data-title='assingedby'>".$taskRow->full_name."</td>
          <td data-title='task'>".$taskRow->task_desc."</td>
          <td data-title='Name'>".$this->getName($taskRow->task_for)."</td>
          <td data-title='adate'>".$taskRow->date_assigned."</td>
          <td data-title='ddate'>".$taskRow->date_completed."</td> 
          <td data-title='Status'>Completed</td>
        </tr>";
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
			$this->removeFromGroup($shname);
			return $stmt;
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function assignTask($hname, $shid, $group, $task, $adate, $ddate)
	{

		try
		{
			$stmt = $this->conn->prepare("INSERT INTO task(task_by,task_for,group_no,task_desc,date_assigned,date_completed) 
		                                               VALUES(:hname, :shid,:group, :task, :adate, :ddate)");
				  
			$stmt->bindparam(":hname", $hname);
			$stmt->bindparam(":shid", $shid);
			$stmt->bindparam(":group", $group);
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