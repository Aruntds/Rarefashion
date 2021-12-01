<?php


	function getSTATUS($selected_status_id, $requesttype) {


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') { ?>

                 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Active </option>

                 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > Inactive </option>

                 <?php

			 }
			 
			 
		/*****************  LABEL OPTION   *****************/	

		if($requesttype == 'label') {

                if($selected_status_id == '1') {
                    return  'Active';
                }
                
                if($selected_status_id == '2') {
                    return  'Inactive';
                }


			 }
			 

	}

	/*****************  Get SALUTION Type function *****************/	

	function getSALUTION($selected_type_id, $requesttype){


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {  ?>


			<option value="" <?php if($selected_type_id == ''){ echo "selected"; } ?>> --None-- </option>
            
            <option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>> Mr. </option>

            <option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>> Mrs. </option>

            <option value="3" <?php if($selected_type_id == '3'){ echo "selected"; } ?>> Miss. </option>

	<?php
	
		}
		
		if($requesttype == 'label'){  
					
			if($selected_type_id == '1') {
				return  'Mr.';
			}
			if($selected_type_id == '2') {
				return  'Mrs.';
			}
			if($selected_type_id == '3') {
				return  'Miss.';
			}
				
		}

	}
	
	/*****************  End of SALUTION Type function *****************/	
	
	
	/*****************  Get GENDER Type function *****************/	

	function getGENDER($selected_type_id, $requesttype){


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {  ?>


			<option value="" <?php if($selected_type_id == ''){ echo "selected"; } ?>> --None-- </option>
            
            <option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>> Male </option>

            <option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>> Female </option>

            <option value="3" <?php if($selected_type_id == '3'){ echo "selected"; } ?>> Others </option>

	<?php
	
		}
		
			if($requesttype == 'label'){  
		
			
			if($selected_type_id == '1') {
				return  'Male';
			}
			if($selected_type_id == '2') {
				return  'Female';
			}
			if($selected_type_id == '3') {
				return  'Others';
			}
				
		}
	}
	
	/*****************  End of GENDER Type function *****************/	
	
	
	/*****************  Get Marital Status function *****************/	

	function getMARITAL($selected_type_id, $requesttype){

	

		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {  ?>


			<option value="" <?php if($selected_type_id == ''){ echo "selected"; } ?>> --None-- </option>
            
            <option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>> Single </option>

            <option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>> Married </option>

		<?php
	
		}
		
		if($requesttype == 'label'){  
		
			
			if($selected_type_id == '1') {
				return  'Single';
			}
			if($selected_type_id == '2') {
				return  'Married';
			}
							
		}

	}
	
	/*****************  End of Marital Status function *****************/	
	
	
	
	/*****************  Get Category function *****************/	
	
	function getCategoryType($selected_type_id, $requesttype){
		
		
		/*****************  SELECT OPTION   *****************/	
			
		if($requesttype == 'select'){   ?>
			
			<option value="">--None--</option>
			<option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>>RTW</option>
			<option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>>MTO</option>
			
			<?php
				
		}
		
		
		/*****************  LABEL OPTION   *****************/	
			
		if($requesttype == 'label'){  
		
			if($selected_type_id == '1') {
				return  'RTW';
			}
			
			if($selected_type_id == '2') {
				return  'MTO';
			}
			if($selected_type_id == '3') {
				return  'STITCH';
			}
			if($selected_type_id == '4') {
				return  'ALT';
			}
			if($selected_type_id == '5') {
				return  'OTHERS';
			}
				
		}
		
		
	}

	/*****************  End of Get Category function *****************/	


	/*****************  Get Parent Category function *****************/	

	 function getPARENTCategory($selected_type_id, $requesttype){ 
	 
	 
		/*****************  SELECT OPTION   *****************/	
		
		if($requesttype == 'select'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_productcategory` where `categoryparentID` = '0' and `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			?> 
            <option value="">  Choose Parent Category  </option>  
            
			<?php
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
				$categorytitle = $fetch_data['categorytitle'];   
				
			?>
            
            <option value="<?php echo $categoryID; ?>" <?php if($selected_type_id == $categoryID){ echo "selected"; } ?>><?php echo $categorytitle; ?></option>
            
		<?php
		
            }	
			
		}
		
		
		
		/*****************  SELECT OPTION   *****************/	
		
		if($requesttype == 'RTW_main'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_productcategory` where `categoryparentID` = '0' and `deleted` = '0' and `status` = '1' and `categorytype`='1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			?> 
            <option value="">  Choose Main Category  </option>  
            
			<?php
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
				$categorytitle = $fetch_data['categorytitle'];   
				
			?>
            
            <option value="<?php echo $categoryID; ?>" <?php if($selected_type_id == $categoryID){ echo "selected"; } ?>><?php echo $categorytitle; ?></option>
            
		<?php
		
            }	
			
		}
		
		
		/*****************  SELECT OPTION   *****************/	
		
		if($requesttype == 'MTO_main'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_productcategory` where `categoryparentID` = '0' and `deleted` = '0' and `status` = '1' and `categorytype`='2'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			?> 
            <option value="">  Choose Main Category  </option>  
            
			<?php
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
				$categorytitle = $fetch_data['categorytitle'];   
				
			?>
            
            <option value="<?php echo $categoryID; ?>" <?php if($selected_type_id == $categoryID){ echo "selected"; } ?>><?php echo $categorytitle; ?></option>
            
		<?php
		
            }	
			
		}
		
		
		
		/*****************  Label  *****************/
			
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_productcategory` where `categoryID` = '$selected_type_id' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
				$categorytitle = $fetch_data['categorytitle'];   
				
			}
			
		return $categorytitle;	
				
		}
		
	}
	
	/*****************  End of Parent Category function *****************/
	
	
	/*****************  Get Category Type ID function *****************/
	
	 function getPARENTCategoryTYPEID($selected_type_id, $requesttype){ 
	
		/*****************  Label  *****************/	
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_productcategory` where `categoryID` = '$selected_type_id' and `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
				$categorytype = $fetch_data['categorytype'];   
				
			}
			
	return $categorytype;	
				
		}
	
	}
	
	/*****************  End of Get Category Type ID function *****************/	
	/*****************  Get Parenet and sub Category*****************/			
	function chooseCategorylist($categoryID,$type) {
	
		if($type != ''){
		$filter_type = "and categorytype = '$type'";
		}
		echo '<option value="">--None--</option>';
		$maincategorylist = mysql_query("SELECT `categoryID`, `categorytitle`, `categoryparentID` FROM js_productcategory WHERE deleted = '0' and status = '1' {$filter_type}") or die("Unable to get Category: ".mysql_error());
		while($main_categorylist = mysql_fetch_array($maincategorylist)) {
			$getcategory_id = $main_categorylist['categoryID'];
			$getcategory_title = $main_categorylist['categorytitle'];
			$getparentcategory_id = $main_categorylist['categoryparentID'];

				//get main category
				if($getparentcategory_id == 0) {	?>				
					<option value='<?php echo $getcategory_id?>' <?php if($categoryID == $getcategory_id){ echo "selected"; } ?> ><?php echo $getcategory_title?></option>;
			<?php }
				
				$parent_categorylist = mysql_query("SELECT `categoryID`, `categorytitle`, `categoryparentID` FROM js_productcategory WHERE categoryparentID=$getcategory_id and deleted = '0' and status = '1' {$filter_type} order by categoryorder ASC") or die("Unable to get Category: ".mysql_error());
				$count_parentcategory = mysql_num_rows($parent_categorylist);
				
				//find parentid
					while($parentsub_categorylist = mysql_fetch_array($parent_categorylist)) {
						$getcategory_id = $parentsub_categorylist['categoryID'];
						$getparentcategory_id = $parentsub_categorylist['categoryID'];
						$getparentcategory_title = $parentsub_categorylist['categorytitle']; ?>
							<option value='<?php echo $getparentcategory_id?>' <?php if($categoryID == $getcategory_id){ echo "selected"; } ?> >&nbsp;--&nbsp;<?php echo $getcategory_title?></option>;		
				<?php	}
				
		}
	}
	
	/*****************  End of Get Parenet and sub Category *****************/	
	/*****************  Get UOM *****************/	
	
	function getUOM($selected_type_id, $requesttype){
		if($requesttype == 'select'){   ?>
			
			<option value="">--</option>
			<option value="1" <?php if($selected_type_id == 1){ echo "selected"; } ?>>m</option>
			<option value="2" <?php if($selected_type_id == 2){ echo "selected"; } ?>>Pcs</option>
			
			<?php
				
		}
		
		if($requesttype == 'label'){  
		
			if($selected_type_id == '1') {
				return  ' m';
			}
			
			if($selected_type_id == '2') {
				return  ' Pcs';
			}
				
		}
		
	}

	/*****************  End of UOM function *****************/	
	
	/*****************  Get Verified By *****************/	
	
	function getVerifiedBy($selected_type_id, $requesttype){
		if($requesttype == 'select'){   ?>
			
			<option value="">--</option>
			<option value="1" <?php if($selected_type_id == 1){ echo "selected"; } ?>>Ram</option>
			<option value="2" <?php if($selected_type_id == 2){ echo "selected"; } ?>>Raju</option>
			
			<?php
				
		}
		
		if($requesttype == 'label'){  
		
			if($selected_type_id == '1') {
				return  'Ram';
			}
			
			if($selected_type_id == '2') {
				return  'Raju';
			}
				
		}
		
	}

	/*****************  End of verified by *****************/
	
	
	/*****************  Get status *****************/	
	
	function getActiveStatus($selected_type_id, $requesttype){
		if($requesttype == 'select'){   ?>
			
			<option value="1" <?php if($selected_type_id == 1){ echo "selected"; } ?>>Active</option>
			<option value="2" <?php if($selected_type_id == 2){ echo "selected"; } ?>>Inactive</option>
			
			<?php
				
		}
		
		if($requesttype == 'label'){  
		
			if($selected_type_id == '1') {
				return  'Active';
			}
			
			if($selected_type_id == '2') {
				return  'InActive';
			}
				
		}
		
	}

	/*****************  End of status *****************/
	/*****************  Get Size*****************/	
	
	function getSIZE($selected_type_id, $requesttype){
		
		
		/*****************  SELECT OPTION   *****************/	
		
		if($requesttype == 'select'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_size` where `deleted` = '0' and `deleted` = '0' and `status` = '1'") or die("#SIZE-LABEL: Getting Size: ".mysql_error());
			
			?> 
            <option value="">  --None--  </option>  
            
			<?php
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$sizeID = $fetch_data['sizeID'];
				
				$sizetitle = $fetch_data['sizetitle'];   
				
			?>
            
            <option value="<?php echo $sizeID; ?>" <?php if($selected_type_id == $sizeID){ echo "selected"; } ?>><?php echo $sizetitle; ?></option>
            
		<?php
		
            }	
			
		}
		
		/*****************  label OPTION   *****************/	
			
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_size` where `sizeID` = '$selected_type_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$sizetitle = $fetch_data['sizetitle'];
				
				
			}
			
	return $sizetitle;	
				
		}
		
	}

/*****************  Get MTO stock code *****************/
	
	 function getMTOmasterstockcode($selected_id, $requesttype){ 
	
		/*****************  Label  *****************/	
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_mtomasterstock` where `mmsID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$mmscode = $fetch_data['mmscode'];
				
				
			}
			
	return $mmscode;	
				
		}
	
	}
	
	/*****************  End of MTO stock code *****************/	

	/*****************  Get RTW stock code *****************/
	
	 function getRTWmasterstockcode($selected_id, $requesttype){ 
	
		/*****************  Label  *****************/	
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_rtwmasterstock` where `rmsID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$rmscode = $fetch_data['rmscode'];
				
				
			}
			
	return $rmscode;	
				
		}
	
	}
	
	/*****************  End of MTO stock code *****************/
	
	/*****************  Get Parent Category function *****************/	

	 function getPARENTbyCategoryTYPE($selected_type_id, $selected_categorytype, $requesttype){ 
	 
	 
		/*****************  SELECT OPTION   *****************/	
		
		if($requesttype == 'select'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_productcategory` where `categoryparentID` = '0' and `deleted` = '0' and `status` = '1' and `categorytype`='$selected_categorytype'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			?> 
            <option value="">  --None--  </option>  
            
			<?php
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
				$categorytitle = $fetch_data['categorytitle'];   
				
			?>
            
            <option value="<?php echo $categoryID; ?>" <?php if($selected_type_id == $categoryID){ echo "selected"; } ?>><?php echo $categorytitle; ?></option>
            
		<?php
		
            }	
			
		}
		
		
		/*****************  Label  *****************/
			
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_productcategory` where `categoryID` = '$selected_type_id' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
				$categorytitle = $fetch_data['categorytitle'];   
				
			}
			
		return $categorytitle;	
				
		}
		
	}
	
	/*****************  End of Parent Category function *****************/
	
		
	/*****************  Get MTO Stock Card Code by ID *****************/
	
	 function getMTOStockCardCode($selected_type_id, $requesttype){ 
	 
		/*****************  Label  *****************/
			
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_mtostockcard` where `mscID` = '$selected_type_id' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$mscID = $fetch_data['mscID'];
				
				$msccode = $fetch_data['msccode'];   
				
			}
			
		return $msccode;	
				
		}
		
	}
	 
	
	/*****************  End of MTO Stock Card Code by ID *****************/
	
	
	/*****************  Get Custom function *****************/	
	
	function getCUSTOMType($selected_type_id, $requesttype){
		
		
		/*****************  SELECT OPTION   *****************/	
			
		if($requesttype == 'select'){   ?>
        
			<option value="" <?php if($selected_type_id == ''){ echo "selected"; } ?>>--None--</option>
			<option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>>Stitching</option>
			<option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>>Alteration</option>
			
			<?php
				
		}
		
		
		/*****************  LABEL OPTION   *****************/	
			
		if($requesttype == 'label'){  
		
			if($selected_type_id == '1') {
				return  'Stitching';
			}
			
			if($selected_type_id == '2') {
				return  'Alteration';
			}
				
		}
		
		
	}

	/*****************  End of Get Category function *****************/	
	
	
	/*****************  Get the reason for take and return stock function *****************/	
	
	function getTAKERETURNReason($selected_type_id, $requesttype){
		
		
		/*****************  SELECT OPTION   *****************/	
			
		if($requesttype == 'Take'){   ?>
        
			<option value="" <?php if($selected_type_id == ''){ echo "selected"; } ?>>--None--</option>
			<option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>>For Workshop</option>
			<option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>>For Order</option>
			<option value="3" <?php if($selected_type_id == '3'){ echo "selected"; } ?>>For Customer</option>
			<option value="4" <?php if($selected_type_id == '4'){ echo "selected"; } ?>>Others</option>
			<?php
				
		}
		
		
		if($requesttype == 'Return'){   ?>
        
			<option value="" <?php if($selected_type_id == ''){ echo "selected"; } ?>>--None--</option>
			<option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>>From Workshop</option>
			<option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>>Others</option>
			<?php
				
		}
		
		
		/*****************  LABEL OPTION   *****************/	
			
		if($requesttype == 'label'){  
		
			if($selected_type_id == '1') {
				return  'Stitching';
			}
			
			if($selected_type_id == '2') {
				return  'Alteration';
			}
				
		}
		
		
	}

	/*****************  End of Get the reason for take and return stock function *****************/	
	
	
	/*****************  Get Style Category function *****************/	

	 function getSTYLECategory($selected_type_id, $requesttype){ 
	 
	 
		/*****************  SELECT OPTION   *****************/	
		
		if($requesttype == 'select'){   
        
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_stylecategory` where `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$stylecatID = $fetch_data['stylecatID'];
				
				$stylecat_title = $fetch_data['stylecat_title'];   
				
			?>
            
            <option value="<?php echo $stylecatID; ?>" <?php if($selected_type_id == $stylecatID){ echo "selected"; } ?>><?php echo $stylecat_title; ?></option>
            
		<?php
		
            }	
			
		}
		
		
		/*****************  Label  *****************/
			
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_stylecategory` where `stylecatID` = '$selected_type_id' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$stylecatID = $fetch_data['stylecatID'];
				
				$stylecat_title = $fetch_data['stylecat_title'];   
				
			}
			
		return $stylecat_title;	
				
		}
		
	}
	
	/*****************  End of Style Category function *****************/
	
	
	/*****************  Get Custom function *****************/	
	
	function getSTAFFType($selected_type_id, $requesttype){
		
		
		/*****************  SELECT OPTION   *****************/	
			
		if($requesttype == 'select'){   ?>
        
			<option value="" <?php if($selected_type_id == ''){ echo "selected"; } ?>>--None--</option>
			<option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>>Warehouse</option>
			<option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>>Outlet </option>
			<option value="3" <?php if($selected_type_id == '3'){ echo "selected"; } ?>>Workshop</option>
			
			<?php
				
		}
		
		
		/*****************  LABEL OPTION   *****************/	
			
		if($requesttype == 'label'){  
		
			if($selected_type_id == '1') {
				return  'Warehouse';
			}
			
			if($selected_type_id == '2') {
				return  'Outlet';
			}
				
			if($selected_type_id == '3') {
				return  'workshop';
			}
				
		}
		
		
	}

	/*****************  End of Get Category function *****************/	
	
	/*****************  Get BalanceMTO_masterstock *****************/
	
	 function getBalanceMTO_masterstock($selected_id){ 
	
		/*****************  Label  *****************/	
		
			$selected_MTO_query = sqlQUERY_LABEL("SELECT * FROM `js_mtomasterstock` where `mmsID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_query)) {
			
				$mmsunits = $fetch_data['mmsunits'];
			}
			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(mscoqty * mscunits) as total FROM `js_mtostockcard` where `mmsID` = '$selected_id' and deleted ='0' and status = '1' group by mmsID") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$mscunits = $fetch_data['total'];
			}
			$balance =  $mmsunits - $mscunits;
	return $balance;	
	
	}
	
	/*****************  End of BalanceMTO_masterstock*****************/	
	
	
	
	/*****************  Get MTO_masterstock *****************/
	
	 function getMTO_masterstock_card($selected_id, $requesttype){ 
	 
	
		if($requesttype == 'opening_qty'){   

			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(mscoqty) as total FROM `js_mtostockcard` where `mmsID` = '$selected_id' and deleted ='0' and status = '1' group by mmsID") or die("#PARENT-LABEL: Getting Master Stock Card: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$mscopeningunits = $fetch_data['total'];
			}
			
	return $mscopeningunits;	
	
		}
		
		if($requesttype == 'available_qty'){   
	
			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(mscaqty) as total FROM `js_mtostockcard` where `mmsID` = '$selected_id' and deleted ='0' and status = '1' group by mmsID") or die("#PARENT-LABEL: Getting Master Stock Card: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$mscopeningunits = $fetch_data['total'];
			}
			
	return $mscopeningunits;	
	
	}

}
	
	/*****************  End of MTO_masterstock*****************/	
	
	

