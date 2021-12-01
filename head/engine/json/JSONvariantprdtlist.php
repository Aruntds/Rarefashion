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
extract($_REQUEST);
include_once('../../jackus.php');

//conditioning
if(!empty($show)) {
	$showcondition = "and `status`='$show'";
}

//'`customergroup`','`customerfirst`','`customerlast`','`customeremail`','`customerdob`','`customergender`','`customerphone`','`customeraddress1`','`customeraddress2`','`customerpincode`','`customerstate`','`customercountry`','`status`'
if($parentproduct != ''){
	$filterby_product_variant = "and parentproduct = '$parentproduct'";
}
echo "{";
echo '"data":[';
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' {$showcondition} {$filterby_product_variant} order by variant_ID desc") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	  $counter++;
	  $variant_ID = $row["variant_ID"];
	  $variant_name = $row["variant_name"];
	  $variant_code = $row["variant_code"];
	  $variant_purchase_price = $row["variant_purchase_price"];
	  $variant_mrp_price = general_currency_symbol.' '.moneyFormatIndia($row["variant_mrp_price"]);
	  $variant_msp_price = general_currency_symbol.' '.moneyFormatIndia($row["variant_msp_price"]);
	  $variantstockstatus = $row["variantstockstatus"];
	  
	  if($variantstockstatus == 1) {
		$variant_instock = "In-Stock";
	  } else {
		$variant_instock = "Out of Stock";
	  }
	  
	  
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"variant_name": "'.$variant_name.'",';
			   $datas .= '"variant_code": "'.$variant_code.'",';
			   $datas .= '"variant_stock": "'.$variantstockstatus.'",';
			   $datas .= '"variant_mrp_price": "'.$variant_mrp_price.'",';
			   $datas .= '"variant_msp_price": "'.$variant_msp_price.'",';
			   $datas .= '"parentproduct": "'.$parentproduct.'",';
			   $datas .= '"modify": "'.$variant_ID.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>
