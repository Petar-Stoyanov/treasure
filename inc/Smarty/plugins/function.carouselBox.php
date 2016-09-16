<?php
/**
 * template_lite {carouselBox} function plugin
 *
 * Type:     function
 * Name:     html_input
 * Purpose:  Returns the 10 top wines mostly ordered 
 * Author:   Konstantin Radoslavov
 */
function tpl_function_carouselBox($params, &$tpl) {
	global $mm, $_langs;
	
	require_once("shared.escape_chars.php");
	extract($params);
	if(empty($sql)) {
		$sql = "SELECT 	p.id, p.name_ln name, p.price1, COUNT(*) cnt
				FROM 	order_detail o
						LEFT JOIN products p ON p.id=o.product_id
				WHERE	p.type_id=1
				GROUP BY p.id
				ORDER BY cnt DESC
				LIMIT 10";
	}
	if(empty($id)) $id='mycarousel';
	$top = $mm->SelAssoc($sql);
	if(empty($top)) return;
	$toReturn='<ul id="'.$id.'" class="jcarousel jcarousel-skin-tango">';
	$ln = nvl($_langs[$_SESSION['ln']], 'bg');
	$lv = ($ln=='bg'?'лв.':'lv.');
	$del_ttl = ($ln=='bg'?'Премахни':'Remove');
	foreach ($top AS $item) {
		$url = title_to_url($item['id'], $item['name']);
		$price = number_format($item['price1'], 2, '.', '');
		$price = explode(".", $price);
		$amount = "{$price[0]}<sup>{$price[1]}</sup>";
		$toReturn.="<li>
						<div class='row'>";
		if($delete) {
			$toReturn.="<div class='delete'><a href='?mode=del{$id}&{$id}id={$item['id']}' title='{$del_ttl}'>{$del_ttl}</a></div>";
		}
		$toReturn.="		<div class='img' style='background: url(/image.php?mode=file&width=90&name=img{$item['id']}_thum1.jpg) no-repeat top left;'>&nbsp;</div>
							<div class='name'><a href='/magazin/{$url}'>{$item['name']}</a></div>
							<div class='price'>{$amount}<small>{$lv}</small></div>
							<div class='buy'><a href='/basket.php?id={$item['id']}'>&nbsp;</a></div>
						</div>
		</li>";
	}
	$toReturn.=	'</ul>';
	
	
	return $toReturn;
}
?>