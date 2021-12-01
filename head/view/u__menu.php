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
if( $save == "update" && $hidden_ID != '') {
	//echo $hidden_ID; exit();

	$categorytitle = $validation_globalclass->sanitize(ucwords($_REQUEST['categorytitle']));
	$category_description = str_replace("'", "\'", $category_description);
	$menu_block = htmlentities($menu_block);
	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }
	
					//Insert query
					$arrFields=array('`menu_name`', '`menu_type`', '`menu_block`', '`menu_url`', '`menu_opentype`', '`menu_parentID`', '`menu_seourl`', '`menu_metatitle`', '`menu_metakeyword`', '`menu_metadescription`', '`createdby`','`status`');

					$arrValues=array("$menu_name","$menu_type","$menu_block","$menu_url","$menu_opentype","$menu_parentID","$menu_seourl","$menu_metatitle","$menu_metakeyword","$menu_metadescription","$logged_user_id","$status");

					$sqlWhere= "menu_ID=$hidden_ID";

					if(sqlACTIONS("UPDATE","js_menu",$arrFields,$arrValues, $sqlWhere)) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'menu.php?code=1' </script>
						<?php

						exit();

					} else {

						$err[] =  "Unable to Insert Record"; 

					}

				

}

if($route == 'edit' && $id != '') {

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_menu` where deleted = '0' and `menu_ID`='$id'") or die("Unable to get records:".mysqli_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $menu_ID = $row["menu_ID"];
	  $menu_name = $row["menu_name"];
	  $menu_url = $row["menu_url"];
	  $menu_type = $row["menu_type"];
	  $menu_block = html_entity_decode($row["menu_block"]);
	  $menu_opentype = $row["menu_opentype"];
	  $status = $row["status"];
	  $menu_parentID = $row["menu_parentID"];
	  $menu_seourl = $row["menu_seourl"];
	  $menu_metatitle = $row["menu_metatitle"];
	  $menu_metakeyword = $row["menu_metakeyword"];
	  $menu_metadescription = $row["menu_metadescription"];

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
				      <button type="submit" name="save" value="update" class="btn btn-warning"><?php echo $__update ?></button>
                      <input type="hidden" name="hidden_ID" value="<?php echo $id ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label">Status</label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" <?php if($status == '1') { echo 'checked'; } ?>>
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="menu_name" class="col-sm-2 col-form-label">Menu Name</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="menu_name" id="menu_name" placeholder=" " value="<?php echo $menu_name ?>">
				    </div>
				  </div>
				
				<div class="form-group row">
				<label for="menu_parentID" class="col-sm-2 col-form-label">Parent Menu</label>
				<div class="col-sm-7">
					<select name="menu_parentID" id="menu_parentID" class="custom-select">
					  <?php echo getPARENTmenu_list($menu_parentID, 'select'); ?>
					</select>				      
					</select>
				</div>
				</div>
				
				<div class="form-group row" id="menu_type_div">
				    <label for="menu_type" class="col-sm-2 col-form-label">Menu Type</label>
				    <div class="col-sm-7">
						<select class="form-control custom-select" id="menu_type" name="menu_type">
						  <option onclick="showmenublock('0');" <?php if($menu_type=='0') { echo "selected"; } ?> value="0">--Select--</option>
						  <option onclick="showmenublock('1');" <?php if($menu_type=='1') { echo "selected"; } ?> value="1">List Menu</option>
						  <option onclick="showmenublock('2');" <?php if($menu_type=='2') { echo "selected"; } ?> value="2">Mega Menu</option>
						</select>
					</div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="menu_url" class="col-sm-2 col-form-label">Menu URL</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="menu_url" id="menu_url" placeholder=" " value="<?php echo $menu_url ?>">
				    </div>
				  </div>

				  <div class="form-group row" id="menu_block_div" <?php if($menu_type == 0 || $menu_type == 1 ) { echo "style='display:none;'"; } else { echo ''; } ?>>
				    <label for="menu_block" class="col-sm-2 col-form-label">Menu Block</label>
				    <div class="col-sm-7">
				      <textarea class="form-control" name="menu_block" id="menu_block" value=""><?php echo $menu_block; ?></textarea>
				    </div>
				  </div>
				
				  <div class="form-group row">
				    <label for="menu_opentype" class="col-sm-2 col-form-label">Open Type</label>
				    <div class="col-sm-7">
						<select id="menu_opentype" name="menu_opentype" class="form-control custom-select"> 
							<?php gettabtype($menu_opentype,'select')?>
						</select>
					</div>

				  </div>

				</div>
				<!-- End of BASIC -->
				<!-- SEO Settings -->
				<div id="seo" <?php if($menu_type == '2' ) { echo "style='display:none;'"; } else { echo ''; } ?>>

				  <div class="divider-text"><?php echo $__hseosettings ?></div>

				  <div class="form-group row">
				    <label for="menu_seourl" class="col-sm-2 col-form-label"><?php echo $__contentseourl ?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="menu_seourl" id="menu_seourl" placeholder="SEO URL" value="<?php echo $menu_seourl ?>">
				    </div>
				  </div>

				  <div class="form-group row">
				  	<label for="menu_metatitle" class="col-sm-2 col-form-label"><?php echo $__contentmetatitle ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Title" name="menu_metatitle" id="menu_metatitle" value="<?php echo $menu_metatitle ?>">
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="menu_metakeyword" class="col-sm-2 col-form-label"><?php echo $__meta_keyword ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Keywords" name="menu_metakeyword" id="menu_metakeyword" value="<?php echo $menu_metakeyword ?>">
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="menu_metadescription" class="col-sm-2 col-form-label"><?php echo $__meta_desc ?></label>
					<div class="col-sm-7">
						  <textarea class="form-control" rows="2"  name="menu_metadescription" id="menu_metadescription"><?php echo $menu_metadescription ?></textarea>
					</div>
				  </div>

				</div>				
				<!-- End of SEO Settings -->

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
	