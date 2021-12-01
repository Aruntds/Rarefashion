    <!-- Plugins JS File -->
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.hoverIntent.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.waypoints.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/superfish.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/owl.carousel.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
<?php if($currentpage == 'shop1.php' || $currentpage == 'shop.php' || $currentpage == 'cart.php') { ?>
    <script src="<?php echo SITEHOME; ?>assets/js/wNumb.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/bootstrap-input-spinner.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/nouislider.min.js"></script>
	    <script src="<?php echo SITEHOME; ?>assets/js/nouislider.min.js"></script>
    <!-- Main JS File -->
    <script src="<?php echo SITEHOME; ?>assets/js/main.js"></script>	
<?php } elseif($currentpage == 'product.php' || $currentpage == 'product3.php' || $currentpage == 'product2.php' || $currentpage == 'product1.php') { ?>
    <script src="<?php echo SITEHOME; ?>assets/js/bootstrap-input-spinner.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.elevateZoom.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/bootstrap-input-spinner.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.magnific-popup.min.js"></script>
 <script src="<?php echo SITEHOME; ?>assets/js/jquery.sticky-kit.min.js"></script>
    <!-- Main JS File -->
    <script src="<?php echo SITEHOME; ?>assets/js/main.js"></script>
<?php } else { ?>
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.plugin.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/jquery.countdown.min.js"></script>
    <!-- Main JS File -->
    <script src="<?php echo SITEHOME; ?>assets/js/main.js"></script>
    <script src="<?php echo SITEHOME; ?>assets/js/demos/demo-10.js"></script>
<?php } ?>

<link href="<?php echo SITEHOME; ?>assets/css/jquery.ambiance.css" rel="stylesheet" type="text/css">
<script src="<?php echo SITEHOME; ?>assets/js/jquery.ambiance.js" type="text/javascript"></script>
 <script src="<?php echo SITEHOME; ?>assets/js/jquery.easy-autocomplete.min.js"></script>
 <script src="<?php echo SITEHOME; ?>assets/js/bootstrap-datepicker.js"></script>
<?php
include_once('assets/js/wishlistjs.php');
include_once('assets/js/cart_add_and_remove_js.php');
?>

<?php

//getting error notification

/*

Help text

$new_product_insertion - adding new product to table

$product_qty_update  -  updating new quantity

$outof_stock_detail - checking out of stock

*/



if($new_product_insertion) {

	$type = "success";

	$title = "Success ";

	$message = "New product added to you cart !";

}

if($product_qty_update) {

	$type = "success";

	$title = "Updated";

	$message = "Your shopping cart is now updated !";

}

if($outof_stock_detail) {

	$type = "error";

	$title = "Out of stock";

	$message = "Oops the product you have choosen was out of stock, you can add it to your wish list to check later !";

}



if($typed_higher_quantity) {

	$type = "error";

	$title = "Quantiy Exceeded";

	$message = "Required no. of quantity not available !";

}



if($prduct_addedto_wishlist) {

	$type = "success";

	$title = "Wishlist Added";

	$message = "Selected product added to your wishlist !";

}



//check user logged in or not

if($_GET['action']=='nolog') {

	$type = "default";

	$title = "Restricted access";

	$message = "Please login before accessing that page !";

	$access_restricted = true;

}



//msg=updated&type=address

if($_GET['msg']=='updated' && $_GET['type'] == 'address') {

	$type = "success";

	$title = "Address updated";

	$message = "Your address updated !";

	$address_updated = true;

}



if($_GET['msg']=='updated' && $_GET['type'] == 'personal') {

	$type = "success";

	$title = "Personal Detail";

	$message = "Your personal details updated !";

	$personal_updated = true;

}

if($_GET['msg'] == 'cart_updated'){
	
	$type = "success";
	
	$title = "Cart Updated";
	
	$message = "Your cart is updated";
	
	$personal_updated = true;
}



if($new_product_insertion || $product_qty_update || $typed_higher_quantity || $access_restricted || $address_updated || $personal_updated || $prduct_addedto_wishlist) {

?>

<script type="text/javascript">

   $(document).ready(function() {

	   $.ambiance({message: "<?php echo $message; ?>", 

		type: "<?php echo $type; ?>",

		title: "<?php echo $title; ?>",

		fade: true,

		timeout: 5});

   });

</script> 

<?php

}



//next set of popup

//msg=log_out&type=information



if($_GET['msg']=='log_out' && $_GET['type'] == 'information') {

	$type = "success";

	$title = "Thank you";

	$message = "Your are now logged out, come back soon!";

	$logged_out = true;

}

if($_GET['msg']=='log_out') {

	$type = "success";

	$title = "Thank you";

	$message = "Your are now logged out, come back soon!";

	$logged_out = true;

}


if($_GET['msg']=='log_out1') {

	$type = "error";

	$title = "Hello User !";

	$message = "Email and Password Incorrect";
  
	$logged_out = true;

}



//msg=login&type=information



if($_GET['msg']=='login' && $_GET['type'] == 'information') {

	$type = "success";

	$title = "Hello $first_name";

	$message = "Welcome back to Getin Gateway !";

	$logged_in = true;

}


if($_GET['msg']=='error') {

	$type = "error";

	$title = "Hello User !";

	$message = "your email is already registered";

}
//msg=newuser&type=information



if($_GET['msg']=='newuser' && $_GET['type'] == 'information') {

	$type = "success";

	$title = "Welcome Guest !";

	$message = "Please check your email for activation link.";

	$logged_in = true;

}


