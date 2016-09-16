<?
include('inc/application.php');
$PAGE_ID=-29;
require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");
require_once('submenu.php');
$FILTER = getFilter($_GET);


if(empty($FILTER['back_url'])) $FILTER['back_url'] = $_SERVER['HTTP_REFERER'];

if(!in_array(nvl($FILTER['mode']),array('','sync'))) $FILTER['mode']='';

switch ($FILTER['mode']) {
	case 'sync':
		sync($FILTER);
		break;	
	default:
		show($FILTER);
		break;
}

function show(&$FILTER, $errs = array()) {
	global $PAGE_TITLE, $_cache, $mm;	
	$PAGE_TITLE .= ' - ' . ($_SESSION['ln']==1?'System processing':'Системни операции');
	
	$sql = "SELECT 	id, cnt, created_at FROM sync ORDER by id DESC";
	
	$syncs = $mm->SelAssoc($sql,true,20,4,$uri);
	
	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	$tpl->assign_by_ref('syncs', $syncs);
	$tpl->assign('pager', $mm->pager);
	$tpl->assign_by_ref('FILTER', $FILTER);
	$tpl->display('system.tpl', $_cache);
}

function sync(&$FILTER) {
	global $PAGE_TITLE, $_cache, $mm;
	$db = '89.190.214.126:D:/CS/CS.FDB';
	
	$user = 'SYSDBA';
	$password = 'masterkey';
	set_time_limit(0);
	$dbh = @ibase_connect($db,$user,$password);
	if(!$dbh) {
		$errs['sync'] = ibase_errmsg();
		$FILTER['mode'] = '';
		show($FILTER, $errs);
		exit;
	}
	
	exit;
	
	$sql = "select * from qsalescklad qs LEFT JOIN obekti o ON o.NAME=qs.OBEKTNAME WHERE o.ID=1";
	$res = ibase_query($dbh, $sql);
	
	$mistral_products = array();
	$new = 0;
	while ($row = ibase_fetch_object($res)) {
	    $mistral_products[] = $row;
	}
	
	ibase_free_result($res);
	ibase_close($dbh);
	
	if(count($mistral_products)>0) {
		foreach($mistral_products as $prod) {
			$product = $mm->SelArr("SELECT * FROM products WHERE code='{$prod->SALESARTNOMER}'");
			if(!$product) {
				$data['hidden'] = 1;
				$data['name_bg'] = $prod->ARTIKUL;
				$data['name_en'] = $prod->ARTIKUL;
				$data['short_descr_bg'] = $prod->ARTIKUL;
				$data['short_descr_en'] = $prod->ARTIKUL;
				$data['description_bg'] = $prod->ARTIKUL;
				$data['description_en'] = $prod->ARTIKUL;
				$data['code'] = $prod->SALESARTNOMER;
				$data['type_id'] = 1;
				$data['unit_type_id'] = 1;
				$data['price1'] = $prod->SALESPRICE;
				$data['quantity'] = $prod->NAL;
				
				$res = $mm->AutoExecute('products', $data, 1, false);
				if($res!==false) {
					$new++;	
				}
				
			}
		}
	}
	
	$sync['cnt'] = $new;
	$res = $mm->AutoExecute('sync', $sync, 1, false);
	
	redirect('/admin/system.php');
}

?>