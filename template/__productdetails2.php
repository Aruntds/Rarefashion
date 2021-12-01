<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0" style="background-color:#f9f9f9;">
		<div class="container d-flex align-items-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.html">Home</a></li>
				<li class="breadcrumb-item"><a href="#">Products</a></li>
				<li class="breadcrumb-item active" aria-current="page">Product Info</li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->

	<div class="page-content">
		<div class="container">
		<!--<div class="product-gallery-carousel owl-carousel owl-full owl-nav-dark owl-loaded owl-drag">
                            <div class="owl-stage-outer">
							<div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0.4s ease 0s; width: 1558px;">
							<div class="owl-item active" style="width: 119.333px;">
							<figure class="product-gallery-image">
                                    <img src="assets/images/products/single/gallery/1.jpg" data-zoom-image="assets/images/products/single/gallery/1-big.jpg" alt="product image">
                                </figure></div>
								<div class="owl-item active" style="width: 119.333px;"><figure class="product-gallery-image">
                                    <img src="assets/images/products/single/gallery/2.jpg" data-zoom-image="assets/images/products/single/gallery/2-big.jpg" alt="product image">
                                </figure></div>
								<div class="owl-item active" style="width: 119.333px;"><figure class="product-gallery-image">
                                    <img src="assets/images/products/single/gallery/2.jpg" data-zoom-image="assets/images/products/single/gallery/2-big.jpg" alt="product image">
                                </figure></div>
								<div class="owl-item active" style="width: 119.333px;"><figure class="product-gallery-image">
                                    <img src="assets/images/products/single/gallery/3.jpg" data-zoom-image="assets/images/products/single/gallery/3-big.jpg" alt="product image">
                                </figure></div>
								<div class="owl-item active" style="width: 389.333px;"><figure class="product-gallery-image">
                                    <img src="assets/images/products/single/gallery/4.jpg" data-zoom-image="assets/images/products/single/gallery/4-big.jpg" alt="product image">
                                </figure></div></div></div>
				<div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button>
				</div>
			<div class="owl-dots disabled">
			</div>
		</div>-->
			<div class="product-details-top">
				<div class="row">
					<div class="col-md-6">
						<div class="product-gallery product-gallery-vertical">
							<div class="row">
								<?php
								$productIDs =$productID;
								$productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$productID' and deleted = '0' order by productmediagalleryfeatured DESC, productmediagallerytype ASC Limit 0,1") or die("#1-Unable to get records:".mysqli_error());

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
									 
								<figure class="product-main-image">
									<img id="product-zoom" src="<?php echo $media_path; ?>" data-zoom-image="<?php echo $media_path; ?>" alt="product image">

									<a href="#" id="btn-product-gallery" class="btn-product-gallery">
										<i class="icon-arrows"></i>
									</a>
								</figure><!-- End .product-main-image -->

								<div id="product-zoom-gallery" class="product-image-gallery" style="height:10%">
								<?php
								$productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$productID' and deleted = '0' order by  productmediagalleryfeatured DESC, productmediagallerytype ASC ") or die("#1-Unable to get records:".mysqli_error());

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
											<a class="product-gallery-item active" href="#" data-image="<?php echo $media_path; ?>" data-zoom-image="<?php echo $media_path; ?>">
												<img src="<?php echo $media_path; ?>" alt="product side">
											</a>
									<?php  
									} 
									} 
									} ?> 
								</div><!-- End .product-image-gallery -->
								<?php 
								}
								  }
								}								  ?>
							</div><!-- End .row -->
						</div><!-- End .product-gallery -->
					</div><!-- End .col-md-6 -->

					<div class="col-md-6">
						<div class="product-details">
							<h1 class="product-title"><?php echo $producttitle; ?></h1><!-- End .product-title -->
							
							<?php                          
								// echo "SELECT count(`review_ID`) AS `total_review_count` FROM `js_review` WHERE review_type = '1' and product_ID = '$productID' and deleted = '0' and `status` = '1'";
									$query= "SELECT count(`review_ID`) AS `total_review_count` FROM `js_review` WHERE review_type = '1' and product_ID = '$productID' and deleted = '0' and `status` = '1'";	
						
						
								$result = sqlQUERY_LABEL($query);
								$result_num = sqlNUMOFROW_LABEL($result);
								
								while($row = sqlFETCHARRAY_LABEL($result))
								{
									$total_sum_of_cart = $row['total_review_count'];
								}
								
							?>
							<div class="ratings-container">
								<!--<div class="ratings">
									<div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
								<!--</div><!-- End .ratings -->
								<a class="ratings-text"  href="#product-details-tab" onclick="select_tab_reviews()" id="review-link">( <?php echo $total_sum_of_cart; ?> Reviews )</a>
							</div><!-- End .rating-container -->

							<div class="product-price mt-2 mb-0" id="default_price">
								<?php echo checkproductPRICE($productID);?>
							</div><!-- End .product-price -->

							<div id="variant_price" class="product-price"></div>

							<div class="product-content mb-0">
								<p><?php echo $productspecialnotes; ?></p>
							</div><!-- End .product-content -->

							<div class="details-filter-row details-row-size mt-1 mb-0">
								<?php
						 // echo "SELECT productrelated_items FROM `js_product` where productID='$productID' and deleted = '0'";
										$related_product = sqlQUERY_LABEL("SELECT productrelated_items FROM `js_product` where productID='$productID' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());
										
										$count_related_product = sqlNUMOFROW_LABEL($related_product);
										$row_related = sqlFETCHARRAY_LABEL($related_product);
										$relatedproduct_list = $row_related["productrelated_items"];
										$relatedproduct_list_array = explode(",", $relatedproduct_list);
										if($relatedproduct_list != '') { ?>
											<label>Color:</label>
											<div class="product-nav product-nav-thumbs">
								<?php
										foreach($relatedproduct_list_array as $selectedproduct) {
											
											$selectedproduct_id = trim($selectedproduct);
														//echo "SELECT `productID`, `producttitle`, `productsku` FROM `js_product` where productID = '$selectedproduct_id' and  deleted = '0'";exit();
											$list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `producttitle`, `productsku` FROM `js_product` where productID = '$selectedproduct_id' and  deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());
											$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
											
											if($count_product_list > 0 && $count_product_list != 9 ) {

											  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
												  $product_ID = $row["productID"];
												  $producttitle = limit_words($row["producttitle"], 8);
												  $productsku = $row["productsku"];
											//echo "SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$product_ID' and deleted = '0' order by productmediagalleryorder ASC, productmediagalleryfeatured DESC, productmediagallerytype ASC LIMIT 1";exit();
													  $productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$product_ID' and deleted = '0' order by productmediagalleryorder ASC, productmediagalleryfeatured DESC, productmediagallerytype ASC LIMIT 1") or die("#1-Unable to get records:".sqlERROR_LABEL());
													
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
															<a href="product.php?token=<?php echo $product_ID.'-'.$productsku; ?>" class="active">
																<img src="<?php echo $media_path; ?>" alt="product desc">
															</a>
															<?php 
															}
														} 
													} //end of count
											  }
											  
											}
											
										}
										?>
										
									</div><!-- End .product-nav -->
										<?php 
										}
										?>
							</div><!-- End .details-filter-row -->
							<?php 
							//echo "SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID'";
							$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID' and variant_available_stock > '0'") or die("Unable to get records:".sqlERROR_LABEL());	
							
							$count_product_availablecount = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
							
                            if(($count_product_availablecount == 0)){
								$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where deleted = '0' and status = '1' and productstockstatus='1' and `productID`='$productID' and productavailablestock > '0'") or die("Unable to get records:".sqlERROR_LABEL());	
							}							
							$count_productvariant_list = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
							//for variant product only
							if($count_productvariant_list > 0) {
								$stock_label = 'In Stock';
								$stock_label_class = 'text-success';
								$cartbutton_disable = "";
							} else {
								$stock_label = 'Out Of Stock';
								$stock_label_class = 'text-danger';
								$cartbutton_disable = "disabled";
							}
							?>
							<p class="stock text-dark mt-2" id="defalut_instock" style="padding-bottom:2px; color:red;">
							Availability: <span class="<?php echo $stock_label_class; ?>"> <?php echo $stock_label; ?></span>
							</p>

							<form action="" id="buy_block" method="post">
							<span id="show_ajax_stock_response"></span>
							<?php 
							//echo $productID;
							$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID'") or die("Unable to get records:".mysqli_error());			
							  
							  $count_productvariant_list = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
							  if($count_productvariant_list > 0) {
							?>
							<div class="details-filter-row details-row-size mt-2">
								<label for="size">Size:</label>
								<div class="product-size" id="product-size">
									<?php
									while($variant_row = sqlFETCHARRAY_LABEL($check_prdt_variant_datas)){
										$variant_size_count++;
										$variant_ID = $variant_row["variant_ID"];
										$variant_name = $variant_row["variant_name"];
										$variantstockstatus = $variant_row["variantstockstatus"];
										$variant_msp_price = $variant_row["variant_msp_price"];
										$variant_taxsplit1 = $variant_row["variant_taxsplit1"];
										$variant_taxsplit2 = $variant_row["variant_taxsplit2"];
										$tot_tax_value = $variant_taxsplit1 + $variant_taxsplit2;
										//echo $variant_ID;
									?>
									<input type="hidden" id="variant_count" value="<?php echo $variant_size_count; ?>">
									<?php if($variant_size_count == 1 ){ ?>
									<a href="javascript:;" class="active" Onclick="getSIZE('<?php echo $variant_ID; ?>','<?php echo $variant_msp_price+$tot_tax_value; ?>','<?php echo $variant_size_count; ?>');" title="<?php echo general_currency_symbol; ?><?php echo number_format($variant_msp_price+$tot_tax_value,2);?>" id="variant_size_display"><?php echo $variant_name; ?></a>
									<?php } else { ?>
									<a href="javascript:;" Onclick="getSIZE('<?php echo $variant_ID; ?>','<?php echo $variant_msp_price+$tot_tax_value; ?>','<?php echo $variant_size_count; ?>');" title="<?php echo general_currency_symbol; ?><?php echo number_format($variant_msp_price+$tot_tax_value,2);?>" ><?php echo $variant_name; ?></a>
									<?php } ?>
									<?php
									}
									?>
								</div><!-- End .product-size -->

								<a href="#" data-toggle="modal" data-target="#exampleModal" class="size-guide"><i class="icon-th-list"></i>size guide</a>
								
								<div class="modal fade text-center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding:10px;">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Size Guide</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body text-center">
										<img src = "assets/images/size_chart.png" width="100%">
									  </div>
									</div>
								  </div>
								</div>
							</div><!-- End .details-filter-row -->
							
							<?php } ?>

							<div class="details-filter-row details-row-size">
								<label for="qty">Qty:</label>
								<div class="product-details-quantity">
									<input type="number" id="qty" name="qty" class="form-control" value="1" min="1" required>
								</div><!-- End .product-details-quantity -->
							</div><!-- End .details-filter-row -->
							<input type="hidden" name="current_session" id="current_session" value="<?php echo $sid; ?>" />
							<input type="hidden" name="product_id" id="product_id" value="<?php echo $productID; ?>" id="product_id" />
							<?php 
							$check_prdt_variant_datas_selected = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID' LIMIT 1") or die("Unable to get records:".mysqli_error());	
									while($variant_row_selected = sqlFETCHARRAY_LABEL($check_prdt_variant_datas_selected)){
										$variant_size_count++;
									$variant_ID_selected = $variant_row_selected["variant_ID"];
									}
										?>
							<input type="hidden" name="product_size" id="product_size" value="<?php echo $variant_ID_selected; ?>"/>
							<input type="hidden" name="available_stock" id="available_stock" value="<?php echo $productavailablestock; ?>" />
							<input type="hidden" name="product_price" id="idCombination" value="<?php echo $sellingprice_unformatted; ?>" />
							<input type="hidden" name="product_color" id="color" value="<?php echo "#" ?>" />

							<div class="product-details-action">
								<button type="submit" id="add_to_cart_in_details" name="add_to_cart_in_details" value="add_to_cart_in_details" class="btn-product btn-cart" <?php echo $cartbutton_disable; ?>>ADD TO CART</button>

								<div class="details-action-wrapper">
									<a onClick="product_wishlist(<?php echo $productID; ?>)" href="javascript:void(0);" class="btn-product btn-wishlist" title="Wishlist"><span>ADD TO WISHLIST</span></a>
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
								<?php 
								 //echo "select * FROM `js_settinggeneral` where `createdby`='$logged_id'";exit();
								 $select_itemlist = sqlQUERY_LABEL("select * FROM `js_settinggeneral` where `_generalID`='1'") or die(sqlERROR_LABEL());
									$result_count = sqlNUMOFROW_LABEL($select_itemlist);
									 while($collect_item_list = sqlFETCHARRAY_LABEL($select_itemlist)) {
										$facebook = $collect_item_list['__general_facebook'];
										$instagram = $collect_item_list['__general_instagram'];
										$twitter = $collect_item_list['__general_twitter'];
										$pinterst = $collect_item_list['__general_pintrest'];
										
									}
								?>
								<div class="social-icons social-icons-sm">
									<span class="social-label">Share:</span>
									<a href="<?php echo $facebook ;?>" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
									<a href="<?php echo $twitter ;?>" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
									<a href="<?php echo $instagram ;?>" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
									<a href="<?php echo $pinterst ;?>" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
								</div>
							</div><!-- End .product-details-footer -->
						</div><!-- End .product-details -->
					</div><!-- End .col-md-6 -->
				</div>
			  </form>
			</div>
			<div class="product-details-tab" id="product-details-tab">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping &amp; Returns</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (<?php echo $total_sum_of_cart;?>)</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    
								<?php if($productpropertydescrption != ''){
									echo html_entity_decode($productdescrption); 
								} else { ?>
									<div class="tx-gray-400 mg-t-60 text-center tx-24">No Features Available right now</div>
								<?php }
								?>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                                <div class="product-desc-content">
                                    <h3>Additional Information</h3>
									<?php if($productpropertydescrption != ''){
									echo html_entity_decode($productpropertydescrption); 
								} else { ?>
									<div class="tx-gray-400 mg-t-60 text-center tx-24">No Properties Available right now</div>
								<?php }
								?>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                                <div class="product-desc-content">
                                    <p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a><br>
									We hope you&rsquo;ll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns information</a></p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                                <div class="reviews">
                                    <h3 class="text-center">Reviews (<?php echo $total_sum_of_cart;?>)</h3>
									<div id="product-accordion-review" class="collapse" aria-labelledby="product-review-heading" data-parent="#product-accordion" style="padding: 0px 190px 0px 190px; display:block; ">
									
									
									
                                             <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span>
												
                                                    Required fields are marked <span class="required">*</span></p>
                                               
                                                    <label for="author">Name&nbsp;<span class="required">*</span></label>
												 <input type="hidden" name="product_id" id="product_id" class="form-control" value="<?php echo $productID;?>">
                                                     <input size="25" name="review_name" id="review_name" class="form-control" type="text"></br>
                                             <label for="email">Email&nbsp;<span class="required">*</span></label>
                                                    <input size="25" type="email" class="form-control" name="review_email" id="review_email">
                                                <div class="comment-form-rating" style="margin-top:20px"><label for="rating">Your rating </label> <span class="required">*</span><br>
												 <div class="rating">
													<input type="radio" id="star5" name="rating" value="5"><label for="star5" title="Rocks!">5 stars</label>
													<input type="radio" id="star4" name="rating" value="4"><label for="star4" title="Pretty good">4 stars</label>
													<input type="radio" id="star3" name="rating" value="3"><label for="star3" title="Meh">3 stars</label>
													<input type="radio" id="star2" name="rating" value="2"><label for="star2" title="Kinda bad">2 stars</label>
													<input type="radio" id="star1" name="rating" value="1"><label for="star1" title="Sucks big time">1 star</label>
												</div>
												</div>
												  <br><br>	
                                                 <label for="comment">Your review<span class="required">*</span></label>
													<textarea name="review_discription" id="review_discription" class="form-control" cols="60" rows="6"  maxlength="150" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" onpaste="return false;" style="width:100%;"></textarea>
														<span id="error" style="color: Red; display: none">* Special Characters not allowed.</span><br>
											<!--<button type="button" name="Submit_review" id="Submit_review" onclick="add_review();" class="btn button" value="Submit_review" style="background-color:black;color:white;width:150px;height:40px;"> Submit</button></br></br>-->
											<button  type="button" name="Submit_review" value="Submit_review" id="Submit_review" onclick="add_review();" class="btn button btn-outline-primary-2 col-12 mb-2">Save</button>	
                                  	
									<?php	
									// echo "SELECT * FROM `js_review` where deleted = '0' and status='1' and product_ID = '$productID' order by review_ID desc";
										$get_reviews_value = sqlQUERY_LABEL("SELECT * FROM `js_review` where deleted = '0' and status='1' and product_ID = '$productID' order by review_ID desc") or die("Unable to get records:".mysqli_error());
										while($variant_row = sqlFETCHARRAY_LABEL($get_reviews_value)){
										$review_name = $variant_row["review_name"];
										//echo $review_name;
										$review_email = $variant_row["review_email"];
										
										$rating = $variant_row["rating"];
										$review_discription = $variant_row["review_discription"];
										$createdon = $variant_row["createdon"];
										//echo $variant_ID;
									if($createdon == '0000-00-00 00:00:00' || $createdon == ''){$rating_date = 'N/A';}
									else{
			                        $rating_date = date('jS M, Y, h:i A',strtotime($createdon));
	                                    	} 
									?>

										
                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-5">
                                                <h4><a href="#"><?php echo $review_name;?></a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">														
													<?php if($rating == '1') {?>
														<div class="ratings-val" style="width: 20%;"></div>
													<?php } if($rating == '2') {?>
														<div class="ratings-val" style="width: 40%;"></div>
													<?php } if($rating == '3') {?>
														<div class="ratings-val" style="width: 60%;"></div>
													<?php } if($rating == '4') {?>
														<div class="ratings-val" style="width: 80%;"></div>
													<?php } if($rating == '5') {?>
														<div class="ratings-val" style="width: 100%;"></div>
													<?php } ?>
                                                    </div><!-- End .ratings -->
                                                </div><!-- End .rating-container -->
                                                <span class="review-date"><?php echo $rating_date;?></span>
                                            </div><!-- End .col -->
                                            <div class="col-7">
                                                <!--<h4>Good, perfect size</h4>-->

                                                <div class="review-content">
                                                    <p><?php echo $review_discription;?></p>
                                                </div><!-- End .review-content -->
												
                                            </div><!-- End .col-auto -->
                                        </div><!-- End .row -->
                                    </div><!-- End .review -->
										
										<?php } ?>
									</div>
                                    
                                </div><!-- End .reviews -->
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div>
				
			<h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
			<div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
				data-owl-options='{ "nav": false, "dots": true, "margin": 20, "loop": false, "responsive": { "0":{"items":1},"480": {"items":2}, "768": {"items":3}, "992": {"items":4}, "1200": {"items":4, "nav": true, "dots": false } }}'>
					<?php
					$list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where productID > '$productID' and deleted = '0' and status = '1' Limit 0, 6") or die("#1-Unable to get records:".mysql_error());
					
					  $count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
					  
						if($count_product_list >0) {
						  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
							  $counter++;
							  $productID_ = $row["productID"];
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
								<a href="product.php?token=<?php echo $productID_.'-'.$productsku; ?>" class="product-image">
									<?php
									
									$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID_' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());
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
									<a onClick="product_wishlist(<?php echo $productID_; ?>)" href="javascript:void(0);" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
								</div><!-- End .product-action-vertical -->

							</figure><!-- End .product-media -->

							<div class="product-body">
								<h3 class="product-title">
								<a href="product.php?token=<?php echo $productID_.'-'.$productsku; ?>">
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
			
			<div class="product-area text-center ptb-60">
			<?php 
			//echo $productIDs;exit();
			//echo "SELECT productupsell_items FROM `js_product` where productID='$productID' and deleted = '0'";exit();
			$related_product = sqlQUERY_LABEL("SELECT productupsell_items FROM `js_product` where productID='$productID' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());
                        
			$count_upsell_product = sqlNUMOFROW_LABEL($related_product);
			$row_upsell = sqlFETCHARRAY_LABEL($related_product);
			$upsellproduct_list = $row_upsell["productupsell_items"];
			if($upsellproduct_list != NULL || $upsellproduct_list != '' ) {
			?>
    <div class="container">
        <div class="section-title">
            <!--<span>new shop item</span>-->
            <h4><span>Others Also Bought</span></h4>
        </div>
    </div>
    <div class="container fix">
        <div class="row">
            <?php
			$upsellproduct_list_array = explode(",", $upsellproduct_list);
			foreach($upsellproduct_list_array as $selected_product) {
				
			$selectedproduct_id_ = trim($selected_product);
			//echo $selectedproduct_id_;exit();
			$list_product_datas = sqlQUERY_LABEL("SELECT js_product.`productID`, js_product.`productsku`, js_product.`producttitle`, js_product.`productsellingprice`, js_productvariants.`variant_taxsplit1`, js_productvariants.`variant_taxsplit2`, js_productvariants.`variant_mrp_price` as productMRPprice, js_productvariants.`variantstockstatus` as productstockstatus, js_productvariants.`variant_available_stock` as productavailablestock FROM js_product, js_productvariants where js_product.productID = '$selectedproduct_id_' and js_productvariants.parentproduct  = '$selectedproduct_id_' Limit 1") or die("Unable to get records:".sqlERROR_LABEL());	
							
			$count_product_availablecount = sqlNUMOFROW_LABEL($list_product_datas);
							//echo "$count_product_availablecount";exit();
            if(($count_product_availablecount == 0)){
			// echo "test";exit();
			 $list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where productID='$selectedproduct_id_' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
								
		    }
		//exit();
			  $count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
			  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
				  $counter++;
				  $product_ID = $row["productID"];
				  $productsku = $row["productsku"];
				  $producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
				  $productsellingprice = $row["productsellingprice"];
				  if($count_product_availablecount > 0){
					  
				  $product_taxsplit1 = $row["variant_taxsplit1"];
				  $product_taxsplit2 = $row["variant_taxsplit2"];
				  $final_selling_price = $productsellingprice + $product_taxsplit1 + $product_taxsplit2;
				  $final_selling_price = formatCASH($final_selling_price);
				  
				  }else{
					  
					  $final_selling_price = formatCASH($productsellingprice);
				  }
				 
				  
				  $productMRPprice = formatCASH($row["productMRPprice"]);
				  $productavailablestock = $row["productavailablestock"];
				  $productstockstatus = $row["productstockstatus"];  //stock status
					
					if($productstockstatus == '0' || $productavailablestock == '0') {
						$outofstock_label = 'Out of Stock';
					}
// echo $counter;
			?>
                
            <div class="col-lg-3">
            <div class="product product-7 text-center">
                <?php if($productstockstatus == '0' || $productavailablestock == '0') { echo '<span class="text-danger">'.$outofstock_label.'</span>'; } 
				?>
					
                <div class="product-media">
				
                    <a href="product.php?token=<?php echo $product_ID.'-'.$productsku; ?>">
				
                        <?php
                    
                        $featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$product_ID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
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
					</div>
                </div>
                <div class="product-body">
                    <h3 class="product-title"><a href="product.php?token=<?php echo $product_ID.'-'.$productsku; ?>"><?php echo $producttitle; ?></a></h3>
                    <div class="product-price"><span class="new-price">₹ <?php echo $final_selling_price; ?></span><span class="old-price">₹ <?php echo $productMRPprice; ?></span></div>
                </div>
            </div>
            </div>
            <?php } 
			} ?>
        </div>
    </div>
		<?php } ?>
</div>
			
		</div><!-- End .container -->
	</div><!-- End .page-content -->
</main><!-- End .main -->
