<?php

//$currentpage
class errorDisplayClass 
{
	
	//check empty text
	public function displayerror($data)
	{
		?>
        $.toast({
			heading: 'Please fix these error(s),',
			text: '<?php echo "$data"; ?>',
			position: 'bottom-right',
			stack: false,
			hideAfter: 6000,
			icon: 'error'
        });
        <?php
	}	
	
	
	
} //End of class

$displayERR_globalclass = new errorDisplayClass();
//echo $displayERR_globalclass->get_currentPAGENAME();

?>