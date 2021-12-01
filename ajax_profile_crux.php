<?php
extract($_REQUEST);

include 'head/jackus.php';

if($new_pwd == ''){
		$arrFields=array('`username`','`useremail`');

		$arrValues=array("$cus_name","$cus_email");

		$sqlWhere= "userID = $id";

			if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues, $sqlWhere)){
			
				$query= "SELECT * FROM js_customer WHERE `user_id` = '$id' AND `deleted` = '0'";
				//echo $query;exit();
				$result = sqlQUERY_LABEL($query);
				$num = sqlNUMOFROW_LABEL($result);
				//echo $num;exit();
			
	
			if($num > 0){
				
			$arrFields1=array('`customerfirst`','`customeraddress1`','`customeraddress2`');

			$arrValues1=array("$cus_name","$customeraddress1","$customeraddress2");

			$sqlWhere1= "user_id = $id";

				if(sqlACTIONS("UPDATE","js_customer",$arrFields1,$arrValues1, $sqlWhere1)){
					$data = array('status' => 'Success', 'msg' => 'Updated');
				}
	
			}else{

			$arrFields2=array('`user_id`','`customerfirst`','`customeraddress1`','`customeraddress2`');
			
			$arrValues2=array("$id","$cus_name","$customeraddress1","$customeraddress2");

				if(sqlACTIONS("INSERT","js_customer",$arrFields2,$arrValues2, '')){
					$data = array('status' => 'Success', 'msg' => 'Inserted');
				}	
			}	
				
			//$data = array('status' => 'Success', 'msg' => 'Updated');

			}
}else{

	if($new_pwd == $confirm_pwd){

		$password = PwdHash($new_pwd,substr($password,0,9));

		$arrFields=array('`username`','`useremail`','`password`');

		$arrValues=array("$cus_name","$cus_email","$password");

		$sqlWhere= "userID = $id";

			if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues, $sqlWhere)){

			$data = array('status' => 'Success', 'msg' => 'Password is Correct');

			}
	}else{
	$data = array('status' => 'Incorrect', 'msg' => 'Password is Incorrect');
	}
}

header('Content-Type: application/json');
echo json_encode($data);
			
// echo $old_password; exit();	
			
//Insert for Customer Address

?>

