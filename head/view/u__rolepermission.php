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
if( $save == "update_continue" && $hidden_role_id != '') {


	$role_name = $validation_globalclass->sanitize($_REQUEST['role_name']);

	$page_allowed = $validation_globalclass->sanitize($_REQUEST['page_allowed']);

	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }


					//Insert query
					$page_allowed = implode(',',$course);
					$arrFields=array('`role_name`', '`page_allowed`','`status`');
					$arrValues=array("$role_name", "$page_allowed", "$status");
					$sqlWhere= "role_ID=$hidden_role_id";
					
					if(sqlACTIONS("UPDATE","js_rolemenu",$arrFields,$arrValues, $sqlWhere)) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'rolepermission.php?route=edit&id=<?php echo $id ?>&formtype=dashboard_config' </script>
						<?php

						exit();

					} else {

						$err[] =  "Unable to Insert Record"; 


	}

}

if( $save == "update" && $hidden_role_id != '') {


	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }


					//Insert query
					$dashboard_content_allowed = implode(',',$dashboard_content);
					$arrFields=array('`dashboard_content_allowed`');
					$arrValues=array("$dashboard_content_allowed");
					$sqlWhere= "role_ID=$hidden_role_id";
					
					if(sqlACTIONS("UPDATE","js_rolemenu",$arrFields,$arrValues, $sqlWhere)) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'rolepermission.php?id=<?php echo $hidden_role_id; ?>' </script>
						<?php

						exit();

					} else {

						$err[] =  "Unable to Insert Record"; 


	}

}

if( $save == "update_notification" && $hidden_role_id != '') {


	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }


					//Insert query
					$notification_content_allowed = implode(',',$notification_content);
					$arrFields=array('`notification_content_allowed`');
					$arrValues=array("$notification_content_allowed");
					$sqlWhere= "role_ID=$hidden_role_id";
					
					if(sqlACTIONS("UPDATE","js_rolemenu",$arrFields,$arrValues, $sqlWhere)) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'rolepermission.php?code=1'</script>
						<?php

						exit();

					} else {

						$err[] =  "Unable to Insert Record"; 


	}

}

if($route == 'edit' && $id != '') {

	//`categoryID`, `categoryparentID`, `categoryname`, `categoryimage`, `categorydescrption`, `categoryseourl`, `categorymetatitle`, `categorymetakeywords`, `categorymetadescrption`, `categorydesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_category`
		$query= "SELECT * FROM `js_rolemenu` where role_ID='$id'";
		$result = sqlQUERY_LABEL($query);
		while($row = sqlFETCHARRAY_LABEL($result))
		{	
			$role_ID = $row['role_ID'];							
			$role_name = $row['role_name'];							
			$page_allowed = explode(',',$row['page_allowed']);	
			$dashboard_content_allowed = explode(',',$row['dashboard_content_allowed']);	
			$notification_content_allowed = explode(',',$row['notification_content_allowed']);			
			$status = $row['status'];							
		}
	}
?>

