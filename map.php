<?
include('inc/application.php');

$PAGE_ID = 3;

require('inc/Smarty/class.template.php');

$PAGE_TITLE =  text::get('title');

if($_POST) {
	$FILTER = getFilter($_POST);
} else {
	$FILTER = getFilter($_GET);
}



switch ($FILTER['mode']) {
	
	default:
		show($FILTER);
		break;
}

function show(&$FILTER, $errs = array()) {
	global $PAGE_TITLE, $_cache, $mm, $_config;
	$area = $mm->SelAssoc('SELECT id, name_bg as name ,X(location) as x, Y(location) as y FROM area WHERE is_deleted = 0');
	$FILTER['area'] = $area;

 	$historical_period = $mm->SelAssoc('SELECT id, name FROM historical_period WHERE is_deleted = 0');
	$FILTER['historical_period'] = $historical_period;

	$type = $mm->SelAssoc('SELECT id, name FROM type WHERE is_deleted = 0');
	$FILTER['type'] = $type;

	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}

	$tpl->assign_by_ref('FILTER', $FILTER);
    $tpl->display('map.tpl');

}
?>
