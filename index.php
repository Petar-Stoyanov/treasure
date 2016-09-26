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

	$museums = $mm->SelAssoc('SELECT t.id, a.name_bg as area, ty.name as type, t.name, hp.name as historical_period, t.main_pic_id FROM treasure as t
								LEFT JOIN area as a ON area_id=a.id
								LEFT JOIN type as ty ON type_id=ty.id
								LEFT JOIN historical_period as hp ON hist_period_id=hp.id
								WHERE t.is_deleted=0 ORDER BY t.sorting_weight ASC');

	$slider = $mm->SelAssoc("SELECT picture_id, text, link FROM slider WHERE is_deleted=0");

	$FILTER['museums'] = $museums;
	$FILTER['slider'] = $slider;

	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}

	$tpl->assign_by_ref('FILTER', $FILTER);
    $tpl->display('home.tpl');

}
?>
