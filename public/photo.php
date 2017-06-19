<?php
require_once ('../includes/functions.php');

require_once ('../includes/Session.php');
function __autoload($className) {
	require_once "../includes/" . $className . '.php';
}

if (empty ( $_GET ['id'] )) {
	$session->message ( "No photograph ID was provided." );
	redirect_to ( 'index.php' );
}

$photo = Photograph::find_by_id ( $_GET ['id'] );

if (! $photo || $photo == false) {
	$session->message ( "The photo could not be located." );
	redirect_to ( 'index.php' );
}

if (isset ( $_POST ['submit'] )) {
	
	$author = trim ( $_POST ['author'] );
	$body = trim ( $_POST ['body'] );
	
	$new_comment = Comments::make ( $photo->id, $author, $body );
	
	if ($new_comment && $new_comment->save ()) {
		
		redirect_to ( "photo.php?id={$photo->id}" );
	} else {
		$message = "There was an error that prevented the comment to being saved.";
	}
} else {
	
	$author = "";
	$body = "";
}

$comments = $photo->comments ();

?>

<?php include 'layouts/header.php'; ?>



<div class="container">

	<div class="row">
		<a class="btn btn-primary" role="button" href="index.php">Back</a> <br />
		<br />
	</div>

	<div class="row">
		<div class="col-lg-12">
			<img class="img-responsive" width="100%"
				src="images/<?php echo $photo->filename; ?>" />
			<div class="caption">
				<h3><?php echo $photo->caption; ?></h3>
			</div>
		</div>
	</div>

</div>



<div class="row">

	<div id="comments">
		  <?php foreach($comments as $comment): ?>
		    <div class="comment" style="margin-bottom: 2em;">
			<div class="text-primary">
			   <?php echo htmlentities($comment->author); ?> wrote:
			</div>
			<div class="body">
				<?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
			</div>
			<div class="meta-info" style="font-size: 0.8em;">
			    <?php echo datetime_to_text($comment->created); ?>
			</div>
		</div>
		  <?php endforeach; ?>
		  <?php if(empty($comments)) { echo "No Comments."; } ?>
		</div>

</div>


<div class="row">
	<h3>New Comment</h3>
			  <?php echo output_message($message); ?>
			  <form action="photo.php?id=<?php echo $photo->id; ?>" method="post">
		<div class="form-group">
			<label>Your name:</label> 
			<input class="form-control" type="text"	name="author" value="<?php echo $author; ?>" />
		</div>
		<div class="form-group">
			<label>Your comment:</label>
			<textarea class="form-control" name="body" cols="40" rows="8"><?php echo $body; ?></textarea>
		</div>
		<input class="btn"  type="submit" name="submit" value="Submit Comment" />

	</form>
</div>


<?php include 'layouts/footer.php';?>