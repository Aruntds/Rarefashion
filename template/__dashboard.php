<?php 

extract($_REQUEST);

include '../head/jackus.php';
include('config.php');

$login_button = '';
	
//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
	//print_r($_GET["code"]);exit();
 //It will Attempt to exchange a code for an valid authentication token.
 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

 //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
 if(!isset($token['error']))
 {
  //Set the access token used for requests
  $google_client->setAccessToken($token['access_token']);

  //Store "access_token" value in $_SESSION variable for future use.
  $_SESSION['access_token'] = $token['access_token'];
//print_r($_SESSION['access_token']);exit();
  //Create Object of Google Service OAuth 2 class
  $google_service = new Google_Service_Oauth2($google_client);

  //Get user profile data from google
  $data = $google_service->userinfo->get();
//print_r($data['given_name']);exit();
  //Below you can find Get profile data and store into $_SESSION variable
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  
   
  }

  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }

  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  }

  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }

  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }

$username = $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'];

$pwd      ='7c222fb2927d828af22f592134e8932480637c0d';
$email    =$_SESSION['user_email_address'];

$check_use_email = commonNOOFROWS_COUNT('js_users', "useremail = '$email' and status = '1' and deleted ='0'");

if($check_use_email == 0){


$arrFields=array('`username`','`useremail`','`password`','`userapproved`','`roleID`','`status`');

$arrValues=array("$username","$email","$pwd","1","1","1");

if(sqlACTIONS("INSERT","js_users",$arrFields,$arrValues,'')){

             $id = sqlINSERTID_LABEL();
				   
			$arrFields=array('`customergroup`','`user_id`','`customerfirst`','`customeremail`','`customerphone`', '`status`','`createdby`');

			$arrValues=array("","$id","$username","$email", "","1","0");
			sqlACTIONS("INSERT","js_customer",$arrFields,$arrValues, '');
			
				   
			$subject = 'Registered Successfully';
			$to = $email;// $project_email;//
			$cc = 'mohan@touchmarkdes.com';//info@touchmarkdes.com
			$Bcc = ''; //info@touchmarkdes.com
			$from = "RareFashion - Registeration <notification@touchmarkdes.space>";
			 
			$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody>
    <tr>
      <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="RareFashion Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'assets/images/logo-light.png" height="50" border="0"></td>
    </tr>
    <tr>
      <td style="padding: 25px 10px 10px;" valign="top" align="center"><table width="535" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td valign="top" align="left"><strong style="font-size: 16px;line-height: 30px;padding-bottom: 15px;display: block;">Hello '.$username.'</strong></td>
            </tr>
            <tr>
              <td valign="top" align="left">Succesfully you have registered in RareFashion. </td>
            </tr>
            <tr>
              <td valign="top" align="left"> For any queries, please contact<br>
              <p> Hello User Your Password : 1234567<p>
                <br>
                Regards,<br>
                Team <span>RareFashion</span></td>
            </tr>
            <tr>
              <td style="padding:0 0 20px 0" valign="top" align="left"><img src="https://i.imgur.com/qe8OmqF.jpg" style="display:block" alt="Seprator image" class="CToWUd" width="535" height="2" border="0"></td>
            </tr>
            <tr>
              <td valign="top" align="center"> © 2021. All rights reserved</td>
            </tr>          </tbody>
        </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>';
	//echo $from,$to,$cc,$Bcc,$subject,$mail_template; exit();
     
	 if(send_mail($from,$to,$cc,$Bcc,$subject,$mail_template)) {
      } else {
         if (!send_mail($from,$to,$cc,$Bcc,$subject,$mail_template, false)) {
         
           if (!empty($error)) { echo $error; } 
          }     
        } 
	

}
   $email = $data['email'];
	$query= "SELECT `userID`,`useremail`,`password`,`userapproved`,`roleID`,`userbanned` FROM js_users WHERE `useremail` = '$email'  AND `deleted` = '0' AND `status` = '1'";
    $result = sqlQUERY_LABEL($query);
	$num = sqlNUMOFROW_LABEL($result);

	// Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
		while($row_pay = sqlFETCHARRAY_LABEL($result)){

			$userID = $row_pay["userID"];
			$useremail = $row_pay["useremail"];
			$password = $row_pay["password"];
			$userapproved = $row_pay["userapproved"];
			$roleID = $row_pay["roleID"];
			$userbanned = $row_pay["userbanned"];
			$staff_id = $row_pay["staff_id"];
		}

			// this sets session and logs user in 
			session_start();
			session_regenerate_id (true); //prevent against session fixation attacks.
			// this sets variables in the session 
			$_SESSION['reg_user_id']= $userID;  
			$_SESSION['reg_user_name'] = $useremail;
			$_SESSION['reg_user_level'] = $roleID;
			$_SESSION['reg_staff_id'] = $staff_id;
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	
				//update the timestamp and key for cookie
			$stamp = time();
			$ckey = GenPwd();
			
			sqlQUERY_LABEL("update js_users set `userlogtime`='$stamp', `userlogkey` = '$ckey' where userID='$id'") or die(sqlERROR_LABEL());
					
			//set a cookie 
			setcookie("reg_user_id", $_SESSION['reg_user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
			setcookie("reg_user_level", $_SESSION['reg_user_level'], time()+60*60*24*COOKIE_TIME_OUT, "/");
			setcookie("reg_user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
			setcookie("reg_user_name",$_SESSION['reg_user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
			
				 $get_current_session_ID_shop_item = sqlQUERY_LABEL("SELECT od_id,od_session FROM js_shop_order_item WHERE  od_session = '$sid' and user_id='0' and deleted = '0' and status = '1'") or die(sqlERROR_LABEL());
				 
				if(sqlNUMOFROW_LABEL($get_current_session_ID_shop_item)){
				        
					// while($row = sqlFETCHARRAY_LABEL($get_current_session_ID_shop_item))
					// {	
						
						// $od_id = $row['od_id'];			
						// $od_session = $row['od_session'];			
										
					// }
				
						sqlQUERY_LABEL("UPDATE js_shop_order_item SET `user_id` = '$userID', `createdby` = '$userID' WHERE user_id='0' and od_session = '$sid'");
				}
			

echo "<script type='text/javascript'>location.assign('".SITEHOME."dashboard.php?msg=".$email."')</script>";
	}
	}
	// else if($check_use_email == 1)
	// {
	// echo "<script type='text/javascript'>location.assign('".SITEHOME."index.php?msg=log_out1')</script>";
	// }
	else
   {
	  // 	echo"test";exit();
	$query= "SELECT `userID`,`useremail`,`password`,`userapproved`,`roleID`,`userbanned`,`userlogtime`,`userlogkey` FROM js_users WHERE `username` = '$email' OR `useremail` = '$email'  AND `deleted` = '0'";
    $result = sqlQUERY_LABEL($query);
	$num = sqlNUMOFROW_LABEL($result);
	//echo $num; exit();
	// Match row found with more than 1 results  - the user is authenticated. 
	
    if ( $num > 0 ) 
    { 

		while($row_pay = sqlFETCHARRAY_LABEL($result)){

			$userID = $row_pay["userID"];
			$useremail = $row_pay["useremail"];
			$password = $row_pay["password"];
			$userapproved = $row_pay["userapproved"];
			$roleID = $row_pay["roleID"];
			$userbanned = $row_pay["userbanned"];
			$staff_id = $row_pay["staff_id"];
			$userlogtime = $row_pay["userlogtime"];
			$userlogkey = $row_pay["userlogkey"];
			//echo $userlogkey;exit();
		}

		if(!empty($userlogtime && $userlogkey)){
			
			$input_password ='1234567';
			if($input_password =='1234567'){
			$password1='7c222fb2927d828af22f592134e8932480637c0d';
			}
			else{
			$password1='7c222fb2927d828af22';
			}
			
			// echo $password1.'<br>';
			// echo $password.'<br>';exit();
			if($password == $password1) { 
		//echo "test";exit();
			$current_session_id = $sid;
					
			session_start();
			
			$_SESSION['reg_user_id']= $userID;  
			$_SESSION['reg_user_name'] = $useremail;
			$_SESSION['reg_user_level'] = $roleID;
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

				//update the timestamp and key for cookie
				$stamp = time();
				$ckey = GenPwd();
			
				sqlQUERY_LABEL("update js_users set `userlogtime`='$stamp', `userlogkey` = '$ckey' where userID='$id'") or die(sqlERROR_LABEL());
					
				//set a cookie 
				setcookie("reg_user_id", $_SESSION['reg_user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_level", $_SESSION['reg_user_level'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_name",$_SESSION['reg_user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				
				//echo "SELECT od_id,od_session FROM js_shop_order_item WHERE od_session = '$sid' and `user_id` = '$userID' and deleted = '0'";exit();
				 $get_current_session_ID_shop_item = sqlQUERY_LABEL("SELECT od_id,od_session FROM js_shop_order_item WHERE od_session = '$sid' and `user_id` = '0' and deleted = '0'") or die(sqlERROR_LABEL());
				 
				 // while($row = sqlFETCHARRAY_LABEL($get_current_session_ID_shop_item))
				// {	
					// $od_id = $row['od_id'];			
                    				
				// }
				if(sqlNUMOFROW_LABEL($get_current_session_ID_shop_item)){
				        
					sqlQUERY_LABEL("UPDATE js_shop_order_item SET `user_id` = '$userID',`createdby` = '$userID' WHERE `user_id` = '0' and od_session = '$sid'");
				}
				// $get_current_session_ID_shop_order = sqlQUERY_LABEL("SELECT od_sesid FROM js_shop_order WHERE od_sesid = '$sid' and deleted = '0'") or die(sqlERROR_LABEL());
				// if(sqlNUMOFROW_LABEL($get_current_session_ID_shop_order)){
					// sqlQUERY_LABEL("UPDATE js_shop_order SET `od_userid` = '$userID', `createdby` = '$userID' WHERE od_userid='0' and od_sesid = '$sid'");
				// } 
				//echo $sid;
				echo "<script type='text/javascript'>location.assign('".SITEHOME."dashboard.php?msg=".$email."')</script>";
				//echo "test";exit();
		
		}else{
			echo "<script type='text/javascript'>location.assign('".SITEHOME."index.php?msg=log_out1')</script>";
		}
	 }else{
		 echo "<script type='text/javascript'>location.assign('".SITEHOME."index.php?msg=log_out1')</script>";
	 }
	}else{
		echo "<script type='text/javascript'>location.assign('".SITEHOME."index.php?msg=log_out1')</script>";
	}

}


}
?>
<main class="main">
	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
		<div class="container">
			<h1 class="page-title">Profile</h1>
		</div><!-- End .container -->
	</div><!-- End .page-header -->
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Profile</li>
			</ol>	
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->

	<div class="page-content">
		<div class="dashboard">
			<div class="container">
				<div class="row">
					<aside class="col-md-4 col-lg-3">
						<ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
							<li class="nav-item">
								<a class="nav-link <?php echo $dashboard_active; ?>" href="dashboard.php">Dashboard</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php echo $order_active; ?>" href="dashboard.php?nav=order">Orders</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link <?php echo $address_active; ?>" href="dashboard.php?nav=address">Adresses</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php echo $account_active; ?>" href="dashboard.php?nav=account">Account Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Sign Out</a>
							</li>
						</ul>
					</aside><!-- End .col-lg-3 -->

					<?php 
					//echo "SELECT `username` FROM js_users WHERE `userID` = '$logged_user_id' AND `deleted` = '0'";
					$get_user_name= sqlQUERY_LABEL("SELECT `username` FROM js_users WHERE `userID` = '$logged_user_id' AND `deleted` = '0'");
					while($row = sqlFETCHARRAY_LABEL($get_user_name)){

					$name = $row["username"];
					}
					?>
					<div class="col-md-8 col-lg-9">
						<div class="tab-content">
							<?php if($nav == '') { ?>
							<div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
								<p>Hello <span class="font-weight-normal text-dark"><?php echo $name; ?></span> (not <span class="font-weight-normal text-dark"><?php echo $name; ?></span>? <a href="logout.php">Log out</a>) 
								<br>
								From your account dashboard you can view your <a href="<?php echo SITEHOME;?>dashboard.php?nav=order">recent orders</a>, manage your <a href="<?php echo SITEHOME;?>dashboard.php?nav=address">shipping and billing addresses</a>, and <a href="<?php echo SITEHOME;?>dashboard.php?nav=account#password_set">edit your password</a> and <a href="<?php echo SITEHOME;?>dashboard.php?nav=account">account details</a>.</p>
							</div><!-- .End .tab-pane -->
							<?php } if($nav == 'order') { ?>
							
							
							<div class="toolbox_orders" style="position: absolute;left: 88%;">
								<div class="toolbox-right mb-1">
									<a href="#" class="sidebar-toggler"><i class="icon-bars"></i>Filters</a>
								</div>
							</div>
							<div id="order-list-pagination"></div>
					
							
							<?php }if($nav == 'orders') { ?>
					
							<?php if($mode == 'cancel'){ 
														
							$__main_order_details_query = sqlQUERY_LABEL("select * FROM `js_shop_order_item` where `user_id`='$logged_user_id' and `od_id`='$orderID' and `pd_id`='$productID'") or die(sqlERROR_LABEL());
							$check_main_order_num_rows = sqlNUMOFROW_LABEL($__main_order_details_query);
							
							if($check_main_order_num_rows > 0) {
								$__main_order_data = sqlFETCHASSOC_LABEL($__main_order_details_query);	
								$orderID = $__main_order_data['od_id'];
								// $od_refno = $__main_order_data['od_refno'];
								$orderSTATUS = $__main_order_data['od_status_item'];
								// $customername = $__main_order_data['od_shipping_first_name'];
								// $customeremail = $__main_order_data['od_payment_email'];
								
							}
							 
							
							if($action == '') {
								
							  $product_name = getPRODUCTNAME($productID);  
							?>
    							 <h4 class="text-center">Do you really want to cancel Product - <span class="text-danger"><?php echo $product_name; ?></span> in Order #<?php echo $od_refno; ?>?</h4>
    							 <div class="text-center">
    								<?php
    								//check order status
    								if($orderSTATUS != '7') {
										
    								?>
    								<a class="btn btn-sm btn-danger" href="<?php echo SITEHOME; ?>dashboard.php?nav=orders&mode=cancel&action=confirm&orderID=<?php echo $orderID; ?>&productID=<?php echo $productID; ?>">Yes, Cancel Product</a>
    								<?php } ?>
    								<a class="btn btn-sm btn-dark" href="<?php echo SITEHOME; ?>dashboard.php?nav=order">Back to Orders Details</a>
    							</div>
							<?php 
							    
							} else {
							
							    	$arrFields1 = array('`od_status_item`');
                                    $arrValues1 = array("7");
                                    $sqlWhere1  =  "pd_id = $productID and od_id = $orderID and user_id = $logged_user_id";
									 // echo $sqlWhere1;exit();
                                    if(sqlACTIONS("UPDATE","js_shop_order_item",$arrFields1, $arrValues1, $sqlWhere1))
									{
                                       // echo 'A'; exit();
                                        //upating log
                                        $description = "Order ".$od_refno." Cancelled";
										//echo $description;exit();
                                		$arrFields_log = array('`pd_id`', '`od_id`', '`od_status`', '`log_description`', '`status`');
                                		$arrValues_log = array("$product_id", "$orderID", "7", "$description", "1");
										//print_r($arrValues_log);exit();
                                		sqlACTIONS("INSERT","js_shop_order_log",$arrFields_log,$arrValues_log, ''); 
										
										//echo"select od_status_item from js_shop_order_item  and od_id = '$orderID' and od_status_item='7'";exit();
                                         $check_shop_status = sqlQUERY_LABEL("select od_status_item from js_shop_order_item  where od_id = '$orderID'") or die(sqlERROR_LABEL());
										 $count = sqlNUMOFROW_LABEL($check_shop_status);
                        				if($count =='1'){
											
									       $arrFields = array('`od_status`');
                                           $arrValues = array("7");
                                           $sqlWhere  = "`od_id`= $orderID and `od_userid` = $logged_user_id";
									            // print_r("UPDATE","js_shop_order",$arrFields, $arrValues, $sqlWhere);exit();
											 if(sqlACTIONS("UPDATE","js_shop_order",$arrFields, $arrValues, $sqlWhere))
										{
										}
										}
										 
										
                                        $check_selecteditem = sqlQUERY_LABEL("select `pd_id`, `variant_id`, `od_qty` from js_shop_order_item where pd_id = $productID and od_id = '$orderID'") or die(sqlERROR_LABEL());
                        				while($collect_selecteditem = sqlFETCHARRAY_LABEL($check_selecteditem)) {
                        
                        					$pd_id = $collect_selecteditem['pd_id'];
                        					$variant_id = $collect_selecteditem['variant_id'];                       		
                        					$od_qty = $collect_selecteditem['od_qty'];
											
											//product table updated
										if($variant_id == '0'){
											
											$check_master_stock = sqlQUERY_LABEL("select `productsku`,`productopeningstock`, `productavailablestock` from js_product where productID='$pd_id'") or die(sqlERROR_LABEL());

											while($collect_master_stock = sqlFETCHARRAY_LABEL($check_master_stock)) {
												$productopeningstock = $collect_master_stock['productopeningstock'];
												$productavailablestock = $collect_master_stock['productavailablestock'];
												$productsku = $collect_master_stock['productsku'];
											}
											
											if($productavailablestock >= $od_qty){

												$new_estore_qty = $productavailablestock + $od_qty;
												
											}
											
                        					$today = date('d/m/Y');
                        					$ord_ref_no = getORDERREF_USING_ODID($orderID);
											
                            				$log_description = "$od_qty Qty return for order #$ord_ref_no (Product ID - $pd_id).  Opening Stock: $productavailablestock / Available Stock: $new_estore_qty Qty on $today";
                            				
                            				$arrFields_log = array('`od_id`', '`prdt_id`', '`variant_id`', '`od_qty`', '`estore_code`', '`log_description`', '`createdby`', '`status`');
                            				
                            				$arrValues_log = array("$orderID", "$pd_id", "$variant_id", "$od_qty", "$productsku", "$log_description", "$logged_customer_id");
											
                            				if(sqlACTIONS("INSERT","js_estore_stock_deduct_log",$arrFields_log,$arrValues_log, '')){
                            
                            				}
									
											$arrFields = array('`productavailablestock`');
												$arrValues = array("$new_estore_qty");
												$sqlwhere ="productID ='$pd_id'";
												if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlwhere)){
												}
											
										}else{
											
											//variant table updated
											
											// echo "select `variant_code`,`variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_ID='$variant_id'"; exit();
											$check_master_stock = sqlQUERY_LABEL("select `variant_code`,`variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_ID='$variant_id'") or die(sqlERROR_LABEL());

											while($collect_master_stock = sqlFETCHARRAY_LABEL($check_master_stock)) {
												$productopeningstock = $collect_master_stock['variant_opening_stock'];
												$productavailablestock = $collect_master_stock['variant_available_stock'];
												$productsku = $collect_master_stock['variant_code'];
											}
											
											// if($productavailablestock >= $od_qty){

												$new_estore_qty = $productavailablestock + $od_qty;
												
											// }
                        					$today = date('d/m/Y');
                        					$ord_ref_no = getORDERREF_USING_ODID($orderID);
											
                            				$log_description = "$od_qty Qty return for order #$ord_ref_no.  Opening Stock: $productavailablestock / Available Stock: $new_estore_qty Qty on $today";
                            				
                            				$arrFields_log = array('`od_id`', '`prdt_id`', '`variant_id`', '`od_qty`', '`estore_code`', '`log_description`', '`createdby`', '`status`');
                            				
                            				$arrValues_log = array("$orderID", "$pd_id", "$variant_id", "$od_qty", "$productsku", "$log_description", "$logged_user_id");
											
                            				if(sqlACTIONS("INSERT","js_estore_stock_deduct_log",$arrFields_log,$arrValues_log, '')){
                            
                            				}
									
											$arrFields = array('`variant_available_stock`');
												$arrValues = array("$new_estore_qty");
												$sqlwhere ="variant_ID ='$variant_id'";
												if(sqlACTIONS("UPDATE","js_productvariants",$arrFields,$arrValues, $sqlwhere)){
												}
											
											
										}
                            
											
                            			
                            			} //edn of while loop
                                       
                                       //on successful update re-direct
                                       ?>
                                            <script type="text/javascript">
                                                window.location = '<?php echo SITEHOME; ?>dashboard.php?nav=order'
                                            </script>
                                       <?php
                                    }
							
							?>
							
    							<div class="text-center">
        							<h4>Please wait while we cancel your order...</h4>
        							<p>Do not press back button or refresh button</p>
    							</div>
    							
							<?php }  } ?>
							
							
							
							
							
							
							<?php } if($nav == 'address') { ?>
							<div class="">
								<!--<p>The following addresses will be used on the checkout page by default.</p>-->

								<div class="tab-content">
							<div>
							
							<div class="col-lg-12 mybooking-body">
										<div class="row">
											<!--<h4 class="card-title text-left p-10 b-b m-b-10">My Saved Locations</h4>	-->
											<h4 class="card-title text-left col-md-8 pb-2">My Saved Locations</h4>	
											<div class="text-right col-md-4"> <a href="#show_shipping_address_add" onclick="shipping_addresschange_add();" class="add_address_main edit scroll-down"> + Add Address </a> </div>
											</div>
											<div id="card_address">
											<div class="row" >
											<?php 
 										$list_data_ship = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$logged_user_id'") or die("Unable to get records:".sqlERROR_LABEL());			
										$check_record_availabity = sqlNUMOFROW_LABEL($list_data_ship);
										if($check_record_availabity != '0'){			
											while($row_ships = sqlFETCHARRAY_LABEL($list_data_ship)){
											  $id = $row_ships["Id"];
											  $ship_fname = $row_ships["ship_fname"];
											  $ship_lname = $row_ships["ship_lname"];
											  $ship_company = $row_ships["ship_company"];
											  $ship_country = $row_ships["ship_country"];
											  $ship_street1 = $row_ships["ship_street1"];
											  $ship_street2 = $row_ships["ship_street2"];
											  $ship_city = $row_ships["ship_city"];
											  $ship_state = $row_ships["ship_state"];
											  $ship_pin = $row_ships["ship_pin"]; 
												?>
											<div class="col-md-5 mb-3 mr-3 element" style="display: block;">
											<div class="card" style="height:100%;">
											  <div class="card-body">
												<h6 class="card-title pt-2"><?php echo $ship_fname.' '.$ship_lname ;?></h6><hr/>
												<p class="card-text">
												<?php if($ship_street2 == '') { ?>
													<?php echo $ship_street1; ?>,<br />
													<?php echo $ship_city; ?>, <?php echo $ship_state; ?>, <br/>
													Pin Code : <?php echo $ship_pin; ?>. <br/>
													<?php echo $ship_country; ?>
												<?php } else { ?>
													<?php echo $ship_street1; ?>,<br />
													<?php echo $ship_street2; ?>,<br/>
													<?php echo $ship_city; ?>, <?php echo $ship_state; ?>,  <br/>
													Pin Code : <?php echo $ship_pin; ?>. <br/>
													<?php echo $ship_country; ?>
												<?php } ?>
												<?php //echo $ship_street1.', '.$ship_street2.',</br> '.$ship_city.', '.$ship_state.' - '.$ship_pin.',</br> '.$ship_country;?></p>
											  </div>
											<div class="row">
												<div class="col-md-6 text-left  ">
												<a href="javascript:;" onclick="shipping_addresschange('<?php echo $id; ?>');">
												<i class="icon-edit" style="font-size:20px; " title="Click to Edit"></i>
												</a>
												</div>
												<div class="col-md-6 text-right ">
												<a class="text-danger" onclick="shipping_address_delete('<?php echo $id; ?>')">
												<i class="icon-close" style="font-size:20px;" title="Click to Delete"></i>
												</a>
												</div>
											</div>
											</div>
											<input type="hidden" name="card_id" class="card_id" value="<?php echo $id; ?>"/>
											
											</div>
											<?php }
												} else { ?>
													<div class="text-center col-md-12 mt-20">No Saved Locations</div>	
											<?php	}
											?>
											 
												
											</div>
											
											</div>
										</div>	
										</div>
										<span id="show_shipping_address_add"></span>
										<span></span>
										<span></span>
										<span></span>
										<span></span>
										
								<div class="row">
									<div class="u-column1 col-lg-12 kreen-Address">								
										<form method='post' id="shipping_address_add" style="display:none">
										<h4 class="card-title text-left col-md-8">Add Address</h4>	
										<div class="row">
											<div class="form-group col-6" >	
												<label for="ship_fname">First Name <span class="text-danger">*</span></label>									 
												<input type="text" class="form-control" id="ship_fname" name="ship_fname" value="" required  data-parsley-trigger="keyup" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"  placeholder="First Name" maxlength="30">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_lname">Last Name</label>									 
												<input type="text" class="form-control" id="ship_lname" name="ship_lname" value="" data-parsley-trigger="keyup" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" placeholder="Last Name">
											</div>
											<!--<div class="form-group col-6">
											  <p>
												<label>Email Address <span class="text-danger">*</span></label>
												<input type="email" class="form-control mb-0" id="email" name="email" required data-parsley-whitespace="trim" data-parsley-type="email" data-parsley-trigger="keyup" autocomplete="off" placeholder="Email Address">
											  </p>
											</div>
											<div class="form-group col-6">
											  <p>
												<label>Mobile Number <span class="text-danger">*</span></label>
												<input type="tel" class="form-control mb-0" id="phone" name="phone"data-parsley-whitespace="trim" data-parsley-type="number" data-parsley-trigger="keyup" maxlength="10"  autocomplete="off" autocomplete="off" data-parsley-type="number" placeholder="Mobile Number" required>
											  </p>
											</div>-->
											<div class="form-group col-6" >	
												<label for="ship_street1">Address #1 <span class="text-danger">*</span></label>									 
												<input type="text" class="form-control" id="ship_street" name="ship_street1" value="" required autocomplete="off"  data-parsley-whitespace="trim" data-parsley-trigger="keyup" placeholder="Address #1">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_street2">Address #2</label>									 
												<input type="text" class="form-control" id="ship_street2" name="ship_street2" value="" autocomplete="off"  data-parsley-whitespace="trim" data-parsley-trigger="keyup" placeholder="Address #2">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_city">City <span class="text-danger">*</span></label>									 
												<input type="text" class="form-control" id="ship_city" name="ship_city" value=""  required autocomplete="off" data-parsley-whitespace="trim" data-parsley-trigger="keyup" placeholder="City">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_state">State <span class="text-danger">*</span></label>									 
												<input type="text" class="form-control" id="ship_state" name="ship_state" value="" required autocomplete="off" data-parsley-whitespace="trim" data-parsley-trigger="keyup" placeholder="State">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_country">Country <span class="text-danger">*</span></label>									 
												<input type="text" class="form-control" id="ship_country" name="ship_country" value="" required autocomplete="off" data-parsley-whitespace="trim" data-parsley-trigger="keyup" placeholder="Country">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_pin">Mobile Number<span class="text-danger">*</span></label>									 
												<input type="text" class="form-control" id="ship_phone" name="ship_phone" maxlength='10' value="" required autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Pin Code">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_pin">Pin Code <span class="text-danger">*</span></label>									 
												<input type="text" class="form-control" id="ship_pin" name="ship_pin" maxlength='6' value="" required autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Pin Code">
											</div>
										</div>
											   <button type="submit" class="btn button btn-outline-primary-2 col-12" name="addshiping_address" value="shiping_address">Save</button>
										</form>
										<div  id="shipping_address_edit" style="display:none">
											<span id="displayEditShippingaddress"></span>
											</div>
									</div>
								</div><!-- End .row -->

							</div>
							
							</div><!-- .End .tab-pane -->
							<?php } if($nav == 'account') { ?>
							<div class="" >
								<form action="#">
									<?php
									$query= "SELECT * FROM `js_users` where userID='$logged_user_id' and deleted='0'";
												// echo $query;
									$result = sqlQUERY_LABEL($query);
										 while($row = sqlFETCHARRAY_LABEL($result))
											{	
												$username = $row['username'];							
												$useremail = $row['useremail'];							
												$password = $row['password'];							
													
											}
									$query= "SELECT * FROM `js_customer` where user_id='$logged_user_id' and deleted='0'";
												// echo $query;
									$result = sqlQUERY_LABEL($query);
										 while($row = sqlFETCHARRAY_LABEL($result))
											{	
												$customeraddress1 = $row['customeraddress1'];							
												$customeraddress2 = $row['customeraddress2'];							
												//$password = $row['password'];							
													
											}
									?>

									<label>Name<span style="color:red;">*</span></label>
									<input type="text" id="cus_name" name="cus_name" class="form-control" value="<?php echo $username ?>" required>
									<small class="form-text">This will be how your name will be displayed in the account section and in reviews</small>

									<label>Email address<span style="color:red;">*</span></label>
									<input type="email" id="cus_email" name="cus_email" class="form-control" value="<?php echo $useremail ?>" required>
									<label>Billing address</label>
									<textarea type="email" id="customeraddress1" name="customeraddress1" class="form-control" required style="min-height: 10px;"><?php echo $customeraddress1 ?></textarea>
									
									<span id="password_set"></span>
									<label>Shipping address</label>
									<textarea type="email" id="customeraddress2" name="customeraddress2" class="form-control"  required style="min-height: 10px;"><?php echo $customeraddress2 ?></textarea>
									<!--<label>Current password (leave blank to leave unchanged)</label>
									<input type="password" id="cus_pwd" name="cus_pwd" class="form-control">-->
									
									<label>New password (leave blank to leave unchanged)</label>
									<input type="password" id="new_pwd" name="new_pwd" class="form-control">

									<label>Confirm new password</label>
									<input type="password" id="confirm_pwd" name="confirm_pwd" class="form-control mb-2">

									<button type="button" onclick="cus_profile();" class="btn btn-outline-primary-2">
										<span id="save_profile">SAVE CHANGES</span>
										<i class="icon-long-arrow-right"></i>
									</button>
								</form>
							</div><!-- .End .tab-pane -->
							<?php } ?>
						</div>
					</div><!-- End .col-lg-9 -->
				</div><!-- End .row -->
				
				
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
                                        Order Days
                                    </a>
                                </h3><!-- End .widget-title -->
                                <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        <div class="filter-items filter-items-count">
                                            <div class="filter-item">
												<input type="radio" class="common_selector_order filterby" name="days"  id="1" value="Past 30 Days">&nbsp;
												<label for="1"> Past 30 Days </label>
                                            </div><!-- End .filter-item -->
                                            <div class="filter-item">
												<input type="radio" class="common_selector_order filterby" name="days"  id="2" value="Past 90 Days">&nbsp;
												<label for="2"> Past 90 Days </label>
                                            </div><!-- End .filter-item -->
                                            <div class="filter-item">
												<input type="radio" class="common_selector_order filterby" name="days"  id="3" value="Last Year">&nbsp;
												<label for="3"> Last Year </label>
                                            </div><!-- End .filter-item -->
                                            <div class="filter-item">
												<input type="radio" class="filter_year" name="days"  id="4" value="Older Days" 
												<?php 
												if($particular_year!=''){
													echo 'checked';
												}
												?> >&nbsp;
												<label for="4"> Particular Year </label>
												<form>
													<div class="card mg-md-b-20 mt-1" id="filter_content_year" style="<?php if($particular_year==''){ echo 'display:none';  } ?>">
													<input type="hidden" name="nav" value="order">
													<div class="card-body" style="padding: 1rem;">
														<div class="row">
														<div class="col-md-12 col-sm-12">
															<label for="since_from" class="mg-b-0">Year</label>
																<div class="input-group mg-md-b-10">
																<input type="text" placeholder="YYYY" class="form-control" id="particular_year" name="particular_year" value="<?php echo $particular_year ?>" data-date-format="yyyy">
																</div>
														</div>
														<div class="col-md-12">
															<button type="submit" class="btn btn-info year_filter" style="background-color: #c66; border-color: #c66;width:100%">Apply Filter</button>
															<!--<a href="<?php echo SITEHOME; ?>dashboard.php?nav=order" class="btn btn-light">Clear</a>-->
														</div>					
														</div>
													</div>
													</div>
													</form>
                                            </div><!-- End .filter-item -->
                                            <div class="filter-item">
												<input type="radio" class="filter_period" name="days"  id="5" value="Period"
												<?php 
												if($period_date_start!='' && $period_date_end!=''){
													echo 'checked';
												}
												?> >&nbsp;
												<label for="5"> Period </label>
												<form>
													<div class="card mg-md-b-20 mt-1" id="filter_content" style="
												<?php 
												if($period_date_start=='' && $period_date_end==''){ echo 'display:none'; } ?> ">
													<input type="hidden" name="nav" value="order">
													<div class="card-body" style="padding: 1rem;">
														<div class="row">
														<div class="col-md-12 col-sm-12">
															<label for="since_from" class="mg-b-0">From</label>
																<div class="input-group mg-md-b-10">
																<input type="text" placeholder="DD/MM/YYYY" class="form-control" id="period_date_start" name="period_date_start" value="<?php echo $period_date_start ?>" data-date-format="dd/mm/yyyy">
																</div>
														</div>
														<div class="col-md-12 col-sm-12">
														<label for="since_to" class="mg-b-0">To</label>
															<div class="input-group mg-b-10">
																<input type="text" placeholder="DD/MM/YYYY" class="form-control" id="period_date_end" name="period_date_end" value="<?php echo $period_date_end ?>" data-date-format="dd/mm/yyyy">
															</div>
														</div>
														<div class="col-md-12">
															<button type="submit" class="btn btn-info period_filter" style="background-color: #c66; border-color: #c66;width:100%">Apply Filter</button>
															<!--<a href="<?php echo SITEHOME; ?>dashboard.php?nav=order" class="btn btn-light">Clear</a>-->
														</div>					
														</div>
													</div>
													</div>
													</form>
                                            </div><!-- End .filter-item -->
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
								
                            </div><!-- End .widget -->
							
                        </div><!-- End .sidebar-filter-wrapper -->
                    </aside><!-- End .sidebar-filter -->
				
			</div><!-- End .container -->
		</div><!-- End .dashboard -->
	</div><!-- End .page-content -->
</main><!-- End .main -->

</div><!-- End .page-wrapper -->
<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container">
<div class="mobile-menu-wrapper">
	<span class="mobile-menu-close"><i class="icon-close"></i></span>

	<form action="#" method="get" class="mobile-search">
		<label for="mobile-search" class="sr-only">Search</label>
		<input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
		<button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
	</form>
	
	<nav class="mobile-nav">
		<ul class="mobile-menu">
			<li class="active">
				<a href="index.html">Home</a>

				<ul>
					<li><a href="index-1.html">01 - furniture store</a></li>
					<li><a href="index-2.html">02 - furniture store</a></li>
					<li><a href="index-3.html">03 - electronic store</a></li>
					<li><a href="index-4.html">04 - electronic store</a></li>
					<li><a href="index-5.html">05 - fashion store</a></li>
					<li><a href="index-6.html">06 - fashion store</a></li>
					<li><a href="index-7.html">07 - fashion store</a></li>
					<li><a href="index-8.html">08 - fashion store</a></li>
					<li><a href="index-9.html">09 - fashion store</a></li>
					<li><a href="index-10.html">10 - shoes store</a></li>
					<li><a href="index-11.html">11 - furniture simple store</a></li>
					<li><a href="index-12.html">12 - fashion simple store</a></li>
					<li><a href="index-13.html">13 - market</a></li>
					<li><a href="index-14.html">14 - market fullwidth</a></li>
					<li><a href="index-15.html">15 - lookbook 1</a></li>
					<li><a href="index-16.html">16 - lookbook 2</a></li>
					<li><a href="index-17.html">17 - fashion store</a></li>
					<li><a href="index-18.html">18 - fashion store (with sidebar)</a></li>
					<li><a href="index-19.html">19 - games store</a></li>
					<li><a href="index-20.html">20 - book store</a></li>
					<li><a href="index-21.html">21 - sport store</a></li>
					<li><a href="index-22.html">22 - tools store</a></li>
					<li><a href="index-23.html">23 - fashion left navigation store</a></li>
					<li><a href="index-24.html">24 - extreme sport store</a></li>
				</ul>
			</li>
			<li>
				<a href="category.html">Shop</a>
				<ul>
					<li><a href="category-list.html">Shop List</a></li>
					<li><a href="category-2cols.html">Shop Grid 2 Columns</a></li>
					<li><a href="category.html">Shop Grid 3 Columns</a></li>
					<li><a href="category-4cols.html">Shop Grid 4 Columns</a></li>
					<li><a href="category-boxed.html"><span>Shop Boxed No Sidebar<span class="tip tip-hot">Hot</span></span></a></li>
					<li><a href="category-fullwidth.html">Shop Fullwidth No Sidebar</a></li>
					<li><a href="product-category-boxed.html">Product Category Boxed</a></li>
					<li><a href="product-category-fullwidth.html"><span>Product Category Fullwidth<span class="tip tip-new">New</span></span></a></li>
					<li><a href="cart.html">Cart</a></li>
					<li><a href="checkout.html">Checkout</a></li>
					<li><a href="wishlist.html">Wishlist</a></li>
					<li><a href="#">Lookbook</a></li>
				</ul>
			</li>
			<li>
				<a href="product.html" class="sf-with-ul">Product</a>
				<ul>
					<li><a href="product.html">Default</a></li>
					<li><a href="product-centered.html">Centered</a></li>
					<li><a href="product-extended.html"><span>Extended Info<span class="tip tip-new">New</span></span></a></li>
					<li><a href="product-gallery.html">Gallery</a></li>
					<li><a href="product-sticky.html">Sticky Info</a></li>
					<li><a href="product-sidebar.html">Boxed With Sidebar</a></li>
					<li><a href="product-fullwidth.html">Full Width</a></li>
					<li><a href="product-masonry.html">Masonry Sticky Info</a></li>
				</ul>
			</li>
			<li>
				<a href="#">Pages</a>
				<ul>
					<li>
						<a href="about.html">About</a>

						<ul>
							<li><a href="about.html">About 01</a></li>
							<li><a href="about-2.html">About 02</a></li>
						</ul>
					</li>
					<li>
						<a href="contact.html">Contact</a>

						<ul>
							<li><a href="contact.html">Contact 01</a></li>
							<li><a href="contact-2.html">Contact 02</a></li>
						</ul>
					</li>
					<li><a href="login.html">Login</a></li>
					<li><a href="faq.html">FAQs</a></li>
					<li><a href="404.html">Error 404</a></li>
					<li><a href="coming-soon.html">Coming Soon</a></li>
				</ul>
			</li>
			<li>
				<a href="blog.html">Blog</a>

				<ul>
					<li><a href="blog.html">Classic</a></li>
					<li><a href="blog-listing.html">Listing</a></li>
					<li>
						<a href="#">Grid</a>
						<ul>
							<li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
							<li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
							<li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
							<li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Masonry</a>
						<ul>
							<li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
							<li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
							<li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
							<li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Mask</a>
						<ul>
							<li><a href="blog-mask-grid.html">Blog mask grid</a></li>
							<li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Single Post</a>
						<ul>
							<li><a href="single.html">Default with sidebar</a></li>
							<li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
							<li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="elements-list.html">Elements</a>
				<ul>
					<li><a href="elements-products.html">Products</a></li>
					<li><a href="elements-typography.html">Typography</a></li>
					<li><a href="elements-titles.html">Titles</a></li>
					<li><a href="elements-banners.html">Banners</a></li>
					<li><a href="elements-product-category.html">Product Category</a></li>
					<li><a href="elements-video-banners.html">Video Banners</a></li>
					<li><a href="elements-buttons.html">Buttons</a></li>
					<li><a href="elements-accordions.html">Accordions</a></li>
					<li><a href="elements-tabs.html">Tabs</a></li>
					<li><a href="elements-testimonials.html">Testimonials</a></li>
					<li><a href="elements-blog-posts.html">Blog Posts</a></li>
					<li><a href="elements-portfolio.html">Portfolio</a></li>
					<li><a href="elements-cta.html">Call to Action</a></li>
					<li><a href="elements-icon-boxes.html">Icon Boxes</a></li>
				</ul>
				</li>
			</ul>
		</nav><!-- End .mobile-nav -->

		<div class="social-icons">
			<a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
			<a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
			<a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
			<a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
		</div><!-- End .social-icons -->
	</div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->
