<?php
require_once('../../includes/functions.php');
require_once('../../includes/Session.php');

function __autoload($className) {
	require_once "../../includes/" . $className . '.php';
}

if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>


<?php include '../layouts/admin_header.php';?>

		<nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Menu</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            	
            	<li><a href="photo_upload.php">Add a new photo</a></li>
              	<li><a href="list_photos.php">List photos</a></li>
              	<li><a href="list_comments.php">List a comments</a></li>
				<li><a href="logfile.php">View Log file</a></li>
				<li><a href="logout.php">Logout</a></li>
				
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

		
<?php include '../layouts/admin_footer.php';?>