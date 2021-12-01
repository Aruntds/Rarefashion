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
?>
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <?php if($route == '') { ?>
        <div class="row">
          <div class="col-lg-9">
            <div class="row row-xs mg-b-25">

			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="contentLIST" class="table table-bordered">
			    <thead>
			        <tr>
                        <th class="wd-5p">S.No</th>
                        <th class="wd-35p">Title</th>
                        <th class="wd-10p">Status</th>
                        <th class="wd-10p">Option</th>
			        </tr>
			    </thead>
			</table>
			</div>

            </div><!-- row -->
          </div><!-- col -->

          <?php 
	          include viewpath('__contentsidebar.php'); 
          ?>

        </div><!-- row -->
        <?php
		 } elseif($route == 'preview') { 

		  //`contentID`, `contentname`, `contentimage`, `contentdescrption`, `contentseourl`, `contentmetatitle`, `contentmetakeywords`, `contentmetadescrption`, `contentdesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_content`
		  $content_datas = sqlQUERY_LABEL("SELECT * FROM `js_content` where contentID='$id' and deleted = '0'") or die("#1-Unable to get records:".mysql_error());
		
		  $count_content_availablecount = sqlNUMOFROW_LABEL($content_datas);
		
		if($count_content_availablecount > 0) {
		  while($row = sqlFETCHARRAY_LABEL($content_datas)){
			  $contentID = $row["contentID"];
			  $contentname = html_entity_decode($row["contentname"], ENT_QUOTES, "UTF-8");
			  $content_descrption = htmlspecialchars_decode($row['contentdescrption']);
			  $contentseourl = $row["contentseourl"];
			  $contentmetatitle = $row["contentmetatitle"];
			  $contentmetakeywords = $row["contentmetakeywords"];
			  $contentmetadescrption = $row["contentmetadescrption"];
			  $createdon = date('d-m-Y h:i:s a',strtotime($row["createdon"]));
			  $status = $row["status"];
		  }
		
		?>
        <p class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-25">Last Updated On: <em><?php echo $createdon; ?></em></p>
        
        <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Content Title</label>
        <h3 class="mg-b-25"><?php echo $contentname; ?></h3>
        
        <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Content Description</label>
        <div class="mg-b-30">
        <?php echo html_entity_decode($content_descrption); ?>
        </div>
        
        <?php
		 } else { 
		 ?>
        <h3 class="text-center">No Record Found</h3>
        <?php }
		 } ?>
      </div><!-- container -->
    </div><!-- content -->