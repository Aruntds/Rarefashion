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
      <div class="col-lg-12">
        <div class="row row-xs mg-b-25">

        <div data-label="Example" class="df-example demo-table table-responsive">
          <table id="productLIST" class="table table-bordered">
		    <thead>
		        <tr>
		            <th class="wd-5p">S.No</th>
		            <th class="wd-15p">SKU</th>
		            <th class="wd-35p">Name</th>
		            <th class="wd-15p">Selling Price</th>
		            <th class="wd-15p">MRP Price</th>
		            <th class="wd-20p">In-Stock</th>
		            <th class="wd-20p">Available Stock</th>
		            <th class="wd-20p">Status</th>
		            <th class="wd-20p">Option</th>
		        </tr>
		    </thead>

		</table>
		</div>   	

        </div><!-- row -->
      </div><!-- col -->

    </div><!-- row -->
	<?php
     } elseif($route == 'preview') {
	

		//check if product image is added or not
		$check_productimageAVAILABLE = commonNOOFROWS_COUNT('js_productmediagallery', "`productID`='$parentproduct' and `productmediagallerytype`='1' and `createdby`='$logged_user_id'");
		
		//check if product video is added or not
		$check_productvideoAVAILABLE = commonNOOFROWS_COUNT('js_productmediagallery', "`productID`='$parentproduct' and `productmediagallerytype`='2' and `createdby`='$logged_user_id'");
		
		$list_product_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where productID='$parentproduct' and deleted = '0'") or die("#1-Unable to get records:".mysql_error());
		
		$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
		
		if($count_product_list > 0) {
		  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
			  $productID = $row["productID"];
			  $productsku = $row["productsku"];
			  $producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
			  
			  $productdescrption = htmlspecialchars_decode($row["productdescrption"]);
			  $productpropertydescrption = htmlspecialchars_decode($row["productpropertydescrption"]);
			  $productspecialnotes = htmlspecialchars_decode($row["productspecialnotes"]);

			  $productsellingprice = ($row["productsellingprice"]);
			  $productMRPprice = ($row["productMRPprice"]);
			  $productpurchaseprice = ($row["productpurchaseprice"]);
			  $productyousaveprice = ($row["productyousaveprice"]);

			  $productopeningstock = $row["productopeningstock"];
			  $productavailablestock = $row["productavailablestock"];

				$productseourl = $row['productseourl'];
				$productmetatitle = htmlentities($row['productmetatitle'], ENT_QUOTES);
				trim ($productmetatitle);
				$productmetakeywords = $row['productmetakeywords'];
				$productmetadescrption = $row['productmetadescrption'];
					  
			  $productstockstatus = $row["productstockstatus"];  //stock status
			  if($productstockstatus) {
				  $productstock_status_label = '<span class="text-success"><i class="far fa-check-circle"></i> In-Stock</span>';
			  } else {
				  $productstock_status_label = '<span class="text-danger"><i class="far fa-times-circle"></i> Out-of-Stock</span>';
			  }

			  $status = $row["status"];  //product status
			  if($status) {
				  $status_label = '<span class="text-success"><i class="far fa-check-circle"></i> Active</span>';
			  } else {
				  $status_label = '<span class="text-danger"><i class="far fa-times-circle"></i> In-Active</span>';
			  }
			  
			  $createdon = strtotime($row["createdon"]);
			  $updatedon = strtotime($row["updatedon"]);
		  }
		
		?>
        
        <p class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-25">
        Created On: <em><?php echo date("d-m-Y h:i a", $createdon); ?></em> | Last Updated On: <em><?php time_stamp($updatedon); ?></em>
        </p>
        
        <div class="row">
        	<div class="col-8">
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Product Title</label>
                <h3 class="mg-b-25">
                    <?php echo $producttitle; ?>
                </h3>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Product Description</label>
                <div class="mg-b-30">
                <?php if($productdescrption) { echo html_entity_decode($productdescrption); } else { echo 'N/A'; } ?>
                </div>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Product Property</label>
                <div class="mg-b-30">
                <?php if($productpropertydescrption) { echo html_entity_decode($productpropertydescrption); } else { echo 'N/A'; } ?>
                </div>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Product Special Notes</label>
                <div class="mg-b-30">
                <?php if($productspecialnotes) { echo html_entity_decode($productspecialnotes); } else { echo 'N/A'; } ?>
                </div>
                                
                <div class="divider-text">SEO Information</div>
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">SEO Title</label>
                <div class="mg-b-30">
                <?php if($productmetatitle) { echo $productmetatitle; } else { echo 'N/A'; } ?>
                </div>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Meta Description</label>
                <div class="mg-b-30">
                <?php if($productmetadescrption) { echo $productmetadescrption; } else { echo 'N/A'; } ?>
                </div>
                
                <label class="tx-sans tx-10 tx-medium tx-spacing-1 tx-uppercase tx-color-03 mg-b-10">Meta Keyword</label>
                <div class="mg-b-30">
                <?php if($productmetakeywords) { echo $productmetakeywords; } else { echo 'N/A'; } ?>
                </div>

            </div>
            
            <!-- side bar -->
            <div class="col-4">
            
            	<?php if($productseourl) { ?>
                    <a href="../product.php?token=<?php echo $productID.'-'.$productsku; ?>&<?php echo $productseourl; ?>" class="btn btn-block btn-outline-warning mg-b-10" target="_blank">
                        Preview <i class="fas fa-external-link-alt"></i>
                    </a>
				<?php } ?>
            
	            <h4 class="mg-b-25">Stock</h4>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td class="tx-medium">Status</td>
                        <td class="text-right"><?php echo $status_label; ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Stock Status</td>
                        <td class="text-right"><?php echo $productstock_status_label; ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Available Stock</td>
                        <td class="text-right"><?php echo $productavailablestock; ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Opening Stock</td>
                        <td class="text-right"><?php echo $productopeningstock; ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>            	

	            <h4 class="mg-b-25">Price Table</h4>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td class="tx-medium">Selling Price</td>
                        <td class="text-right"><?php echo formatCASH($productsellingprice); ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">MRP Price</td>
                        <td class="text-right"><?php echo formatCASH($productMRPprice); ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Purchase Price</td>
                        <td class="text-right"><?php echo formatCASH($productpurchaseprice); ?></td>
                      </tr>
                      <tr>
                        <td class="tx-medium">Customer Saves</td>
                        <td class="text-right"><?php echo formatCASH($productyousaveprice); ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                
                <h4 class="mg-b-25"></h4>
                <div class="row pd-0">
				<?php
				if($check_productimageAVAILABLE > 0) {
					
                  $productmedia_datas = sqlQUERY_LABEL("SELECT * FROM `js_productmediagallery` where productID='$productID' and productmediagallerytype='1' and deleted = '0' order by productmediagalleryorder ASC") or die("#1-Unable to get records:".mysql_error());
                
                  $count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);
                
                if($count_productmedia_availablecount > 0) {
                  while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
                      $productmediagalleryID = $row["productmediagalleryID"];
                      $productmediagalleryurl = $row["productmediagalleryurl"];
                      $productmediagalleryfeatured = $row["productmediagalleryfeatured"];
                      //image path
                      $media_path = "uploads/productmediagallery/$productmediagalleryurl";
                      
                      //update featured icon
                      if($productmediagalleryfeatured == '1') {
                        $featured_icon_select = '<i class="icon ion-md-heart text-warning"></i>';  
                      } else {
                        $featured_icon_select = '<i class="icon ion-md-heart"></i>';  
                      }
                      
                ?>
                    <div class="col-lg-6 col-sm-6 pd-5">
                        <figure class="pos-relative mg-b-0 pd-2 wd-lg-100p">
                          <img src="<?php echo $media_path; ?>" class="img-fit-cover img-thumbnail" alt="<?php echo $orginal_producttitle; ?>">
                          <figcaption class="pos-absolute b-0 l-0 wd-100p pd-20 d-flex justify-content-center">
                            <div class="btn-group">
                              <a href="javascript:;" class="btn btn-dark btn-icon" title="Set as Default"><?php echo $featured_icon_select; ?></a>
                              <a href="<?php echo $media_path; ?>" target="_blank" class="btn btn-dark btn-icon" title="Download"><i data-feather="download"></i></a>
                            </div>
                          </figcaption>
                        </figure>   
                    </div>
                <?php } } } ?>
                </div>
                
                <?php 
				if($check_productvideoAVAILABLE > 0) {	
					//get video-id
					$productmediavideo_id = getSINGLEDBVALUE('productmediagalleryurl', "productID='$parentproduct' and productmediagallerytype=2 and status='1' and deleted=0", 'js_productmediagallery', 'label');
				
				?>
        
                  <div class="text-center mg-t-40">
                  <a href="https://www.youtube.com/watch?v=<?php echo $productmediavideo_id; ?>" target="_blank">
                  <img src="https://img.youtube.com/vi/<?php echo $productmediavideo_id; ?>/mqdefault.jpg" class="img-thumbnail mg-t-5 mg-b-10" />
                  </a>
                  </div>
               <?php } ?> 
            </div>
        </div>
        <?php
		 } else { 
		 ?>
        <h3 class="text-center">No Record Found</h3>
        <?php }
		 } 
	?>
  </div><!-- container -->