/*****************  Get BalanceMTO_masterstock *****************/
	
	 function getBalanceRTW_masterstock($selected_id){ 
	
		/*****************  Label  *****************/	
		
			$selected_RTW_query = sqlQUERY_LABEL("SELECT * FROM `js_rtwmasterstock` where `rmsID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_RTW_query)) {
			
				$rmsunits = $fetch_data['rmsunits'];
			}
			$selected_rtw_cardquery = sqlQUERY_LABEL("SELECT sum(rscoqty) as total FROM `js_rtwstockcard` where `rmsID` = '$selected_id' and deleted ='0' and status = '1' group by rmsID") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_rtw_cardquery)) {
			
				$rscunits = $fetch_data['total'];
			}
			$balance =  $rmsunits - $rscunits;
	return $balance;	
	
	}
	
	/*****************  End of BalanceMTO_masterstock*****************/	
	
/*****************  Get Opening RTW stock card quantity *****************/
	
	 function getOpenRTW_qty($selected_id,$type){ 
	
		/*****************  Label  *****************/	
		if($type == 'rscoqty'){
			$selected_rtw_cardquery = sqlQUERY_LABEL("SELECT rscoqty  FROM `js_rtwstockcard` where `rscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_rtw_cardquery)) {
			
				$rscoqty = $fetch_data['rscoqty'];
			}
	return $rscoqty;	
	
	}
	
	if($type == 'rscaqty'){
			$selected_rtw_cardquery = sqlQUERY_LABEL("SELECT rscaqty  FROM `js_rtwstockcard` where `rscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_rtw_cardquery)) {
			
				$rscaqty = $fetch_data['rscaqty'];
			}
	return $rscaqty;	
	
	}
}
	
	/*****************  End of BalanceMTO_masterstock*****************/	

	/*****************  Get MTO Stock Card Code by ID *****************/
	
	 function getRTWStockCardCode($selected_type_id, $requesttype){ 
	 
		/*****************  Label  *****************/
			
		if($requesttype == 'label') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_rtwstockcard` where `rscID` = '$selected_type_id' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$rscID = $fetch_data['rscID'];
				
				$rsccode = $fetch_data['rsccode'];   
				
			}
			
		return $rsccode;	
				
		}
		
	}
	 
	
	/*****************  End of MTO Stock Card Code by ID *****************/

	/*****************  Get Category details by code function *****************/
	
	function getCATEGORYDetails($selected_type_id, $selected_type_code, $requesttype){
	
	
		/*****************  Category ID  *****************/
			
		if($requesttype == 'Category_id') {
		
			$selected_query = sqlQUERY_LABEL("SELECT * FROM `js_productcategory` where `categorycode` = '$selected_type_code' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
			}
		return $categoryID;	
		}
		
	}

	/***************** End of Get Category details by code function *****************/


	/*****************  Get MTO Stock card details*****************/
	
	 function getMTO_stockcard($selected_id,$type){ 
	
		/*****************  Label  *****************/	
		if($type == 'units'){
			$selected_mto_cardquery = sqlQUERY_LABEL("SELECT mscunits FROM `js_mtostockcard` where `mscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_mto_cardquery)) {
			
				$mscunits = $fetch_data['mscunits'];
			}
	return $mscunits;	
	
	}
	
	if($type == 'mscoqty'){
			$selected_rtw_cardquery = sqlQUERY_LABEL("SELECT mscoqty  FROM `js_mtostockcard` where `mscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_rtw_cardquery)) {
			
				$mscoqty = $fetch_data['mscoqty'];
			}
	return $mscoqty;	
	
	}
	
	if($type == 'mscaqty'){
			$selected_rtw_cardquery = sqlQUERY_LABEL("SELECT mscaqty  FROM `js_mtostockcard` where `mscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_rtw_cardquery)) {
			
				$mscaqty = $fetch_data['mscaqty'];
			}
	return $mscaqty;	
	
	}
	
	
}
	
	/*****************  End of MTO Stock card details*****************/
	
	
	/***************** Check stock card units and rtw size*****************/
	
	 function checkunits_stockcard($selected_id,$selected_units,$type){ 
	
		/*****************  Label  *****************/	
		if($type == 'mto'){
			$selected_mto_cardquery = sqlQUERY_LABEL("SELECT `mscunits` FROM js_mtostockcard WHERE mmsID = '$selected_id' and mscunits = '$selected_units' and deleted='0' and status='1'") or die("stock card units and rtw size".mysql_error());
			$no_rows = sqlNUMOFROW_LABEL($selected_mto_cardquery);
	
		}
	
	if($type == 'rtw'){
			$selected_rtw_cardquery = sqlQUERY_LABEL("SELECT `sizeID` FROM js_rtwstockcard WHERE sizeID = '$selected_units' and rmsID='$selected_id' and deleted = '0' and status = '1'") or die("stock card units and rtw size".mysql_error());
			$no_rows = sqlNUMOFROW_LABEL($selected_rtw_cardquery);
	
		}
		return $no_rows;	

	}
	
	
	
	/*****************  Get Outlet Records *****************/
	 function getOutletrecords($selected_type_id, $requesttype){ 
	 
		/*****************  Label  *****************/
		if($requesttype == 'name-code' || $requesttype == 'code') {
			
			$selected_query = sqlQUERY_LABEL("SELECT outletname, outletcode FROM `js_outlet` where `outletID` = '$selected_type_id' and `deleted` = '0'") or die("#OUTLET: Getting outlet Title: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$outletname = $fetch_data['outletname'];   
				$outletcode = $fetch_data['outletcode'];   
			}
			
			if($requesttype == 'code') {
				return $outletcode;
			} else {
				return $outletname.'( '.$outletcode.' )';
			}
			
		}
		
		/*****************  List  *****************/
		if($requesttype == 'select-list') {
			$selected_query = sqlQUERY_LABEL("SELECT outletID, outletname, outletcode FROM `js_outlet` where `status`='1' and `deleted` = '0'") or die("#OUTLET SELECT LIST: Getting outlet Select List: ".mysql_error());
			?> 
            <option value="">  --None--  </option>  
			<?php
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
				$outletID = $fetch_data['outletID'];   
				$outletname = $fetch_data['outletname'];   
				$outletcode = $fetch_data['outletcode'];
			?>
            <option value="<?php echo $outletID; ?>" <?php if($selected_type_id == $outletID){ echo "selected"; } ?>><?php echo $outletname; ?></option>
			<?php
            }
		return $outletname.'( '.$outletcode.' )';
		}
		
	}	
	/*****************  End of Outlet Records *****************/

	/****************** get Stock Order - detail ****************/
	function getnewSTOCKORDERCOUNT($mtosono, $outletID, $type) {
		
		if($type == '2') {
			$type = 'MTO';	
		} else {
			$type = 'RTW';
		}
		
		if($type == 'MTO') {
			if($mtosono == '') {
				$collectSO_Count = sqlQUERY_LABEL("SELECT mtosono FROM `js_mtostockorder` where outletID='$outletID' order by mtosono DESC limit 0,1") or die("Unable to get Stock Order REF NO: ".mysql_error());
				
				if(mysql_num_rows($collectSO_Count) > 0 ) {
					while($collectSO_id = sqlFETCHARRAY_LABEL($collectSO_Count)) {
						$mtosono_detail = $collectSO_id['mtosono'];
					}
					$mtosono_detail++;
				} else {
					$outletcode = getOutletrecords($outletID, 'code');
					$mtosono_detail = 'SO-'.$outletcode.''.$type.'-11000';
				}
			} else {
	
				$collectSO_Count = sqlQUERY_LABEL("SELECT mtosono FROM `js_mtostockorder` where mtosono = '$mtosono' and outletID='$outletID'") or die("Unable to get Stock Order REF NO: ".mysql_error());
				while($collectSO_id = sqlFETCHARRAY_LABEL($collectSO_Count)) {
					$mtosono_detail = $collectSO_id['mtosono'];
				}
			}
		return $mtosono_detail;
	}else{
	
			if($rtwsono == '') {
				$collectSO_Count = sqlQUERY_LABEL("SELECT rtwsono FROM `js_rtwstockorder` where outletID='$outletID' order by rtwsono DESC limit 0,1") or die("Unable to get Stock Order REF NO: ".mysql_error());
				
				if(mysql_num_rows($collectSO_Count) > 0 ) {
					while($collectSO_id = sqlFETCHARRAY_LABEL($collectSO_Count)) {
						$rtwsono_detail = $collectSO_id['rtwsono'];
					}
					$rtwsono_detail++;
				} else {
					$outletcode = getOutletrecords($outletID, 'code');
					$rtwsono_detail = 'SO-'.$outletcode.''.$type.'-11000';
				}
			} else {
	
				$collectSO_Count = sqlQUERY_LABEL("SELECT rtwsono FROM `js_rtwstockorder` where rtwsono = '$rtwsono' and outletID='$outletID'") or die("Unable to get Stock Order REF NO: ".mysql_error());
				while($collectSO_id = sqlFETCHARRAY_LABEL($collectSO_Count)) {
					$rtwsono_detail = $collectSO_id['rtwsono'];
				}
			}
		return $rtwsono_detail;
	
		
	}	
	
}
	/****************** end of Stock Order - detail ****************/
