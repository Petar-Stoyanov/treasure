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
function tpl_function_fileIcon($params, &$tpl) {
	global $mm, $_text;
	
	extract($params);
	$file = 'fileUnknown';
	
	switch ($type) {
		case 'application/msword':
			$file = 'fileWord';
			break;
		case 'application/excel':
		case 'application/vnd.ms-excel':
		case 'application/x-excel':
		case 'application/x-msexcel':
			$file = 'fileExcel';
			break;
		case 'application/mspowerpoint':
		case 'application/powerpoint':
		case 'application/vnd.ms-powerpoint':
		case 'application/x-mspowerpoint':
			$file = 'filePowerpoint';
			break;
	}
		
	$toReturn =  "<img src='/img/icons/{$file}.png' width='16' height='16'>";
	return $toReturn;
}
?>