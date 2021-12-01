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
include_once('jackus.php');

if ($_POST['resetpassword']=='Request a new Password')
{
	$err = array();
	$msg = array();
	
	$user_email = $validation_globalclass->sanitize($_REQUEST['user_email']);

	if(!$validation_globalclass->is_email_valid($user_email)) {
		$err = "Please enter a valid email"; 
	}
	
	//check if activ code and user is valid as precaution
	if($user_email) {
		$query= "SELECT `userID` FROM js_users WHERE `useremail` = '".$user_email."'  AND `deleted` = '0'";
		$result = sqlQUERY_LABEL($query);

		$num = mysql_num_rows($result);
		if ( $num <= 0 ) { 
			$err = "Sorry no such account exists or registered.";
		}
	}
	
	if(empty($err)) {
	
	$new_pwd = GenPwd();
	$pwd_reset = PwdHash($new_pwd);
		
	//`app_users` (`au_id`, `au_username`, `au_pwd`, `au_email`, `au_package`, `activation_code`, `approved`, `au_level`, `au_last_log`, `au_createdon`, `au_ctime`, `au_ckey`, `au_banned`, `md5_id`)
	
	$rs_activ = mysql_query("update js_users set password='$pwd_reset' WHERE userID = '$logged_user_id'") or die(mysql_error());
							 
	$reset_message = 
	"<table cellspacing='5' cellpadding='0' bgcolor='#FDFAEB' style='padding: 20px; width: 100%;'>
	<tbody><tr>
	<tr bgcolor='#980065'><th style='border: 1px solid #AF187A; padding: 10px 10px 5px; color: #ffffff; margin-bottom: 5px; font-family:Arial, Helvetica, sans-serif'>Your password changed</th></tr>
	<tr bgcolor='#FFFFFF' bordercolor='#AAB9BD'>
	<td style='border: 1px solid #AAB9BD; padding: 5px 10px; font-size:12px; background-color: #fdfdfd; font-family:Arial, Helvetica, sans-serif'>
	<p>&nbsp;</p>
	<p>Hi there!</p>
	<p>You recently asked to reset your administrator account password on ".date('Y-m-d H:i:s T')."</p>
	<p>Here is the newly generated password for you, <b>".$new_pwd."</b></p>

	<p>If this was you, you can safely ignore this email.</p>
	<p>If this wan`t you, your account has been compromised.  Please send an email to $_emailto.</p>
	
	<p>See you soon on ".$_emailheading.".</p>
	
	<p>Thanks<br />
	".$_emailheading." Team</p>
	</td>
	</tr>
	<tr><td style='font-size:11px; padding:5px 0px;'>Dont Reply to this email.  This mail was sent to notify the submission to your website.</td></tr>
	</tr></tbody></table>";
	
	$mailheaders = "MIME-Version: 1.0\r\n";
	$mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$mailheaders .= "From: ".$_emailfrom."\r\n";

	//information to admin
	mail($user_email, "$_emailheading - account password reset request" ,stripslashes($reset_message), $mailheaders);
	
	?>
		<script type='text/javascript'>
			window.location = 'forgot.php?action=success&token=<?php  echo md5($activ_code); ?>&type=registration'
		</script>	
		<?php  
							 
	 }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <title><?php echo $__forgotpassword; ?> | <?php echo $_SITETITLE; ?></title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASEPATH; ?>/public/img/favicon.png">

	<!-- main header -->
	<?php include publicpath('__seo.php'); ?>
	<!-- main header ends -->

    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/ionicons/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dashforge.css">
    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dashforge.dashboard.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  </head>
  <body>


    <div class="content content-fixed content-auth-alt mg-t-20 mg-b-30">
      <div class="container d-flex justify-content-center ht-100p">
        <div class="mx-wd-300 wd-sm-450 ht-100p d-flex flex-column align-items-center justify-content-center">
          <div class="wd-80p wd-sm-300 mg-b-15"><img src="<?php echo BASEPATH; ?>/public/img/forgot.png" class="img-fluid" alt=""></div>
          <h4 class="tx-20 tx-sm-24">Reset your password</h4>
          <p class="tx-color-03 mg-b-30 tx-center">Enter your username or email address and we will send you a link to reset your password.</p>
          <form method="post" action="">
          <div class="wd-100p d-flex flex-column flex-sm-row mg-b-40">
            <input type="email" name="user_email" id="user_email" class="form-control wd-sm-250 flex-fill" placeholder="Enter username or email address">
            <button type="submit" id="resetpassword" name="resetpassword" value="Request a new Password" class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0">Send reset password email</button>
          </div>
          </form>
          <span class="tx-12 tx-color-03">I remember my account? &nbsp;<a href="index.php" class="tx-semibold">Login</a></span>

        </div>
      </div><!-- container -->
    </div><!-- content -->
        
    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- End of Footer -->
	<script type="text/javascript">
	
	<?php

		if(!empty($err)) { 
			$displayMSG_globalclass->displayMSG(0, "Invalid", $err, 'error');
		}
		
		if($action == 'success') { 
			$displayMSG_globalclass->displayMSG(1, "Success", 'We found an account associated with this email id.  You can check your INBOX for confirmation email.', 'success');
		}
		
	?>
	</script>
  </body>
</html>	