//warehouse staff type = 1,outlet staff type = 2,workshop staff type = 3
	/****************** get Common Status - detail ****************/
	function getSTAFFLIST($staff_type, $staff_id, $requesttype) {
		
		//filter by
		if($staff_type != '') { $filterbystaff_type = " `stafftype`='$staff_type' and ";	 }
		
		if($staff_id != '' && $staff_id != '0') { $filterbystaff_id = " `staffID`='$staff_id' and";	}
		
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'select') {

			 $getstatus_query = mysql_query("SELECT `staffID`, `staffname` FROM `js_staff` where {$filterbystaff_type} {$filterbystaff_id} `deleted`='0' order by staffname ASC") or die("#STATUS-SELECT: Getting Status: ".mysql_error());
			 
			 echo '<option value="">  --None--  </option>';
			 
			 while($getstatus_fetch = mysql_fetch_array($getstatus_query)) {
				 	$staffID = $getstatus_fetch['staffID'];
				 	$staffname = $getstatus_fetch['staffname'];
				 ?>
                 <option value='<?php echo $staffID; ?>' <?php if($staff_id==$staffID) { echo "selected"; } ?> >
				 	<?php echo $staffname; ?>
                 </option>
                 <?php
			 }
			 
		}

		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = mysql_query("SELECT `staffname` FROM `js_staff` where `staffID`='$staff_id'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 while($getstatus_fetch = mysql_fetch_array($getstatus_query)) {
				 	$staffname = $getstatus_fetch['staffname'];
					return $staffname;
			 }
		}
		
	}	
	/****************** end of Common Status - detail ****************/
	
	/****************** get Common Status - detail ****************/
	function getCOMMONSTATUS($selected_status_type, $selected_status_id, $requesttype) {
		
		//`status_type`, `status_id`, `status_title` FROM `oc_Status`
		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'select') {
			 $getstatus_query = mysql_query("SELECT `status_id`, `status_title` FROM `js_status` where `status_type`='$selected_status_type' order by status_id ASC") or die("#STATUS-SELECT: Getting Status: ".mysql_error());
			 while($getstatus_fetch = mysql_fetch_array($getstatus_query)) {
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
			 $getstatus_query = mysql_query("SELECT `status_title` FROM `js_status` where `status_id`='$selected_status_id' and `status_type`='$selected_status_type'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 while($getstatus_fetch = mysql_fetch_array($getstatus_query)) {
				 	$status_title = $getstatus_fetch['status_title'];
					return $status_title;
			 }
		}
		
	}	
	/****************** end of Common Status - detail ****************/

/*****************  Get category ID for MTO and RTW*****************/
	
	 function getSTOCK_category($selected_type_id, $requesttype){ 
	 
		/*****************  Label  *****************/
			
		if($requesttype == 'rtw') {
		
			$selected_query = sqlQUERY_LABEL("SELECT categoryID FROM `js_rtwstockcard` where `rscID` = '$selected_type_id' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
			}
			
				
		}
		
	/*****************  End of category ID for MTO and RTW *****************/
		if($requesttype == 'mto') {
		
			$selected_query = sqlQUERY_LABEL("SELECT categoryID FROM `js_mtostockcard` where `mscID` = '$selected_type_id' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryID = $fetch_data['categoryID'];
				
			}
		}
		return $categoryID;	
	}
	 
	
	/*****************  End of category ID for MTO and RTW *****************/
	
	
	
	/****************** get Common Status - detail ****************/
	function getCUSTOMER($customer_id, $requesttype) {
		

		/*****************  LABLE OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `cusfirstname`, `cuslastname` FROM `js_customer` where `cusID`='$customer_id'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 if(sqlNUMOFROW_LABEL($getstatus_query) > 0){
				 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$cusname = $getstatus_fetch['cusfirstname'].' '.$getstatus_fetch['cuslastname'];
						
				 }
			 
			 return $cusname;
			 }
			 else {
			  return '--';
			 }
		}
		
		if($requesttype == 'customercode') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `cuscode` FROM `js_customer` where `cusID`='$customer_id'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 if(sqlNUMOFROW_LABEL($getstatus_query) > 0){
				 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
						$cuscode = $getstatus_fetch['cuscode'];
						
				 }
			 
			 return $cuscode;
			 }
			 else {
			  return '--';
			 }
		}
		
		if($requesttype == 'cuscode') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `cusfirstname`, `cuslastname` FROM `js_customer` where `cuscode`='$customer_id'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 if(sqlNUMOFROW_LABEL($getstatus_query) > 0){
				 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$cusname = $getstatus_fetch['cusfirstname'].' '.$getstatus_fetch['cuslastname'];
						
				 }
			 
			 return $cusname;
			 }
			 else {
			  return '--';
			 }
		}

		if($requesttype == 'claimedcustomer_label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT cusID, cusfirstname, cusmobile FROM `js_customer` where `cusID`='$customer_id'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 if(sqlNUMOFROW_LABEL($getstatus_query) > 0){
				 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
					$customername = $getstatus_fetch['cusfirstname'];
					$customertelephone = $getstatus_fetch['cusmobile'];
				 }
			 
				 return $customername .'-'. $customertelephone;
			 }
			 else {
				  return '--';
			 }
		}

		if($requesttype == 'mobile') {
			$getstatus_query = sqlQUERY_LABEL("SELECT cusID, cusmobile FROM `js_customer` where `cusID`='$customer_id'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			if(sqlNUMOFROW_LABEL($getstatus_query) > 0){
				while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				   $customertelephone = $getstatus_fetch['cusmobile'];
				}
			
				return $customertelephone;
			}
			else {
				 return '--';
			}
	   }

	   if($requesttype == 'email') {
		$getstatus_query = sqlQUERY_LABEL("SELECT cusID, cusemail FROM `js_customer` where `cusID`='$customer_id'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
		if(sqlNUMOFROW_LABEL($getstatus_query) > 0){
			while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
			   $customeremail = $getstatus_fetch['cusemail'];
			}
		
			return $customeremail;
		}
		else {
			 return '--';
		}
   }
		
	}	
	
	
		
	/*****************  Get Product Category - List  *****************/        
	
		
	/*****************  Get Product Category - List  *****************/            
    function listproductCategory($categoryID,$type,$name) {
	
		if($name=='1'){
			$path='manage_mtomasterstock.php?cat_id=';
		}
		if($name=='2'){
			$path='manage_rtwmasterstock.php?cat_id=';
		}
		if($name=='3'){
			$path='manage_mtomasterstockcard.php?cat_id=';
		}
		if($name=='4'){
			$path='manage_rtwmasterstockcard.php?cat_id=';
		}

        if($type != ''){
            $filter_type = "and categorytype = '$type'";
		}
		
        if($categoryID != ''){
            $filter_by_category = "and categoryID = '$categoryID'";
		}

	$maincategorylist = mysql_query("SELECT `categoryID`, `categorytitle`, `categoryparentID` FROM js_productcategory WHERE deleted = '0' and status = '1' {$filter_type} {$filter_by_category}") or die("Unable to get Category: ".mysql_error());
        while($main_categorylist = mysql_fetch_array($maincategorylist)) {
            $getcategory_id = $main_categorylist['categoryID'];
            $getcategory_title = $main_categorylist['categorytitle'];
            $getparentcategory_id = $main_categorylist['categoryparentID'];

                //get main category
                if($getparentcategory_id == 0) {    ?>                
                    <a class="dropdown-item" href='<?php echo $path.$getcategory_id?>'><?php echo $getcategory_title?></a>
            <?php }
                
                $parent_categorylist = mysql_query("SELECT `categoryID`, `categorytitle`, `categoryparentID` FROM js_productcategory WHERE categoryparentID=$getcategory_id and deleted = '0' and status = '1' order by categoryorder ASC") or die("Unable to get Category: ".mysql_error());
                $count_parentcategory = mysql_num_rows($parent_categorylist);
                
                    while($parentsub_categorylist = mysql_fetch_array($parent_categorylist)) {
                        $getcategory_id = $parentsub_categorylist['categoryID'];
                        $getparentcategory_id = $parentsub_categorylist['categoryID'];
                        $getparentcategory_title = $parentsub_categorylist['categorytitle']; ?>
                            <a class="dropdown-item" href='<?php echo $path.$getcategory_id?>' >&nbsp;--&nbsp;<?php echo $getparentcategory_title?></a>
                <?php    }
                
        }
    }
    
    /*****************  End of Get Parenet and sub Category *****************/
    
		/****************** get Stock Order return- detail ****************/
	function getnewSTOCKORDERRETURN($outsorno, $outletID, $type) {
		
		if($type == '2') {
			$out_type = 'MTO';	
		} else {
			$out_type = 'RTW';
		}
		
		
			if($outsorno == '') {
				$collectSOr_Count = sqlQUERY_LABEL("SELECT outsorno FROM `js_outletstockorderreturn` where `deleted`='0' and outletID='$outletID' and outsortype = '$type' order by outsorno DESC limit 0,1") or die("Unable to get Stock Order return REF NO: ".mysql_error());
				
				if(mysql_num_rows($collectSOr_Count) > 0 ) {
					while($collectSOr_id = sqlFETCHARRAY_LABEL($collectSOr_Count)) {
						$outsorno_detail = $collectSOr_id['outsorno'];
					}
					$outsorno_detail++;
				} else {
					$outletcode = getOutletrecords($outletID, 'code');
					$outsorno_detail = 'SOR-'.$outletcode.''.$out_type.'-11000';
				}
			} else {
	
				$collectSO_Count = sqlQUERY_LABEL("SELECT outsorno FROM `js_outletstockorderreturn` where outsorno = '$outsorno' and outletID='$outletID' and `deleted`='0' ") or die("Unable to get Stock Order REF NO: ".mysql_error());
				while($collectSO_id = sqlFETCHARRAY_LABEL($collectSO_Count)) {
					$outsorno_detail = $collectSO_id['outsorno'];
				}
			}
		return $outsorno_detail;
	
}
	/****************** end of Stock Order - detail ****************/
	
	
	//BILL COLLECTION REPORT 
	
	function dashboardBILL_list($sortby, $limit_count) {
			
			if($sortby == 'days') {
				$filterby_sorting = "order by billdate DESC";
			} else if($sortby == 'dueamount') {
				$filterby_sorting = "order by billbalance DESC";
			} else if($sortby == '') {
				$filterby_sorting = "order by billID DESC";
			}
			
			if($limit_count !='') {
				$filterby_limitrecords = "LIMIT 0 , $limit_count";
			}
			
		  $collectmaster_bill = sqlQUERY_LABEL("SELECT billrefno, cusID, billdate, billbalance, billtotal, createdon FROM `js_bill` where `deleted`='0' {$filterby_sorting} {$filterby_limitrecords} ") or die("Unable to get Recent Bill: ".mysql_error());
		  $checknew_billlist = sqlNUMOFROW_LABEL($collectmaster_bill);
		  
		  if($checknew_billlist > 0) {
		  while($bill_records = sqlFETCHARRAY_LABEL($collectmaster_bill)){
			$counter++;
			$billrefno= $bill_records['billrefno'];
			$cusID= $bill_records['cusID'];
			$billdate= $bill_records['billdate'];
			$billbalance= $bill_records['billbalance'];
			$billtotal= $bill_records['billtotal'];
			$createdon= $bill_records['createdon'];
					
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $billrefno.'<br>'.dateformat_datepicker($billdate); ?></td>
			<td><?php echo strtoupper(getCUSTOMER($cusID, 'label')); ?></td>
			<td><?php echo $billtotal; ?></td>
			</tr>
			<?php
		  }
		  } else {
		?>
		<tr><td colspan="4" align="center" class="text-muted"> No Bills available</td></tr>
		<?php  
		  }
			
		}
		
		
		
	//Reorder Outlet Stock COLLECTION REPORT 
	
	function dashboardOutlet_stock($limit_count) {
					
			if($limit_count !='') {
				$filterby_limitrecords = "LIMIT 0 , $limit_count";
			}
			
		  $collectmaster_bill = sqlQUERY_LABEL("SELECT * FROM `js_outletstock` where `deleted`='0' and `outletas`<'3' order by outletas DESC {$filterby_limitrecords}") or die("Unable to get Recent Bill: ".mysql_error());
		  $checknew_billlist = sqlNUMOFROW_LABEL($collectmaster_bill);
		  
		  if($checknew_billlist > 0) {
		  while($bill_records = sqlFETCHARRAY_LABEL($collectmaster_bill)){
			$counter++;
			$outletprdtID= $bill_records['outletprdtID'];
			$outletprdttype= $bill_records['outletprdttype'];
			$categoryID= $bill_records['categoryID'];
			$outletas= $bill_records['outletas'];
			$cat_title = getPARENTCategory($categoryID, 'label');
			$CategoryType = getCategoryType($outletprdttype, 'label');	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $CategoryType; ?></td>
			<td><?php echo $cat_title; ?></td>
			<td><?php echo $outletas; ?></td>
			</tr>
			<?php
		  }
		  } else {
		?>
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
		<?php  
		  }
			
		}


	//Stock Order COLLECTION REPORT 
	
	function dashboardMTOStock_order($limit_count) {
					
			if($limit_count !='') {
				$filterby_limitrecords = "LIMIT 0 , $limit_count";
			}
			
		  $collectmaster_bill = sqlQUERY_LABEL("SELECT * from js_mtostockorder where deleted='0' order by mtosoID DESC {$filterby_limitrecords}") or die("Unable to get Recent Bill: ".mysql_error());
		  $checknew_billlist = sqlNUMOFROW_LABEL($collectmaster_bill);
		  
		  if($checknew_billlist > 0) {
		  while($bill_records = sqlFETCHARRAY_LABEL($collectmaster_bill)){
			$counter++;
			$mtosono= $bill_records['mtosono'];
			$mtososent= $bill_records['mtososent'];
			$mtosototalitem= $bill_records['mtosototalitem'];
			$mtosototalquantity= $bill_records['mtosototalquantity'];
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $mtosono; ?></td>
			<td><?php echo $mtososent; ?></td>
			<td><?php echo $mtosototalitem; ?></td>
			</tr>
			<?php
		  }
		  } else {
		?>
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
		<?php  
		  }
			
		}
		
		
	//Stock Order COLLECTION REPORT 
	
	function dashboardRTWStock_order($limit_count) {
					
			if($limit_count !='') {
				$filterby_limitrecords = "LIMIT 0 , $limit_count";
			}
			
		  $collectmaster_bill = sqlQUERY_LABEL("SELECT * from js_rtwstockorder where deleted='0' order by rtwsoID DESC {$filterby_limitrecords}") or die("Unable to get Recent Bill: ".mysql_error());
		  $checknew_billlist = sqlNUMOFROW_LABEL($collectmaster_bill);
		  
		  if($checknew_billlist > 0) {
		  while($bill_records = sqlFETCHARRAY_LABEL($collectmaster_bill)){
			$counter++;
			$rtwsono= $bill_records['rtwsono'];
			$rtwsosent= $bill_records['rtwsosent'];
			$rtwsototalitem= $bill_records['rtwsototalitem'];
			$rtwsototalquantity= $bill_records['rtwsototalquantity'];
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $rtwsono; ?></td>
			<td><?php echo $rtwsosent; ?></td>
			<td><?php echo $rtwsototalquantity; ?></td>
			</tr>
			<?php
		  }
		  } else {
		?>
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
		<?php  
		  }
			
		}
		
		
//getting top life-time buyer
function lifetimebuyer_customers($limit_count) {
		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$total_collectmaster_order = mysql_query("SELECT `cusID`,COUNT(`cusID`) AS total_bills, SUM(`billtotal`) AS total_purchase FROM `js_bill` WHERE `status`!='0' and `status`!='5' GROUP BY cusID HAVING COUNT(cusID) > 1 order by SUM(`billtotal`) DESC {$filterby_limitrecords}") or die("Unable to get Bills: ".mysql_error());
	$total_checknew_order = mysql_num_rows($total_collectmaster_order);
		if($total_checknew_order > 0) {
	while($customer_record_detail = mysql_fetch_array($total_collectmaster_order)) {
			$counter++;
			$bill_customerid = $customer_record_detail['cusID'];
			$billqty= $customer_record_detail['total_bills'];
			$billed_amount= $customer_record_detail['total_purchase'];
			
			echo '<tr><td>'.$counter.'</td><td>'.getCUSTOMER($bill_customerid,'label').'</td><td>'.($billqty).'</td><td>'.summary_idr_Cash(($billed_amount)).'</td></tr>';
	}	
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
        
	<?php
	}
	
}


function MTO_outletreturn($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT outsorID, outsorno, outsordate, outsorgrnstatus, outsortotalitem, outsortotalquantity, status FROM `js_outletstockorderreturn` where deleted = '0' and outsortype = '2' order by outsorID desc {$filterby_limitrecords}") or die("Unable to get records:".mysql_error());
	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
		while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){
	
			$counter++;
			$outsorID = $fetch_records['outsorID'];
			$outsorno = $fetch_records['outsorno'];
			$outsordate = dateformat_datepicker($fetch_records['outsordate']);
			$outsorgrnstatus = $fetch_records['outsorgrnstatus'];
			$outsortotalitem = $fetch_records['outsortotalitem'];
			$outsortotalquantity = $fetch_records['outsortotalquantity'];
			if($outsorgrnstatus == '1') { 
				$grn = '<span class="btn btn-xs btn-success" data-toggle="tooltip" data-original-title="Active Item">Generated</span>';
			 } else { 
				$grn = '<span class="btn btn-xs btn-default" data-toggle="tooltip" data-original-title="In-Active Item">Not Generated</span>';
			 } 
			
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $outsorno; ?></td>
			<td><?php echo $outsordate; ?></td>
			<td><?php echo $grn; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
<?php	}
	
}


