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
    $shid = strip_tags($_POST['txt_shid']);
    $task = strip_tags($_POST['txt_task']);
    $ddate = strip_tags($_POST['txt_date']);
      
    $task_data->assignTask($userRow['full_name'], $shid, $task, date("Y/m/d"),$ddate);
  }
  
  if(isset($_POST['btn-save']))
  {
    $shid = strip_tags($_POST['txt_shid']);
    $task = strip_tags($_POST['txt_task']);
    $ddate = strip_tags($_POST['txt_date']);
      
    $task_data->editTask($task,$shid,$ddate);
  }
 if(isset($_POST['btn-delete']))
  {
    $shid = strip_tags($_POST['txt_shid']);
    $task_data->deleteTask($shid);
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

  <script src="js/jquery.js"></script>
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
       ?>


    <div class="row" style="margin-top: 10vh;">
       <?php 
          $task_data->createCards();
        ?>
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

  function showAssign($id){
    console.log("Show Assign: "+$id);
    $('#assignForm'+$id).fadeToggle();
  }

    // $('.datepicker').pickadate({
    //   selectMonths: true, // Creates a dropdown to control month
    //   selectYears: 15, // Creates a dropdown of 15 years to control year
    //   format: 'yyyy-mm-dd'
    // });


  </script>
  </body>
</html>
