<?php
/**
 * template_lite {backurl} function plugin
 *
 * Type:     function
 * Name:     backurl
 * Purpose:  Fixes the backurl link
 * Input:
 *           - back_url = the url
 * Author:   Konstantin Radoslavov
 */
function tpl_function_backurl($params, &$tpl) {
	global $_config;
	require_once("shared.escape_chars.php");
	extract($params);

	if(!isset($back_url)) $back_url = $_SERVER['REQUEST_URI'];
	
	$back_url = preg_replace('/(http:\/\/)+(www.)?apollowine\.com/', '', $back_url);
	$back_url = preg_replace('/en\//', '', $back_url);
	$back_url = preg_replace('/ru\//', '', $back_url);
	
	if(empty($ln)) {
		switch($_SESSION['ln']) {
			case 1:
				$lang_url = 'en/';
				break;
			case 3:
				$lang_url = 'ru/';
				break;
			default:
				$lang_url = '';
				break;
		}
	} else {
		switch($ln) {
			case 1:
				$lang_url = 'en/';
				break;
			case 3:
				$lang_url = 'ru/';
				break;
			default:
				$lang_url = '';
				break;
		}
	}
	
	if(substr($back_url,0,1)=='/') {
		$back_url = substr($back_url,1);
		$back_url = "/" . $lang_url . $back_url;
	} else {
		$back_url = $lang_url . $back_url;
	}
	$back_url = $_config['base_url'] . $back_url;
	return $back_url;
	
}
?>