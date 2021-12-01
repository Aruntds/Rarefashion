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
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_footerone` where deleted = '0' {$showcondition} order by footeroneorder ASC") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	  $counter++;
	  $footeroneID = $row["footeroneID"];
	  $footeronetitle = $row["footeronetitle"];
	  $status = $row["status"];
	

	   $datas .= "{";
		   $datas .= '"count": "'.$counter.'",';
		   $datas .= '"footeronetitle": "'.$footeronetitle.'",';
		   $datas .= '"status": "'.$status.'",';
		   $datas .= '"modify": "'.$footeroneID.'"';
	   $datas .= " },";
	
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>