<?php if($formtype==''){ ?>
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
				      <button type="submit" name="save" value="update_continue" class="btn btn-warning"><?php echo $__update; ?></button>
                      <input type="hidden" name="hidden_role_id" value="<?php echo $role_ID; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo .' of '.$role_name; ?></div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" <?php if($status == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

				<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
							  <label>Role Name</label>
							  <input type="text" id="role_name" name="role_name" data-parsley-whitespace="trim" data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" class="form-control" value="<?php echo $role_name; ?>" placeholder="" required>
							</div>
						 </div>
						 <table class="table" id="document_type">
					<thead>
						<tr>
						   <th>#</th>
							<th>Main Page Menu</th>
							<th>PageID</th>
							<th>Permissions</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$query= "SELECT * FROM `js_pagemenu` where parent_ID = '0' and status=1 and deleted='0'";
					$result = sqlQUERY_LABEL($query);
					while($fetch_records = sqlFETCHARRAY_LABEL($result))
					{		
							$counter++;
							$page_ID = $fetch_records['page_ID'];
							$menu_title = $fetch_records['menu_title'];
							$page_name = $fetch_records['page_name'];
							
					
					?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $menu_title;?> </td>
						<td><?php echo $page_ID;?> </td>
						<td> <div class="custom-control custom-checkbox">
								<input type="checkbox" <?php if(in_array($page_ID,$page_allowed)) { echo "checked";}?> name="course[]" class="custom-control-input" id="course-<?php echo $page_ID;?>" value="<?php echo $page_ID;?>">
								<label class="custom-control-label" for="course-<?php echo $page_ID;?>"><?php echo "Show"; ?></label>
							</div>
						</td>
						</tr>
						<?php 
						$query_sub= "SELECT * FROM `js_pagemenu` where parent_ID = '$page_ID' and status=1 and deleted='0' order by menu_title";
					$result_sub= sqlQUERY_LABEL($query_sub);
							while($fetch_records_sub = sqlFETCHARRAY_LABEL($result_sub))
							{		
									$pageID = $fetch_records_sub['page_ID'];
									$menu_title = $fetch_records_sub['menu_title'];
									$page_name = $fetch_records_sub['page_name'];
									
							?>
							<tr>
							<td></td>
							<td>--<?php echo $menu_title;?> </td>
							<td><?php echo $pageID;?> </td>
							<td> <div class="custom-control custom-checkbox">
								<input type="checkbox" <?php if(in_array($pageID,$page_allowed)) { echo "checked";}?> name="course[]" class="custom-control-input" id="course-<?php echo $pageID;?>" value="<?php echo $pageID;?>">
								<label class="custom-control-label" for="course-<?php echo $pageID;?>"><?php echo "Show"; ?></label>
							</div>
						</td>
						</tr>
							
							<?php } ?>	
							
						<?php } ?>
						
						</tbody>
					</table>		
								
				</div>			 
				</div>
				<!-- End of BASIC -->

				</form>


            </div><!-- row -->
          </div><!-- col -->
        
<?php } if($formtype=='dashboard_config'){ ?>
	<div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-10">
            <div class="mg-b-25">
            <form method="post" enctype="multipart/form-data" data-parsley-validate action="">
                <div id="stick-here"></div>
                  <div id="stickThis" class="form-group row mg-b-0">
                     <div class="col-3 col-sm-6">
                        <?php pageCANCEL($currentpage, $__cancel); ?>
                     </div>
                     <div class="col-9 col-sm-6 text-right">
                        <button type="submit" name="save" value="update" class="btn btn-warning"><?php echo $__update_continue ?></button>
						<input type="hidden" name="hidden_role_id" value="<?php echo $role_ID; ?>" />
                     </div>
                  </div>
					<!-- BASIC Starting -->
				<div id="basic">
					<div class="divider-text"><?php echo $__hbasicinfo .' of '.$role_name; ?></div>
						<div class="card mg-md-t-20">
					<table class="table" id="document_type">
					<thead>
						<tr>
						   <th>#</th>
							<th>Dashboard Title</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
					
						<?php 
						$query_sub= "SELECT * FROM `js_dashboard_content` where deleted='0' order by dashboard_content_ID";
					$result_sub= sqlQUERY_LABEL($query_sub);
							while($fetch_records_sub = sqlFETCHARRAY_LABEL($result_sub))
							{		
									$counter_d++;
									$dashboard_content_ID = $fetch_records_sub['dashboard_content_ID'];
									$dashboard_content_title = $fetch_records_sub['dashboard_content_title'];
									$dashboard_content_status = $fetch_records_sub['dashboard_content_status'];
									
							?>
							<tr>
							<td><?php echo $counter_d;?> </td>
							<td><?php echo $dashboard_content_title;?> </td>
							<td> <div class="custom-control custom-switch mg-t-10">
									<input type="checkbox" class="custom-control-input" name="dashboard_content[]" id="dashboard_content_<?php echo $dashboard_content_ID; ?>" <?php if(in_array($dashboard_content_ID,$dashboard_content_allowed)) { echo "checked";}?> value="<?php echo $dashboard_content_ID;?>">
									<label class="custom-control-label" for="dashboard_content_<?php echo $dashboard_content_ID; ?>">Yes</label>
								</div>
						</td>
						</tr>
							
							<?php } ?>	
							
						
						</tbody>
					</table>
				</div>
			</div>
           <!-- End of BASIC -->
				</form>
         </div>
      <!-- col -->
			</div>
		  </div>
		</div>
	  </div>
      <?php } if($formtype=='notification_config'){ ?>
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
					 <button type="submit" name="save" value="update_notification" class="btn btn-warning"><?php echo $__update; ?></button>
						<input type="hidden" name="hidden_role_id" value="<?php echo $id; ?>" />
                     </div>
                  </div>
					<!-- BASIC Starting -->
                      <div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo .' of '.$role_name; ?></div>
						<div class="card mg-md-t-20">
					<table class="table" id="document_type">
					<thead>
						<tr>
						   <th>#</th>
							<th>Notification Title</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
					
						<?php 
						$query_sub= "SELECT * FROM `js_notification_content` where deleted='0' and status = '1' order by notification_content_ID";
					$result_sub= sqlQUERY_LABEL($query_sub);
							while($fetch_records_sub = sqlFETCHARRAY_LABEL($result_sub))
							{		
									$counter_n++;
									$notification_content_ID = $fetch_records_sub['notification_content_ID'];
									$notification_content_title = $fetch_records_sub['notification_content_title'];
									
							?>
							<tr>
							<td><?php echo $counter_n;?> </td>
							<td><?php echo $notification_content_title;?> </td>
							<td> <div class="custom-control custom-switch mg-t-10">
									<input type="checkbox" class="custom-control-input" name="notification_content[]" id="notification_content_<?php echo $notification_content_ID; ?>" <?php if(in_array($notification_content_ID,$notification_content_allowed)) { echo "checked";}?> value="<?php echo $notification_content_ID;?>">
									<label class="custom-control-label" for="notification_content_<?php echo $notification_content_ID; ?>">Yes</label>
								</div>
						</td>
						</tr>
							
							<?php } ?>	
							
						
						</tbody>
					</table>
				</div>
			</div>
           <!-- End of BASIC -->
				</form>
         </div>
      <!-- col -->
			</div>
		  </div>
		</div>
	  </div>
      <?php } ?>		
          <?php 
	          //$brand_sidebar_view_type='create';
	          //include viewpath('__brandsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   