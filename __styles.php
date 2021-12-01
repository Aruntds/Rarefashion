<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?php if(isset($commontitle)) { echo $commontitle.' | '; } ?>RARE Fashions</title>
<meta name="keywords" content="RARE Fashions">
<meta name="description" content="RARE Fashions">
<meta name="author" content="p-themes">
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo SITEHOME; ?>assets/images/icons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITEHOME; ?>assets/images/icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITEHOME; ?>assets/images/icons/favicon-16x16.png">
<link rel="manifest" href="<?php echo SITEHOME; ?>assets/images/icons/site.webmanifest">
<link rel="mask-icon" href="<?php echo SITEHOME; ?>assets/images/icons/safari-pinned-tab.svg" color="#666666">
<link rel="shortcut icon" href="<?php echo SITEHOME; ?>assets/images/logo-icon.png">
<meta name="apple-mobile-web-app-title" content="RARE Fashions">
<meta name="application-name" content="RARE Fashions">
<meta name="msapplication-TileColor" content="#cc9966">
<meta name="msapplication-config" content="<?php echo SITEHOME; ?>assets/images/icons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/easy-autocomplete.css">
<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/reviews.css">

<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/nouislider1.css">

<?php if($currentpage == 'shop.php' || $currentpage == 'category.php' || $currentpage == 'product.php' || $currentpage == 'product3.php' || $currentpage == 'product2.php' || $currentpage == 'product1.php') { ?>
	<!-- Plugins CSS File -->
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/bootstrap.min.css">
	<!-- Main CSS File -->
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/style.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/pagination.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/plugins/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/plugins/magnific-popup/magnific-popup.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/plugins/nouislider/nouislider.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/skins/skin-demo-7.css">
<?php } else { ?>
	<!-- Plugins CSS File -->
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/plugins/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/plugins/magnific-popup/magnific-popup.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/plugins/jquery.countdown.css">
	<!-- Main CSS File -->
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/style.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/skins/skin-demo-7.css">
	<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/font-face.css"/>	
    <link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/font-awesome.css">
<?php } ?>

<?php if($currentpage == 'dashboard.php') { ?>
		<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/pagination.css">
		<link rel="stylesheet" href="<?php echo SITEHOME; ?>assets/css/datepicker.css">
<?php } ?>