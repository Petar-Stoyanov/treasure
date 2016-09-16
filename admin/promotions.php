<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Промоции';
$PAGE_ID = -17;
require_once('submenu.php');
$side_menu = array(
	array('href' => 'promotions.php', 'title' => 'Активни промоции', 'active' => true),
	array('href' => 'group_promotions.php', 'title' => 'Групови промоции'),
	array('href' => 'recommended.php', 'title' => 'Препоръчани продукти'),
	array('href' => 'branding.php', 'title' => 'Брандиране'),
	array('href' => 'campaigns.php', 'title' => 'Кампании'),
	array('href' => 'campaigns_delivery.php', 'title' => 'Кампании за безпл. доставка'),
	array('href' => 'campaigns_register.php', 'title' => 'Кампании за регистрация'),
	array('href' => 'campaigns_firstorder.php', 'title' => 'Кампании за първа поръчка'),
);

if($_POST) {
	$FILTER = getFilter($_POST);
	if(isset($_POST['search'])) {
		$get = getFilter($_GET);
		if(is_array($get)) $FILTER = array_merge($FILTER,$get);
		
		$FILTER = quotes_filter($FILTER, 'search');
	} else {
		$FILTER['mode'] = 'save';
		$FILTER = quotes_filter($FILTER, 'description_bg, description_en, active_till, active_from');
		$FILTER = intval_filter($FILTER,'id, prod_id, unit_type_id');
		$FILTER['real_price'] = doubleval($FILTER['real_price']);
		$FILTER['disc_perc'] = doubleval($FILTER['disc_perc']);
		$FILTER['disc_price'] = doubleval($FILTER['disc_price']);
	}
} else {
	$FILTER = getFilter($_GET);
	$FILTER['id'] = intval($FILTER['id']);
}

if(!in_array(nvl($FILTER['mode']),array('edit','save','del'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
	case 'edit':
		edit($FILTER);
		break;
	case 'save':
		insertUpdate($FILTER);
		break;
	case 'del':
		$mm->Query("DELETE FROM product_promotions WHERE id={$FILTER['id']}");
		redirect($FILTER['back_url']);
		break;
	default:
		show($FILTER);
		break;
}


function show(&$FILTER) {
	
	get_list($FILTER);	
	
	$tpl = new Template_Lite();
	$tpl->assign_by_ref('FILTER',$FILTER);
	
	$tpl->display('promotions.tpl');
}


function edit(&$FILTER,$errs = array()){
	global $mm;
	
	$FILTER['id']=intval($FILTER['id']);
	$FILTER['prod_id']=intval(nvl($FILTER['prod_id'])); // get the product id from request. Happens when new promotion is added ($FILTER['id'] == -1)
	
	if(empty($errs) && $FILTER['id']!=-1) {
		$res = $mm->SelAssoc("	SELECT 	id, product_id, active_from, active_till, disc_perc, disc_price, real_price, description_bg, description_en
								FROM product_promotions
								WHERE id={$FILTER['id']}
							");
		if($res!=false) {
			$FILTER['item'] = $res[$FILTER['id']];
			if(!$FILTER['prod_id']) $FILTER['prod_id'] = $FILTER['item']['product_id']; //get the product id from the promotion.
		} else {
			redirect('promotions.php');
		}
	}
	
	if($FILTER['prod_id']>0) { // get product information
		$FILTER['product'] = $mm->SelArr("SELECT id, name_bg as name, short_descr_bg, type_id, price1, price2, unit_type_id FROM products WHERE id={$FILTER['prod_id']}");
		$FILTER['real_price'] = $FILTER['product']['price1'];
	}
	
	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	
	$cache .= "|edit";
	$tpl->assign_by_ref('FILTER', $FILTER);
	$tpl->assign_by_ref('errs', $errs);
	$tpl->display('promotions.tpl', $cache);
}


function insertUpdate(&$FILTER) {
	global $mm;
	
		
	$FILTER['item']['product_id'] = $FILTER['prod_id'];
	$FILTER['item']['description_bg'] = $FILTER['description_bg'];
	$FILTER['item']['description_en'] = $FILTER['description_en'];
	$FILTER['item']['real_price'] = $FILTER['real_price'];
	$FILTER['item']['disc_perc'] = $FILTER['disc_perc'];
	$FILTER['item']['disc_price'] = $FILTER['disc_price'];
	
	if(empty($FILTER['active_from'])) $errs['active_from'] = 'Полето е задължително.';
	if(empty($FILTER['active_till'])) $errs['active_till'] = 'Полето е задължително.';
	if(empty($FILTER['disc_price'])) $errs['disc_price'] = 'Полето е задължително.';
	if(!empty($errs)) {
		$FILTER['mode'] = 'edit';
		edit($FILTER, $errs);
		return;
	}

	$FILTER['item']['active_till'] = formatDate($FILTER['active_till']);
	$FILTER['item']['active_from'] = formatDate($FILTER['active_from']);
	
	if($FILTER['id']>0) {
		$res = $mm->AutoExecute('product_promotions', $FILTER['item'], 2, "id={$FILTER['id']}");
	} else {
		$res = $mm->AutoExecute('product_promotions', $FILTER['item'], 1, false);
	}
	redirect($FILTER['back_url']);	
}

function get_list(&$FILTER) {
	global $mm;
	
	$FILTER = intval_filter($FILTER, 'id, sort_id');
	
	$uri = '';
	$srch_where = "\nWHERE a.product_id=p.id AND active_till >= CURDATE()";
	
	if(nvl($FILTER['search'])) {
		$srch_where .= "\nAND( p.name_bg like '%{$FILTER['search']}%' 
				OR p.name_en like '%{$FILTER['search']}%'
				)";
		$uri="mode=search&search={$FILTER['search']}";
	}
	
	if(!isset($FILTER['sort_id'])) $FILTER['sort_id'] = 1;
	$sort_id = $FILTER['sort_id'];
	$order_by = abs($sort_id);
	$order_by .= ($sort_id>0?' ASC':' DESC');
	
	if($sort_id) $uri .= "sort_id=$sort_id";
	
	
	$sql = "SELECT 	a.id, p.name_bg, p.id prod_id, p.type_id, a.active_till, a.real_price, a.disc_price, a.active_from
			FROM product_promotions a, products p
			$srch_where
			ORDER BY $order_by";
	
	$FILTER['list'] = $mm->SelAssoc($sql,true,10,4,$uri,3);
	$FILTER['pager'] = $mm->pager;
}

?>