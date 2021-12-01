        <header class="header header-intro-clearance header-3">
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
                            <form action="#" method="get">
                                <div class="header-search-wrapper search-wrapper-wide">
                                    <label for="q" class="sr-only">Search</label>
                                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search for products, brands and more..." required>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                    </div>

                    <div class="header-right">
                        <div class="dropdown compare-dropdown">
                            <a href="#signin-modal" data-toggle="modal" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
                                <div class="icon">
                                    <i class="icon-user"></i>
                                </div>
                                <p>Profile</p>
                            </a>
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
						$query= "SELECT SUM(od_qty) AS totalsum FROM `js_shop_order_item` WHERE od_session = '$sid' and deleted='0' ";	
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$total_sum_of_cart = $row['totalsum'];
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
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
						<?php
                          $h_list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' and status='1' order by categoryID ASC") or die("#1-Unable to get records:".mysql_error());
                        
                          while($h_row = sqlFETCHARRAY_LABEL($h_list_parentcategory_datas)){
                              $h_categoryID = $h_row["categoryID"];
                              $h_categoryname = $h_row["categoryname"];
                              $h_categoryparentID = $h_row["categoryparentID"];
                              $h_status = $h_row["status"];
                            
                                //generated sub-category details
                                $h_list_subcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' and `categoryparentID`='$h_categoryID' and status='1' order by categoryparentID ASC") or die("#2-Unable to get records:".mysql_error());
                                $h_count_subcateogry_list = sqlNUMOFROW_LABEL($h_list_subcategory_datas);
                                if($h_categoryparentID == '0') { 
								//class="active"
                                ?>
                                <li><a href="category.php?token=<?php echo $h_categoryID.'-'.convertSEOURL($h_categoryname); ?>"><?php echo $h_categoryname; ?></a>
                                <?php	
                                    
                                } //end of parent category check
                            
                                //checking sub category
                                if($h_count_subcateogry_list > 0) {
								//check in 
                                ?>
                                <ul>
                                <?php
                                    while($h_subrow = sqlFETCHARRAY_LABEL($h_list_subcategory_datas)){
                                      $h_subcategoryID = $h_subrow["categoryID"];
                                      $h_subcategoryname = html_entity_decode($h_subrow["categoryname"], ENT_QUOTES, "UTF-8");
                                      $h_substatus = $h_subrow["status"];
                                    ?>
                                    <li><a href="category.php?token=<?php echo $h_subcategoryID.'-'.convertSEOURL($h_subcategoryname); ?>"><?php echo $h_subcategoryname; ?></a></li>
                                    <?php	
                                    } //end of while loop
                                ?>
                                </ul>
                                <?php
                                } else {
                                ?>
                                </li> <!-- end of parent <?php echo $h_categoryparentID; ?>-->
                                <?php			
                                }//end of sub catggory - count
                            }
                            ?>                                
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
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