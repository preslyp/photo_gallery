<?php

	require_once ('../../includes/functions.php');
	require_once('../../includes/Session.php');

	function __autoload($className) {
		require_once "../../includes/" . $className . '.php';
	}
	

	if (!$session->is_logged_in()) { redirect_to("login.php"); }

 	$max_file_size = 1048576;
	
	if (isset($_POST['submit'])) {
		
	$photo = new Photograph();
	$photo->caption = $_POST['caption'];
	$photo->attach_file($_FILES['file_upload']);
	
		if ($photo->save()) {
			
			$session->message("Photograph uploaded successfully.");
			redirect_to("list_photos.php");
			
		} else {
				
			$message = join("<br/>", $photo->errors );
		}
			
	
	}


?>


<?php include '../layouts/admin_header.php';?>

	
	<h2>Photo Upload</h2>

	<?php if(isset($message)) echo output_message($message); ?>
	
	<form action="photo_upload.php" enctype="multipart/form-data" method="POST">
	
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
	<br />
	
	<input type="file" name="file_upload" />
	<br />
	
	<p>Caption: <input class="form-control"  type="text" name="caption" value="" /></p>
	
	<input class="btn" type="submit" name="submit" value="Upload" />
	</form>
	
	<a href="list_photos.php">See the photos.</a>
	
<?php include '../layouts/admin_footer.php';?>