if($_GET['msg']=='signin_alert' && $_GET['type'] == 'information') {

	$type = "Error";

	$title = "Hello User !";

	$message = "You must be login first.";

	$logged_in = true;

}

//Cart Added Msg start

if($_GET['prdt_details']=='cart_added2' || $_GET['prdt_details'] == 'cart_added1') {

	$type = "success";

	$title = "Hi! Check Your Cart";

	$message = "Product Added to your Cart !";

	$logged_in = true;

}

//Cart Added Msg End


//Product Out Of Stock Error Msg

if($_GET['prdt_error'] == 'outofstock1' || $_GET['prdt_error'] == 'outofstock2' || $_GET['prdt_error'] == 'outofstock3' || $_GET['prdt_error'] == 'outofstock4'){
	
	$type = "error";

	$title = "Hi!";

	$message = "Product is Out of Stock ! ";

	$logged_in = true;
	
}


if($logged_out || $logged_in) {

?>

<script type="text/javascript">

   $(document).ready(function() {

	   $.ambiance({message: "<?php echo $message; ?>", 

		type: "<?php echo $type; ?>",

		title: "<?php echo $title; ?>",

		fade: true,

		timeout: 5});

   });

</script> 

<?php } ?>
<script type="text/javascript">
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
}
</script>
<script type="text/javascript">
    function signup() {

   var email = document.getElementById('register_email').value;
   var pwd = document.getElementById('register_password').value;
 // var checkedValue = document.getElementById('.register-policy-input:checked').value;
//alert(checkedValue);
//if(checkedValue == '1'){
	 if(email ==''){
		
		$.ambiance({message: "Please enter valid email id",
		type: "error",
        title: "Hello User !",
		fade: false,
		timeout: 5
		});
		
		return false;
	 }
	 if(pwd =='')
	 {
		
		 $.ambiance({message: "Please enter Password",
		type: "error",
        title: "Hello User !",
		fade: false,
		timeout: 5
		});
		 return false;
	 }
if(email != "" && pwd !="")
	{
       $.ajax({
         url: 'ajax/ajax_registration.php' ,
         data: {
				email:email,pwd:pwd
				},
		//type:'post',
        success: function(data) {
			
			if(data =='1'){
				$.ambiance({message: "your email is already registered",
		        type: "error",
                title: "Hello User !",
		        fade: false,

		        timeout: 5
		});
			}else{
				location.href="dashboard.php?email="+email;
		        return true;
			}
		
        
           }		
       });
	}
	// }else{
		
		 // alert();
		// $.ambiance({message: "Please checked the privacy policy",
		// type: "error",
        // title: "Hello User !",
		// fade: false,
		// timeout: 5
		// });
		
		// return false;
		
	// }
}


    function sign_in() {

   var email = document.getElementById('singin_email').value;
   var pwd = document.getElementById('singin_password').value;
  if(email ==''){
		
		$.ambiance({message: "Please enter valid email id",
		type: "error",
        title: "Hello User !",
		fade: false,
		timeout: 5
		});
		
		return false;
	 }
	 if(pwd =='')
	 {
		
		 $.ambiance({message: "Please enter Password",
		type: "error",
        title: "Hello User !",
		fade: false,
		timeout: 5
		});
		 return false;
	 }
       $.ajax({
         url: 'ajax/ajax_login.php?type=password' ,
         data: {
				email:email,pwd:pwd
				},
		type:'post',
        success: function(data) {
			var x = data;
			// var y = JSON.parse(x);
			
			// if(y.status == 'Error') {
				// $("#signin_pwd").html("Password Incorrect");
            // }  
			// if(y.status == 'Success') {
		 
			// location.href="myaccount.php";

              // // //$('#mymodal').modal('hide');
			  
            // }
		
		if(data['status'] == 'Error') {
			
			$.ambiance({message: "Email and Password Incorrect", 

		        type: "error",

                title: "Hello User !",

		        fade: false,

		        timeout: 5
		});
			
				// $("#signin_pwd").html("Password Incorrect");
				// setTimeout(function () { $("#signin_pwd").html("Login"); }, 3000);
				
            }  
			if(data['status'] == 'Success') {
				
				//alert("Login Successfully")
		 
		 $.ambiance({message: "Login Successfully", 

		        type: "success",

                title: "Hello User !",

		        fade: false,

		        timeout: 5
		});
			location.href="<?php echo curPageURL(); ?>?email="+email;

              // //$('#mymodal').modal('hide');
			  
            }
		

		   return true;
        
        }		
    });
	
	}

	function generateOTP() {

		var digits = '0123456789';
		let OTP = '';
		for (let i = 0; i < 4; i++) {
			OTP += digits[Math.floor(Math.random() * 10)];
		}
		return OTP;
	}


	function sendotp_login() {
		
	var singin_email = document.getElementById('singin_email').value;
	
	if(singin_email != '' && validateEmail(singin_email) == true){
		// $("#pwd_div").hide();
		// $("#otp_div").show();
		// $("#signin_btn").hide();
		// $("#hide_otp").hide();
		// $("#otp_btn").show();
		var otp = generateOTP();
	
		$.ajax({
			
			 url: 'ajax/otpmail.php?email='+singin_email+'&otpmsg='+otp ,
			 data: {
					singin_email:singin_email
					},
			  type: "post",
			
			success: function(data) {
				
			//var x = data;
			if(data['status'] == 'Success') {
				    $("#resend_otp").hide();
					$("#pwd_div").hide();
					$("#otp_div").show();
					$("#signin_btn").hide();
					$("#hide_otp").hide();
					$("#otp_btn").show();
					window.value = otp;
					$("#endtime_div").show();
					let timerOn = true;

					function timer(remaining) {
					 var m = Math.floor(remaining / 60);
					 var s = remaining % 60;
					 
					 m = m < 10 ? '0' + m : m;
					 s = s < 10 ? '0' + s : s;
					 document.getElementById('endtimer').innerHTML = m + ':' + s;
					 remaining -= 1;

					 if(remaining >= 0 && timerOn) {
					setTimeout(function() {
					timer(remaining);
					}, 1000);
					return;
					 }

					 if(!timerOn) {
					return;
					 }
					 $("#send_otpdiv").show();
					 $("#endtime_div").hide();
					 $("#resend_otp").show();
					}
					timer(180);
             

					if (response == "OK") {
					} else { return false; }
				} else if(data['status'] == 'Error') {
					$.ambiance({message: "Please Enter a Valid Email Address", 

							type: "error",

							title: "Hello User !",

							fade: false,

							timeout: 5
					});
				}
			}
		});
		$("#num_otp").focus();
		$('#num_otp').attr('autofocus' , 'true');	
	} else if(singin_email == '') {
		$.ambiance({message: "Please Enter Email Address", 

		        type: "error",

                title: "Hello User !",

		        fade: false,

		        timeout: 5
		});
	} else if(validateEmail(singin_email) == false) {
		$.ambiance({message: "Please Enter Valid Email Address", 

		        type: "error",

                title: "Hello User !",

		        fade: false,

		        timeout: 5
		});
	} 

	}

	function verify_otp_login() {
		
	   var otp = window.value;

	   var otp_password = document.getElementById('otp_password').value;
	   var singin_email = document.getElementById('singin_email').value;
	 if(singin_email){ 
	 if(otp_password == otp){

		$('#pleasewait-loader').show();
	   location.href="dashboard.php?email="+singin_email;
			  $('#pleasewait-loader').hide();
			
		
		

	 }else{
		 $.ambiance({message: "MISMATCHED OTP", 

		        type: "error",

                title: "Hello User !",

		        fade: false,

		        timeout: 5
		});
		 
		 
		// $("#signin_otp").html("MISMATCHED OTP");
		// setTimeout(function () { $("#signin_otp").html("Verify OTP"); $('#otp_password').val('');}, 3000);
	 }

	}else{
		
		$.ambiance({message: "Email shouldn't be Empty", 

		        type: "error",

                title: "Hello User !",

		        fade: false,

		        timeout: 5
		});
		
	//alert("Email shouldn't be Empty");
	}
	}	
	
