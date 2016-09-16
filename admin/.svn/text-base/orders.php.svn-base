<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Поръчки';
$PAGE_ID = -25;
require_once('submenu.php');

$type = nvl($_REQUEST['type']);
if (!in($type, 1,2,3,4,5)) $type=1;
$p = intval($_GET['p']);
if($p!=0) $p = 1;

$order_cnts = $mm->SelAssoc("
select 1 type, count(1) cnt from orders where status=1 and paid=0
union all 
select 2 type, count(1) cnt from orders where status=1 and paid=1
union all 
select 3 type, count(1) cnt from orders where status=2
union all 
select 4 type, count(1) cnt from orders where status=3
union all
select 5 type, count(1) cnt from orders where status=4
union all 
select 6 type, count(1) cnt from orders where status=5

"); 

$side_menu["1_0"] = array('href' => 'orders.php?type=1&p=0', 'title' => "Чакащи неплатени поръчки ({$order_cnts[1]['cnt']})", 'active' => ($type==1 && $p==0));
$side_menu["1_1"] = array('href' => 'orders.php?type=1&p=1', 'title' => "Чакащи платени поръчки ({$order_cnts[2]['cnt']})", 'active' => ($type==1 && $p==1));
$side_menu["2_0"] = array('href' => 'orders.php?type=2', 'title' => "Изпратени поръчки ({$order_cnts[3]['cnt']})", 'active' => ($type==2));
$side_menu["3_0"] = array('href' => 'orders.php?type=3', 'title' => "Доставени поръчки ({$order_cnts[4]['cnt']})", 'active' => ($type==3));
$side_menu["4_0"] = array('href' => 'orders.php?type=4', 'title' => "Приключени поръчки ({$order_cnts[5]['cnt']})", 'active' => ($type==4));
$side_menu["5_0"] = array('href' => 'orders.php?type=5', 'title' => "Отказани поръчки ({$order_cnts[6]['cnt']})", 'active' => ($type==5));


if($_POST) {
	$FILTER = getFilter($_POST);
	if(isset($_POST['search'])) {
		$get = getFilter($_GET);
		if(is_array($get)) $FILTER = array_merge($FILTER,$get);
		
		$FILTER = quotes_filter($FILTER, 'search');
	} else {
		$FILTER['id'] = intval($FILTER['id']);
	}
} else {
	$FILTER = getFilter($_GET);
	$FILTER = intval_filter($FILTER,'id,type');
}


if(!in_array(nvl($FILTER['mode']),array('edit','view','save'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
	case 'view':
	case 'edit':
		edit($FILTER);
		break;
	case 'save':
		insertUpdate($FILTER);
		break;
	default:
		show($FILTER);
		break;
}


function show(&$FILTER) {
	
	get_list($FILTER);	
	
	$tpl = new Template_Lite();
	$tpl->assign_by_ref('FILTER',$FILTER);
	
	$tpl->display('orders.tpl');
}


function edit(&$FILTER,$errs = array()){
	global $mm;
	
	if(stristr($return_to,'products.php')) $return_to = "orders.php?type={$FILTER['type']}";
	
	if($FILTER['act']){
		$upd_fld='';
		$return_to = $_SERVER['HTTP_REFERER'];
		$cur_status = order::getStatus($FILTER['id']);
		switch($FILTER['act']) {
			case 'setpaid':
				$upd_fld = 'paid=1';
				$return_to = replace_param_in_url('p','1',$return_to);
				$new_status = $cur_status;
				break;
			case 'shi':
				$date = formatDate($FILTER['delivery_date']);
				$upd_fld = "status=2, delivery_date='$date'";
				$return_to = replace_param_in_url('type','2',$return_to);
				$new_status = 2;
				break;
			case 'del':
				$date = formatDate($FILTER['delivered_date']);
				$upd_fld = "status=3, delivered_date='$date'";
				$return_to = replace_param_in_url('type','3',$return_to);
				$new_status = 3;
				break;
			case 'clo':
				$upd_fld = 'status=4';
				$return_to = replace_param_in_url('type','4',$return_to);
				$new_status = 4;
				break;
			case 'rej':
				$upd_fld = 'status=5';
				$return_to = replace_param_in_url('type','5',$return_to);
				$new_status = 5;
				break;
		}
		if($upd_fld) {
			$mm->Query("UPDATE orders SET $upd_fld WHERE id={$FILTER['id']}");
			if($new_status<>$cur_status) mailer::send_order_change($FILTER['id'],$cur_status,$new_status);
			redirect($return_to);
		}
	}
	
	if(!empty($return_to)) {
		$FILTER['back_url'] = $return_to;
	}
	
	if(empty($errs) && $FILTER['id']!=-1) {
		$FILTER['order'] = order::getDetails($FILTER['id']);
		$FILTER['addresses'] = $mm->SelAssoc("
			SELECT ua.id, CONCAT_WS(', ', ua.street, ua.city, ua.zip, CONCAT('тел.',ua.phone), ac.name_bg) AS address FROM user_addresses ua LEFT JOIN allcountries ac ON ac.id=ua.country WHERE ua.user_id={$FILTER['order']['user_id']}
		");
		
		if($FILTER['order']['address_id']>0) {
			$FILTER['notes'] = $mm->SelOne("SELECT notes FROM user_addresses WHERE id={$FILTER['order']['address_id']}");
		}
		
		$FILTER['is_camp_applied'] = $mm->SelOne("
										SELECT campaign_id cid FROM order_detail 
										WHERE campaign_id IS NOT NULL 
											  AND order_id={$FILTER['id']}
										LIMIT 1
									");
		if($FILTER['is_camp_applied']) {
			$campaigns = $mm->SelAssoc("SELECT id, name, discount, for_firstorder FROM campaigns");
			if(!$campaigns[$FILTER['is_camp_applied']]['for_firstorder']) {
				$FILTER['promo_disc_ttl'] = order::getTotalPromoDiscount($FILTER['id']);
			}
		}
	} 
		
	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	
	$cache .= "|edit";
	$tpl->assign_by_ref('FILTER', $FILTER);
	if(isset($errs)) $tpl->assign_by_ref('errs', $errs);
	if(isset($campaigns)) $tpl->assign_by_ref('campaigns',$campaigns);
	$tpl->display('orders.tpl', $cache);
}


function insertUpdate(&$FILTER) {
	global $mm;
	$FILTER = intval_filter($FILTER,'id, address_id, payment_method_id, status');
	$FILTER['discount'] = doubleval($FILTER['discount']);
	$FILTER['paid'] = intval(nvl($FILTER['paid']));
	
	$changed_qtys = array_diff_assoc($_POST['new_qty'],$_POST['prev_qty']);
	foreach($changed_qtys as $pid=>$qty) {
		intval($pid);
		intval($qty);
		order::setProductQuantity($qty,$pid,$FILTER['id']);
	}
	
	$delivery_date = '';
	$delivered_date = '';
	if($FILTER['delivery_date']) {
		$delivery_date = formatDate($FILTER['delivery_date']);
		$delivery_date = ", delivery_date = '$delivery_date'";
	}
	if($FILTER['delivered_date']) {
		$delivered_date = formatDate($FILTER['delivered_date']);
		$delivered_date = ", delivered_date = '$delivered_date'";
	}
	
	$delivery_price = order::getDeliveryPrice($FILTER['id']);
	if(empty($delivery_price)) $delivery_price = "null";
	$cur_status = order::getStatus($FILTER['id']);
	$new_status = $FILTER['status'];
	$mm->Query("UPDATE orders 
				SET paid = {$FILTER['paid']},
					address_id = {$FILTER['address_id']},
					payment_method_id = {$FILTER['payment_method_id']},
					status = {$FILTER['status']},
					delivery_price = $delivery_price
					$delivery_date
					$delivered_date
				WHERE id = {$FILTER['id']}
				");
		
	$FILTER['discount'] = floatval($FILTER['discount']);
	order::setDiscount($FILTER['id'], $FILTER['discount']);
	
	// send email for changing the status
	if($new_status<>$cur_status) mailer::send_order_change($FILTER['id'],$cur_status,$new_status);
	log::logNotice('orders',"Order [{$FILTER['id']}] modified: [<pre>" . print_r($FILTER, true) . "</pre>]");
	//$FILTER['back_url'] = replace_param_in_url(array('type'=>$FILTER['status'],'p'=>$FILTER['paid']),null,$FILTER['back_url']);
	if(empty($FILTER['back_url'])) {
		if(empty($_SERVER['HTTP_REFERER'])) {
			$FILTER['back_url'] = "orders.php?mode=view&id={$FILTER['id']}&type={$FILTER['status']}&p={$FILTER['paid']}";
		} else {
			$FILTER['back_url'] = $_SERVER['HTTP_REFERER'];
		}
	}
	redirect($FILTER['back_url']);
	//redirect("orders.php?mode=edit&tab=4&id={$FILTER['id']}&type={$FILTER['type']}");
	
}

function get_list(&$FILTER) {
	global $mm,$PAGE_TITLE;
	
	$FILTER = intval_filter($FILTER, 'id, sort_id, type');
	if(!in($FILTER['type'], 1,2,3,4,5)) $FILTER['type']=1;
	$uri = "type={$FILTER['type']}";
	$paid = '';
	if(isset($_GET['p'])) {
		$p = intval($_GET['p']);
		if($p != 0) $p = 1;
		$paid = " AND paid = $p";
		$uri .= "&p=$p";
	}
	
	
	$srch_where = "WHERE status={$FILTER['type']}{$paid}";
	
	if(nvl($FILTER['search'])) {
		$srch_where = "\nWHERE ( fname like '%{$FILTER['search']}%' 
				OR lname like '%{$FILTER['search']}%' OR email like '%{$FILTER['search']}%'
				) AND status<>0";
		$uri.="&mode=search&search={$FILTER['search']}";
	}
	
	if(!isset($FILTER['sort_id'])) $FILTER['sort_id'] = 1;
	$sort_id = $FILTER['sort_id'];
	$order_by = abs($sort_id);
	$order_by .= ($sort_id>0?' ASC':' DESC');
	
	if($sort_id) $uri .= "&sort_id=$sort_id";
	
	
	$sql = "SELECT 	o.id, CONCAT(u.fname, ' ', u.lname) name, u.email, o.total, o.status, o.created_at, o.user_id, payment_method_id, paid
			FROM orders o
				JOIN users u ON o.user_id=u.id
			$srch_where
			ORDER BY $order_by";
	
	$FILTER['list'] = $mm->SelAssoc($sql,true,10,4,$uri,3);
	$FILTER['pager'] = $mm->pager;
}

?>