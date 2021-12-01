<script type="text/javascript">   
   function product_wishlist(idurl,varient_id){
	var product_id= idurl;	
	var product_size= varient_id;	
	//var product_size = document.getElementById("product_size").value;
	//alert(product_size);
	var customer_id= '<?php echo $logged_user_id ?>';
	
	if(customer_id){
        { 
		$.ajax({
         url: 'ajax/ajax_wishlist.php' ,
        data: {
				customer_id:customer_id,product_id:product_id,product_size:product_size
				},
		//type:'post',
                success: function(data) {
			var x = data;
			
			//alert(data['status']);
			
			if(data['status'] == 'Error') {
				 $.ambiance({message: "Item already Exist in your wishlist.", 

						type: "success",

						title: "Hello User !",

						fade: true,

						timeout: 5});
            }  
			if(data['status'] == 'Success') {
				
					   $.ambiance({message: "Item added in your wishlist.", 

						type: "success",

						title: "Hello User !",

						fade: true,

						timeout: 5});

              $("#wish_div").load(" #wish_div");
            }
			if(data['status'] == 'Incorrect') {
			  $("#save_profile").html("Password Mismatched");
				setTimeout(function () { $("#save_profile").html("Save Changes");  }, 5000);
             
            }
		
		   return true;
        
        }		
		});
		}
		$.get(location.href).then(function(page) {
		$(".wishlist").html($(page).find(".wishlist").html())
		})
		

	}else{
	//location.href="index.php?msg=signin_alert&type=information";
	   $.ambiance({message: "You must be login first.", 

		type: "error",

		title: "Hello User !",

		fade: true,

		timeout: 5});
	}
	}

    function remove_wish(id){
	//alert(id)	
	
		$.ajax({
         url: 'ajax/ajax_remove_wishlist.php' ,
        data: {
				id:id
				},
		//type:'post',
            success: function(data) {
				
			var x = data;
			  
			if(data['status'] == 'Success') {
				
				$("#wish_item"+id).hide();
				
					   $.ambiance({message: "Item Removed from your wishlist.", 

						type: "error",

						title: "Hello User !",

						fade: true,

						timeout: 5});

               $(".table-wishlist").load(" .table-wishlist");
            }
		   return true;
      
        }		
		});
		
		$.get(location.href).then(function(page) {
		$(".wishlist").html($(page).find(".wishlist").html())
		})
		
		$.get(location.href).then(function(page) {
		$(".wishitem").html($(page).find(".wishitem").html())
		})
	
	}
</script>
