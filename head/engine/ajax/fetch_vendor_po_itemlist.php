<?php 

extract($_REQUEST);

include_once('../../jackus.php');

reguser_protect();

	//echo $vpo_id_ref;exit();
	
	if($vpo_id_ref != '')
	{
		//echo 'djkf';exit();
		$selectpo_itemlist = sqlQUERY_LABEL("select `vpo_item_id`, `prdt_id`, `prdt_serialno`, `vpo_item_qty`, `vpo_item_price`, `vpo_discount_value`, `vpo_discount_amt`, `vpo_after_discount_price`, `vpo_after_discount_item_total`, `vpo_item_tax`, `vpo_item_tax1`, `vpo_item_tax2`, `vpo_item_total` FROM `js_vendor_po_items` where `vpo_id`='$vpo_id_ref' ORDER BY `vpo_item_id` DESC") or die(sqlERROR_LABEL());
		$count_vpo_itemlist = sqlNUMOFROW_LABEL($selectpo_itemlist);
				//echo $count_vpo_itemlist;exit();

		if($count_vpo_itemlist > 0) {
			while($collect_poitem_list = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
				$counter++;
				$item_id = $collect_poitem_list['vpo_item_id'];
				$product_id = $collect_poitem_list['prdt_id'];
				$prdt_serialno = $collect_poitem_list['prdt_serialno'];
				$product_item_qty = $collect_poitem_list['vpo_item_qty'];
				$product_item_price = $collect_poitem_list['vpo_item_price'];
				$vpo_discount_value = $collect_poitem_list['vpo_discount_value'];
				$vpo_discount_amt = $collect_poitem_list['vpo_discount_amt'];
				$vpo_after_discount_price = $collect_poitem_list['vpo_after_discount_price'];
				$vpo_dicounted_item_price = ($vpo_after_discount_price/$product_item_qty);
				$vpo_after_discount_item_total = $collect_poitem_list['vpo_after_discount_item_total'];
				$product_item_tax = $collect_poitem_list['vpo_item_tax'];
				$product_item_tax1 = $collect_poitem_list['vpo_item_tax1'];
				$product_item_tax2 = $collect_poitem_list['vpo_item_tax2'];
				$product_item_total = $collect_poitem_list['vpo_item_total'];
				?>
				<tr id="dummy_po_list_<?php echo $item_id; ?>">
                    <td class="text-center"><?php echo $counter; ?></td>
                    <td><?php echo getPRODUCTDETAIL($product_id, 'code'); ?></td>
                    <td><?php echo getPRODUCTDETAIL($product_id, 'name'); ?></td>
                    <td class="text-center"><?php echo $product_item_qty; ?></td>
                    <td class="text-right">
					<?php if($vpo_discount_value !='0' && $vpo_discount_value !='') { ?>
					<del><?php echo number_format($product_item_price, 2); ?></del><br>
					<?php echo number_format($vpo_dicounted_item_price, 2); ?>
					<?php } else { ?>
					<?php echo number_format($product_item_price, 2); ?>
					<?php } ?>
					</td>
					
                    <td class="text-right"><?php echo number_format($product_item_tax1, 2); ?></td>
                    <td class="text-right"><?php echo number_format($product_item_tax2, 2); ?></td>
                    <td class="text-right">
					<?php if($vpo_discount_value !='0' && $vpo_discount_value !='') { ?>
					<del><?php echo number_format($product_item_total, 2); ?></del><br>
					<?php echo number_format($vpo_after_discount_item_total, 2); ?>
					<?php } else { ?>
					<?php echo number_format($product_item_total, 2); ?>
					<?php } ?>
					</td>
					<td>
                        <a href="javascript:;" onClick="remove_po_productitem_List(<?php echo $item_id; ?>);">
                        Delete
                        </a>                    
                    </td>
				</tr>
				<?php
			}  //end of vendor po item while loop
		} else {
			echo '<tr><td colspan="8" align="center">"Start adding Products"</td></tr>';
		}
	} else {
		echo '<tr><td colspan="8" align="center">"Start adding Products"</td></tr>';
	}
		
	exit();

?>
