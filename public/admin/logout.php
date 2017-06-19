<?php 
require_once ('../../includes/functions.php');
require_once("../../includes/Session.php"); 

	
    $session->logout();
    redirect_to("login.php");
?>
