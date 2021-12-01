<?php

extract($_REQUEST);

include_once('../../jackus.php');

	if($_GET['type'] == 'record_emailnotes') {

		$dailycall_list_id = $_POST['dailycall_list_id'];
		$selected_contact_id = $_POST['contact_id'];
		$dailycall_id = $_POST['dailycall_id'];
		$email = $_POST['email'];
		$emailcc = $_POST['emailcc'];
		$emailbcc = $_POST['emailbcc'];
		$subject = $_POST['subject'];
		$template = $_POST['template'];
		$description_mail = $_POST['description_mail'];
		$follow_check = $_POST['follow_status'];
		$remainder = $_POST['remainder'];
		$customdate = dateformat_database($_POST['customdate']);
		if($follow_check == 'on') { 
			$follow_check = '1'; 
			$remainder_selected = $remainder;
			if($remainder_selected == '6') {
				$customdate_selected = $customdate;
			} else{
	
				$customdate_selected = date('Y-m-d', strtotime("+".$remainder_selected." days"));
			}
		} else { 
			$follow_check = '0'; 
			$remainder_selected = '0';
			$customdate_selected = '';
		}
		
		$notes = addslashes($description_mail);
		
	
		$arrFields=array('`dailycall_ID`','`contactID`','`dailycall_type`','`follow_check`','`email_subject`','`reminder`','`custom_date`','`notes`','`createdby`','`status`'); 
		$arrValues=array("$dailycall_id","$selected_contact_id","2","$follow_check","$subject","$remainder_selected","$customdate_selected","$notes","$logged_user_id","1"); 

		if(sqlACTIONS("INSERT","follow_contact_log",$arrFields,$arrValues,''))
		{	
			//send mail
			
				
		$email_from = getUSERNAME($logged_user_id, 'email');
		$password = getUSERNAME($logged_user_id, 'password');
		//send mail
		$message_template = $description_mail;	
		//$subject = $email_subject;
		$to = $email;
		//echo $to.$emailbcc.$emailcc; exit();
		//$to = 'suriya.tds@gmail.com';//emailcc
		$cc = $emailcc;
		$Bcc = $emailbcc;
		$from = $email_from;
		$name = 'Touchmark Descience';
		$email_from = 'suriya.tds@gmail.com';
		$password ='suriya@18';
		if (smtpmailer($to, $from, $Bcc, $name, $subject, $message_template,$email_from,$password)) {

		// echo 'Yippie, message send via Gmail';

	} else {

		 if (!smtpmailer($to, $from, $Bcc, $name, $subject, $message_template, false)) {

			 if (!empty($error)) { echo $error; }

		 }

	}
			//
		
		
		} 

?>