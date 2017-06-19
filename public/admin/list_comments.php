<?php

	require_once('../../includes/functions.php');
	require_once('../../includes/Session.php');
	
	function __autoload($className) {
		require_once "../../includes/" . $className . '.php';
	}
	
	if (!$session->is_logged_in()) { redirect_to("login.php"); }
	
	$comments = Comments::find_all();


?>

<?php include '../layouts/admin_header.php';?>

	<h2>Comments</h2>
	
	<?php echo output_message($message);?>
	
	<table class="table">
		<tr>
			<th>Photo_id</th>
			<th>Created</th>
			<th>Author</th>
			<th>body</th>
			<th>&nbsp;</th>
		</tr>
		
		<?php foreach ( $comments as $comment ): ?>
		
			<tr>
				<td><?php echo $comment->photograph_id; ?></td>
				<td><?php echo $comment->created; ?></td>
				<td><?php echo $comment->author; ?></td>
				<td><?php echo $comment->body; ?></td>
				<td><a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a></td>
			</tr>
		
		<?php endforeach; ?>	
	
	</table>
	
	<br />
	<br />
	
	<a href="list_photos.php">List a photograph.</a>
		
		
		
		
		
<?php include '../layouts/admin_footer.php';?>