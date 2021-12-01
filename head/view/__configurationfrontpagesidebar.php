<?php 
if($catalog_sidebar_view_type=='' || $catalog_sidebar_view_type=='list') {
?>
  <div class="col-lg-3 mg-t-40 mg-lg-t-0 d-sm-none d-md-block">

    <nav class="nav nav-classic tx-13">
      <a class="nav-link"><span>Active</span></a>
    </nav>

  </div><!-- col -->
<?php 

} 
//For Create Page
if($catalog_sidebar_view_type=='create') {
?>
  <div class="col-lg-3 mg-t-40 mg-lg-t-0 d-sm-none d-md-block">

    <h6 class="tx-uppercase tx-semibold mg-t-50 mg-b-15">Quick Links</h6>

    <nav class="nav nav-classic tx-13">
      <a href="#categorylisting" class="nav-link"><span>Category Listing</span></a>
      <a href="#featuredproduct" class="nav-link"><span>Featured Products</span></a>      
      <a href="#blogsettings" class="nav-link"><span>Blog Settings</span></a>      
      <!--<a href="#newsletter" class="nav-link"><span>Newsletter</span></a> -->     
    </nav>

  </div><!-- col -->
<?php } ?>