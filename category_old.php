<?php 
	include 'head/jackus.php'; 
	include '___class__home.inc';

	$search_value = trim($_REQUEST['search_value']);
	//echo $search_value;exit();
	$category_token = strbefore($_REQUEST['token'], '-');
	
	if($category_token) {
		
		$list_category_datas = sqlQUERY_LABEL("SELECT * FROM `js_category` where categoryID = '$category_token' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());

		$count_category_list = sqlNUMOFROW_LABEL($list_category_datas);

		if($count_category_list > 0) {
			while($row = sqlFETCHARRAY_LABEL($list_category_datas)){
				$categoryID = $row["categoryID"];
				$categoryname = html_entity_decode($row["categoryname"], ENT_QUOTES, "UTF-8");
				$categoryimage = $row["categoryimage"];
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


	//echo "SELECT * FROM `js_category` where categoryname LIKE '%$search_value%' and deleted = '0' and status = '1'";
$count_category_list ='1';
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
			//$commontitle = $categoryname;
			//echo $commontitle;exit();
			//overall product
			// $count_overallproduct = getSINGLEDBVALUE('count(*)', " FIND_IN_SET('$categoryID', productcategory) and deleted='0' and status = '1'", 'js_product', 'label');
			
			//filtered count product
			
			// $count_product_datas = sqlQUERY_LABEL("SELECT `productID` FROM `js_product` where  FIND_IN_SET('$categoryID', productcategory) and deleted = '0' and status = '1' LIMIT 0,10") or die("#1-Unable to get records:".mysql_error());
			//echo $count_product_datas;exit();
			//$count_product_list = sqlNUMOFROW_LABEL($count_product_datas);
			//$count_product_list = '';
			
		
	}else{
		//echo 'test';exit();
		$count_category_list = true;
		$categoryname = 'Category';
		$commontitle = 'Category';
		
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
                        <li class="breadcrumb-item"><a href="category.php"><?php 
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
				<?php if($count_category_list >0) { ?>				
        			<div class="toolbox">

        				<div class="toolbox-left">
                            <a href="#" class="sidebar-toggler"><i class="icon-bars"></i>Filters</a>
        				</div><!-- End .toolbox-left -->
                                  <?php if(empty($search_value)){ ?>
                        <div class="toolbox-center" id="showing">
                            
							<div class="toolbox-info">
                                Showing <span id=""><?php echo $count_product_list; ?> of <?php echo $count_overallproduct; ?></span> Products
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-center -->
                       <?php } ?>
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
			
                <?php 
					} else {

				?>	
					<div class="text-center mt-150 mb-150">
					<h2><?php echo $categoryhero_text; ?></h2>
					<p><?php echo $categorydescription; ?></p>
					<a href="index.php" class="btn btn-outline-darker btn-load-more"> Go to Home Page </a>
					</div>
				<?php }	//filter-sidebar 

 ?>	                   
                       <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
					   <aside class="sidebar-shop sidebar-filter" >
					   
                        <div class="sidebar-filter-wrapper" >
                            <div class="widget widget-clean">
												
                                <label onclick="close_side();"><i class="icon-close"></i>Filters</label>
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
											
											<?php  
						   $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' {$showcondition} order by categoryID ASC") or die("#1-Unable to get records:".mysql_error());

							  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

							  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
								  $counter++;
								  $categoryID = $row["categoryID"];
								  $categoryname = $row["categoryname"];
							?>
										<div class="filter-item">
													<div class="custom-control custom-checkbox common_selector ">
														<input type="checkbox" class="custom-control-input filterby" id="brand-<?php echo $categoryID; ?>" value='<?php echo $categoryID; ?>'>
														<label class="custom-control-label" for="brand-<?php echo $categoryID; ?>"><?php echo $categoryname; ?></label>
													</div><!-- End .custom-checkbox -->
												</div><!-- End .filter-item -->

										<!-- End .filter-item -->
											<?php } ?>
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
                                                    <input type="checkbox" class="custom-control-input"  id="size-3">
                                                    <label class="custom-control-label" for="size-3">M</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"  id="size-4">
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
									        Price
									    </a>
									</h3><!-- End .widget-title -->
									<div class="collapse show" id="widget-3">
                                    <div class="filter-price">
                                                <div class="filter-price-text">
                                                    Price Range:
                                                    <span id="filter-price-range"></span>
                                                </div><!-- End .filter-price-text -->
												</div>
									
										<div class="widget-body">											
									<div class="filter-items filter-items-count">
									<div class="filter-item">
											<div id="price-slider" class="noUi-target noUi-ltr noUi-horizontal">
											<div class="noUi-base">
											<div class="noUi-connects">
											
											</div>
											
										
											</div>
											</div>
									</div><!-- End .filter-item -->

										
											
 											</div><!-- End .filter-items -->
										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
								 </div><!-- End .widget -->
                        </div><!-- End .sidebar-filter-wrapper -->
                    </aside>
					   	
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

</body>

</html>
