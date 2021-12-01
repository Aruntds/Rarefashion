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

//`categoryID`, `categoryparentID`, `categoryname`, `categoryimage`, `categorydescrption`, `categoryseourl`, `categorymetatitle`, `categorymetakeywords`, `categorymetadescrption`, `categorydesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_category`
$counter = '0';
echo "{";
echo '"data":[';
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_offers` where deleted = '0' order by offers_id DESC") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	 
	  $counter++;
	  $offers_id = $row["offers_id"];
	  $offers_name = $row["offers_name"];
 	  $offers_type = $row["offers_type"];
	  $status = $row["status"];
	  $offer_status = $row["offer_status"];
	  $offers_expiry_date = $row["offers_expiry_date"];
	  $offers_start_date = $row["offers_start_date"]; 
	  $expiry_date = dateformat_datepicker($offers_expiry_date);
	  $start_date = dateformat_datepicker($offers_start_date);
		   $start_date = date_create($offers_start_date);
		    
			$start_date = date_format($start_date,"d/m/Y H:i");
			$expiry_date = date_create($offers_expiry_date);
		    
			$expiry_date = date_format($expiry_date,"d/m/Y H:i");

	  $current_date =  date('Y-m-d H:i'); 
	  
	  
	   
	  if($offer_status =='0'){
		$offer_status = "<span class='text-dark'> DRAFT</span>";  
	  }elseif($status =='1'){
			$offer_status = "<span class='text-warning'>UPCOMING SALE</span>";    
	  }elseif($status =='2'){	  
			$offer_status = "<span class='text-success'> ON-SALE</span>";   
	  }elseif($status =='3'){
			$offer_status = "<span class='text-danger'>EXPIRED</span>";   
	  }
		  
	  
  	
		   $datas .= "{";	
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"offers_name": "'.$offers_name.'",';
			   $datas .= '"start_date": "'.$start_date.'",';
			   $datas .= '"expiry_date": "'.$expiry_date.'",';
			   $datas .= '"offer_status": "'.$offer_status.'",';
			   $datas .= '"modify": "'.$offers_id.'"';
			$datas .= " },";
 	 
	}
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>