<?php 
if($product_sidebar_view_type=='' || $product_sidebar_view_type=='list') {
?>
  <div class="col-lg-3 mg-t-40 mg-lg-t-0 d-sm-none d-md-block">

    <h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Summary</h6>

    <nav class="nav nav-classic tx-13">
      <a class="nav-link"><span>Active</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_content', '`status`=1 and `deleted`=0'); ?></span></a>
      <a class="nav-link"><span>Inactive</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_content', '`status`=0 and `deleted`=0'); ?></span></a>
      <a class="nav-link"><span>Deleted</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_content', '`deleted`=1'); ?></span></a>
    </nav>

    <?php /*?><h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Sort by</h6>

    <nav class="nav nav-classic tx-13">
      <a href="" class="nav-link"><span>Title</span></a>
      <a href="" class="nav-link"><span>Created On</span></a>
    </nav><?php */?>

  </div><!-- col -->
<?php 

} 

$productCRUXpage = array('s1', 's2', 's3', 's4', 's5', 's6');
//For Create Page
if(in_array($product_sidebar_view_type, $productCRUXpage)){
	
	//if (($key = array_search($product_sidebar_view_type, $productCRUXpage)) !== false) {
	//	unset($productCRUXpage[$key]);
	//}
	
	function productACTIVE($customSIDEBARVALUE, $product_sidebar_view_type=NULL) {
		if($customSIDEBARVALUE == $product_sidebar_view_type){
			echo 'active';
		} else { 
			echo 'disabled';
		}
	}
	
	//generate page link in product details already available
	
	
?>
  <div class="col-lg-3 pd-t-40 pd-b-30 mg-t-40 mg-lg-t-0 d-sm-none d-md-block bd bd-r-0">
    <!--  active / complete -->
      <ul class="steps steps-vertical">
        <li class="step-item <?php productACTIVE('s1', $product_sidebar_view_type); ?>">
          <a href="<?php echo $currentpage; ?>?route=step1&parentproduct=<?php echo $parentproduct; ?>" class="step-link">
            <span class="step-number">1</span>
            <div>
              <span class="step-title">Product Info</span>
              <span class="step-desc">Basic product details</span>
            </div>
          </a>
        </li>
        <li class="step-item <?php productACTIVE('s2', $product_sidebar_view_type); ?>">
          <a href="<?php echo $currentpage; ?>?route=step2&parentproduct=<?php echo $parentproduct; ?>" class="step-link">
            <span class="step-number">2</span>
            <div>
              <span class="step-title">Image & Video</span>
              <span class="step-desc">Customer Experience Images & Promotional Videos</span>
            </div>
          </a>
        </li>
        <li class="step-item <?php productACTIVE('s3', $product_sidebar_view_type); ?>">
          <a href="<?php echo $currentpage; ?>?route=step3&parentproduct=<?php echo $parentproduct; ?>" class="step-link">
            <span class="step-number">3</span>
            <div>
              <span class="step-title">Related & Upsell Product</span>
              <span class="step-desc">Complete The Collection / You may also like section</span> <!--Manage products Cross Selling-->
            </div>
          </a>
        </li>
        <li class="step-item <?php productACTIVE('s4', $product_sidebar_view_type); ?>">
          <a href="<?php echo $currentpage; ?>?route=step4&parentproduct=<?php echo $parentproduct; ?>" class="step-link">
            <span class="step-number">4</span>
            <div>
              <span class="step-title">SEO Settings</span>
              <span class="step-desc">Enables product to be Search Engine Friendly</span>
            </div>
          </a>
        </li>
        <li class="step-item <?php productACTIVE('s5', $product_sidebar_view_type); ?>">
          <a href="<?php echo $currentpage; ?>?route=step5&parentproduct=<?php echo $parentproduct; ?>" class="step-link">
            <span class="step-number">5</span>
            <div>
              <span class="step-title">Variants</span>
              <span class="step-desc">Filter Options of the product</span>
            </div>
          </a>
        </li>
        <li class="step-item <?php productACTIVE('s6', $product_sidebar_view_type); ?>">
          <a href="<?php echo $currentpage; ?>?route=step6&parentproduct=<?php echo $parentproduct; ?>" class="step-link">
            <span class="step-number">6</span>
            <div>
              <span class="step-title">Gift Option</span>
              <span class="step-desc">Allows customised gift message.</span>
            </div>
          </a>
        </li>
      </ul>    

  </div><!-- col -->
<?php } ?>