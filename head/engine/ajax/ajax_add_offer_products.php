<?php 
extract($_REQUEST);

include '../../jackus.php';

 if($type =='product_add_item'){
	//  echo "SELECT COUNT(prdt_id) as total FROM `js_offers_items`  WHERE offers_id = '$id' ";
  $list_offer_datas = sqlQUERY_LABEL("SELECT COUNT(prdt_id) as total FROM `js_offers_items`  WHERE offers_id = '$id' and prdt_id= '$prdt_id' ") or die("#1-Unable to get records:".mysql_error());

  $count_offer_list = sqlNUMOFROW_LABEL($list_offer_datas);

  while($row = sqlFETCHARRAY_LABEL($list_offer_datas)){
 
	  $total = $row["total"];
  }	 
 	 if($total == '0'){
		$prdt_name = htmlentities($prdt_name, ENT_QUOTES);
		 
		$arrFields = array('`offers_id`', '`prdt_id`', '`offers_product_code`','`offers_product_name`','`offers_product_price`');
		
		$arrValues = array("$id", "$prdt_id", "$prdt_code", "$prdt_name", "$prdt_price");

		if(sqlACTIONS("INSERT","js_offers_items",$arrFields,$arrValues, '')){
 			echo "1";
		}
	 }else{
		echo "2"; 
	 }
		
 }	
 if($type =='remove_added_item'){ 
 		 
		  $sql_where = "offers_item_id  = '$offer_id'";

		if(sqlACTIONS("DELETE","js_offers_items",'','', $sql_where )){
 			echo "success";
		}
 }	

 
?>