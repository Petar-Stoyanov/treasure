<?
include('inc/application.php');
$PAGE_ID=-38;
require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");
require_once('submenu.php');
$FILTER = getFilter($_GET);

if($_POST) {
	$FILTER = getFilter($_POST);
	$FILTER['mode'] = 'save';	
	$FILTER = quotes_filter($FILTER, 'email');
	$FILTER = intval_filter($FILTER, 'id');
} else {
	$FILTER = getFilter($_GET);
}

if(!in_array(nvl($FILTER['mode']),array('','save'))) $FILTER['mode']='';

switch ($FILTER['mode']) {
	case 'save':
		$FILTER['vat'] = floatval($FILTER['vat']);
		$FILTER['eur'] = floatval($FILTER['eur']);
		$FILTER['usd'] = floatval($FILTER['usd']);
		
		$set['email']=(!empty($FILTER['email'])?$FILTER['email']:null);
		$set['vat']=(!empty($FILTER['vat'])?$FILTER['vat']:null);
		$set['eur']=(!empty($FILTER['eur'])?$FILTER['eur']:null);
		$set['usd']=(!empty($FILTER['usd'])?$FILTER['usd']:null);
		$mm->AutoExecute('system', $set, 2, "id={$FILTER['id']}");
		redirect('settings.php');
		break;	
	default:
		show($FILTER);
		break;
}

function show(&$FILTER, $errs = array()) {
	global $PAGE_TITLE, $_cache, $mm;	
	$PAGE_TITLE .= ' - ' . ($_SESSION['ln']==1?'System settings':'Системни настройки');
	
	$sql = "SELECT 	id, email, vat, eur, usd FROM system WHERE id=1";
	
	$settings = $mm->SelArr($sql);
	print_r($settings);
	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	$tpl->assign_by_ref('settings', $settings);
	$tpl->assign_by_ref('FILTER', $FILTER);
	$tpl->display('settings.tpl', $_cache);
}
?>