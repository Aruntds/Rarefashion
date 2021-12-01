<?php
extract($_REQUEST);
include_once('head/jackus.php');
include 'shopfunction.php'; 
include '___class__home.inc';

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include '__styles.php'; ?>
</head>
<body>
    <div class="page-wrapper">
       <?php 
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__header'
		);
				echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 

		?>
		<div class="fullwidth-template">
		<?php 
			
			//list of module view templates
			$loadbodyFUNCTIONS = array(
			'__wishlist'
			);	
			echo $homepage_propertyclass->loadPAGE($loadbodyFUNCTIONS); 

		?>
		</div>

    <!-- Sign in / Register Modal -->
    <!-- Plugins JS File -->
    <?php

		//list of module view templates
		$loadFUNCTIONS = array(
		'__footer',
		'__scripts'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?>
</body>

</html>