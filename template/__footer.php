<?php 

include('config.php');

$login_button = '';

?>      

	  <footer class="footer bg-gray">
            <div class="footer-middle">
                <div class="container">
                    <div class="row">
						<?php 	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_footer` where deleted = '0' order by footer_displayorder ASC") or die("Unable to get records:".mysql_error());			
						$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

						while($row = sqlFETCHARRAY_LABEL($list_datas)){
						  $footer_ID = $row["footer_ID"];
						  $footer_displayorder = $row["footer_displayorder"];
						  $footer_title = stripslashes($row["footer_title"]);
						  $footer_displaysize = $row["footer_displaysize"];
						  $footer_description = html_entity_decode($row["footer_description"]);
						  $footer_show = stripslashes($row["footer_show"]);

						  $status = $row["status"];
							if($footer_displaysize=='1'){ $display = 'col-lg-2'; }
							if($footer_displaysize=='2'){ $display = 'col-lg-4'; }
							
						?>
	            		<div class="col-md-12 <?php echo $display; ?>">
							<div class="widget">
								<h6 class="widget-title"><?php echo $footer_title;?></h6>
	            				<ul class="widget-list">
	            					<li><a href="about.php" class="text-white"><?php echo html_entity_decode($footer_description); ?></a></li>
	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-6 col-lg-3 -->
						<?php } ?>
					<div class="col-md-12 col-lg-3">
                            <div class="widget widget-newsletter">
                                <h4 class="widget-title">Sign up to newsletter</h4><!-- End .widget-title -->

                                <p>Subscribe to the Rarefashion newsletter to receive timely updates from your favorite products.</p>
                                    <div class="input-group" style="width:270px;">
									   <input type="hidden" id="session_id" class="form-control form-control-white" value="<?php echo $sid; ?> ">
                                        <input type="email" id="subscriber_email" class="form-control form-control-white" placeholder="Enter your Email Address" aria-label="Email Adress" required="">
                                        <div class="input-group-append">
                                            <button class="btn btn-dark" type="submit" onclick="subscribe()"><i class="icon-long-arrow-right"></i></button>
                                        </div><!-- .End .input-group-append -->
                                    </div><!-- .End .input-group -->
									<div id="subscribe_newsletter_msg" style="text-align: left!important"></div>
                            </div><!-- End .widget -->
                        </div>	
	            	</div><!-- End .row -->
	            <!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="footer-bottom">
                <div class="container">
                     <!-- End .footer-payments -->
                    <p class="footer-copyright">Copyright © 2019 Rarefashion. All Rights Reserved.</p><!-- End .footer-copyright -->
					<div class="social-icons">
					    <?php						
						 
							 //echo "select * FROM `js_settinggeneral` where `createdby`='$logged_id'";exit();
						 $select_itemlist = sqlQUERY_LABEL("select * FROM `js_settinggeneral` where `_generalID`='1'") or die(sqlERROR_LABEL());
							$result_count = sqlNUMOFROW_LABEL($select_itemlist);
							 while($collect_item_list = sqlFETCHARRAY_LABEL($select_itemlist)) {
								$facebook = $collect_item_list['__general_facebook'];
								$instagram = $collect_item_list['__general_instagram'];
								$twitter = $collect_item_list['__general_twitter'];
								$pinterest = $collect_item_list['__general_pintrest'];
								
							}
						 
							?>
                                    <a href="<?php echo $facebook; ?>" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                    <a href="<?php echo $twitter; ?>" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                    <a href="<?php echo $instagram; ?>" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                    <a href="<?php echo $pinterest; ?>#" class="social-icon" title="Youtube" target="_blank"><i class="icon-pinterest"></i></a>
                                </div>
                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
     
<?php 

if($currentpage == 'index.php'){
	$email = $group_limit = getSINGLEDBVALUE('useremail',"userID='$logged_user_id' and deleted='0' and `status` ='1'",'js_users','label');

	$query1 = $group_limit = getSINGLEDBVALUE('session_id',"session_id='$sid' and deleted='0'",'js_subscriber','label');
	//echo "SELECT  * FROM `js_subscriber` WHERE subscriber_email ='$email' OR session_id ='$query1' and deleted='0'";exit();
	$query= sqlQUERY_LABEL("SELECT  * FROM `js_subscriber` WHERE subscriber_email ='$email' OR session_id ='$query1' and deleted='0'")or die(sqlERROR_LABEL());
	$count_row = sqlNUMOFROW_LABEL($query);

   if($count_row == '0'){
?>
    <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="assets/images/logo-dark.png" class="logo" alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the Rarefashion newsletter to receive timely updates from your favorite products.</p>
                                <div class="input-group input-group-round" id="subscribe_popup">
                                    <input type="hidden" id="session_id" class="form-control form-control-white" value="<?php echo $sid; ?> ">
                                    <input type="email" id="subscriber_email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit" onclick="subscribe()"><span>subscriber</span></button>
                                    </div><!-- .End .input-group-append -->
                                </div><!-- .End .input-group -->
								<div class="text-danger" id="subscribe_popup_show" style="display:none;">Thank you for taking the time to Subscribe for our newsletter.</div>
									<div id="subscribe_newsletter_msg" style="text-align: left!important"></div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                 
                            </div><!-- End .custom-checkbox -->
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5">
                        <img src="assets/images/newspopup.jpg" class="newsletter-img" alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php   }}?>

     <!-- Plugins JS File -->
    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" onclick="close_popup();"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill nav-border-anim" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="#">
                                        <div class="form-group">
										<?php //print_r($_SESSION) ;?>
                                            <label for="singin_email">Username or Email Address <span style="color:red;">*</span></label>
											
                                            <input type="text" class="form-control" id="singin_email" name="singin_email" required>
											<div  id="hide_otp" class="form-text small text-muted mg-0 text-right" style="margin-top:0;"> Click here to <a href="javascript:;" onclick="sendotp_login()"   class="text-danger">Send OTP</a></div>
											<div  id="resend_otp" class="form-text small text-muted mg-0 text-right" style="margin-top:0; display:none"> Click here to <a href="javascript:;" onclick="sendotp_login()"   class="text-danger">Resend OTP</a></div>
                                        </div><!-- End .form-group -->

                                        <div class="form-group" id="pwd_div">
                                            <label for="singin_password">Password <span style="color:red;">*</span></label>
                                            <input type="password" class="form-control" id="singin_password" name="singin_password" required>
                                        </div><!-- End .form-group -->
										
										
										
                                        <div class="form-group" id="otp_div" style="display:none">
                                            <label for="otp_password" >OTP<span style="color:red;">*</span></label>
                                            <input type="password" class="form-control"  maxlength="4" id="otp_password" name="otp_password" required>
                                        </div><!-- End .form-group -->
                                          <small id='endtime_div' style="display:none">OTP Expires in - <span id='endtimer' class='text-primary' ></span></small>
                                        <div class="form-footer">
                                            <button id="signin_btn" type="button" onclick="sign_in();" class="btn btn-outline-primary-2">
                                                <span id="signin_pwd">LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
											<button style="display:none" id="otp_btn" type="button" onclick="verify_otp_login();" class="btn btn-outline-primary-2">
                                                <span id="signin_otp">Verify OTP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
											
                                           <!-- <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a onclick="forgot_password();" href="javascript:;" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
										<div class="col-sm-6">
									
												 <a href="" class="btn btn-login btn-g"><i class="icon-google-plus-g"></i>Login With Google</a>
												 <?php 
										 // $facebook_permissions = ['email']; // Optional permissions
                                        // $facebook_login_url = $facebook_helper->getLoginUrl('https://touchmarkdes.space/rarefashions/template/__dashboard.php.php', $facebook_permissions);
										
	                                                 ?>
                                            
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Login With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div>
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form >
                                        <div class="form-group">
                                            <label for="register_email">Email Address<span style="color:red;">*</span></label>
                                            <input type="email" class="form-control" id="register_email" name="register_email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register_password">Password<span style="color:red;">*</span></label>
                                            <input type="password" class="form-control" id="register_password" name="register_password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="button" onclick="signup();"  class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                         <input type="checkbox"  class="custom-control-input" name="register-policy" id="register-policy" value ="1" required>
                                                <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a><span style="color:red;">*</span></label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="" class="btn btn-login btn-g"><i class="icon-google-plus-g"></i>Register With Google</a>
												
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login  btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Register With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div>
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
					 <div id="forgot_pwd"  style="display:none">
					  <form action="#">
                                        <div class="form-group">
										<?php //print_r($_SESSION) ;?>
                                            <h3 for="singin_email">Forgot Password ?</h3>
                                            <h6  class="text-danger" id="show_error_div"></h6>
                                            <label for="singin_email">Email Address <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="forgot_email" name="forgot_email" required>
											<small id='endtime_div1' style="display:none">OTP Expires in - <span id='endtimer1' class='text-primary' ></span></small></br>
											<div style="display:none; margin-top:10px" id="send_otp" class="form-text small text-muted mg-0 text-right show" style="margin-top:0;"> Click here to <a href="javascript:;" onclick="sendotp_forgot_pwd();"   class="text-danger">Resend OTP</a></div>
                                        </div><!-- End .form-group -->

                                        <div class="form-group show" id="forget_otp" style="display:none">
                                            <label for="forgot_otp">OTP<span style="color:red;">*</span></label>
                                            <input type="password" class="form-control" id="forgot_otp" name="forgot_otp" required>
                                        </div><!-- End .form-group -->
                                         <!-- End .form-group -->

                                        <div class="form-footer">
											<button id="sendotp_btn" type="button" onclick="sendotp_forgot_pwd();" class="btn btn-outline-primary-2">
                                                <span id="signin_otp">Send OTP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
											
											<button style="display:none" id="otp_btn" type="button" onclick="verify_forgetotp_login();" class="btn btn-outline-primary-2 show">
                                                <span id="verify_otp_btn">Verify OTP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    
					 </div> 
                   	 <div id="reset_pwd" style="display:none">
					  <form action="#">
                                        <div class="form-group">
										<?php //print_r($_SESSION) ;?>
                                            <h3 for="singin_email">Reset Password </h3>
                                            <h6  class="text-danger" id="show_resterror_div"></h6>
                                            <label for="singin_email">New Password</label>
                                            <input type="password" class="form-control" id="new_pwd" name="new_pwd" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group show" id="pwd_div" >
                                            <label for="cnfm_pwd">Confirm Password</label>
                                            <input type="password" class="form-control" id="cnfm_pwd" name="cnfm_pwd" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
											<button id="sendotp_btn" type="button" onclick="reset_pwd();" class="btn btn-outline-primary-2">
											
                                                <span id="reset_otp_btn">Update Password</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
											
                                        </div><!-- End .form-footer -->
                                    </form>
                                    
					 </div> 
                   
				   </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->



 