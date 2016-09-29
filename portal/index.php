<?php
session_start();
require_once("class.user.php");
$login = new USER();

if($login->is_loggedin()!="")
{
  $login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
  $uname = strip_tags($_POST['txt_uname_email']);
  $upass = strip_tags($_POST['txt_password']);
    
  if($login->doLogin($uname,$upass))
  {
        if($login->checkHead($uname)){
          $login->redirect('head-home.php');
        }
        else{
          $login->redirect('home.php');
        }
  }
  else
  {
    $error = "Wrong Details !";
  } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Work Assignment Portal</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>




<body>
  <nav class="light-blue lighten-1" role="navigation" style="margin-bottom:15vh;">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo center">Work Assignment Portal</a>
    </div>
  </nav>
  <div class="row">
    <div class="col s4 offset-s4">
      <center>
        <h1>Welcome!</h1>
        <h5>Please Sign-In to Continue</h5>
      </center>
    </div>
  </div>
<div id="error">
        <?php
            if(isset($error))
            {
                ?>
                <div class="alert alert-danger">
                   <center><i class="material-icons">error</i> &nbsp; <?php echo $error; ?> !</center>
                </div>
                <?php
            }
        ?>
        </div>
<div class="row">
    <form class="col s4 offset-s4" method="post">
      <div class="row">
        <div class="input-field col s12">
          <input id="first_name" type="text" name="txt_uname_email" class="validate">
          <label for="name">Username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="password" type="password" name="txt_password" class="validate">
          <label for="password">Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s4 offset-s4">
          <button type="submit" name="btn-login" class="waves-effect waves-light btn">Sign-In<i class="material-icons right">input</i></button>
        </div>
      </div>
    </form>
  </div>



  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>
