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

//upload related product
if($save == "next") {

	if(empty($err)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";	
		?>
		<script type="text/javascript">window.location = 'product.php?route=step4&parentproduct=<?php echo $parentproduct; ?>' </script>
		<?php
		
		exit();	
	}
	
}

?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <?php 
	          $product_sidebar_view_type='s3';
	          include viewpath('__productsidebar.php');
          ?>
          <div class="col-lg-9 pd-t-40 bd">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<a href="<?php echo $currentpage; ?>?route=step2&parentproduct=<?php echo $parentproduct; ?>" class="btn btn-secondary" type="cancel"><?php echo $__back; ?></a>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
                      <input type="hidden" name="hidden_parentproduct" id="hidden_parentproduct" value="<?php echo $parentproduct; ?>" />
				      <button type="submit" name="save" value="next" class="btn btn-success">Next</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Related & Upsell Product</div>

				    <div class="tx-gray-400 mg-t-60 text-center tx-24">** Not Available right now **</div>

				</div>
				<!-- End of BASIC -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   