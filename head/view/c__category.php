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

	$categoryparentID = $validation_globalclass->sanitize($_REQUEST['categoryparentID']);
		$encrypt_category_name =  base64_encode($categoryname);

	$categoryname = $validation_globalclass->sanitize(ucwords($_REQUEST['categoryname']));
	
	$description = $validation_globalclass->sanitize($_REQUEST['categorydescrption']);

	$categoryseourl = $validation_globalclass->sanitize(strtolower($_REQUEST['categoryseourl']));
	$categorymetatitle = $validation_globalclass->sanitize($_REQUEST['categorymetatitle']);
	$categorymetakeywords = $validation_globalclass->sanitize($_REQUEST['categorymetakeywords']);
	$categorymetadescrption = $validation_globalclass->sanitize($_REQUEST['categorymetadescrption']);
	//html content
	$categorydescrption = addslashes($description);
	trim ($categorydescrption);

	$categorydesignsettings = $_REQUEST['categorydesignsettings'];

	$categorystatus = $_REQUEST['categorystatus']; //value='on' == 1 || value='' == 0
	if($categorystatus == 'on') { $category_status = '1'; } else { $category_status = '0'; }
	
	//upload PATH
	$media_path = "uploads/category/";

	$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
	$media_name = $_FILES['categoryimage']['name'];
	$media_size = $_FILES['categoryimage']['size'];

	//echo "SELECT * FROM `js_category` where deleted = '0' and `categoryname`='$categoryname'";exit();
	// $list_datas = sqlQUERY_LABEL("SELECT * FROM `js_category` where deleted = '0' and `categoryname`='$categoryname'") or die("Unable to get records:".mysql_error());			
	// $check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			
	
	
 //if($check_record_availabity == '0'){
	if(strlen($media_name))
	{
		list($txt, $ext) = explode(".", $media_name);
		if(in_array($ext,$valid_formats))
		{
		if($media_size<(1000*1000))
			{
				$category_image = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['categoryimage']['tmp_name'];

				if(move_uploaded_file($tmp, $media_path.$category_image)) {

					//Insert query
					$arrFields=array('`categoryparentID`','`categoryname`','`category_code`','`encrypt_category_name`','`categoryimage`','`categorydescrption`','`categoryseourl`','`categorymetatitle`','`categorymetakeywords`','`categorymetadescrption`','`categorydesignsettings`','`createdby`','`status`');

					$arrValues=array("$categoryparentID","$categoryname","$category_code","$encrypt_category_name","$category_image","$categorydescrption","$categoryseourl","$categorymetatitle","$categorymetakeywords","$categorymetadescrption","$categorydesignsettings","$logged_user_id","$category_status");

					if(sqlACTIONS("INSERT","js_category",$arrFields,$arrValues,'')) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						if( $save == "save"	) {
							?>
							<script type="text/javascript">window.location = 'category.php?route=add&code=1' </script>
							<?php
							//header("Location:category.php?route=add&code=1");
						} else {
							?>
							<script type="text/javascript">window.location = 'category.php?code=1' </script>
							<?php
							//header("Location:category.php?code=1");
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
		$arrFields=array('`categoryparentID`','`categoryname`','`category_code`','`encrypt_category_name`','`categorydescrption`','`categoryseourl`','`categorymetatitle`','`categorymetakeywords`','`categorymetadescrption`','`categorydesignsettings`','`createdby`','`status`');

		$arrValues=array("$categoryparentID","$categoryname","$categorycode","$encrypt_category_name","$categorydescrption","$categoryseourl","$categorymetatitle","$categorymetakeywords","$categorymetadescrption","$categorydesignsettings","$logged_user_id","$category_status");

		if(sqlACTIONS("INSERT","js_category",$arrFields,$arrValues,'')) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

			if( $save == "save"	) {
				?>
				<script type="text/javascript">window.location = 'category.php?route=add&code=1' </script>
				<?php
				//header("Location:category.php?route=add&code=1");
			} else {
				?>
				<script type="text/javascript">window.location = 'category.php?code=1' </script>
				<?php
				//header("Location:category.php?code=1");
			}

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

	}
	// }else{
		 ?>
		 <!--<script type="text/javascript">window.location = 'category.php?route=add&code=0' </script>-->
		 <?php 
	// }

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
				      <button type="submit" name="save" value="save" id="save" class="btn btn-success"><?php echo $__save ?></button>
				      <button type="submit" name="save_close" id="save_close" value="save_close" class="btn btn-success"><?php echo $__save_close ?></</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="categorystatus" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="categorystatus" id="categorystatus" checked="">
						  <label class="custom-control-label" for="categorystatus">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="categoryparentID" class="col-sm-2 col-form-label"><?php echo $__categoriesparentcategory ?><span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						<select name="categoryparentID" id="categoryparentID" class="custom-select">						  
						  <?php echo getPARENTCategory($categoryID, 'select'); ?>
						</select>				      
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="categoryname" class="col-sm-2 col-form-label"><?php echo $__categoriescategoryname ?><span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
				      
					  <input type="text" class="form-control" name="categoryname" id="categoryname"  placeholder="Please enter category name" data-parsley-checkcategoryname data-parsley-checkcategoryname-message="Category name already Exists" data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" required>		 
					  <input type="hidden" name="encrypt_category_name" id="encrypt_category_name" value="">		
				    </div>
				  </div>
				  
				   <div class="form-group row">
				    <label for="categorycode" class="col-sm-2 col-form-label">Category Code<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
				      
					  <input type="text" class="form-control" name="categorycode" id="categorycode"  placeholder="Please enter category Code" data-parsley-checkcategorycode data-parsley-checkcategorycode-message="Category code already Exists" data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" required>		 
					  <input type="hidden" name="encrypt_categorycode" id="encrypt_categorycode" value="">		
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="imageupload" class="col-sm-2 col-form-label"><?php echo $__categoriescategoryimage ?></label>
				    				    
				    <div class="col-sm-7">

						<div class="custom-file">
						  <input type="file" class="custom-file-input" name="categoryimage" id="categoryimage">
						  <label class="custom-file-label" for="customFile"><?php echo $__categorieschoosefile ?></label>
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
				    <label for="categorydescrption" class="col-sm-2 col-form-label"><?php echo $__description ?></label>
				    <div class="col-sm-7">
				    	<textarea class="form-control" rows="2"  name="categorydescrption" id="categorydescrption"></textarea>
				    </div>
				  </div>
				</div>
				<!-- End of BASIC -->

				<!-- SEO Settings -->
				<div id="seo">

				  <div class="divider-text"><?php echo $__hseosettings ?></div>

				  <div class="form-group row">
				    <label for="categoryseourl" class="col-sm-2 col-form-label"><?php echo $__contentseourl ?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="categoryseourl" id="categoryseourl" placeholder="SEO URL">
				    </div>
				  </div>

				  <div class="form-group row">
				  	<label for="categorymetatitle" class="col-sm-2 col-form-label"><?php echo $__contentmetatitle ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Title" name="categorymetatitle" id="categorymetatitle" >
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="categorymetakeywords" class="col-sm-2 col-form-label"><?php echo $__meta_keyword ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Keywords" name="categorymetakeywords" id="categorymetakeywords" >
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="categorymetadescrption" class="col-sm-2 col-form-label"><?php echo $__meta_desc ?></label>
					<div class="col-sm-7">
						  <textarea class="form-control" rows="2"  name="categorymetadescrption" id="categorymetadescrption"></textarea>
					</div>
				  </div>

				</div>
				<!-- End of SEO Settings -->

				<!-- Design Settings -->
				<div id="design">

				  <div class="divider-text"><?php echo $__hdesignsettings ?></div>

				  <div class="form-group row">
				    <label for="categorydesignsettings" class="col-sm-2 col-form-label"><?php echo $__contentdisplay ?></label>
				    <div class="col-sm-7">
						<select name="categorydesignsettings" id="categorydesignsettings" class="custom-select">
						  <option value="1" selected><?php echo $__categoriespdlistonly ?></option>
						  <option value="2"><?php echo $__categoriescontentonly ?></option>
						  <option value="3"><?php echo $__categoriespdandcontent ?></option>
						</select>				      
				    </div>
				  </div>

				</div>
				<!-- End of Design Settings -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $category_sidebar_view_type='create';
	          include viewpath('__categorysidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   
	