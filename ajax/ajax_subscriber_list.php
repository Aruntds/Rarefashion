<?php 
extract($_REQUEST);

include '../head/jackus.php';

//$total_row = commonNOOFROWS_COUNT('js_subscriber',"subscriber_email = '$subscriber_email'");

$query = $group_limit = getSINGLEDBVALUE('subscriber_email',"subscriber_email='$subscriber_email' and deleted='0'",'js_subscriber','label');
$total_row = sqlNUMOFROW_LABEL($query);
if($total_row == 0){
	$arrFields=array('`subscriber_email`','`session_id`');

	$arrValues=array("$subscriber_email","$session_id");

	if(sqlACTIONS("INSERT","js_subscriber",$arrFields,$arrValues, '')){

		$data = array('status' => 'Success', 'msg' => 'subscribed' );

	}
} else {
	$data = array('status' => 'Failure', 'msg' => 'subscribed' );
}

header('Content-Type: application/json');
echo json_encode($data);


?>