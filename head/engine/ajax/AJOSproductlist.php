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

if(!isset($q)){ 
  $fetchData = sqlQUERY_LABEL("select `productID`, `producttitle`, `productsku` from js_product where deleted = '0' and status='1' order by producttitle limit 5");
}else{ 
  $fetchData = sqlQUERY_LABEL("select `productID`, `producttitle`, `productsku` from js_product where deleted = '0' and status='1' and producttitle like '%".$q."%' or  productsku like '%".$q."%' limit 5");
} 

$data = array();
while ($row = sqlFETCHARRAY_LABEL($fetchData)) {
  //control - title length
  $shorten_product_title = $row['producttitle'];
 // echo $shorten_product_title;exit();
    $shorten_product_title = str_replace("\'","'",$shorten_product_title);
  $formated_product_title = $row['productsku'].'-'.$shorten_product_title;
  $data[] = array("id"=>$row['productsku'], "text"=>$formated_product_title);
}
echo json_encode($data);