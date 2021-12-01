<?php

extract($_REQUEST);

include_once('../../jackus.php');

	if($_GET['type'] == 'promobanner_img_one') {

	

	$selected_promobannerID = $_GET['promobannerone_id'];
	//echo $selected_promobannerID ;exit();
	

		$query= "SELECT * FROM `js_promobanner` where `deleted`='0' and `promobannerTYPE`='1' and `promobannerID` = '$selected_promobannerID'";

		$result = sqlQUERY_LABEL($query);

		while($row = sqlFETCHARRAY_LABEL($result))

		{			

			$promobannerID = $row['promobannerID'];

			$display_size = $row['display_size'];
			$display_imagesize = getDISPLAYIMAGESIZE($promobannerID,'label');

			$banner_link = $row['banner_link'];
			
			$promobanner_image = $row['promobanner_image'];

			$path="uploads/promobanner1/";

			$image_path = $path.$promobanner_image;
			
			?>

        <img src="<?php echo $image_path; ?>" width="100%" alt="Image Not Available" class="text-danger"/><br />

        <br><h5> <span class="text-dark">Display Size : </span><?php echo $display_imagesize; ?></h5>

		<h5> <span class="text-dark">Banner Link : </span><?php echo $banner_link; ?></h5>      
  

		<?php

		}

	}
	
	
	if($_GET['type'] == 'promobanner_img_two') {

	

	$selected_promobannerID = $_GET['promobannertwo_id'];
	//echo $selected_promobannerID ;exit();
	

		$query= "SELECT * FROM `js_promobanner` where `deleted`='0' and `promobannerTYPE`='2' and `promobannerID` = '$selected_promobannerID'";

		$result = sqlQUERY_LABEL($query);

		while($row = sqlFETCHARRAY_LABEL($result))

		{			

			$promobannerID = $row['promobannerID'];

			$display_size = $row['display_size'];
			$display_imagesize = getDISPLAYIMAGESIZE($promobannerID,'label');

			$banner_link = $row['banner_link'];
			
			$promobanner_image = $row['promobanner_image'];

			$path="uploads/promobanner2/";

			$image_path = $path.$promobanner_image;
			
			?>

        <img src="<?php echo $image_path; ?>" width="100%" alt="Image Not Available" class="text-danger"/><br />

        <br><h5> <span class="text-dark">Display Size : </span><?php echo $display_imagesize; ?></h5>

		<h5> <span class="text-dark">Banner Link : </span><?php echo $banner_link; ?></h5>      

		<?php

		}

	}
?>