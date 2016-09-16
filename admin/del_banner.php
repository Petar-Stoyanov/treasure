<?
include("{$_SERVER['DOCUMENT_ROOT']}/inc/config.php");
include("{$_SERVER['DOCUMENT_ROOT']}/inc/functions.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/db.class.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/log.php");

$FILTER = getFilter($_GET);
$FILTER['id'] = intval($FILTER['id']);

if(file_exists("{$_config['root_dir']}/img/products/banner{$FILTER['id']}.swf")) unlink("{$_config['root_dir']}/img/products/banner{$FILTER['id']}.swf");

redirect($FILTER['back_url']);
	
?>