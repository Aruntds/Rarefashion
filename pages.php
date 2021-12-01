<?php

	include 'head/jackus.php'; 
	extract($_REQUEST);
	include '___class__home.inc';
//echo "SELECT * FROM `js_content` where deleted = '0' and `contentID`='$id' and status ='1'";
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_content` where deleted = '0' and `contentID`='$id' and status ='1'") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	
	$contentID = $row["contentID"];
	  $contentname = html_entity_decode($row["contentname"], ENT_QUOTES, "UTF-8");
	  $contentimage = $row["contentimage"];
	  $content_descrption = html_entity_decode($row["contentdescrption"]);
	  //$contentdescrption = stripslashes($row["contentdescrption"]);
	  $contentseourl = $row["contentseourl"];
	  $contentmetatitle = stripslashes($row["contentmetatitle"]);
	  $contentmetakeywords = stripslashes($row["contentmetakeywords"]);
	  $contentmetadescrption = stripslashes($row["contentmetadescrption"]);
	  $contentdesignsettings = $row["contentdesignsettings"];
	  $status = $row["status"];
	  $sidebar = $row["sidebar"];
		if($sidebar == 0){
			$column = 'col-xl-12 col-lg-12 col-md-12 col-sm-12';
			$display = 'style="display:none"';
		}else{
			$column = 'col-xl-9 col-lg-9 col-md-9 col-sm-9';
			
		}
		if(!empty($contentimage)) {
			//upload PATH
			$media_path = "uploads/content/$contentimage";
		} else {
			//upload PATH
			$media_path = "public/img/blank-placeholder.jpg";
		}
	}
	
	if($contentmetatitle == '') {
	    $commontitle = $contentname;
	} else {
	   $commontitle = $contentmetatitle;   
	}
	
	if($contentname == ''){
		$display_title = 'style="display:none"';
		$display = 'display:block';
		$contentname = '404 Page';
		$commontitle = $contentname;
	} else{
		$display_title = 'style="display:block"';
		$display = 'display:none';
	}

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
			'__page_content'
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