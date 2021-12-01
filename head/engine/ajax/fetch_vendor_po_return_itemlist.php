<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2020 Touchmark De`Science
*
*/
//Dont place PHP Close tag at the bottom
include_once('../../jackus.php');
protectpg_includes();

	
	$vpor_id_ref = $_GET['vpor_id_ref'];
	
	//`vpor_item_id`, `vpor_id`, `prdt_id`, `vpor_item_qty`, `vpor_item_price`, `vpor_item_tax`, `vpor_item_tax1`, `vpor_item_tax2`, `vpor_item_total`, `vpor_item_grn_status`, `vpor_item_createdon`, `vpor_item_updatedon`, `status` FROM `adisil_vendor_po_return_items`
	if($_GET['vpor_id_ref'] != '')
	{
		
		$selectpo_itemlist = sqlQUERY_LABEL("select `vpor_item_id`, `prdt_id`, `vpor_item_qty`, `vpor_item_price`, `vpor_item_tax`, `vpor_item_tax1`, `vpor_item_tax2`, `vpor_item_total` FROM `js_vendor_po_return_items` where `vpor_id`='$vpor_id_ref' ORDER BY `vpor_item_id` DESC") or die(sqlERROR_LABEL());
		$count_vpor_itemlist = sqlNUMOFROW_LABEL($selectpo_itemlist);
		
		if($count_vpor_itemlist > 0) {
			while($collect_poitem_list = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
				$counter++;
				$item_id = $collect_poitem_list['vpor_item_id'];
				$product_id = $collect_poitem_list['prdt_id'];
				$product_item_qty = $collect_poitem_list['vpor_item_qty'];
				$product_item_price = $collect_poitem_list['vpor_item_price'];
				$product_item_tax = $collect_poitem_list['vpor_item_tax'];
				$product_item_tax1 = $collect_poitem_list['vpor_item_tax1'];
				$product_item_tax2 = $collect_poitem_list['vpor_item_tax2'];
				$product_item_total = $collect_poitem_list['vpor_item_total'];
				?>
				<tr id="dummy_po_list_<?php echo $item_id; ?>">
                    <td class="text-center"><?php echo $counter; ?></td>
                    <td><?php echo getPRODUCTDETAIL($product_id, 'code'); ?></td>
                    <td><?php echo getPRODUCTDETAIL($product_id, 'name'); ?></td>
                    <td class="text-center"><?php echo $product_item_qty; ?></td>
                    <td class="text-right"><?php echo number_format($product_item_price, 2); ?></td>
                    <td class="text-right"><?php echo number_format($product_item_tax1, 2); ?></td>
                    <td class="text-right"><?php echo number_format($product_item_tax2, 2); ?></td>
                    <td class="text-right"><?php echo number_format($product_item_total, 2); ?></td>
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