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
	  <?php if($formtype==''){ ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">

			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="promocodeList" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p"><?php echo $__contentsno ?></th>
			            <th class="wd-15p"><?php echo $__name ?></th>
						<th class="wd-15p"><?php echo $__type ?></th>
			            <th class="wd-10p"><?php echo $__code ?></th>
			            <th class="wd-15p"><?php echo $__value ?></th>
			            <th class="wd-15p"><?php echo $__expirydate ?></th>
			            <th class="wd-10p"><?php echo $__option ?></th>
			            <th class="wd-9p"><?php echo $__status ?></th>
			            <th class="wd-20p"><?php echo $__modify ?></th>
			        </tr>
			    </thead>
			</table>
			</div>

            </div><!-- row -->
          </div><!-- col -->

          <?php 
	        // include viewpath('__ourexpertisesidebar.php'); 
          ?>

        </div><!-- row -->
	  <?php } ?>
		
		<div>
		</div>
      </div><!-- container -->
    </div><!-- content -->