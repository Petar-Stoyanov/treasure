<? $PAGE_ID=-27;
include('inc/application.php');
require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$FILTER = getFilter($_GET);


if(empty($FILTER['back_url'])) $FILTER['back_url'] = $_SERVER['HTTP_REFERER'];

if(!in_array(nvl($FILTER['mode']),array('','del', 'delall'))) $FILTER['mode']='';

switch ($FILTER['mode']) {
	case 'del':
		$sql = "DELETE FROM log WHERE id={$FILTER['id']}";
		$mm->Query($sql);
		redirect("log.php");
		break;
	case 'delall':
		$sql = "truncate table log";
		$mm->Query($sql);
		redirect("log.php");
		break;
	
	default:
		show($FILTER);
		break;
}

function show(&$FILTER, $errs = array()) {
	global $PAGE_TITLE, $_cache, $mm;	
	$PAGE_TITLE .= ' - ' . ($_SESSION['ln']==1?'Application Log':'Системен Лог');
	
	$sql = "SELECT 	l.id, l.source, l.message, l.type, ifnull(u.email, l.user_id) username, ifnull(au.name, l.admuser_id) admusername, l.created_at 
							FROM 	log l
									LEFT JOIN users u ON u.id=l.user_id
									LEFT JOIN adminusers au ON au.id=l.admuser_id
							ORDER by id DESC";
	
	$logs = $mm->SelAssoc($sql,true,40,4,$uri,3);
	
	/*
	define('LOG_ERROR', 1);
	define('LOG_WARNING', 2);
	define('LOG_NOTICE', 3);
	define('LOG_LOG', 4);
	*/
	$tpl = new Template_Lite();
	
	$tpl->assign_by_ref('logs', $logs);
	$tpl->assign('pager', $mm->pager);
	$tpl->assign_by_ref('FILTER', $FILTER);
	$tpl->display('log.tpl', $_cache);
}
?>