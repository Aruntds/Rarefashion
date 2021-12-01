<?php 

extract($_REQUEST);

include '../head/jackus.php';


			$arrFields=array('`deleted`');

			$arrValues=array("1");
			
			$sqlWhere = "wish_id = $id ";
			//echo $sqlWhere;exit();
		
		if(sqlACTIONS("UPDATE","js_wishlist",$arrFields,$arrValues, $sqlWhere)){
				
				$data = array('status' => 'Success', 'msg' => 'Updated');

		}

header('Content-Type: application/json');
echo json_encode($data);

?>