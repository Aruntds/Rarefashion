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
        <div class="row">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">

			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="subscriber_LIST" class="table table-bordered">
			    <thead>
			        <tr>
                  <th class="wd-5p"><?php echo $__contentsno ?></th>
			            <th class="wd-20p"><?php echo 'Registered '.$__email; ?></th>
			            <th class="wd-20p"><?php echo 'Registered Date'; ?></th>
			            <th class="wd-5p"><?php echo $__options ?></th>
			        </tr>
			    </thead>
			</table>
			</div>

            </div><!-- row -->
          </div><!-- col -->

          <?php 
	          include viewpath('__footersidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->