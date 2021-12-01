<?php
$check_page = basename($_SERVER['PHP_SELF']);  
if($route == ''){$show_page = 'list';}else{$show_page = $route;}
$check_pagetype =  pageTYPE($show_page,'getid'); //echo $check_pagetype ;exit();
if($check_page != 'restricted.php'){
	$restricted_access = checkmenupage($check_page,$check_pagetype,$logged_user_level);
	if(checkmenupage($check_page,$check_pagetype,$logged_user_level) == '0'){
		//header("Location:restricted.php");
		echo "<script type='text/javascript'>window.location = 'restricted.php'</script>";	
	}
}

?>