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
//Dont place PHP Close tag at the bottom
protectpg_includes();

//Update
if( $save == "update" && $id != '') {

	//$customergrouptitle = $validation_globalclass->sanitize(ucwords($_REQUEST['customergrouptitle']));
	$header_image = htmlentities($_REQUEST['header_image']);
	trim ($header_image);

	
		//Insert query
		$arrFields=array('`from_name`','`from_address`','`header_image`','`footer_text`','`status`');
		$arrValues=array("$from_name","$from_address","$header_image","$footer_text","$status");

		$sqlWhere= "id=$id";

		if(sqlACTIONS("UPDATE","js_email_header_footer",$arrFields,$arrValues, $sqlWhere)) {
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
			if( $save == "save"	) {
			?>
			  <script type="text/javascript">window.location = 'emailnotification.php?route=add&code=2' </script>
			<?php
			//header("Location:category.php?route=add&code=1");
			} else {
			?>
			  <script type="text/javascript">window.location = 'emailnotification.php?code=2' </script>
			<?php
			//header("Location:category.php?code=1");
			}		
			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

}
?>


 


    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
	  
	  <?php if($route ==""){?>
	  
	  
	  <div class="content">
              <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
                <div class="row">
                  <div class="col-lg-9">
                    <div class="row row-xs mg-b-25">
        
                    <div data-label="Example" class="df-example demo-table table-responsive">
                      <table id="emailtemplate" class="table table-bordered">
                        <thead>
                            <tr>
                         
                                <th class="wd-20p">Email</th>
                                <th class="wd-10p">Content Type</th>
                                <th class="wd-10p">Recipient(s)</th>
                                <th class="wd-10p">Custom Message</th>
                            </tr>
                        </thead>
                   
					 <tbody>
					   <?php
					
					  $select_itemlist = sqlQUERY_LABEL("select * FROM `js_email_notification`") or die(sqlERROR_LABEL());
								$result_count = sqlNUMOFROW_LABEL($select_itemlist);
								 while($collect_item_list = sqlFETCHARRAY_LABEL($select_itemlist)) {
									?>
								<tr>
                                  <td><?php echo $collect_item_list['email_values']; ?></td>
                                  <td><?php echo $collect_item_list['addtional_content']; ?></td>
                                  <td><?php echo $collect_item_list['recipient']; ?></td>
                                  <td><?php echo '<a href="emailnotification.php?route=edit&id='. $collect_item_list['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';?></td>
							    </tr>
									<?php
								}
            ?>
              
          
            </tbody>
					
					 </table>
					
			   </div>

            </div><!-- row -->
          </div><!-- col -->


        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->

	  
        <div class="row">
          <div class="col-lg-9">
            <div class="mg-b-25">
				
				   <?php
						$select_itemlist = sqlQUERY_LABEL("select `createdby` FROM `js_settinggeneral` where `deleted`='0'") or die(sqlERROR_LABEL());
						$result_count = sqlNUMOFROW_LABEL($select_itemlist);
						 while($collect_item_list = sqlFETCHARRAY_LABEL($select_itemlist)) {
							$logged_id = $collect_item_list['createdby'];
						 }
						 
						 //echo "select * FROM `js_settinggeneral` where `createdby`='$logged_id'";exit();
						 $select_itemlist = sqlQUERY_LABEL("select * FROM `js_email_header_footer`") or die(sqlERROR_LABEL());
								$result_count = sqlNUMOFROW_LABEL($select_itemlist);
								 while($collect_item_list = sqlFETCHARRAY_LABEL($select_itemlist)) {
									$id = $collect_item_list['id'];
									$from_name = $collect_item_list['from_name'];
									$from_address = $collect_item_list['from_address'];
									$header_image = $collect_item_list['header_image'];
									$footer_text = $collect_item_list['footer_text'];
									$status = $collect_item_list['status'];
									//$port = $collect_item_list['_smtpport'];
								}
						 
                 	?>
							
							
				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<p class="text-muted">Last Updated on : Few Seconds Ago</p>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
					
				      <button type="submit" name="save" value="update" class="btn btn-warning">Update</button>
					  <input type="hidden" name="id" value="<?php echo $id; ?>" />
				    </button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Basic Info</div>
		
		
		           <div class="form-group row">
						<label for="status" class="col-sm-4 col-form-label"><?php echo $__status ;?></label>
						<div class="col-sm-8">
							<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" name="status" id="status" value="1" <?php if($status == '1') { echo 'checked=""'; } ?>>
								  <label class="custom-control-label" for="status">Yes</label>
							</div>

						</div>
				  </div>
				  <h2>Email sender options</h2>
				  <div class="form-group row">
				    <label for="from_name" class="col-sm-4 col-form-label"><?php echo $__from_name ;?><span class="text-danger">*</span><span class="woocommerce-help-tip" data-tip="How the sender name appears in outgoing  emails."></span></label>
					
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="from_name" id="from_name" placeholder="From Name" value="<?php echo $from_name;?>" required data-parsley-error-message="Please Enter From name">
				    </div>
				  </div>
				  
				   <div class="form-group row">
				    <label for="from_address" class="col-sm-4 col-form-label"><?php echo $__from_address ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="from_address" id="from_address" placeholder="From Address" value="<?php echo $from_address;?>" required data-parsley-error-message="Please Enter From address">
				    </div>
				  </div>
				  
				   <h2>Email template</h2><div id="email_template_options-description"><p>This section lets you customize the  emails. <a href="<?php echo BASEPATH; ?>emailnodification.php?route=preview" target="_blank">Click here to preview your email template</a>.</p>
                        </div>
				  
				  
				  
				  <div class="form-group row">
				    <label for="header_image" class="col-sm-4 col-form-label"><?php echo $__header_image ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="header_image" id="header_image" placeholder="Please Enter Header Image" value="<?php echo $header_image;?>" required data-parsley-error-message="Please Enter Header Image">
				    </div>
				  </div>
				  
				   <div class="form-group row">
				    <label for="footer_text" class="col-sm-4 col-form-label"><?php echo $__footer_image ;?></label>
				    <div class="col-sm-8">
				      <textarea class="form-control" rows="4" cols="40" name="footer_text" id="footer_text" placeholder="Footer Text"><?php echo $footer_text;?></textarea> 
				    </div>
				  </div>
				  
				 
				
			</div>
				<!-- End of BASIC -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $smtpconfig_sidebar_view_type='create';
	          include viewpath('__smtpconfigsidebar.php'); 
          ?>

        </div><!-- row -->
	  <?php } if($route == 'preview'){?>
	  <div id="wrapper" dir="ltr" style="background-color: #f7f7f7; margin: 0; padding: 70px 0; width: 100%; -webkit-text-size-adjust: none;">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td align="center" valign="top">
						<div id="template_header_image">
													</div>
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color: #ffffff; border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); border-radius: 3px;">
							<tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" style='background-color: #96588a; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; border-radius: 3px 3px 0 0;'>
										<tr>
											<td id="header_wrapper" style="padding: 36px 48px; display: block;">
												<h1 style='font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #ab79a1; color: #ffffff; background-color: inherit;'>HTML email template</h1>
											</td>
										</tr>
									</table>
									<!-- End Header -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
										<tr>
											<td valign="top" id="body_content" style="background-color: #ffffff;">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%">
													<tr>
														<td valign="top" style="padding: 48px 48px 32px;">
															<div id="body_content_inner" style='color: #636363; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;'>
																<p style="margin: 0 0 16px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
																<p style="margin: 0 0 16px;"><a class="link" href="#" style="font-weight: normal; text-decoration: underline; color: #96588a;">Sed sit amet sapien odio</a></p>
																<p style="margin: 0 0 16px;">Phasellus quis varius augue. Fusce eu euismod leo, a accumsan tellus. Quisque vitae dolor eu justo cursus egestas. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sit amet sapien odio. Sed pellentesque arcu mi, quis malesuada lectus lacinia et. Cras a tempor leo.</p>
																<h2 style='color: #96588a; display: block; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;'>Lorem ipsum dolor</h2>
																<p style="margin: 0 0 16px;">Fusce eu euismod leo, a accumsan tellus. Quisque vitae dolor eu justo cursus egestas. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sit amet sapien odio. Sed pellentesque arcu mi, quis malesuada lectus lacinia et. Cras a tempor leo.</p>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						<!-- Footer -->
						<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
							<tr>
								<td valign="top" style="padding: 0; border-radius: 6px;">
									<table border="0" cellpadding="10" cellspacing="0" width="100%">
										<tr>
											<td colspan="2" valign="middle" id="credit" style='border-radius: 6px; border: 0; color: #8a8a8a; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 12px; line-height: 150%; text-align: center; padding: 24px 0;'>
												<p style="margin: 0 0 16px;">Kritiks Melange — Built &amp; Maintained by Touchmarkdes Pvt. Ltd.</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- End Footer -->
					</td>
				</tr>
			</table>
		</div>
	  <?php } ?>
      </div><!-- container -->
    </div><!-- content -->   