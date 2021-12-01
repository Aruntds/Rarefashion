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

reguser_protect();
			
if($_POST['submit'] == 'update_password')  

{	

	$chkoldpwd = sqlQUERY_LABEL("SELECT password from `js_users` where userID='$logged_user_id'");
	
	//echo "SELECT password from `js_users` userID='$userID'";
	//exit();
	//list($old) = sqlNUMOFROW_LABEL($chkoldpwd);
	list($old) = sqlFETCHROW_LABEL($chkoldpwd);
	$old_salt = substr($old,0,9);
	
	$new_password = $_POST['new_password'];
	$confirm_password = $_POST['confirm_password'];
	
	if($new_password == '' ) {
		$err[] = "Your new password is empty";
	}
	
	if($new_password != $confirm_password) {
		$err[] = "Confirmation password is mismatching";
	}
   //echo $old .'--'. PwdHash($_POST['old_password'],$old_salt); exit();
	//check for old password in md5 format
	if($old === PwdHash($_POST['old_password'],$old_salt))
	{
	} else
	{
		 $err[] = "Your old password is invalid";
	}
	//print_r($err);exit();
	if(empty($err))  {
	
		$newsha1 = PwdHash($_POST['new_password']);
		sqlQUERY_LABEL("update js_users set password='$newsha1' where userID='$logged_user_id'");
		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		?>
		<script type="text/javascript"> window.location = 'logout.php?msg=success' </script>
		<?php
		exit();
		
	}

}

//Generating dynamic file names to view/add/edit/delete O/P:  r_{module-name}.php
$generateINCLUDE = viewGENERATOR($currentpage, $route);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo $_SITETITLE; ?></title>
    <?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>
  </head>
  <body>

	  <!-- main header -->
	  <?php include publicpath('__header.php'); ?>
	  <!-- main header ends -->
  
    <div class="content content-fixed bd-b">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
          
            <?php include publicpath('__breadcrumb.php'); ?>

          <div class="mg-t-20 mg-sm-t-0">

            

            <?php pageREFRESH(curPageURL(), $__refresh); ?>

          </div>

        </div>
      </div>
    </div>

    <!-- container -->
    <?php include ($generateINCLUDE); ?>
	<div class="content">
		<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
		  <div class="row">
			 <div class="col-lg-9">
				<div class="mg-b-25">
				   <form method="post" enctype="multipart/form-data" data-parsley-validate>
					  <div id="stick-here"></div>
					  <div id="stickThis" class="form-group row mg-b-0">
						 <div class="col-3 col-sm-6">
							<?php pageCANCEL($currentpage, $__cancel); ?>
							
						 </div>
						 <div class="col-9 col-sm-6 text-right">
							<button type="submit" id="submit" name="submit" value="update_password" class="btn btn-warning">Update</button>
						 </div>
					  </div>
					  <!-- BASIC Starting -->
					<div id="basic">
							 <div class="divider-text">Old Password</div>
							
							
						  <!-- LEAD FIRSTNAME -->
							
					<form name="chngpwd" action="" method="post"  >		 
						<div class="form-group row" id="staff_code_individual1">
							<label for="old_password" class="col-sm-3 col-form-label">Old Password</label>
							<div class="col-sm-7">
							   <input type="password" id="old_password" name="old_password" class="form-control" autocomplete="off">				      
							</div>
						</div>
						<div class="divider-text">New Password</div>
						
						<div class="form-group row" id="staff_code_individual2">
							<label for="new_password" class="col-sm-3 col-form-label" id="lead_address">New Password </label>
							<div class="col-sm-7">
								<input type="password" id="new_password" name="new_password" class="form-control" autocomplete="off">			      
							</div>
						</div>
					
						<div class="form-group row">
							<label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password </label>
							<div class="col-sm-7">
								<input type="password" id="confirm_password" name="confirm_password" class="form-control" autocomplete="off">				      
							</div>
						</div>
					</form>	
					</div>
					  </div>
				   </form>
				</div>
			 </div>
			 <!-- col -->
		  </div>
		  <!-- row -->
	    </div>
	   <!-- container -->
	</div>

    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <!-- End of Footer -->

    <div class="modal fade" id="deleteDATA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel2">Please confirm your action</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body receiving-delete-data"></div>
        </div>
      </div>
    </div>
 
	<!-- onclick spinner -->
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

    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/jqueryui/jquery-ui.min.js"></script>
    <!--<script src="<?php echo BASEPATH; ?>/public/integration/tiny_mce/tiny_mce.js"></script>-->
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
	
    <script>

//////////////////////////////////      
      <?php if($route == 'add' || $route == 'edit') {  ?>
 
        /*tinyMCE.init({
            mode : "textareas",
            theme : "advanced"
        });*/
		
        function uploadImage(input){
            if (input.files && input.files[0]) {
              var url = URL.createObjectURL(input.files[0]);
              $('#imagePreview').attr('style', 'background-image:url(' + url + ')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
            }
        }

        //document.querySelector("input").onchange = function(){uploadImage(this)};

        $("#categoryimage").change(function() {
            uploadImage(this);         
        });
		
/////////////////////////////////
        //fix submit buttons to top on scroll
        function sticktothetop() {
            var window_top = $(window).scrollTop();
            var top = $('#stick-here').offset().top;
            if (window_top > top) {
                $('#stickThis').addClass('stick');
                $('#stick-here').height($('#stickThis').outerHeight());
            } else {
                $('#stickThis').removeClass('stick');
                $('#stick-here').height(0);
            }
        }

        $(window).scroll(sticktothetop);
        sticktothetop();

<?php } ?>

      });

	function  deleteITEM(deleting_id) { 
		var SELECTED_ID = deleting_id;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__brand.php?type=delete&delete_id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}

	function  togglestatusITEM(brand_id, status) { 
		var SELECTED_ID = brand_id;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__brand.php?type=changestatus&brand_id='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}

  <?php
    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record created Successfully', 'success');
    }
  
    if($code == '0') {
      $displayMSG_globalclass->displayMSG($code, "Error", 'Unable to Add Category.', 'error');  
    }

    if(!empty($err))  {
  ?>
      toastr.error('Error', '<?php foreach ($err as $e) { echo "$e <br>"; } ?>', {timeOut: 6000})
  <?php } ?>

    </script>
  </body>
</html>	