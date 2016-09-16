<?php
/**
 * template_lite {topWines} function plugin
 *
 * Type:     function
 * Name:     html_input
 * Purpose:  Returns the 10 top wines mostly ordered 
 * Author:   Konstantin Radoslavov
 */
function tpl_function_topWines($params, &$tpl) {
	global $mm, $_langs;
	
	require_once("shared.escape_chars.php");
	extract($params);
	$top = $mm->SelAssoc("
					SELECT p.id, p.name_bg name, p.price1, COUNT(*) cnt
					FROM 	order_detail o
							LEFT JOIN products p ON p.id=o.product_id
					WHERE	p.type_id=1
					GROUP BY p.id
					ORDER BY cnt DESC
					LIMIT 5");
	if(empty($top)) return;
	$toReturn='<ul id="mycarousel" class="jcarousel jcarousel-skin-tango">';
	$ln = nvl($_langs[$_SESSION['ln']], 'bg');
	$lv = ($ln==2?'лв.':'lv.');
	foreach ($top AS $item) {
		$url = title_to_url($item['id'], $item['name']);
		$price = number_format($item['price1'], 2, '.', '');
		$price = explode(".", $price);
		$amount = "{$price[0]}<sup>{$price[1]}</sup>";
		$toReturn.="<li>
						<div class='row'>
							<div class='img' style='background: url(/image.php?mode=file&width=90&name=img{$item['id']}_thum1.jpg) no-repeat top left;'>&nbsp;</div>
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