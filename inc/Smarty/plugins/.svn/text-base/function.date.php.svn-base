<?php
/**
 * template_lite {html_input} function plugin
 *
 * Type:     function
 * Name:     html_input
 * Purpose:  Creates a pager element
 * Input:
 *           - name = the name of the textbox
 *           - password = boolean - if set, this box will be a password box
 *           - value = optional default value for the input box
 *           - size = optional size for the input box
 *           - length = optional maxlength for the input box
 * Author:   Paul Lockaby <paul@paullockaby.com>
 */
function tpl_function_date($params, &$tpl) {
	global $mm, $_text;
	
	extract($params);
	$lang = ($_SESSION['ln']==1?'en':'bg');
	if($now) {
		$l = date('l');
		$l = $_text[$l][$lang];
		$M = date('M');
		$M = $_text[$M][$lang];
		$Y = date('Y');
		$d = date('d');
		date('l, d M Y');
		$toReturn = "{$l}, {$d} {$M} {$Y}";
	}
	
	return $toReturn;
}
?>