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

if(isset($_POST["category_code"])   == $_POST["old_category_code"]) {

  	$output = array(
   'success' => true
   );

  echo json_encode($output); 
    
}elseif(isset($_POST["category_code"]))
{
	
		
     	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_category` where category_code ='$category_code' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());		
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