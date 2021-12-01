<main class="main">
	<div class="page-header text-center" style="letter-spacing: 3px; background-image: url('<?php echo SITEHOME;?>assets/images/page-header-bg.jpg')">
		<div class="container">
			<h1 class="page-title"><?php echo $contentname; ?></h1>
		</div><!-- End .container -->
	</div><!-- End .page-header -->
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo $contentname; ?></li>
                    </ul>
                </nav>
            </div>
        </nav>

<div class="page-content mt-30">
    <!-- POST LAYOUT -->
    <div class="container">
        <div class="row" style="margin-top:30px">
			<form action="" method="post" <?php echo $display_title; ?>>
            <div class="main-content <?php echo $column ?>">
               <div class="kreen-heading style-01">
					<div class="heading-inner">
					<!--<h3 class="title"><?php echo $contentname ?> </h3>-->
					</div>
				</div>
				<div class="mt-20 mb-40 pl-40 pr-30">
				<?php echo html_entity_decode($content_descrption) ?>
				</div>
            </div>
			</form>
			<div class="nopage col-md-12 justify-content-center mb-60"  style="margin-top:30px; text-align: center;<?php echo $display ?>">
			
			<div>
				<img class="pageNotFoundImage" src="https://www.bbassets.com/static/images/404pan.png">
				<h2 class="center-content" style="align:center">This page is currently unavailable.</h2>
				<p>Let’s take you back to home.</p>
                <button type="button" class="btn button btn-outline-primary-2" onclick="window.location.href='index.php'">Go To Home</button>
			</div>
			
			
			</div>
		<!--<div class="sidebar col-xl-3 col-lg-4 col-md-4 col-sm-12"  <?php echo $display ?>>
	<div id="widget-area" class="widget-area shop-sidebar">
		<?php
			$setting_front_page = sqlQUERY_LABEL("SELECT _settings_frontpage_featuredshow, _settings_frontpage_featuredproducts FROM `js_settingfrontpage`") or die("Unable to get records:".sqlERROR_LABEL());			
		$check_record_availabity = sqlNUMOFROW_LABEL($setting_front_page);			
		while($setting_front = sqlFETCHARRAY_LABEL($setting_front_page)){
			//Store Front Page - Product Settings
			$frontpage_featuredshow = $setting_front["_settings_frontpage_featuredshow"];
			$frontpage_featuredproducts = $setting_front["_settings_frontpage_featuredproducts"];
		}
		if($frontpage_featuredshow == '1') {
			
		$arr = explode(",", $frontpage_featuredproducts);
		?>
		<div id="kreen_products-2" class="widget kreen widget_products">
			<h2 class="widgettitle">Featured Products<span class="arrow"></span></h2>
			<ul class="product_list_widget">
					<?php
					
					for ($flag = 0; $flag <= count($arr); $flag++) {
						$list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where productID = '$arr[$flag]' and productID != '$product_token' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
						
						  $count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
						
						  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
							  $productID = $row["productID"];
							  $productsku = $row["productsku"];
							  $producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
							  $productsellingprice = formatCASH($row["productsellingprice"]);
							  $productMRPprice = formatCASH($row["productMRPprice"]);
							  $productavailablestock = $row["productavailablestock"];
							  $productstockstatus = $row["productstockstatus"];  //stock status
							  
							  //product title
							  $custom_producttitle = limit_words($producttitle, 4);
								
								//check price difference percentage
								if($row["productMRPprice"] > $row["productsellingprice"]) {
									$__productprice_difference = number_format(((($row["productMRPprice"] - $row["productsellingprice"])/$row["productsellingprice"]) * 100), 0);
									$shop_discount_percentage = '<span class="onsale"><span class="number">-'.$__productprice_difference.'%</span></span>';
									$shop_offer_strike_price = '<del><span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">₹</span>'.$productMRPprice.'</span></del>';
								} else {
									$shop_discount_percentage = '';
									$shop_offer_strike_price = '';
								}
								
								//button variable
								if($productstockstatus == 0 || $productavailablestock == 0) {
									$shop_buttonclass_m = 'nostock-cart';
									$shop_buttonclass = 'nostock-cart_button';
									$shop_button_label = 'Out of Stock';
								} else {
									$shop_buttonclass_m = 'add-to-cart';
									$shop_buttonclass = 'add_to_cart_button';
									$shop_button_label = 'Add to Cart';
								}							
							
					?>			
				<li>				
					<a href="product?token=<?php echo $productID.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>" title="<?php echo $producttitle; ?>">
						<?php
							$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
							  while($featured_image = sqlFETCHARRAY_LABEL($featured_product_image)){
								  $productmediagallerytitle = $featured_image["productmediagallerytitle"];
								  $productmediagalleryurl = $featured_image["productmediagalleryurl"];
							?>
							<img class="attachment-kreen_thumbnail size-kreen_thumbnail" src="uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" title="<?php echo $producttitle; ?>" alt="<?php echo $producttitle; ?>">
							<?php
							
							}
						?>
						<span class="product-title"><?php if(strlen($custom_producttitle) > 35) { $add_moredots='...'; } echo $custom_producttitle.$add_moredots; ?></span>
					</a>
					<span class="price"><?php echo $shop_offer_strike_price; ?> <ins><span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">₹</span><?php echo $productsellingprice; ?></span></ins></span> 
				</li>
				<?php
					
				  }
				  //$flag+1;
				}
				
				?>
			</ul>
		</div>
		<?php 
			
		} 
		
		//check featured category
		$list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where productcategory = '$productcategory' and productID != '$product_token' and deleted = '0' and status = '1' Limit 3") or die("#1-Unable to get records:".sqlERROR_LABEL());

		$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
		if($count_product_list > 0) {
		?>
		
		<div id="kreen_products-2" class="widget kreen widget_products">
			<h2 class="widgettitle">Related Products<span class="arrow"></span></h2>
			<ul class="product_list_widget">
					<?php
					
						
						  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
							  $productID = $row["productID"];
							  $productsku = $row["productsku"];
							  $producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
							  $productsellingprice = formatCASH($row["productsellingprice"]);
							  $productMRPprice = formatCASH($row["productMRPprice"]);
							  $productavailablestock = $row["productavailablestock"];
							  $productstockstatus = $row["productstockstatus"];  //stock status
							  
							  //product title
							  $custom_producttitle = limit_words($producttitle, 4);
								
								//check price difference percentage
								if($row["productMRPprice"] > $row["productsellingprice"]) {
									$__productprice_difference = number_format(((($row["productMRPprice"] - $row["productsellingprice"])/$row["productsellingprice"]) * 100), 0);
									$shop_discount_percentage = '<span class="onsale"><span class="number">-'.$__productprice_difference.'%</span></span>';
									$shop_offer_strike_price = '<del><span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">₹</span>'.$productMRPprice.'</span></del>';
								} else {
									$shop_discount_percentage = '';
									$shop_offer_strike_price = '';
								}
								
								//button variable
								if($productstockstatus == 0 || $productavailablestock == 0) {
									$shop_buttonclass_m = 'nostock-cart';
									$shop_buttonclass = 'nostock-cart_button';
									$shop_button_label = 'Out of Stock';
								} else {
									$shop_buttonclass_m = 'add-to-cart';
									$shop_buttonclass = 'add_to_cart_button';
									$shop_button_label = 'Add to Cart';
								}							
							
					?>			
				<li>				
					<a href="product?token=<?php echo $productID.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>" title="<?php echo $producttitle; ?>">
						<?php
							$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
							  while($featured_image = sqlFETCHARRAY_LABEL($featured_product_image)){
								  $productmediagallerytitle = $featured_image["productmediagallerytitle"];
								  $productmediagalleryurl = $featured_image["productmediagalleryurl"];
							?>
							<img class="attachment-kreen_thumbnail size-kreen_thumbnail" src="uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" title="<?php echo $producttitle; ?>" alt="<?php echo $producttitle; ?>">
							<?php
							
							}
						?>
						<span class="product-title"><?php if(strlen($custom_producttitle) > 35) { $add_moredots='...'; } echo $custom_producttitle.$add_moredots; ?></span>
					</a>
					<span class="price"><?php echo $shop_offer_strike_price; ?> <ins><span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">₹</span><?php echo $productsellingprice; ?></span></ins></span> 
				</li>
				<?php
					
				  }
				  				
				?>
			</ul>
		</div>
		<?php } ?>
		
		<div id="kreen_product_categories-2" class="widget kreen widget_product_categories">
			<h2 class="widgettitle">Product categories<span class="arrow"></span></h2>
			<ul class="product-categories">
			   <?php  
				   $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' order by categoryID ASC") or die("#1-Unable to get records:".sqlERROR_LABEL());

				  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

				  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
					  $counter++;
					  $categoryID = $row["categoryID"];
					  $categoryname = $row["categoryname"];
				?>
					<li class="cat-item cat-item-22">
						<a href="<?php echo SITEHOME; ?>shop?categoryid=<?php echo $categoryID.'-'.convertSEOURL($categoryname); ?>"><?php echo $categoryname; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>                    
	</div>
</div>-->
        </div>
		</div>
    </div>
</div>