function RTW_outletreturn($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT outsorID, outsorno, outsordate, outsorgrnstatus, outsortotalitem, outsortotalquantity, status FROM `js_outletstockorderreturn` where deleted = '0' and outsortype = '1' order by outsorID desc {$filterby_limitrecords}") or die("Unable to get records:".mysql_error());
	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
		while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){
	
			$counter++;
			$outsorID = $fetch_records['outsorID'];
			$outsorno = $fetch_records['outsorno'];
			$outsordate = dateformat_datepicker($fetch_records['outsordate']);
			$outsorgrnstatus = $fetch_records['outsorgrnstatus'];
			$outsortotalitem = $fetch_records['outsortotalitem'];
			$outsortotalquantity = $fetch_records['outsortotalquantity'];
			if($outsorgrnstatus == '1') { 
				$grn = '<span class="btn btn-xs btn-success" data-toggle="tooltip" data-original-title="Active Item">Generated</span>';
			 } else { 
				$grn = '<span class="btn btn-xs btn-default" data-toggle="tooltip" data-original-title="In-Active Item">Not Generated</span>';
			 } 
			
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $outsorno; ?></td>
			<td><?php echo $outsordate; ?></td>
			<td><?php echo $grn; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
<?php	}
	
}


function MTO_masterstock($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_mtomasterstock` where deleted = '0' order by mmsID desc {$filterby_limitrecords}") or die("Unable to get records:".mysql_error());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		$id = $fetch_records['mmsID'];
		$categoryID = $fetch_records['categoryID'];
		$category_name= getPARENTCategory($categoryID, 'label');
		$mmstitle = $fetch_records['mmstitle'];
		$mmscode = $fetch_records['mmscode'];
		$mmsimage = $fetch_records['mmsimage'];
		$mmsunits = $fetch_records['mmsunits'];
		$unitID = $fetch_records['unitID'];
		$mmsverifiedby = $fetch_records['mmsverifiedby'];
		$mmsverifiedon = $fetch_records['mmsverifiedon'];
		$mmsstoragelocation = $fetch_records['mmsstoragelocation'];
		$mmsstorageinfo = $fetch_records['mmsstorageinfo'];
		$status = getActiveStatus($fetch_records['status'],'label');
		$mmsverifiedon = date("d-m-Y", strtotime($mmsverifiedon));
		$balance_units = getBalanceMTO_masterstock($id);
			
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $mmscode; ?></td>
			<td><?php echo $mmsunits; ?></td>
			<td><?php echo $balance_units; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
<?php	}
	
}


function RTW_masterstock($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_rtwmasterstock` where deleted = '0'  order by rmsID desc {$filterby_limitrecords} ") or die("Unable to get records:".mysql_error());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		$id = $fetch_records['rmsID'];
		$categoryID = $fetch_records['categoryID'];
		$category_name= getPARENTCategory($categoryID, 'label');
		$rmstitle = $fetch_records['rmstitle'];
		$rmscode = $fetch_records['rmscode'];
		$rmsimage = $fetch_records['rmsimage'];
		$rmsunits = $fetch_records['rmsunits'];
		$unitID = $fetch_records['unitID'];
		$rmsverifiedby = $fetch_records['rmsverifiedby'];
		$rmsverifiedon = $fetch_records['rmsverifiedon'];
		$rmsstoragelocation = $fetch_records['rmsstoragelocation'];
		$rmsstorageinfo = $fetch_records['rmsstorageinfo'];
		$status = getActiveStatus($fetch_records['status'],'label');
		$rmsverifiedon = date("d-m-Y", strtotime($rmsverifiedon));
			
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $rmscode; ?></td>
			<td><?php echo $rmsunits; ?></td>
			<td><?php echo $rmsunits; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
<?php	}
	
}


function DashboardRTW_stockcardlist($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_rtwstockcard` where deleted = '0' order by rscID DESC {$filterby_limitrecords}") or die("Unable to get records:".mysql_error());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

			$counter++;
			$id = $fetch_records['rscID'];
			$rsccode = $fetch_records['rsccode'];
			$rmsID = $fetch_records['rmsID'];
			$rscunits = $fetch_records['rscunits'];
			$rscoqty = $fetch_records['rscoqty'];
			$rscaqty = $fetch_records['rscaqty'];
			$sizeID = getSIZE($fetch_records['sizeID'], 'label');
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $rsccode; ?></td>
			<td><?php echo $rscunits.$sizeID; ?></td>
			<td><?php echo $rscaqty; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
	<?php	
    
    }

}


function DashboardMTO_stockcardlist($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_mtostockcard` where deleted = '0' order by mscID DESC {$filterby_limitrecords}") or die("Unable to get records:".mysql_error());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

			$counter++;
			$id = $fetch_records['mscID'];
			$msccode = $fetch_records['msccode'];
			$mmsID = $fetch_records['mmsID'];
			$mscunits = $fetch_records['mscunits'];
			$mscoqty = $fetch_records['mscoqty'];
			$mscaqty = $fetch_records['mscaqty'];
			$unitID = getUOM($fetch_records['unitID'], 'label');
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $msccode; ?></td>
			<td><?php echo $mscunits.$unitID; ?></td>
			<td><?php echo $mscaqty; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
	<?php	
    
    }

}


function Dashboard_fittinglist($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT * from js_orderform where deleted='0' and `orderform_fittingrqst`='1' and `orderform_fittingdate` != '0000-00-00' order by orderformID DESC {$filterby_limitrecords}") or die("Unable to get records:".mysql_error());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

			$counter++;
			$orderform_fileno = $fetch_records['orderform_fileno'];
			$billID = $fetch_records['billID'];
			$cusID = $fetch_records['cusID'];
			$orderform_fittingdate = dateformat_datepicker($fetch_records['orderform_fittingdate']);
			$billref = calculate_bill($billID, 'billref');
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $billref; ?></td>
			<td><?php echo $orderform_fileno; ?></td>
			<td><?php echo $orderform_fittingdate; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
	<?php	
    
    }

}


function Dashboard_Deliverylist($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT * from js_orderform where deleted='0' and `status` = '9' order by orderformID DESC {$filterby_limitrecords}") or die("Unable to get records:".mysql_error());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

			$counter++;
			$orderform_fileno = $fetch_records['orderform_fileno'];
			$billID = $fetch_records['billID'];
			$cusID = $fetch_records['cusID'];
			$orderform_deliverydate = dateformat_datepicker($fetch_records['orderform_deliverydate']);
			$billref = calculate_bill($billID, 'billref');
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $billref; ?></td>
			<td><?php echo $orderform_fileno; ?></td>
			<td><?php echo $orderform_deliverydate; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
	<?php	
    
    }

}


