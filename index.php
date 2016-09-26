<?
include('inc/application.php');

$PAGE_ID = 1;

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

	$museums = $mm->SelAssoc('SELECT area_id, name, type_id, hist_period_id, main_pic_id, sorting_weight FROM treasure WHERE is_deleted=0 ORDER BY sorting_weight ASC');
	

	$FILTER['museums'] = $museums;

	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}

	$tpl->assign_by_ref('FILTER', $FILTER);
    $tpl->display('home.tpl');

}
?>
