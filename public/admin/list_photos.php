<?php
	
	require_once('../../includes/functions.php');
	require_once('../../includes/Session.php');
	
	function __autoload($className) {
		require_once "../../includes/" . $className . '.php';
	}
	
	if (!$session->is_logged_in()) { redirect_to("login.php"); }
	
	$photos = Photograph::find_all();

	 
?>


<?php include '../layouts/admin_header.php';?>

	<h2>Photographs</h2>
	
	<?php echo output_message($message);?>
	
	<table class="table">
		<tr>
			<th>Image</th>
			<th>Filename</th>
			<th>Coption</th>
			<th>Size</th>
			<th>Type</th>
			<th>Comments</th>
			<th>&nbsp;</th>
		</tr>
		
		<?php foreach ( $photos as $photo ): ?>
		
			<tr>
				<td><img src="../images/<?php echo $photo->filename; ?>" width="100" /></td>
				<td><?php echo $photo->filename; ?></td>
				<td><?php echo $photo->caption; ?></td>
				<td><?php echo $photo->size; ?></td>
				<td><?php echo $photo->type; ?></td>
				<td>
					<a href="comments.php?id=<?php echo $photo->id; ?>">
						<?php echo count(Comments::find_comments_on($photo->id)); ?>
					</a>
				</td>
				<td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a></td>
			</tr>
		
		<?php endforeach; ?>	
	
	</table>
	
	<br />
	<br />
	
	<a href="photo_upload.php">Upload a new photograph.</a><br />
	<a href="list_comments.php">Comments.</a>
		
		
		
		
		
<?php include '../layouts/admin_footer.php';?>