<?php

	require_once('../../includes/functions.php');
	require_once('../../includes/Session.php');
	if (!$session->is_logged_in()) { redirect_to("login.php"); }
	
	function __autoload($className) {
		require_once "../../includes/" . $className . '.php';
	}
	
	
	if (empty($_GET['id'])) {
		redirect_to('index.php');
	}
	
	
	$photo = Photograph::find_by_id($_GET['id']);
	
	//var_dump($photo);
	
	if ($photo && $photo->delete()) {
		
		$session->message("The photo was deleted.");
		redirect_to("list_photos.php");
		
	} else {
		$session->message("The photo could not be deleted.");
		redirect_to("list_photos.php");
	}



?>


