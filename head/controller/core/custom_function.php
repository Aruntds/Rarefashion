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

//license validity
/*$response = array('manager'=> $logged_user_id, 'url'=> APIACCESSPATH, 'lastchecked'=> date('Y-m-d H:i:s'), 'nextupdate' => date('Y/m/d', strtotime("+7 days")));

$fp = fopen('../composer.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);

$readjson = file_get_contents('../composer.json') ;
$data = json_decode($readjson, true);  //Decode JSON
echo $data["manager"].', '.$data["url"].', '.$data["lastchecked"].', '.$data["nextupdate"];
exit();

if($checklicense == '1') {
	
	$sitekey_status = $composer_VALIDATELICENSE->LICENSEVALID('0', 'LICENSE_SITE_KEY', $accessaccess_auth, $logged_user_id);
	$accesskey_status = $composer_VALIDATELICENSE->LICENSEVALID('1', 'LICENSE_ACCESS_KEY', $accessaccess_auth, $logged_user_id);
	
	if($sitekey_status != '1' || $accesskey_status != '1') {
		echo $__licenseexpirymessage;
		exit();
	}
	
}*/

//common button removing style
function removeADDBTN($action) {
	if($action == 'add' || $action == 'update') { 
		return 'style="display: none;"';
	}
}

//page Refresh
function pageREFRESH($fullpageURL, $label) {
	echo '<a href="'.$fullpageURL.'" class="btn btn-xs btn-dark btn-icon"><i data-feather="refresh-ccw"></i> <span class="text-hide-xs">'.$label.'</span></a>';	
}

//page Refresh
function pageCANCEL($pageNAME, $label) {
	echo '<a href="'.$pageNAME.'" class="btn btn-secondary" type="cancel">'.$label.'</a>';	
}

//stripping status title
function statusLABEL($status_span, $label_type) {
	if($label_type == 'class') {
		return $status_span = strafter($status_span, '/');
	}
	if($label_type == 'value') {
		return $status_span = strbefore($status_span, '/');
	}
}//check logged user id and outlet id

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

//display settings - category
/*
<option value="1" selected>Product List Only</option>
<option value="2">Content Only</option>
<option value="3">Product & Content Only</option>
*/
function customCATEGORYDISPLAYSETTINGS($selected_status_id, $requesttype) {

	/*****************  SELECT OPTION   *****************/	
	if($requesttype == 'select') { ?>
		 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > Product List Only </option>
		 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > Content Only </option>
		 <option value='3' <?php if($selected_status_id=='3') { echo "selected"; } ?> > Product & Content Only </option>
		 <?php
	 }

	/*****************  LABEL OPTION   *****************/	

	if($requesttype == 'label') {
		if($selected_status_id == '1') {
			return  'Product List Only';
		}
		
		if($selected_status_id == '2') {
			return  'Content Only';
		}
		
		if($selected_status_id == '3') {
			return  'Product & Content Only';
		}
	}
}

function customCONTENTDISPLAYSETTINGS($selected_status_id, $requesttype) {

	/*****************  SELECT OPTION   *****************/	
	if($requesttype == 'select') { ?>
		 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > No Sidebar </option>
		 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > With Sidebar </option>
		 <?php
	 }

	/*****************  LABEL OPTION   *****************/	

	if($requesttype == 'label') {
		if($selected_status_id == '1') {
			return  'No Sidebar';
		}
		
		if($selected_status_id == '2') {
			return  'With Sidebar';
		}
	}
}

