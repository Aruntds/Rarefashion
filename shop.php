<?php 
	include 'head/jackus.php'; 
	include '___class__home.inc';

	$search_value = trim($_REQUEST['search_value']);
	$search_token = trim($_REQUEST['token']);
	
	$category_token = strbefore($_REQUEST['token'], '-');
	//echo $category_token;exit();
	if($category_token) {
		
		$list_category_datas = sqlQUERY_LABEL("SELECT * FROM `js_category` where categoryID = '$category_token' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());

		$count_category_list = sqlNUMOFROW_LABEL($list_category_datas);
          //echo $count_category_list;exit();
		if($count_category_list > 0) {
			while($row = sqlFETCHARRAY_LABEL($list_category_datas)){
				$categoryID = $row["categoryID"];
				$categoryname = html_entity_decode($row["categoryname"], ENT_QUOTES, "UTF-8");
				$categoryimage = $row["categoryimage"];
				//echo $categoryimage;exit();
				$categorydescrption = html_entity_decode($row["categorydescrption"], ENT_QUOTES, "UTF-8");

				$categoryseourl = $row['categoryseourl'];
				$categorymetatitle = htmlentities($row['categorymetatitle'], ENT_QUOTES);
				trim ($categorymetatitle);
				$categorymetakeywords = $row['categorymetakeywords'];
				$categorymetadescrption = $row['categorymetadescrption'];
				$categorydesignsettings = $row['categorydesignsettings'];
				
			}
		
			$commontitle = $categoryname;			
			
			$count_overallproduct = getSINGLEDBVALUE('count(*)', " FIND_IN_SET('$categoryID', productcategory) and deleted='0' and status = '1'", 'js_product', 'label');
			
			$count_product_datas = sqlQUERY_LABEL("SELECT `productID` FROM `js_product` where  FIND_IN_SET('$categoryID', productcategory) and deleted = '0' and status = '1' LIMIT 0,10") or die("#1-Unable to get records:".mysql_error());
			
			$count_product_list = sqlNUMOFROW_LABEL($count_product_datas);
			
		} 
	}elseif($search_value){


		// $list_category_datas = sqlQUERY_LABEL("SELECT * FROM `js_category` where categoryname LIKE '%$search_value%' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());

		// $count_category_list = sqlNUMOFROW_LABEL($list_category_datas);
	
		// if($count_category_list > 0) {
			
			// while($row = sqlFETCHARRAY_LABEL($list_category_datas)){
				// $categoryID = $row["categoryID"];
				
				// $categoryname = html_entity_decode($row["categoryname"], ENT_QUOTES, "UTF-8");
				// $categoryimage = $row["categoryimage"];
				// $categorydescrption = html_entity_decode($row["categorydescrption"], ENT_QUOTES, "UTF-8");

				// $categoryseourl = $row['categoryseourl'];
				// $categorymetatitle = htmlentities($row['categorymetatitle'], ENT_QUOTES);
				// trim ($categorymetatitle);
				// $categorymetakeywords = $row['categorymetakeywords'];
				// $categorymetadescrption = $row['categorymetadescrption'];
				// $categorydesignsettings = $row['categorydesignsettings'];
				
			// }
			//page title
			// $commontitle = $categoryname;
			//echo $categoryID;exit();
		//	overall product
			// $count_overallproduct = getSINGLEDBVALUE('count(*)', "FIND_IN_SET('$categoryID', productcategory) and deleted='0' and status = '1'",'js_product', 'label');
			//echo $count_overallproduct;
            //  filtered count product
			// echo "SELECT `productID` FROM `js_product` where  FIND_IN_SET('$categoryID', productcategory) and deleted = '0' and status = '1' LIMIT 0,10";
			// $count_product_datas = sqlQUERY_LABEL("SELECT `productID` FROM `js_product` where  FIND_IN_SET('$categoryID', productcategory) and deleted = '0' and status = '1' LIMIT 0,10") or die("#1-Unable to get records:".mysql_error());
			//echo $count_product_datas;exit();
			// $count_product_list = sqlNUMOFROW_LABEL($count_product_datas);
			//$count_product_list = '';
			
		
	}
	else{
		
		$count_category_list = true;
		$categoryname = 'Shop';
		$commontitle = 'Shop';
		
		//overall product
		$count_overallproduct = getSINGLEDBVALUE('count(*)', " deleted='0' and status = '1'", 'js_product', 'label');
		
		//count product
		$count_product_datas = sqlQUERY_LABEL("SELECT `productID` FROM `js_product` where deleted = '0' and status = '1' LIMIT 0,10") or die("#1-Unable to get records:".mysql_error());
		
		$count_product_list = sqlNUMOFROW_LABEL($count_product_datas);
	}
		
	
	

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="<?php echo $categorymetadescrption; ?>"/>
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
    <link rel="canonical" href="<?php echo curPageURL(); ?>" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $categorymetatitle; ?>" />
    <meta property="og:description" content="<?php echo $categorymetadescrption; ?>" />
    <meta property="og:url" content="<?php echo curPageURL(); ?>" />
    <meta property="og:site_name" content="Online" />
    <meta property="og:updated_time" content="<?php echo time_stamp($updatedon); ?>" />
    <meta property="og:image" content="<?php echo SITEHOME; ?>uploads/category/<?php echo $productmediagalleryurl; ?>" />
    <meta property="og:image:secure_url" content="<?php echo SITEHOME; ?>uploads/category/<?php echo $categoryimage; ?>" />
    <meta property="og:image:width" content="542" />
    <meta property="og:image:height" content="241" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?php echo $categorymetadescrption; ?>" />
    <meta name="twitter:title" content="<?php echo $categorymetatitle; ?>" />
    <meta name="twitter:image" content="<?php echo SITEHOME; ?>uploads/category/<?php echo $categoryimage; ?>" />
	<style>
	.page-header-image {
    padding: 35.6rem 0 7rem;
	background-color: #ebebeb;
	background-size: cover;
	background-position: center center;
	background-repeat: no-repeat;
	height: 400px;
	width: 100%;
	}
	
	.page-header-image {
    padding: 35.6rem 0 7rem;
	background-color: #ebebeb;
	background-size: cover;
	background-position: center center;
	background-repeat: no-repeat;
	height: 400px;
	width: 100%;
	}
	</style>
	<?php include '__styles.php'; ?>
	
</head>

<body class="product-category">
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
	
<div id="load-productscreen">
	<div class="product_loader"></div>	
</div>
	<div class="page-wrapper">
    <?php 
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__header'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?> 

        <main class="main">
		
		<?php if(!empty($categoryimage)){
			?>
			<div class="page-header-image text-center" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0) 70%, rgba(0, 0, 0, 0.64) 100%), url('uploads/category/<?php echo $categoryimage;?>')">
        		<div class="container-fluid">
        			 <h1 class="page-title text-white">
                   <?php echo $commontitle; ?>
                    </h1>
                    <?php echo $categorydescription; ?>
					
        		</div><!-- End .container-fluid -->
        	</div><!-- End .page-header -->
			
	<?php 	} else {
		?> 
			<div class="page-header text-center">
        		<div class="container-fluid">
        			 <h1 class="page-title">
                   <?php echo $commontitle; ?>
                    </h1>
                    <?php echo $categorydescription; ?>
					
        		</div><!-- End .container-fluid -->
        	</div><!-- End .page-header -->
			
			
		<?php } ?>
        	
			
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container-fluid">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo SITEHOME; ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="shop.php"><?php 
						if($categoryname !='') {
						echo $categoryname; 
						} else if($search_value != '') {
							?>Search Results for <b><?php echo $search_value; ?> </b> <?php 
						}
						?></a></li>
						<?php if($categoryname !='') { ?>
							<li class="breadcrumb-item active" aria-current="page">All</li>
						<?php } ?>
                    </ol>
                </div><!-- End .container-fluid -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container-fluid">
				<?php //if($count_category_list >0) { ?>				
        			<div class="toolbox">

        				<div class="toolbox-left">
                            <a href="#" class="sidebar-toggler"><i class="icon-bars"></i>Filters</a>
        				</div><!-- End .toolbox-left -->
                                  <?php if(empty($search_value)){ ?>
                        <!--<div class="toolbox-center" id="showing">
                            
							<div class="toolbox-info">
                                Showing <span id=""><?php echo $count_product_list; ?> of <?php echo $count_overallproduct; ?></span> Products
                            </div><!-- End .toolbox-info -->
                        <!--</div><!-- End .toolbox-center -->
                       <?php } ?>
        				<div class="toolbox-right">
        					<div class="toolbox-sort">
        						<label for="sortby">Sort by:</label>
        						<div class="select-custom">
									<select name="sortby" id="sortby" class="form-control">
										<option class="custom-control-input filterby_all" value="all" selected="selected">All</option>
										<option class="custom-control-input filterby_popularity" value="popularity">Most Popular</option>
										<option class="custom-control-input filterby_rating" value="rating">Most Rated</option>
										<option class="custom-control-input filterby_lowtohigh" value="lowtohigh">Low to High</option>
										<option class="custom-control-input filterby_hightolow" value="hightolow">High to Low</option>
									</select>
								</div>
        					</div><!-- End .toolbox-sort -->
        				</div><!-- End .toolbox-right -->
        			</div><!-- End .toolbox -->
			
                <?php 
					//} else {

				?>	
					<!--<div class="text-center mt-150 mb-150">
					<h2><?php echo $categoryhero_text; ?></h2>
					<p><?php echo $categorydescription; ?></p>
					<a href="index.php" class="btn btn-outline-darker btn-load-more"> Go to Home Page </a>
					</div>-->
				<?php //}	//filter-sidebar 

 ?>	                   
                       <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
					   <aside class="sidebar-shop sidebar-filter">
                        <div class="sidebar-filter-wrapper">
                            <div class="widget widget-clean">
                                <label class="filter_close" style="cursor: pointer;"><i class="icon-close"></i>Filters</label>
                                <a class="sidebar-filter-clear" style="cursor: pointer;">Clean All</a>
                            </div><!-- End .widget -->
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                        Category
                                    </a>
                                </h3><!-- End .widget-title -->
                                   <?php if($category_token){   
								   ?>
                                <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        <div class="filter-items filter-items-count">
										<?php 
										$categorynames = sqlQUERY_LABEL("SELECT categoryname  FROM `js_category` where categoryID = '$category_token' or categoryparentID  ='$category_token' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());

	                                 	$categoryname_count = sqlNUMOFROW_LABEL($categorynames);
                                    
										 if($categoryname_count > 0) {
									          while($row = sqlFETCHARRAY_LABEL($categorynames)){
											     $categoryname1 = $row["categoryname"];
												
										         $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryname`, `status` FROM `js_category` where deleted = '0' {$showcondition} and categoryname='$categoryname1' and deleted = '0' and status = '1' order by categoryID ASC LIMIT 1") or die("#1-Unable to get records:".sqlERROR_LABEL());
											     $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);
											
											  while($row1 = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
												 
												  $categoryID = $row1["categoryID"];
												  $categoryname = $row1["categoryname"];
												  
											?>
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input filterby" id="<?php echo $categoryname; ?>-<?php echo $categoryID; ?>" value="<?php echo $categoryID; ?>">
                                                    <label class="custom-control-label" for="<?php echo $categoryname; ?>-<?php echo $categoryID; ?>"><?php echo $categoryname; ?></label>
                                                </div><!-- End .custom-checkbox -->
                                                <!--<span class="item-count">3</span>-->
                                            </div><!-- End .filter-item -->
											<?php } }}?>
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
								   <?php }else{ ?>
									   
									   <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        <div class="filter-items filter-items-count">
										<?php 					
										         $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' {$showcondition} order by categoryID ASC") or die("#1-Unable to get records:".sqlERROR_LABEL());
											     $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);
											  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
												  $counter++;
												  $categoryID = $row["categoryID"];
												  $categoryname = $row["categoryname"];
											?>
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input filterby" id="<?php echo $categoryname; ?>-<?php echo $categoryID; ?>" value="<?php echo $categoryID; ?>">
                                                    <label class="custom-control-label" for="<?php echo $categoryname; ?>-<?php echo $categoryID; ?>"><?php echo $categoryname; ?></label>
                                                </div><!-- End .custom-checkbox -->
                                                <!--<span class="item-count">3</span>-->
                                            </div><!-- End .filter-item -->
											<?php }?>
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
									   
								 <?php  } ?>
								
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
										<?php  
										$list_size_datas = sqlQUERY_LABEL("SELECT variant_name FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' GROUP BY variant_name ORDER BY variant_name") or die("#1-Unable to get records:".sqlERROR_LABEL());

										$count_size_list = sqlNUMOFROW_LABEL($list_size_datas);

										while($row_size = sqlFETCHARRAY_LABEL($list_size_datas)){
											$counter++;
											$variant_name = $row_size["variant_name"];
										?>
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input filterby_size" id="<?php echo $variant_name; ?>-<?php echo $counter; ?>" value="<?php echo $variant_name; ?>">
                                                    <label class="custom-control-label" for="<?php echo $variant_name; ?>-<?php echo $counter; ?>"><?php echo $variant_name; ?></label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->
										<?php } ?>
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
										<?php  
										$list_color_datas = sqlQUERY_LABEL("SELECT `productfiltercolorID`, `productfiltercolorcode`, `productfiltercolortitle`, `status` FROM `js_productfiltercolor` where deleted = '0' {$showcondition} order by productfiltercolorID ASC") or die("#1-Unable to get records:".sqlERROR_LABEL());

										$count_color_list = sqlNUMOFROW_LABEL($list_color_datas);

										while($row_color = sqlFETCHARRAY_LABEL($list_color_datas)){
											// $counter++;
											$productfiltercolorID = $row_color["productfiltercolorID"];
											$productfiltercolorcode = $row_color["productfiltercolorcode"];
											$productfiltercolortitle = $row_color["productfiltercolortitle"];
										?>
                                            <!--<a href="#" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>-->
											<a class="custom-color filterby_color" style="background: <?php echo $productfiltercolorcode; ?>;" value="<?php echo $productfiltercolorID; ?>"><span class="sr-only" ><?php echo $productfiltercolortitle; ?></span></a>
										<?php } ?>
                                        </div><!-- End .filter-colors -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                        Material
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-4">
                                    <div class="widget-body">
                                        <div class="filter-items">
										<?php  
										$list_material_datas = sqlQUERY_LABEL("SELECT `productfiltermaterialID`, `productfiltermaterialtitle`, `status` FROM `js_productfiltermaterial` where deleted = '0' {$showcondition} order by productfiltermaterialID ASC") or die("#1-Unable to get records:".sqlERROR_LABEL());

										$count_material_list = sqlNUMOFROW_LABEL($list_material_datas);

										while($row_material = sqlFETCHARRAY_LABEL($list_material_datas)){
											// $counter++;
											$productfiltermaterialID = $row_material["productfiltermaterialID"];
											$productfiltermaterialtitle = html_entity_decode($row_material["productfiltermaterialtitle"], ENT_QUOTES, "UTF-8");
										?>
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input filterby_material"  id="<?php echo $productfiltermaterialtitle; ?>-<?php echo $productfiltermaterialID; ?>" value="<?php echo $productfiltermaterialID; ?>">
                                                    <label class="custom-control-label"  for="<?php echo $productfiltermaterialtitle; ?>-<?php echo $productfiltermaterialID; ?>"><?php echo $productfiltermaterialtitle; ?></label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->
										<?php } ?>
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
                                                <span id="filter-price-range" class="filter-price-range filterby_price"></span>
                                            </div><!-- End .filter-price-text -->

                                            <div id="price-slider"></div><!-- End #price-slider -->
                                        </div><!-- End .filter-price -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
							
							
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-6" role="button" aria-expanded="true" aria-controls="widget-6">
                                        Type
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-6">
                                    <div class="widget-body">
                                        <div class="filter-items">
										<?php  
										$list_type_datas = sqlQUERY_LABEL("SELECT `productfiltertypeID`, `productfiltertypetitle`, `status` FROM `js_productfiltertype` where deleted = '0' {$showcondition} order by productfiltertypeID ASC") or die("#1-Unable to get records:".sqlERROR_LABEL());

										$count_type_list = sqlNUMOFROW_LABEL($list_type_datas);

										while($row_type = sqlFETCHARRAY_LABEL($list_type_datas)){
											// $counter++;
											$productfiltertypeID = $row_type["productfiltertypeID"];
											$productfiltertypetitle = html_entity_decode($row_type["productfiltertypetitle"], ENT_QUOTES, "UTF-8");
										?>
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input filterby_type"  id="<?php echo $productfiltertypetitle; ?>-<?php echo $productfiltertypeID; ?>" value="<?php echo $productfiltertypeID; ?>">
                                                    <label class="custom-control-label"  for="<?php echo $productfiltertypetitle; ?>-<?php echo $productfiltertypeID; ?>"><?php echo $productfiltertypetitle; ?></label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->
										<?php } ?>
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

							
                        </div><!-- End .sidebar-filter-wrapper -->
                    </aside><!-- End .sidebar-filter -->
					   	
					   <div class="category_show">
                        <div class="row" id="pagination-result"> 
						
					   </div> 
					   
					   </div>	
					 
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
		
		function getresult(url) {
		
	    var filterby = get_filter('filterby');
	    var filterby_color = get_filter_color('filterby_color');
	    var filterby_material = get_filter('filterby_material');
	    var filterby_type = get_filter('filterby_type');
	    var filterby_size = get_filter('filterby_size');
	    var filterby_price = get_filter_price('filterby_price');
	    var filterby_hightolow = get_filter_drop_down('filterby_hightolow');
	    var filterby_lowtohigh = get_filter_drop_down('filterby_lowtohigh');
	    var filterby_popularity = get_filter_drop_down('filterby_popularity');
	    var filterby_rating = get_filter_drop_down('filterby_rating');
		// alert(filterby)
		$('#load-productscreen').show();
		$.ajax({
			url: url,
			type: "GET",
			data:  {rowcount:$("#rowcount").val(),"pagination_setting":"all-links",filterby:filterby, filterby_color:filterby_color, filterby_material:filterby_material, filterby_type:filterby_type, filterby_size:filterby_size,  filterby_price:filterby_price, filterby_hightolow:filterby_hightolow, filterby_lowtohigh:filterby_lowtohigh, filterby_popularity:filterby_popularity, filterby_rating:filterby_rating },
			beforeSend: function(){$("#load-productscreen").show();},
			success: function(data){				
			    $('html, body').animate({ scrollTop: 0 }, 'slow');
				$("#pagination-result").html(data);
				setInterval(function() {$("#load-productscreen").hide(); },500);
				//setInterval(function() {$("#load-productscreen").hide(); },500);
			},
			error: function() 
			{} 	        
		});
	}
	
	
	
	
	function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }	
	function get_filter_color(class_name)
    {
        var filter = [];
        $('.'+class_name+'.selected').each(function(){
            filter.push($(this).attr('value'));
        });
        return filter;
    }		
	function get_filter_drop_down(class_name)
    {
        var filter = [];
        $('.'+class_name+':selected').each(function(){
            filter.push($(this).attr('value'));
        });
        return filter;
    }	
	function get_filter_price(id_name)
    {
        var filter = [];
        $('.'+id_name).each(function(){
            filter.push($(this).attr("low").split('₹'));
            filter.push($(this).attr("high").split('₹'));
        });
        return filter;
    }	
		
		
	$('.custom-control-input').click(function(){
       getresult("ajax/shop_pagination.php?s=<?php echo $search_value; ?>&token=<?php echo $search_token; ?>");
    });
	
	$('.filter-price-range').click(function(){
       getresult("ajax/shop_pagination.php?s=<?php echo $search_value; ?>&token=<?php echo $search_token; ?>");
    });
	
	$('.custom-color').click(function(){
		if($('.custom-color.selected')){
			if($('.custom-color.selected').attr('value') != undefined && $('.custom-color.selected:hover').attr('value') != undefined && $('.custom-color.selected').attr('value') == $('.custom-color.selected:hover').attr('value')){
				$('.custom-color.selected').removeClass('selected');
			} else {
				$('.custom-color.selected').removeClass('selected');
				$(".custom-color:hover").addClass(' selected');
			}
		}
		
       getresult("ajax/shop_pagination.php?s=<?php echo $search_value; ?>&token=<?php echo $search_token; ?>");
    });
	
	$('.sidebar-filter-clear').click(function(){
		location.reload();
    });
	$('.filter_close').click(function(){
		$('body').removeClass('sidebar-filter-active');
    });
	
	$( document ).ready(function() {
			$('#filter-price-range').attr('low', '');
			$('#filter-price-range').attr('high', '');
			getresult("ajax/shop_pagination.php?s=<?php echo $search_value; ?>&token=<?php echo $search_token; ?>");
		});
		
		
		
		
		
	</script>
</body>

</html>
