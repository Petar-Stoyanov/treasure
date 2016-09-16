<?
if(in($PAGE_ID,-5,-6,-7,-8,-9,-10,-11,-12,-15,-16,-17,-18,-19,-20,-23,-25,-39,-40)) {
	$noms_sel = in($PAGE_ID,-5,-6,-7,-8,-9,-10,-11,-12,-16,-18,-20,-23);
	$sub_menu = array(
		array('href' => 'orders.php?type=1&p=0', 'title' => 'Поръчки', 'selected'=>($PAGE_ID==-25)),
		array('href' => 'products.php', 'title' => 'Продукти','selected'=>($PAGE_ID==-15)),
		array('href' => 'promotions.php', 'title' => 'Промоции','selected'=>($PAGE_ID==-17)),
		array('href' => 'nom_product_types.php', 'title' => 'Номенклатури', 'selected' => $noms_sel),
		array('href' => 'product_groups.php', 'title' => 'Групи', 'selected' => ($PAGE_ID==-19)),
		array('href' => 'del_zones.php', 'title' => 'Зони доставки', 'selected' => ($PAGE_ID==-39)),
		array('href' => 'popular_searches.php', 'title' => 'Най-търсени', 'selected' => ($PAGE_ID==-40)),
		array('href' => 'product_outfits.php', 'title' => 'Аутфити', 'selected' => ($PAGE_ID==-20)),
	);
} elseif(in($PAGE_ID, -21)) {
	$sub_menu = array(
		array('href' => 'library.php?type=library', 'title' => 'Статии','selected'=>($_GET['type']=='library')),
		array('href' => 'library.php?type=news', 'title' => 'Новини', 'selected' => $_GET['type']=='news'),
		array('href' => 'library.php?type=static', 'title' => 'Статични страници', 'selected' => $_GET['type']=='static'),
	);
} elseif(in($PAGE_ID, -30,-38)) {
	$sub_menu = array(
		//array('href' => 'system.php', 'title' => 'Синхронизация', 'selected'=>($PAGE_ID==-29)),
		array('href' => 'archive.php', 'title' => 'Архиви на БД','selected'=>($PAGE_ID==-30)),
		array('href' => 'settings.php', 'title' => 'Настройки','selected'=>($PAGE_ID==-38))
	);
}

?>