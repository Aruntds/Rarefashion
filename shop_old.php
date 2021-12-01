<?php 
	include 'head/jackus.php'; 
	include '___class__home.inc';

	//page title
	$commontitle = "Shop";
	
	$list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where deleted = '0' and status = '1' LIMIT 0,10") or die("#1-Unable to get records:".mysql_error());
	
	  $count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include '__styles.php'; ?>
</head>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
	<div class="page-wrapper">
    <?php 
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__header'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?> 

        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container-fluid">
        			<h1 class="page-title">
                    <?php echo $commontitle; ?>
                    </h1>
                    <?php echo $categorydescription; ?>
        		</div><!-- End .container-fluid -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container-fluid">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo SITEHOME; ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="category.php">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $categoryname; ?></li>
                    </ol>
                </div><!-- End .container-fluid -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container-fluid">
        			<div class="toolbox">
        				<div class="toolbox-left">
                            <a href="#" class="sidebar-toggler"><i class="icon-bars"></i>Filters</a>
        				</div><!-- End .toolbox-left -->

                        <div class="toolbox-center">
                            <div class="toolbox-info">
                                Showing <span><?php echo $count_product_list; ?></span> Products
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-center -->

        				<div class="toolbox-right">
        					<div class="toolbox-sort">
        						<label for="sortby">Sort by:</label>
        						<div class="select-custom">
									<select name="sortby" id="sortby" class="form-control">
										<option value="popularity" selected="selected">Most Popular</option>
										<option value="rating">Most Rated</option>
										<option value="date">Date</option>
									</select>
								</div>
        					</div><!-- End .toolbox-sort -->
        				</div><!-- End .toolbox-right -->
        			</div><!-- End .toolbox -->

                    <div class="row">
						<?php
							  
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
		
								<div class="col-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
									<div class="product">
										<figure class="product-media">
											<?php if($productstockstatus == '0') { echo '<span class="product-label label-new">'.$outofstock_label.'</span>'; } ?>
											<a href="product.php?token=<?php echo $productID.'-'.$productsku; ?>" target="_blank">
												<?php
												
												$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());
												  while($featured_image = sqlFETCHARRAY_LABEL($featured_product_image)){
													  $productmediagallerytitle = $featured_image["productmediagallerytitle"];
													  $productmediagalleryurl = $featured_image["productmediagalleryurl"];
												?>
												<img class="product-image" src="uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" title="<?php echo $producttitle; ?>" alt="<?php echo $producttitle; ?>">                               
												<?php
												
												  }
												  
												?>
											</a>

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
											<div class="product-action-vertical">
												<a onClick="product_wishlist(<?php echo $productID; ?>,<?php echo $variant_IDs; ?>)" href="javascript:void(0);" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
												<?php 
												$list_variant_size = sqlQUERY_LABEL("SELECT variant_name FROM js_productvariants WHERE parentproduct = '$productID' and deleted = '0'") or die ("#1-Unable to get records:".mysqli_error());
												if(sqlNUMOFROW_LABEL($list_variant_size)){
												
												//print_r($variant_name);
												?>
												<a href="#" class="btn-product-icon btn-quickview btn-expandable" title="Sizes"><span style="font-weight:600;">
												<?php
												while($list_variant_size_data = sqlFETCHARRAY_LABEL($list_variant_size)){
												$variant_name = $list_variant_size_data['variant_name'];
												?>
												<?php echo $variant_name.', '; ?>
												<?php } ?>
												</span></a>
												<?php 
												}
												?>
											</div><!-- End .product-action -->

											<!-- <div class="product-action action-icon-top">
												<a href="product.php?token=<?php echo $productID.'-'.$productsku; ?>" class="btn-product btn-cart"><span>add to cart</span></a>
												<a href="product.php?token=<?php echo $productID.'-'.$productsku; ?>" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
											</div>End .product-action -->
										</figure><!-- End .product-media -->

										<div class="product-body">
											<h3 class="product-title"><a href="product.php?token=<?php echo $productID.'-'.$productsku; ?>" target="_blank"><?php if(strlen($custom_producttitle) > 35) { $add_moredots='...'; } echo $custom_producttitle.$add_moredots; ?></a></h3><!-- End .product-title -->
											<div class="product-price">
												<?php echo checkproductPRICE($productID);?>
											</div><!-- End .product-price -->
											<?php /*<div class="ratings-container">
												<div class="ratings">
													<div class="ratings-val" style="width: 0%;"></div><!-- End .ratings-val -->
												</div><!-- End .ratings -->
												<span class="ratings-text">( 0 Reviews )</span>
											</div><!-- End .rating-container -->

											<div class="product-nav product-nav-dots">
												<a href="#" style="background: #cc9966;"><span class="sr-only">Color name</span></a>
												<a href="#" class="active" style="background: #ebebeb;"><span class="sr-only">Color name</span></a>
											</div><!-- End .product-nav -->*/ ?>
										</div><!-- End .product-body -->
									</div><!-- End .product -->
								</div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
																   
                            <?php 
								} //end of while loop 
							?>
								<!-- End .col-sm-6 col-lg-4 col-xl-3 -->
							</div><!-- End .row -->

							<div class="load-more-container text-center">
								<a href="#" class="btn btn-outline-darker btn-load-more">More Products <i class="icon-refresh"></i></a>
							</div><!-- End .load-more-container -->							
													

                    </div><!-- End .products -->

                    <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
                    <aside class="sidebar-shop sidebar-filter">
                        <div class="sidebar-filter-wrapper">
                            <div class="widget widget-clean">
                                <label><i class="icon-close"></i>Filters</label>
                                <a href="#" class="sidebar-filter-clear">Clean All</a>
                            </div><!-- End .widget -->
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                        Category
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        <div class="filter-items filter-items-count">
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-1">
                                                    <label class="custom-control-label" for="cat-1">Dresses</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">3</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-2">
                                                    <label class="custom-control-label" for="cat-2">T-shirts</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">0</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-3">
                                                    <label class="custom-control-label" for="cat-3">Bags</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">4</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-4">
                                                    <label class="custom-control-label" for="cat-4">Jackets</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">2</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-5">
                                                    <label class="custom-control-label" for="cat-5">Shoes</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">2</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-6">
                                                    <label class="custom-control-label" for="cat-6">Jumpers</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">1</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-7">
                                                    <label class="custom-control-label" for="cat-7">Jeans</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">1</span>
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-8">
                                                    <label class="custom-control-label" for="cat-8">Sportwear</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">0</span>
                                            </div><!-- End .filter-item -->
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                        Size
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-2">
                                    <div class="widget-body">
                                        <div class="filter-items">
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-1">
                                                    <label class="custom-control-label" for="size-1">XS</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-2">
                                                    <label class="custom-control-label" for="size-2">S</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked id="size-3">
                                                    <label class="custom-control-label" for="size-3">M</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked id="size-4">
                                                    <label class="custom-control-label" for="size-4">L</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-5">
                                                    <label class="custom-control-label" for="size-5">XL</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-6">
                                                    <label class="custom-control-label" for="size-6">XXL</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                                        Colour
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-3">
                                    <div class="widget-body">
                                        <div class="filter-colors">
                                            <a href="#" style="background: #b87145;"><span class="sr-only">Color Name</span></a>
                                            <a href="#" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>
                                            <a href="#" style="background: #333333;"><span class="sr-only">Color Name</span></a>
                                            <a href="#" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>
                                            <a href="#" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>
                                            <a href="#" style="background: #669933;"><span class="sr-only">Color Name</span></a>
                                            <a href="#" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>
                                            <a href="#" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>
                                        </div><!-- End .filter-colors -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                        Brand
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-4">
                                    <div class="widget-body">
                                        <div class="filter-items">
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-1">
                                                    <label class="custom-control-label" for="brand-1">Next</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-2">
                                                    <label class="custom-control-label" for="brand-2">River Island</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-3">
                                                    <label class="custom-control-label" for="brand-3">Geox</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-4">
                                                    <label class="custom-control-label" for="brand-4">New Balance</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-5">
                                                    <label class="custom-control-label" for="brand-5">UGG</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-6">
                                                    <label class="custom-control-label" for="brand-6">F&F</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-7">
                                                    <label class="custom-control-label" for="brand-7">Nike</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                        Price
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-5">
                                    <div class="widget-body">
                                        <div class="filter-price">
                                            <div class="filter-price-text">
                                                Price Range:
                                                <span id="filter-price-range"></span>
                                            </div><!-- End .filter-price-text -->

                                            <div id="price-slider"></div><!-- End #price-slider -->
                                        </div><!-- End .filter-price -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </div><!-- End .sidebar-filter-wrapper -->
                    </aside><!-- End .sidebar-filter -->
                </div><!-- End .container-fluid -->
							
			</div><!-- End .page-content -->
        </main><!-- End .main -->

    <?php
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__footer',
		'__scripts'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?>   
</div><!-- End .page-wrapper -->
<script>
	var stock_record = {
			url: function(phrase) {
				return "ajax/ajax_search_products.php?product_info=" + phrase + "&format=json";
			},
			getValue: "product_details",
			template: {
				type: "iconRight",
				fields: {
				  iconSrc: "icon"
				}
			  },

			list: {
				onChooseEvent: function() {
					get_productdtls_List();
				},	
				match: {
                    enabled: false
                },
				
				hideOnEmptyPhrase: true
            },
			theme: "square"
		 };


        $("#productdata").easyAutocomplete(stock_record);
		
		
		function get_productdtls_List()
		{
			var productinfo =document.getElementById( "productdata" ).value;
			
			// alert(vpo_id);
			
		   if(productinfo)
		   {
			   //$('#progress_table').show();
			   $.ajax({
					   type: 'post', 
					   url: 'ajax/ajax_search_productname.php',
					   data: { productinfo:productinfo,
				   },
				   success: function (response) {
						location.assign(response);
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}	
		
		
	</script>
</body>

</html>