function Dashboard_measurementlist($created_by, $selectedoutlet_id, $limit_count) {

		if($limit_count !='') {
			$filterby_limitrecords = "LIMIT 0 , $limit_count";
		}
	
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_customermeasurement` where deleted = '0' order by cusmID DESC {$filterby_limitrecords}") or die("Unable to get records:".mysql_error());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
	
	if($fetch_list > '0') { 
	
	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

			$counter++;
			$cusmID = $fetch_records['cusmID'];
			$cusID = $fetch_records['cusID'];
			$kemeja = $fetch_records['kemeja'];
			$polano = $fetch_records['polano'];
			$batik = $fetch_records['batik'];
			$cusname = getCUSTOMER($cusID, 'label');
	
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $cusname; ?></td>
			<td><?php echo $kemeja; ?></td>
			<td><?php echo $batik; ?></td>
			</tr>
			<?php
		} 
	
	} else { ?>
	
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
	
	<?php	
    
    }

}


	//Stock Order COLLECTION REPORT 
	
	function dashboardORDER_list($user_level, $limit_count) {
					
			if($limit_count !='') {
				$filterby_limitrecords = "LIMIT 0 , $limit_count";
			}
			
			if($user_level == '6') {

				$filter_by_userlevel = "and status >= '5'";	
			
			}
			
			if($user_level == '5') {
			
				$filter_by_userlevel = "and status >= '3'";	
			
			}

			
		  $collectmaster_order = sqlQUERY_LABEL("SELECT * from js_orderform where deleted='0' {$filter_by_userlevel} order by orderformID DESC {$filterby_limitrecords}") or die("Unable to get Recent Bill: ".mysql_error());
		  $checknew_orderist = sqlNUMOFROW_LABEL($collectmaster_order);
		  
		  if($checknew_orderist > 0) {
		  while($bill_records = sqlFETCHARRAY_LABEL($collectmaster_order)){
			$counter++;
			$orderform_fileno= $bill_records['orderform_fileno'];
			$cusID= $bill_records['cusID'];
			$orderform_date= dateformat_datepicker($bill_records['orderform_date']);
			$billID= $bill_records['billID'];
			$billref = calculate_bill($billID, 'billref');
			?>
			<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $billref; ?></td>
			<td><?php echo $orderform_fileno; ?></td>
			<td><?php echo $orderform_date; ?></td>
			</tr>
			<?php
		  }
		  } else {
		?>
		<tr><td colspan="4" align="center" class="text-muted"> No Data available</td></tr>
		<?php  
		  }
			
		}


	/*****************  Get Order Status *****************/	

	function getORDERStatus($selected_type_id, $requesttype){


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {  ?>


			<option value="" <?php if($selected_type_id == 1){ echo "selected"; } ?>> --None-- </option>
            
            <option value="1" <?php if($selected_type_id == 1){ echo "selected"; } ?>> Pending </option>

            <option value="2" <?php if($selected_type_id == 2){ echo "selected"; } ?>> Completed </option>

            <option value="3" <?php if($selected_type_id == 3){ echo "selected"; } ?>> Cancelled </option>

	<?php
	
		}

	}
	
	/*****************  End of Order Status *****************/	
	
	/*****************  customer loyalty *****************/
	
	 function get_customerloyalty($selected_type_id){ 
	 
		/*****************  Label  *****************/
			
		
			$selected_query = sqlQUERY_LABEL("SELECT cusavailable FROM `js_customerloyaltypoints` where `cusID` = '$selected_type_id' and `deleted` = '0'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$cusavailable = $fetch_data['cusavailable'];
				
			}
			
			return $cusavailable;
				
		}

	/*****************  End of customer loyalty *****************/
	
	/*****************  Create bill refno *****************/
	
	function createBILLREFNO($billid) {

		if($billid == '') {
			$collectBILL = sqlQUERY_LABEL("SELECT `billrefno` FROM `js_bill` Order by billID DESC Limit 0,1") or die("Unable to get Bill details: ".mysql_error());
			if(mysql_num_rows($collectBILL) > 0 ) {
				while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
					$billrefno = $collectBILL_id['billrefno'];
				}
				$billrefno++;
			} else {
				$billrefno = 'B00001';
			}
		} else {

			$collectBILL = sqlQUERY_LABEL("SELECT `billrefno` FROM `js_bill` where billID = '$billid'") or die("Unable to get Bill Details: ".mysql_error());
			while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
				$billrefno = $collectBILL_id['billrefno'];
			}
		}
		return $billrefno;
	
	}
	/*****************  Create billrefno *****************/
	
	/*****************  Get Alteration *****************/	

	function getAlteration($selected_type_id, $requesttype){


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `cusoptID`, `cusopttitle` FROM `js_customoptions` where `cusopttype`='2' and deleted = '0' and status = '1' order by cusoptID ASC") or die("#STATUS-SELECT: Getting Status: ".mysql_error());
			 ?>
             <option value="">  Choose Alteration  </option>  
            <?php
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$cusoptID = $getstatus_fetch['cusoptID'];
				 	$cusopttitle = $getstatus_fetch['cusopttitle'];
				 ?>
                 <option value='<?php echo $cusoptID; ?>' <?php if($selected_type_id==$cusoptID) { echo "selected"; } ?> >
				 	<?php echo $cusopttitle; ?>
                 </option>
                 <?php
			 }
		}

		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `cusopttitle` FROM `js_customoptions` where `cusoptID`='$selected_type_id' and deleted = '0' and status = '1'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$cusopttitle = $getstatus_fetch['cusopttitle'];
					return $cusopttitle;
			 }
		}
		

	}
	
	/*****************  End of Alteration *****************/	

	/*****************  Get Stiching product *****************/	

	function getStichingProduct($selected_type_id, $requesttype){


		if($requesttype == 'select') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `cusoptID`, `cusopttitle` FROM `js_customoptions` where `cusopttype`='1' and deleted = '0' and status = '1' order by cusoptID ASC") or die("#STATUS-SELECT: Getting Status: ".mysql_error());
			 ?>
             <option value="">  Choose Stitching product  </option>  
            <?php
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$cusoptID = $getstatus_fetch['cusoptID'];
				 	$cusopttitle = $getstatus_fetch['cusopttitle'];
				 ?>
                 <option value='<?php echo $cusoptID; ?>' <?php if($selected_type_id==$cusoptID) { echo "selected"; } ?> >
				 	<?php echo $cusopttitle; ?>
                 </option>
                 <?php
			 }
		}

		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `cusopttitle` FROM `js_customoptions` where `cusoptID`='$selected_type_id' and deleted = '0' and status = '1'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$cusopttitle = $getstatus_fetch['cusopttitle'];
					return $cusopttitle;
			 }
		}
		
		if($requesttype == 'price') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `cusoptprice` FROM `js_customoptions` where `cusoptID`='$selected_type_id' and deleted = '0' and status = '1'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$cusoptprice = $getstatus_fetch['cusoptprice'];
					return $cusoptprice;
			 }
		}
	}
	
	/*****************  End of Stiching product *****************/	

	/*****************  Get Payment Mode *****************/	
	
	function getPaymentmode($paymentmode, $requesttype) {
		
		if($requesttype == 'select') { 
			?>
			<option value='1'<?php if($paymentmode == '1'){ echo "selected"; } ?>>CASH</option>
			<option value='2'<?php if($paymentmode == '2'){ echo "selected"; } ?>>DEBIT CARD</option>
			<option value='3'<?php if($paymentmode == '3'){ echo "selected"; } ?>>CREDIT CARD</option>
			<option value='4'<?php if($paymentmode == '4'){ echo "selected"; } ?>>TRF BCA</option>
			<option value='5'<?php if($paymentmode == '5'){ echo "selected"; } ?>>TRF MANDIRI</option>
			<option value='6'<?php if($paymentmode == '6'){ echo "selected"; } ?>>CHEQUE</option>
			<?php
		}
		
		if($requesttype == 'label'){  
			if($paymentmode == '1') {
				return  'CASH';
			} elseif($paymentmode == '2') {
				return  'DEBIT CARD';
			} elseif($paymentmode == '3') {
				return  'CREDIT CARD';
			} elseif($paymentmode == '4') {
				return  'TRF BCA';
			} elseif($paymentmode == '5') {
				return  'TRF MANDIRI';
			} elseif($paymentmode == '6') {
				return  'CHEQUE';
			}	
		}
		
	}	
	
	/*****************  End of Payment Mode *****************/
	
	
	/*****************  Get Category categorypricefunction *****************/
	
	 function getCategoryPrice($selected_type_id){ 
	
		/*****************  Label  *****************/	
		
			$selected_query = sqlQUERY_LABEL("SELECT categoryprice FROM `js_productcategory` where `categoryID` = '$selected_type_id' and `deleted` = '0' and `status` = '1'") or die("#PARENT-LABEL: Getting Parent Category: ".mysql_error());
			
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_query)) {
			
				$categoryprice = $fetch_data['categoryprice'];
				
				
			}
			
	return $categoryprice;	
				
	
	}
	
	
	/*****************  End of Get categoryprice function *****************/	
	
	
	/*****************  Get Category categorypricefunction *****************/
	
	 function calculate_bill($selected_type_id,$type){ 
	
		/*****************  Label  *****************/	
		if($type == 'subtotal') {
			 $collectsum_itemprice = sqlQUERY_LABEL("SELECT sum(billitemprice*billitemqty) as subtotal FROM `js_billitem` where billID = '$selected_type_id' and deleted ='0'" ) or die("Unable to get footer data: ".mysql_error());
			$collectsum_itemprice_list = sqlFETCHARRAY_LABEL($collectsum_itemprice); 	{
			
			$output = $collectsum_itemprice_list['subtotal'];
		}				
                                                        
			
	}
	
	if($type == 'billqty') {
			 $collectsum_itemprice = sqlQUERY_LABEL("SELECT sum(billitemqty)as billqty FROM `js_billitem` where billID = '$selected_type_id' and deleted ='0'") or die("Unable to get footer data: ".mysql_error());
			$collectsum_itemprice_list = sqlFETCHARRAY_LABEL($collectsum_itemprice); 	{
			
			$output = $collectsum_itemprice_list['billqty'];	
		}				
                                                        
			
	}
	
	if($type == 'rbillqty') {
			 $collectsum_itemprice = sqlQUERY_LABEL("SELECT sum(rbillitemrqty)as billqty FROM `js_rbillitem` where rbillID = '$selected_type_id' and deleted ='0'") or die("Unable to get footer data: ".mysql_error());
			$collectsum_itemprice_list = sqlFETCHARRAY_LABEL($collectsum_itemprice); 	{
			
			$output = $collectsum_itemprice_list['billqty'];	
		}				
                                                        
			
	}
	
	if($type == 'billbalance') {
			 $collectsum_itemprice = sqlQUERY_LABEL("SELECT billbalance FROM `js_bill` where billID = '$selected_type_id' and deleted ='0'") or die("Unable to get billbalance: ".mysql_error());
			$collectsum_itemprice_list = sqlFETCHARRAY_LABEL($collectsum_itemprice); 	{
			
			$output = $collectsum_itemprice_list['billbalance'];	
		}				
                                                        
			
	}
	
	if($type == 'billref') {
			 $collectsum_itemprice = sqlQUERY_LABEL("SELECT billrefno FROM `js_bill` where billID = '$selected_type_id' and deleted ='0'") or die("Unable to get billbalance: ".mysql_error());
			$collectsum_itemprice_list = sqlFETCHARRAY_LABEL($collectsum_itemprice); 	{
			
			$output = $collectsum_itemprice_list['billrefno'];	
		}				
                                                        
			
	}
			
	return $output;	
				
	
	}
	
	/*****************  End of Get categoryprice function *****************/	
	
	/*****************  Get Size*****************/	
	
	function getbilltype_units($selected_type_id, $requesttype){
		
		
		/*****************  SELECT OPTION   *****************/	
		
		if($requesttype == 'RTW') {
		
			$select_list = sqlQUERY_LABEL("select * FROM `js_rtwstockcard` where `rscID`='$selected_type_id' and `deleted`='0'") or die(mysql_error());
					while($collect_list = sqlFETCHARRAY_LABEL($select_list)) {
						$units = $collect_list['sizeID'];
					}
		}	
		
		if($requesttype == 'MTO') {
		
			$select_list = sqlQUERY_LABEL("select * FROM `js_mtostockcard` where `mscID`='$selected_type_id' and `deleted`='0'") or die(mysql_error());
					while($collect_list = sqlFETCHARRAY_LABEL($select_list)) {
						$units = $collect_list['unitID'];
					}
		}
	return $units;	
				
		}
		
	/*********Bill status*************/
	
	function billSTATUS_label($statusID) {
		//0-in-complete 1-unpaid 2-due 3-paid 4-order generated 5-cancelled
		if($statusID == '1') {
			$status_label = 'Paid';
		} elseif($statusID == '2') {
			$status_label = 'Due';
		} elseif($statusID == '3') {
			$status_label = 'Cancelled';
		} elseif($statusID == '0') {
			$status_label = 'In-Complete';
		}
		
		return $status_label;

	}
	
	/******************End of bill status *****/
	
	/******************OUtlet stock available *****/
	
	 function getoutletavailable($selected_id,$type){ 
	
		/*****************  Label  *****************/	
			$selected_outletstk = sqlQUERY_LABEL("SELECT outletas FROM `js_outletstock` where `outletprdtID` = '$selected_id' and outletprdttype='$type' and deleted ='0'") or die("#PARENT-LABEL: Getting outlet stock: ".mysql_error());
			if(sqlNUMOFROW_LABEL($selected_outletstk) > 0 ) {
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_outletstk)) {
				
					$outletas = $fetch_data['outletas'];
				}
			}else{
				$outletas = 0;
			}
	return $outletas;	
	
	
	}
	
	/******************End of OUtlet stock available*****/	
	
	/*****************  Create return bill reference number*****************/	
	function createRBILLREFNO($billrefid) {

		if($billrefid == '') {
			$collectBILL = sqlQUERY_LABEL("SELECT `rbillrefno` FROM `js_rbill` Order by rbillID DESC Limit 0,1") or die("Unable to get Bill details: ".mysql_error());
			if(mysql_num_rows($collectBILL) > 0 ) {
				while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
					$rbillrefno = $collectBILL_id['rbillrefno'];
				}
				$rbillrefno++;
			} else {
				$rbillrefno = 'RB00001';
			}
		return $rbillrefno;	
		}
	}
	/*****************  End of return bill reference number*****************/
	
/*****************  getrbillitem_qty*****************/	
	function getrbillitem_qty($rbillid,$type,$prdt) {

			$collectBILL = sqlQUERY_LABEL("SELECT `rbillitemrqty` FROM `js_rbillitem` where rbillID='$rbillid' and rbillitemtype='$type' and rbillitemprdt='$prdt' and deleted = 0") or die("Unable to get Bill details: ".mysql_error());
			if(mysql_num_rows($collectBILL) > 0 ) {
				while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
					$rbillitemrqty = $collectBILL_id['rbillitemrqty'];
				}
			} 
		return $rbillitemrqty;	
	}
	/*****************  End of getrbillitem_qty*****************/	
	
	
	
	 function getoutlet_astock($outlet_id,$type,$prd_id){ 
	
		/*****************  Label  *****************/	
			$selected_outletstk = sqlQUERY_LABEL("SELECT outletas FROM `js_outletstock` where `outletprdtID` = '$prd_id' and outletprdttype='$type' and outletID = '$outlet_id' and deleted ='0'") or die("#PARENT-LABEL: Getting outlet stock: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_outletstk)) {
			
				$outletas = $fetch_data['outletas'];
			}
	return $outletas;	
	
	
	}
	
	/******************End of OUtlet stock available*****/

	function Outletlist($outletID,$type,$name) {
	
		if($name=='1'){
			$path='manage_mtooutletstockreturn.php?out_id=';
		}
		if($name=='2'){
			$path='manage_rtwoutletstockreturn.php?out_id=';
		}
		if($name=='3'){
			$path='manage_outletstock.php?out_id=';
		}
		if($name=='4'){
			$path='manage_mtostockorder.php?out_id=';
		}
		if($name=='5'){
			$path='manage_rtwstockorder.php?out_id=';
		}

		if($type != ''){
		$filter_type = "and outlettype = '$type'";
		}

		if($outletID != ''){
		$filter_type = "and outletID = '$outletID'";
		}

		$outletlist = mysql_query("SELECT `outletname`, `outletID` FROM `js_outlet` WHERE deleted = '0' and status = '1' {$filter_type} {$filter_by_category} ") or die("Unable to get Outlet: ".mysql_error());
        while($outlet_list = mysql_fetch_array($outletlist)) {
			$getoutletname = $outlet_list['outletname'];
			$getoutletID = $outlet_list['outletID'];
                //get main category
                if($getoutletID != '') {    ?>                
                    <a class="dropdown-item" href='<?php echo $path.$getoutletID?>'><?php echo $getoutletname?></a>       
		<?php }
					
			}
	}
	
	
		
	/******************Create payment refno*****/
	
	function createPAYMENTREFNO($billid, $billref_no) {

		if($billid != '') {

			$collectPAYMENTREF_NO = sqlQUERY_LABEL("SELECT `referenceno` FROM `js_payment_received` where billID='$billid' order by receivedID DESC Limit 0,1") or die("Unable to get Bill details: ".mysql_error());
			if(sqlNUMOFROW_LABEL($collectPAYMENTREF_NO) > 0 ) {
				while($PAYMENTREF_id = sqlFETCHARRAY_LABEL($collectPAYMENTREF_NO)) {
					$referenceno = $PAYMENTREF_id['referenceno'];
				}
				$referenceno++;
				
			} else {
				$referenceno = date('Ymd').'-'.$billref_no.'-0001';  //2018-11-08-billrefno-000
			}
		} 
		return $referenceno;
		//end of generating new bill ref no
	}
	
/******************End of payment refno*****/

/******************Last Received payment*****/
function getlast_receivedpayment($billid){ 
	
		/*****************  Label  *****************/	
			$selected_outletstk = sqlQUERY_LABEL("SELECT receivedamount FROM `js_payment_received` where `billID` = '$billid' and deleted ='0' order by receivedID desc limit 0,1") or die("#PARENT-LABEL: Getting payment received: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_outletstk)) {
			
				$receivedamount = $fetch_data['receivedamount'];
			}
	return $receivedamount;	
	
	
	}


/******************End of Last Received payment*****/
/*****************  Choose order type *****************/	

	function getORDERtype($selected_type_id, $requesttype){


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {  ?>


			<option value=""> --None-- </option>
            
            <option value="1" <?php if($selected_type_id == 1){ echo "selected"; } ?>> Ordinary </option>

            <option value="2" <?php if($selected_type_id == 2){ echo "selected"; } ?>> Urgent </option>


	<?php
	
		}
		if($requesttype == 'label') {
		
		if($selected_type_id == '1') {
				return  'Ordinary';
			}
			
			if($selected_type_id == '2') {
				return  'Urgent';
			}
		
		} 

	}
	
	/*****************  End of Order Status *****************/	
	
	
	/*****************  Get Order reference no *****************/	
	function getnewORDERCOUNT() {
		$collectORDER_Count = sqlQUERY_LABEL("SELECT orderform_refno FROM `js_orderform` order by orderformID DESC limit 0,1") or die("Unable to get Order: ".mysql_error());
		if(sqlNUMOFROW_LABEL($collectORDER_Count) > 0 ) {
			while($collectORDER_id = sqlFETCHARRAY_LABEL($collectORDER_Count)) {
				$orderCOUNT_detail = $collectORDER_id['orderform_refno'];
			}
			$orderCOUNT_detail++;
		} else {
			$orderCOUNT_detail = 'FILE-'.date('my').'-00001';
		}
		//ORD-2017-05-15071
		return $orderCOUNT_detail;
	}
/*****************  End of Order reference no *****************/	

/*****************  Get Style category pictures *****************/

function choosestylecatLIST($item_id) {
		$mainstlye_catlist = sqlQUERY_LABEL("SELECT `stylecatID`,`stylecat_title` FROM js_stylecategory WHERE status = '1'") or die("Unable to get offer: ".mysql_error());
		while($main_stlye_catlist = sqlFETCHARRAY_LABEL($mainstlye_catlist)) {
			$stylecat_id = $main_stlye_catlist['stylecatID'];
			$stylecat_title = $main_stlye_catlist['stylecat_title'];
			?>
            <option value="<?php echo $stylecat_id; ?>" <?php if($stylecat_id == $item_id) { echo 'selected'; } ?> ><?php echo $stylecat_title; ?></option>
            <?php
		}
	}
/*****************  Get Order reference no *****************/

/*****************  Check order form style created *****************/

function checkOrderformstyle($orderformID,$billitemprdt) {
		$collectORDER_Count = sqlQUERY_LABEL("SELECT orderformstyleID FROM `js_orderformstyle` where orderformID = '$orderformID' and billitemprdt = '$billitemprdt' and deleted = 0") or die("Unable to get Order: ".mysql_error());
		if(sqlNUMOFROW_LABEL($collectORDER_Count) > 0 ) {
			while($fetchcust_records = sqlFETCHARRAY_LABEL($collectORDER_Count)){
						$orderformstyleID = $fetchcust_records['orderformstyleID'];
			}
		}
		
		return $orderformstyleID;
	}
/*****************  End of Check order form style created*****************/


/****************** get user role****************/
	function getuserrole($selected_status_id, $requesttype) {
		
		if($requesttype == 'label') {
			 $getstatus_query = mysql_query("SELECT `roletitle` FROM `js_role` where `roleID`='$selected_status_id'") or die("#STATUS-LABEL: Getting Status: ".mysql_error());
			 while($getstatus_fetch = mysql_fetch_array($getstatus_query)) {
				 	$roletitle = $getstatus_fetch['roletitle'];
			 }
		}
		
		return $roletitle;

		
	}	
	/****************** end of Common Status - detail ****************/

/*****************  Function for Auto Daily Sales Report *****************/

//DAILY REPORT
function sales_billsamount_DATE($date) {
	$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(billtotal) AS billed_totalpaid FROM `js_bill` where `deleted`='0' AND billdate='".$date."' and status != '0' and status != '3'") or die("Unable to get #1: ".mysql_error());
	$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid); 
	return INOD_rupiah($collectsum_paid_list['billed_totalpaid'],'ind');
}

//BILLS
function sales_billsCOUNT_DATE($date) {
	$countingBILLS = sqlQUERY_LABEL("SELECT COUNT(*) FROM js_bill WHERE `deleted`='0' AND billdate='".$date."' and status != '0'");
	$count = mysql_fetch_array($countingBILLS);
	return $count[0];
}

//PAID  //paid paid_one  paid_two
function sales_billsPAID($date) {
	$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(billpaidone) AS billed_paid_one, SUM(billpaidtwo) AS billed_paid_two, SUM(billpaidthree) AS billed_paid_three FROM `js_bill` WHERE `deleted`='0' AND billdate='".$date."' and status != '0' and status != '3'") or die(mysql_error());
	$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
	$totalling_paid_amount = ($collectsum_paid_list['billed_paid_one'] + $collectsum_paid_list['billed_paid_two'] + $collectsum_paid_list['billed_paid_three']);
	return INOD_rupiah($totalling_paid_amount,'ind');
}


//BALANCE
function sales_billsBALANCE($date) {
	$collectsum_balance = sqlQUERY_LABEL("SELECT SUM(billbalance) AS billed_balance FROM `js_bill` WHERE `deleted`='0' AND billdate='".$date."' AND `status` IN (1,2)") or die(mysql_error());
	$collectsum_balance_list = mysql_fetch_assoc($collectsum_balance); 

	return INOD_rupiah($collectsum_balance_list['billed_balance'],'ind');
}

// `modeofpay`, `modeofpay_one`, `modeofpay_two`,  `totalamount`, `paid`, `paid_one`, `paid_two`
function receiptPMODE_bydate($pmode, $dates) {
		
	//checking payment mode #1
	$collect_receiptpmode_one = sqlQUERY_LABEL("SELECT sum(billpaidone) as paidONE FROM `js_bill` where billdate = '".$dates."' and billmodeone = '".$pmode."' and billpaidone!='0' and `deleted`='0'") or die("Unable to get payment mode status: ".mysql_error());
		$collect_receiptpmode_one_list = mysql_fetch_assoc($collect_receiptpmode_one);
		$paidONE = ($collect_receiptpmode_one_list['paidONE']);

	//checking payment mode #2
	$collect_receiptpmode_one = sqlQUERY_LABEL("SELECT sum(billpaidtwo) as paidTWO FROM `js_bill` where billdate = '".$dates."' and billmodetwo = '".$pmode."' and billpaidtwo!='0' and `deleted`='0'") or die("Unable to get payment mode status: ".mysql_error());
		$collect_receiptpmode_one_list = mysql_fetch_assoc($collect_receiptpmode_one);
		$paidTWO = ($collect_receiptpmode_one_list['paidTWO']);
			
	//checking payment mode #3
	$collect_receiptpmode_one = sqlQUERY_LABEL("SELECT sum(billpaidthree) as paidTHREE FROM `js_bill` where billdate = '".$dates."' and billmodethree = '".$pmode."' and billpaidthree !='0' and `deleted`='0'") or die("Unable to get payment mode status: ".mysql_error());
		$collect_receiptpmode_one_list = mysql_fetch_assoc($collect_receiptpmode_one);
		$paidMAIN = ($collect_receiptpmode_one_list['paidTHREE']);
		
	return ($paidTHREE+$paidONE+$paidTWO);	
}

/***************** En of the Function for Auto Daily Sales Report *****************/



/*****************  Function for Dashboard Summary *****************/

//QUICK SUMMARY SECTION
function quick_summary($type, $requesttype) {

	//type - today, week, month".date('Y-m-d')."
	if($type == 'today') {
		$filter_quicksummary = "and billdate = '".date('Y/m/d')."'";
		$filter_quicksummary_amt = "and receiveddate = '".date('Y/m/d')."'";
	} else if($type == 'week') {
		$toreport = date('Y/m/d');	
		$fromreport = date('Y/m/d', strtotime("-7 days"));
		$filter_quicksummary = "and billdate between  '$fromreport' and '$toreport'";
		$filter_quicksummary_amt = "and receiveddate between  '$fromreport' and '$toreport'";
	} else if($type == 'month') {
		$filter_quicksummary = "and MONTH(`billdate`)='".date('m')."' and  YEAR(`billdate`)='".date('Y')."'";
		$filter_quicksummary_amt = "and MONTH(`receiveddate`)='".date('m')."' and  YEAR(`receiveddate`)='".date('Y')."'";
	}

	//total bills
	if($requesttype == 'totalbills') { 
		$countingBILLS = sqlQUERY_LABEL("SELECT COUNT(*) FROM js_bill WHERE `deleted`='0' {$filter_quicksummary} and status != '0'");
		$count = sqlFETCHARRAY_LABEL($countingBILLS);
		return $count[0];
	}
	
	
	//sales amount
	if($requesttype == 'totalsales') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(billtotal) AS billed_totalpaid FROM `js_bill` where `deleted`='0' {$filter_quicksummary} and status != '0' and status != '3'") or die("Unable to get #1: ".mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid); 
		return INOD_rupiah($collectsum_paid_list['billed_totalpaid'], 'ind');
	}
	
	//received amount
	if($requesttype == 'totalreceived') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(billpaidthree) AS billed_paid_three, SUM(billpaidone) AS billed_paid_one, SUM(billpaidtwo) AS billed_paid_two FROM `js_bill` WHERE `deleted`='0' {$filter_quicksummary} AND `billpaidone`!='0'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['billed_paid_one'] + $collectsum_paid_list['billed_paid_two'] + $collectsum_paid_list['billed_paid_three']);
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	
	//balance
	if($requesttype == 'totalblance') {
		$collectsum_balance = mysql_query("SELECT SUM(billbalance) AS billed_balance FROM `js_bill` WHERE `deleted`='0' {$filter_quicksummary} AND `status`  IN (1,2)") or die(mysql_error());
		$collectsum_balance_list = mysql_fetch_assoc($collectsum_balance); 
		
		if($collectsum_balance_list['billed_balance'] != '') {
			return $collectsum_balance_list['billed_balance'];
		} else {
			return '0';
		}
	}
	
	
	//Cash amount
	if($requesttype == 'totalcash') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' {$filter_quicksummary_amt} AND `receivedmode`='1'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	

	//Cash amount
	if($requesttype == 'totalCard') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' {$filter_quicksummary_amt} AND `receivedmode` IN (2,3)") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	
	//Bank amount
	if($requesttype == 'totalbank') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' AND `receivedmode` IN (4,5)") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	//Cheque amount
	if($requesttype == 'totalcheque') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' {$filter_quicksummary_amt} AND `receivedmode`= '6'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}

	}

}

/*****************  End of Function for Dashboard Summary *****************/
/*****************  Get Payment Mode *****************/	

	function choosefitting($selected_type_id, $requesttype){


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {  ?>

			<option value="1" <?php if($selected_type_id == 1){ echo "selected"; } ?>> Delivery </option>
            
            <option value="2" <?php if($selected_type_id == 2){ echo "selected"; } ?>> Fitting </option>



	<?php
	
		}
		
			
		if($requesttype == 'label'){  
		
			if($selected_type_id == '1') {
				return  'Delivery';
			}
			
			if($selected_type_id == '2') {
				return  'Fitting';
			}
				
		}
		

	}
	
	/*****************  End of Payment Mode *****************/
	/******************OUtlet stock available *****/
	
	function getoutletopening($selected_id,$type){ 
	
		/*****************  Label  *****************/	
			$selected_outletstk = sqlQUERY_LABEL("SELECT outletos FROM `js_outletstock` where `outletprdtID` = '$selected_id' and outletprdttype='$type' and deleted ='0'") or die("#PARENT-LABEL: Getting outlet stock: ".mysql_error());
			if(sqlNUMOFROW_LABEL($selected_outletstk) > 0 ) {
				while($fetch_data = sqlFETCHARRAY_LABEL($selected_outletstk)) {
				
					$outletos = $fetch_data['outletos'];
				}
			}else{
				$outletos = 0;
			}
			
	return $outletos;	
	
	
	}
	
	/******************End of OUtlet stock available*****/	
	
	
	 function get_stockorderitem($selected_id,$selected_soid,$type){ 
	
		/*****************  Label  *****************/	
		if($type == 'mto'){
			$selected_mto_cardquery = sqlQUERY_LABEL("SELECT mtosoitemqty FROM `js_mtostockorderitem` where `mscID` = '$selected_id' and `mtosoID` = '$selected_soid' and deleted ='0'") or die("#STOCK-ORDER: MTO Order qty".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_mto_cardquery)) {
				$mtosoitemqty = $fetch_data['mtosoitemqty'];
			}
			return $mtosoitemqty;	
		}
		
		if($type == 'mtoitems'){
			$selected_mto_cardcount = sqlQUERY_LABEL("SELECT * FROM `js_mtostockorderitem` where `mtosoID` = '$selected_soid' and deleted ='0'") or die("#STOCK-ORDER: MTO Order item: ".mysql_error());
			$mtosoitem_count = sqlNUMOFROW_LABEL($selected_mto_cardcount);
			return $mtosoitem_count;	
		}
	
		if($type == 'rtw'){
			$selected_mto_cardquery = sqlQUERY_LABEL("SELECT rtwsoitemqty FROM `js_rtwstockorderitem` where `rscID` = '$selected_id' and `rtwsoID` = '$selected_soid' and deleted ='0'") or die("#STOCK-ORDER: RTW Order qty: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_mto_cardquery)) {
				$rtwsoitemqty = $fetch_data['rtwsoitemqty'];
			}
			return $rtwsoitemqty;	
		}
		
		if($type == 'rtwitems'){
			$selected_rtw_cardcount = sqlQUERY_LABEL("SELECT * FROM `js_rtwstockorderitem` where `rtwsoID` = '$selected_soid' and deleted ='0'") or die("#STOCK-ORDER: RTW Order item: ".mysql_error());
			$rtwsoitem_count = sqlNUMOFROW_LABEL($selected_rtw_cardcount);
			return $rtwsoitem_count;	
		}
	
		if($type == 'sormto'){
			$selected_mto_cardquery = sqlQUERY_LABEL("SELECT outsoritemqty FROM `js_outletstockorderreturnitem` where `outletprdtID` = '$selected_id' and `outsorID` = '$selected_soid' and deleted ='0'") or die("#STOCK-ORDER: MTO Stock Order qty: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_mto_cardquery)) {
				$outsoritemqty = $fetch_data['outsoritemqty'];
			}
			return $outsoritemqty;	
		}
			
		if($type == 'sormtoitems'){
			$selected_mto_cardcount = sqlQUERY_LABEL("SELECT * FROM `js_outletstockorderreturnitem` where `outsorID` = '$selected_soid' and deleted ='0'") or die("#STOCK-ORDER: MTO Stock Order item: ".mysql_error());
			$outsoritem_count = sqlNUMOFROW_LABEL($selected_mto_cardcount);
			return $outsoritem_count;
		}
			
		if($type == 'sorrtwitems'){
			$selected_mto_cardcount = sqlQUERY_LABEL("SELECT * FROM `js_outletstockorderreturnitem` where `outsorID` = '$selected_soid' and deleted ='0'") or die("#STOCK-ORDER: RTW Stock Order item: ".mysql_error());
			$outsoritem_count = sqlNUMOFROW_LABEL($selected_mto_cardcount);
			return $outsoritem_count;
		}

}


/*****************  Warehouse - MTO checking stock available *****************/	
	function get_masterstockcard_itemwise_QTY($selected_id, $requesttype){ 

		if($requesttype == 'opening_qty'){   
	
			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(mscoqty) as total FROM `js_mtostockcard` where `mscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Master Stock Card: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$output = $fetch_data['total'];
			}
			
		}
		
		if($requesttype == 'available_qty'){

			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(mscaqty) as total FROM `js_mtostockcard` where `mscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Master Stock Card: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$output = $fetch_data['total'];
			}
		
		}
			
		return $output;
		
	}

/*****************  Warehouse - RTW checking stock available *****************/	
	function get_rtwmasterstockcard_itemwise_QTY($selected_id, $requesttype){ 

		if($requesttype == 'opening_qty'){   
	
			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(rscoqty) as total FROM `js_rtwstockcard` where `rscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Master Stock Card: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$output = $fetch_data['total'];
			}
			
		}
		
		if($requesttype == 'available_qty'){

			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(rscaqty) as total FROM `js_rtwstockcard` where `rscID` = '$selected_id' and deleted ='0' and status = '1'") or die("#PARENT-LABEL: Getting Master Stock Card: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$output = $fetch_data['total'];
			}
		
		}
			
		return $output;
		
	}

