<?php 
if($promobanner2_sidebar_view_type=='' || $promobanner2_sidebar_view_type=='list') {
?>
  <div class="col-lg-3 mg-t-40 mg-lg-t-0 d-sm-none d-md-block">

    <h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Summary</h6>

    <nav class="nav nav-classic tx-13">
      <a class="nav-link"><span>Active</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_promobanner', '`status`=1 and `promobannerTYPE`=2 and `deleted`=0'); ?></span></a>
      <a class="nav-link"><span>Inactive</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_promobanner','`status`=0 and `promobannerTYPE`=2 and `deleted`=0'); ?></span></a>
      <a class="nav-link"><span>Deleted</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_promobanner', '`deleted`=1 and `promobannerTYPE`=2'); ?></span></a>
    </nav>

  </div><!-- col -->
<?php 

} 
//For Create Page
if($promobanner2_sidebar_view_type=='create') {
?>
  <div class="col-lg-3 mg-t-40 mg-lg-t-0 d-sm-none d-md-block">

    <h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Quick Links</h6>

    <nav class="nav nav-classic tx-13">
      <a href="#basic" class="nav-link"><span>Promo Banner #2</span></a>
    </nav>

  </div><!-- col -->
<?php } ?>