//Profile Update	

function cus_profile() {
   var cus_name = document.getElementById('cus_name').value;
   var cus_email = document.getElementById('cus_email').value;
   var customeraddress1 = document.getElementById('customeraddress1').value;
   var customeraddress2 = document.getElementById('customeraddress2').value;
   var new_pwd = document.getElementById('new_pwd').value;
   var confirm_pwd = document.getElementById('confirm_pwd').value;
   var id = '<?php echo $logged_user_id ?>';
   var password ='<?php echo $password ?>';
   $("#save_profile").html("Saving Changes..");
  if(cus_name == ''){
	  
	   $.ambiance({message: "Plese enter name", 

						type: "error",

						title: "Hello User !",

						fade: true,

						timeout: 5});
						
						return false;
  }
  if(cus_email == ''){
	  
	   $.ambiance({message: "Plese enter email id", 

						type: "error",

						title: "Hello User !",

						fade: true,

						timeout: 5});
						return false;
	  
  }

       $.ajax({
         url: 'ajax_profile_crux.php' ,
         data: {
				cus_name:cus_name,cus_email:cus_email,customeraddress1:customeraddress1,customeraddress2:customeraddress2,new_pwd:new_pwd,confirm_pwd:confirm_pwd,id:id,pwd:password
				},
		type:'post',
        success: function(data) {
			var x = data;
			if(data['status'] == 'Error') {
				$("#save_profile").html("Old password Incorrect");
				setTimeout(function () { $("#save_profile").html("Save Changes");  }, 5000);
            }  
			if(data['status'] == 'Success') {
				
			  $("#save_profile").html("Changes Updated");
				setTimeout(function () { $("#save_profile").html("Save Changes");$('#cus_pwd').val('');$('#new_pwd').val('');$('#confirm_pwd').val('')  }, 5000);
				
					   $.ambiance({message: "Your Changes Updated.", 

						type: "success",

						title: "Hello User !",

						fade: true,

						timeout: 5});

              
            }
			if(data['status'] == 'Incorrect') {
			  $("#save_profile").html("Password Mismatched");
				setTimeout(function () { $("#save_profile").html("Save Changes");  }, 5000);
             
            }
		
		   return true;
        
        }		
    });
	
   
}
//Profile Update End 

	function getresult(url) {
	        var filterby = get_filter('filterby');
 // alert(filterby)
	$.ajax({
		url: url,
		type: "post",
		data:  {rowcount:$("#rowcount").val(),"pagination_setting":"all-links",filterby:filterby},
		beforeSend: function(){$("#overlay").show();},
		success: function(data){
		$("#pagination-result").html(data);
		setInterval(function() {$("#overlay").hide(); },500);
		},
		error: function() 
		{} 	        
    });
	}

	// $( document ).ready(function() {
		// var urlParams = new URLSearchParams(window.location.search);
		
		// if(urlParams.get('nav')!="order" && urlParams.get('mode')!="cancel"){ 
			// getresult("ajax/shop_pagination.php");
		// }
	// });	
 
 function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }	
	
	// $('.common_selector').click(function(){
        // getresult("ajax/shop_pagination.php");
    // });
	
	//Update Cart
	
	function update_cart(prdt_id, prdt_var_id){
		
		var prdt_id = prdt_id;
		var prdt_var_id = prdt_var_id;
		var prdt_qty = document.getElementById('dispaly-qty').value;
		//alert(prdt_qty);
		$.ajax({
		type : "POST",
		url : 'ajax/ajax_update_cart.php',
		data : {
			product_ID : prdt_id, product_var_id : prdt_var_id
		},
		success : function(response) {
			// var x = response;
			//$('#display-qty').html(response);
			//$('#showcartitem-count-bdg').html(response);
			//$('#total-price').html(response);
			//$('#product-price').html(response);
			//$('#sub-total').html(response);
			//$("#delete-cart"+cart_id).hide();
			/* if(data['status'] == 'Success') {
				
				$.ambiance({message: "Product Is Removed From Your Cart", 

				type: "success",

				title: "Hello User !",

				fade: true,

				timeout: 5});
			} */
			return true;
		}
	})
	
	}
	
	$("#shipping_address").hide();
	$("#different_address").click(function() {
		if($(this).is(":checked")) {
			$("#shipping_address").show();
		} else {
			$("#shipping_address").hide();
		}
	});
	
	$(".cod").hide();
	$(".paypal_content").hide();
	$(".bank_transfer").hide();
	
	$("input[name='payment_type']").click(function() { 
	
	var payment_type = $("input[name='payment_type']:checked").val();
	
	if(payment_type == 'bt'){
		
	$(".cod").hide('slow');
	$(".paypal_content").hide('slow');
	$(".bank_transfer").show('slow');
		
	} else if(payment_type == 'razor'){
		
	$(".cod").hide('slow');
	$(".paypal_content").show('slow');
	$(".bank_transfer").hide('slow');
		
	} else if(payment_type == 'cod'){
		
	$(".cod").show('slow');
	$(".paypal_content").hide('slow');
	$(".bank_transfer").hide('slow');	
		
	}

	});
	
	//change address
	function billing_addresschange(){
	 
	$("#billing_address_edit").show();
	$("#billing_address").hide();

 }  
 function shipping_addresschange(){
	 
	$("#shipping_address_edit").show();
	$("#shipping_address").hide();

 } 
 
 
	 function getSIZE(variant_ID, price,mrp_price,COUNT){
		
		var variant_ID = variant_ID;
		
		var mrp_price = '<?php echo general_currency_symbol; ?>'+(mrp_price);
		var price = '<?php echo general_currency_symbol; ?>'+(Math.round(price * 100) / 100).toFixed(2);
	//alert(mrp_price);
		document.getElementById('product_size').value = variant_ID;
		
		if(COUNT > 1){
			$('#variant_size_display').removeClass('active');
		}
		
		$.ajax({
		  url: 'ajax/ajax_addtocart.php?type=check_stock_status',
		  data: { __variant_ID:variant_ID, },
		  type: 'post',
		  success: function(response){
			$('#show_ajax_stock_response').html(response);
			$('#defalut_instock').hide();
			$('#default_price').hide();		
			
			var res = response.split("<span");
			//alert(res);
			var split_text = res[1];
			var result = split_text.split(" ");
			var get_status = result[1] + result[2];	
		//	alert(get_status);
			if(get_status == 'class="text-success">In') {
				
		  document.querySelector('#variant_price').innerHTML = price;
		  document.querySelector('#variant_price1').innerHTML = mrp_price;
				
				$("#add_to_cart_in_details").removeAttr("disabled");
            } else if(get_status == 'class="text-danger">Out') {
				 document.querySelector('#variant_price').innerHTML = price;
				 document.querySelector('#variant_price1').innerHTML = mrp_price;
				$("#add_to_cart_in_details").attr( "disabled", "disabled" ); 
            } else if(get_status == '>N/A') {
				//$("#add_to_cart_in_details").attr( "disabled", "disabled" );
            }
		  }
		});	
	}
	
	//removing Order Items
	function remove_quickitem_List(deleting_quicklink_id)
	{
		var cartid = deleting_quicklink_id;	
		//alert('#dummy_po_list_'+po_prdt_id);
	   if(cartid)
	   {
		   //$('#progress_sales_table').show();
		   $.ajax({
				   type: 'post', url: 'ajax/ajax_addtocart.php?type=remove_item',
				   data: { cartID:cartid,
			   },
			   success: function (response) {
				  // $('#progress_sales_table').hide();
					//cart_item_removed();
				   $('#show-sales-list').html(response);
				   $('#cart_item-'+cartid).remove();
				   if(response=="OK") { 
				   return true;  
				   } else { return false; }
			  }
		   });
		}
	}
	
