<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2020 Touchmark De`Science
*
*/
//Dont place PHP Close tag at the bottom
protectpg_includes();
if($route == 'import'){$product_session_id = session_id();}

if($upload == 'import') {
	
	$file_name      = $_FILES['csv']['name'];
	$file_type 		= $_FILES['csv']['type'];
	$file_temp_loc 	= $_FILES['csv']['tmp_name'];
	$file_error_msg = $_FILES['csv']['error'];
	$file_size 		= $_FILES['csv']['size'];
	
	/* 1. file upload handling */
	if(!$file_temp_loc) { // if not file selected
		echo "Error: please browse for a file before clicking the upload button.";
		exit();	
	} 
	if(!preg_match("/\.(csv)$/i", $file_name)) { // check file extension
		echo 'Error: your file is not CSV.';
		@unlink($file_temp_loc); // remove to the temp folder
		exit();
	}
	if($file_size > 17611165) { // file check size
		echo "Error: you file was larger than 5 Megabytes in size.";
		exit();	
	}
	if($file_error_msg == 1) { // 
		echo "Error: an error occured while processing the file, try agian.";
		exit();	
	}  
	
	$move_file = move_uploaded_file($file_temp_loc, "uploadedexcels/{$file_name}"); // temp loc, file name
	//echo $move_file;exit();
	if($move_file != true) { // if not move to the temp location
		echo 'Error: File not uploaded, try again.';
		@unlink($file_temp_loc); // remove to the temp folder
		exit();
	}

	$csvFile  = 'uploadedexcels/'.$file_name;

	$csvFileLength = filesize($csvFile);
	
	$csvSeparator = ",";
	$handle = fopen($csvFile, 'r'); 
	$flag = true;
	$count = '';

	$query='';
	$query_image='';
    $query .= "(";	
	$query_image .= "(";
	$arrFields_image=array('`productID`','`productmediagallerytype`','`productmediagalleryurl`',	'`productmediagalleryorder`', '`productmediagalleryfeatured`','`createdby`','`status`');
	$query_image .= implode(",", $arrFields_image) . ") VALUES "; 
	

$arrFields=array('`productcategory`', '`producttype`', '`productcolor`','`productmaterial`','`productsku`','`producttitle`','`productdescrption`', '`productpropertydescrption`', '`productspecialnotes`', '`productsellingprice`', '`productMRPprice`', '`productpurchaseprice`','`productyousaveprice`', '`producttaxtype`','`producttax`','`productstockstatus`','`productopeningstock`', '`productavailablestock`', '`productheight`','`productheightunit`', '`productwidth`','`productwidthunit`','`productdepth`','`productdepthunit`','`productweight`','`productweightunit`','`productrelated_show`', '`productrelated_items`', '`productupsell_show`','`productupsell_items`','`productgiftmessage`','`productgiftwrapping`','`productgiftwrappingprice`', '`productseourl`', '`productmetatitle`', '`productmetakeywords`', '`productmetadescrption`', '`productviewed`', '`createdby`','`status`');



	$query .= implode(",", $arrFields) . ") VALUES "; 
	//echo $query;exit();
$productid = getSINGLEDBVALUE('productID', "deleted = '0' and status = '1' ORDER BY productID DESC", 'js_product', 'label');

if($productid == 'N/A'){
	$productid = '1';
} else {
	++$productid;
}
	$product_id = $productid;
	
		$all_inserting_sku_code_array = [];
		$sku_code_excel_count = '0';
	while(($data = fgetcsv($handle, $csvFileLength, $csvSeparator)) !== FALSE) { // while for each row
	
	//print_r($data);die;
	
	?>
	<!--<div class="modal fade effect-scale show" id="pleasewait-loader" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="display: block;">
      <div class="modal-dialog modal-dialog-centered wd-150" role="document">
        <div class="modal-content">
          <div class="modal-body text-center">
            <div class="spinner-border wd-80 ht-80" role="status">
              <span class="sr-only">Loading...</span>
            </div>     
          <p>working on it...</p>
          </div>
        </div>
      </div>
    </div>-->
	<?php
	// echo 'A'.$csvFile; exit();
	if(!$flag) {
		$count += count($data[0]); // count imported
		
		$sku_code_excel = $data['5'];
	
		
		if(!in_array($sku_code_excel, $all_inserting_sku_code_array)){
		
		$all_inserting_sku_code_array[] = $sku_code_excel;
		
		$sku_present_or_not = getSINGLEDBVALUE('productID', "productsku = '$sku_code_excel' and deleted = '0' and status = '1'", 'js_product', 'label');
		
		/****************************
		Checking if record is empty
		****************************/
		if($sku_present_or_not == 'N/A') {
			
			$count_insert++;
			++$sku_code_excel_count;
			if($count_insert > 1 && $sku_present_or_not == 'N/A'){
		
			$query .=",";
		}
			foreach($_POST as $key => $value) {
				$data[$key] = filter($value);
				
			}
			
			$productID = $data['0'];
		
			// echo 'A'.$count;
			$present_category_product=[];
			$productcategory_title_excel = $data['1'];
			$productcategory_title = explode(',',$productcategory_title_excel);
				foreach($productcategory_title as $val_productcategory) {
					$category = trim(htmlentities($val_productcategory));
					$category_present_or_not = getSINGLEDBVALUE('categoryID', "category_code = '$category' and deleted = '0' and status = '1'", 'js_category', 'label');
					
					if($category_present_or_not != 'N/A'){
						$present_category_product[] = $category_present_or_not ;
					}
				}
			$productcategory = implode(",", $present_category_product ) ;
				//echo $productcategory; exit();
				
			$present_type_product = [];
			$producttype_title_excel = $data['2'];
			$producttype_title = explode(',',$producttype_title_excel);
				foreach($producttype_title as $val_producttype) {
					$type = trim(htmlentities($val_producttype));
					$type_present_or_not = getSINGLEDBVALUE('productfiltertypeID', "filter_type_code = '$type' and deleted = '0' and status = '1'", 'js_productfiltertype', 'label');
				
					if($type_present_or_not != 'N/A'){
						
						$present_type_product[] = $type_present_or_not ;
					}
				}
			$producttype = implode(",", $present_type_product ) ;
				
		
			$present_color_product=[];
			$productcolor_title_excel = $data['3'];
			$productcolor_title = explode(',',$productcolor_title_excel);
				foreach($productcolor_title as $val_productcolor) {
					$color = trim(htmlentities($val_productcolor));
					$color_present_or_not = getSINGLEDBVALUE('productfiltercolorID', "filter_color_code = '$color' and deleted = '0' and status = '1'", 'js_productfiltercolor', 'label');
					if($color_present_or_not != 'N/A'){
						$present_color_product[] = $color_present_or_not ;
					}
				}
			$productcolor = implode(",", $present_color_product ) ;
			
			$present_material_product=[];
			$productmaterial_title_excel = $data['4'];
			$productmaterial_title = explode(',',$productmaterial_title_excel);
				foreach($productmaterial_title as $val_productmaterial) {
					$material = trim(htmlentities($val_productmaterial));
					$material_present_or_not = getSINGLEDBVALUE('productfiltermaterialID', "filtermaterial_code = '$material' and deleted = '0' and status = '1'", 'js_productfiltermaterial', 'label');
					
					if($material_present_or_not != EMPTYFIELD){
						$present_material_product[] = $material_present_or_not ;
					}
				}
			$productmaterial = implode(",", $present_material_product ) ;
				
			$productsku = $data['5'];
			$producttitle = trim(($data['6']));
			
			if($producttitle != ''){
				
				$producttitle = addslashes($producttitle);
				$producttitle = str_replace("\n","\\n",$producttitle);
				//$prdt_slash_replaces = str_replace("\\", '', $prdt_string_replace);
				$producttitle = xml_entities($producttitle, 'Windows-1252');
				//echo$producttitle;exit();
			
			}
			
			$productdescrption = trim(($data['7']));
			if($productdescrption != ''){
			
				$prdt_string_replace = addslashes($productdescrption);
				//$prdt_slash_replace = str_replace("\\", '', $prdt_string_replace);
				$productdescrption = xml_entities($prdt_string_replace, 'Windows-1252');
				//echo$productdescrption;exit();
			}
			$productpropertydescrption = trim(($data['8']));
			if($productpropertydescrption != ''){
				$prdt_string_replace = addslashes($productpropertydescrption);
				//$prdt_slash_replace = str_replace("\\", '', $prdt_string_replace);
				$productpropertydescrption = xml_entities($prdt_string_replace, 'Windows-1252');
			}
			
			$productspecialnotes = trim(($data['9']));
			if($productspecialnotes != ''){
				$prdt_string_replace = addslashes($productspecialnotes);
				//$prdt_slash_replace = str_replace("\\", '', $prdt_string_replace);
				$productspecialnotes = xml_entities($prdt_string_replace, 'Windows-1252');
			}
			
			$productsellingprice = removenumberFORMATTING($data['10']);
			$productMRPprice = removenumberFORMATTING($data['11']);
			$productpurchaseprice = removenumberFORMATTING($data['12']);
			$productyousaveprice = removenumberFORMATTING($data['13']);
			if($productyousaveprice == ''){
				$productyousaveprice = ($productMRPprice-$productsellingprice);
			}
				
			$product_taxtype = $data['14'];
			
			if($productstockstatus =='YES'){
				$productstockstatus ='Y';
			}else{
				$productstockstatus ='N';
			}
			
		    $product_tax_value = $data['15'];
			$productstockstatus = $data['16'];
			
			if($productstockstatus =='In-Stock'){
				$productstockstatus ='1';
			}else{
				$productstockstatus ='0';
			}
			$productopeningstock = $data['17'];
			$productavailablestock = $data['18'];
			$productheight = $data['19'];
			$productheightunit = $data['20'];
			$productwidth = $data['21'];
			$productwidthunit = $data['22'];
			$productdepth = $data['23'];
			$productdepthunit = $data['24'];
			$productweight = $data['25'];
			$productweightunit = $data['26'];
			$related_productsshow = $data['27'];
			$select_relatedproducts = $data['28'];
			$upsell_productsshow = $data['29'];
			
			if($upsell_productsshow =='YES'){
				$upsell_productsshow ='1';
			}else{
				$upsell_productsshow ='0';
			}
			
			$select_upsell_products = $data['30'];
			$productgiftmessage = $data['31'];
			$productgiftwrapping = $data['32'];
			$productgiftwrappingprice = $data['33'];
			$productseourl = $data['34'];
			$productmetatitle = trim(($data['35']));
			
			if($productmetatitle != ''){
				$prdt_slash_replace = addslashes($productmetatitle);
			
				//$prdt_slash_replace = str_replace("\\", '', $prdt_string_replace);
				$productmetatitle = xml_entities($prdt_slash_replace, 'Windows-1252');
				
			}
			
			$productmetakeywords = $data['36'];
			$productmetadescrption = trim(($data['37']));
			
			if($productmetadescrption != ''){
				$prdt_slash_replace = addslashes($productmetadescrption);
				//$prdt_slash_replace = str_replace("\\", '', $prdt_string_replace);
				$productmetadescrption = xml_entities($prdt_slash_replace, 'Windows-1252');
				//echo $productmetadescrption;exit();
			}
			
			
			$productviewed = $data['38'];
			$productimagecount = $data['39'];
			$status = $data['40'];
        
			$final_data=array("$productcategory","$producttype","$productcolor","$productmaterial","$productsku","$producttitle","$productdescrption","$productpropertydescrption","$productspecialnotes","$productsellingprice","$productMRPprice","$productpurchaseprice","$productyousaveprice","$product_taxtype","$product_tax_value","$productstockstatus","$productopeningstock","$productavailablestock","$productheight", "$productheightunit", "$productwidth", "$productwidthunit", "$productdepth", "$productdepthunit", "$productweight", "$productweightunit", "$related_productsshow","$select_relatedproducts","$upsell_productsshow","$select_upsell_products","$productgiftmessage","$productgiftwrapping","$productgiftwrappingprice", "$productseourl","$productmetatitle","$productmetakeywords","$productmetadescrption","$productviewed","$logged_user_id","1");
			
			$query .= "(";
			$query .= "'" .implode("', '", $final_data) . "'";
			$query .= ")";	
					
					if($product_id == '0' && $count == '1'){
						$product_id = 1;
					} else if($product_id != '0' && $count > '1'){
						$product_id++;
					} 
						//echo$data['41'];exit();
						if($data['41'] > '0') {
							//echo"test";exit();
							for($i=1; $i<=$data['41']; $i++){
								//echo"test";exit();

								if($i == '1'){
									$productmediagalleryfeatured = '1';
								} else {
									$productmediagalleryfeatured = '0';
								}
								$productmediagallery_image = $data['5'].'-'.$i.".png";
								
								$arrValues_image=array("$product_id","1","$productmediagallery_image","$i","$productmediagalleryfeatured", "$logged_user_id","1");
				
								$query_image .= "(";
								$query_image .= "'" .implode("', '", $arrValues_image) . "'";
								$query_image .= "),";
								
							}
								
						}
			
			}//end of checking data
		 
		  }
		} 
		$flag = false;
	}

$query_image = substr($query_image, 0, -1);
$query_image .= '"';
if($sku_code_excel_count == '0'){
	echo "<script type='text/javascript'>window.location = 'product.php?code=9'</script>";
	exit();
} else if($sku_code_excel_count > '0'){
	sqlQUERY("INSERT INTO `js_product` " . $query) or die("#1-Unable to get records:".sqlERROR_LABEL());
	sqlQUERY("INSERT INTO `js_productmediagallery` " . substr($query_image, 0, -1)) or die("#1-Unable to get records:".sqlERROR_LABEL());
}

	fclose($handle);
	unlink($csvFile); // delete csv after imported

	
		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we import loading...</div>";
		
		if($count == $sku_code_excel_count){
		echo "<script type='text/javascript'>window.location = 'product.php?code=8'</script>";
		} else {
			
			echo "<script type='text/javascript'>window.location = 'product.php?code=10&product_count=$count&not_duplicate_sku=$sku_code_excel_count'</script>";
		}
		exit();
		?>
		<div class="form-group" id="process" style="display:none;">
        <div class="progress">
         <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
          <span id="process_data">0</span>
         </div>
        </div>
	   </div>

<?php
}
if($route == 'import_Variant'){$product_session_id = session_id();}

if($upload == 'import_Variant') {

		$file_name      = $_FILES['csv']['name'];
		$file_type 		= $_FILES['csv']['type'];
		$file_temp_loc 	= $_FILES['csv']['tmp_name'];
		$file_error_msg = $_FILES['csv']['error'];
		$file_size 		= $_FILES['csv']['size'];
	
		/* 1. file upload handling */
		if(!$file_temp_loc) { // if not file selected
			echo "Error: please browse for a file before clicking the upload button.";
			exit();	
		} 
		if(!preg_match("/\.(csv)$/i", $file_name)) { // check file extension
			echo 'Error: your file is not CSV.';
			@unlink($file_temp_loc); // remove to the temp folder
			exit();
		}
		if($file_size > 17611165) { // file check size
			echo "Error: you file was larger than 5 Megabytes in size.";
			exit();	
		}
		if($file_error_msg == 1) { // 
			echo "Error: an error occured while processing the file, try agian.";
			exit();	
		}  
		
		$move_file = move_uploaded_file($file_temp_loc, "uploadedexcels/{$file_name}"); // temp loc, file name
		//echo $move_file;exit();
		if($move_file != true) { // if not move to the temp location
			echo 'Error: File not uploaded, try again.';
			@unlink($file_temp_loc); // remove to the temp folder
			exit();
		}

		$csvFile  = 'uploadedexcels/'.$file_name;
		//echo$csvFile;exit();
		$csvFileLength = filesize($csvFile);
		//echo $csvFileLength;
		$csvSeparator = ",";
		$handle = fopen($csvFile, 'r'); 
		$flag = true;
		$count = '';
		$query='';
		$query .= "(";	
	
		$arrFields=array('`parentproduct`', '`variant_name`', '`variant_code`','`variant_mrp_price`','`variant_msp_price`','`variant_taxtype`','`variant_tax_value`', '`variant_taxsplit1`', '`variant_taxsplit2`', '`variant_opening_stock`', '`variant_available_stock`', '`variantstockstatus`', '`createdby`','`status`');



		$query .= implode(",", $arrFields) . ") VALUES "; 
			
		$variant_ID = getSINGLEDBVALUE('variant_ID', "deleted = '0' and status = '1' ORDER BY variant_ID DESC", 'js_productvariants', 'label');
		
		if($variant_ID == 'N/A'){
			$variant_ID = '1';
		} else {
			++$variant_ID;
		}
			$variant_ID = $variant_ID;
			
				$all_inserting_sku_code_array = [];
				$sku_code_excel_count = '0';
			
			while(($data = fgetcsv($handle, $csvFileLength, $csvSeparator)) !== FALSE) { // while for each row

       //   print_r($data);exit();
	
	?>
	
	<?php
	
	if(!$flag) {
		$count += count($data[0]); // count imported
		
		$variant_sku_code_excel = $data['3'];
		if(!in_array($variant_sku_code_excel, $all_inserting_sku_code_array)){
		$all_inserting_sku_code_array[] = $variant_sku_code_excel;
		
		$sku_present_or_not = getSINGLEDBVALUE('variant_ID', "variant_code = '$variant_sku_code_excel' and deleted = '0' and status = '1'", 'js_productvariants', 'label');
		
	
		/****************************
		Checking if record is empty
		****************************/
		if($sku_present_or_not == 'N/A') {
			
			$count_insert++;
			++$sku_code_excel_count;
			//echo $sku_code_excel_count;
			if($count_insert > 1 && $sku_present_or_not == 'N/A' ){
			$query .=",";
		}
		
			
			foreach($_POST as $key => $value) {
				$data[$key] = filter($value);
				
			}
		
			$productID = $data['0'];
			$sku_code = $data['1'];
			$Variant_sku_code = getSINGLEDBVALUE('productID', "productsku = '$sku_code' and deleted = '0' and status = '1'", 'js_product', 'label');

			if($Variant_sku_code == 'N/A'){
			$Variant_sku_code = '';
			}
					
			$Variant_sku_code = $Variant_sku_code;
				
			
			$Variant_name = $data['2'];
			//echo$Variant_name;exit();
			if($Variant_name =='Small'){
				$variant_name_size ='S';
			}elseif($Variant_name =='Medium'){
				$variant_name_size ='M';
			}elseif($Variant_name =='Large'){
				$variant_name_size ='L';
			}elseif($Variant_name =='Xtra Large'){
				$variant_name_size ='XL';
			}elseif($Variant_name =='X Xtra Large'){
				$variant_name_size ='XXL';
			}
			//echo$variant_name_size;exit();
			$variant_code      = $data['3'];
			$variant_mrp_price = $data['4'];
			$variant_msp_price = $data['5'];
			$variant_taxtype   = $data['6'];
			$variant_tax_value = $data['7'];
			
			if($variant_taxtype =='YES'){
				
				$product_taxsplit = ($variant_msp_price * ($variant_tax_value/100))/2;
				//echo $product_taxsplit;exit();
				$product_taxsplit1 = $product_taxsplit;
				$product_taxsplit2 = $product_taxsplit;
				$variant_taxtype = 'Y';
				
			}elseif($variant_taxtype =='No'){
				
				$product_taxsplit = ($variant_msp_price * ($variant_tax_value/100))/2;
				$product_taxsplit1 = $product_taxsplit;
				$product_taxsplit2 = $product_taxsplit;
				$variant_taxtype = 'N';
				
			}
			$variant_opening_stock     = $data['8'];
			$variant_available_stock   = $data['9'];
			$variantstockstatus        = $data['10'];
			
			 if($variantstockstatus =='In-Stock'){
				 $variantstockstatus='1';
			 }
        
			$final_data=array("$Variant_sku_code","$variant_name_size","$variant_code","$variant_mrp_price","$variant_msp_price","$variant_taxtype","$variant_tax_value","$product_taxsplit1","$product_taxsplit2","$variant_opening_stock","$variant_available_stock","$variantstockstatus","$logged_user_id","1");
			
			$query .= "(";
			$query .= "'" .implode("', '", $final_data) . "'";
			$query .= ")";	
					
				
			
			}//end of checking data
		 
		  }
		} 
		$flag = false;
	}


if($sku_code_excel_count == '0'){
	echo "<script type='text/javascript'>window.location = 'product.php?code=9'</script>";
	exit();
} else if($sku_code_excel_count > '0'){
//	echo"INSERT INTO `js_productvariants` " . $query;exit();
	sqlQUERY("INSERT INTO `js_productvariants` " . $query) or die("#1-Unable to get records:".sqlERROR_LABEL());

}

	fclose($handle);
	unlink($csvFile); // delete csv after imported

		//RTW Product Log			
		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we import loading...</div>";
		// echo $count == $sku_code_excel_count; exit();
		if($count == $sku_code_excel_count){
		echo "<script type='text/javascript'>window.location = 'product.php?code=8'</script>";
		} else {
			// $sku_code_excel_count += $sku_code_excel_count;
			// echo $sku_code_excel_count; exit();
			echo "<script type='text/javascript'>window.location = 'product.php?code=10&product_count=$count&not_duplicate_sku=$sku_code_excel_count'</script>";
		}
		exit();
		?>
		<div class="form-group" id="process" style="display:none;">
        <div class="progress">
         <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
          <span id="process_data">0</span>
         </div>
        </div>
	   </div>

<?php
}
?>
<div class="content">
  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
    <?php if($route == '') { ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="row row-xs mg-b-25">

        <div data-label="Example" class="df-example demo-table table-responsive">
          <table id="productLIST" class="table table-bordered">
		    <thead>
		        <tr>
		            <th class="wd-5p">S.No</th>
		            <th class="wd-15p">SKU</th>
		            <th class="wd-35p">Name</th>
		            <th class="wd-15p">Selling Price</th>
		            <th class="wd-15p">MRP Price</th>
		            <th class="wd-20p">In-Stock</th>
		            <th class="wd-20p">Available Stock</th>
		            <th class="wd-20p">Status</th>
		            <th class="wd-20p">Option</th>
		        </tr>
		    </thead>

		</table>
		</div>   	

        </div><!-- row -->
      </div><!-- col -->

    </div><!-- row -->
	
	<?php
     } else if($route=='import' && $formtype==''){ ?>
		<form id="mainform" method="post" enctype="multipart/form-data" id="import_product" action="">
			<div class="row justify-content-center">
				 <div class="col-lg-12">
				   <h3 class="form-title text-center">
						 Import Items 
					</h3>
					</div>
				<div class="col-md-6 col-lg-6 col-xl-6 mx-auto">

					<div class="card mb-4 mt-4">

						<div class="card-body">

							<div class="form-group">                                

								<div class="row">  

								 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 

									 <div class="form-group">

										   <label class="control-label">Upload your file  <span class="text-danger">*</span></label>

											  <div class="valitor">

												 <input name="csv" type="file" class="span6 m-wrap" />

												 <span class="help-block"> -Import .CSV format files only. Allowed size 5MB.<br> <a href="Sample_File_Product_import.csv">Click to download sample</a><br /></span>

											   </div>

										</div>

								 </div>

								 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 

									
								<button class="btn btn-primary buttonalign_save" type="submit" name="upload" value="import">
									<i class="fa fa-upload">&nbsp;</i> Upload
									</button>

									</button>

								   <a href="products.php?msg=success"class="btn btn-default">Return</a>

								 </div>

								</div> 

							</div>                      

						</div>

					</div>

				</div>

			</div>

		</form>
	<?php }   else if($route=='import_images' && $formtype==''){  ?>
	
		<div class="container">  
        <div class="row">  
            <div class="col-md-12">
				 <h3 class="mb-4"> Multiple Image Upload </h3>  
				<form action="ajaxupload.php" enctype="multipart/form-data" class="dropzone" id="image-upload"> 
					<div class="row justify-content-center">
						<!--<div class="text-center pt-5">  -->
						<div class="text-center">  
							   <!--<h6 class="mt-3"><img width='40px' src="https://img.icons8.com/ios/80/000000/drag-and-drop.png"/>  Drop files to attach </br></h6> <h6 class="mt-1">OR</h6> <h6 class="mt-1"><img width='40px' src='https://img.icons8.com/dotty/80/000000/upload.png'/>  Upload image by click on box</h6>-->
							   <!--<h6><img width='40px' src="https://img.icons8.com/ios/80/000000/drag-and-drop.png"/>  Drop files to attach OR<img width='40px' src='https://img.icons8.com/dotty/80/000000/upload.png'/>  Upload image by click on box</h6>-->
							</div>  

					</div>

				</form>
            </div>  
        </div>  
    </div>  
	<?php } else if($route =='import_Variant' && $formtype==''){ ?>
		<form id="mainform" method="post" enctype="multipart/form-data" id="import_product" action="">
			<div class="row justify-content-center">
				 <div class="col-lg-12">
				   <h3 class="form-title text-center">
						 Import Variant Items 
					</h3>
					</div>
				<div class="col-md-6 col-lg-6 col-xl-6 mx-auto">

					<div class="card mb-4 mt-4">

						<div class="card-body">

							<div class="form-group">                                

								<div class="row">  

								 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 

									 <div class="form-group">

										   <label class="control-label">Upload your file  <span class="text-danger">*</span></label>

											  <div class="valitor">

												 <input name="csv" type="file" class="span6 m-wrap" />

												 <span class="help-block"> -Import .CSV format files only. Allowed size 5MB.<br> <a href="variant_import_file.csv">Click to download sample</a><br /></span>

											   </div>

										</div>

								 </div>

								 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 

									
								<button class="btn btn-primary buttonalign_save" type="submit" name="upload" value="import_Variant">
									<i class="fa fa-upload">&nbsp;</i> Upload
									</button>

									</button>

								   <a href="products.php?msg=success"class="btn btn-default">Return</a>

								 </div>

								</div> 

							</div>                      

						</div>

					</div>

				</div>

			</div>

		</form>
	<?php } 





	elseif($route == 'preview') {
	

		//check if product image is added or not
		$check_productimageAVAILABLE = commonNOOFROWS_COUNT('js_productmediagallery', "`productID`='$parentproduct' and `productmediagallerytype`='1' and `createdby`='$logged_user_id'");
		
		//check if product video is added or not
		$check_productvideoAVAILABLE = commonNOOFROWS_COUNT('js_productmediagallery', "`productID`='$parentproduct' and `productmediagallerytype`='2' and `createdby`='$logged_user_id'");
		
		$list_product_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where productID='$parentproduct' and deleted = '0'") or die("#1-Unable to get records:".mysql_error());
		
		$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
		
		if($count_product_list > 0) {
		  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
			  $productID = $row["productID"];
			  $productsku = $row["productsku"];
			  $producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
			  
			  $productdescrption = htmlspecialchars_decode($row["productdescrption"]);
			  $productpropertydescrption = htmlspecialchars_decode($row["productpropertydescrption"]);
			  $productspecialnotes = htmlspecialchars_decode($row["productspecialnotes"]);

			  $productsellingprice = ($row["productsellingprice"]);
			  $productMRPprice = ($row["productMRPprice"]);
			  $productpurchaseprice = ($row["productpurchaseprice"]);
			  $productyousaveprice = ($row["productyousaveprice"]);

			  $productopeningstock = $row["productopeningstock"];
			  $productavailablestock = $row["productavailablestock"];

				$productseourl = $row['productseourl'];
				$productmetatitle = htmlentities($row['productmetatitle'], ENT_QUOTES);
				trim ($productmetatitle);
				$productmetakeywords = $row['productmetakeywords'];
				$productmetadescrption = $row['productmetadescrption'];
					  
			  $productstockstatus = $row["productstockstatus"];  //stock status
			  if($productstockstatus) {
				  $productstock_status_label = '<span class="text-success"><i class="far fa-check-circle"></i> In-Stock</span>';
			  } else {
				  $productstock_status_label = '<span class="text-danger"><i class="far fa-times-circle"></i> Out-of-Stock</span>';
			  }

			  $status = $row["status"];  //product status
			  if($status) {
				  $status_label = '<span class="text-success"><i class="far fa-check-circle"></i> Active</span>';
			  } else {
				  $status_label = '<span class="text-danger"><i class="far fa-times-circle"></i> In-Active</span>';
			  }
			  
			  $createdon = strtotime($row["createdon"]);
			  $updatedon = strtotime($row["updatedon"]);
			  
			  //check in product variant avialble
			  $check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and `parentproduct`='$productID'") or die("Unable to get records:".mysqli_error());			
			  
			  $count_productvariant_list = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
			  
		  }
			
			//check in product variant available
			if($count_productvariant_list == 0 ) {
			
				//get e-product stock details
				$get_prdt_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and `productsku`='$productsku'") or die("Unable to get records:".mysqli_error());
				$count_product_datas = sqlNUMOFROW_LABEL($get_prdt_datas);
				if($count_product_datas > 0){
					while($row = sqlFETCHARRAY_LABEL($get_prdt_datas)){

						$prdt_name = $row['producttitle'];
						$prdt_code = $row['productsku'];
						$prdt_mrp = $row['productMRPprice'];
						$prdt_msp = $row['productsellingprice'];
						$prdt_tax = $row['producttax'];
						$prdt_taxsplit1 = $row['producttax'];
					/* foreach ($characters as $character) {
						$estore_prdt_name = $character->estore_prdt_name;
						$estore_prdt_code = $character->estore_prdt_code;
						$estore_prdt_unit_price = $character->estore_prdt_unit_price;
						$estore_prdt_mrp = $character->estore_prdt_mrp;
						$estore_prdt_msp = $character->estore_prdt_msp;
						$e_store_prdt_tax = $character->e_store_prdt_tax;
						$e_store_prdt_taxsplit1 = $character->e_store_prdt_taxsplit1;
						$e_store_prdt_taxsplit2 = $character->e_store_prdt_taxsplit2;
						$e_store_prdt_gst_type = $character->e_store_prdt_gst_type;
						$final_selling_price = $estore_prdt_msp + $e_store_prdt_taxsplit1 + $e_store_prdt_taxsplit2;
						$estore_prdt_qty = $character->estore_prdt_qty;
						$estore_prdt_opening_qty = $character->estore_prdt_opening_qty;
						} */
					}
				}
			}			//end of main product stock
		?>
        
        <p class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-25">
        Created On: <em><?php echo date("d-m-Y h:i a", $createdon); ?></em> | Last Updated On: <em><?php time_stamp($updatedon); ?></em>
        </p>
        
        <div class="row">
        	<div class="col-8">
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Product Title</label>
                <h3 class="mg-b-25">
                    <?php echo $producttitle; ?>
                </h3>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Product Description</label>
                <div class="mg-b-30">
                <?php if($productdescrption) { echo html_entity_decode($productdescrption); } else { echo 'N/A'; } ?>
                </div>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Product Property</label>
                <div class="mg-b-30">
                <?php if($productpropertydescrption) { echo html_entity_decode($productpropertydescrption); } else { echo 'N/A'; } ?>
                </div>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Product Special Notes</label>
                <div class="mg-b-30">
                <?php if($productspecialnotes) { echo html_entity_decode($productspecialnotes); } else { echo 'N/A'; } ?>
                </div>
				
				<?php
				
				//check in product variant available
				if($count_productvariant_list > 0) {				
				
				?>		
				<div class="divider-text">Product Variants</div>
				<div class="table-responsive">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td class="tx-medium">S.No</td>
                        <td class="tx-medium">Variant Name</td>
						<td class="tx-medium">Stock Status</td>
                        <td class="tx-medium">Opening Stock</td>
                        <td class="tx-medium">Available Stock</td>
                        <td class="tx-medium">MRP Price</td>
                        <td class="tx-medium">Selling Price</td>
                      </tr>
					  <?php
						
						while($variant_row = sqlFETCHARRAY_LABEL($check_prdt_variant_datas)){
							$variantrow_counter++;
							$variant_ID = $variant_row["variant_ID"];
							$variant_name = $variant_row["variant_name"];							
							$variant_code = $variant_row["variant_code"];
							$variantstockstatus = $variant_row["variantstockstatus"];
							$variant_opening_stock = $variant_row["variant_opening_stock"];
							$variant_available_stock = $variant_row["variant_available_stock"];
							$variant_mrp_price = $variant_row["variant_mrp_price"];
							$variant_msp_price = $variant_row["variant_msp_price"];
							if($variantstockstatus == '1'){
								$variantstockstatus = "<span class='text-success'>Active</span>";
							} else {
								$variantstockstatus = "<span class='text-danger'>In-Active</span>";
							}
							//get e-product stock details
							/* $list_producttype_data = curl_multiple(GENERALAPIPATH_SELECT_ESTORE_PRDT_DATA, ['sku_code' => $variant_code] );

							$characters = json_decode($list_producttype_data); // decode the JSON feed

							$count_producttype_list = count($characters);
								
							if($count_producttype_list > 0){
									
								foreach ($characters as $character) {
									$estore_prdt_name = $character->estore_prdt_name;
									$estore_prdt_code = $character->estore_prdt_code;
									$estore_prdt_unit_price = $character->estore_prdt_unit_price;
									$estore_prdt_mrp = $character->estore_prdt_mrp;
									$estore_prdt_msp = $character->estore_prdt_msp;
									$e_store_prdt_tax = $character->e_store_prdt_tax;
									$e_store_prdt_taxsplit1 = $character->e_store_prdt_taxsplit1;
									$e_store_prdt_taxsplit2 = $character->e_store_prdt_taxsplit2;
									$e_store_prdt_gst_type = $character->e_store_prdt_gst_type;
									$final_selling_price = $estore_prdt_msp + $e_store_prdt_taxsplit1 + $e_store_prdt_taxsplit2;
									$estore_prdt_opening_qty = $character->estore_prdt_opening_qty;
									$estore_prdt_qty = $character->estore_prdt_qty;
								}
							}				 */	  
						?>
						  <tr>
							<td class="text-right"><?php echo $variantrow_counter; ?></td>
							<td class="text-right"><?php echo $variant_name; ?></td>
							<td class="text-right"><?php echo $variantstockstatus; ?></td>
							<td class="text-right"><?php echo $variant_opening_stock; ?></td>
							<td class="text-right"><?php echo $variant_available_stock; ?></td>
							<td class="text-right"><?php echo $variant_mrp_price; ?></td>
							<td class="text-right"><?php echo $variant_msp_price; ?></td>
						  </tr>
					  <?php
						}
					?>
                    </tbody>
                  </table>
                </div> 				
                <?php
					}  //end of variant products
				?>
				
                <div class="divider-text">SEO Information</div>
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">SEO Title</label>
                <div class="mg-b-30">
                <?php if($productmetatitle) { echo $productmetatitle; } else { echo 'N/A'; } ?>
                </div>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Meta Description</label>
                <div class="mg-b-30">
                <?php if($productmetadescrption) { echo $productmetadescrption; } else { echo 'N/A'; } ?>
                </div>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Meta Keyword</label>
                <div class="mg-b-30">
                <?php if($productmetakeywords) { echo $productmetakeywords; } else { echo 'N/A'; } ?>
                </div>

            </div>
            
            <!-- side bar -->
            <div class="col-4">
            
            	<?php if($productseourl) { ?>
                    <a href="../product.php?token=<?php echo $productID.'-'.$productsku; ?>&<?php echo $productseourl; ?>" class="btn btn-block btn-outline-warning mg-b-10" target="_blank">
                        Preview <i class="fas fa-external-link-alt"></i>
                    </a>
				<?php } ?>
            
	            <h4 class="mg-b-25">Stock</h4>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td class="tx-medium">Status</td>
                        <td class="text-right"><?php echo $status_label; ?></td>
                      </tr>
					  <?php
					  if($count_productvariant_list ==0) {
					  ?>
                      <tr>
                        <td class="tx-medium">Stock Status</td>
                        <td class="text-right"><?php echo $productstock_status_label; ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Available Stock</td>
                        <td class="text-right"><?php echo $estore_prdt_qty; ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Opening Stock</td>
                        <td class="text-right"><?php echo $estore_prdt_opening_qty; ?></td>
                      </tr>
					  <?php } ?>
                    </tbody>
                  </table>
                </div>            	

	            <h4 class="mg-b-25">Price Table</h4>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td class="tx-medium">Selling Price</td>
                        <td class="text-right"><?php echo formatCASH($productsellingprice); ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">MRP Price</td>
                        <td class="text-right"><?php echo formatCASH($productMRPprice); ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Purchase Price</td>
                        <td class="text-right"><?php echo formatCASH($productpurchaseprice); ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Customer Saves</td>
                        <td class="text-right"><?php echo formatCASH($productyousaveprice); ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                
                <h4 class="mg-b-25"></h4>
                <div class="row pd-0">
				<?php
				if($check_productimageAVAILABLE > 0) {
					
                  $productmedia_datas = sqlQUERY_LABEL("SELECT * FROM `js_productmediagallery` where productID='$productID' and productmediagallerytype='1' and deleted = '0' order by productmediagalleryorder ASC") or die("#1-Unable to get records:".mysql_error());
                
                  $count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);
                
                if($count_productmedia_availablecount > 0) {
                  while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
                      $productmediagalleryID = $row["productmediagalleryID"];
                      $productmediagalleryurl = $row["productmediagalleryurl"];
                      $productmediagalleryfeatured = $row["productmediagalleryfeatured"];
                      //image path
                      $media_path = "../uploads/productmediagallery/$productmediagalleryurl";
                      
                      //update featured icon
                      if($productmediagalleryfeatured == '1') {
                        $featured_icon_select = '<i class="icon ion-md-heart text-warning"></i>';  
                      } else {
                        $featured_icon_select = '<i class="icon ion-md-heart"></i>';  
                      }
                      
                ?>
                    <div class="col-lg-6 col-sm-6 pd-5">
                        <figure class="pos-relative mg-b-0 pd-2 wd-lg-100p">
                          <img src="<?php echo $media_path; ?>" class="img-fit-cover img-thumbnail" alt="<?php echo $orginal_producttitle; ?>">
                          <figcaption class="pos-absolute b-0 l-0 wd-100p pd-20 d-flex justify-content-center">
                            <div class="btn-group">
                              <a href="javascript:;" class="btn btn-dark btn-icon" title="Set as Default"><?php echo $featured_icon_select; ?></a>
                              <a href="<?php echo $media_path; ?>" target="_blank" class="btn btn-dark btn-icon" title="Download"><i data-feather="download"></i></a>
                            </div>
                          </figcaption>
                        </figure>   
                    </div>
                <?php } } } ?>
                </div>
                
                <?php 
				if($check_productvideoAVAILABLE > 0) {	
					//get video-id
					$productmediavideo_id = getSINGLEDBVALUE('productmediagalleryurl', "productID='$parentproduct' and productmediagallerytype=2 and status='1' and deleted=0", 'js_productmediagallery', 'label');
				
				?>
        
                  <div class="text-center mg-t-40">
                  <a href="https://www.youtube.com/watch?v=<?php echo $productmediavideo_id; ?>" target="_blank">
                  <img src="https://img.youtube.com/vi/<?php echo $productmediavideo_id; ?>/mqdefault.jpg" class="img-thumbnail mg-t-5 mg-b-10" />
                  </a>
                  </div>
               <?php } ?> 
            </div>
        </div>
        <?php
		 } else { 
		 ?>
        <h3 class="text-center">No Record Found</h3>
        <?php }
		 } 
	?>
  </div><!-- container -->
</div><!-- content -->

    <div id="offproductSUMMARY" class="off-canvas off-canvas-overlay off-canvas-right wd-300">
      <a href="#" class="close"><i data-feather="x"></i></a>

      <div class="pd-10 pd-l-20 ht-100p tx-13 mg-t-40">
          <div class="row">
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Available Stock</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0"><?php echo $productavailablestock; ?></h4>
            </div>
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Views</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0">1,800</h4>
            </div>        
            
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Stock Value</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0"><?php echo formatCASH($productsellingprice*$productavailablestock); ?></h4>
            </div>        
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Revenue</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0">2,50,750</h4>
            </div>
        
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Rating Score</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0">4.5</h4>
            </div>    
                
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Avg. Views Per Day</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0">48</h4>
            </div>
            
            <div class="col-12 align-items-baseline mg-t-10 tx-rubik">
                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Product Summary</h6>
                <ul class="activity tx-13">
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-primary-light tx-primary wd-30 ht-30">
                      <i data-feather="check-circle"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Louise</strong> added a cart</p>
                      <small class="tx-color-03">2 hours ago</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-success-light tx-success wd-30 ht-30">
                      <i data-feather="heart"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Kevin</strong> added  to the wishlist</p>
                      <small class="tx-color-03">5 hours ago</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-warning-light tx-orange wd-30 ht-30">
                      <i data-feather="shopping-cart"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Natalie</strong> purchased the product <strong>ORD #111000011</strong></p>
                      <small class="tx-color-03">8 hours ago</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-pink-light tx-pink wd-30 ht-30">
                      <i data-feather="heart"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Katherine</strong> added to wishlist</p>
                      <small class="tx-color-03">Yesterday</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-indigo-light tx-indigo wd-30 ht-30">
                      <i data-feather="settings"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Katherine</strong> purchased the product <a href="" class="link-02"><strong>ORD #111000010</strong></a></p>
                      <small class="tx-color-03">2 days ago</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                </ul><!-- activity -->
                <a href="#" class="btn btn-block btn-outline-light">View All Activities</a>
          </div>
      </div>
      
    </div><!-- off-canvas -->
    </div>