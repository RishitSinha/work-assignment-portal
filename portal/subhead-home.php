<?php

  require_once("session.php");
  
  require_once("class.user.php");
  require_once("class.task.php");
  $auth_user = new USER();
  
  
  $user_id = $_SESSION['user_session'];
  
  $stmt = $auth_user->runQuery("SELECT * FROM user WHERE user_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  $task_data = new TASK(); 

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

  <script src="js/jquery.js"></script>
</head>




<body>
  <nav class="deep-purple " role="navigation" style="margin-bottom:5vh;">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Sub Head's Portal</a>
     <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="logout.php?logout=true">Logout</a></li>
    </div>
  </nav>
  <div class="row">
    <div class="col s8 offset-s2">
      <h2 style="color: #673ab7 ;"><?php print($userRow['full_name']); ?></h2>
      <button class='waves-effect waves-light deep-purple darken-2 btn' onclick=showATask()>All Tasks</button>
      <button class='waves-effect waves-light deep-purple darken-2 btn' onclick=showCTask()>My Tasks</button>
      <hr>

    <div class="row" style="margin-top: 10vh;">
    <div class="table-responsive-vertical shadow-z-1">
  <table id="cTask" class="table table-hover table-mc-light-blue">
      <thead>
        <tr>
          <th>Assigned By</th>
          <th>Task</th>
          <th>Assigned To</th>
          <th>Assigned Date</th>
          <th>Due Date</th>
          <th>Status</th>
          <th>Completed</th>

        </tr>
      </thead>
      <tbody>
        <?php
        $task_data->getMyTasks($user_id);

       ?>
      </tbody>
    </table>
  </div>
</div>
  <div class="table-responsive-vertical shadow-z-1">
  <table id="aTask" class="table table-hover table-mc-light-blue">
      <thead>
        <tr>
          <th>Assigned By</th>
          <th>Task</th>
          <th>Assigned To</th>
          <th>Assigned Date</th>
          <th>Due Date</th>
          <th>Status</th>

        </tr>
      </thead>
      <tbody>
        <?php
        $task_data->getActiveTasks();
        $task_data->getCompletedTasks();

       ?>
      </tbody>
    </table>
  </div>
</div>

    
    
  </body>
</html>

    </div>

    </div>
                      


                    </div>



  <!--  Scripts-->
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script src="js/index.js"></script>
  <script type="text/javascript">


  function showEdit($id){
    console.log("Show Edit: "+$id);
    $('#editForm'+$id).fadeToggle();
  }
  $(document).ready(function() {
    $('#aTask').hide();
    $('#cTask').show();
    });

  function showCTask(){
     $('#cTask').toggle();
     $('#aTask').hide();
  }

  function showATask(){
     $('#aTask').toggle();
     $('#cTask').hide();
  }
  function showAssign($id){
    console.log("Show Assign: "+$id);
    $('#assignForm'+$id).fadeToggle();
  }

  $('input[type="checkbox"]').change(function(){
    <?php $task_data->getChecked($user_id);?>
  });
    // $('.datepicker').pickadate({
    //   selectMonths: true, // Creates a dropdown to control month
    //   selectYears: 15, // Creates a dropdown of 15 years to control year
    //   format: 'yyyy-mm-dd'
    // });


  </script>
  </body>
</html>