/****************** Get Common Units - detail ****************/
function getproductCOMMONUNITS($selected_unit_type, $selected_unit_id, $requesttype) {
	
	//`productunitsID`, `productunitstype`, `productunitstitle`, `productunitsstatus` FROM `js_productunits`
	/*****************  SELECT OPTION   *****************/
	if($requesttype == 'select') {
		 $getproductunit_query = sqlQUERY_LABEL("SELECT `productunitsID`, `productunitstitle` FROM `js_productunits` where `productunitstype`='$selected_unit_type' order by productunitsID ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		 echo '<option value="">--</option>';
		 while($getproductunit_fetch = sqlFETCHARRAY_LABEL($getproductunit_query)) {
				$productunitsID = $getproductunit_fetch['productunitsID'];
				$productunitstitle = $getproductunit_fetch['productunitstitle'];
			 ?>
			 <option value='<?php echo $productunitsID; ?>' <?php if($selected_unit_id==$productunitsID) { echo "selected"; } ?> >
				<?php echo $productunitstitle; ?>
			 </option>
			 <?php
		 }
	}

	/*****************  SELECT OPTION   *****************/
	if($requesttype == 'label') {
		 $getproductunit_query = sqlQUERY_LABEL("SELECT `productunitstitle` FROM `js_productunits` where `productunitsID`='$selected_unit_id' and `productunitstype`='$selected_unit_type'") or die("#STATUS-LABEL: Getting Status: ".sqlERROR_LABEL());
		 while($getproductunit_fetch = sqlFETCHARRAY_LABEL($getproductunit_query)) {
				$productunitstitle = $getproductunit_fetch['productunitstitle'];
				return $productunitstitle;
		 }
	}
	
}
/****************** End of Common Units - detail ****************/

/****************** Get Product Filter Type - detail ****************/
function getproductFILTERTYPE($selected_filtertype_id, $reason, $requesttype) {
	/*****************  SELECT OPTION   *****************/
	if($requesttype == 'select' && $reason=='') {
		
		 $getproductfiltertype_query = sqlQUERY_LABEL("SELECT `productfiltertypeID`, `productfiltertypetitle` FROM `js_productfiltertype` where `status`='1' and `deleted`='0' order by productfiltertypetitle ASC") or die("#FILTERTYPE-SELECT: Getting Record: ".sqlERROR_LABEL());
		 echo '<option value="">--</option>';
		 while($getproductfiltertype_fetch = sqlFETCHARRAY_LABEL($getproductfiltertype_query)) {
				$productfiltertypeID = $getproductfiltertype_fetch['productfiltertypeID'];
				$productfiltertypetitle = $getproductfiltertype_fetch['productfiltertypetitle'];
			 ?>
			 <option value='<?php echo $productfiltertypeID; ?>' <?php if($selected_filtertype_id==$productfiltertypeID) { echo "selected"; } ?> >
				<?php echo $productfiltertypetitle; ?>
			 </option>
			 <?php
		 }
	} else {
		//multiselect
		$prdt_filtertype_id = explode(",", $selected_filtertype_id);

		 $getproductfiltertype_query = sqlQUERY_LABEL("SELECT `productfiltertypeID`, `productfiltertypetitle` FROM `js_productfiltertype` where `status`='1' and `deleted`='0' order by productfiltertypetitle ASC") or die("#FILTERTYPE-SELECT: Getting Record: ".sqlERROR_LABEL());
		 // echo '<option value="">--</option>';
		 while($getproductfiltertype_fetch = sqlFETCHARRAY_LABEL($getproductfiltertype_query)) {
				$productfiltertypeID = $getproductfiltertype_fetch['productfiltertypeID'];
				$productfiltertypetitle = $getproductfiltertype_fetch['productfiltertypetitle'];

				if(in_array($productfiltertypeID,$prdt_filtertype_id)) $str_filtertype = "selected"; else $str_filtertype="";
			 ?>
			 <option value='<?php echo $productfiltertypeID; ?>' <?php echo $str_filtertype; ?>>
				<?php echo $productfiltertypetitle; ?>
			 </option>
			 <?php
		 }

	}

	/*****************  SELECT OPTION   *****************/
	if($requesttype == 'label') {
		 $getproductfiltertype_query = sqlQUERY_LABEL("SELECT `productfiltertypetitle` FROM `js_productfiltertype` where `productfiltertypeID`='$selected_filtertype_id'") or die("#FILTERTYPE-LABEL: Getting Status: ".sqlERROR_LABEL());
		 while($getproductfiltertype_fetch = sqlFETCHARRAY_LABEL($getproductfiltertype_query)) {
				$productfiltertypetitle = $getproductfiltertype_fetch['productfiltertypetitle'];
				return $productfiltertypetitle;
		 }
	}
	
}
/****************** End of Product Filter Type - detail ****************/

/****************** Get Product Filter Color - detail ****************/
function getproductFILTERCOLOR($selected_filtercolor_id, $reason, $requesttype) {
	
	/*****************  SELECT OPTION   *****************/
	if($requesttype == 'select' && $reason=='') {
		 $getproductfiltercolor_query = sqlQUERY_LABEL("SELECT `productfiltercolorID`, `productfiltercolortitle` FROM `js_productfiltercolor` where `status`='1' and `deleted`='0' order by productfiltercolortitle ASC") or die("#FILTERCOLOR-SELECT: Getting Record: ".sqlERROR_LABEL());
		 echo '<option value="">--</option>';
		 while($getproductfiltercolor_fetch = sqlFETCHARRAY_LABEL($getproductfiltercolor_query)) {
				$productfiltercolorID = $getproductfiltercolor_fetch['productfiltercolorID'];
				$productfiltercolortitle = $getproductfiltercolor_fetch['productfiltercolortitle'];
			 ?>
			 <option value='<?php echo $productfiltercolorID; ?>' <?php if($selected_filtertype_id==$productfiltercolorID) { echo "selected"; } ?> >
				<?php echo $productfiltercolortitle; ?>
			 </option>
			 <?php
		 }
	} else {
		//multiselect
		$prdt_filtercolor_id = explode(",", $selected_filtercolor_id);

		 $getproductfiltercolor_query = sqlQUERY_LABEL("SELECT `productfiltercolorID`, `productfiltercolortitle` FROM `js_productfiltercolor` where `status`='1' and `deleted`='0' order by productfiltercolortitle ASC") or die("#FILTERCOLOR-SELECT: Getting Record: ".sqlERROR_LABEL());
		 echo '<option value="">--</option>';
		 while($getproductfiltercolor_fetch = sqlFETCHARRAY_LABEL($getproductfiltercolor_query)) {
				$productfiltercolorID = $getproductfiltercolor_fetch['productfiltercolorID'];
				$productfiltercolortitle = $getproductfiltercolor_fetch['productfiltercolortitle'];

				if(in_array($productfiltercolorID,$prdt_filtercolor_id)) $str_filtercolor = "selected"; else $str_filtercolor="";
			 ?>
			 <option value='<?php echo $productfiltercolorID; ?>' <?php echo $str_filtercolor; ?>>
				<?php echo $productfiltercolortitle; ?>
			 </option>
			 <?php
		 }

	}

	/*****************  SELECT OPTION   *****************/
	if($requesttype == 'label') {
		 $getproductfiltercolor_query = sqlQUERY_LABEL("SELECT `productfiltercolortitle` FROM `js_productfiltercolor` where `productfiltercolorID`='$selected_filtertype_id'") or die("#FILTERCOLOR-LABEL: Getting Status: ".sqlERROR_LABEL());
		 while($getproductfiltercolor_fetch = sqlFETCHARRAY_LABEL($getproductfiltercolor_query)) {
				$productfiltercolortitle = $getproductfiltercolor_fetch['productfiltercolortitle'];
				return $productfiltercolortitle;
		 }
	}
	
}
/****************** End of Product Filter Color - detail ****************/

/****************** Get Product Filter Material - detail ****************/
function getproductFILTERMATERIAL($selected_filtermaterial_id, $reason, $requesttype) {
	
	/*****************  SELECT OPTION   *****************/
	if($requesttype == 'select' && $reason=='') {
		 $getproductfiltermaterial_query = sqlQUERY_LABEL("SELECT `productfiltermaterialID`, `productfiltermaterialtitle` FROM `js_productfiltermaterial` where `status`='1' and `deleted`='0' order by productfiltermaterialtitle ASC") or die("#FILTERTYPE-SELECT: Getting Record: ".sqlERROR_LABEL());
		 echo '<option value="">--</option>';
		 while($getproductfiltermaterial_fetch = sqlFETCHARRAY_LABEL($getproductfiltermaterial_query)) {
				$productfiltermaterialID = $getproductfiltermaterial_fetch['productfiltermaterialID'];
				$productfiltermaterialtitle = $getproductfiltermaterial_fetch['productfiltermaterialtitle'];
			 ?>
			 <option value='<?php echo $productfiltermaterialID; ?>' <?php if($selected_filtermaterial_id==$productfiltermaterialID) { echo "selected"; } ?> >
				<?php echo $productfiltermaterialtitle; ?>
			 </option>
			 <?php
		 }
	} else {
		//multiselect
		$prdt_filtermaterial_id = explode(",", $selected_filtermaterial_id);

		 $getproductfiltermaterial_query = sqlQUERY_LABEL("SELECT `productfiltermaterialID`, `productfiltermaterialtitle` FROM `js_productfiltermaterial` where `status`='1' and `deleted`='0' order by productfiltermaterialtitle ASC") or die("#FILTERTYPE-SELECT: Getting Record: ".sqlERROR_LABEL());
		 echo '<option value="">--</option>';
		 while($getproductfiltermaterial_fetch = sqlFETCHARRAY_LABEL($getproductfiltermaterial_query)) {
				$productfiltermaterialID = $getproductfiltermaterial_fetch['productfiltermaterialID'];
				$productfiltermaterialtitle = $getproductfiltermaterial_fetch['productfiltermaterialtitle'];
				
				if(in_array($productfiltermaterialID,$prdt_filtermaterial_id)) $str_filtermaterial = "selected"; else $str_filtermaterial="";
				
			 ?>
			 <option value='<?php echo $productfiltermaterialID; ?>' <?php echo $str_filtermaterial; ?>>
				<?php echo $productfiltermaterialtitle; ?>
			 </option>
			 <?php
		 }

	}

	/*****************  SELECT OPTION   *****************/
	if($requesttype == 'label') {
		 $getproductfiltermaterial_query = sqlQUERY_LABEL("SELECT `productfiltermaterialtitle` FROM `js_productfiltermaterial` where `js_productfiltermaterialID`='$selected_filtermaterial_id'") or die("#FILTERTYPE-LABEL: Getting Status: ".sqlERROR_LABEL());
		 while($getproductfiltermaterial_fetch = sqlFETCHARRAY_LABEL($getproductfiltermaterial_query)) {
				$productfiltertypetitle = $getproductfiltermaterial_fetch['productfiltermaterialtitle'];
				return $productfiltertypetitle;
		 }
	}
	
}
/****************** End of Product Filter Type - detail ****************/

/****************** Get Frontpage Settings Category Filter - detail ****************/
function customFRONTPAGECATALOGUESETTINGS($selected_status_id, $requesttype) {

	/*****************  SELECT OPTION   *****************/	
	if($requesttype == 'select') { ?>
		 <option value='1' <?php if($selected_status_id=='1') { echo "selected"; } ?> > by Names </option>
		 <option value='2' <?php if($selected_status_id=='2') { echo "selected"; } ?> > by Created On </option>
		 <option value='3' <?php if($selected_status_id=='3') { echo "selected"; } ?> > by Popularity </option>
		 <?php
	 }

	/*****************  LABEL OPTION   *****************/	

	if($requesttype == 'label') {
		if($selected_status_id == '1') {
			return  'producttitle ASC'; //'by Created On'
		}
		
		if($selected_status_id == '2') {
			return  'createdon DESC'; //'by Popularity'
		}
		
		if($selected_status_id == '3') {
			return  'productviewed DESC'; //'by Names'
		}
	}
}