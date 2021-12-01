<?php 
//echo $sid.'<br>';
//echo $logged_user_id;
if($logged_user_id){
	$check_order_details = sqlQUERY_LABEL("select `od_id`,`od_sesid` from js_shop_order where od_userid = '$logged_user_id' and  od_status = '0' and status = '0'");
	$check_order_details_numrows = sqlNUMOFROW_LABEL($check_order_details);
	if($check_order_details_numrows > 0){
	sqlQUERY_LABEL("update js_shop_order set `od_sesid`='$sid' where od_userid='$logged_user_id' and od_status = '0' and status = '0'") or die(sqlERROR_LABEL());
		while($collect_order_details = sqlFETCHARRAY_LABEL($check_order_details)) {
		$od_id = $collect_order_details['od_id'];
		sqlQUERY_LABEL("update js_shop_order_item set `od_session`='$sid' where user_id='$logged_user_id' and od_id = '$od_id'") or die(sqlERROR_LABEL());
		}
	}		
}
?>
<style>
.product-price,
.kreen-Price-currencySymbol,
.Price-currencySymbol,
.product-prices {
	font-family: 'Jost', sans-serif;
	font-size : 20 px;
}
.sticky-div{
    position: sticky; 
    display: block;-webkit-align-self: flex-start;
    top: 64px;bottom: 0;
}
</style>
<header class="header header-7">
	<div class="header-top">
		<div class="container-fluid">
			<div class="header-left">
				<div class="header-dropdown">
					<a href="">Special collection already available.</a>
					
				</div><!-- End .header-dropdown -->
			</div><!-- End .header-left -->

			<div class="header-right">
				<ul class="top-menu">
					<li>
						<a href="#">Links</a>
						<ul>
							<li id="wish_div">
								<?php 
									$query= "SELECT * FROM js_wishlist WHERE `wish_userid` = '$logged_user_id' AND `deleted` = '0'"; 
									$result = sqlQUERY_LABEL($query);
									$num = sqlNUMOFROW_LABEL($result);
								?>
								<a href="wishlist.php"><i class="icon-heart-o"></i>My Wishlist <span>(<?php echo $num ?>)</span></a>
							</li>
								<?php if($sid != '' && $logged_user_id != '') { ?>
							<li>
								<div class="header-dropdown">
									<a href="dashboard.php">
										<div class="icon">
											<i class="icon-user"></i>
										</div>
									<p>Profile</p>
									</a>
									<div class="header-menu">
										<ul style="display:block!important">
											<li style="margin-left: 2.6rem!important;"><a href="dashboard.php">Dashboard</a></li>
											<li><a href="dashboard.php?nav=order">Orders</a></li>
											<li><a href="dashboard.php?nav=address">Addresses</a></li>
											<li><a href="dashboard.php?nav=account">Account Details</a></li>
											<li><a href="logout.php">Sign Out</a></li>
										</ul>
									</div><!-- End .header-menu -->
								</div>
								<!--<a href="dashboard.php" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
									<div class="icon">
										<i class="icon-user"></i>
									</div>
									<p>Profile</p>
								</a>-->
							</li>
								<?php } else { ?>
							<li>
								<a href="#signin-modal" data-toggle="modal" role="button" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
									<!--<div class="icon">
										<i class="icon-user"></i>
									</div>-->
									<p>Sign In / Register</p>
								</a>
							</li>
								<?php } ?>
						</ul>
					</li>
				</ul><!-- End .top-menu -->
			</div><!-- End .header-right -->
		</div><!-- End .container-fluid -->
	</div><!-- End .header-top -->

	<div class="header-middle sticky-header">
		<div class="container-fluid">
			<div class="header-left">
				<button class="mobile-menu-toggler">
					<span class="sr-only">Toggle mobile menu</span>
					<i class="icon-bars"></i>
				</button>
				
				<a href="index.php" class="logo">
					<img src="assets/images/logo-dark.png" alt="Molla Logo" width="105" height="25">
				</a>

				<nav class="main-nav">
					<ul class="menu sf-arrows">
								<?php
								$h_list_parentcategory_datas = sqlQUERY_LABEL("SELECT `menu_ID`, `menu_parentmenu`, `menu_name`, `menu_type`, `menu_url` FROM `js_menu` where deleted = '0' and  menu_parentID = '0' order by menu_ID ASC") or die("#1-Unable to get records:".mysqli_error());
				
								while($h_row = sqlFETCHARRAY_LABEL($h_list_parentcategory_datas)){
									$parentmenu_ID = $h_row["menu_ID"];
									$menu_parentmenu = $h_row["menu_parentmenu"];
									$menu_type = $h_row["menu_type"];
									$menu_name = $h_row["menu_name"];
									$menu_url = $h_row["menu_url"];

									//checking submenu available for current menu
									
									$h_list_subcategory_datas = sqlQUERY_LABEL("SELECT `menu_ID`, `menu_parentmenu`, `menu_name`, `menu_url`, `menu_block` FROM `js_menu` where deleted = '0' and  menu_parentID != '0' and menu_parentID='$parentmenu_ID' order by menu_name ASC") or die("#2-Unable to get records:".mysqli_error());
									$h_count_subcateogry_list = sqlNUMOFROW_LABEL($h_list_subcategory_datas);
									
									if($h_count_subcateogry_list > 0) {
										$__addSUBMENUCLASS = "sf-with-ul";
									} else {
										$__addSUBMENUCLASS = "";
									}
									
									?>
									<li>
										<a href="<?php echo SITEHOME.$menu_url; ?>" class="<?php echo $__addSUBMENUCLASS; ?>"><?php echo $menu_name; ?></a>
										<?php
										if($h_count_subcateogry_list > 0) {
											
											if($menu_type == '1') {
										?>
										<ul>
											<?php
												while($h_subrow = sqlFETCHARRAY_LABEL($h_list_subcategory_datas)){
												$smenu_ID = $h_subrow["menu_ID"];
												$smenu_name = $h_subrow["menu_name"];								  
												$smenu_url = $h_subrow["menu_url"];
											?>
											<li><a href="#"><?php echo $smenu_name; ?></a></li>
											<?php } ?>
										</ul>
										<?php 
										} //End of Meny Type=1
										
										if($menu_type == '2') {
										?>
											<div class="megamenu megamenu-sm" style="width: 900px;">
											<?php
											while($h_subrow = sqlFETCHARRAY_LABEL($h_list_subcategory_datas)){
											  $smenu_ID = $h_subrow["menu_ID"];
											  $smenu_block = $h_subrow["menu_block"];
											  $smenu_block = htmlspecialchars_decode($smenu_block);
											  
												echo html_entity_decode($smenu_block);
											}
											?>
											</div>	
										<?php
										}//End of Menu Type=2
									}
									?>
									</li>
								<?php } /*End of Main Menu While Loop */ ?> 
							</ul><!-- End .menu -->
					</nav><!-- End .main-nav -->
			</div><!-- End .header-left -->

			<div class="header-right">
				<div class="header-search header-search-extended header-search-visible">
					<a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
					<form action="shop.php" role="search" method="get" class="head-back-search">
						<div class="header-search-wrapper search-wrapper-wide">
							<label for="q" class="sr-only">Search</label>
							<input type="text" id="productdata" name="search_value" class="form-control" placeholder="Search product ..." value="<?php echo $_GET['search_value']; ?>">
							<button class="btn btn-primary" type="submit" onclick="get_search_values();"><i class="icon-search"></i></button>
							
							<input name="post_type" value="product" type="hidden">
                                            <input name="taxonomy" value="product_cat" type="hidden">
                                            <button type="submit" class="btn-submit" style="display:none;">
                                                <span class="pe-7s-search"></span>
                                   </button>
							
						</div><!-- End .header-search-wrapper -->
					</form>
				</div><!-- End .header-search -->
				
				<div class="dropdown cart-dropdown">
					<?php
						if($logged_user_id !=''){
							
						$query= "SELECT  * FROM `js_shop_order_item` WHERE user_id ='$logged_user_id' and deleted='0' and `status` ='1'";	
							
						}else{
						
						$query= "SELECT * FROM `js_shop_order_item` WHERE od_session = '$sid' and user_id ='' and deleted='0' and `status` ='1' ";	
						}
					  //echo $query;
					$result = sqlQUERY_LABEL($query);
					$total_sum_of_cart = sqlNUMOFROW_LABEL($result);
					 
					?>					
					<a href="cart.php" class="dropdown-toggle">
						<i class="icon-shopping-cart"></i>
						<span class="cart-count"><?php echo number_format($total_sum_of_cart); ?></span>
					</a>
                      
                   
				</div><!-- End .cart-dropdown -->
			</div><!-- End .header-right -->
		</div><!-- End .container-fluid -->
	</div><!-- End .header-middle -->
</header><!-- End .header -->
