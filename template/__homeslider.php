<!-- Slider Area Start -->
<?php
    //starting home-slider setup
    $list_homeslider_datas = sqlQUERY_LABEL("SELECT `homesliderID`, `homeslidertitle1`, `homeslidertitle2`, `homeslidertext`, `homesliderlink`, `homesliderlinktext`, `homesliderimage` FROM `js_homeslider` where deleted = '0' and status='1' order by display_order ASC") or die("#1-Unable to get records:".mysqli_error());
    
    $count_homeslider_list = sqlNUMOFROW_LABEL($list_homeslider_datas);
	if($count_homeslider_list > 0) {
	?>
	<div class="container">
		<div class="intro-slider-container slider-container-ratio mb-2">
			<div class="intro-slider owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": false}'>    
			<?php
				while($row = sqlFETCHARRAY_LABEL($list_homeslider_datas)){
				  $homesliderID = $row["homesliderID"];
				  $homeslidertitle1 = $row["homeslidertitle1"];
				  $homeslidertitle2 = $row["homeslidertitle2"];
				  $homeslidertext = htmlspecialchars_decode($row['homeslidertext']);
				  $homesliderlink = $row["homesliderlink"];
				  $homesliderlinktext = $row["homesliderlinktext"];
				  $homesliderimage = $row["homesliderimage"];
				  
					//upload PATH
					$homeslider_path = "uploads/homeslider/$homesliderimage";
					//assets/images/demos/demo-10/slider/slide-1-480w.jpg
				?>				
				<div class="intro-slide">
				<figure class="slide-image">
					<picture>
						<source media="(max-width: 480px)" srcset="<?php echo $homeslider_path; ?>">
						<img src="<?php echo $homeslider_path; ?>" alt="Image Desc">
					</picture>
				</figure>

				<div class="intro-content">
					<h3 class="intro-subtitle"><?php echo $homeslidertitle1; ?></h3>
					<h1 class="intro-title text-white"><?php echo $homeslidertitle2; ?></h1>

					<div class="intro-price text-white"><?php echo html_entity_decode($homeslidertext); ?></div>

					<?php if($homesliderlinktext != '') { ?>
					<a href="<?php echo $homesliderlink; ?>" class="btn btn-white-primary btn-round">
						<span><?php echo $homesliderlinktext; ?></span>
						<i class="icon-long-arrow-right"></i>
					</a>
					<?php } ?>
				</div>
			</div>					
				<?php		
				} //end of while loop		
				?>
			</div>
			<span class="slider-loader"></span>
		</div>
	</div><!-- End .container -->    
	<?php } //end of num of rows count ?><!-- Slider Area End -->