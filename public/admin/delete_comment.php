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
	
	
	$comment = Comments::find_by_id($_GET['id']);
	
	//var_dump($comment);
	
	if ($comment && $comment->delete()) {
		
		$session->message("The comment was deleted.");
		redirect_to("list_comments.php");
		
	} else {
		$session->message("The comment could not be deleted.");
		redirect_to("list_comments.php");
	}



?>


