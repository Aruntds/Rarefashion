<?php 
	include 'head/jackus.php'; 
	include '___class__home.inc'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '__styles.php'; ?>	
</head>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
	<div class="page-wrapper">
    <?php 
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__header'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?> 

        <main class="main">
            <div class="container-fluid">
			<?php 
				//list of module view templates
				$loadFUNCTIONS = array(
				//'__homeslider',
				'__promobanner1',
				'__promobanner2'
				//'__testimonials'
				);
				
				echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
			
			?>
            <div class="mb-3"></div>
            </div>
            <?php 
				//list of module view templates
				$loadFUNCTIONS = array(
				'__homeicons',
				'__featuredproduct',
				'__frontcategoryproduct'
				//'__testimonials'
				);
				
				echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
			
			?>
        </main>

    <?php
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__footer',
		'__scripts'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?>     
	</div>
	
 <script src="<?php echo SITEHOME; ?>assets/js/jquery.easy-autocomplete.min.js"></script>
    
	
	<script>
	var stock_record = {
			url: function(phrase) {
				return "ajax/ajax_search_products.php?product_info=" + phrase + "&format=json";
			},
			getValue: "product_details",
			template: {
				type: "iconRight",
				fields: {
				  iconSrc: "icon"
				}
			  },

			list: {
				onChooseEvent: function() {
					get_productdtls_List();
				},	
				match: {
                    enabled: false
                },
				
				hideOnEmptyPhrase: true
            },
			theme: "square"
		 };


        $("#productdata").easyAutocomplete(stock_record);
		
		
		function get_productdtls_List()
		{
			var productinfo =document.getElementById( "productdata" ).value;
			
			// alert(vpo_id);
			
		   if(productinfo)
		   {
			   //$('#progress_table').show();
			   $.ajax({
					   type: 'post', 
					   url: 'ajax/ajax_search_productname.php',
					   data: { productinfo:productinfo,
				   },
				   success: function (response) {
						location.assign(response);
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}	
		
		
	</script>
</body>

</html>
