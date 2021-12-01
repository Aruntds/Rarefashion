<?php 

extract($_REQUEST);

include '../head/jackus.php';

 
$list_data_ship = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where Id='$id' and deleted = '0' and `customerID`='$logged_user_id'") or die("Unable to get records:".sqlERROR_LABEL());			
//$check_record_availabity = sqlNUMOFROW_LABEL($list_data_ship);			
$row_ships = sqlFETCHARRAY_LABEL($list_data_ship);
  $shipping_id = $row_ships["Id"];
  $ship_fname = $row_ships["ship_fname"];
  $ship_lname = $row_ships["ship_lname"];
  $ship_company = $row_ships["ship_company"];
  $ship_phone = $row_ships["ship_phone"];
  $ship_country = $row_ships["ship_country"];
  $ship_street1 = $row_ships["ship_street1"];
  $ship_street2 = $row_ships["ship_street2"];
  $ship_city = $row_ships["ship_city"];
  $ship_state = $row_ships["ship_state"];
  $ship_pin = $row_ships["ship_pin"]; 
	
$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_customer` where deleted = '0' and `user_id`='$logged_user_id'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

		while($row = sqlFETCHARRAY_LABEL($list_datas)){
		  $customeremail = $row["customeremail"];
		  $customerphone = $row["customerphone"];

		}
$data = array('fname' => $ship_fname, 'lname' => $ship_lname,  'country' => $ship_country,'street1' => $ship_street1, 'street2' => $ship_street2,'city' => $ship_city, 'state' => $ship_state, 'pin' => $ship_pin, 'email' => $customeremail, 'phone' => $ship_phone);

header('Content-Type: application/json');
echo json_encode($data);
       

?>