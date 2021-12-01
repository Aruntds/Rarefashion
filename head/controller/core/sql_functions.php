<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2019 Touchmark Descience Pvt Ltd
*
*/

	/****************** get Common Status - detail ****************/
	function getCOMMONSTATUS($selected_status_type, $selected_status_id, $requesttype) {
		
		//`status_type`, `status_id`, `status_title` FROM `oc_Status`
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'select') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `status_id`, `status_title` FROM `js_status` where `status_type`='$selected_status_type' order by status_id ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$status_id = $getstatus_fetch['status_id'];
					$status_title = $getstatus_fetch['status_title'];
				 ?>
				 <option value='<?php echo $status_id; ?>' <?php if($selected_status_id==$status_id) { echo "selected"; } ?> >
					<?php echo $status_title; ?>
				 </option>
				 <?php
			 }
		}
	
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `status_title` FROM `js_status` where `status_id`='$selected_status_id' and `status_type`='$selected_status_type'") or die("#STATUS-LABEL: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$status_title = $getstatus_fetch['status_title'];
					return $status_title;
			 }
		}
		
	}
	/****************** end of Common Status - detail ****************/

	function getPRODUCTCATEGORY($selected_id, $reason, $requesttype){ 
	
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select' && $reason==''){   
		
		  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' order by categoryparentID ASC") or die("#1-Unable to get records:".sqlERROR_LABEL());
		
		  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);
		
		  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
			  $categoryID = $row["categoryID"];
			  $categoryname = $row["categoryname"];
			  $categoryparentID = $row["categoryparentID"];
			
				if($categoryparentID == '0') {
				//generated sub-category details
				$list_subcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' and `categoryparentID`='$categoryID' order by categoryparentID ASC") or die("#2-Unable to get records:".sqlERROR_LABEL());
				$count_subcateogry_list = sqlNUMOFROW_LABEL($list_subcategory_datas);
					?>
					<option value="<?php echo $categoryID; ?>"><?php echo $categoryname; ?></option>
					<?php
					
				} //end of parent category check
			
				//checking sub category
				if($count_subcateogry_list > 0) {
					while($subrow = sqlFETCHARRAY_LABEL($list_subcategory_datas)){
					  $subcategoryID = $subrow["categoryID"];
					  $subcategoryname = $subrow["categoryname"];
						?>
						<option value="<?php echo $subcategoryID; ?>">---|<?php echo $subcategoryname; ?></option>
						<?php
					} //end of while loop
				} //end of sub catggory - count
				
			}
					
		} else if($requesttype == 'select' && $reason=='simpleselect'){      ///only single category selected
		
		  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' order by categoryparentID ASC") or die("#1-Unable to get records:".sqlERROR_LABEL());
		
		  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);
		
		  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
			  $categoryID = $row["categoryID"];
			  $categoryname = $row["categoryname"];
			  $categoryparentID = $row["categoryparentID"];
			
				if($categoryparentID == '0') {
				//generated sub-category details
				$list_subcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' and `categoryparentID`='$categoryID' order by categoryparentID ASC") or die("#2-Unable to get records:".sqlERROR_LABEL());
				$count_subcateogry_list = sqlNUMOFROW_LABEL($list_subcategory_datas);
					?>
					<option value="<?php echo $categoryID; ?>" <?php if($selected_id == $categoryID) { echo 'selected="selected"'; } ?>><?php echo $categoryname; ?></option>
					<?php
					
				} //end of parent category check
			
				//checking sub category
				if($count_subcateogry_list > 0) {
					while($subrow = sqlFETCHARRAY_LABEL($list_subcategory_datas)){
					  $subcategoryID = $subrow["categoryID"];
					  $subcategoryname = $subrow["categoryname"];
						?>
						<option value="<?php echo $subcategoryID; ?>" <?php if($selected_id == $subcategoryID) { echo 'selected="selected"'; } ?>>---|<?php echo $subcategoryname; ?></option>
						<?php
					} //end of while loop
				} //end of sub catggory - count
				
			}
					
		} else if($requesttype == 'select' && $reason=='multiselect') {
			//multiselect
			$prdt_mcategory = explode(",", $selected_id);
				   
			  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' order by categoryparentID ASC") or die("#1-Unable to get records:".sqlERROR_LABEL());
			
			  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);
			
			  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
				  $categoryID = $row["categoryID"];
				  $categoryname = $row["categoryname"];
				  $categoryparentID = $row["categoryparentID"];
					if(in_array($categoryID,$prdt_mcategory)) $str_category = "selected"; else $str_category="";
					
					if($categoryparentID == '0') {
					//generated sub-category details
					$list_subcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' and `categoryparentID`='$categoryID' order by categoryparentID ASC") or die("#2-Unable to get records:".sqlERROR_LABEL());
					$count_subcateogry_list = sqlNUMOFROW_LABEL($list_subcategory_datas);
						?>
						<option value="<?php echo $categoryID; ?>" <?php echo $str_category; ?>><?php echo $categoryname; ?></option>
						<?php
						
					} //end of parent category check
				
					//checking sub category
					if($count_subcateogry_list > 0) {
						while($subrow = sqlFETCHARRAY_LABEL($list_subcategory_datas)){
						  $subcategoryID = $subrow["categoryID"];
						  $subcategoryname = $subrow["categoryname"];
						  if(in_array($subcategoryID,$prdt_mcategory)) $str_subcategory = "selected"; else $str_subcategory="";
							?>
							<option value="<?php echo $subcategoryID; ?>" <?php echo $str_subcategory; ?>>---|<?php echo $subcategoryname; ?></option>
							<?php
						} //end of while loop
					} //end of sub catggory - count
					
				}
						
			
		}
		
		/*****************  SHOW LABEL  *****************/	
		if($requesttype == 'label'){
		
			$selected_query = sqlQUERY_LABEL("SELECT categoryname FROM `js_category` where `categoryID` = '$selected_id'") or die("#PARENT-LABEL: Getting Parent Category: ".sqlERROR_LABEL());
			if(sqlNUMOFROW_LABEL($selected_query) > 0) {
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					return $fetch_data['categoryname'];
				}	
			} else {
				return '--';	
			}
	
			
		}
				
	}

	function getPARENTCategory($selected_type_id, $requesttype){ 
	 
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT categoryID, categoryname FROM `js_category` where `categoryparentID` = '0' and `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".sqlERROR_LABEL());
			?> 
            <option value="0">No Parent Category</option>
			<?php
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$categoryID = $fetch_data['categoryID'];
				$categoryname = $fetch_data['categoryname'];
			?>
            <option value="<?php echo $categoryID; ?>" <?php if($selected_type_id == $categoryID){ echo "selected"; } ?>><?php echo $categoryname; ?></option>
		<?php
            }	
			
		}
		
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'label'){   

			$selected_query = sqlQUERY_LABEL("SELECT categoryname FROM `js_category` where `categoryparentID` = '$selected_type_id'") or die("#PARENT-LABEL: Getting Parent Category: ".sqlERROR_LABEL());
			if(sqlNUMOFROW_LABEL($selected_query) > 0) {
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					return $fetch_data['categoryname'];
				}	
			} else {
				return '--';	
			}
			
		}
				
	 }
	
	//setting page - multiple select option
	function getsettingsFRONTPAGEPRODUCTS($selected_product_id, $requesttype) {
		
		$product_list_array = explode(",", $selected_product_id);
		
		foreach($product_list_array as $selectedproduct) {
			
			$selectedproduct_id = trim($selectedproduct);
						
		  	$list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `producttitle`, `productsku` FROM `js_product` where productsku = '$selectedproduct_id' and  deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());
			$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
			
			if($count_product_list > 0) {

			  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
				  $productID = $row["productID"];
				  $producttitle = limit_words($row["producttitle"], 8);
				  $producttitle = str_replace("\'","'",$producttitle);
				  //echo $producttitle;exit();
				  $productsku = $row["productsku"];
			?>
					<option value="<?php echo $productsku; ?>" selected="selected"><?php echo $productsku.'-'.$producttitle; ?></option>
					<?php
			  }
			  
			}
			
		}

	}
	 
	//Display Image Size
	function getDISPLAYIMAGESIZE($selected_status_id, $requesttype) {


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') { ?>

                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Small </option>

                 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > Medium </option>
				 
                 <option value='3' <?php if($selected_status_id=='3') { echo "selected"; } ?> > Large </option>

                 <?php

			 }
			 
		if($requesttype == 'label') {

                if($selected_status_id == '1') {  
                	
                    return "Small";
                }
                
                if($selected_status_id == '2') {
					
                    return  "Medium";
                }
				
				if($selected_status_id == '3') {
					
                    return  "Large";
                }

			 }
	 }
	 
	//Display Footer Size
	function getDISPLAYFOOTERSIZE($selected_status_id, $requesttype) {


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') { ?>

                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Size x 2 </option>

                 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > Size x 3 </option>

                 <?php

			 }
			 
		if($requesttype == 'label') {

                if($selected_status_id == '1') {  
                	
                    return "Size x 2";
                }
                
                if($selected_status_id == '2') {
					
                    return  "Size x 3";
                }

			 }
	 }
 
	function getcustomerGROUP($selected_type_id, $requesttype){ 
	 
	 
		
		if($requesttype == 'select'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_customergroup` where `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".sqlERROR_LABEL());
			?> 
            <option value="">  Choose Customer Title  </option>  
			<?php
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$customergroupID = $fetch_data['customergroupID'];
				$customergrouptitle = $fetch_data['customergrouptitle'];   
			?>
            <option value="<?php echo $customergroupID; ?>" <?php if($selected_type_id == $customergroupID){ echo "selected"; } ?>><?php echo $customergrouptitle; ?></option>
		<?php
		
            }	
			
		} //end of select

		
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'label'){   

			$selected_query = sqlQUERY_LABEL("SELECT customergrouptitle FROM `js_customergroup` where `deleted` = '0' and `customergroupID` = '$selected_type_id'") or die("#CUSTOMGROUP-LABEL: Getting Custom Group: ".sqlERROR_LABEL());
			if(sqlNUMOFROW_LABEL($selected_query) > 0) {
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					return $fetch_data['customergrouptitle'];
				}	
			} else {
				return '--';	
			}
			
		}		
		
		
		}

	//Display Mode
	function getDISPLAYMODE($selected_status_id, $requesttype) {
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select') { ?>
                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Grid Only </option>
                 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > List Only </option>
                 <?php
			 }
	 }
	
	//Display Mode
	function getPRODUCTSORTBY($selected_status_id, $requesttype) {
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select') { ?>
                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Name </option>
                 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > Created On </option>
                 <option value='3' <?php if($selected_status_id=='3') { echo "selected"; } ?> > Position </option>
                 <?php
			 }
	 }
	
	function getGENDER($selected_status_id, $requesttype) {
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select') { ?>
                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Male </option>
                 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > Female </option>
                 <option value='3' <?php if($selected_status_id=='3') { echo "selected"; } ?> > Trangender </option>
                 <?php
			 }
		if($requesttype == 'label') { 
                  if($selected_status_id=='1') { return 'Male';}
                  if($selected_status_id=='2') { return 'Female';}
                  if($selected_status_id=='3') { return 'Trangender';}
                
			 }
	 }
	
	//Time Zone
	function getTIMEZONE($selected_status_id, $requesttype) {
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select') { ?>
                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Asia / Kolkotta </option>
                 
                 <?php
			 }
			 
			 if($requesttype == 'label') {

                if($selected_status_id == '1') {  
                	
                    return "Asia / Kolkotta";
                }

			 }
	 }
	
	//Language
	function getLANGUAGE($selected_status_id, $requesttype) {
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select') { ?>
                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > English</option>
                 <?php
			 }
	 }
	
	//Currency
	function getCUREENCY($selected_type_id, $requesttype){
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select'){
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_currency_code`") or die("#PARENT-LABEL: Getting Parent Category: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$id_countries = $fetch_data['id_countries'];
				$name = $fetch_data['name'];
			?>
            <option value="<?php echo $id_countries; ?>" <?php if($selected_type_id == $id_countries){ echo "selected"; } ?>><?php echo $name; ?></option>
		<?php
            }	
		}
		/*****************  label  *****************/	
		if($requesttype == 'currrency_symbol'){
			//`id_countries`, `name`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `currency_code`, `currency_name`, `currrency_symbol`, `flag` FROM `js_currency_code`
			$selected_query = sqlQUERY_LABEL("SELECT currrency_symbol FROM `js_currency_code` where id_countries='$selected_type_id'") or die("#PARENT-LABEL: Getting Parent Category: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				echo $fetch_data['currrency_symbol'];
            }	
		}
	}
	
	//Country
	function getCOUNTRY($selected_status_id, $requesttype) {
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select') { ?>
                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > India </option>
                 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > America </option>
                 <?php
			 }
			 
			  if($requesttype == 'label') {

                if($selected_status_id == '1') {  
                	
                    return "India";
                }
				 if($selected_status_id == '2') {  
                	
                    return "America";
                }
			 }
	 }
	 
	 //To get Email Template
	function getEMAILTEMPLATE($selected_type_id, $requesttype){ 
	
	if($requesttype == 'select'){   
	
		$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_emailtemplate` where `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".sqlERROR_LABEL());
		?> 
		<option value="">Choose Template </option>  
		<?php
		while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			$template_ID = $fetch_data['template_ID'];
			$template_name = $fetch_data['template_name'];   
		?>
		<option value="<?php echo $template_ID; ?>" <?php if($selected_type_id == $template_ID){ echo "selected"; } ?>><?php echo $template_name; ?></option>
	<?php
	
		}	
		
	} //end of select

	/*****************  SELECT OPTION   *****************/	
	if($requesttype == 'label'){   

		$selected_query = sqlQUERY_LABEL("SELECT template_name FROM `js_emailtemplate` where `deleted` = '0' and `template_ID` = '$selected_type_id'") or die("#CUSTOMGROUP-LABEL: Getting Custom Group: ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($selected_query) > 0) {
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				return $fetch_data['template_name'];
			}	
		} else {
			return '--';	
		}
		
	}		}
	
	 //To get New Order Confirmation
	function getNEWORDERCONFIRMATION($selected_type_id, $requesttype){ 
	
	if($requesttype == 'select') { ?>
			 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > General Contact </option>
			 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > Sales Representative </option>
			 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > Customer Support </option>
			 <?php
		 }
	}
	
	//To get Single Field Value
	function getSINGLEDBVALUE($requested_fieldvalue, $request_wherecondition, $requested_table, $requesttype){ 
		
		/*****************  SHOW LABEL   *****************/	
		if($requesttype == 'label'){   
          
			$selected_query = sqlQUERY_LABEL("SELECT $requested_fieldvalue FROM `$requested_table` where $request_wherecondition") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			if(sqlNUMOFROW_LABEL($selected_query) > 0) {
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					return $fetch_data[$requested_fieldvalue];
				}	
			} else {
				return 'N/A';	
			}
			
		}
				
	}
	
	
	function getodSTATUS($selected_type_id){ 
		
		/*****************  SHOW LABEL   *****************/	
		if($selected_type_id =='1'){
		$status ="<h6 class='badge btn-success'>Paid</h6>";	
		}elseif($selected_type_id=='2'){
		$status ="<h6 class='badge btn-secondary'>Cancelled</h6>";	
		}elseif($selected_type_id=='3'){
		$status ="<h6 class='badge btn-warning'>Pending</h6>";	
		}elseif($selected_type_id=='4'){
		$status ="<h6 class='badge btn-danger' class='text-success'>Awaiting Bank Wire Payment</h6>";	
		}elseif($selected_type_id=='5'){
		$status ="<h6 class='badge btn-info' >Under Shipment</h6></br>";	
		}elseif($selected_type_id=='6'){
		$status ="<h6 class='badge btn-dark' >Delivered</h6>";	
		}elseif($selected_type_id=='7'){
		$status ="<h6 class='badge btn-light'>Courier Process</h6>";	
		}elseif($selected_type_id=='8'){
		$status ="<h6 class='badge btn-primary'>New</h6>";	
		}
		return $status;
		
				// $status ="<h6 class='text-warning'>Ordered</h6></br>";	
				// }elseif($selected_type_id=='2'){
				// $status ="<h6 class='text-primary'>Packed</h6></br>";	
				// }elseif($selected_type_id=='3'){
				// $status ="<h6 class='text-info'>Shipped</h6></br>";	
				// }elseif($selected_type_id=='4'){
				// $status ="<h6 class='text-success'>Delivered</h6></br>";	
				// }elseif($selected_type_id=='5'){
				// $status ="<h6 class='text-danger'>Failed</h6></br>";	
				// }elseif($selected_type_id=='6'){
				// $status ="<h6 class='text-secondary'>Returned</h6></br>";	
				// }else{
				// $status ="<h6 class='text-danger'>Cancelled</h6></br>";	
				// }

				
	}
	
	function getpaymentSTATUS($selected_type_id){ 
		
		/*****************  SHOW LABEL   *****************/	
		if($selected_type_id =='1'){
		$status ="<h6 class='text-success'>paid</h6>";	
		}elseif($selected_type_id=='2'){
		$status ="<h6 class='text-secondary'>Cancelled</h6>";	
		}else{
		$status ="<h6 class='text-warning' class='text-info'>Pending</h6>";	
		}
		return $status;
		
				// $status ="<h6 class='text-warning'>Ordered</h6></br>";	
				// }elseif($selected_type_id=='2'){
				// $status ="<h6 class='text-primary'>Packed</h6></br>";	
				// }elseif($selected_type_id=='3'){
				// $status ="<h6 class='text-info'>Shipped</h6></br>";	
				// }elseif($selected_type_id=='4'){
				// $status ="<h6 class='text-success'>Delivered</h6></br>";	
				// }elseif($selected_type_id=='5'){
				// $status ="<h6 class='text-danger'>Failed</h6></br>";	
				// }elseif($selected_type_id=='6'){
				// $status ="<h6 class='text-secondary'>Returned</h6></br>";	
				// }else{
				// $status ="<h6 class='text-danger'>Cancelled</h6></br>";	
				// }

				
	}
	
	function getCUSTOMERADDRESS($selected_type_id,$requesttype){ 
		
		/*****************  SHOW LABEL   *****************/	
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` where od_id='$selected_type_id' order by od_id desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){
		$od_shipping_address1 = $fetch_records['od_shipping_address1'];	
		$od_shipping_address2 = $fetch_records['od_shipping_address2'];	
		$od_shipping_city = $fetch_records['od_shipping_city'];	
		$od_shipping_state = $fetch_records['od_shipping_state'];	
		$od_shipping_postal_code = $fetch_records['od_shipping_postal_code'];	
		$od_shipping_country = $fetch_records['od_shipping_country'];	
		$shipping =$od_shipping_address1.','.$od_shipping_address2.','.$od_shipping_city.','.$od_shipping_postal_code.','.$od_shipping_country.'.';
		
		$od_payment_address1 = $fetch_records['od_payment_address1'];	
		$od_payment_address2 = $fetch_records['od_payment_address2'];	
		$od_payment_city = $fetch_records['od_payment_city'];	
		$od_payment_state = $fetch_records['od_payment_state'];	
		$od_payment_postal_code = $fetch_records['od_payment_postal_code'];	
		$od_payment_country = $fetch_records['od_payment_country'];	
		$od_payment_mode = $fetch_records['od_payment_mode'];	
		$billing .=$od_payment_address1.','.$od_payment_address2.','.$od_payment_city.','.$od_payment_state.','.$od_payment_postal_code.','.$od_payment_country.'.';
		$billing .="</br><small class='text-secondary'> Via ".$od_payment_mode."</small>";

				
	}
	
	if($requesttype =='shipping'){
	return $shipping;	
	}
	if($requesttype =='billing'){
	return $billing;	
	}
	
	}
	
	
		function checkmenu($selected_menu) {
		
		$get_data = sqlQUERY_LABEL("select page_ID from js_pagemenu where menu_title = '$selected_menu' and sidebar_display = '1' and `deleted`='0' and status = '1'") or die(sqlERROR_LABEL());

			$count_rows = sqlNUMOFROW_LABEL($get_data);
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($get_data)) {
				$page_ID = $getstatus_fetch['page_ID'];
			 }
			 return $page_ID;
	}

	/*****************  Check Role access*****************/		
	function checkrolemenu($page_ID,$user_level) {
		$get_data = sqlQUERY_LABEL("select page_allowed from js_rolemenu where role_ID = '$user_level' and `deleted`='0'") or die(sqlERROR_LABEL());
			$count_rows = sqlNUMOFROW_LABEL($get_data);
			if($count_rows > 0){
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($get_data)) {
					$page_allowed = explode(',',$getstatus_fetch['page_allowed']);
					if(in_array($page_ID,$page_allowed)){
						return 1;
					}else{
						return 0;
					}
				}
			}else{
				return 0;
			}
	}

/*****************  Check Role access*****************/		
function checkmenupage($pagename,$pagetype,$user_level) {
	$get_data = sqlQUERY_LABEL("select page_ID from js_pagemenu where page_name = '$pagename' and page_type = '$pagetype' and `deleted`='0' and status = '1'") or die(sqlERROR_LABEL());
		$count_rows = sqlNUMOFROW_LABEL($get_data);
		if($count_rows > 0){
		 while($getstatus_fetch = sqlFETCHARRAY_LABEL($get_data)) {
				$page_ID = $getstatus_fetch['page_ID'];
		 }
				$access = checkrolemenu($page_ID,$user_level);
				
		}else{
			$access = 0;
		}
		return $access;
}

/*****************  Get Page type function *****************/		
function getParentmenu($selected_service_type,$requesttype) {
		
		//`status_type`, `status_id`, `status_title` FROM `rbc_Status`
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'select') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `page_ID`, `menu_title` FROM `js_pagemenu` where parent_ID ='0' and status ='1' and deleted='0' order by menu_title ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$parent_ID = $getstatus_fetch['page_ID'];
				 	$menu_title = $getstatus_fetch['menu_title'];
				 ?>
                 <option value='<?php echo $parent_ID; ?>' <?php if($selected_service_type == $parent_ID) { echo "selected"; } ?> >
				 	<?php echo $menu_title; ?>
                 </option>
                 <?php
			 }
		}

		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `menu_title` FROM `js_pagemenu` where `page_ID`='$selected_service_type' and deleted ='0'") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$menu_title = $getstatus_fetch['menu_title'];
					return $menu_title;
			 }
		}
		
	}
	
	/*****************  Get Page type function *****************/	

	function pageTYPE($selected_type_id, $requesttype){


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {  ?>


			<option value="" <?php if($selected_type_id == ''){ echo "selected"; } ?>> --None-- </option>
            
            <option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>>Add</option>

            <option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>>Edit</option>

            <option value="3" <?php if($selected_type_id == '3'){ echo "selected"; } ?>>Delete</option>
			
			<option value="4" <?php if($selected_type_id == '4'){ echo "selected"; } ?>>List</option>
			
			<option value="5" <?php if($selected_type_id == '5'){ echo "selected"; } ?>>Preview</option>
			
			<option value="6" <?php if($selected_type_id == '6'){ echo "selected"; } ?>>Import</option>
			
			<option value="7" <?php if($selected_type_id == '7'){ echo "selected"; } ?>>Product Step1</option>
			
			<option value="8" <?php if($selected_type_id == '8'){ echo "selected"; } ?>>Product Step2</option>
			
			<option value="9" <?php if($selected_type_id == '9'){ echo "selected"; } ?>>Product Step3</option>
			
			<option value="10" <?php if($selected_type_id == '10'){ echo "selected"; } ?>>Product Step4</option>
			
			<option value="11" <?php if($selected_type_id == '11'){ echo "selected"; } ?>>Product Step5</option>
			
			<option value="12" <?php if($selected_type_id == '12'){ echo "selected"; } ?>>Product Step6</option>
			
			<option value="13" <?php if($selected_type_id == '13'){ echo "selected"; } ?>>Import Images</option>
			
			<option value="14" <?php if($selected_type_id == '14'){ echo "selected"; } ?>>Variant Import</option>

	<?php
	
		}
		
			if($requesttype == 'label'){  
		
			
			if($selected_type_id == '1') {
				return  'Add';
			}
			if($selected_type_id == '2') {
				return  'Edit';
			}
			if($selected_type_id == '3') {
				return  'Delete';
			}
			if($selected_type_id == '4') {
				return  'List';
			}
			if($selected_type_id == '5') {
				return  'Preview';
			}
			if($selected_type_id == '6') {
				return  'Import';
			}
			if($selected_type_id == '7') {
				return  'Product Step1';
			}
			if($selected_type_id == '8') {
				return  'Product Step2';
			}
			if($selected_type_id == '9') {
				return  'Product Step3';
			}
			if($selected_type_id == '10') {
				return  'Product Step4';
			}
			if($selected_type_id == '11') {
				return  'Product Step5';
			}
			if($selected_type_id == '12') {
				return  'Product Step6';
			}
			if($selected_type_id == '13') {
				return  'Import Images';
			}
			if($selected_type_id == '14') {
				return  'Variant Import';
			}
				
		}
		
		if($requesttype == 'getid') {  
		
		if($selected_type_id == 'add') {
				return  '1';
			}
			if($selected_type_id == 'edit') {
				return  '2';
			}
			if($selected_type_id == 'delete') {
				return  '3';
			}
			if($selected_type_id == 'list') {
				return  '4';
			}
			if($selected_type_id == 'preview') {
				return  '5';
			}
			if($selected_type_id == 'import') {
				return  '6';
			}
			if($selected_type_id == 'step1') {
				return  '7';
			}
			if($selected_type_id == 'step2') {
				return  '8';
			}
			if($selected_type_id == 'step3') {
				return  '9';
			}
			if($selected_type_id == 'step4') {
				return  '10';
			}
			if($selected_type_id == 'step5') {
				return  '11';
			}
			if($selected_type_id == 'step6') {
				return  '12';
			}
			
			if($selected_type_id == 'import_images') {
				return  '13';
			}
			if($selected_type_id == 'import_Variant') {
				return  '14';
			}
		
		}
	}
	
/*****************  Get Rolemenu *****************/		
function getrole($selected_service_type,$requesttype) {
		
		//`status_type`, `status_id`, `status_title` FROM `rbc_Status`
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'select') {

			 $getstatus_query = sqlQUERY_LABEL("SELECT * FROM `js_rolemenu` where deleted='0' and role_ID NOT IN('3') order by role_ID desc") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$role_ID = $getstatus_fetch['role_ID'];
				 	$role_name = $getstatus_fetch['role_name'];
				 ?>
                 <option value='<?php echo $role_ID; ?>' <?php if($selected_service_type == $role_ID) { echo "selected"; } ?> >
				 	<?php echo $role_name; ?>
                 </option>
                 <?php
			 }
		}

		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `role_name` FROM `js_rolemenu` where `role_ID`='$selected_service_type' and deleted ='0'") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$role_name = $getstatus_fetch['role_name'];
					return $role_name;
			 }
		}
		
	}


function orderREFNOGENERATOR($__main_orderID) {
	
	if($__main_orderID < 10)
	{	
	$ord_id="ORD000000".$__main_orderID;
	}
	else if($__main_orderID >= 10 and $__main_orderID <= 99)
	{	 
	$ord_id="ORD00000".$__main_orderID;
	}
	else if($__main_orderID >= 100 and $__main_orderID <= 999)
	{
	$ord_id="ORD0000".$__main_orderID;
	}
	else if($__main_orderID >= 1000 and $__main_orderID <= 9999)
	{
	$ord_id="ORD000".$__main_orderID;
	}
	else if($__main_orderID >= 10000 and $__main_orderID <= 99999)
	{
	$ord_id="ORD00".$__main_orderID;
	}
	else if($__main_orderID >= 100000 and $__main_orderID <= 999999)
	{
	$ord_id="ORD0".$__main_orderID;
	}
	else if($__main_orderID >= 1000000 and $__main_orderID <= 9999999)
	{
	$ord_id="ORD".$__main_orderID;
	}
	return $ord_id;
}

/*****************  Get Rolemenu *****************/		
function getorder_paymentSTATUS($selected_type, $order_ID, $selectedrecordID, $requesttype) {
		
		//`status_type`, `status_id`, `status_title` FROM `rbc_Status`
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'select') { ?>
			<option value="">Choose Status</option>
			<?php
			 $check_shop_order_log = sqlQUERY_LABEL("SELECT od_status FROM `js_shop_order_log` where od_id ='$order_ID' order by od_status ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch_order = sqlFETCHARRAY_LABEL($check_shop_order_log)) {
				 	$od_status[] = $getstatus_fetch_order['od_status'];
			 }
				$array_of_od_status = implode("','",$od_status);
			
			if($order_ID != ''){
				$filterby_status = " and order_status_refno NOT IN ('$array_of_od_status')";
			}
		$getstatus_query = sqlQUERY_LABEL("SELECT * FROM `js_shop_orderstatus` where order_status_type='$selected_type' {$filterby_status} order by order_status_refno ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$order_status_id = $getstatus_fetch['order_status_id'];
				 	$order_status_refno = $getstatus_fetch['order_status_refno'];
				 	$order_status_name = $getstatus_fetch['order_status_name'];
				 ?>
                 <option value='<?php echo $order_status_refno; ?>' <?php if($selectedrecordID == $order_status_refno) { echo "selected"; } ?> >
				 	<?php echo $order_status_name; ?>
                 </option>
                 <?php
			 }
		}
		if($requesttype == 'select_in_delivery_agent') {?>
			<option value="">Choose Status</option>
			<?php
			 $getstatus_query = sqlQUERY_LABEL("SELECT * FROM `js_shop_orderstatus` where order_status_refno IN ('5','6') and order_status_type='$selected_type' order by order_status_refno ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$order_status_id = $getstatus_fetch['order_status_id'];
				 	$order_status_refno = $getstatus_fetch['order_status_refno'];
				 	$order_status_name = $getstatus_fetch['order_status_name'];
				 ?>
                 <option value='<?php echo $order_status_refno; ?>' <?php if($selectedrecordID == $order_status_refno) { echo "selected"; } ?> >
				 	<?php echo $order_status_name; ?>
                 </option>
                 <?php
			 }
		}
		
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `order_status_name` FROM `js_shop_orderstatus` where `order_status_refno`='$selectedrecordID' and order_status_type='$selected_type'") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$order_status_name = $getstatus_fetch['order_status_name'];
					return $order_status_name;
			 }
		}
		
	}
	
	
function getCUSTOMERDETAILS($user_id, $request_type){
	
	$list_customer = sqlQUERY_LABEL("SELECT * FROM `js_customer` where user_id='$user_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_customer_list = sqlNUMOFROW_LABEL($list_customer);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_customer)){
		$customer_fname = $fetch_records['customerfirst'];	
		$customer_lname = $fetch_records['customerlast'];	
		$customer_email = $fetch_records['customeremail'];	
		$customerdob = $fetch_records["customerdob"];
		$customergender = $fetch_records["customergender"];
		$customerphone = $fetch_records["customerphone"];
		$customeraddress1 = $fetch_records["customeraddress1"];
		$customeraddress2 = $fetch_records["customeraddress2"];
		$customerpincode = $fetch_records["customerpincode"];
		$customerstate = $fetch_records["customerstate"];
		$status = $fetch_records["status"];
	}
	if($request_type == 'name'){
		return $customer_fname.' '.$customer_lname;
	} if($request_type == 'email'){
		return $customer_email;
	} if($request_type == 'dob'){
		return $customerdob;
	} if($request_type == 'phone'){
		return $customerphone;
	}
}

function getORDERQTY($od_id, $user_id){
	
	$list_order_list = sqlQUERY_LABEL("SELECT * FROM `js_shop_order_item` where od_id='$od_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_order_list = sqlNUMOFROW_LABEL($list_order_list);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_order_list)){
		
		$order_qty = $fetch_records['od_qty'];	
	}
	return $order_qty;
	
}	
	
	
	//To get Single Field Value
	function getVARIANT_CODE($prdt_ID, $requesttype){ 
		
		/*****************  SHOW LABEL   *****************/	
		if($requesttype == 'get_variant_code'){   
		
			$selected_query = sqlQUERY_LABEL("SELECT `variant_code` FROM `js_productvariants` where `parentproduct`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$variant_code = $fetch_data['variant_code'];
			}	
			return $variant_code;
		}

		if($requesttype == 'variant_code_from_variant_ID'){   
		
			$selected_query = sqlQUERY_LABEL("SELECT `variant_code` FROM `js_productvariants` where `variant_ID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$variant_code = $fetch_data['variant_code'];
			}	
			return $variant_code;
		}

		if($requesttype == 'variant_name_from_variant_ID'){   
		
			$selected_query = sqlQUERY_LABEL("SELECT `variant_name` FROM `js_productvariants` where `variant_ID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$variant_name = $fetch_data['variant_name'];
			}	
			return $variant_name;
		}
		
		if($requesttype == 'variant_mrp_price'){   
		
			$selected_query = sqlQUERY_LABEL("SELECT `variant_mrp_price` FROM `js_productvariants` where `variant_ID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$variant_mrp_price = $fetch_data['variant_mrp_price'];
			}	
			return $variant_mrp_price;
		}
		
	}

	//To get Single Field Value
	/* function getPRDT_ESTORECODE($prdt_ID, $variant_id, $requesttype){ 

		if($requesttype == 'get_prdt_name'){
			
			$selected_query = sqlQUERY_LABEL("SELECT `producttitle` FROM `js_product` where `productID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$producttitle = $fetch_data['producttitle'];
			}	
			return $producttitle;
		}
			
		if($variant_id =='' || $variant_id == '0'){
			/*****************  SHOW LABEL   *****************/	
			/* if($requesttype == 'get_prdt_estore_code'){
				
				$selected_query = sqlQUERY_LABEL("SELECT `productestore_code` FROM `js_product` where `productID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					$productestore_code = $fetch_data['productestore_code'];
				}	
				return $productestore_code;
			}
		} else {	
			if($requesttype == 'get_prdt_estore_code'){
				
				$selected_query = sqlQUERY_LABEL("SELECT `variant_code` FROM `js_productvariants` where `parentproduct`='$prdt_ID' and `variant_ID`='$variant_id'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					$variant_code = $fetch_data['variant_code'];
				}	
				return $variant_code;
			}
		}
	}	 */ 
	
	function getPRDT_CODE($prdt_ID, $variant_id, $requesttype){ 
		
		if($variant_id =='' || $variant_id == '0'){
			/*****************  SHOW LABEL   *****************/	
			if($requesttype == 'get_prdt_code'){
				
				$selected_query = sqlQUERY_LABEL("SELECT `productsku` FROM `js_product` where `productID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					$productestore_code = $fetch_data['productsku'];
				}	
				return $productestore_code;
			}
		} else {	
			if($requesttype == 'get_prdt_code'){
				
				$selected_query = sqlQUERY_LABEL("SELECT `variant_code` FROM `js_productvariants` where `parentproduct`='$prdt_ID' and `variant_ID`='$variant_id'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					$variant_code = $fetch_data['variant_code'];
				}	
				return $variant_code;
			}
		}
		
		if($requesttype == 'get_prdt_name'){
			
				$selected_query_name = sqlQUERY_LABEL("SELECT `producttitle` FROM `js_product` where `productID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query_name)) {
					$prdt_name = $fetch_data['producttitle'];
				}	
				return $prdt_name;	
			
		}
	}
	
	function getVRIANTPRODUCTPRICE($pd_id, $var_id){
		
		if($pd_id != '' && $var_id != '0'){
			$selected_query = sqlQUERY_LABEL("SELECT `variant_msp_price` FROM `js_productvariants` where `parentproduct`='$pd_id' and `variant_ID`='$var_id'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					$variant_msp_price = $fetch_data['variant_msp_price'];
				}
				
				return $variant_msp_price; 
		}
		
	}
	
	function getTotal_cart_amount($pd_id, $user_id, $ses_id, $request_type)
	{
		
		if(!empty($user_id)){
			$cart_query= sqlQUERY_LABEL("SELECT * FROM `js_shop_order_item` WHERE deleted='0' and user_id = '$user_id' and status ='1'") or die("#CART-PRICE: Unable to get cart value ".sqlERROR_LABEL());
		}else{
			//echo $ses_id;die;
			$cart_query= sqlQUERY_LABEL("SELECT * FROM `js_shop_order_item` WHERE deleted='0' and od_session = '$ses_id' and user_id ='' and status='1'") or die("#CART-PRICE: Unable to get cart value ".sqlERROR_LABEL());
		}
			
										// echo $query;
		//$cart_result = sqlQUERY_LABEL($cart_query);
		while($cart_row = sqlFETCHARRAY_LABEL($cart_query))
		{
		$product_ID = $cart_row['pd_id'];
		$product_qty = $cart_row['od_qty'];
		$product_price = $cart_row['od_price'];
		$item_tax1 = $cart_row['item_tax1'];
		$item_tax2 = $cart_row['item_tax2'];
		$od_item_discount += $cart_row['od_item_discount'];
		//$total_price = $product_qty * $product_price;
		$total_cart_amount += ($product_price+$item_tax1+$item_tax2 - $od_item_discount);
		
		}
		if($request_type == 'subtotal'){
			return number_format($total_cart_amount,2); 
		}
		if($request_type == 'total'){
			return $total_cart_amount; 
		}
	}
	
	function getnewORDERREF($order_reference_id) {	
		if($order_reference_id == '') {
			$collectITEM_Count = sqlQUERY_LABEL("SELECT od_refno, od_id FROM `js_shop_order` where deleted = '0' order by od_id DESC limit 0,1") or die("Unable to get Refno: ".sqlERROR_LABEL());
			if(sqlNUMOFROW_LABEL($collectITEM_Count) > 0 ) {
			while($collectITEM_id = sqlFETCHARRAY_LABEL($collectITEM_Count)) {
			$orderCODE_detail = $collectITEM_id['od_refno'];
			}
			$orderCODE_detail++;
			} else {
				
			$orderCODE_detail = "RAORD-".date('my').'-11000'; }
			} else {		
			$collectBILL = sqlQUERY_LABEL("SELECT od_refno FROM `js_shop_order` where od_refno = '$order_reference_id'") or die("Unable to get Bill details: ".sqlERROR_LABEL());
			while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
			$orderCODE_detail = $collectBILL_id['od_refno'];
			}
			}
			return $orderCODE_detail;
	}
	
	function checkproductPRICE($productID) {
	
	//check in product variant avialble
	$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID'") or die("Unable to get records:".sqlERROR_LABEL());			

	$count_productvariant_list = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
	if($count_productvariant_list > 0) {
		//get variant first price
		$check_prdt_variant_1 = sqlQUERY_LABEL("SELECT variant_mrp_price, variant_msp_price, variant_taxsplit1, variant_taxsplit2 FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID' order by variant_msp_price ASC LIMIT 1") or die("Unable to get records:".sqlERROR_LABEL());	
		while($variant_row_1 = sqlFETCHARRAY_LABEL($check_prdt_variant_1)){
			$variant_mrp_price = $variant_row_1["variant_mrp_price"];
			$variant_msp_price_1 = $variant_row_1["variant_msp_price"];
			$variant_taxsplit1 = $variant_row_1["variant_taxsplit1"];
			$variant_taxsplit2 = $variant_row_1["variant_taxsplit2"];
			$tot_tax_value = $variant_taxsplit1 + $variant_taxsplit2;
		}
//echo $tot_tax_value; 		
		
		//get variant last price
		$check_prdt_variant_2 = sqlQUERY_LABEL("SELECT variant_msp_price FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID'  order by variant_msp_price DESC LIMIT 1") or die("Unable to get records:".sqlERROR_LABEL());	
		while($variant_row_2 = sqlFETCHARRAY_LABEL($check_prdt_variant_2)){
			$variant_msp_price_2 = $variant_row_2["variant_msp_price"];
		}		
		//echo $tot_tax_value.'</br>'.$variant_msp_price_1;
		
		if($variant_mrp_price > $variant_msp_price_1) {
			$productPRICETAG = '<p class="product-price">
			<span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">'.general_currency_symbol.'</span>'.formatCASH($variant_msp_price_1+$tot_tax_value).'</span>   &nbsp;
		<del><span class="kreen-Price-amount amount text-light"><span class="kreen-Price-currencySymbol text-light">'.general_currency_symbol.'</span>'.formatCASH($variant_mrp_price).'</span></del></p>';
		} else {
			$productPRICETAG = '<p class="product-price">
		<span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">'.general_currency_symbol.'</span>'.formatCASH($variant_msp_price_1+$tot_tax_value).'</span> </p>';
		}
		
	} else {

		$__product_datas = sqlQUERY_LABEL("SELECT productID, productsku FROM `js_product` where productID = '$productID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
		while($__row = sqlFETCHARRAY_LABEL($__product_datas)){
			$product_code = $__row["productsku"];
		}
		
		$list_producttype_data = sqlQUERY_LABEL("SELECT * FROM `js_product` where productsku = '$product_code' and deleted = '0' and status = '1'") or die ("#1-Unable to get records:".sqlERROR_LABEL());
		
		while($row = sqlFETCHARRAY_LABEL($list_producttype_data)) {
			$prdt_mrp = $row['productMRPprice'];
			$prdt_msp = $row['productsellingprice'];
			$prdt_available_qty = $row['productavailablestock'];
			$prdt_stockstatus = $row['productstockstatus'];
		}	
				
				
		if($prdt_mrp > $prdt_msp) {
			$productPRICETAG = '<p class="product-price">
			 <span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">'.general_currency_symbol.'</span>'.formatCASH($prdt_msp).'</span> &nbsp;
		<del><span class="kreen-Price-amount amount text-light"><span class="kreen-Price-currencySymbol text-light">'.general_currency_symbol.'</span>'.formatCASH($prdt_mrp).'</span> </del>
		</p>';
		} else {
			$productPRICETAG = '<p class="product-price">
		 <ins><span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">'.general_currency_symbol.'</span>'.formatCASH($prdt_msp).'</span></ins>
		</p>';
		}
		
	}
	
	return $productPRICETAG;
	
}


function checkproductPRICE1($productID,$product_variant_id) {
	//echo $product_variant_id;exit();
	//check in product variant avialble
	//echo "SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID' and `variant_ID`='$product_variant_id'";
	$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID' and `variant_ID`='$product_variant_id'") or die("Unable to get records:".sqlERROR_LABEL());			

	$count_productvariant_list = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
	if($count_productvariant_list > 0) {
		//get variant first price
		$check_prdt_variant_1 = sqlQUERY_LABEL("SELECT variant_mrp_price, variant_msp_price, variant_taxsplit1, variant_taxsplit2 FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID' and `variant_ID`='$product_variant_id' order by variant_msp_price ASC LIMIT 1") or die("Unable to get records:".sqlERROR_LABEL());	
		while($variant_row_1 = sqlFETCHARRAY_LABEL($check_prdt_variant_1)){
			$variant_mrp_price = $variant_row_1["variant_mrp_price"];
			$variant_msp_price_1 = $variant_row_1["variant_msp_price"];
			$variant_taxsplit1 = $variant_row_1["variant_taxsplit1"];
			$variant_taxsplit2 = $variant_row_1["variant_taxsplit2"];
			$tot_tax_value = $variant_taxsplit1 + $variant_taxsplit2;
		}
//echo $tot_tax_value; 		
		
		//get variant last price
		$check_prdt_variant_2 = sqlQUERY_LABEL("SELECT variant_msp_price FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID' and `variant_ID`='$product_variant_id' order by variant_msp_price DESC LIMIT 1") or die("Unable to get records:".sqlERROR_LABEL());	
		while($variant_row_2 = sqlFETCHARRAY_LABEL($check_prdt_variant_2)){
			$variant_msp_price_2 = $variant_row_2["variant_msp_price"];
		}		
		//echo $tot_tax_value.'</br>'.$variant_msp_price_1;
		
		if($variant_mrp_price > $variant_msp_price_1) {
			$productPRICETAG = '<p class="product-price">
			<span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">'.general_currency_symbol.'</span>'.formatCASH($variant_msp_price_1+$tot_tax_value).'</span>   &nbsp;
		<del><span class="kreen-Price-amount amount text-light"><span class="kreen-Price-currencySymbol text-light">'.general_currency_symbol.'</span>'.formatCASH($variant_mrp_price).'</span></del></p>';
		} else {
			$productPRICETAG = '<p class="product-price">
		<span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">'.general_currency_symbol.'</span>'.formatCASH($variant_msp_price_1+$tot_tax_value).'</span> </p>';
		}
		
	} else {

		$__product_datas = sqlQUERY_LABEL("SELECT productID, productsku FROM `js_product` where productID = '$productID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
		while($__row = sqlFETCHARRAY_LABEL($__product_datas)){
			$product_code = $__row["productsku"];
		}
		
		$list_producttype_data = sqlQUERY_LABEL("SELECT * FROM `js_product` where productsku = '$product_code' and deleted = '0' and status = '1'") or die ("#1-Unable to get records:".sqlERROR_LABEL());
		
		while($row = sqlFETCHARRAY_LABEL($list_producttype_data)) {
			$prdt_mrp = $row['productMRPprice'];
			$prdt_msp = $row['productsellingprice'];
			$prdt_available_qty = $row['productavailablestock'];
			$prdt_stockstatus = $row['productstockstatus'];
		}	
				
				
		if($prdt_mrp > $prdt_msp) {
			$productPRICETAG = '<p class="product-price">
			 <span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">'.general_currency_symbol.'</span>'.formatCASH($prdt_msp).'</span> &nbsp;
		<del><span class="kreen-Price-amount amount text-light"><span class="kreen-Price-currencySymbol text-light">'.general_currency_symbol.'</span>'.formatCASH($prdt_mrp).'</span> </del>
		</p>';
		} else {
			$productPRICETAG = '<p class="product-price">
		 <ins><span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">'.general_currency_symbol.'</span>'.formatCASH($prdt_msp).'</span></ins>
		</p>';
		}
		
	}
	
	return $productPRICETAG;
	
}

function getProduct_COUNT_USING_CATEGORY_ID($category_id){
	//echo "SELECT * FROM `js_product` where productcategory = '$category_id' and deleted = '0' and status = '1'";
	$__product_category_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where productcategory = '$category_id' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
	
	$category_product_count = sqlNUMOFROW_LABEL($__product_category_datas);	
	
	return $category_product_count;
}


	function getDELIVERAGENT( $selected_type, $requesttype) {
		
		//`status_type`, `status_id`, `status_title` FROM `rbc_Status`
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'select') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT * FROM `js_deliveryagent` where status='1' and deleted ='0' order by da_first ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$da_ID = $getstatus_fetch['da_ID'];
				 	$da_first = $getstatus_fetch['da_first'];
				 	$da_last = $getstatus_fetch['da_last'];
				 	$da_phone = $getstatus_fetch['da_phone'];
				 ?>
                 <option value='<?php echo $da_ID; ?>' <?php if($selected_type == $da_ID) { echo "selected"; } ?> >
				 	<?php echo $da_first.' '.$da_last.' - '.$da_phone; ?>
                 </option>
                 <?php
			 }
		}

		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			//echo "SELECT * FROM `js_deliveryagent` where `da_ID`='$selected_type' and status='1' and deleted = '0' ";
			 $getstatus_query = sqlQUERY_LABEL("SELECT * FROM `js_deliveryagent` where `da_ID`='$selected_type' and status='1' and deleted = '0' ") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$da_first = $getstatus_fetch['da_first'];
				 	$da_last = $getstatus_fetch['da_last'];
				 	$da_phone = $getstatus_fetch['da_phone'];
					return $da_first.' '.$da_last.' - '.$da_phone;
			 }
		}
		
	}
	
	
		function getVARIANT_ESTORECODE($prdt_ID, $requesttype){ 
		
		/*****************  SHOW LABEL   *****************/	
		if($requesttype == 'get_variant_estore_code'){   
		
			$selected_query = sqlQUERY_LABEL("SELECT `variant_code` FROM `js_productvariants` where `parentproduct`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$variant_code = $fetch_data['variant_code'];
			}	
			return $variant_code;
		}

		if($requesttype == 'variant_estore_code_from_variant_ID'){   
		
			$selected_query = sqlQUERY_LABEL("SELECT `variant_code` FROM `js_productvariants` where `variant_ID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$variant_code = $fetch_data['variant_code'];
			}	
			return $variant_code;
		}

		if($requesttype == 'variant_name_from_variant_ID'){   
		
			$selected_query = sqlQUERY_LABEL("SELECT `variant_name` FROM `js_productvariants` where `variant_ID`='$prdt_ID'") or die("#SINGLEVALUE-LABEL: Getting UNIQUE TABLE VALUE: ".sqlERROR_LABEL());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$variant_name = $fetch_data['variant_name'];
			}	
			return $variant_name;
		}
		
	}
	
	function getDELIVERAGENT_DETAILS($selected_id, $requesttype) {
		
		//`status_type`, `status_id`, `status_title` FROM `rbc_Status`
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'get_da_ID_from_user_ID') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `da_ID` FROM `js_deliveryagent` where status='1' and deleted ='0'  and user_id = '$selected_id'") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$da_ID = $getstatus_fetch['da_ID'];
			 }
				return $da_ID;
		}
	}
	
	function checkdashboardmenu($user_level,$check) {
	$get_data = sqlQUERY_LABEL("select dashboard_content_allowed from js_rolemenu where role_ID = '$user_level' and `deleted`='0'") or die(sqlERROR_LABEL());
		$count_rows = sqlNUMOFROW_LABEL($get_data);
		if($count_rows > 0){
		 while($getstatus_fetch = sqlFETCHARRAY_LABEL($get_data)) {
				$dashboard_content_allowed = explode(',',$getstatus_fetch['dashboard_content_allowed']);
				if(in_array($check,$dashboard_content_allowed)){
					return 1;
				}else{
					return 0;
				}
			}
		}else{
			return 0;
		}
}

