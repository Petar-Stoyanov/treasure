<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Начало';
$PAGE_ID = -1;

$sub_menu = array(
	array('href' => 'nom_product_types.php', 'title' => 'Типове продукти')
);


$tpl = new Template_Lite();
$tpl->assign_by_ref('FILTER', $FILTER);
$tpl->display('home.tpl');
?>