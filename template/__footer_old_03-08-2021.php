        <footer class="footer footer-dark">
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
								<h6 class="text-white"><?php echo $footer_title;?></h6>
	            				<ul class="widget-list">
	            					<li><a href="about.html" class="text-white"><?php echo html_entity_decode($footer_description); ?></a></li>
	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-6 col-lg-3 -->
						<?php } ?>
						
	            	</div><!-- End .row -->
	            </div><!-- End .container -->
	        </div><!-- End .footer-middle -->
			
	        <div class="footer-bottom">
	        	<div class="container">
	        		<p class="footer-copyright">Copyright © 2021 RARE Fashions. All Rights Reserved.&nbsp;&nbsp;<a href="#" >Terms of use</a> | <a href="#" >Privacy Policy</a></p><!-- End .footer-copyright -->
	        		<figure class="footer-payments" style="padding: 10px;">
					
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
	        			<!--<div class="social-icons social-icons-color">
                       
                        <a href="<?php echo $facebook; ?>" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="<?php echo $twitter; ?>" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="<?php echo $instagram; ?>" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="<?php echo $pinterest; ?>" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
						</div>-->
						<div class="social-icons">
							<a href="<?php echo $facebook; ?>" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
							<a href="<?php echo $twitter; ?>" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
							<a href="<?php echo $instagram; ?>" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
							<a href="<?php echo $pinterest; ?>" class="social-icon" target="_blank" title="Pinterest"><i class="icon-pinterest"></i></a>
						</div>
	        		</figure><!-- End .footer-payments -->
	        	</div><!-- End .container -->
	        </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
   
    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li>
                        <a href="#">New in</a>
                        <ul>
                            <li><a href="#">View all</a></li>
                            <li><a href="#">Clothing</a></li>
                            <li><a href="#">Shoes</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Back in stock</a></li>
                            <li><a href="#">Trending now</a></li>
                            <li><a href="#">RARE DESIGN</a></li>
                        </ul>
                    </li>                    
                    <li>
                        <a href="#">Clothing</a>
                    </li>
                    <li>
                        <a href="#">Shoes</a>
                    </li>
                    <li>
                        <a href="#">Accessories</a>
                    </li>
                    <li>
                        <a href="#">Activewear</a>
                    </li>
                    <li>
                        <a href="#">Discover</a>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
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
                                            <label for="singin_email">Username or email address *</label>
											
                                            <input type="text" class="form-control" id="singin_email" name="singin_email" required>
											<div  class="form-text small text-muted mg-0 text-right" style="margin-top:0;"> Click here to <a href="javascript:;" onclick="sendotp_login()"   class="text-danger">Send OTP</a></div>
                                        </div><!-- End .form-group -->

                                        <div class="form-group" id="pwd_div">
                                            <label for="singin_password">Password *</label>
                                            <input type="password" class="form-control" id="singin_password" name="singin_password" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group" id="otp_div" style="display:none">
                                            <label for="otp_password" >OTP *</label>
                                            <input type="password" class="form-control"  maxlength="4" id="otp_password" name="otp_password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button id="signin_btn" type="button" onclick="sign_in();" class="btn btn-outline-primary-2">
                                                <span id="signin_pwd">LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
											<button style="display:none" id="otp_btn" type="button" onclick="verify_otp_login();" class="btn btn-outline-primary-2">
                                                <span id="signin_otp">Verify OTP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a href="#" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-g">
                                                    <i class="icon-google-plus-g"></i>
                                                    Login With Google
                                                </a>
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
                                            <label for="register_email">Your email address *</label>
                                            <input type="email" class="form-control" id="register_email" name="register_email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register_password">Password *</label>
                                            <input type="password" class="form-control" id="register_password" name="register_password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="button" onclick="signup();"  class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-g">
                                                    <i class="icon-google-plus-g"></i>
                                                    Login With Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login  btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Login With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div>
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>