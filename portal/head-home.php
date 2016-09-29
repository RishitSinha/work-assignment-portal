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
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
              <input type="checkbox" id="test5" />
              <label for="test5"></label>
            </div>
          </div>
      </div>
      <div class="col s4">
        <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
      </div>
      <div class="col s4">
        <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
      </div>
      <div class="col s4">
        <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col s4">
        <div class="card">
          <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col s4">
        <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
      </div>
      <div class="col s4">
        <div class="card deep-purple darken-1">
            <div class="card-content white-text">
              <span class="card-title">Sub-Head Name</span>
              <p>TASK DESCRIPTION</p>
            </div>
            <div class="card-action">
              <a href="#">Action Button</a>
              <a href="#">Action Button</a>
            </div>
          </div>
      </div>
    </div>




    <div class="row">
      <div class="col s6 offset-s3">
        <form method="post">
          
            <h2 class="form-signin-heading" style="color:#673ab7;">Assign</h2>
            
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
                
                <input type="text" class="form-control" name="txt_shname" placeholder="Sub-Head Name" required />
                
                <input type="text" class="form-control" name="txt_task" placeholder="Task" />


                <input type="date" class="datepicker" name="txt_date" placeholder="Date" />
            
                <button type="submit" name="btn-assign" class="waves-effect waves-light deep-purple darken-2 btn">
                      Assign
                </button>

          </form>

      </div>
    </div>



    </div>
  </div>



  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script type="text/javascript">
    $('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 15, // Creates a dropdown of 15 years to control year
      format: 'yyyy-mm-dd'
    });
  </script>
  </body>
</html>
