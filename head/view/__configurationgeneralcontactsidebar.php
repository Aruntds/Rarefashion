<?php 
if($configurationgeneralcontact_sidebar_view_type=='' || $configurationgeneralcontact_sidebar_view_type=='list') {
?>
  <div class="col-lg-3 mg-t-40 mg-lg-t-0 d-sm-none d-md-block">

    <h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Summary</h6>

    <nav class="nav nav-classic tx-13">
      <a class="nav-link"><span>Active</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_category', '`status`=1'); ?></span></a>
      <a class="nav-link"><span>Inactive</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_category', '`status`=0'); ?></span></a>
      <a class="nav-link"><span>Deleted</span> <span class="badge"><?php echo commonNOOFROWS_COUNT('js_category', '`deleted`=1'); ?></span></a>
    </nav>

    <?php /*?><h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Sort by</h6>

    <nav class="nav nav-classic tx-13">
      <a href="" class="nav-link"><span>Title</span></a>
      <a href="" class="nav-link"><span>Created On</span></a>
    </nav><?php */?>

  </div><!-- col -->
<?php 

} 
//For Create Page
if($configurationgeneralcontact_sidebar_view_type=='create') {
?>
  <div class="col-lg-3 mg-t-40 mg-lg-t-0 d-sm-none d-md-block">

    <h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Quick Links</h6>

    <nav class="nav nav-classic tx-13">
      <a href="#basic" class="nav-link"><span>Basic Info</span></a>
     
    </nav>

  </div><!-- col -->
<?php } ?>