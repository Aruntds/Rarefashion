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

//check
if( $login == 'login') {

	// Request variables are filtered
	foreach($_REQUEST as $key => $value) {
		$data[$key] = filter($value); 
	}

	$user_email = $data['inputEmail'];
	$input_password = $data['inputPassword'];
// echo "SELECT `userID`,`useremail`,`password`,`userapproved`,`roleID`,`userbanned`,`staff_id` FROM js_users WHERE `username` = '$user_email' OR `useremail` = '$user_email'  AND `deleted` = '0' AND `status` = '1'"; exit();
	$query= "SELECT `userID`,`useremail`,`password`,`userapproved`,`roleID`,`userbanned` FROM js_users WHERE `username` = '$user_email' OR `useremail` = '$user_email'  AND `deleted` = '0' AND `status` = '1'";
    $result = sqlQUERY_LABEL($query);
	$num = sqlNUMOFROW_LABEL($result);

	// Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
		while($row_pay = sqlFETCHARRAY_LABEL($result)){

			$userID = $row_pay["userID"];
			$useremail = $row_pay["useremail"];
			$password = $row_pay["password"];
			$userapproved = $row_pay["userapproved"];
			$roleID = $row_pay["roleID"];$userbanned = $row_pay["userbanned"];
			$staff_id = $row_pay["staff_id"];
		}
		//list($userID,$useremail,$password,$userapproved,$roleID,$userbanned,$staff_id) = sqlFETCHROW_LABEL($result);

		if(!$userapproved) {
    		//header("Location:?session=invalid&code=2");
    		?>
    		<script type="text/javascript">window.location = 'index.php?session=invalid&code=2' </script>
    		<?php
		 }

		if($userbanned == 1 ) {
		    //header("Location:?session=invalid&code=3");
    		?>
    		<script type="text/javascript">window.location = 'index.php?session=invalid&code=3' </script>
    		<?php
		}


		if ($password === PwdHash($input_password,substr($password,0,9))) { 
			// this sets session and logs user in 
			session_start();
			session_regenerate_id (true); //prevent against session fixation attacks.
			// this sets variables in the session 
			$_SESSION['reg_user_id']= $userID;  
			$_SESSION['reg_user_name'] = $useremail;
			$_SESSION['reg_user_level'] = $roleID;
			$_SESSION['reg_staff_id'] = $staff_id;
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	
				//update the timestamp and key for cookie
				$stamp = time();
				$ckey = GenPwd();
			
				sqlQUERY_LABEL("update js_users set `userlogtime`='$stamp', `userlogkey` = '$ckey' where userID='$id'") or die(sqlERROR_LABEL());
					
				//set a cookie 
				setcookie("reg_user_id", $_SESSION['reg_user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_level", $_SESSION['reg_user_level'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_name",$_SESSION['reg_user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				
				echo "<script type='text/javascript'>window.location = 'dashboard.php'</script>"; 
				exit();
		
		} else {
			//header("Location:?session=invalid&code=4");
    		?>
    		<script type="text/javascript">window.location = 'index.php?session=invalid&code=4' </script>
    		<?php
		}
	
		} else {
    		//header("Location:?session=invalid&code=5");
    		?>
    		<script type="text/javascript">window.location = 'index.php?session=invalid&code=5' </script>
    		<?php
	    }		
	}

?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <title><?php echo $__signin_seotitle; ?> | <?php echo $_SITETITLE; ?></title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASEPATH; ?>/public/img/favicon.png">

    <link href="<?php echo BASEPATH; ?>/public/integration/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASEPATH; ?>/public/integration/ionicons/css/ionicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dashforge.css">
    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dashforge.auth.css">
    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/erp-login.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  </head>
  <body>

	<div class="row no-gutters">
		<div class="col-md-8 bg-image-cover-style no-gutters">
			<div class="l-box d-flex">
				<div class="row">
					<p class="d-none d-md-block">&nbsp;</p>
					<div class="col-md-12 d-none d-sm-block">
						<div id="carouselExample4" class="carousel slide carousel-fade" data-ride="carousel">						
							<ol class="carousel-indicators">
							  <li data-target="#carouselExample4" data-slide-to="0" class="active"></li>
							  <li data-target="#carouselExample4" data-slide-to="1"></li>
							  <li data-target="#carouselExample4" data-slide-to="2"></li>
							</ol>
							<div class="carousel-inner">
							  <div class="carousel-item active">
								  <img src="public/img/erp-welcome-1.png" class="d-block" alt="...">							  
							  </div>
							  <div class="carousel-item">
								<img src="public/img/erp-welcome-2.png" class="d-block" alt="...">
							  </div>
							  <div class="carousel-item">
								<img src="public/img/erp-welcome-3.png" class="d-block" alt="...">
							  </div>
							</div>
						</div>
					</div>
					<!-- df-example -->

					<div class="col-md-6 col-6 text-white mobile-style">
						<h4 class="text-white">Need assistance?</h4>
						<p class="mb-0">Contact our support number: +91-9080706050</p>
					</div>
					<div class="col-md-6 col-6 text-right text-white mobile-style">
						<h4 class="text-white">Reach out to us</h4>
						<p class="mb-0">support@touchmarkdes.com</p>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-4 no-gutters">
			<div class="r-box d-flex justify-content-center align-items-center">

            <div class="col-lg-10 col-md-10 login-box">
				<p class="d-none show-inmobile">&nbsp;</p>
				<div class="col-md-12">
					<h1 class="text-white">TDS eSTORE</h1>
				</div>	
				
                <div class="col-lg-12 login-title">
					<span>Welcome back! Please signin to continue.</span>
                </div>

                <div class="col-lg-12 login-form">
					<form>
						<div class="form-group">
							<label class="form-control-label">USERNAME</label>
							<input type="text" name="inputEmail" id="inputEmail" class="form-control" placeholder="yourname@yourmail.com">
						</div>
						<div class="form-group">
							<label class="form-control-label">PASSWORD</label>
							<input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="**********">
						</div>

						<div class="col-lg-12 loginbttm">
							<div class="col-lg-6 login-btm login-text">
								<!-- Error Message -->
							</div>
							<div class="col-lg-12 login-btm login-button">
								<button type="submit" name="login" value="login" class="btn btn-outline-primary">LOGIN</button>
							</div>
						</div>
					</form>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>

			</div>
		</div>
	</div>

<?php /*
    <div class="content content-fixed content-auth">
      <div class="container">
        <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
          <div class="media-body align-items-center d-none d-lg-flex">
            <div class="mx-wd-600">
              <img src="<?php echo BASEPATH; ?>/public/img/signin.png" class="img-fluid" alt="">
            </div>
          </div><!-- media-body -->
          
          <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
            <div class="wd-100p">
              <h3 class="tx-color-01 mg-b-5">Sign In</h3>
              <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>
              
              <form method="post" action="">
              <div class="form-group">
                <label>Email address</label>
                <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="yourname@yourmail.com">
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between mg-b-5">
                  <label class="mg-b-0-f">Password</label>
                </div>
                <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="yourname@yourmail.com">
              </div>
              <button type="submit" name="login" value="login" class="btn btn-brand-02 btn-block">Sign In</button>
              </form>
            </div>
          </div><!-- sign-wrapper -->
        </div><!-- media -->
      </div><!-- container -->
    </div><!-- content -->
*/ ?>
    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- End of Footer -->
	<script type="text/javascript">
	
	<?php

		if($code == '1') { 
			$displayMSG_globalclass->displayMSG($code, "Success", 'Record created Successfully', 'success');
		}
		
		if($code == '2') { 
			$displayMSG_globalclass->displayMSG($code, "Invalid", 'Account not activated. Please check your email for activation code', 'error');
		} 
	
		if($code == '3') { 
			$displayMSG_globalclass->displayMSG($code, "Warning", 'Your account was banned by the administrator. Please contact us if you think this is a mistake.', 'warning');
		} 
	
		if($code == '4') {
			$displayMSG_globalclass->displayMSG($code, "Invalid", 'Invalid Login. Please try again with correct user email and password.', 'error');	
		}
	
		if($code == '5') {
			$displayMSG_globalclass->displayMSG($code, "Invalid", 'Invalid login. No such user exists.', 'error');	
		}
		
		if($msg == 'log_out') {
			$displayMSG_globalclass->displayMSG($code, "Success", 'You`re now logged out, see you soon.', 'success');	
		}
	
	?>
	
    </script>    
</body>
</html>