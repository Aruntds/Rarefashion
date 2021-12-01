<?php
$setting_front_page = sqlQUERY_LABEL("SELECT _settings_frontpage_featuredshow, _settings_frontpage_featuredproducts FROM `js_settingfrontpage`") or die("Unable to get records:".mysql_error());			
$check_record_availabity = sqlNUMOFROW_LABEL($setting_front_page);			
while($setting_front = sqlFETCHARRAY_LABEL($setting_front_page)){
	//Store Front Page - Product Settings
	$frontpage_featuredshow = $setting_front["_settings_frontpage_featuredshow"];
	$frontpage_featuredproducts = $setting_front["_settings_frontpage_featuredproducts"];
}
if($frontpage_featuredshow == '1') {
	
$arr = explode(",", $frontpage_featuredproducts);
//print_r($arr);
//for ($flag = 1; $flag <= count($arr); $flag++) {
//	echo $arr[$flag].'++<br >';
//    // insert Data
//	if ($flag%2 == 0)
//   echo '-<br/><br/>'; 
//   $flag+1;     
//}
?>
            <div class="bg-light-2 pt-6 pb-6 featured">
                <div class="container-fluid">
                    <div class="heading heading-center mb-3">
                        <h2 class="title">FEATURED PRODUCTS</h2><!-- End .title -->
 
                    </div><!-- End .heading -->

                     
                        <div class=" p-0 fade show active">
                            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                                data-owl-options='{                                    "nav": false,                                     "dots": true,                                    "margin": 20,                                    "loop": false,                                    "responsive": {                                        "0": {                                            "items":2                                        },                                        "480": {                                            "items":2                                        },                                        "768": {                                            "items":3                                        },                                        "992": {                                            "items":4                                        },                                        "1200": {                                            "items":5,                                            "nav": true                                        }                                    }                                }'>
								<?php
					
				for ($flag = 0; $flag <= count($arr); $flag++) {
					$list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where productID = '$arr[$flag]' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
					
					  $count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
					
					  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
						  $productID = $row["productID"];
						  $productsku = $row["productsku"];
						  $producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
						  $producttitle = str_replace("\'","'",$producttitle); //$row["producttitle"];
						  $productsellingprice = formatCASH($row["productsellingprice"]);
						  $productMRPprice = formatCASH($row["productMRPprice"]);
						  $productavailablestock = $row["productavailablestock"];
						  $productstockstatus = $row["productstockstatus"];  //stock status
						  
						  //product title
						  $custom_producttitle = limit_words($producttitle, 4);
						  
							if($productstockstatus == '0') {
								$outofstock_label = 'Out of Stock';
							}
					?>
                                <div class="product product-7 text-center">
                                    <figure class="product-media">
                                        <a href="product.php?token=<?php echo $productID.'-'.$productsku; ?>" >
										<?php	
										$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
										  while($featured_image = sqlFETCHARRAY_LABEL($featured_product_image)){
											  $productmediagallerytitle = $featured_image["productmediagallerytitle"];
											  $productmediagalleryurl = $featured_image["productmediagalleryurl"];
										?>
                                            <img src="uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" title="<?php echo $productmediagallerytitle; ?>" alt="<?php echo $productmediagallerytitle; ?>">
											<?php
										
										  }
										  
										$gallery_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='0' and productmediagallerytype='1' and deleted = '0' and status = '1' LIMIT 1") or die("#1-Unable to get records:".mysqli_error());
										  while($product_gallery_image = sqlFETCHARRAY_LABEL($gallery_product_image)){
											  $product_gallerytitle = $product_gallery_image["productmediagallerytitle"];
											  $product_galleryurl = $product_gallery_image["productmediagalleryurl"];
										?>
                                            <img src="uploads/productmediagallery/<?php echo $product_galleryurl; ?>" title="<?php echo $product_gallerytitle; ?>" alt="<?php echo $product_gallerytitle; ?>" class="product-image-hover">
											<?php
										  }
										?>
                                        </a>
										<div class="product-action-vertical">
										<?php 
										$list_variant_size = sqlQUERY_LABEL("SELECT variant_name,variant_ID FROM js_productvariants WHERE parentproduct = '$productID' and deleted = '0' LIMIT 1") or die ("#1-Unable to get records:".mysqli_error());
									//if(sqlNUMOFROW_LABEL($list_variant_size)){
									$check_list_variant_size = sqlNUMOFROW_LABEL($list_variant_size);
									//echo $check_list_variant_size;exit();
									if($check_list_variant_size > 0){
										while($list_variant_size_data = sqlFETCHARRAY_LABEL($list_variant_size)){
										$variant_name = $list_variant_size_data['variant_name'];
										$variant_IDs = $list_variant_size_data['variant_ID'];
									}
									}else{
										$variant_IDs = '';
									}
									?>
                                            <a onClick="product_wishlist(<?php echo $productID; ?>,<?php echo $variant_IDs; ?>)" href="javascript:void(0);"  class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
											<a href="#" class="btn-product-icon btn-quickview btn-expandable" title="Sizes"><span style="font-weight:600;">
											
                                           <?php  
										   $show_variant_size = sqlQUERY_LABEL("SELECT variant_name,variant_ID FROM js_productvariants WHERE parentproduct = '$productID' and deleted = '0'") or die ("#1-Unable to get records:".mysqli_error());
										   if(sqlNUMOFROW_LABEL($show_variant_size)){
											   while($show_variant_size_data = sqlFETCHARRAY_LABEL(				$show_variant_size)){
												$variant_name = $show_variant_size_data['variant_name'];
												$variant_ID = $show_variant_size_data['variant_ID'];
												?>
									
										<?php echo $variant_name." | "; ?>
										<?php } ?>
										</span></a>
										<?php 
										} ?>
                                        </div><!-- End .product-action-vertical -->
                                     </figure><!-- End .product-media -->

                                    <div class="product-body">
									<div class="product-title">
                                       <a href="product.php?token=<?php echo $productID.'-'.$productsku; ?>" target="_blank">
									<?php if(strlen($custom_producttitle) > 35) { $add_moredots='...'; } echo $custom_producttitle.$add_moredots; ?>
									</div>
								</a>
                                        <div class="product-price">
                                       <?php echo checkproductPRICE($productID);?>
                                        </div><!-- End .product-price -->
                                         
                                    </div><!-- End .product-body -->
                                </div><!-- End .product -->
					<?php
					
					  }
					  //$flag+1;
					}
					
					?>
                              </div><!-- End .owl-carousel -->
                        </div><!-- .End .tab-pane -->
                      <!-- End .tab-content -->
                </div><!-- End .container-fluid -->
            </div><!-- End .bg-light-2 pt-4 pb-4 -->
<?php } ?>
