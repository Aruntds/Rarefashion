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

//Insert Operation
if($save == 'save'){
	
		//Image1
		$valid_formats = array("jpg", "png","jpeg");
		
		$invoice_logo1 = $_FILES['invoice_logo']['name'];
		$size1 = $_FILES['invoice_logo1']['size'];
		$path="public/sales/";

		if(strlen($invoice_logo1))

		{
			list($txt, $ext) = explode(".", $invoice_logo1);
			if(in_array($ext,$valid_formats)){
					if($size1 <(1000*1000))
	
						{ 
	
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
	
							$tmp = $_FILES['invoice_logo']['tmp_name'];
	
							if(move_uploaded_file($tmp, $path.$actual_image_name)){
							
								$invoice_logo1 = $actual_image_name.';';
							
							}
	
						} else { 
					$err[] =  "failed"; 
				}
			} else { 
				$err[] = "Image file size max 1 MB";	 
			}
			
		}
		
		
		//Image 2
		$invoicehtml_pagelogo1 = $_FILES['invoicehtml_pagelogo']['name'];
		//echo $invoice_logo1 ;exit();
		$size2 = $_FILES['invoicehtml_pagelogo1']['size'];
		$path="public/sales/";

		if(strlen($invoicehtml_pagelogo1))

		{
			list($txt, $ext) = explode(".", $invoicehtml_pagelogo1);
			if(in_array($ext,$valid_formats)){
					if($size2 <(1000*1000))
	
						{ 
	
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
	
							$tmp = $_FILES['invoicehtml_pagelogo']['tmp_name'];
	
							if(move_uploaded_file($tmp, $path.$actual_image_name)){
								
								$invoicehtml_pagelogo1 = $invoice_logo1.$actual_image_name.';';

							
							}
	
						} else {
						$check_img = 4;
						}
			} else {
			 $check_img = 5;
			}
			
		}
			
			$allow_reorder = $_REQUEST['allow_reorder']; //value='on' == 1 || value='' == 0
			if($allow_reorder == 'on') { $allow_reorder = '1'; } else { $allow_reorder = '0'; }
			
			$sales_enabled = $_REQUEST['sales_enabled']; //value='on' == 1 || value='' == 0
			if($sales_enabled == 'on') { $sales_enabled = '1'; } else { $sales_enabled = '0'; }
				//Insert query
					$arrFields=array('`_sales_allowrequired`','`_sales_invoicelogo`','`_sales_invoicehtmlpagelogo`','`_sales_invoiceprintaddress`','`_sales_enabled`','`_sales_noconfirmationemailsender`','`createdby`');
					$arrValues=array("$allow_reorder","$invoice_logo1","$invoicehtml_pagelogo1","$sales_address","$sales_enabled","$sales_confirm","$logged_user_id");

					if(sqlACTIONS("INSERT","js_settingsales",$arrFields,$arrValues,''))
					{	
						?>
						<script type="text/javascript">window.location = 'configurationsales.php?code=1' </script>
						<?php		
						
					}
}