</div><!-- content -->

    <div id="offproductSUMMARY" class="off-canvas off-canvas-overlay off-canvas-right wd-300">
      <a href="#" class="close"><i data-feather="x"></i></a>

      <div class="pd-10 pd-l-20 ht-100p tx-13 mg-t-40">
          <div class="row">
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Available Stock</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0"><?php echo $productavailablestock; ?></h4>
            </div>
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Views</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0">1,800</h4>
            </div>        
            
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Stock Value</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0"><?php echo formatCASH($productsellingprice*$productavailablestock); ?></h4>
            </div>        
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Revenue</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0">2,50,750</h4>
            </div>
        
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Rating Score</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0">4.5</h4>
            </div>    
                
            <div class="col-6 mg-b-10">
               <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-md-b-8">Avg. Views Per Day</h6>
               <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normaltx-spacing--2 tx-rubik mg-b-0">48</h4>
            </div>
            
            <div class="col-12 align-items-baseline mg-t-10 tx-rubik">
                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Product Summary</h6>
                <ul class="activity tx-13">
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-primary-light tx-primary wd-30 ht-30">
                      <i data-feather="check-circle"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Louise</strong> added a cart</p>
                      <small class="tx-color-03">2 hours ago</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-success-light tx-success wd-30 ht-30">
                      <i data-feather="heart"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Kevin</strong> added  to the wishlist</p>
                      <small class="tx-color-03">5 hours ago</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-warning-light tx-orange wd-30 ht-30">
                      <i data-feather="shopping-cart"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Natalie</strong> purchased the product <strong>ORD #111000011</strong></p>
                      <small class="tx-color-03">8 hours ago</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-pink-light tx-pink wd-30 ht-30">
                      <i data-feather="heart"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Katherine</strong> added to wishlist</p>
                      <small class="tx-color-03">Yesterday</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                  <li class="activity-item activity-item-custom">
                    <div class="activity-icon bg-indigo-light tx-indigo wd-30 ht-30">
                      <i data-feather="settings"></i>
                    </div>
                    <div class="activity-body">
                      <p class="mg-b-2"><strong>Katherine</strong> purchased the product <a href="" class="link-02"><strong>ORD #111000010</strong></a></p>
                      <small class="tx-color-03">2 days ago</small>
                    </div><!-- activity-body -->
                  </li><!-- activity-item -->
                </ul><!-- activity -->
                <a href="#" class="btn btn-block btn-outline-light">View All Activities</a>
          </div>
      </div>
      
    </div><!-- off-canvas -->
    </div>