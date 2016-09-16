<?php
include('application.php');
/**
 * Created by PhpStorm.
 * User: shukrishukriev
 * Date: 12/1/14
 * Time: 11:02 AM
 */
$FILTER = getFilter($_GET);

switch ($FILTER['mode']) {
	
	case 'save_quantity':
		$FILTER = getFilter($_POST);
		
		$quantity['product_id'] = intval($FILTER['product_id']);
		$quantity['qty'] = intval($FILTER['qty']);
		$quantity['product_color_id'] = intval($FILTER['color_id']);
		$quantity['product_size_id'] = intval($FILTER['size_id']);
	
		$res = $mm->AutoExecute('product_quantity', $quantity, 1, false);
	
		if(isset($FILTER['ajax'])) {
			exit;
		}
		break;
		
	case 'update_quantity':
		$FILTER = getFilter($_POST);
		$FILTER['id'] = intval($FILTER['id']);
		$FILTER['product_id'] = intval($FILTER['product_id']);
		$FILTER['qty'] = intval($FILTER['qty']);
		$FILTER['color_id'] = intval($FILTER['color_id']);
		$FILTER['size_id'] = intval($FILTER['size_id']);
		
		if($FILTER['id']>0) {
			$mm->Query("UPDATE product_quantity SET qty='{$FILTER['qty']}', product_color_id={$FILTER['color_id']}, product_size_id={$FILTER['size_id']} WHERE id={$FILTER['id']}");
		}
		
		if(isset($FILTER['ajax'])) {
			
			exit;
		}
		break;
}

?>