function getMEMBERSHIP_ELIGIBILITY_ID($total_order_value, $requesttype) {
		
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'get_eligible_membership_ID') {
			//echo "SELECT `membership_ID` FROM `js_membership` where `membership_hd_amount` >= '$total_order_value' and status='1' and deleted = '0' ";
			if($total_order_value > 500 && $total_order_value < 1000 ){
				$filter_membership_id_value = 500;
			} else if($total_order_value > 999 && $total_order_value < 2500 ){
				$filter_membership_id_value = 1000;
			} elseif($total_order_value > 2499){
				$filter_membership_id_value = 2500;
			} else {
				$filter_membership_id_value = 0;
			}
			$getstatus_query = sqlQUERY_LABEL("SELECT `membership_ID`,`membership_hd_amount` FROM `js_membership` where `membership_eligibility_amt` >= '$filter_membership_id_value' and status='1' and deleted = '0' ") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				$membership_ID = $getstatus_fetch['membership_ID'];
			}
			return $membership_ID;
		}

		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'get_eligible_membership_points_expiry') {
			//echo "SELECT * FROM `js_deliveryagent` where `da_ID`='$selected_type' and status='1' and deleted = '0' ";
			$getstatus_query = sqlQUERY_LABEL("SELECT `membership_points_expiry` FROM `js_membership` where `membership_ID` = '$total_order_value' and status='1' and deleted = '0' ") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				$membership_points_expiry = $getstatus_fetch['membership_points_expiry'];
			}
			return $membership_points_expiry;
		}

		if($requesttype == 'get_membership_title') {
			//echo "SELECT * FROM `js_deliveryagent` where `da_ID`='$selected_type' and status='1' and deleted = '0' ";
			$getstatus_query = sqlQUERY_LABEL("SELECT `membership_title` FROM `js_membership` where `membership_ID` = '$total_order_value' and status='1' and deleted = '0' ") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				$membership_title = $getstatus_fetch['membership_title'];
			}
			return $membership_title;
		}
		
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'get_membership_point_rs') {
			//echo "SELECT * FROM `js_deliveryagent` where `da_ID`='$selected_type' and status='1' and deleted = '0' ";
			$getstatus_query = sqlQUERY_LABEL("SELECT `membership_point_rs` FROM `js_membership` where `membership_ID` = '$total_order_value' and status='1' and deleted = '0' ") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				$membership_point_rs = $getstatus_fetch['membership_point_rs'];
			}
			return round($membership_point_rs);
		}
	}
	
	function getORDER_DETAILS($selected_status_id, $request_type){
		
		if($request_type == 'get_od_ID_from_od_refno'){
		//echo "SELECT od_refno FROM `js_shop_order` where `od_id`='$od_id' and status='1' and deleted = '0' ";
		$getrefno_query = sqlQUERY_LABEL("SELECT od_id FROM `js_shop_order` where `od_refno`='$selected_status_id' and deleted = '0'") or die("#ORDREF-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getrefno_query)) {
				 	$od_id = $getstatus_fetch['od_id'];
			 }
			 return $od_id;
		}

		if($request_type == 'get_user_ID_from_od_id'){
		//echo "SELECT od_refno FROM `js_shop_order` where `od_id`='$od_id' and status='1' and deleted = '0' ";
		$getrefno_query = sqlQUERY_LABEL("SELECT od_userid FROM `js_shop_order` where `od_id`='$selected_status_id' and deleted = '0'") or die("#ORDREF-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getrefno_query)) {
				 	$od_userid = $getstatus_fetch['od_userid'];
			 }
			 return $od_userid;
		}
		
		if($request_type == 'get_od_total_from_od_id'){
		//echo "SELECT od_refno FROM `js_shop_order` where `od_id`='$od_id' and status='1' and deleted = '0' ";
		$getrefno_query = sqlQUERY_LABEL("SELECT od_total FROM `js_shop_order` where `od_id`='$selected_status_id' and deleted = '0'") or die("#ORDREF-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getrefno_query)) {
				 	$od_total = $getstatus_fetch['od_total'];
			 }
			 return $od_total;
		}

		if($request_type == 'get_od_discount_amount_from_od_id'){
		//echo "SELECT od_refno FROM `js_shop_order` where `od_id`='$od_id' and status='1' and deleted = '0' ";
		$getrefno_query = sqlQUERY_LABEL("SELECT od_discount_amount FROM `js_shop_order` where `od_id`='$selected_status_id' and deleted = '0'") or die("#ORDREF-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getrefno_query)) {
				 	$od_discount_amount = $getstatus_fetch['od_discount_amount'];
			 }
			 return $od_discount_amount;
		}

		if($request_type == 'get_od_date_from_od_id'){
		//echo "SELECT od_refno FROM `js_shop_order` where `od_id`='$od_id' and status='1' and deleted = '0' ";
		$getrefno_query = sqlQUERY_LABEL("SELECT od_date FROM `js_shop_order` where `od_id`='$selected_status_id' and deleted = '0'") or die("#ORDREF-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getrefno_query)) {
				 	$od_date = $getstatus_fetch['od_date'];
			 }
			 return $od_date;
		}
		
	}
	
	function getCUSTOMER_DATA($selected_type_id,$requesttype) {
	
		if($requesttype == 'customers_name') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT customerfirst FROM `js_customer` Where customerID ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $customers_name = $row_cus["customerfirst"];
				  return ucwords($customers_name);              
				}
		}

		if($requesttype == 'customers_refno') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT customer_ref_no FROM `js_customer` Where customerID ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $customer_ref_no = $row_cus["customer_ref_no"];
				  return $customer_ref_no;              
				}
		}
		
		if($requesttype == 'customers_mobile') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT customers_mobile FROM `js_customers` Where customers_id ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $customers_mobile = $row_cus["customers_mobile"];
				  return $customers_mobile;              
				}
		}

		if($requesttype == 'get_userID_from_reference_code') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT user_id FROM `js_customer` Where reference_code ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $user_id = $row_cus["user_id"];
				  return $user_id;              
				}
		}
		
		if($requesttype == 'userID') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT customerfirst FROM `js_customer` Where user_id ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $customerfirst = $row_cus["customerfirst"];
				  return $customerfirst;              
				}
		}

		if($requesttype == 'get_current_membership_id') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT current_membership_id FROM `js_customer` Where user_id ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $current_membership_id = $row_cus["current_membership_id"];
				  return $current_membership_id;              
				}
		}
		
		if($requesttype == 'get_customerid_from_userid') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT customerID FROM `js_customer` Where user_id ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $customerID = $row_cus["customerID"];
				  return $customerID;              
				}
		}
		
		if($requesttype == 'user_id') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT user_id FROM `js_customer` Where customerID ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $user_id = $row_cus["user_id"];
				  return $user_id;              
				}
		}

		if($requesttype == 'customerdob') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT customerdob FROM `js_customer` Where user_id ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $customerdob = $row_cus["customerdob"];
				  return $customerdob;              
				}
		}
		
		if($requesttype == 'get_rewards_multiplayer') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT rewards_multiplayer FROM `js_customer` Where user_id ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $rewards_multiplayer = $row_cus["rewards_multiplayer"];
				  return $rewards_multiplayer;              
				}
		}

		if($requesttype == 'referral_code') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT referral_code FROM `js_customer` Where user_id ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $referral_code = $row_cus["referral_code"];
				  return $referral_code;              
				}
		}

		if($requesttype == 'get_user_id_reference_code') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT reference_code FROM `js_customer` Where user_id ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $reference_code = $row_cus["reference_code"];
				  return $reference_code;              
				}
		}
		
		if($requesttype == 'reference_code') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT reference_code FROM `js_customer` Where customerID ='$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $reference_code = $row_cus["reference_code"];
				  return $reference_code;              
				}
		}
	}
	
	function getAREAMANEGER_DETAILS($selected_user_ID, $requesttype) {
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'get_am_ID_from_user_ID') {
			$getstatus_query = sqlQUERY_LABEL("SELECT `am_ID` FROM `js_area_manager` where user_id = '$selected_user_ID' and status='1' and deleted = '0' ") or die("#STATUS-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				$am_ID = $getstatus_fetch['am_ID'];
			}
			return $am_ID;
		}
		/*****************  SELECT OPTION   *****************/
	}
	
	function getPRODUCTNAME($selected_type_id) {
	
		if($selected_type_id != '') {
		
			$list_product_name = sqlQUERY_LABEL("SELECT producttitle FROM js_product WHERE productID = $selected_type_id") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_product_name)){
				  $product_name = $row_cus["producttitle"];
				  return ucwords($product_name);              
				}
		}
	}
	
	function star_rating($rating){
		if($rating == '1') {
			$return_star_rating = '<div class="tx-16 mg-l-10">
			  <i class="icon ion-md-star lh-0 tx-orange"></i>
			  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
			  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
			  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
			  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
			</div>';
		} if($rating == '2') {
		$return_star_rating = '<div class="tx-16 mg-l-10">
		  <i class="icon ion-md-star lh-0 tx-orange"></i>
		  <i class="icon ion-md-star lh-0 tx-orange"></i>
		  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
		  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
		  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
		</div>';
		} if($rating == '3') {
		$return_star_rating = '<div class="tx-16 mg-l-10">
		  <i class="icon ion-md-star lh-0 tx-orange"></i>
		  <i class="icon ion-md-star lh-0 tx-orange"></i>
		  <i class="icon ion-md-star lh-0 tx-orange"></i>
		  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
		  <i class="icon ion-md-star lh-0 tx-gray-300"></i>
		</div>';
		} if($rating == '4') {
		$return_star_rating = '<div class="tx-18">
			<i class="icon ion-md-star lh-0 tx-orange"></i>
			<i class="icon ion-md-star lh-0 tx-orange"></i>
			<i class="icon ion-md-star lh-0 tx-orange"></i>
			<i class="icon ion-md-star lh-0 tx-orange"></i>
			<i class="icon ion-md-star lh-0 tx-gray-300"></i>
		  </div>';
		}if($rating == '5') {
		$return_star_rating = '<div class="tx-16 mg-l-10">
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                        </div>';
		}
		return $return_star_rating;
	}
	
		function ORDER_STATUS_REPORT_DONAT_CHART($choosenmonth, $filter_by_agent, $reporttype){
		
		if($reporttype == 'TOTAL_ORDERS'){
					
			$counting_order_DETAILS = sqlQUERY_LABEL("SELECT COUNT(ORDER_DETAILS.`od_id`) AS TOTAL_ORDERS FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` and `carrier_name` = '$filter_by_agent' and  MONTH(ORDER_DETAILS.`od_date`) = '$choosenmonth' order by ORDER_DETAILS.`od_id` desc");
			
			if(sqlNUMOFROW_LABEL($counting_order_DETAILS)) {
				while($collect_order_DATA = sqlFETCHARRAY_LABEL($counting_order_DETAILS)) {
					echo $collect_order_DATA['TOTAL_ORDERS'];
				}
			} else {
				echo '0';
			}
		}

		if($reporttype == 'TOTAL_PENDING_ORDERS'){
					
			$counting_order_DETAILS = sqlQUERY_LABEL("SELECT COUNT(ORDER_DETAILS.`od_id`) AS TOTAL_ORDERS FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` and `carrier_name` = '$filter_by_agent' and  MONTH(ORDER_DETAILS.`od_date`) = '$choosenmonth' and ORDER_DETAILS.`od_status` != '5' and ORDER_DETAILS.`od_status` != '6' order by ORDER_DETAILS.`od_id` desc");
			
			if(sqlNUMOFROW_LABEL($counting_order_DETAILS)) {
				while($collect_order_DATA = sqlFETCHARRAY_LABEL($counting_order_DETAILS)) {
					echo $collect_order_DATA['TOTAL_ORDERS'];
				}
			} else {
				echo '0';
			}
		}
		
		if($reporttype == 'TOTAL_IN_PROGRESS_ORDERS'){
					
			$counting_order_DETAILS = sqlQUERY_LABEL("SELECT COUNT(ORDER_DETAILS.`od_id`) AS TOTAL_ORDERS FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` and `carrier_name` = '$filter_by_agent' and ORDER_DETAILS.`od_status` ='5'  and  MONTH(ORDER_DETAILS.`od_date`) = '$choosenmonth' order by ORDER_DETAILS.`od_id` desc");
			
			if(sqlNUMOFROW_LABEL($counting_order_DETAILS)) {
				while($collect_order_DATA = sqlFETCHARRAY_LABEL($counting_order_DETAILS)) {
					echo $collect_order_DATA['TOTAL_ORDERS'];
				}
			} else {
				echo '0';
			}
		}

		if($reporttype == 'TOTAL_DELIVERED_ORDERS'){

			$counting_order_DETAILS = sqlQUERY_LABEL("SELECT COUNT(ORDER_DETAILS.`od_id`) AS TOTAL_ORDERS FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` and `carrier_name` = '$filter_by_agent' and ORDER_DETAILS.`od_status` ='6' and  MONTH(ORDER_DETAILS.`od_date`) = '$choosenmonth' order by ORDER_DETAILS.`od_id` desc");
			
			if(sqlNUMOFROW_LABEL($counting_order_DETAILS)) {
				while($collect_order_DATA = sqlFETCHARRAY_LABEL($counting_order_DETAILS)) {
					echo $collect_order_DATA['TOTAL_ORDERS'];
				}
			} else {
				echo '0';
			}
		}
		
	}
	
	function CUSTOMERWISE_ORDER_DETAILS($selected_type_id,$requesttype) {

		if($requesttype == 'total_orders') {
			$list_customers_datas = sqlQUERY_LABEL("SELECT COUNT(*) as TOTAL_ORDERS FROM js_shop_order where od_userid = '$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());
				while($row = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $TOTAL_ORDERS = $row["TOTAL_ORDERS"];
				  return $TOTAL_ORDERS;
				}
		}

		if($requesttype == 'total_sales') {
			$list_customers_datas = sqlQUERY_LABEL("SELECT SUM(od_total) AS TOTAL_AMOUNT, SUM(od_discount_amount) AS TOTAL_DISCOUNT FROM js_shop_order where od_userid = '$selected_type_id' and deleted = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());
				while($row = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $TOTAL_AMOUNT = $row["TOTAL_AMOUNT"];
				  $TOTAL_DISCOUNT = $row["TOTAL_DISCOUNT"];
				  return ($TOTAL_AMOUNT - $TOTAL_DISCOUNT);
				}
		}
		
		
	}
	
	function getORDER_COUNT($selected_type_id, $requesttype) {
	
		if($requesttype == 'customers_name') {
		
			$list_customers_datas = sqlQUERY_LABEL("SELECT A.user_id, B.od_userid, A.customerfirst, COUNT(A.customerlast) FROM js_customer A, js_shop_order B WHERE A.user_id = '$selected_type_id' GROUP BY A.customerfirst ") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row = sqlFETCHARRAY_LABEL($list_customers_datas)){
				  $customers_name = $row["COUNT(A.customerlast)"];
				  return $customers_name;              
				}
		}
	}
	
	function customerTOTALSALES($customer_id, $request_type){
	if($request_type == 'customer_sales'){
		$list_datas_customer = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` where deleted = '0' and od_userid = '$customer_id'") or die("Unable to get records:".sqlERROR_LABEL());

		while($fetch_records = sqlFETCHARRAY_LABEL($list_datas_customer)){
			
			$od_total = $fetch_records['od_total'];
			$customer_total += $od_total;
		}
		return $customer_total;
	}
	
	if($request_type == 'customer_order'){
		$list_datas_customer = sqlQUERY_LABEL("SELECT count(*) as total_order FROM `js_shop_order` where deleted = '0' and od_userid = '$customer_id'") or die("Unable to get records:".sqlERROR_LABEL());

		$fetch_records = sqlFETCHARRAY_LABEL($list_datas_customer);
		$total_orders = $fetch_records['total_order'];
		
		return $total_orders;
	}
}

function getCUSTOMERSELECT($selected_type_id, $requesttype){
		
		if($requesttype == 'select'){
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_customer` where `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".sqlERROR_LABEL());
			?>
            <option value="">  Choose Customer </option>
			<?php
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$customerid = $fetch_data['customerID'];
				$customers_name = $fetch_data['customerfirst'];
				$customerphone = $fetch_data['customerphone'];
				$user_ID = getCUSTOMER_DATA($customerid, 'user_id');

			?>
           <option value="<?php echo $user_ID; ?>" <?php if($selected_type_id == $user_ID){ echo "selected"; } ?>><?php echo $customers_name.'-'.$customerphone; ?></option>
		<?php
		
            }	
			
		} //end of select
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'label'){
			$selected_query = sqlQUERY_LABEL("SELECT customers_name FROM `js_customers` where `deleted`= '0' and `customers_id` = '$selected_type_id'") or die("#CUSTOMGROUP-LABEL: Getting Custom Group: ".sqlERROR_LABEL());
			if(sqlNUMOFROW_LABEL($selected_query) > 0) {
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					return $fetch_data['customers_name'];
				}	
			} else {
				return '--';	
			}
			
		}
	
	}
	
	function getVERIFIED_EMAIL_MOBILE($selected_type_id,$requesttype) {

	if($requesttype == 'email') {
		$list_customers_datas = sqlQUERY_LABEL("SELECT email_verified FROM js_users WHERE userID = '$selected_type_id'") or die("#1-Unable to get records:".sqlERROR_LABEL());
		while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
			$email_verified = $row_cus["email_verified"];
			return $email_verified;
		}
	}
	if($requesttype == 'mobile_no') {
		$list_customers_datas = sqlQUERY_LABEL("SELECT mobileno_verified FROM js_users WHERE userID = '$selected_type_id'") or die("#1-Unable to get records:".sqlERROR_LABEL());
		while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
			$mobileno_verified = $row_cus["mobileno_verified"];
			return $mobileno_verified;
		}
	}
	if($requesttype == 'username') {
		$list_customers_datas = sqlQUERY_LABEL("SELECT username FROM js_users WHERE userID = '$selected_type_id'") or die("#1-Unable to get records:".sqlERROR_LABEL());
		while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
			$username = $row_cus["username"];
			return $username;
		}
	}
	if($requesttype == 'get_roleid') {
		$list_customers_datas = sqlQUERY_LABEL("SELECT roleID FROM js_users WHERE userID = '$selected_type_id'") or die("#1-Unable to get records:".sqlERROR_LABEL());
		while($row_cus = sqlFETCHARRAY_LABEL($list_customers_datas)){
			$roleID = $row_cus["roleID"];
			return $roleID;
		}
	}
}

function COUPON_WISE_DISCOUNT_SUMMARY($since_from, $since_to, $reporttype){

		if($since_from !='' && $since_to !=''){
			$filterby_date = " and DATE(od_date) between '$since_from' and '$since_to'";
		}
					
		$counting_order_DETAILS = sqlQUERY_LABEL("SELECT COUNT(od_discount_promo_ID) AS TOTAL_USED, od_discount_promo_ID, SUM(od_total) AS TOTAL_ORDER_AMT, SUM(od_discount_amount) AS TOTAL_DISCOUNT_AMT FROM `js_shop_order` where deleted = '0' and od_status NOT IN ('7','8') and status = '1' and od_payment_status IN('1', '3') and od_discount_promo_ID !='0' {$filterby_date} order by od_id desc");
		
		if(sqlNUMOFROW_LABEL($counting_order_DETAILS)) {
			while($collect_order_DATA = sqlFETCHARRAY_LABEL($counting_order_DETAILS)) {
				$TOTAL_USED_COUPON = $collect_order_DATA['TOTAL_USED'];
				$TOTAL_ORDER_AMT = $collect_order_DATA['TOTAL_ORDER_AMT'];
				$TOTAL_DISCOUNT_AMT = $collect_order_DATA['TOTAL_DISCOUNT_AMT'];
			}
		} else {
				$TOTAL_USED_COUPON = 0;
				$TOTAL_ORDER_AMT = 0;
				$TOTAL_DISCOUNT_AMT = 0;
		}
		if($reporttype == 'TOTAL_USED_COUPON'){
			return $TOTAL_USED_COUPON;
		} else if($reporttype == 'TOTAL_ORDER_AMT'){
			return $TOTAL_ORDER_AMT;
		} else if($reporttype == 'TOTAL_DISCOUNT_AMT'){
			return $TOTAL_DISCOUNT_AMT;
		} else if($reporttype == 'AFTER_DICOUNT'){
			return ($TOTAL_ORDER_AMT - $TOTAL_DISCOUNT_AMT);	
		}
	}
	
	function getPROMCODE_DETAILS($selected_type_id) {
	
		if($selected_type_id != '') {
		
			$list_product_name = sqlQUERY_LABEL("SELECT promocode_code,promocode_name FROM js_promocode WHERE promocode_id = $selected_type_id") or die("#1-Unable to get records:".sqlERROR_LABEL());

				while($row_cus = sqlFETCHARRAY_LABEL($list_product_name)){
				  $promocode_name = $row_cus["promocode_name"];
				  $promocode_code = $row_cus["promocode_code"];
				}
			return strtoupper($product_name.$promocode_code);              
		}
	}
	
	function getORDERREF_USING_ODID($od_id){
		//echo "SELECT od_refno FROM `js_shop_order` where `od_id`='$od_id' and status='1' and deleted = '0' ";
		$getrefno_query = sqlQUERY_LABEL("SELECT od_refno FROM `js_shop_order` where `od_id`='$od_id' and deleted = '0'") or die("#ORDREF-LABEL: Getting page_ID: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getrefno_query)) {
				 	$od_refno = $getstatus_fetch['od_refno'];
			 }
			 return $od_refno;
		
	}
	
	 	 //Tab Open Type 
	 function gettabtype($selected_status_id, $requesttype) {


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') { ?>

                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Same Window </option>

                 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > New Window </option>
				 

                 <?php

			 }
			 
		if($requesttype == 'label') {

                if($selected_status_id == '1') {  
                	
                    return "Same Window";
                }
                
                if($selected_status_id == '2') {
					
                    return  "New Window";
                }
				
			 }
	 }
	 
	  function getPARENTmenu_list($selected_type_id, $requesttype){ 
	 
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'select'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT menu_ID, menu_name FROM `js_menu` where `menu_parentID` = '0' and `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Menu: ".mysql_error());
			?> 
            <option onclick="showmenutype('0');" value="0">No Parent Menu</option>
			<?php
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$menu_ID = $fetch_data['menu_ID'];
				$menu_name = $fetch_data['menu_name'];
			?>
            <option onclick="showmenutype('<?php echo $menu_ID; ?>');" value="<?php echo $menu_ID; ?>" <?php if($selected_type_id == $menu_ID){ echo "selected"; } ?>><?php echo $menu_name; ?></option>
		<?php
            }	
			
		}
		
		/*****************  SELECT OPTION   *****************/	
		if($requesttype == 'label'){   

			$selected_query = sqlQUERY_LABEL("SELECT menu_name FROM `js_menu` where `menu_parentID` = '$selected_type_id'") or die("#PARENT-LABEL: Getting Parent Menu: ".mysql_error());
			if(sqlNUMOFROW_LABEL($selected_query) > 0) {
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
					return $fetch_data['menu_name'];
				}	
			} else {
				return '--';	
			}
			
		}
				
	 }
	 
	 function getMRPprice($product_id, $variant_id,$od_qty) {
		// echo $od_qty;exit();
		 //echo "SELECT variant_mrp_price FROM `js_productvariants` where `parentproduct` = '$product_id' and variant_ID = '$variant_id'";
		 if($variant_id) {
			// echo "SELECT variant_mrp_price FROM `js_productvariants` where `parentproduct` = '$product_id' and `variant_ID` = '$variant_id'";
		 $variant_select_MRP = sqlQUERY_LABEL("SELECT variant_mrp_price FROM `js_productvariants` where `parentproduct` = '$product_id' and `variant_ID` = '$variant_id'") or die("#PARENT-LABEL: Getting Variant MRP: ".mysql_error());
		 if(sqlNUMOFROW_LABEL($variant_select_MRP) > 0){
			 while($fetch_variant_data = sqlFETCHARRAY_LABEL($variant_select_MRP)) {
					$variant_MRP = $fetch_variant_data['variant_mrp_price'];
				
				return $variant_MRP * $od_qty;
				}
		 } } else {
		 $select_MRP = sqlQUERY_LABEL("SELECT productMRPprice FROM `js_product` where `productID` = '$product_id'") or die("#PARENT-LABEL: Getting Product MRP: ".mysql_error());
			if(sqlNUMOFROW_LABEL($select_MRP) > 0) {
				while($fetch_data = sqlFETCHARRAY_LABEL($select_MRP)) {
					$product_MRP = $fetch_data['productMRPprice'];
				}
				return $product_MRP;
			}
		 }
		 
	 }


   function ODAMOUNTREDUES($od_id){
	//   echo"SELECT SUM(od_price) as product_price,SUM(item_tax1),SUM(item_tax2) FROM `js_shop_order_item` where `od_id` = '$od_id' and `od_status_item` = '7'";exit();
	    $variant_select_MRP = sqlQUERY_LABEL("SELECT SUM(od_price) as product_price,SUM(item_tax1) as item_tax1 ,SUM(item_tax2) as item_tax2 FROM `js_shop_order_item` where `od_id` = '$od_id' and `od_status_item` = '7'") or die("#PARENT-LABEL: Getting Variant MRP: ".mysql_error());
		 if(sqlNUMOFROW_LABEL($variant_select_MRP) > 0){
			 while($fetch_variant_data = sqlFETCHARRAY_LABEL($variant_select_MRP)) {
					$product_price = $fetch_variant_data['product_price'];
					$item_tax1 = $fetch_variant_data['item_tax1'];
					$item_tax2 = $fetch_variant_data['item_tax2'];
				    $price_amout_redues=$product_price+$item_tax1+$item_tax2;
					//echo $price_amout_redues;
				return round($price_amout_redues);
              }
		 }
   }
   	function getOFFERS($selected_ID, $requesttype) {
		
 		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'select') {
			?>
			<option value='' > Select offer </option>
			<?php
			 $getstatus_query = sqlQUERY_LABEL("SELECT `offers_name`, `offers_id` FROM `js_offers` where `status`!='3' order by offers_id ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$offers_id = $getstatus_fetch['offers_id'];
					$offers_name = $getstatus_fetch['offers_name'];
				 ?>
				 <option value='<?php echo $offers_id; ?>' <?php if($selected_ID == $offers_id) { echo "selected"; } ?> >
					<?php echo $offers_name; ?>
				 </option>
				 <?php
			 }
		}
	
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `offers_name` FROM `js_offers` where `offers_id`='$selected_ID'") or die("#STATUS-LABEL: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$offers_name = $getstatus_fetch['offers_name'];
					return $offers_name;
			 }
		}

		if($requesttype == 'offer_qty') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `offer_qty` FROM `js_offers` where `offers_id`='$selected_ID'") or die("#STATUS-LABEL: Getting Status: ".sqlERROR_LABEL());
			 if(sqlNUMOFROW_LABEL($getstatus_query) > 0){
				while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$offer_qty = $getstatus_fetch['offer_qty'];
					return $offer_qty;
				}
			 } else {
				 return '0';
			 }
		}
		
		if($requesttype == 'offer_value') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `offer_value` FROM `js_offers` where `offers_id`='$selected_ID'") or die("#STATUS-LABEL: Getting Status: ".sqlERROR_LABEL());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$offer_value = $getstatus_fetch['offer_value'];
					return $offer_value;
			 }
		}
	}

