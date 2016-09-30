<?php

  require_once("session.php");
  
  require_once("class.user.php");
  require_once("class.task.php");
  $auth_user = new USER();
  
  
  $user_id = $_SESSION['user_session'];
  
  $stmt = $auth_user->runQuery("SELECT * FROM user WHERE user_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  if(!$userRow['head']){
    echo "Unknown User. Please Login Again.";
    $auth_user->redirect('logout.php?logout=true');
  }

  $task_data = new TASK(); 

  if(isset($_POST['btn-assign']))
  {
    $shname = strip_tags($_POST['txt_shname']);
    $task = strip_tags($_POST['txt_task']);
    $ddate = strip_tags($_POST['txt_date']);
      
    $task_data->assignTask($userRow['user_id'], $shname, $task, date("Y/m/d"),$ddate);
  }
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
<title>Welcome - <?php print($userRow['full_name']); ?></title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link rel="stylesheet" href="css/style1.css">

</head>




<body>
  <nav class="deep-purple " role="navigation" style="margin-bottom:5vh;">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Head's Portal</a>
     <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="logout.php?logout=true">Logout</a></li>
    </div>
  </nav>
  <div class="row">
    <div class="col s8 offset-s2">
      <h2 style="color: #673ab7 ;"><?php print($userRow['full_name']); ?></h2>
      <hr>

      <?php
        $task_data->getActiveTasks();
        echo '<hr>';
        $task_data->getCompletedTasks();
        //$task_data->assignTask('1','rishit','come to treat',date("Y/m/d"),'2016-09-30');
       ?>


    <div class="row" style="margin-top: 10vh;">
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('6'); ?></span>
              <input type="text"  name='txt_task6' value='<?php $task_data->getMyTasks("abhinav") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('abhinav')){ ?>
              
              
            <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
            
                <form method="post">
                <button type="submit" name="btn-save6" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <button type="submit" name="btn-delete6" class="waves-effect waves-light deep-purple darken-2 btn" >
                      Delete
                </button>
                </form>
                <!--<input type="checkbox" id="test5" />
              <label for="test5"></label>-->
              <?php if(isset($_POST['btn-save6']))
              {
                //$task = $_REQUEST['txt_task6'];
                $task_data->editTask('new work','abhinav');
              }
               if(isset($_POST['btn-delete6']))
              {
                $task_data->deleteTask('abhinav');
              }
               }
              else {  ?>
            <button name="assign"  class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="abhinav"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('7'); ?></span>
             <input type="text" value='<?php $task_data->getMyTasks("ashutosh") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('ashutosh')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete7" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete7']))
              {
                $task_data->deleteTask('ashutosh');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="ashutosh"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('8'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("dipramit") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('dipramit')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete8" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete8']))
              {
                $task_data->deleteTask('dipramit');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="dipramit"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
          </div>
        </div>
      </div>
      </div>
    <div class="row">
    <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('9'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("esha") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('esha')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete9" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete9']))
              {
                $task_data->deleteTask('esha');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="esha"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('10'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("harshit") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('harshit')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete10" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete10']))
              {
                $task_data->deleteTask('harshit');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="harshit"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('11'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("paras") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('paras')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete11" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete11']))
              {
                $task_data->deleteTask('paras');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign ">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="paras"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('12'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("pradhumn") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('pradhumn')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete12" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete12']))
              {
                $task_data->deleteTask('pradhumn');
              }
               }
              else {  ?>
            <button name="assign"  class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="pradhumn"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('13'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("rishit") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('rishit')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete13" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete13']))
              {
                $task_data->deleteTask('rishit');
              }
               }
              else {  ?>
            <button name="assign"  class="waves-effect waves-light deep-purple darken-2 btn assign ">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="rishit"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
            
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('14'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("sagar") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('sagar')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete14" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete14']))
              {
                $task_data->deleteTask('sagar');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="sagar"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
            
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('15'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("sahil") ?>' disabled/></input>
            </div>
            
            <?php if($task_data->busy('sahil')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete15" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete15']))
              {
                $task_data->deleteTask('sahil');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="sahil"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
            
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('16'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("shivanshu") ?>' disabled/></input>
            </div>
            
            
            <?php if($task_data->busy('shivanshu')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete16" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete16']))
              {
                $task_data->deleteTask('shivanshu');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="shivanshu"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
            
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php $task_data->getName('17'); ?></span>
              <input type="text" value='<?php $task_data->getMyTasks("shubham") ?>' disabled/></input>
            </div>
            
            
            <?php if($task_data->busy('shubham')){ ?>
               <button name="btn-edit" class="waves-effect waves-light deep-purple darken-2 btn edit" >
                      Edit
                </button>
                <button name="btn-save" class="waves-effect waves-light deep-purple darken-2 btn save" >
                      Save
                </button><br><br><br>
            <form method="post">
            <button type="submit" name="btn-delete17" class="waves-effect waves-light deep-purple darken-2 btn">
                      Delete
                </button>
                </form>
                <?php if(isset($_POST['btn-delete17']))
              {
                $task_data->deleteTask('shubham');
              }
               }
              else {  ?>
            <button name="assign" class="waves-effect waves-light deep-purple darken-2 btn assign">Assign</button>
              <div id="assignForm">
        <form method="post">
          
            <h4 class="form-signin-heading" style="color:#673ab7;">Assign</h4><hr />
            
            <div id="error">
            <?php
              if(isset($error))
              {
                ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
              }
            ?>
                </div>
                  
                <input type="text" class="form-control" name="txt_shname" value="shubham"  />


                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>
          </div>
    <?php }?>
            
          </div>
        </div>
      </div>
    </div>




    



    </div>
  </div>



  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script src="js/index.js"></script>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
   <script type="text/javascript">
    $('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 15, // Creates a dropdown of 15 years to control year
      format: 'yyyy-mm-dd'
    });
  </script>
  </body>
</html>
