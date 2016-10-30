<?
include('inc/application.php');

$PAGE_ID = 2;

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

$object = $FILTER['object'];

	$museum = $mm->SelAssoc("SELECT t.seo_url, t.id, a.name_bg as area, ty.name as type, t.name, t.description as description, hp.name as historical_period, t.main_pic_id, t.seo_url, t.video_url, t.address, t.working_time, t.first_rel_place_id, t.second_rel_place_id  FROM treasure as t
								LEFT JOIN area as a ON area_id=a.id
								LEFT JOIN type as ty ON type_id=ty.id
								LEFT JOIN historical_period as hp ON hist_period_id=hp.id
								WHERE seo_url='{$object}' AND t.is_deleted=0 ORDER BY t.sorting_weight ASC");

	$museum = $museum[$object];

	$gallery = $mm->SelAssoc("SELECT picture_id from treasure_have_picture WHERE treasure_id={$museum['id']}");
	$museum['gallery'] = $gallery;

	if($museum['first_rel_place_id']){
		$first_rel_place_id = $museum['first_rel_place_id'];
		$first_rel_place = $mm->SelAssoc("SELECT t.id, a.name_bg as area, ty.name as type, t.name, t.text as description, t.link, t.picture_id FROM related_place as t
								LEFT JOIN area as a ON area_id=a.id
								LEFT JOIN type as ty ON type_id=ty.id
								WHERE t.id={$first_rel_place_id} AND t.is_deleted=0");
		if($first_rel_place != false){
			$museum['first_related_place'] = $first_rel_place[$first_rel_place_id];
		}
	}
	
	if($museum['second_rel_place_id']){
		$second_rel_place_id = $museum['second_rel_place_id'];
		$second_rel_place = $mm->SelAssoc("SELECT t.id, a.name_bg as area, ty.name as type, t.name, t.text as description, t.link, t.picture_id FROM related_place as t
								LEFT JOIN area as a ON area_id=a.id
								LEFT JOIN type as ty ON type_id=ty.id
								WHERE t.id={$second_rel_place_id} AND t.is_deleted=0");
		if($second_rel_place != false){
			$museum['second_related_place'] = $second_rel_place[$second_rel_place_id];
		}
	}
	
	$FILTER['museum'] = $museum;
	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}

	$tpl->assign_by_ref('FILTER', $FILTER);
    $tpl->display('inner-page.tpl');

}
?>
