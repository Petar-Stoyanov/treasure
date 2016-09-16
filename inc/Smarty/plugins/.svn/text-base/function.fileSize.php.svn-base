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
function tpl_function_fileSize($params, &$tpl) {
	global $mm, $_text;
	
	extract($params);
	$dsize = $size;
	if(empty($dsize)) {
		LOG::logError('function.fileSize.php','tpl_function_fileSize() no size prameter.');
		return false;
	}
	
	if (strlen($dsize) <= 9 && strlen($dsize) >= 7) {
		$dsize = number_format($dsize / 1048576,1);
		return "$dsize MB";
	} elseif (strlen($dsize) >= 10) {
		$dsize = number_format($dsize / 1073741824,1);
		return "$dsize GB";
	} else {
		$dsize = number_format($dsize / 1024,1);
		return "$dsize KB";
	}
}
?>