/*****************  Outlet - MTO checking stock available *****************/	
	function get_mtooutletstocks_itemwise_QTY($selected_id, $selected_outlet, $requesttype){ 

		if($requesttype == 'opening_qty'){   
	
			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(outletos) as total FROM `js_outletstock` where `outletprdtID` = '$selected_id' and `outletID`='$selected_outlet' and `outletprdttype`='2' and deleted ='0'") or die("#PARENT-LABEL: Getting MTO Outlet Available Stock: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$output = $fetch_data['total'];
			}
			
		}
		
		if($requesttype == 'available_qty'){

			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(outletas) as total FROM `js_outletstock` where `outletprdtID` = '$selected_id' and `outletID`='$selected_outlet' and `outletprdttype`='2' and deleted ='0'") or die("#PARENT-LABEL: Getting MTO Outlet Available Stock: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$output = $fetch_data['total'];
			}
		
		}
			
		return $output;
		
	}

/*****************  Warehouse - RTW checking stock available *****************/	
	function get_rtwoutletstocks_itemwise_QTY($selected_id, $selected_outlet, $requesttype){ 

		if($requesttype == 'opening_qty'){   
	
			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(outletos) as total FROM `js_outletstock` where `outletprdtID` = '$selected_id' and `outletID`='$selected_outlet' and `outletprdttype`='1' and deleted ='0'") or die("#PARENT-LABEL: Getting MTO Outlet Available Stock: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$output = $fetch_data['total'];
			}
			
		}
		
		if($requesttype == 'available_qty'){
			$selected_MTO_cardquery = sqlQUERY_LABEL("SELECT sum(outletas) as total FROM `js_outletstock` where `outletprdtID` = '$selected_id' and `outletID`='$selected_outlet' and `outletprdttype`='1' and deleted ='0'") or die("#PARENT-LABEL: Getting MTO Outlet Available Stock: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_MTO_cardquery)) {
			
				$output = $fetch_data['total'];
			}
		
		}
			
		return $output;
		
	}	
	
