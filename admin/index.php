<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Начало';
$PAGE_ID = -1;

$sub_menu = array(
	array('href' => 'nom_product_types.php', 'title' => 'Типове продукти')
);

$sql = "SELECT 	a.id, p.name_bg, p.id prod_id, a.active_till, a.real_price, a.disc_price, u.name_bg unit, a.active_from
			FROM product_promotions a, products p, unit_types u
			WHERE a.product_id=p.id AND p.unit_type_id=u.id AND a.active_till > NOW() AND a.active_till < DATE_ADD(NOW(), INTERVAL 3 DAY)
			ORDER BY a.active_till DESC";
$FILTER['promotions'] = $mm->SelAssoc($sql,true,10,4,$uri,3);

$sql = "SELECT 	a.id, a.description_bg, a.active_till, a.active_from
			FROM product_promotions a
			WHERE a.product_id IS NULL AND a.active_till > NOW() AND a.active_till < DATE_ADD(NOW(), INTERVAL 3 DAY)
			ORDER BY a.active_till DESC";
$FILTER['group_promotions'] = $mm->SelAssoc($sql,true,10,4,$uri,3);

$sql = "SELECT 	id, status, total, status, created_at, payment_method_id, paid
		FROM orders WHERE status=1 ORDER BY created_at DESC LIMIT 10";
$FILTER['orders'] = $mm->SelAssoc($sql,false);
$FILTER['waiting_p_cnt'] = $mm->SelOne("select count(1) cnt from orders where status=1 and paid=1"); 
$FILTER['waiting_np_cnt'] = $mm->SelOne("select count(1) cnt from orders where status=1 and paid=0"); 

$sql = "
		SELECT 	id, name, active_till, discount
		FROM campaigns 
		WHERE active_till > NOW() AND active_till < DATE_ADD(NOW(), INTERVAL 7 DAY)
		ORDER BY active_till DESC
";
$FILTER['campaigns'] = $mm->SelAssoc($sql,true,10,4,$uri,3);


$tpl = new Template_Lite();
$tpl->assign_by_ref('FILTER', $FILTER);
$tpl->display('home.tpl');
?>