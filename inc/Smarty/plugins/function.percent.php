<?php
/**
 * template_lite {percent} function plugin
 *
 * Type:     function
 * Name:     percent
 * Purpose:  Formats price
 * Input:
 *           - num1 = first number
 *           - num2 = second number
 * Author:   Konstantin Radoslavov
 */
function tpl_function_percent($params, &$tpl)
{
	require_once("shared.escape_chars.php");
	extract($params);

	if (empty($num1) || empty($num2))
	{
		return '';
		
	}
	$per = floatval(($num1 - $num2)/$num1*100);
	//$per = number_format($per, 2, '.' , '');
	
	return $per . '%';
}
?>