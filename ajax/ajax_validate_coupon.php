<?php 
extract($_REQUEST);

include '../head/jackus.php';

	$coupon_code = $coupon_code;
	$od_total_value = $od_total_value;
	$hidden_od_id = $_POST['hidden_od_id'];
	//echo $hidden_od_id;exit();
	$today = date('Y-m-d');
	$list_dicount_datas = sqlQUERY_LABEL("SELECT * FROM `js_promocode` where promocode_code='$coupon_code' and status= '1' and deleted = '0'") or die("Unable to get records:".mysqli_error());    

	$check_dicount_record_availabity = sqlNUMOFROW_LABEL($list_dicount_datas);      
	  
		if($check_dicount_record_availabity > 0) {

		  while($row = sqlFETCHARRAY_LABEL($list_dicount_datas)){
			$promocode_id = $row["promocode_id"];
			$promocode_name = $row["promocode_name"];
			$promocode_code = $row["promocode_code"];
			$discount_value = $row["promocode_value"];
			$max_promocode_value = $row["max_discount_amt"];
			$promocode_expiry_date = $row["promocode_expiry_date"];
			$discount_type = $row["promocode_type"];
			$promocode_option = $row["promocode_option"];
			$status = $row["status"];
		  }
		
		if($today <= $promocode_expiry_date){
			if($discount_value > 0) { 
				if($discount_type == 1) {
					$discounted_item_price = ($od_total_value-$discount_value);
					$discountedamount_frm_fullprice = $discount_value;
				} else if($discount_type == 2) { // discount by percentage
					$discounted_item_price = (($od_total_value * $discount_value) / 100 );
					$discountedamount_frm_fullprice = $discounted_item_price;
				}
				//discount by amount
				// if($discount_type == 1) {
					// $discounted_item_price = ($od_total_value-$discount_value);
					// $discountedamount_frm_fullprice = $discount_value;
				// } else if($discount_type == 2) { // discount by percentage
					// $discounted_item_price = (($od_total_value * $discount_value) / 100 );
					// $discountedamount_frm_fullprice = $discounted_item_price;
					 // if($discountedamount_frm_fullprice > $max_promocode_value){
					
						 // $discountedamount_frm_fullprice = $max_promocode_value;
					// } 
				// }
			}
			//echo $discountedamount_frm_fullprice;
			$total = $od_total_value - $discountedamount_frm_fullprice;
			// echo "UPDATE `js_shop_order` SET `od_discount_promo_ID` ='$promocode_id', `od_discount_type`='$discount_type', `od_discount_value`='$discount_value', `od_discount_amount`='$discountedamount_frm_fullprice' WHERE `od_sesid`='$sid' and od_userid = '$logged_user_id' and od_id = '$hidden_od_id'"; exit();
		  sqlQUERY_LABEL("UPDATE `js_shop_order` SET `od_discount_promo_ID` ='$promocode_id', `od_discount_type`='$discount_type', `od_discount_value`='$discount_value', `od_discount_amount`='$discountedamount_frm_fullprice' WHERE `od_sesid`='$sid' and od_userid = '$logged_user_id'") or die(sqlERROR_LABEL());
		
		$data = array('status' => 'Success', 'msg' => 'Updated');
		
		} else {

		$data = array('status' => 'Error_Expired', 'msg' => 'Expired');
		}
		} else { 
	
		$data = array('status' => 'Error_No_Record', 'msg' => 'No_Record');

		}
		
if($type_remove_coupon == 1){
	
	$sqlFields = array('`od_discount_promo_ID`', '`od_discount_type`', '`od_discount_value`', '`od_discount_amount`');
	
	$sqlValues = array("0", "0", "0", "0");
	
	$sqlWhere = "od_sesid = '$sid' and od_userid = '$logged_user_id'";
	
	if(sqlACTIONS("UPDATE", 'js_shop_order', $sqlFields, $sqlValues, $sqlWhere)){
		
		$data = array('status' => 'Success', 'msg' => 'Removed');
		
	} else { 
	
		$data = array('status' => 'Error', 'msg' => 'Not Removed');
	
	}
}
header('Content-Type: application/json');
echo json_encode($data);
//echo "success";
?>