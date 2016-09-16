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
	case 'get_colors':
		$size_id = intval($FILTER['size_id']);
		$FILTER['product_category_id'] = intval($FILTER['product_category_id']);
		$FILTER['product_type_id'] = intval($FILTER['product_type_id']);
		$body = '<option value="">Изберете цвят</option>';
		if($size_id>0) {
			
			if($FILTER['product_category_id']) {
				$colors = $mm->SelAssoc("SELECT s.id, s.name_ln title, s.name_bg FROM products pr LEFT JOIN product_quantity p ON p.product_id=pr.id LEFT JOIN product_colors s ON s.id=p.product_color_id WHERE p.qty>0 AND p.product_size_id={$size_id} AND pr.product_category_id={$FILTER['product_category_id']} ORDER BY s.name_ln");
			} else if($FILTER['product_type_id']) {
				$colors = $mm->SelAssoc("SELECT s.id, s.name_ln title, s.name_bg FROM products pr LEFT JOIN product_quantity p ON p.product_id=pr.id LEFT JOIN product_colors s ON s.id=p.product_color_id WHERE p.qty>0 AND p.product_size_id={$size_id} AND pr.type_id={$FILTER['product_type_id']} ORDER BY s.name_ln");
			}
			foreach($colors AS $c) {
				$body .= '<option value="'.$c['id'].'">'.$c['title'].'</option>';
			}
		}
		
		if(isset($FILTER['ajax'])) {
			echo $body;
			exit;
		}
		break;
	case 'get_sizes':
		$color_id = intval($FILTER['color_id']);
		$FILTER['product_category_id'] = intval($FILTER['product_category_id']);
		$FILTER['product_type_id'] = intval($FILTER['product_type_id']);
		$body = '<option value="">Изберете размер</option>';
		if($color_id>0) {
			if($FILTER['product_category_id']) {
				$sizes = $mm->SelAssoc("SELECT s.id, s.name_ln title, s.name_bg FROM products pr LEFT JOIN product_quantity p ON p.product_id=pr.id LEFT JOIN product_sizes s ON s.id=p.product_size_id WHERE p.qty>0 AND p.product_color_id={$color_id} AND pr.product_category_id={$FILTER['product_category_id']} ORDER BY s.name_ln");
			} else if($FILTER['product_type_id']) {
				$sizes = $mm->SelAssoc("SELECT s.id, s.name_ln title, s.name_bg FROM products pr LEFT JOIN product_quantity p ON p.product_id=pr.id LEFT JOIN product_sizes s ON s.id=p.product_size_id WHERE p.qty>0 AND p.product_color_id={$color_id} AND pr.type_id={$FILTER['product_type_id']} ORDER BY s.name_ln");
			}
			
			foreach($sizes AS $c) {
				$body .= '<option value="'.$c['id'].'">'.$c['title'].'</option>';
			}
		}
		
		if(isset($FILTER['ajax'])) {
			echo $body;
			exit;
		}
		break;
}

?>