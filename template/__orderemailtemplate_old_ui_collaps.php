<?php
/***********************************
	order email template
************************************/
$__main_order_details_query = sqlQUERY_LABEL("select * FROM `js_shop_order` where `od_userid`='$logged_user_id' and `od_id`='$__main_orderID'") or die(sqlERROR_LABEL());
$check_main_order_num_rows = sqlNUMOFROW_LABEL($__main_order_details_query);

if($check_main_order_num_rows > 0) {
	$__main_order_data = sqlFETCHASSOC_LABEL($__main_order_details_query);	
	$orderID = $__main_order_data['od_id'];
	$od_refno = $__main_order_data['od_refno'];
	$orderDATE = $__main_order_data['od_date'];
	$orderpaymentMODE = $__main_order_data['od_payment_mode'];
	$orderTOTAL = $__main_order_data['od_total'];
	$orderSTATUS = $__main_order_data['od_status'];
	$created_orderDATE = strtotime($orderDATE);
	$created_orderDATE = date('M d, Y', $created_orderDATE);
	
	if($orderpaymentMODE == 'cod') {
		$orderpaymentMODE = 'Cash on Delivery';
	} elseif($orderpaymentMODE == 'razor') {
		$orderpaymentMODE = 'Razor Pay';
	}
	
	//Payment/Shipping Address
	$_checkout_shipping_fname = $__main_order_data['od_shipping_first_name'];
	$_checkout_shipping_lname = $__main_order_data['od_shipping_last_name'];
	$_checkout_shipping_street1 = $__main_order_data['od_shipping_address1'];
	$_checkout_shipping_street2 = $__main_order_data['od_shipping_address2'];
	$_checkout_shipping_email = $__main_order_data['od_shipping_email'];
	$_checkout_shipping_phone = $__main_order_data['od_shipping_phone'];
	$_checkout_shipping_city = $__main_order_data['od_shipping_city'];
	$_checkout_shipping_state = $__main_order_data['od_shipping_state'];
	$_checkout_shipping_pin = $__main_order_data['od_shipping_postal_code'];
	$_checkout_shipping_country = $__main_order_data['od_shipping_country'];
	
	//Billing Address
	$_checkout_payment_fname = $__main_order_data['od_payment_first_name'];
	$_checkout_payment_lname = $__main_order_data['od_payment_last_name'];
	$_checkout_payment_street1 = $__main_order_data['od_payment_address1'];
	$_checkout_payment_street2 = $__main_order_data['od_payment_address2'];
	$_checkout_payment_email = $__main_order_data['od_payment_email'];
	$_checkout_payment_phone = $__main_order_data['od_payment_phone'];
	$_checkout_payment_city = $__main_order_data['od_payment_city'];
	$_checkout_payment_state = $__main_order_data['od_payment_state'];
	$_checkout_payment_pin = $__main_order_data['od_payment_postal_code'];
	$_checkout_payment_country = $__main_order_data['od_payment_country'];
$message .=
'<div class="es-wrapper-color">
	<!--[if gte mso 9]>
		<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
			<v:fill type="tile" color="#efefef"></v:fill>
		</v:background>
	<![endif]-->
	<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="font-family:arial; background-color: #eeebeb;padding-bottom: 10px;">
		<tbody>
			<tr>
				<td class="esd-email-paddings" valign="top">
					<table class="es-content esd-header-popover" cellspacing="0" cellpadding="0" align="center">
						<tbody>
							<tr>
								<td class="es-adaptive esd-stripe" esd-custom-block-id="1733" align="center">
									<table class="es-content-body" style="background-color: #efefef;" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
										<tbody>
											<tr>
												<td class="esd-structure es-p15t es-p15b es-p20r es-p20l" align="left">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="es-content" cellspacing="0" cellpadding="0" align="center">
						<tbody>
							<tr>
								<td class="esd-stripe" esd-custom-block-id="1754" align="center">
									<table class="es-content-body" width="600" bgcolor="#fff" cellspacing="0" cellpadding="0" align="center">
										<tbody>
											<tr>
												<td class="esd-structure es-p10t es-p10b es-p20r es-p20l" esd-general-paddings-checked="false" align="left">
													<table width="100%" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td class="esd-container-frame" width="560" valign="top" align="center">
																	<table style="border-radius: 0px; border-collapse: separate;" width="100%" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td>
<table class="es-header" cellspacing="0" cellpadding="0" align="center" style="padding:0px;">
						<tbody>
							<tr>
								<td class="esd-stripe" esd-custom-block-id="1735" align="center">
									<table class="es-header-body" style="background-color: black;" width="600" cellspacing="0" cellpadding="0" bgcolor="black" align="center">
										<tbody>
											<tr>
												<td class="esd-structure es-p5t es-p5b es-p15r es-p15l" align="center" >
													<!--[if mso]><table width="570" cellpadding="0" cellspacing="0"><tr><td width="180" valign="top"><![endif]-->
													<table class="es-left" cellspacing="0" cellpadding="0" align="center">
														<tbody>
															<tr>
																<td class="es-m-p0r esd-container-frame" width="180" valign="top" align="center">
																	<table width="100%" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td class="esd-block-image es-m-p0l es-p15l es-m-txt-c" style="font-size: 0px;" align="center"><a href="'.SEOURL.'" target="_blank"><img src="'.SEOURL.'assets/images/logo-light.png" alt="Rare Fashion" title="Rare Fashion" style="display: block;" width="150" style="padding:10px;"></a></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<!--[if mso]></td><td width="20"></td><td width="370" valign="top"><![endif]-->
													<!--[if mso]></td></tr></table><![endif]-->
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
																				</td>
																			</tr>
																			<tr>
																				<td class="esd-block-text es-p10t es-p15b" align="center">
																					<h1>Thanks for your order<br></h1>
																				</td>
																			</tr>
																			<tr>
																				<td class="esd-block-text es-p5t es-p5b es-p40r es-p40l" align="center">
																					<p style="color: #333333; padding-bottom:20px;">You will receive an email when your items are shipped. If you have any questions, Call us 1-800-1234-5678.</p>
																				</td>
																			</tr>
																			<tr>
																				<td class="button btn" align="center" style="padding-bottom:20px;"><span class="btn button" style=""><a href="'.SEOURL.'order-tracking.php" class="button btn" target="_blank" style="font-size: 16px;border-top-width: 10px;border-bottom-width: 10px;border-radius: 5px;background: #2cb543;border-color: #2cb543;padding: 10px 15px;color: #fff;text-decoration: none;">View order status</a></span></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="es-content" cellspacing="0" cellpadding="0" align="center">
						<tbody>
							<tr>
								<td class="esd-stripe" esd-custom-block-id="1755" align="center">
									<table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="padding: 10px 15px;">
										<tbody>
											<tr>
												<td class="esd-structure es-p20t es-p30b es-p20r es-p20l" align="left">
													<!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="280" valign="top"><![endif]-->
													<table class="es-left" cellspacing="0" cellpadding="0" align="left">
														<tbody>
															<tr>
																<td class="es-m-p20b esd-container-frame" width="65%" align="left">
																	<table style="background-color: #fef9ef; border-color: #efefef; border-collapse: separate; border-width: 1px 0px 1px 1px; border-style: solid; padding:10px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fef9ef">
																		<tbody>
																			<tr>
																				<td class="esd-block-text es-p20t es-p10b es-p20r es-p20l" align="left">
																					<h4>SUMMARY:</h4>
																				</td>
																			</tr>
																			<tr>
																				<td class="esd-block-text es-p20b es-p20r es-p20l" align="left">
																					<table style="width: 100%;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left">
																						<tbody>
																							<tr>
																								<td><span style="font-size: 14px; line-height: 150%;">Order #:</span></td>
																								<td><span style="font-size: 14px; line-height: 150%;">'.$od_refno.'</span></td>
																							</tr>
																							<tr>
																								<td><span style="font-size: 14px; line-height: 150%;">Order Date:</span></td>
																								<td><span style="font-size: 14px; line-height: 150%;">'.$created_orderDATE.'</span></td>
																							</tr>
																							<tr>
																								<td><span style="font-size: 14px; line-height: 150%;">Order Total:</span></td>
																								<td><span style="font-size: 14px; line-height: 150%;">'. general_currency_symbol.' '.($orderTOTAL).
																								'</span></td>
																							</tr>
																						</tbody>
																					</table>
																					<p style="line-height: 150%;"><br></p>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<!--[if mso]></td><td width="0"></td><td width="280" valign="top"><![endif]-->
													<table class="es-right" cellspacing="0" cellpadding="0" align="right" style>
														<tbody>
															<tr>
																<td class="esd-container-frame" width="65%" align="left">
																	<table style="background-color: #fef9ef; border-collapse: separate; border-width: 1px; border-style: solid; border-color: #efefef; padding:10px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fef9ef">
																		<tbody>
																			<tr>
																				<td class="esd-block-text es-p20t es-p10b es-p20r es-p20l" align="left">
																					<h4>SHIPPING ADDRESS:<br></h4>
																				</td>
																			</tr>
																			<tr>
																				<td class="esd-block-text es-p20b es-p20r es-p20l" align="left">
																					<p>'.$_checkout_shipping_fname.' '.$_checkout_shipping_lname.'<br>'.$_checkout_shipping_street1.', '.$_checkout_shipping_street2.'<br>'.$_checkout_shipping_city.', '.$_checkout_shipping_state.'<br>'.$_checkout_shipping_country.', '.$_checkout_shipping_pin.' <br>Email : '.$_checkout_shipping_email.'<br>Mobile: '.$_checkout_shipping_phone.'</p>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<!--[if mso]></td></tr></table><![endif]-->
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="es-content" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="padding-top:20px;">
						<tbody>
							<tr>
								<td class="esd-stripe" esd-custom-block-id="1758" align="center">
									<table class="es-content-body" width="600" cellspacing="0" cellpadding="0"  bgcolor="#ccc" align="center">
										<tbody>
											<tr>
												<td class="esd-structure es-p10t es-p10b es-p20r es-p20l" esd-general-paddings-checked="false" align="left">
													<!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="270" valign="top"><![endif]-->
													<table class="es-left" cellspacing="0" cellpadding="0" align="left">
														<tbody>
															<tr>
																<td class="es-m-p0r es-m-p20b esd-container-frame" width="270" valign="top" align="center">
																	<table width="100%" cellspacing="0" cellpadding="0" style="padding-left: 25px;>
																		<tbody>
																			<tr>
																				<td class="esd-block-text es-p20l" align="left">
																					<span style="font-size:13px; padding: 10px 15px;display: block;">ITEMS ORDERED</span>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<!--[if mso]></td><td width="20"></td><td width="270" valign="top"><![endif]-->
													<table cellspacing="0" cellpadding="0" align="right">
														<tbody>
															<tr>
																<td class="esd-container-frame" width="270" align="left">
																	<table width="100%" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td class="esd-block-text" align="left">
																					<table style="width: 100%;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" padding-top: 10px; margin-left: -7px;>
																						<tbody>
																							<tr>
																								<td><span style="font-size:13px; text-align: left;">NAME</span></td>
																								<td style="text-align: center;" width="60"><span style="font-size:13px;"><span style="line-height: 100%;">QTY</span></span></td>
																								<td style="text-align: center;" width="100"><span style="font-size:13px;"><span style="line-height: 100%;">PRICE</span></span></td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<!--[if mso]></td></tr></table><![endif]-->
												</td>
											</tr>
											<tr>
												<td class="esd-structure es-p20r es-p20l" esd-general-paddings-checked="false" align="left">
													<table width="100%" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td class="esd-container-frame" width="560" valign="top" align="center">
																	<table width="100%" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td class="esd-block-spacer es-p10b" style="font-size:0" align="center">
																					<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
																						<tbody>
																							<tr>
																								<td style="border-bottom: 1px solid #efefef; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; height: 1px; width: 100%; margin: 0px;"></td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>';
										//	echo "SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$__main_orderID' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '1'";
										$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$__main_orderID' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '0'") or die("#1-Unable to get records:".mysqli_error());
											$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);

											if($check_product_data_num_rows >0) {
											while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
												  $counter++;
												  $cart_id = $featured_data["cart_id"];
												  $od_id = $featured_data["od_id"];
												  $pd_id = $featured_data["pd_id"];
												  $producttitle = $featured_data["producttitle"];
												  $productsku = $featured_data["productsku"];
												  $variant_id = $featured_data["variant_id"];
												  $od_qty = $featured_data["od_qty"];
												  $od_price += $featured_data["od_price"];
												  $item_tax_type = $featured_data["item_tax_type"];
												  $item_tax = $featured_data["item_tax"];
												  $item_tax1 = $featured_data["item_tax1"];
												  $item_tax2 = $featured_data["item_tax2"];
												  $item_total = $od_price + $item_tax1 + $item_tax2;
												  
												  if($variant_id != '0'){
													  $variant_name = getVARIANT_ESTORECODE($variant_id,'variant_name_from_variant_ID');
												  }
											 
				$message .= '<tr>
												<td class="esd-structure es-p5t es-p10b es-p20r es-p20l" esd-general-paddings-checked="false" align="left">';
													
													 
													$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$pd_id' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
													  while($featured_image = sqlFETCHARRAY_LABEL($featured_product_image)){
														  $productmediagallerytitle = $featured_image["productmediagallerytitle"];
														  $productmediagalleryurl = 'uploads/productmediagallery/'.$featured_image["productmediagalleryurl"];
													}
													
					$message .= 		'<table class="es-left" cellspacing="0" cellpadding="0" align="left">
														<tbody>
															<tr>
																<td class="es-m-p0r es-m-p20b esd-container-frame" width="178" valign="top" align="center">
																	<table width="100%" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td class="esd-block-image" style="font-size:0" align="center"><a href="'.SEOURL.'/product.php?token='.$pd_id.'-'.convertSEOURL($producttitle).'-'.$productsku.'" target="_blank"><img src="'.SEOURL.''.$productmediagalleryurl.'" alt="'.$producttitle.'" class="adapt-img" title="'.$producttitle.'" width="125"></a></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<!--[if mso]></td><td width="20"></td><td width="362" valign="top"><![endif]-->
													<table cellspacing="0" cellpadding="0" align="right">
														<tbody>
															<tr>
																<td class="esd-container-frame" width="362" align="left">
																	<table width="100%" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td class="esd-block-text" align="left">
																					<p><br></p>
																					<table style="width: 100%;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0">
																						<tbody>
																							<tr>
																								<td>'.$producttitle.' '.$variant_name.'</td>
																								<td style="text-align: center;" width="60">'.$od_qty.'</td>
																								<td style="text-align: center;" width="100">'. general_currency_symbol.' '.formatCASH($item_total).'</td>
																							</tr>
																						</tbody>
																					</table>
																					<p><br></p>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<!--[if mso]></td></tr></table><![endif]-->
												</td>
											</tr>
											<tr>
												<td class="esd-structure es-p20r es-p20l" esd-general-paddings-checked="false" align="left">
													<table width="100%" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td class="esd-container-frame" width="560" valign="top" align="center">
																	<table width="100%" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td class="esd-block-spacer es-p10b" style="font-size:0" align="center">
																					<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
																						<tbody>
																							<tr>
																								<td style="border-bottom: 1px solid #efefef; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; height: 1px; width: 100%; margin: 0px;"></td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>';
											 } } 
				$message .=  '<tr>
												<td class="esd-structure es-p5t es-p30b es-p40r es-p20l" align="left">
													<table width="100%" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td class="esd-container-frame" width="540" valign="top" align="center">
																	<table width="100%" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td class="esd-block-text" align="right">
																					<table style="width: 500px; padding: 20px 10px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="right">
																						<tbody>
																							<tr>
																								<td style="text-align: right; font-size: 16px; line-height: 150%;">Subtotal ('. $counter.' items):</td>
																								<td style="text-align: right; font-size: 16px; line-height: 150%;">'. general_currency_symbol.' '.formatCASH(orderTOTALSUMMARY($__main_orderID, 'subtotal')).'</td>
																							</tr>
																							<tr>
																								<td style="text-align: right; font-size: 16px; line-height: 150%;">Tax ('. $counter.' items):</td>
																								<td style="text-align: right; font-size: 16px; line-height: 150%;">'. general_currency_symbol.' '.formatCASH(orderTOTALSUMMARY($__main_orderID, 'taxtotal')).'</td>
																							</tr>
																							<tr>
																								<td style="text-align: right; font-size: 16px; line-height: 150%;">Flat-rate Shipping:</td>
																								<td style="text-align: right; font-size: 16px; line-height: 150%; color: #d48344;"><strong>FREE</strong></td>
																							</tr>
																							<tr>
																								<td style="text-align: right; font-size: 16px; line-height: 150%;">Discount:</td>
																								<td style="text-align: right; font-size: 16px; line-height: 150%;">'. general_currency_symbol.' '.formatCASH(orderTOTALSUMMARY($__main_orderID, 'discounttotal')).'</td>
																							</tr>
																							<tr>
																								<td style="text-align: right; font-size: 16px; line-height: 150%;"><strong>Order Total:</strong></td>
																								<td style="text-align: right; font-size: 16px; line-height: 150%; color: #80b82d;"><strong>'. general_currency_symbol.' '.formatCASH(orderTOTALSUMMARY($__main_orderID, 'ordertotal')).'</strong></td>
																							</tr>
																						</tbody>
																					</table>
																					<p style="line-height: 150%;"><br></p>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>';
 } 
 ?>
