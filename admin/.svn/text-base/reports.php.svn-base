<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Справки';
$PAGE_ID = -41;

$side_menu = array(
	array('href' => 'reports.php', 'title' => 'Отворени продукти', 'active' => true),
);

$FILTER = getFilter($_GET);


//if(!in_array(nvl($FILTER['mode']),array('hide','unhide','edit','save'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
	default:
		show($FILTER);
		break;
}


function show(&$FILTER) {
	global $mm;
	
	if(empty($FILTER['mode'])) {
	
		if(!isset($FILTER['sort_id'])) $FILTER['sort_id'] = -7;
		$sort_id = $FILTER['sort_id'];
		$order_by = abs($sort_id);
		$order_by .= ($sort_id>0?' ASC':' DESC');
		
		if($sort_id) $uri .= "sort_id=$sort_id";
		$sql = "SELECT p.id, p.name_bg name, pt.name_bg type, p.code, p.price1, p.price2, p.created_at FROM products p LEFT JOIN product_types pt ON pt.id=p.type_id WHERE p.deleted=0 AND p.hidden=0 ORDER BY $order_by";
		
		$FILTER['data'] = $mm->SelAssoc($sql,true,30,4,$uri,3);
		$FILTER['pager'] = $mm->pager;
		
	}
	$tpl = new Template_Lite();
	$tpl->assign_by_ref('FILTER',$FILTER);
	
	$tpl->display('reports.tpl');
}

function get_list(&$FILTER) {
	global $mm,$PAGE_TITLE;
	
	$FILTER = intval_filter($FILTER, 'id, sort_id');
	
	$uri = $srch_where = '';
	
	if(nvl($FILTER['search'])) {
		$srch_where = "\nWHERE ( name like '%{$FILTER['search']}%' 
				OR address like '%{$FILTER['search']}%'
				)";
		$uri="mode=search&search={$FILTER['search']}";
	}
	
	if(!isset($FILTER['sort_id'])) $FILTER['sort_id'] = 1;
	$sort_id = $FILTER['sort_id'];
	$order_by = abs($sort_id);
	$order_by .= ($sort_id>0?' ASC':' DESC');
	
	if($sort_id) $uri .= "sort_id=$sort_id";
	
	
	$sql = "SELECT 	id, name, address, hidden
			FROM partners 
			$srch_where
			ORDER BY $order_by";
	
	$FILTER['list'] = $mm->SelAssoc($sql,true,10,4,$uri,3);
	$FILTER['pager'] = $mm->pager;
}

?>