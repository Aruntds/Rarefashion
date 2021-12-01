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


echo "{";
echo '"data":[';
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `menu_ID`, `menu_parentID`, `menu_name`, `menu_type`, `status` FROM `js_menu` where deleted = '0' {$showcondition} order by menu_parentID ASC") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	  $counter++;
	  $menu_ID = $row["menu_ID"];
	  $menu_name = $row["menu_name"];
	  $menu_type = $row["menu_type"];
	  $menu_parentID = $row["menu_parentID"];
	  $status = $row["status"];
	
		if($menu_parentID == '0') {
		//generated sub-category details
		$list_subcategory_datas = sqlQUERY_LABEL("SELECT `menu_ID`, `menu_parentID`, `menu_type`, `menu_name`, `status` FROM `js_menu` where deleted = '0' and `menu_parentID`='$menu_ID' {$showcondition} order by menu_parentID ASC") or die("#2-Unable to get records:".mysql_error());
		$count_subcateogry_list = sqlNUMOFROW_LABEL($list_subcategory_datas);
	
		   $datas .= "{";	
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"menu_name": "'.$menu_name.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"modify": "'.$menu_ID.'"';
			$datas .= " },";
			
		} //end of parent category check
	
		//checking sub category
		if($count_subcateogry_list > 0) {
			while($subrow = sqlFETCHARRAY_LABEL($list_subcategory_datas)){
			  $counter++;
			  $submenuID = $subrow["menu_ID"];
			  $submenu_name = $subrow["menu_name"];
			  $menu_type = $subrow["menu_type"];
			  $substatus = $subrow["status"];
			
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"menu_name": "---| '.$submenu_name.'",';
			   $datas .= '"menu_type": "'.$menu_type.'",';
			   $datas .= '"status": "'.$substatus.'",';
			   $datas .= '"modify": "'.$submenuID.'"';
		   $datas .= " },";
	
			} //end of while loop
		} //end of sub catggory - count
	}
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>