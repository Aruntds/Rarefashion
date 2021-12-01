<?php 
extract($_REQUEST);

include '../../jackus.php';



//$useremail = $_POST['useremail'];
// $email2 = $_POST['email1'];
// $password2 = $_POST['password1'];
// $contact2 = $_POST['contact1'];


	echo $password;
	
	
	/* $time_from = date('h:i:s',$time_from);
	$time_to = date('h:i:s',$time_to); */
	
	$arrFields = array('`_generalID`', '`_smtp_hostname`', '`_smtp_useremail`', '`_smtp_password`', '`smtp`', '`_smtpport`',);

	$arrValues = array("1", "$username", "$useremail", "$password", "$smtp", "$port",);

	$sqlWhere = "_generalID = '1'";
	return sqlACTIONS("UPDATE","js_settinggeneral",$arrFields,$arrValues, $sqlWhere);
	

header('Content-Type: application/json');
echo json_encode($data);


?>