function get_OFFER_ELIGIBILITY_ID($cart_added_qty, $PRDT_ID, $request_type){

	if($request_type == 'get_prdt_offer_type'){
		$get_offers_data = sqlQUERY_LABEL("SELECT OFFERS.`offers_type` FROM `js_offers` OFFERS LEFT JOIN `js_offers_items` OFFER_ITEMS  ON OFFER_ITEMS.`offers_id` = OFFERS.`offers_id` where OFFERS.`status` = '2' and OFFER_ITEMS.`prdt_id` = '$PRDT_ID' ORDER BY OFFERS.`offer_qty`") or die("#PARENT-LABEL: Getting OFFER ELIGIBILE ID: ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_offers_data) > 0){
			while($fetch_offers_data = sqlFETCHARRAY_LABEL($get_offers_data)) {
				$offers_type = $fetch_offers_data['offers_type'];
				return ($offers_type);
			}
		} else {
			return '0'; 
		}
	}
	
	if($request_type == 'get_auto_assign_offer_id_based_on_bulk_qty'){
		$get_offers_data = sqlQUERY_LABEL("SELECT OFFERS.`offers_id` FROM `js_offers` OFFERS LEFT JOIN `js_offers_items` OFFER_ITEMS  ON OFFER_ITEMS.`offers_id` = OFFERS.`offers_id` where OFFERS.`offer_qty` <= '$cart_added_qty' and OFFERS.`status` = '2' and OFFER_ITEMS.`prdt_id` = '$PRDT_ID' ORDER BY OFFERS.`offer_qty` DESC LIMIT 0,1") or die("#PARENT-LABEL: Getting OFFER ELIGIBILE ID: ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_offers_data) > 0){
			while($fetch_offers_data = sqlFETCHARRAY_LABEL($get_offers_data)) {
				$offers_id = $fetch_offers_data['offers_id'];
				return ($offers_id);
			}
		} else {
			return '0'; 
		}
	}	
	
	if($request_type == 'get_auto_assign_offer_type_based_on_bulk_qty'){
		$get_offers_data = sqlQUERY_LABEL("SELECT OFFERS.`offers_type` FROM `js_offers` OFFERS LEFT JOIN `js_offers_items` OFFER_ITEMS  ON OFFER_ITEMS.`offers_id` = OFFERS.`offers_id` where OFFERS.`offer_qty` <= '$cart_added_qty' and OFFERS.`status` = '2' and OFFER_ITEMS.`prdt_id` = '$PRDT_ID' ORDER BY OFFERS.`offer_qty` DESC LIMIT 0,1") or die("#PARENT-LABEL: Getting OFFER ELIGIBILE ID: ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_offers_data) > 0){
			while($fetch_offers_data = sqlFETCHARRAY_LABEL($get_offers_data)) {
				$offers_type = $fetch_offers_data['offers_type'];
				return ($offers_type);
			}
		} else {
			return '0'; 
		}
	}
	
	// if($request_type == 'get_offer_id'){
		// $get_offers_data = sqlQUERY_LABEL("SELECT OFFERS.`offers_id` FROM `js_offers` OFFERS LEFT JOIN `js_offers_items` OFFER_ITEMS  ON OFFER_ITEMS.`offers_id` = OFFERS.`offers_id` where OFFERS.`offer_qty` < '$cart_added_qty' and OFFERS.`status` = '2' and OFFER_ITEMS.`prdt_id` = '$PRDT_ID'") or die("#PARENT-LABEL: Getting OFFER ELIGIBILE ID: ".sqlERROR_LABEL());
		// if(sqlNUMOFROW_LABEL($get_offers_data) > 0){
			// while($fetch_offers_data = sqlFETCHARRAY_LABEL($get_offers_data)) {
				// $offers_id = $fetch_offers_data['offers_id'];
				// return ($offers_id);
			// }
		// } else {
			// return '0'; 
		// }
	// }	
	
	// if($request_type == 'get_offer_type'){
		// $get_offers_data = sqlQUERY_LABEL("SELECT OFFERS.`offers_type` FROM `js_offers` OFFERS LEFT JOIN `js_offers_items` OFFER_ITEMS  ON OFFER_ITEMS.`offers_id` = OFFERS.`offers_id` where OFFERS.`offer_qty` <= '$cart_added_qty' and OFFERS.`status` = '2' and OFFER_ITEMS.`prdt_id` = '$PRDT_ID'") or die("#PARENT-LABEL: Getting Variant MRP: ".sqlERROR_LABEL());
		// if(sqlNUMOFROW_LABEL($get_offers_data) > 0){
			// while($fetch_offers_data = sqlFETCHARRAY_LABEL($get_offers_data)) {
				// $offers_type = $fetch_offers_data['offers_type'];
				// return ($offers_type);
			// }
		// } else {
			// return '0'; 
		// }
	// }

	if($request_type == 'get_offer_qty'){
		$get_offers_data = sqlQUERY_LABEL("SELECT offer_value FROM js_offers where offers_id = '$cart_added_qty' and status = '2'") or die("#PARENT-LABEL: Getting Variant MRP: ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_offers_data) > 0){
			while($fetch_offers_data = sqlFETCHARRAY_LABEL($get_offers_data)) {
				$offer_value = $fetch_offers_data['offer_value'];
				return ($offer_value);
			}
		} else {
			return '0'; 
		}
	}

   }
 
   function get_OD_QTY_FROM_SESSION($prdt_id, $session_id, $variant_id, $request_type){

	if($request_type == 'get_total_cart_od_qty_without_bogo_offer_type'){
		$get_shop_order_item_data = sqlQUERY_LABEL("SELECT SUM(od_qty) AS TOTAL_ADDED_QTY FROM js_shop_order_item where pd_id = '$prdt_id' and od_session = '$session_id' and offer_type NOT IN ('0','1')") or die("#PARENT-LABEL: GETTING OFFER TYPE : ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_shop_order_item_data) > 0){
			while($fetch_shop_order_item_data = sqlFETCHARRAY_LABEL($get_shop_order_item_data)) {
				$TOTAL_ADDED_QTY = $fetch_shop_order_item_data['TOTAL_ADDED_QTY'];
				return ($TOTAL_ADDED_QTY);
			}
		} else {
			return '0'; 
		}
	}
	
	if($request_type == 'get_total_cart_od_qty_without_offer_qty'){
		$get_shop_order_item_data = sqlQUERY_LABEL("SELECT SUM(od_qty) AS TOTAL_ADDED_QTY FROM js_shop_order_item where pd_id = '$prdt_id' and od_session = '$session_id' and offer_id = '0' and offer_type = '0'") or die("#PARENT-LABEL: GETTING OFFER TYPE : ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_shop_order_item_data) > 0){
			while($fetch_shop_order_item_data = sqlFETCHARRAY_LABEL($get_shop_order_item_data)) {
				$TOTAL_ADDED_QTY = $fetch_shop_order_item_data['TOTAL_ADDED_QTY'];
				return ($TOTAL_ADDED_QTY);
			}
		} else {
			return '0'; 
		}
	}	
	
	if($request_type == 'get_total_cart_variant_od_qty_without_offer_qty'){
		$get_shop_order_item_data = sqlQUERY_LABEL("SELECT SUM(od_qty) AS TOTAL_ADDED_QTY FROM js_shop_order_item where pd_id = '$prdt_id' and od_session = '$session_id' and `variant_id` = '$variant_id' and offer_id = '0' and offer_type = '0'") or die("#PARENT-LABEL: GETTING OFFER TYPE : ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_shop_order_item_data) > 0){
			while($fetch_shop_order_item_data = sqlFETCHARRAY_LABEL($get_shop_order_item_data)) {
				$TOTAL_ADDED_QTY = $fetch_shop_order_item_data['TOTAL_ADDED_QTY'];
				return ($TOTAL_ADDED_QTY);
			}
		} else {
			return '0'; 
		}
	}

	if($request_type == 'get_total_cart_without_selected_variant_od_qty_without_offer_qty'){
		$get_shop_order_item_data = sqlQUERY_LABEL("SELECT SUM(od_qty) AS TOTAL_ADDED_QTY FROM js_shop_order_item where pd_id = '$prdt_id' and od_session = '$session_id' and `variant_id` != '$variant_id' and offer_id = '0' and offer_type = '0'") or die("#PARENT-LABEL: GETTING OFFER TYPE : ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_shop_order_item_data) > 0){
			while($fetch_shop_order_item_data = sqlFETCHARRAY_LABEL($get_shop_order_item_data)) {
				$TOTAL_ADDED_QTY = $fetch_shop_order_item_data['TOTAL_ADDED_QTY'];
				return ($TOTAL_ADDED_QTY);
			}
		} else {
			return '0'; 
		}
	}

	if($request_type == 'get_added_offer_product_offer_id'){
		$get_shop_order_item_data = sqlQUERY_LABEL("SELECT `offer_id` FROM js_shop_order_item where pd_id = '$prdt_id' and  od_session = '$session_id' and offer_id != '0' and offer_type != '0'") or die("#PARENT-LABEL: GETTING OFFER TYPE : ".sqlERROR_LABEL());
		if(sqlNUMOFROW_LABEL($get_shop_order_item_data) > 0){
			while($fetch_shop_order_item_data = sqlFETCHARRAY_LABEL($get_shop_order_item_data)) {
				$offer_id = $fetch_shop_order_item_data['offer_id'];
				return ($offer_id);
			}
		} else {
			return '0'; 
		}
	}

   }
   
?>