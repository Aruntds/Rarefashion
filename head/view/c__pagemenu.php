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

	$menu_title = $validation_globalclass->sanitize($_REQUEST['menu_title']);

	$page_name = $validation_globalclass->sanitize($_REQUEST['page_name']);
	
	$page_type = $validation_globalclass->sanitize($_REQUEST['page_type']);
	
	$sidebar_display = $validation_globalclass->sanitize($_REQUEST['sidebar_display']);
	
	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }

					//Insert query
					if($parent== '1'){$parent_ID = 0;}
				
					$arrFields=array('`parent_ID`', '`menu_title`','`page_name`','`page_type`','`createdby`','`status`','`sidebar_display`');
					
					$arrValues=array("$parent_ID", "$menu_title", "$page_name","$page_type", "$logged_user_id","$status", "$sidebar_display");
					
					if(sqlACTIONS("INSERT","js_pagemenu",$arrFields,$arrValues,'')) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						if( $save == "save"	) {
							?>
							<script type="text/javascript">window.location = 'pagemenu.php?route=add&code=1' </script>
							<?php
							//header("Location:category.php?route=add&code=1");
						} else {
							?>
							<script type="text/javascript">window.location = 'pagemenu.php?code=1' </script>
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
        <div class="row">
          <div class="col-lg-10">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<?php pageCANCEL($currentpage, $__cancel); ?>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
				      <button type="submit" name="save" value="save" class="btn btn-success"><?php echo $__save ?></button>
				      <button type="submit" name="save_close" value="save_close" class="btn btn-success"><?php echo $__save_close ?></</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-2 mg-l-35 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch mg-t-10">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" checked="">
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

				<div class="card-body">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<label>Menu Title</label>
								
								<input type="text" id="menu_title" name="menu_title" class="form-control" required placeholder="Enter Title Name Eg: Labours, Add Labours">
							</div>
						</div>
						<div class="col-md-12 col-sm-12 row">
							<div class="col-lg-6 col-md-6">
								<label>Display Sidebar</label>
					
								<div class="row">
								<div class="col-md-3">
									<div class="custom-control custom-radio">
									<input type="radio" name="sidebar_display" class="custom-control-input" id="feedback111" value="1">
									<label class="custom-control-label" for="feedback111">Yes</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="custom-control custom-radio">
									<input type="radio" name="sidebar_display" class="custom-control-input" id="feedback1112"  value="0">
									<label class="custom-control-label" for="feedback1112">No</label>
									</div>
								</div>
								</div>
								
							</div>	
					
					<div class="col-md-6">	
					
					
					<label>Parent</label>
					
							<div class="row ">
							<div class="col-md-3"> 
							
									<div class="custom-control custom-radio">
										<input type="radio" onclick="showparent();" name="parent" class="custom-control-input" id="parent1" value="1">
										<label class="custom-control-label" for="parent1">Yes</label>
									</div>
								</div>
								<div class="col-md-3">
									 <div class="custom-control custom-radio">
										<input type="radio" onclick="showparent();" name="parent" class="custom-control-input" id="parent0" value="0">
										<label class="custom-control-label" for="parent0">No</label>
									</div>
								</div>
							</div>	
							</div>
						</div>
					
						<div id="show_parent" <?php echo $show_div;?>>
							<div class="col-md-12 col-sm-12 row mg-t-20">
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
									  <label for="parent_ID">Parent Menu</label>
										<select class="form-control" name="parent_ID" id="parent_ID">
										<?php echo getParentmenu($parent_ID,'select'); ?> 
										</select>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 ">
									<div class="form-group">
									  <label for="proofattach">Page Type</label>
										<select class="form-control" name="page_type" id="page_type">
										<?php echo pageTYPE($page_type,'select'); ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								<label>Page Name</label>
								<input type="text" id="page_name" name="page_name" class="form-control"  placeholder="Eg: crud_supervisor.php">
								</div>
							</div>	
						</div>
				</div>	
				 
				</div>
				<!-- End of BASIC -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          //$brand_sidebar_view_type='create';
	          //include viewpath('__brandsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   