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

if(isset($_POST["category_name"])   == $_POST["old_category_name"]) {

  	$output = array(
   'success' => true
   );

  echo json_encode($output); 
    
}elseif(isset($_POST["category_name"]))
{
	$c_name = base64_encode($category_name);
		
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_category` where encrypt_category_name ='$c_name' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());		
	    $total_row = sqlNUMOFROW_LABEL($list_datas);			
    
 if($total_row == 0)
 {
  $output = array(
   'success' => true
  );

  echo json_encode($output);
 }
}
 

?>