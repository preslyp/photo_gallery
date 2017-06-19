<?php 

	function __autoload($className) {
		require_once "../includes/" . $className . '.php';
	}
	
	
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
	
	$per_page = 2;
	
	$total_count = Photograph::count_all();
	
	$pagination = new Pagination($page, $per_page, $total_count);

	
	$sql = "SELECT * FROM photographs ";
	$sql .= "LIMIT {$per_page} ";
	$sql .= "OFFSET {$pagination->offset()}";
	$photos = Photograph::find_by_sql($sql);


?>

<?php include 'layouts/header.php';?>

<div class="row">
	
	<?php foreach ( $photos as $value ): ?>

		<div class="col-lg-3 col-md-4 col-xs-6 thumb">

		<a class="thumbnail" href="photo.php?id=<?php echo $value->id; ?>"> <img
			class="img-responsive" src="images/<?php echo $value->filename; ?>"
			width="250" height="150" />
			  <div class="caption">
				<p><?php echo $value->caption; ?></p>
			</div>
		</a>

	</div>
	
	<?php endforeach; ?>
	
</div>

<nav aria-label="Page navigation" class="text-center">
	<ul class="pagination">
		<?php
			if ($pagination->total_pages () > 1) {
				

			if ($pagination->has_previous_page ()) {
				echo "<li><a href=\"index.php?page=";
				echo $pagination->previous_page ();
				echo "\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</a></li>";
			}
			
			for($i = 1; $i <= $pagination->total_pages (); $i ++) {
				if ($i == $page) {
					echo "<li><span class=\"selected\">{$i}</span></li> ";
				} else {
					echo "<li><a href=\"index.php?page={$i}\">{$i}</a></li>";
				}
			}
			
			if ($pagination->has_next_page ()) {
				echo "<li><a href=\"index.php?page=";
				echo $pagination->next_page ();
				echo "\"  aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</a></li>";
			}
		}
		
		?>
  </ul>
</nav>


<?php include 'layouts/footer.php';?>