function IsAlphaNumeric(e) {
         var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
         var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || keyCode == 32 || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
         document.getElementById("error").style.display = ret ? "none" : "inline";
         return ret;
     }
	 
function add_review() {

	var review_name = document.getElementById('review_name').value;
	var product_ID = document.getElementById('product_id').value;
	var review_email =document.getElementById( "review_email" ).value;
	var rating = $("input[name='rating']:checked").val();
	var review_discription =document.getElementById( "review_discription" ).value;
	// document.getElementById('review_name').value = '';
	// document.getElementById( "review_email" ).value = '';
	// document.getElementById( "review_discription" ).value ='';
		
	if(review_name != '' && review_email != '' && rating != '' && rating!= undefined && review_discription != ''){
    $.ajax({
        
         url: 'ajax/add_review.php',
         data: {
				product_ID:product_ID,review_name:review_name,rating:rating,review_email:review_email,review_discription:review_discription
				},
		
		
        success: function(response) 
		    {				
				$.ambiance({message: "Review Received.", 

				type: "success",

				title: "Hello User !",
				
				color: 'green',
				
				fade: false,

				timeout: 5
				});
				setInterval('location.reload()', 5000);
			}
    });
	
	 } else {
		 
		 
		 $.ambiance({message: "Fill All the Required Fields", 

		type: "error",

        title: "Hello User !",

		fade: false,

		timeout: 5
		});
		 
		
	 }

	}
	

		// $( document ).ready(function() {
