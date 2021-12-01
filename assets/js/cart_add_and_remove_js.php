<script type="text/javascript">
/* 
function addproducttocart(){
	var __ord_session = document.getElementById("current_session").value;
	var __ord_product_id = document.getElementById("product_id").value;
	var __ord_color_id = document.getElementById("color").value;
	var __ord_size_id = document.getElementById("size").value;
	var __ord_availablestock = document.getElementById("available_stock").value;
	var __ord_qty = document.getElementById("qty").value;
	var __ord_product_price = document.getElementById("idCombination").value;
	//alert(__ord_product_price)
	$.ajax({
		type:"POST",
        url: 'ajax/ajax_addto_cart.php' ,
		data:{
				//data: "&ord_session=" + SID + "&ord_product_id=" + PRDID + "&ord_color_id=" + PCOLOR + "&ord_size_id=" + PSIZE + "&ord_availablestock=" + PSTOCK + "&ord_qty=" + PQTY + "&ord_product_price=" + PPRICE,
				ord_session : __ord_session,
				ord_product_id : __ord_product_id,
				ord_color_id : __ord_color_id,
				ord_size_id : __ord_size_id,
				ord_availablestock : __ord_availablestock,
				ord_qty : __ord_qty,
				ord_product_price : __ord_product_price
			 },
		//type:'post',
        success: function(response) {
			//$("#cart-item").load();
			$('#showcartitem-count-bdg').html(response);
		   return true;
        
			}		
		});
} */

//Coupon Validate



//Remove Cart Item

function delete_cart_items(pd_id, od_qty, cart_id, var_id)
{
	var cart_ID = cart_id;
	var product_ID = pd_id;
	var product_qty = od_qty;
	var product_var_id = var_id;
	
	$.ajax({
		type : "POST",
		url : 'ajax/ajax_remove_cart_items.php',
		data : {
			product_ID : product_ID, product_qty : product_qty, product_var_id : product_var_id
		},
		success : function(response) {
			// var x = response;
			//$('#display-qty').html(response);
			//$('#showcartitem-count-bdg').html(response);
			//$('#total-price').html(response);
			//$('#product-price').html(response);
			//$('#sub-total').html(response);
			$("#delete-cart"+cart_id).hide();
			if(data['status'] == 'Success') {
				
				$.ambiance({message: "Product Is Removed From Your Cart", 

				type: "success",

				title: "Hello User !",

				fade: true,

				timeout: 5});
			}
		}
	})
}
</script>