//Update Record
if($update == "update" && $hidden_id != '') {
		
		//Image1
		$valid_formats = array("jpg", "png","jpeg");
		
		$invoice_logo1 = $_FILES['invoice_logo']['name'];
		$size1 = $_FILES['invoice_logo1']['size'];
		$path="public/sales/";

		if(strlen($invoice_logo1))

		{
			list($txt, $ext) = explode(".", $invoice_logo1);
			if(in_array($ext,$valid_formats)){
					if($size1 <(1000*1000))
	
						{ 
	
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
	
							$tmp = $_FILES['invoice_logo']['tmp_name'];
	
							if(move_uploaded_file($tmp, $path.$actual_image_name)){
							
								if($old_invoice_logo != '') {					
									//remove_oldimage before updating
									$oldimage_path = $path.$old_invoice_logo;
									unlink($oldimage_path);
								}
							
							}
	
						} else { 
					$err[] =  "failed"; 
				}
			} else { 
				$err[] = "Image file size max 1 MB";	 
			}
			
		}
		
		$allow_reorder = $_REQUEST['allow_reorder']; //value='on' == 1 || value='' == 0
			if($allow_reorder == 'on') { $allow_reorder = '1'; } else { $allow_reorder = '0'; }
			
			$sales_enabled = $_REQUEST['sales_enabled']; //value='on' == 1 || value='' == 0
			if($sales_enabled == 'on') { $sales_enabled = '1'; } else { $sales_enabled = '0'; }
		//Update query
			$arrFields=array('`_sales_allowrequired`','`_sales_invoicelogo`','`_sales_invoicehtmlpagelogo`','`_sales_invoiceprintaddress`','`_sales_enabled`','`_sales_noconfirmationemailsender`','`createdby`');
			$arrValues=array("$allow_reorder","$invoice_logo1","$invoicehtml_pagelogo1","$sales_address","$sales_enabled","$sales_confirm","$logged_user_id");

			$sqlWhere= "createdby=$hidden_id";

			if(sqlACTIONS("UPDATE","js_settingsales",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'configurationsecurity.php?code=2' </script>
				<?php
				//header("Location:category.php?code=1");
				
			exit();

		} else {

			$err[] =  "Unable to Update Record"; 

		}

}	
				
?>

   <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-9">
            <div class="mg-b-25">

        <form method="post" enctype="multipart/form-data" data-parsley-validate>
			<?php 
				$gettinglast_updated = getSINGLEDBVALUE('updatedon', "createdby=$logged_user_id", 'js_settingsales', 'label');
				$formated_lastupdate_time = strtotime($gettinglast_updated);
			?>
          <div id="stick-here"></div>
          <div id="stickThis" class="form-group row mg-b-0">
          <div class="col-3 col-sm-6">
             <p class="text-muted">Last Updated on : <?php echo time_stamp($formated_lastupdate_time); ?></p>
          </div>
            <div class="col-9 col-sm-6 text-right">
				<?php if($logged_user_id == '') { ?>
				  <button type="submit" name="save" value="save" class="btn btn-success">Save</button>
				<?php } else { ?>
					<button type="submit" name="update" value="update" class="btn btn-warning">Update</button>
				  <input type="hidden" name="hidden_id" value="<?php echo $logged_user_id; ?>" />
				<?php } ?>
				 </button>
			</div>
          </div>

        <!-- BASIC Starting -->
        <div id="basic">
          <div class="divider-text">General</div>
			<?php 	
				if($logged_user_id != '') {
					
					$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_settingsales` where deleted = '0' and `createdby`='$logged_user_id'") or die("Unable to get records:".mysql_error());			
					$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

					while($row = sqlFETCHARRAY_LABEL($list_datas)){
					  $sales_allowrequired = $row["_sales_allowrequired"];
					  $sales_invoiceprintaddress =$row["_sales_invoiceprintaddress"];
					  $sales_enabled =$row["_sales_enabled"];
					  $sales_noconfirmationemailsende =$row["_sales_noconfirmationemailsende"];
					  $sales_invoicelogo =$row["_sales_invoicelogo"];
					  $sales_invoicehtmlpagelogo =$row["_sales_invoicehtmlpagelogo"];
					  
						if(!empty($sales_invoicelogo)) {
							//upload PATH
							$media_path = "uploads/sales/$sales_invoicelogo";
						} else {
							//upload PATH
							$media_path = "public/img/blank-placeholder.jpg";
						}
					}
				}
			?>
			<div class="form-group row">
				  	<label for="allow_reorder" class="col-sm-4 col-form-label"><?php echo $__allowreorder ?><span class="text-danger">*</span></label>
					<div class="col-sm-8">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="allow_reorder" id="allow_reorder" <?php if($sales_allowrequired == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="allow_reorder">Yes</label>
						</div>
					</div>
			</div>

		    <div class="form-group row">
            <label for="invoice_logo" class="col-sm-4 col-form-label"><?php echo $__invoicelogo ; ?><span class="text-danger">*</span></label>
                        
            <div class="col-sm-8">

            <div class="custom-file">
              <input type="file" class="custom-file-input" name="invoice_logo" id="invoice_logo" required data-parsley-error-message="Please choose Invoice Logo">
              <label class="custom-file-label" for="customFile">Choose file</label>
			  <input type="hidden" name="old_invoice_logo" value="<?php echo $sales_invoicelogo; ?>">
            </div>

            <div class="media-upload">
                <div class="avatar-preview">
                    <div id="imagePreview" style="background-image: url(<?php echo $media_path ; ?>);">
                    </div>
                </div>
            </div>

          </div>

          </div>
		  
		  
		  <div class="form-group row">
            <label for="invoicehtml_pagelogo" class="col-sm-4 col-form-label"><?php echo $__invoicehtml_pagelogo ; ?><span class="text-danger">*</span></label>
                        
            <div class="col-sm-8">

            <div class="custom-file">
              <input type="file" class="custom-file-input" name="invoicehtml_pagelogo" id="invoicehtml_pagelogo" required data-parsley-error-message="Please choose Invoice HTML Page Logo">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>

            <div class="media-upload">
                <div class="avatar-preview">
                    <div id="imagePreview1" style="background-image: url(<?php echo $media_path2 ; ?>);">
                    </div>
                </div>
            </div>

          </div>

          </div>
		  

		   <div class="form-group row">
            <label for="sales_address" class="col-sm-4 col-form-label"><?php echo $__invoice_printaddress ; ?><span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <textarea class="form-control" rows="2"  name="sales_address" id="sales_address" required data-parsley-error-message="Please Enter Address"><?php echo $sales_invoiceprintaddress ;?></textarea>
            </div>
          </div>

        </div>
        <!-- End of BASIC -->

        <!-- SEO Settings -->
        <div id="order">

          <div class="divider-text">Order</div>
		
		<div class="form-group row">
				  	<label for="sales_enabled" class="col-sm-4 col-form-label"><?php echo $__enabled ?><span class="text-danger">*</span></label>
					<div class="col-sm-8">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="sales_enabled" id="sales_enabled" <?php if($sales_enabled == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="sales_enabled">Yes</label>
						</div>
					</div>
			</div>

		   <div class="form-group row">
            <label for="sales_confirm" class="col-sm-4 col-form-label"><?php echo $__neworder_conformation ; ?><span class="text-danger">*</span></label>
            <div class="col-sm-8">
            <select name="sales_confirm" id="sales_confirm" class="custom-select">              
               <?php echo getNEWORDERCONFIRMATION($sales_noconfirmationemailsende,'select'); ?>
            </select>             
            </div>
          </div>
        </div>
      
        <!-- End of SEO Settings -->

        <!-- Design Settings -->
        
        <!-- End of Design Settings -->

        </form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
            $category_sidebar_view_type='create';
            include viewpath('__salessidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   