<?php
	
	require_once('../../includes/functions.php');
	require_once('../../includes/Session.php');
	
	function __autoload($className) {
		require_once "../../includes/" . $className . '.php';
	}
	
	if (!$session->is_logged_in()) { redirect_to("login.php"); }
	

	if (empty($_GET['id'])) {
		$session->message("No photograph ID was provided.");
		redirect_to('index.php');
	}
	
	$photo = Photograph::find_by_id($_GET['id']);
	
	
	if (!$photo || $photo == false ) {
		$session->message("The photo could not be located.");
		redirect_to('index.php');
	}
	
		
	$comments =$photo->comments();

?>


<?php include '../layouts/admin_header.php';?>

	<h2>Comments on <?php echo $photo->filename;?></h2>
	
	<div id="comments">
  <?php foreach($comments as $comment): ?>
    <div class="comment" style="margin-bottom: 2em;">
	    <div class="author">
	      <?php echo htmlentities($comment->author); ?> wrote:
	    </div>
      <div class="body">
				<?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
			</div>
	    <div class="meta-info" style="font-size: 0.8em;">
	      <?php echo datetime_to_text($comment->created); ?>
	    </div>
	    <div class="action" style="font-size: 0.8em;">
	    <a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete comment</a>
	    </div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($comments)) { echo "No Comments."; } ?>
</div>
	
	
	<a href="photo_upload.php">Upload a new photograph.</a><br />
	<a href="list_comments.php">List of comments.</a>
		
		
		
		
		
<?php include '../layouts/admin_footer.php';?>