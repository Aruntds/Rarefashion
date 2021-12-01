<style>
.product-price{
	font-family: 'Jost', sans-serif;
	font-size : 20 px;
}
.sticky-div{
    position: sticky; 
    display: block;-webkit-align-self: flex-start;
    top: 64px;bottom: 0;
}
</style>
<header class="header header-intro-clearance header-3 sticky-header" style="background-color:#2d2d2d;">
            <div class="header-middle">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                        
                        <a href="index.php" class="logo">
                            <img src="assets/images/logo-light.png" alt="Rare Logo" width="105" height="25">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
							
                           <!-- <form action="#" method="get">
                                <div class="search-box header-search-wrapper search-wrapper-wide">
                                    <label for="q" class="sr-only">Search</label>
                                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                    <input type="text" autocomplete="off" class="form-control" name="q" id="q" placeholder="Search for products, brands and more..." required>
									<div class="result"></div>
                                </div><!-- End .header-search-wrapper
                            </form>-->
							 <form action="category.php" role="search" method="get" class="head-back-search">
						
						  <div class="search-box header-search-wrapper search-wrapper-wide">
						   <label for="q" class="sr-only">Search</label>
								<input type="text" id="productdata" name="search_value" class="form-control" placeholder="Search for products, brands and more..." value="<?php echo $search_value; ?>">
						        <div id="app_search_values"></div>
								<button class="btn btn-primary" onclick="get_search_values();" ><i class="icon-search" aria-hidden="true"></i></button>
							</div>
							<input name="post_type" value="product" type="hidden">
                                            <input name="taxonomy" value="product_cat" type="hidden">
                                            <button type="submit" class="btn-submit" style="display:none;">
                                                <span class="pe-7s-search"></span>
                                   </button>
                            </form>
                        </div><!-- End .header-search -->
                    </div>

                    <div class="header-right">
                        <div class="dropdown compare-dropdown">
							<?php if($sid != '' && $logged_user_id != '') { ?>
							<a href="dashboard.php" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
                                <div class="icon">
                                    <i class="icon-user"></i>
                                </div>
                                <p>Profile</p>
                            </a>
							<?php } else { ?>
                            <a href="#signin-modal" data-toggle="modal" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
                                <div class="icon">
                                    <i class="icon-user"></i>
                                </div>
                                <p>Profile</p>
                            </a>
							<?php } ?>
                        </div><!-- End .compare-dropdown -->

                        <div class="wishlist">
						<?php 
									$query= "SELECT * FROM js_wishlist WHERE `wish_userid` = '$logged_user_id' AND `deleted` = '0'";
									
									$result = sqlQUERY_LABEL($query);
									$num = sqlNUMOFROW_LABEL($result);
						?>
                            <a href="wishlist.php" title="Wishlist">
                                <div class="icon">
                                    <i class="icon-heart-o"></i>
                                    <span class="wishlist-count badge"><?php echo $num ?></span>
                                </div>
                                <p>Wishlist</p>
                            </a>
                        </div><!-- End .compare-dropdown -->
						<?php
                            if(!empty($logged_user_id)){
								
							$query= "SELECT count(od_id) AS totalcount FROM `js_shop_order_item` WHERE user_id ='$logged_user_id' and deleted='0' and `status` ='1'";	
								
							}else{
								
							$query= "SELECT count(od_id) AS totalcount FROM `js_shop_order_item` WHERE od_session = '$sid' and deleted='0' and `status` ='1' ";	
							}
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$total_sum_of_cart = $row['totalcount'];
						}
						?>
                        <div class="dropdown cart-dropdown" id="cart-item">
                            <a href="cart.php" class="dropdown-toggle">
                                <div class="icon">
                                    <i class="icon-shopping-cart"></i>
									<span id="showcartitem-count-bdg" class="cart-count badge"><?php echo number_format($total_sum_of_cart); ?></span>
                                </div>
                                <p>Cart</p>
                            </a>

                        </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div>
            </div><!-- End .header-middle -->

            <div class="header-bottom sticky-header">
                <div class="container">

              <div class="header-center">
						<div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
								<?php 
								$list_menu_datas = sqlQUERY_LABEL("SELECT * FROM `js_menu` where deleted = '0' and  menu_parentID = '0' order by menu_ID ASC") or die("Unable to get records:".mysqli_error());			
								$check_menu_record_availabity = sqlNUMOFROW_LABEL($list_menu_datas);
								while($row = sqlFETCHARRAY_LABEL($list_menu_datas)){
								  $menu_ID1 = $row["menu_ID"];
								  $menu_parentID = $row["menu_parentID"];
								  $menu_name = $row["menu_name"];
								?>
                                 <li>
                                    <a href="shop.php" class="sf-with-ul"><?php echo $menu_name; ?></a>
                                    <div class="megamenu megamenu-md" style="width: 900px;">
                                        <div class="row no-gutters">
                                            <div class="col-md-12">
                                                <div class="menu-col">
                                                    <div class="row">
														<?php 
														$list_sub_menu_datas = sqlQUERY_LABEL("SELECT * FROM `js_menu` where deleted = '0' and  menu_parentID = '$menu_ID1' and menu_type = '2' order by menu_ID ASC") or die("Unable to get records:".mysqli_error());			
														$check__sub_menu_record_availabity = sqlNUMOFROW_LABEL($list_sub_menu_datas);
														while($row = sqlFETCHARRAY_LABEL($list_sub_menu_datas)){
														  $menu_ID = $row["menu_ID"];
														  $menu_parentID = $row["menu_parentID"];
														  $menu_name = $row["menu_name"];
														  $menu_type = $row["menu_type"];
														  $menu_block = htmlspecialchars_decode(html_entity_decode($row["menu_block"]));
														  ?>
                                                        <div class="col-md-3">
                                                            <div class="menu-title"><?php echo $menu_name; ?></div>
															<!-- End .menu-title -->
														<?php echo $menu_block; ?>
                                                        </div><!-- End .col-md-6 -->
														<?php } ?>
														<div class="col-md-3">
														<?php 
														$list_sub_menu_datas1 = sqlQUERY_LABEL("SELECT * FROM `js_menu` where deleted = '0' and  menu_parentID = '$menu_ID1' and menu_type = '1' order by menu_ID ASC") or die("Unable to get records:".mysqli_error());			
														$check__sub_menu_record_availabity1 = sqlNUMOFROW_LABEL($list_sub_menu_datas1);
														while($row = sqlFETCHARRAY_LABEL($list_sub_menu_datas1)){
														  $menu_ID = $row["menu_ID"];
														  $menu_parentID = $row["menu_parentID"];
														  $menu_name = $row["menu_name"];
														  $menu_type = $row["menu_type"];
														  ?>
															<ul>
																<li class="menu-title"><a href="#"><?php echo $menu_name; ?></a></li>
															</ul>
														<?php } ?>
														</div>
                                                    </div><!-- End .row -->
                                               
											   </div><!-- End .menu-col -->
                                            </div><!-- End .col-md-8 -->

                                            <!-- End .col-md-4 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .megamenu megamenu-md -->
                                </li>
								<?php } ?>
							</ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->
                    </div>

                    <div class="header-right">
                        <p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
                    </div>
                    
                </div>
            </div>
        </header>
