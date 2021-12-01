<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
		<div class="container d-flex align-items-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="shop.php">Products</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $commontitle; ?></li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->

	<div class="page-content">
		<div class="container">
			
			<div class="product-details-top">
				<div class="row">
					<div class="col-md-6">
						<div class="product-gallery product-gallery-vertical">
							<div class="row">
								<figure class="product-main-image">
								<?php
								$productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$productID' and deleted = '0' order by productmediagalleryorder ASC, productmediagalleryfeatured DESC, productmediagallerytype ASC Limit 0,1") or die("#1-Unable to get records:".mysqli_error());

								  $count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);

								if($count_productmedia_availablecount > 0) {
								  while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
									  $productmediagalleryID = $row["productmediagalleryID"];
									  $productmediagalleryurl = $row["productmediagalleryurl"];
									  $productmediagallerytype = $row["productmediagallerytype"];
									  //image path
									  $media_path = "uploads/productmediagallery/$productmediagalleryurl";
									  
										if($productmediagallerytype == '1') {
										?>
										<img id="product-zoom" src="<?php echo $media_path; ?>" data-zoom-image="<?php echo $media_path; ?>" alt="product image">
										<?php 
										}
										if($productmediagallerytype =='2'){  //Get Video only
										?>
											<div class="p-image">
											 <iframe width="420" height="315" src="https://www.youtube.com/embed/<?php echo $productmediagalleryurl; ?>"></iframe> 
											</div>
										<?php 
										}//end of video count
									} 
								} //end of count

								?>  
								
									<a href="#" id="btn-product-gallery" class="btn-product-gallery">
										<i class="icon-arrows"></i>
									</a>
								</figure><!-- End .product-main-image -->

								<div id="product-zoom-gallery" class="product-image-gallery">
									<?php
									$productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$productID' and deleted = '0' order by productmediagalleryorder ASC, productmediagalleryfeatured DESC, productmediagallerytype ASC") or die("#1-Unable to get records:".mysqli_error());
									
									  $count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);
									
									if($count_productmedia_availablecount > 0) {
									  while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
										  $productmediagalleryID = $row["productmediagalleryID"];
										  $productmediagalleryurl = $row["productmediagalleryurl"];
										  $productmediagallerytype = $row["productmediagallerytype"];
										  //image path
										  $media_path = "uploads/productmediagallery/$productmediagalleryurl";
										  
											if($productmediagallerytype == '1') {
											?>
											<a class="product-gallery-item" href="#" data-image="<?php echo $media_path; ?>" alt="" data-zoom-image="<?php echo $media_path; ?>">
												<img src="<?php echo $media_path; ?>" alt="product side">
											</a>
											<?php 
											}
											if($productmediagallerytype =='2'){  //Get Video only
											?>
												<div class="p-thumb youtube">
												<img id="zoom<?php echo $productmediagalleryID; ?>" src="https://img.youtube.com/vi/<?php echo $productmediagalleryurl; ?>/mqdefault.jpg">
												</div>
											<?php 
											}//end of video count
										} 
									} //end of count
									?> 
								</div><!-- End .product-image-gallery -->
							</div><!-- End .row -->
						</div><!-- End .product-gallery -->
					</div><!-- End .col-md-6 -->

					<div class="col-md-6">
						<div class="product-details">
							<h1 class="product-title"><?php echo $producttitle; ?></h1><!-- End .product-title -->

							<div class="ratings-container">
								<!-- <div class="ratings">
									<div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val ->
								</div>End .ratings -->
								<a class="ratings-text" href="#product-review-link" id="review-link">SKU: <?php echo $productsku; ?></a>
							</div><!-- End .rating-container -->

							<div class="product-price">
							  <?php echo checkproductPRICE($productID);?>
							</div><!-- End .product-price -->
							<?php 
							$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID'") or die("Unable to get records:".sqlERROR_LABEL());			

							$count_productvariant_list = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
							//for variant product only
							if($count_productvariant_list > 0) {
								$stock_label = 'N/A';
								$stock_label_class = '';
							}
							?>
							<p class="stock <?php echo $stock_label_class; ?> text-dark" id="defalut_instock">
							Availability: <span> <?php echo $stock_label; ?></span>
							</p>
							<form action="" id="buy_block" method="post">
							<span id="show_ajax_stock_response"></span>
							<div class="product-content">
								<?php echo $productspecialnotes; ?>
							</div><!-- End .product-content -->
							<?php 
							//echo $productID;
							$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID'") or die("Unable to get records:".mysqli_error());			
							  
							  $count_productvariant_list = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
							  if($count_productvariant_list > 0) {
							?>
								<div class="details-filter-row details-row-size mb-md-1">
								<label>Size:</label>
								<div class="product-size" id="product-size">
									<?php
									while($variant_row = sqlFETCHARRAY_LABEL($check_prdt_variant_datas)){
										$variant_ID = $variant_row["variant_ID"];
										$variant_name = $variant_row["variant_name"];
										$variantstockstatus = $variant_row["variantstockstatus"];
										$variant_msp_price = $variant_row["variant_msp_price"];
										//echo $variant_ID;
									?>
									<a href="javascript:;" Onclick="getSIZE(<?php echo $variant_ID; ?>);" title="<?php echo general_currency_symbol; ?><?php echo number_format($variant_msp_price,2);?>"><?php echo $variant_name; ?></a>
									<?php
									}
									?>
								</div><!-- End .product-size -->

								<a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
							</div>
							<?php } ?>
							<div class="details-filter-row details-row-size">
								<label for="qty">Qty:</label>
								<div class="product-details-quantity">
									<input type="number" id="qty" name="qty" class="form-control" value="1" required>
								</div><!-- End .product-details-quantity -->
							</div><!-- End .details-filter-row -->
							<input type="hidden" name="current_session" id="current_session" value="<?php echo $sid; ?>" />
							<input type="hidden" name="product_id" id="product_id" value="<?php echo $productID; ?>" id="product_id" />
							<input type="hidden" name="product_size" id="product_size" value="<?php echo $variant_ID; ?>"/>
							<input type="hidden" name="available_stock" id="available_stock" value="<?php echo $productavailablestock; ?>" />
							<input type="hidden" name="product_price" id="idCombination" value="<?php echo $sellingprice_unformatted; ?>" />
							<input type="hidden" name="product_color" id="color" value="<?php echo "#" ?>" />
							<div class="product-details-action">
								<button type="submit" id="add_to_cart_in_details" name="add_to_cart_in_details" value="add_to_cart_in_details" class="btn-product btn-cart">add to cart</span></button>
								
								<div class="details-action-wrapper">
									<a onClick="product_wishlist(<?php echo $productID; ?>)" href="javascript:void(0);" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
								</div><!-- End .details-action-wrapper -->
							</div><!-- End .product-details-action -->

							<div class="product-details-footer">
								<div class="product-cat">
									<span>Category:</span>
									<?php 
									$categories = '';
									$cats = explode(",", $productcategory);
									foreach($cats as $cat) {
										$cat = trim($cat);
										$__category_title = getSINGLEDBVALUE('categoryname', " categoryID='$cat' and deleted='0' and status = '1'", 'js_category', 'label');
										$categories .= " <a target='_blank' href='category.php?token=".$cat."-".convertSEOURL($__category_title)."'>" . $__category_title . "</a>,";
									}
									echo substr($categories, 0, -1);
									?>
								</div><!-- End .product-cat -->

								<div class="social-icons social-icons-sm">
									<span class="social-label">Share:</span>
									<a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
									<a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
									<a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
									<a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
								</div>
							</div><!-- End .product-details-footer -->
						</div><!-- End .product-details -->
					</div><!-- End .col-md-6 -->
				</div><!-- End .row -->
			</div><!-- End .product-details-top -->

			<div class="product-details-tab">
				<ul class="nav nav-pills justify-content-center" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
						<div class="product-desc-content">
							<?php echo html_entity_decode($productdescrption); ?>
						</div><!-- End .product-desc-content -->
					</div><!-- .End .tab-pane -->
					<div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
						<div class="product-desc-content">
							<?php echo html_entity_decode($productpropertydescrption); ?>
						</div><!-- End .product-desc-content -->
					</div><!-- .End .tab-pane -->
					<div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
						<div class="product-desc-content">
							<h3>Delivery & returns</h3>
							<p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a><br>
							We hope you’ll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns information</a></p>
						</div><!-- End .product-desc-content -->
					</div><!-- .End .tab-pane -->
				</div><!-- End .tab-content -->
			</div><!-- End .product-details-tab -->

			</form>
			
			<h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->

			<div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
				data-owl-options='{ "nav": false, "dots": true, "margin": 20, "loop": false, "responsive": { "0":{"items":1},"480": {"items":2}, "768": {"items":3}, "992": {"items":4}, "1200": {"items":4, "nav": true, "dots": false } }}'>
					<?php
					$list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where productID > '$productID' and deleted = '0' and status = '1' Limit 0, 6") or die("#1-Unable to get records:".mysql_error());
					
					  $count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
					  
						if($count_product_list >0) {
						  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
							  $counter++;
							  $productID = $row["productID"];
							  $productsku = $row["productsku"];
							  $producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
							  $productsellingprice = formatCASH($row["productsellingprice"]);
							  $productMRPprice = formatCASH($row["productMRPprice"]);
							  $productavailablestock = $row["productavailablestock"];
							  $productstockstatus = $row["productstockstatus"];  //stock status
								
							  $custom_producttitle = limit_words($producttitle, 4);
							  
								if($productstockstatus == '0') {
									$outofstock_label = 'Out of Stock';
								}
					  
						?>
						<div class="product product-7 text-center">
							<figure class="product-media">
								<?php if($productstockstatus == '0') { echo '<span class="product-label label-new">'.$outofstock_label.'</span>'; } ?>
								<a href="product.php?token=<?php echo $productID.'-'.$productsku; ?>" class="product-image" target="_blank">
									<?php
									
									$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());
									  while($featured_image = sqlFETCHARRAY_LABEL($featured_product_image)){
										  $productmediagallerytitle = $featured_image["productmediagallerytitle"];
										  $productmediagalleryurl = $featured_image["productmediagalleryurl"];
									?>
									<img class="product-image" src="uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" title="<?php echo $productmediagallerytitle; ?>" alt="<?php echo $productmediagallerytitle; ?>">                               
									<?php
									
									  }
									  
									?>
								</a>

								<div class="product-action-vertical">
									<a onClick="product_wishlist(<?php echo $productID; ?>)" href="javascript:void(0);" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
								</div><!-- End .product-action-vertical -->

							</figure><!-- End .product-media -->

							<div class="product-body">
								<h3 class="product-title">
								<a href="product.php?token=<?php echo $productID.'-'.$productsku; ?>" target="_blank">
									<?php if(strlen($custom_producttitle) > 35) { $add_moredots='...'; } 
										echo $custom_producttitle.$add_moredots; 
									?>
								</a>
								</h3><!-- End .product-title -->
								<div class="product-price">
									<span class="new-price">₹ <?php echo $productsellingprice; ?></span><span class="old-price">₹ <?php echo $productMRPprice; ?></span>
								</div><!-- End .product-price -->
							</div><!-- End .product-body -->
						</div><!-- End .product -->
																				   
					<?php 
						} //end of while loop 
					}
					?>                        
			
			</div><!-- End .owl-carousel -->
		</div><!-- End .container -->
	</div><!-- End .page-content -->
</main><!-- End .main -->