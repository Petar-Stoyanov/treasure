<?php
/**
 * template_lite {langUrl} function plugin
 *
 * Type:     function
 * Name:     langUrl
 * Purpose:  returns the language url prefix
 * Author:   Konstantin Radoslavov
 */
function tpl_function_langUrl($params, &$tpl)
{
	require_once("shared.escape_chars.php");
	extract($params);

	$url = '';
	if($_SESSION['ln']==1) {
		return $url . "en/";
	} else if($_SESSION['ln']==3) {
		return $url . "ru/";
	} else {
		return $url;
	}
}
?>