// var search_value ='<?php echo $search_value; ?>';
// var token ='<?php echo $_GET['token']; ?>';

		// var urlParams = new URLSearchParams(window.location.search);
		
		// if(urlParams.get('nav')!="order" && urlParams.get('mode')!="cancel"){ 
			// getresult("ajax/shop_pagination.php?search_value=search_value&token=token");
		// }
		// });
	
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

		function get_productdtls_header_products()
		{

			var productinfo =document.getElementById( "header_search" ).value;
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

function add_order_review(order_ID)
{
	var order_ID = order_ID;
	var review_name = document.getElementById('review_name').value;
	var review_email = document.getElementById('review_email').value;
	var rating = $("input[name='ratings-val']:checked").val();
	var review_discription = document.getElementById('review_discription').value;
	
	/* alert(order_ID)
	alert(review_name)
	alert(review_email)
	alert(rating)
	alert(review_discription) */
	
	if(review_name != '' && review_email != '' && rating != '' && review_discription != ''){
		
		$.ajax({
         url: '<?php echo SITEHOME; ?>ajax/add_order_review.php',
         data: {
				order_ID:order_ID,review_name:review_name,review_email:review_email,rating:rating,review_discription:review_discription
				},
		 // type: "post"
		
        success: function(response) {
           $.ambiance({message: "Review Received",
						type: "success",
						title: "Hi!",
						fade: true,
						timeout: 5});
		setTimeout(function () { location.assign("<?php echo SITEHOME; ?>myorders.php?mode=preview&odid="+order_ID); }, 1000);
            if (response == "OK") {
            } else { return false; }
        }
    });
		
	} else {
		
		$.ambiance({message: "Please Enter Your comment",
		type: "error",
		title: "Hi!",
		fade: true,
		timeout: 5});
		
	}
	
}

</script>
<script>
 function shipping_addresschange_add(){
	 
	$("#shipping_address_add").show();
	$("#shipping_address_edit").hide();
	$("#card_address").hide();
 } 
 function shipping_addresschange(delete_id){
	var cardid = delete_id;	
	var customer_id= '<?php echo $logged_user_id ?>';
	 
	if(cardid != '' && customer_id != '')
		   {
			   $('#loadingORDER').show();
			   $.ajax({
					   type: 'post', url: 'ajax/ajax_edit_shipping_address.php?type=getaddress_info',
					   data: { cardid:cardid, customer_id:customer_id,
				   },
				   success: function (response) {
					   $("#shipping_address_edit").show();
						$("#shipping_address_add").hide();
					   $('#displayEditShippingaddress').html(response);
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}

 } 

function shipping_address_delete(card_id){
	$('#shipping_address_add').hide();
	var cardid = card_id;	
	var customer_id= '<?php echo $logged_user_id ?>';
     $.ajax({
         url: 'ajax/ajax_shipping_remove.php?type=delete' ,
        data: {
				customer_id:customer_id,cardid:cardid
				},
		//type:'post',
                success: function(data) {
					  // $("#wishlist_count").load(" #wishlist_count");
					 // $("#wishlist"+wish_id).removeClass(' active'); 
			var x = data;			
			if(x['status'] == 'Success') {
			    
				//$('#wishdiv_'+wish_id).hide();
				address_removed();
				location.reload();
				$('#card_address').load('address.php #card_address');
            }

		   return true;
        
        }		
		});
} 
		function address_removed() {
		  $.ambiance({
			
			message: "Address Removed", 

			type: "error",

			title: "Hi!",

			fade: true,

			timeout: 5
		});
	  }
	  
	  function form_display_shipping_address(){
	$('#addressDATA').modal({show:true});
 }
 
  function check_address(id){
	$("#add_shipping_address").show();
	$('#addressDATA').modal('hide');
	//alert(id)
	$.ajax({	 
	 url: 'ajax/ajax_get_address.php',
	 data: {
			id:id
			},
	 
		success: function(data) {
		  
			var x = data;
		 
			$("#billing_first_name").val(x['fname']);
			$("#billing_last_name").val(x['lname']);
			$("#billing_email").val(x['email']);
			$("#billing_phone").val(x['phone']);
			$("#billing_address_1").val(x['street1']);
			$("#billing_address_2").val(x['street2']);
			$("#billing_city").val(x['city']);
			$("#billing_state").val(x['state']);
			$("#billing_postcode").val(x['pin']);
			$("#billing_country").val(x['country']);

		}
	});

 }
 
 function validate_coupon()
{
	var coupon_code = document.getElementById('coupon_code').value;
	var od_total_value = document.getElementById('order_total').value;
	var hidden_od_id = document.getElementById('od_id').value;
	/* alert(coupon_code)
	alert(od_total_value)
	alert(hidden_od_id) */
	$.ajax({
		type: "POST",
		url: 'ajax/ajax_validate_coupon.php',
		data: {
			coupon_code:coupon_code,od_total_value:od_total_value,hidden_od_id:hidden_od_id
		},
		success : function(data){
			// var x = response;
			if(data['status'] == 'Success'){
				
				$.ambiance({message: "You Entered Valid Coupon Code", 

						type: "success",

						title: "Hi!",

						fade: true,

						timeout: 5});
						setTimeout(function () { location.assign("<?php echo SITEHOME; ?>cart.php"); }, 5000);
			} else if(data['status'] == 'Error_No_Record') {
				
				$.ambiance({message: "You Entered In-Valid Coupon Code", 

						type: "error",

						title: "Hi!",

						fade: true,

						timeout: 5});
				
			} else if(data['status'] == 'Error_Expired') {
				
				$.ambiance({message: "Promocode Expired", 

						type: "error",

						title: "Hi!",

						fade: true,

						timeout: 5});
				
			}
			return true;
		}
	})
}
 
 function remove_coupon(){
	 
	var hidden_od_id = document.getElementById('od_id').value; 
	
	var type_remove_coupon = 1;
	
	$.ajax({
		type: "POST",
		url: 'ajax/ajax_validate_coupon.php',
		data: {
			hidden_od_id:hidden_od_id, type_remove_coupon:type_remove_coupon
		},
		success : function(data){
			// var x = response;
			if(data['status'] == 'Success'){
				
				$.ambiance({message: "Coupon Removed", 

						type: "success",

						title: "Hi!",

						fade: true,

						timeout: 5});
						setTimeout(function () { location.assign("<?php echo SITEHOME; ?>cart.php"); }, 5000);
			} else {
				
				$.ambiance({message: "Coupon Not Removed", 

						type: "error",

						title: "Hi!",

						fade: true,

						timeout: 5});
				
			}
			return true;
		}
	})
	 
 }
 
		// // cart_quantity_update(hidden_cart_ID, hidden_PRDT_ID)
 // function cart_quantity_update(){
	 
	// var hidden_od_id = document.getElementById('od_id').value; 
	// var hidden_cart_ID = document.getElementById('hidden_cart_ID').value; 
	// var hidden_PRDT_ID = document.getElementById('hidden_PRDT_ID').value; 
	// var display_qty = document.getElementById('dispaly-qty'+hidden_cart_ID).value; 
	
	// $.ajax({
		// type: "POST",
		// url: 'ajax/ajax_cart_quantity_update.php',
		// data: {
			// hidden_od_id:hidden_od_id, selected_CARTID:hidden_cart_ID, selected_PRDTID:hidden_PRDT_ID, selected_PRDTQTY:display_qty
		// },
		// success : function(data){
			// // var x = response;
			// if(data['status'] == 'Success'){
				
				// $.ambiance({message: "Cart Updated", 

						// type: "success",

						// title: "Hi!",

						// fade: true,

						// timeout: 5});
						// $("#qty_total_update").load("cart.php #qty_total_update");
						// $("#summary-cart").load("cart.php #summary-cart");
						// // setTimeout(function () { location.assign("<?php echo SITEHOME; ?>cart.php"); }, 5000);
			// } else if(data['status'] == 'Error_Stock') {
				
				// $.ambiance({message: "Out of Stock!", 

						// type: "error",

						// title: "Hi!",

						// fade: true,

						// timeout: 5});
				
			// } else if(data['status'] == 'Error') {
				
				// $.ambiance({message: "Cart is not updated", 

						// type: "error",

						// title: "Hi!",

						// fade: true,

						// timeout: 5});
				
			// }
			// return true;
		// }
	// })
	 
 // }
 
 <?php if($nav == 'address' && $msg == 'add_address') { ?>
	$.ambiance({
		
		message: "New Address Created Successfully", 

		type: "success",

		title: "Hi!",

		fade: true,

		timeout: 5
	});
 <?php } if($nav == 'address' && $msg == 'update_address') { ?>
	$.ambiance({
		
		message: "Selected Address Updated", 

		type: "success",

		title: "Hi!",

		fade: true,

		timeout: 5
	});
 <?php } ?>
 
 
 function collectOrder_RECORD()
		{
			//alert();
			var order_id = document.getElementById( "ord_ref_no" ).value;	
			var order_email = document.getElementById( "ord_email" ).value;	
			
		   if(order_id != '' && order_email != '')
		   {
			   $('#loadingORDER').show();
			   $.ajax({
					   type: 'post', url: 'ajax/ajax_order_details.php?type=getorder_info',
					   data: { order_info:order_id, order_EMAIL:order_email,
				   },
				   success: function (response) {
					  // alert();
					   $('#loadingORDER').hide();
					   $('#hide_on_ajax_response').hide();
					   $('#back_to_track').show();
					   $('#show_default_order_history_response').hide();
					   $('#displayORDERDATA').html(response);
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}
	
		
	function forgot_password(){
		 
		$('.form-tab').hide();
		
		$('#forgot_pwd').show();
	}
	
function sendotp_forgot_pwd() {

   var forget_email = document.getElementById('forgot_email').value;  
   
   var otp = generateOTP();
   
	if(forget_email){	
		$.ajax({       
		 //url: 'ajax/otpmail.php?email='+singin_email+'&otpmsg='+otp ,
			 url: 'ajax/otpmail.php?email='+forget_email+'&otpmsg='+otp,
			 data: {},
			 type: "post",
			
			success: function(data) {
				var remaining = 0;
				var x = data;
				
				$("#resend_otp").hide();
				
					if (x['status'] == "Error") {
					
					$("#show_error_div").html("Please enter valid mobile number or email"); $("#show_error_div").addClass(' text-danger');$("#send_otp").hide();
					
					setTimeout(function () {$("#show_error_div").html(""); $("#show_error_div").removeClass(' text-success'); $("#show_error_div").addClass(' text-danger');$("#send_otp").html("Send OTP")}, 12000);
						}else{

					
					$("#sendotp_btn").hide();
					$(".show").show();
					$("#show_error_div").html("OTP will be send to your Registerd email & mobile number"); 
					$("#endtime_div1").show();
					$("#send_otpdiv").hide();
					$("#endtimer1").show();
							
					let timerOn = true;

						function timer(remaining) {
						  var m = Math.floor(remaining / 60);
						  var s = remaining % 60;
						  
						  m = m < 10 ? '0' + m : m;
						  s = s < 10 ? '0' + s : s;
						  document.getElementById('endtimer1').innerHTML = m + ':' + s;
						  remaining -= 1;
						  
						$("#send_otp").hide();
						  if(remaining >= 0 && timerOn) {
							setTimeout(function() {
								timer(remaining);
							}, 1000);
							return;
						  }

						  if(!timerOn) {
							// Do validate stuff here
							
							return;
						  }
						   $("#endtime_div1").hide();
						   $("#forget_otp").hide();
							$("#send_otp").show();
							$.ambiance({message: "Timeout for OTP", 

							type: "error",

							title: "Hello User !",

							fade: false,

							//timeout: 5
						});
						    // $("#pwd_div").hide();
							// $("#otp_btn").hide();
							// $("#show_error_div").hide();
							// $("#resend_otp").show();
						}

						timer(180);
						
										
					$("#show_error_div").removeClass(' text-danger'); $("#show_error_div").addClass(' text-success');; 
					
					setTimeout(function () {$("#show_error_div").html(""); $("#show_error_div").removeClass(' text-success'); $("#show_error_div").addClass(' text-danger');$("#send_otpdiv").show();
					$("#pwd_div").hide();
					$("#resend_otp").show();}, 5000);
						}
		  
			}
		});
 	}else{
	 
		$("#mobile").html("Please Enter mobile number or email ");
		$("#mobile").addClass(' text-danger');
		setTimeout(function () { $("#mobile").html(""); }, 5000);
	}

}

function verify_forgetotp_login() {
    var verifyotp = document.getElementById('forgot_otp').value;
	//alert(verifyotp);
 	$("#verify_otp_btn").html("Verifying.."); 
	$("#send_otpdiv").hide();
	 
    $.ajax({
          
         url: 'ajax/otpmail.php?type=verify' ,
         data: {otp:verifyotp},
		  
		  success: function(data) {
			 
          			var x = data;
			if (x['status'] == "Success") {
			$('#forgot_pwd').hide();
			$("#resend_otp").hide();
			$("#reset_pwd").show();
		  } else if (x['status'] == "Error") {
					
					$("#show_error_div").html("OTP is not matched"); $("#show_error_div").removeClass(' text-success'); $("#show_error_div").addClass(' text-danger'); 
	
				setTimeout(function () {$("#show_error_div").html(""); $("#show_error_div").removeClass(' text-success'); $("#show_error_div").addClass(' text-danger');$("#send_otpdiv").show();$("#verify_otp_btn").html("Update Password"); $("#send_otp").html("Send OTP")}, 12000);
				}
				// else{
					
					// $.ambiance({message: "Your Password Changed Successfully", 

							// type: "success",

							// title: "Hello User !",

							// fade: false,

							//timeout: 5
						// });
					 // $('#forgot_pwd').hide();
					// $('#reset_pwd').show();
			//}
        }
    
	});    
 
}	

function reset_pwd() {
    var new_pwd = document.getElementById('new_pwd').value;
    var cnfm_pwd = document.getElementById('cnfm_pwd').value;
 	$("#reset_otp_btn").html("Verifying.."); 
	 
if(new_pwd !="" && cnfm_pwd !=""){
    $.ajax({
          
         url: 'ajax/otpmail.php?type=Resetpwd' ,
         data: {new_pwd:new_pwd,cnfm_pwd:cnfm_pwd },
		  
		  success: function(data) {
          			var x = data;
				if (x['status'] == "Success") {
					 $('#signin-modal').modal('hide');
					 $.ambiance({message: "Your Password Reset is done", 

								type: "success",

								title: "Hello User !",

								fade: false,

								//timeout: 5
								});
								window.location = 'index.php'
					} else if (x['status'] == "Error") {
					//$("#send_otp").html("Send OTP");
					// if (y.status == "Error") {
					 
					
					$("#show_resterror_div").html("Passwords are mismatched"); $("#show_resterror_div").removeClass(' text-success'); $("#show_resterror_div").addClass(' text-danger'); 
	
					// setTimeout(function () {$("#mobile").html(""); $("#mobile").removeClass(' text-success'); $("#mobile").addClass(' text-danger');$("#send_otpdiv").show();$("#send_otp").html("Resend OTP");}, 4000);
				
				setTimeout(function () {$("#show_resterror_div").html(""); $("#show_resterror_div").removeClass(' text-success'); $("#show_resterror_div").addClass(' text-danger');$("#reset_otp_btn").html("Update Password");}, 6000);
				
				}
				}
			
			});    
	} else {
		
	$("#show_resterror_div").html("Please enter New Password and Confirm Password"); $("#show_resterror_div").addClass(' text-danger');	$("#reset_otp_btn").html("Update Password"); 
	setTimeout(function () {$("#show_resterror_div").html(""); $("#show_resterror_div").removeClass(' text-success'); $("#show_resterror_div").addClass(' text-danger');}, 6000);
	}
	 
}	

function close_popup(){
	
	window.location.reload();
	$("#singin_email").val('');
	$("#singin_password").val('');
	$("#register_email").val('');
	$("#register_password").val('');
	$("#otp_password").val('');
	$("#endtime_div").hide();
	$("#forgot_email").val('');
}

    // $('.cart-product-quantity').on('click', function (e) {
		// cart_quantity_update(hidden_cart_ID, hidden_PRDT_ID);
    // });
	$(document).ready(function() {
			$('.cart-product-quantity .btn-decrement').click(function () {
				$(this).parents('.cart-product-quantity').addClass('active');
				var hidden_cart_id = $(".cart-product-quantity.active").attr('cart_id');
				var product_id = $(".cart-product-quantity.active").attr('product_id');
				cart_quantity_update(hidden_cart_id, product_id);
				$(this).parents('.cart-product-quantity').removeClass('active');
			});
			
			$('.cart-product-quantity .btn-increment').click(function () {
				$(this).parents('.cart-product-quantity').addClass('active');
				var hidden_cart_id = $(".cart-product-quantity.active").attr('cart_id');
				var product_id = $(".cart-product-quantity.active").attr('product_id');
				cart_quantity_update(hidden_cart_id, product_id);
				$(this).parents('.cart-product-quantity').removeClass('active');
			});
		});
		
function cart_quantity_update(hidden_cart_id, product_id){
	
	var hidden_od_id = document.getElementById('od_id').value;
	var hidden_cart_ID = hidden_cart_id;
	var hidden_PRDT_ID = product_id;
	var display_qty = document.getElementById('dispaly-qty'+hidden_cart_ID).value;
	if(display_qty == 10){
		$.ambiance({message: "Limit Exceeds. Maximum 10 Quantities Allowed!",
						type: "error",
						title: "Hi!",
						fade: true,
						timeout: 5});
	} else {
	$.ajax({
		type: "POST",
		url: 'ajax/ajax_cart_quantity_update.php',
		data: {
			hidden_od_id:hidden_od_id, selected_CARTID:hidden_cart_ID, selected_PRDTID:hidden_PRDT_ID, selected_PRDTQTY:display_qty
		},
		success : function(data){
			// var x = response;
			if(data['status'] == 'Success'){
				
				$.ambiance({message: "Cart Updated",
						type: "success",
						title: "Hi!",
						fade: true,
						timeout: 5});
						$("#qty_total_update"+hidden_cart_ID).load("cart.php #qty_total_update"+hidden_cart_ID);
						$("#summary-cart").load("cart.php #summary-cart");
						// setTimeout(function () { location.assign("<?php echo SITEHOME; ?>cart.php"); }, 5000);
			} else if(data['status'] == 'Error_Stock') {
				
				var display_qty = document.getElementById('dispaly-qty'+hidden_cart_ID).value;
				display_qty_stock = display_qty - 1;
				document.getElementById('dispaly-qty'+hidden_cart_ID).value = display_qty_stock;
				$.ambiance({message: "Out of Stock!",
						type: "error",
						title: "Hi!",
						fade: true,
						timeout: 5});
				
			} else if(data['status'] == 'Error') {
				$.ambiance({message: "Cart is not updated",
						type: "error",
						title: "Hi!",
						fade: true,
						timeout: 5});
				
			}
			return true;
		}
	})
	}
	
 } 
 	function user_subscribed() {
		$.ambiance({
			
			message: "You are subscribed", 

			type: "success",

			title: "Hi!",

			fade: true,

			timeout: 5
		});
	  }
	  
	  function user_alreadysubscribed() {
		  $.ambiance({
			
			message: "You are already subscribed", 

			type: "error",

			title: "Hi!",

			fade: true,

			timeout: 5
		});
	  }
	
	function validateEmail(email) 
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
	// function setCookie(c_name, value, exdays) {
		// var exdate = new Date();
		// exdate.setDate(exdate.getDate() + exdays);
		// var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
		// document.cookie = c_name + "=" + c_value;
	// }
 function subscribe() {
		var subscriber_email = document.getElementById("subscriber_email").value;
		var session_id = document.getElementById("session_id").value;
		document.getElementById("subscriber_email").value ='';
	//alert(email);
		if(subscriber_email != '' && validateEmail(subscriber_email) == true){
			//alert();
			$("#subscribe_newsletter_msg").hide();
			$.ajax({
			
			 url: 'ajax/ajax_subscriber_list.php',
			 data: {
					subscriber_email:subscriber_email,session_id:session_id
					},
					
					success: function(data) {
					var x = data;
					//var y = JSON.parse(x);
					//if(y.status == 'Error') {
				
					//if(y.status == 'Success') {	
					if (x['status'] == "Success") {
						
						user_subscribed();
						$("#subscribe_popup").hide();
						$("#subscribe_popup_show").show();
						// setCookie('hide', true, 7);
						<?php
						setcookie("subscribe_hide", true, time()+60*60*24*7, "/");
						?>
					}
					if (x['status'] == "Failure") {
						
						user_alreadysubscribed();
					}
					return true;
					}
			});
		} else {
			$("#subscribe_newsletter_msg").html('<span class="text-danger">Enter a valid email id.</span>');
		}
	} 
	
function close_side(){
		
		$('.sidebar-filter-active').removeClass('sidebar-filter-active');
	}
	
function select_tab_reviews(){
	$("#product-desc-link").removeClass(' active');
	$('#product-desc-link').attr('aria-selected' , 'false');
	$("#product-desc-tab").removeClass(' active show');
	// $(".review").addClass(' active');
	$("#product-review-link").addClass(' active');
	$('#product-review-link').attr('aria-selected' , 'true');
	$("#product-review-tab").addClass(' active show');	
}
</script>	


