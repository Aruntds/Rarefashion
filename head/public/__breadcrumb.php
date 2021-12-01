<div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-style1 mg-b-10">
    <li class="breadcrumb-item">
      <a href="<?php echo $currentpage; ?>">
      <?php echo breadcrumbGENERATOR($currentpage, $route, 'mainPAGE'); ?>
      </a></li>
    <li class="breadcrumb-item active" aria-current="page">
      <?php echo breadcrumbGENERATOR($currentpage, $route, 'subPAGE'); ?>
    </li>
  </ol>
</nav>
<h4 class="mg-b-0"><?php include publicpath('__pagetitle.php');?> <?php echo ' &raquo; '.breadcrumbGENERATOR($currentpage, $route, 'productsubPAGETITLE'); ?></h4>
</div>