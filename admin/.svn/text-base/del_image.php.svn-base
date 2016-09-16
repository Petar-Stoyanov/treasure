<?
include("{$_SERVER['DOCUMENT_ROOT']}/inc/config.php");
include("{$_SERVER['DOCUMENT_ROOT']}/inc/functions.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/db.class.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/log.php");

$FILTER = getFilter($_GET);
$FILTER['id'] = intval($FILTER['id']);

if($FILTER['mode']=='file') {
	$image = "{$_config['root_dir']}/img/products/{$FILTER['name']}";
	if(file_exists($image)) {
		unlink($image);
	}

} elseif($FILTER['mode']=='stat_page') { //stat page photo
	$FILTER['name'] = 'stat_page' . $FILTER['id'] . '_' . $FILTER['field'] . '.png';
	$image = "{$_config['root_dir']}/img/stat_page/{$FILTER['name']}";
	if(file_exists($image)) {
		unlink($image);
	} else {
		$FILTER['name'] = 'stat_page' . $FILTER['id'] . '_' . $FILTER['field'] . '.jpg';
		$image = "{$_config['root_dir']}/img/stat_page/{$FILTER['name']}";
		if(file_exists($image)) {
			unlink($image);
		}
	}
} elseif($FILTER['mode']=='gallery') { //stat page photo
	$image = "{$_config['root_dir']}/img/galleries/{$FILTER['id']}/{$FILTER['name']}";
	if(file_exists($image)) {
		unlink($image);
	}
} elseif($FILTER['mode']=='gp') { //gallery photo
	$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
	$mm->UseDB($_config['db_dbname']);
	$mm->Query("SET NAMES cp1251");
	
	$table = $FILTER['type'];
	
	$res = $mm->SelRow("DELETE FROM {$table} WHERE id={$FILTER['id']}");

} else {
	$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
	$mm->UseDB($_config['db_dbname']);
	$mm->Query("SET NAMES cp1251");
	
	$table = $FILTER['type'];
	$photo_fld = nvl($FILTER['field'],'photo');
	$type_fld = ($photo_fld=='photo'?'image_type':"{$photo_fld}_type");
	$res = $mm->Query("UPDATE {$table} SET {$photo_fld}=NULL, {$type_fld}=NULL WHERE id={$FILTER['id']}");
}

redirect($FILTER['back_url']);
	
?>