<?php
extract($_REQUEST);
include_once('head/jackus.php');
include 'shopfunction.php'; 
include '___class__home.inc';

//echo $sid;
//print_r($_SESSION);

if($email != ''){

	$query= "SELECT * FROM `js_users` where useremail='$email'";
				// echo $query;
		$result = sqlQUERY_LABEL($query);
			while($row = sqlFETCHARRAY_LABEL($result))
			{ $user_email = $row['useremail']; }
				
// echo "SELECT * FROM `js_customers` where customer_mobile='$number'";

	// Request variables are filtered

	$query= "SELECT `userID`,`useremail`,`password`,`userapproved`,`roleID`,`userbanned` FROM js_users WHERE `username` = '$user_email' OR `useremail` = '$user_email'  AND `deleted` = '0'";
    $result = sqlQUERY_LABEL($query);
	$num = sqlNUMOFROW_LABEL($result);
	//echo $num,$user_email; exit();
	//Match row found with more than 1 results  - the user is authenticated. 

    if ( $num > 0 ) { 

		while($row_pay = sqlFETCHARRAY_LABEL($result)){

			$userID = $row_pay["userID"];
			$useremail = $row_pay["useremail"];
			$password = $row_pay["password"];
			$userapproved = $row_pay["userapproved"];
			$roleID = $row_pay["roleID"];$userbanned = $row_pay["userbanned"];
			$staff_id = $row_pay["staff_id"];
		}

		//list($userID,$useremail,$password,$userapproved,$roleID,$userbanned,$staff_id) = sqlFETCHROW_LABEL($result);

		if(!$userapproved) {

		echo "<script type='text/javascript'>window.location = 'index.php?session=invalid&code=2'</script>";
		//header("Location:index.php?session=invalid&code=2");

		 }

		if($userbanned == 1 ) {
		
		echo "<script type='text/javascript'>window.location = 'index.php?session=invalid&code=3'</script>";
		//header("Location:index.php?session=invalid&code=3");
		 }


		if ($useremail == $email) { 
			// this sets session and logs user in 
			session_start();
			session_regenerate_id (true); //prevent against session fixation attacks.
			// this sets variables in the session 
			$_SESSION['reg_user_id']= $userID;  
			$_SESSION['reg_user_name'] = $useremail;
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	
				//update the timestamp and key for cookie
				$stamp = time();
				$ckey = GenPwd();
			
				sqlQUERY_LABEL("update js_users set `userlogtime`='$stamp', `userlogkey` = '$ckey' where userID='$id'") or die(sqlERROR_LABEL());
					
				//set a cookie 
				setcookie("reg_user_id", $_SESSION['reg_user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_name",$_SESSION['reg_user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
	
				echo "<script type='text/javascript'>window.location = 'dashboard.php?msg=login&type=information'</script>"; 
				
				
		
				
				exit();
		
		} else {
			
			echo "<script type='text/javascript'>window.location = 'index.php?session=invalid&code=4'</script>";
			//header("Location:index.php?session=invalid&code=4");
		}
	
		} else {
			echo "<script type='text/javascript'>window.location = 'index.php?session=invalid&code=5'</script>";
			//header("Location:index.php?session=invalid&code=5");
	    }		
	
	
	}
	
	// session_start();
 // print_r($_SESSION);

if($addbilling_address == 'billing_address'){

	$arrFields=array('`customerID`', '`bill_fname`', '`bill_lname`', '`bill_company`', '`bill_country`', '`bill_street1`', '`bill_street2`', '`bill_city`', '`bill_state`', '`bill_pin`');

	$arrValues=array("$logged_customer_id", "$bill_fname", "$bill_lname", "$bill_company", "$bill_country", "$bill_street1", "$bill_street2", "$bill_city", "$bill_state", "$bill_pin");

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_billing_address` where deleted = '0' and `customerID`='$logged_user_id'") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);	
		
	if($check_record_availabity == 0){
		if(sqlACTIONS("INSERT","js_billing_address",$arrFields,$arrValues, '')){
			echo "<script type='text/javascript'>window.location = 'dashboard.php?msg=success'</script>"; 
			exit();
		}
	} else {
		$sqlwhere ="customerID ='$logged_user_id'";
		if(sqlACTIONS("UPDATE","js_billing_address",$arrFields,$arrValues, $sqlWhere)){
			echo "<script type='text/javascript'>window.location = 'dashboard.php?msg=success'</script>"; 
			exit();
		}
	}
}

if($addshiping_address == 'shiping_address'){

	$arrFields=array('`customerID`', '`ship_fname`', '`ship_lname`', '`ship_company`', '`ship_country`', '`ship_street1`', '`ship_street2`', '`ship_city`', '`ship_state`', '`ship_pin`');

	$arrValues=array("$logged_user_id", "$ship_fname", "$ship_lname", "$ship_company", "$ship_country", "$ship_street1", "$ship_street2", "$ship_city", "$ship_state", "$ship_pin");
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$logged_user_id'") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);	

	if($check_record_availabity == 0){
		if(sqlACTIONS("INSERT","js_shipping_address",$arrFields,$arrValues, '')){
			echo "<script type='text/javascript'>window.location = 'dashboard.php?msg=success'</script>"; 
			exit();
		}
	}else{
		$sqlwhere ="customerID ='$logged_user_id'";
		if(sqlACTIONS("UPDATE","js_shipping_address",$arrFields,$arrValues, $sqlWhere)){
			echo "<script type='text/javascript'>window.location = 'dashboard.php?msg=success'</script>"; 
			exit();
		}
	}

}

 if(curPageURL() == SEOURL.'dashboard.php') {
	$dashboard_active = "active";
} else if(curPageURL() == SEOURL.'dashboard.php?nav=order'){
	$order_active = "active";
} else if(curPageURL() == SEOURL.'dashboard.php?nav=address'){
	$address_active = "active";
} else if(curPageURL() == SEOURL.'dashboard.php?nav=account'){
	$account_active = "active";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php include '__styles.php'; ?>
</head>
<body>
    <div class="page-wrapper">
       <?php 
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__header'
		);
				echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 

		?>
        <div class="fullwidth-template">
	<?php 
		
		//list of module view templates
		$loadbodyFUNCTIONS = array(
		'__myorders',
		);	
		echo $homepage_propertyclass->loadPAGE($loadbodyFUNCTIONS); 

	?>
</div>

    <?php

		//list of module view templates
		$loadFUNCTIONS = array(
		'__footer',
		'__scripts'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?>
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