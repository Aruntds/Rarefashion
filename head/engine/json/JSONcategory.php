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
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' {$showcondition} order by categoryID ASC") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	  $counter++;
	  $categoryID = $row["categoryID"];
	  $categoryname = html_entity_decode($row["categoryname"], ENT_QUOTES, "UTF-8");
	  $categoryparentID = $row["categoryparentID"];
	  $status = $row["status"];
	
		if($categoryparentID == '0') {
		//generated sub-category details
		$list_subcategory_datas = sqlQUERY_LABEL("SELECT `categoryID`, `categoryparentID`, `categoryname`, `status` FROM `js_category` where deleted = '0' and `categoryparentID`='$categoryID' {$showcondition} order by categoryparentID ASC") or die("#2-Unable to get records:".mysql_error());
		$count_subcateogry_list = sqlNUMOFROW_LABEL($list_subcategory_datas);
	
		   $datas .= "{";	
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"categoryname": "'.$categoryname.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"modify": "'.$categoryID.'"';
			$datas .= " },";
			
		} //end of parent category check
	
		//checking sub category
		if($count_subcateogry_list > 0) {
			while($subrow = sqlFETCHARRAY_LABEL($list_subcategory_datas)){
			  $counter++;
			  $subcategoryID = $subrow["categoryID"];
			  $subcategoryname = html_entity_decode($subrow["categoryname"], ENT_QUOTES, "UTF-8");
			  $substatus = $subrow["status"];
			
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"categoryname": "---| '.$subcategoryname.'",';
			   $datas .= '"status": "'.$substatus.'",';
			   $datas .= '"modify": "'.$subcategoryID.'"';
		   $datas .= " },";
	
			} //end of while loop
		} //end of sub catggory - count
	}
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>