/*****************  MTO/RTW Master Stock image *****************/
	function get_masterstocks_IMAGES($selected_id, $requesttype){ 
		
		if($requesttype == 'MTO') {
			$selected_RTW_query = sqlQUERY_LABEL("SELECT mmsimage FROM `js_mtomasterstock` where `mmsID` = '$selected_id' and deleted ='0' and status = '1'") or die("#MASTER STOCK IMAGE: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_RTW_query)) {
				$masterstockimage = $fetch_data['mmsimage'];
			}			
			$path = 'public/mtomasterstock_images/';		
		}
		
		if($requesttype == 'RTW') {
			$selected_RTW_query = sqlQUERY_LABEL("SELECT rmsimage FROM `js_rtwmasterstock` where `rmsID` = '$selected_id' and deleted ='0' and status = '1'") or die("#MASTER STOCK IMAGE: ".mysql_error());
			while($fetch_data = sqlFETCHARRAY_LABEL($selected_RTW_query)) {
				$masterstockimage = $fetch_data['rmsimage'];
			}
			$path = 'public/rtwmasterstock_images/';		
		}
		
		$masterstock_full_image = BASEPATH.$path.$masterstockimage; //image path - public/img/logo/
		$masterstockimage_data = @getimagesize($masterstock_full_image); //checking image
		if(!empty($masterstockimage_data)) {
			return "<img src='".$masterstock_full_image."' class='image-thumbnail' style='width: 50px; height: 50px;' />";
		} else {
			return "No-Image";
		}
		
	}
	
/*****************  Get Alteration *****************/	

	function getPromotions($selected_type_id, $requesttype){


		/*****************  SELECT OPTION   *****************/	

		if($requesttype == 'select') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT * FROM `js_promotions` where deleted = '0' and status = '1' order by promoqty ASC") or die("#STATUS-SELECT: Getting Status: ".mysql_error());
			 ?>
             <option value="">  Choose Promo </option>  
            <?php
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$promoID = $getstatus_fetch['promoID'];
				 	$promotitle = $getstatus_fetch['promotitle'];
					$promoprice = $getstatus_fetch['promoprice'];
				 ?>
                 <option value='<?php echo $promoID; ?>' <?php if($selected_type_id==$promoID) { echo "selected"; } ?> >
				 	<?php echo $promotitle .'-'.INOD_rupiah($promoprice,'ind'); ?>
                 </option>
                 <?php
			 }
		}

		/*****************  SELECT OPTION   *****************/
		if($requesttype == 'label') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `promotitle` FROM `js_promotions` where `promoID`='$selected_type_id'") or die("#STATUS-LABEL: Getting promotions: ".mysql_error());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$promotitle = $getstatus_fetch['promotitle'];
					return $promotitle;
			 }
		}
		
		if($requesttype == 'promoqty') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `promoqty` FROM `js_promotions` where `promoID`='$selected_type_id'") or die("#STATUS-LABEL: Getting promotions: ".mysql_error());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$promoqty = $getstatus_fetch['promoqty'];
					return $promoqty;
			 }
		}
		
		if($requesttype == 'promoprice') {
			 $getstatus_query = sqlQUERY_LABEL("SELECT `promoprice` FROM `js_promotions` where `promoID`='$selected_type_id'") or die("#STATUS-LABEL: Getting promotions: ".mysql_error());
			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($getstatus_query)) {
				 	$promoprice = $getstatus_fetch['promoprice'];
					return $promoprice;
			 }
		}
		

	}
	
	/*****************  End of Alteration *****************/
	function get_productcode($selected_id,$type){ 

	if($type== 'product') {

	$productitemlist = sqlQUERY_LABEL("SELECT `categoryID`, `categorycode` FROM js_productcategory WHERE deleted = '0' ") or die("Unable to get Category: ".mysql_error());

		while($fetch_productitemlist = sqlFETCHARRAY_LABEL($productitemlist)) {
		$getcategoryID = $fetch_productitemlist['categoryID'];
		$getcategorycode = $fetch_productitemlist['categorycode'];		
		}
		
		return $getcategorycode;
		
	}
}
/*****************Get Sales*****************/