<?php /*
	<li class="megamenu-container">
		<a href="" class="sf-with-ul">New in</a>
		
		<div class="megamenu megamenu-md">
			<div class="row no-gutters">
				<div class="col-md-4">
					<div class="menu-col">
						<div class="row">
							<div class="col-md-12">
								<div class="menu-title">NEW PRODUCTS</div><!-- End .menu-title -->
								<ul>
									<li><a href="shop.php">View all</a></li>
									<li><a href="#">Clothing</a></li>
									<li><a href="#">Shoes</a></li>
									<li><a href="#">Accessories</a></li>
									<li><a href="#">Back in stock</a></li>
									<li><a href="#">Trending now</a></li>
									<li><a href="#">RARE DESIGN</a></li>
								</ul>
							</div><!-- End .col-md-6 -->
						</div><!-- End .row -->
					</div><!-- End .menu-col -->
				</div><!-- End .col-md-4 -->

				<div class="col-md-4">
					<div class="banner banner-overlay">
						<a href="shop.php" class="banner banner-menu">
							<img src="assets/images/menu/banner-1.jpg" alt="Banner">

							<div class="banner-content banner-content-top">
								<div class="banner-title text-white"><span><strong>NEW<br />SEASON</strong></span><br />STYLES</div><!-- End .banner-title -->
							</div><!-- End .banner-content -->
						</a>
					</div><!-- End .banner banner-overlay -->
				</div><!-- End .col-md-4 -->
				<div class="col-md-4">
					<div class="banner banner-overlay">
						<a href="shop.php" class="banner banner-menu">
							<img src="assets/images/menu/banner-2.jpg" alt="Banner">

							<div class="banner-content banner-content-top">
								<div class="banner-title text-white"><span><strong>VARSITY<br />VIBE</strong></span><br />TRENDS</div><!-- End .banner-title -->
							</div><!-- End .banner-content -->
						</a>
					</div><!-- End .banner banner-overlay -->
				</div><!-- End .col-md-4 -->
			</div><!-- End .row -->
		</div><!-- End .megamenu megamenu-md -->
		
	</li>	
	
	*/ ?>