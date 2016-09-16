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
function tpl_function_getText($params, &$tpl) {
	global $mm, $PAGE_ID, $_config, $_langs;
	require_once("shared.escape_chars.php");
	extract($params);

	if(!isset($pageid)) $pageid = $PAGE_ID;
	if(!isset($pageid)) return "*{$textid}*";
	
	if(empty($textid)) return '';
	
	require("{$_config['root_dir']}/inc/page_{$pageid}.php");
	
	$lang = $_langs[$_SESSION['ln']];
	
	if(isset($_text[$textid])) {
		return $_text[$textid][$lang];
	}else{
		return "*{$textid}*";
	}
}
?>