function get_Minisales($selected_id,$selected_date,$type){ 
	if($type== 'bill_refno') {
		$soldout_bill = sqlQUERY_LABEL("SELECT bill.billrefno,bill.cusID FROM `js_billitem` as item , js_bill as bill where item.categoryID = '$selected_id' and item.billID = bill.billID and bill.deleted = 0 and item.deleted = 0 and bill.status != '0' and bill.billdate='$selected_date'") or die("Unable to get records:".mysql_error());
		$count_today_bill = mysql_num_rows($soldout_bill);
		if($count_today_bill > 0){
				while($fetch_soldout_bill = sqlFETCHARRAY_LABEL($soldout_bill)) {
					$bill_refno .= $fetch_soldout_bill['billrefno']."--".getCUSTOMER($fetch_soldout_bill['cusID'],'label') ."<br>";
				}
		}else{
		$bill_refno  = '--';
		}
		return $bill_refno;
	}
	
	if($type== 'billitemprdt') {
		$counter = 0;
		$soldout_bill = sqlQUERY_LABEL("SELECT item.billitemprdt,item.billitemtype FROM `js_billitem` as item , js_bill as bill where item.categoryID = '$selected_id' and item.billID = bill.billID and bill.deleted = 0 and item.deleted = 0 and bill.status != '0' and bill.billdate='$selected_date' group by item.billitemprdt") or die("Unable to get records:".mysql_error());
		$count_today_sales = mysql_num_rows($soldout_bill);
		if($count_today_sales > 0){
			while($collect_sold_today = mysql_fetch_array($soldout_bill)) {
				$counter ++;
				if($counter != $count_today_sales){
				
					if($collect_sold_today['billitemtype'] == '1'){
					$stockcard_code .= getRTWStockCardCode($collect_sold_today['billitemprdt'],'label') .",";
					}elseif($collect_sold_today['billitemtype'] == '2'){
					$stockcard_code .= getMTOStockCardCode($collect_sold_today['billitemprdt'],'label') .",";
					}
				
				}
				else{
				
				if($collect_sold_today['billitemtype'] == '1'){
					$stockcard_code .= getRTWStockCardCode($collect_sold_today['billitemprdt'],'label');
					}elseif($collect_sold_today['billitemtype'] == '2'){
					$stockcard_code .= getMTOStockCardCode($collect_sold_today['billitemprdt'],'label');
					}
				}
			}
		}else{
			$stockcard_code = '--';
		}
		
		return $stockcard_code;
	}
	
	
	
	if($type== 'billitemqty') {
		$soldout_bill = sqlQUERY_LABEL("SELECT sum(item.billitemqty) as total FROM `js_billitem` as item , js_bill as bill where item.categoryID = '$selected_id' and item.billID = bill.billID and bill.deleted = 0 and item.deleted = 0 and bill.status != '0' and bill.billdate='$selected_date' group by item.billitemprdt") or die("Unable to get records:".mysql_error());
		$count_today_sales = mysql_num_rows($soldout_bill);
		if($count_today_sales > 0){
			while($collect_sold_today = mysql_fetch_array($soldout_bill)) {
				$total_qty = $collect_sold_today['total'];
				
				}
		}else{
			$total_qty  = '--';
		}
		
		return $total_qty;
	}
}	


	/***************** Customer details *****************/	
	function sales_bill_customer($customer_id, $requesttype) {

		if($requesttype == 'billtotal_cus') {

		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(billtotal) AS billed_totalpaid FROM `js_bill` where `deleted`='0' AND cusID='$customer_id'") or die("Unable to get #1: ".mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid); 

		if($collectsum_paid_list['billed_totalpaid'] > '0') {

			$billed_totalpaid= $collectsum_paid_list['billed_totalpaid'];
			return $billed_totalpaid;
			} else { 					
				return '0';				
			}		
		}

		if($requesttype == 'billdue_cus') {

		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(billbalance) AS bill_due FROM `js_bill` where `deleted`='0' AND cusID='$customer_id'") or die("Unable to get #1: ".mysql_error());
		$collectsum_paid_list = sqlFETCHARRAY_LABEL($collectsum_paid); 

		if($collectsum_paid_list['bill_due'] > '0') {

			$bill_due= $collectsum_paid_list['bill_due'];
			return $bill_due;
			} else { 					
				return '0';				
			}		
		}

		if($requesttype == 'billpaid_cus') {

		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(billpaidone) AS bill_paidone, SUM(billpaidtwo) AS bill_paidtwo, SUM(billpaidthree) AS bill_paidthree FROM `js_bill` where `deleted`='0' AND cusID='$customer_id'") or die("Unable to get #1: ".mysql_error());

		while($fetchcust_records = sqlFETCHARRAY_LABEL($collectsum_paid)){
			$bill_paidone = $fetchcust_records['bill_paidone'];
			$bill_paidtwo = $fetchcust_records['bill_paidtwo'];
			$bill_paidthree = $fetchcust_records['bill_paidthree'];

			$billpaid= $bill_paidone+$bill_paidtwo+$bill_paidthree;
		}

		return $billpaid;
	}

		if($requesttype == 'billrefno_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT `billrefno` FROM `js_bill` where `deleted`='0' AND cusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
				$collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL);

				if($collectBILL_id['billrefno'] > '0') {
					$billrefno = $collectBILL_id['billrefno'];			
					return $billrefno;
					} else { 					
						return 'N/A';				
					}
		}
		

		if($requesttype == 'billcount_cus') {

		$collectBILL = sqlQUERY_LABEL("SELECT count(billID) as bill_id FROM `js_bill` where `deleted`='0' AND cusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
			while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
				$bill_id = $collectBILL_id['bill_id'];
			}
			return $bill_id;
		}

		if($requesttype == 'billclaimcount_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT count(billID) as bill_id FROM `js_bill` where `deleted`='0' AND billclaimedcusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
				while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
					$bill_id = $collectBILL_id['bill_id'];
				}
				return $bill_id;
		}

		if($requesttype == 'billtotalcount_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT count(billID) as bill_id FROM `js_bill` where `deleted`='0' AND cusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
				while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
					$bill_id = $collectBILL_id['bill_id'];
				}

			$collectclaimBILL = sqlQUERY_LABEL("SELECT count(billID) as billclaim_id FROM `js_bill` where `deleted`='0' AND billclaimedcusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
			while($collectclaimBILL_id = sqlFETCHARRAY_LABEL($collectclaimBILL)) {
				$billclaim_id = $collectclaimBILL_id['billclaim_id'];
			}

				$billtotal_id=$bill_id+$billclaim_id;				
				return $billtotal_id;
		}

		if($requesttype == 'billclaimdue_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT SUM(billbalance) AS bill_due FROM `js_bill` where `deleted`='0' AND billclaimedcusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
				while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
					$bill_due = $collectBILL_id['bill_due'];
				}
				return $bill_due;
		}
		if($requesttype == 'claimduecount_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT count(billID) AS tot_duecount FROM `js_bill` where `deleted`='0' and `status` = '2' AND billclaimedcusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
				while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
					
					$tot_duecount = $collectBILL_id['tot_duecount'];
				}
				return $tot_duecount;
		}

		if($requesttype == 'claimpaid_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT  SUM(billpaidone) AS bill_paidone, SUM(billpaidtwo) AS bill_paidtwo, SUM(billpaidthree) AS bill_paidthree FROM `js_bill` where `deleted`='0' AND billclaimedcusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
			while($fetchcust_records = sqlFETCHARRAY_LABEL($collectBILL)){
				$bill_paidone = $fetchcust_records['bill_paidone'];
				$bill_paidtwo = $fetchcust_records['bill_paidtwo'];
				$bill_paidthree = $fetchcust_records['bill_paidthree'];
	
				$billpaid= $bill_paidone+$bill_paidtwo+$bill_paidthree;
			}
	
			return $billpaid;
		}

		if($requesttype == 'claimtotal_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT SUM(billtotal) AS billed_totalpaid FROM `js_bill` where `deleted`='0' AND billclaimedcusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
			$collectsum_paid_list = mysql_fetch_assoc($collectBILL);
				if($collectsum_paid_list['billed_totalpaid'] > '0') {

				$billed_totalpaid= $collectsum_paid_list['billed_totalpaid'];
				return $billed_totalpaid;
				} else { 					
					return '0';				
				}	
		}

		if($requesttype == 'claimldue_cus') {

			$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(billbalance) AS bill_due FROM `js_bill` where `deleted`='0' AND billclaimedcusID='$customer_id'") or die("Unable to get #1: ".mysql_error());
			$collectsum_paid_list = sqlFETCHARRAY_LABEL($collectsum_paid); 
	
			if($collectsum_paid_list['bill_due'] > '0') {
	
				$bill_due= $collectsum_paid_list['bill_due'];
				return $bill_due;
				} else { 					
					return '0';				
				}		
		}

		if($requesttype == 'claimrefno_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT `billrefno` FROM `js_bill` where `deleted`='0' AND billclaimedcusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
				$collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL);

				if($collectBILL_id['billrefno'] > '0') {
					$billrefno = $collectBILL_id['billrefno'];			
					return $billrefno;
					} else { 					
						return 'N/A';				
					}
		}
		

		if($requesttype == 'claimpaidcount_cus') {

			$collectBILL = sqlQUERY_LABEL("SELECT count(billID) AS tot_paidcount FROM `js_bill` where `deleted`='0' and `status` = '1' AND billclaimedcusID='$customer_id'") or die("Unable to get Bill Details: ".mysql_error());
				while($collectBILL_id = sqlFETCHARRAY_LABEL($collectBILL)) {
					
					$tot_paidcount = $collectBILL_id['tot_paidcount'];
				}
				return $tot_paidcount;
		}

		if($requesttype == 'billrecenttotal_cus') {

			$collectsum_paid = sqlQUERY_LABEL("SELECT billtotal FROM `js_bill` where `deleted`='0' AND cusID='$customer_id' order by billtotal DESC ") or die("Unable to get #1: ".mysql_error());
			$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid); 

			if($collectsum_paid_list['billtotal'] > '0') {

			$billtotal= $collectsum_paid_list['billtotal'];

				return $billtotal;
			} else { 
				
				return '0';
			
			}
	
		}

		if($requesttype == 'createdon_cus') {

			$collectsum_paid = sqlQUERY_LABEL("SELECT  createdon FROM `js_bill` where `deleted`='0' AND cusID='$customer_id' order by createdon DESC ") or die("Unable to get #1: ".mysql_error());
			$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid); 			

			if($collectsum_paid_list['createdon'] > '0') {

				$createdon= $collectsum_paid_list['createdon'];
				return $createdon;
				} else { 					
					return '----';				
				}	
		}
	}	

	/***************** End of Customer details *****************/	
	/*****************Get Sales*****************/

function check_printbill($selected_id,$type){ 
	if($type == 'checkbill'){
	$error_val = 0;
	$selectpo_itemlist = sqlQUERY_LABEL("select * FROM `js_billitem` where `billID`='$selected_id' and billitemtype in ('1','2') and `deleted`='0'") or die(mysql_error());
		while($fetch_productid = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
	
			$billitemprdt = $fetch_productid['billitemprdt'];
	
			$billitemqty = $fetch_productid['billitemqty'];
			
			$billitemtype = $fetch_productid['billitemtype'];
			$outletas = getoutletavailable($billitemprdt,$billitemtype);
			if($billitemqty > $outletas){
			$error_val = 1;
			}
		}
		 return $error_val;
	}
	if($type == 'checkitem'){
	$error_val = 0;
	$selectpo_itemlist = sqlQUERY_LABEL("select * FROM `js_billitem` where `billitemID`='$selected_id' and `deleted`='0'") or die(mysql_error());
		while($fetch_productid = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
	
			$billitemprdt = $fetch_productid['billitemprdt'];
	
			$billitemqty = $fetch_productid['billitemqty'];
			
			$billitemtype = $fetch_productid['billitemtype'];
			$outletas = getoutletavailable($billitemprdt,$billitemtype);
			if($billitemqty > $outletas){
			$error_val = 1;
			}
		}
		 return $error_val;
	}
}
	
/******************************************/

	/*****************Get Daily Sales*****************/


	function DailySales_REPORT($selected_id,$requesttype,$datedetails){ 

		if($requesttype == 'totalbills'){
			$selectbilllist = sqlQUERY_LABEL("select count(billID) FROM `js_bill` where `deleted`='0' and `billdate`='$datedetails'") or die(mysql_error());
			$countbill = sqlFETCHARRAY_LABEL($selectbilllist);
			return $countbill[0];
		}
		
		
		if($requesttype == 'totalpaidbills'){
			$selectbilllist = sqlQUERY_LABEL("select count(billID) FROM `js_bill` where `deleted`='0' and `billdate`='$datedetails' and status='1'") or die(mysql_error());
			$countbill = sqlFETCHARRAY_LABEL($selectbilllist);
			return $countbill[0];
		}
		
		
		if($requesttype == 'totalduebills'){
			$selectbilllist = sqlQUERY_LABEL("select count(billID) FROM `js_bill` where `deleted`='0' and `billdate`='$datedetails' and status='2'") or die(mysql_error());
			$countbill = sqlFETCHARRAY_LABEL($selectbilllist);
			return $countbill[0];
		}
		
		
		if($requesttype == 'totalunpaidbills'){
			$selectbilllist = sqlQUERY_LABEL("select count(billID) FROM `js_bill` where `deleted`='0' and `billdate`='$datedetails' and status='2' and billpaidone ='0' and billpaidtwo ='0' and billpaidthree ='0'") or die(mysql_error());
			$countbill = sqlFETCHARRAY_LABEL($selectbilllist);
			return $countbill[0];
		}
		
		
		if($requesttype == 'totalincompletebills'){
			$selectbilllist = sqlQUERY_LABEL("select count(billID) FROM `js_bill` where `deleted`='0' and `billdate`='$datedetails' and status='0'") or die(mysql_error());
			$countbill = sqlFETCHARRAY_LABEL($selectbilllist);
			return $countbill[0];
		}

		
		if($requesttype == 'totalsales'){
			$selectbilllist = sqlQUERY_LABEL("select sum(billtotal) as billtotal, sum(returnedamt) as returnedamt FROM `js_bill` where `deleted`='0' and `billdate`='$datedetails' and status != '0' and status !='3'") or die(mysql_error());
			while($fetch_sales = sqlFETCHARRAY_LABEL($selectbilllist)) {
	
			$billtotal = $fetch_sales['billtotal'];
	
			$returnedamt = $fetch_sales['returnedamt'];
			
			$total_sales = $billtotal-$returnedamt;
		}
		
		return $total_sales;
	}
	
	
		if($requesttype == 'totalreceived'){
			$selectbilllist = sqlQUERY_LABEL("select sum(billpaidone) as billpaidone, sum(billpaidtwo) as billpaidtwo, sum(billpaidthree) as billpaidthree FROM `js_bill` where `deleted`='0' and `billdate`='$datedetails' and status != '0' and status !='3'") or die(mysql_error());
			while($fetch_received = sqlFETCHARRAY_LABEL($selectbilllist)) {
	
			$billpaidone = $fetch_received['billpaidone'];
			$billpaidtwo = $fetch_received['billpaidtwo'];
			$billpaidthree = $fetch_received['billpaidthree'];

			$total_received = $billpaidone+$billpaidtwo+billpaidthree;
		}
		
		return $total_received;
	}	
	
		if($requesttype == 'totalbalance'){
			$selectbilllist = sqlQUERY_LABEL("select sum(billbalance) as billbalance FROM `js_bill` where `deleted`='0' and `billdate`='$datedetails' and status != '0' and status !='3'") or die(mysql_error());
			while($fetch_balance = sqlFETCHARRAY_LABEL($selectbilllist)) {
	
			$billbalance = $fetch_balance['billbalance'];

		}
		
		return $billbalance;
	}
	
	
	if($requesttype == 'totalcash') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' AND `receivedmode`='1' and `receiveddate`='$datedetails'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	
	if($requesttype == 'totaldebitcard') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' AND `receivedmode`='2' and `receiveddate`='$datedetails'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	if($requesttype == 'totalcreditcard') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' AND `receivedmode`='3' and `receiveddate`='$datedetails'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	if($requesttype == 'totaltrfbca') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' AND `receivedmode`='4' and `receiveddate`='$datedetails'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	if($requesttype == 'totaltrfmandiri') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' AND `receivedmode`='5' and `receiveddate`='$datedetails'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	
	if($requesttype == 'totalcheque') {
		$collectsum_paid = sqlQUERY_LABEL("SELECT SUM(receivedamount) AS receivedamount FROM `js_payment_received` WHERE `deleted`='0' AND `receivedmode`='6' and `receiveddate`='$datedetails'") or die(mysql_error());
		$collectsum_paid_list = mysql_fetch_assoc($collectsum_paid);
		$totalling_paid_amount = ($collectsum_paid_list['receivedamount']);
		
		if($totalling_paid_amount != '') {
			return $totalling_paid_amount;
		} else {
			return '0';
		}
	}
	
	
	if($requesttype== 'bill_products') {
	
		$selectbilllist = sqlQUERY_LABEL("select * FROM `js_billitem` where `deleted`='0' and `billID`='$selected_id'") or die(mysql_error());
			while($fetch_products = sqlFETCHARRAY_LABEL($selectbilllist)) {

				if($fetch_products['billitemtype'] == '1'){
				$stockcard_code .= getRTWStockCardCode($fetch_products['billitemprdt'],'label') ."<br>";
				}elseif($fetch_products['billitemtype'] == '2'){
				$stockcard_code .= getMTOStockCardCode($fetch_products['billitemprdt'],'label') ."<br>";
				}elseif($fetch_products['billitemtype'] == '3'){
				$stockcard_code .= getStichingProduct($fetch_products['billitemprdt'],'label') ."<br>";
				}elseif($fetch_products['billitemtype'] == '4'){
				$stockcard_code .= getStichingProduct($fetch_products['billitemprdt'],'label') ."<br>";
				}elseif($fetch_products['billitemtype'] == '5'){
				$stockcard_code .= $fetch_products['billitemprdt']."<br>";
				}
				
			}
			return $stockcard_code;
			
			}	
	
	}