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
// if($save == 'update' && $hidden_id!= '')

// {	
	// if($password != '' && $confirmpassword != '' ){
		// if($password == $confirmpassword)
		// {
	
			// $pwd = PwdHash($password);
			// $arrFields=array('`_smtp_hostname`','`_smtp_useremail`','`_smtp_password`','`_smtp_typedpwd`','`smtp`','`_smtpport`');
			// $arrValues=array("$username","$useremail","$pwd","$password","$smtp","$port");

			// $sqlWhere= "`createdby`=$hidden_id";
		
			// if(sqlACTIONS("UPDATE","js_settinggeneral",$arrFields,$arrValues,$sqlWhere))
			// {	
				// header("Location:smtp_config.php?id=$hidden_id&code=2"); 	
			// }
		// } else {
		 // $code = '0';
		// }
	// } else {
		
		// $arrFields=array('`_smtp_hostname`','`_smtp_useremail`','`smtp`','`_smtpport`');
		// $arrValues=array("$username","$useremail","$smtp","$port");

		// $sqlWhere= "`createdby`=$hidden_id";
	
		// if(sqlACTIONS("UPDATE","js_settinggeneral",$arrFields,$arrValues,$sqlWhere))
		// {	
			// header("Location:smtp_config.php?id=$hidden_id&code=2"); 	
		// }
		
	// }
	
	// }

?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
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
						 $select_itemlist = sqlQUERY_LABEL("select * FROM `js_settinggeneral` where `createdby`='$logged_id'") or die(sqlERROR_LABEL());
								$result_count = sqlNUMOFROW_LABEL($select_itemlist);
								 while($collect_item_list = sqlFETCHARRAY_LABEL($select_itemlist)) {
									$username = $collect_item_list['_smtp_hostname'];
									$useremail = $collect_item_list['_smtp_useremail'];
									$password = $collect_item_list['_smtp_password'];
									$smtp = $collect_item_list['smtp'];
									$port = $collect_item_list['_smtpport'];
								}
						 
                 	?>
							
							
				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<p class="text-muted">Last Updated on : Few Seconds Ago</p>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
					<button id="submit" onclick="myFunction()" type="button" class="btn btn-warning" value="update">Update</button>
				     <!-- <button type="submit" name="save" value="update" class="btn btn-warning">Update</button>-->
					  <input type="hidden" name="hidden_id" value="<?php echo $logged_id; ?>" />
				    </button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Basic Info</div>
		
				  <div class="form-group row">
				    <label for="username" class="col-sm-4 col-form-label"><?php echo $__username ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="username" id="username1" placeholder="Username" value="<?php echo $username ;?>" required data-parsley-error-message="Please Enter SMTP Hostname">
				    </div>
				  </div>
				  
				   <div class="form-group row">
				    <label for="useremail" class="col-sm-4 col-form-label"><?php echo $__useremail ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="useremail" id="useremail" placeholder="useremail" value="<?php echo $useremail ;?>" required data-parsley-error-message="Please Enter SMTP Username">
				    </div>
				  </div>
				  
				   <div class="form-group row">
				    <label for="password" class="col-sm-4 col-form-label"><?php echo $__password ;?><span class="text-danger">*</span></label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password;?>" required data-parsley-error-message="Please Enter SMTP Password">
						</div>
				  </div>
				  
				   <div class="form-group row">
				    <label for="smtp" class="col-sm-4 col-form-label"><?php echo $__smtp ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="smtp" id="smtp" placeholder="Smtp" value="<?php echo $smtp ;?>" required data-parsley-error-message="Please Enter SMTP">
				    </div>
				  </div>
				  
				   <div class="form-group row">
				    <label for="port" class="col-sm-4 col-form-label"><?php echo $__port ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="port" id="port" placeholder="Port" value="<?php echo $port ;?>" required data-parsley-error-message="Please Enter SMTP Port">
				    </div>
				  </div>
				  
				<div class="form-group row">
				    <label for="testmail" class="col-sm-4 col-form-label"><?php echo $__sendtestmail ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="testmail" id="testmail" placeholder="Port" value="" required data-parsley-error-message="Please Enter Email"></br>
					  <!-- <button type="submit" name="save" value="update" class="btn btn-success">Send Test Mail</button>-->
				    </div>
				</div>    
				  
			</div>
			
			  <div class="modal fade effect-scale show" id="pleasewait-loader" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered wd-150" role="document">
					<div class="modal-content">
					  <div class="modal-body text-center">
						<div class="spinner-border wd-80 ht-80" role="status">
						  <span class="sr-only">Loading...</span>
						</div>     
					  <p>working on it...</p>
					  </div>
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
      </div><!-- container -->
    </div><!-- content -->   
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	 <script>
	function myFunction() {
	
	var username = document.getElementById('username1').value;
	var useremail = document.getElementById('useremail').value;
	var password = document.getElementById('password').value;
	var smtp = document.getElementById('smtp').value;
	var port = document.getElementById('port').value;
	var testmail = document.getElementById('testmail').value;
	
	$('#pleasewait-loader').show();
	//alert(count);
	
	// alert(username);
	// alert(useremail);
	// alert(password);
	// alert(smtp);
	// alert(port); 
	// alert(testmail); 
	
	$.ajax({
			
			 url: 'engine/ajax/ajax_add_smtp.php?id=1',
			 data: {
					username:username,useremail:useremail,password:password,smtp:smtp,port:port,testmail:testmail
					},
					
					success: function(data) {
						
						$('#pleasewait-loader').hide();
						location.reload();
					// var x = data;
					
					// if (x['status'] == "Success") {
						
						// $("#details_preview").show();
						
						// $("#details_preview").load(window.location.href + " #details_preview" );
						// $("#details_edit").hide();
						// deliveryDetailsUpdated();
					// }
					// return true;
					 }
			 });
	
		
	}
	 </script>