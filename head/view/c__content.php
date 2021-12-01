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
if($save == "save" || $save_close == "save_close") {

	$contentname = htmlentities(ucwords($_REQUEST['contentname']));
	$content_descrption = htmlentities($_REQUEST['contentdescrption']);
	trim ($content_descrption);

	$contentseourl = convertSEOURL($validation_globalclass->sanitize($_REQUEST['contentseourl']));
	$contentmetatitle = $validation_globalclass->sanitize($_REQUEST['contentmetatitle']);
	$contentmetakeywords = $validation_globalclass->sanitize($_REQUEST['contentmetakeywords']);
	$contentmetadescrption = $validation_globalclass->sanitize($_REQUEST['contentmetadescrption']);

	$contentdesignsettings = $_REQUEST['contentdesignsettings'];

	$contentstatus = $_REQUEST['contentstatus']; //value='on' == 1 || value='' == 0
	if($contentstatus == 'on') { $content_status = '1'; } else { $content_status = '0'; }
		
		$sidebar = $_REQUEST['sidebar']; //value='on' == 1 || value='' == 0
		if($sidebar == 'on') { $sidebar = '1'; } else { $sidebar = '0'; }

	//upload PATH
	$media_path = "uploads/content/";

	$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
	$media_name = $_FILES['contentimage']['name'];
	$media_size = $_FILES['contentimage']['size'];

	if(strlen($media_name))
	{
		list($txt, $ext) = explode(".", $media_name);
		if(in_array($ext,$valid_formats))
		{
		if($media_size<(1000*1000))
			{
				$content_image = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['contentimage']['tmp_name'];

				if(move_uploaded_file($tmp, $media_path.$content_image)) {

					//Insert query
					$arrFields=array('`contentname`','`contentimage`','`contentdescrption`','`contentseourl`','`contentmetatitle`','`contentmetakeywords`','`contentmetadescrption`','`contentdesignsettings`','`createdby`','`sidebar`','`status`');

					$arrValues=array("$contentname","$content_image","$content_descrption","$contentseourl","$contentmetatitle","$contentmetakeywords","$contentmetadescrption","$contentdesignsettings","$logged_user_id","$sidebar","$content_status");

					if(sqlACTIONS("INSERT","js_content",$arrFields,$arrValues,'')) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						if( $save == "save"	) {
							?>
							<script type="text/javascript">window.location = 'content.php?route=add&code=1' </script>
							<?php
							//header("Location:content.php?route=add&code=1");
						} else {
							?>
							<script type="text/javascript">window.location = 'content.php?code=1' </script>
							<?php
							//header("Location:content.php?code=1");
						}
	
						exit();

					} else {

						$err[] =  "Unable to Insert Record"; 

					}

				} else { 
					$err[] =  "failed"; 
				}
			} else { 
				$err[] = "Image file size max 1 MB";	 
			}
		} else { 
			$err[] =  "Invalid file format..";	 
		}
	} else {

		//Insert Query
		$arrFields=array('`contentname`','`contentdescrption`','`contentseourl`','`contentmetatitle`','`contentmetakeywords`','`contentmetadescrption`','`contentdesignsettings`','`createdby`','`sidebar`','`status`');

		$arrValues=array("$contentname","$content_descrption","$contentseourl","$contentmetatitle","$contentmetakeywords","$contentmetadescrption","$contentdesignsettings","$logged_user_id","$sidebar","$content_status");

		if(sqlACTIONS("INSERT","js_content",$arrFields,$arrValues,'')) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

			if( $save == "save"	) {
				?>
				<script type="text/javascript">window.location = 'content.php?route=add&code=1' </script>
				<?php
				//header("Location:content.php?route=add&code=1");
			} else {
				?>
				<script type="text/javascript">window.location = 'content.php?code=1' </script>
				<?php
				//header("Location:content.php?code=1");
			}

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

	}

}
?>

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
				      <button type="submit" name="save" value="save" class="btn btn-success"><?php echo $__save ?></button>
				      <button type="submit" name="save_close" value="save_close" class="btn btn-success"><?php echo $__save_close ?></button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="contentstatus" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="contentstatus" id="contentstatus" checked="">
						  <label class="custom-control-label" for="contentstatus">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="contentname" class="col-sm-2 col-form-label"><?php echo $__contenttittle ?><span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="contentname" id="contentname" placeholder="Content Title" required data-parsley-error-message="Please enter content title">
				    </div>
				  </div>
					<div class="form-group row">
                    <label for="sidebar" class="col-sm-2 col-form-label">Show Sidebar</label>
				    <div class="col-sm-2">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="sidebar" name="sidebar" <?php if($sidebar=='1') { echo 'checked="checked"'; } ?> >
                              <label class="custom-control-label" for="sidebar">Show</label>
                            </div>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="imageupload" class="col-sm-2 col-form-label"><?php echo $__contentimage ?></label>
				    				    
				    <div class="col-sm-7">

						<div class="custom-file">
						  <input type="file" class="custom-file-input" name="contentimage" id="contentimage">
						  <label class="custom-file-label" for="customFile"><?php echo $__contentchoosebannermage ?></label>
						</div>

						<div class="media-upload">
						    <div class="avatar-preview">
						        <div id="imagePreview" style="background-image: url(public/img/blank-placeholder.jpg);">
						        </div>
						    </div>
						</div>

					</div>

				  </div>

				  <div class="form-group row">
				    <label for="contentdescrption" class="col-sm-2 col-form-label"><?php echo $__description ?></label>
				    <div class="col-sm-7">
				    	<textarea class="form-control" rows="2"  name="contentdescrption" id="contentdescrption"></textarea>
				    </div>
				  </div>
				</div>
				<!-- End of BASIC -->

				<!-- SEO Settings -->
				<div id="seo">

				  <div class="divider-text"><?php echo $__hseosettings ?></div>

				  <div class="form-group row">
				    <label for="contentseourl" class="col-sm-2 col-form-label"><?php echo $__contentcseourl ?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="contentseourl" id="contentseourl" placeholder="SEO URL">
				    </div>
				  </div>

				  <div class="form-group row">
				  	<label for="contentmetatitle" class="col-sm-2 col-form-label"><?php echo $__contentmetatitle ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Title" name="contentmetatitle" id="contentmetatitle" >
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="contentmetakeywords" class="col-sm-2 col-form-label"><?php echo $__meta_keyword ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Keywords" name="contentmetakeywords" id="contentmetakeywords" >
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="contentmetadescrption" class="col-sm-2 col-form-label"><?php echo $__meta_desc ?></label>
					<div class="col-sm-7">
						  <textarea class="form-control" rows="2"  name="contentmetadescrption" id="contentmetadescrption"></textarea>
					</div>
				  </div>

				</div>
				<!-- End of SEO Settings -->

				<!-- Design Settings -->
				<div id="design">

				  <div class="divider-text"><?php echo $__hdesignsettings ?></div>

				  <div class="form-group row">
				    <label for="contentdesignsettings" class="col-sm-2 col-form-label"><?php echo $__contentdisplay ?></label>
				    <div class="col-sm-7">
						<select name="contentdesignsettings" id="contentdesignsettings" class="custom-select">
						  <?php echo customCONTENTDISPLAYSETTINGS($contentdesignsettings, 'select'); ?>
						</select>				      
				    </div>
				  </div>

				</div>
				<!-- End of Design Settings -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $content_sidebar_view_type='create';
	          include viewpath('__contentsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   