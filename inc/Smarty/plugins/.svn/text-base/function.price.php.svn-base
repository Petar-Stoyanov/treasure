<?php
/**
 * template_lite {price} function plugin
 *
 * Type:     function
 * Name:     price
 * Purpose:  Formats price
 * Input:
 *           - amount = the actual price
 * Author:   Konstantin Radoslavov
 */
function tpl_function_price($params, &$tpl)
{
	require_once("shared.escape_chars.php");
	extract($params);

	if (empty($amount))
	{
		return '0.00';
		//return '0<sup>00</sup>';
	}
	$price = number_format($amount, 2, '.', '');
	$toReturn = $price;
	//$price = explode(".", $price);
	$toReturn .= "<span>".text::get('lv', 0)."</span>";
	
	return $toReturn;
}
?>