<?php
	require_once('session.php');
	require_once('class.user.php');
	$user_logout = new USER();
	
	if($user_logout->is_loggedin()!="")
	{
		if($user_logout->is_loggedin()!="")
{
    if($user_logout->checkHead($uname)){
	$user_logout->redirect('head.php');
}
else {
    $user_logout->redirect('subhead.php');
}
	}
}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('index.php');
	}
