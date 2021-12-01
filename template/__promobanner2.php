    <!-- Banner Area Start -->
   <?php
   
    //starting home-slider setup
    $list_promobanner_datas = sqlQUERY_LABEL("SELECT `promobannerID`, `promobanner_title`, `promobanner_image`, `display_size`, `banner_link` FROM `js_promobanner` where promobannerTYPE='2' and deleted = '0' and status='1' order by display_order ASC") or die("#1-Unable to get records:".mysqli_error());
    
    $count_promobanner_list = sqlNUMOFROW_LABEL($list_promobanner_datas);
	if($count_promobanner_list > 0) {
	?>
	<div class="row justify-content-center">

            <?php
				while($row = sqlFETCHARRAY_LABEL($list_promobanner_datas)){

				  $promobannerID = $row["promobannerID"];
				  $promobanner_title = $row["promobanner_title"];
				  $promobanner_image = $row["promobanner_image"];
				  $display_size = $row["display_size"];  //1-small 2-medium 3-large
				  $banner_link = $row["banner_link"];
				  
				  if($display_size == '1') {
					  $div_class = 'col-lg-3 col-md-3';
				  } elseif($display_size == '2') {
					  $div_class = 'col-lg-4 col-md-4';
				  } elseif($display_size == '3') {
					  $div_class = 'col-lg-6 col-md-6';
				  }
				  
				  $media_path = "uploads/promobanner2/$promobanner_image";
			?>
				<div class="<?php echo $div_class; ?>" id="promo-<?php echo $promobannerID; ?>">
					<div class="banner">
						<a href="<?php echo $banner_link; ?>" title="<?php echo $promobanner_title; ?>">
							<img src="<?php echo $media_path; ?>" alt="<?php echo $promobanner_title; ?>">
						</a>

						<?php /* <div class="banner-content">
							<h4 class="banner-subtitle">Final reduction</h4>
							<h3 class="banner-title"><strong>Sandals & <br>Flip Flops</strong> <br>up to 60% off</h3>
							<a href="#" class="btn btn-outline-dark banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
						</div> */ ?>
					</div>
				</div>

            <?php } ?>
            
	</div>
   <?php
    } //end of num of rows count 
   ?><!-- Banner Area End -->