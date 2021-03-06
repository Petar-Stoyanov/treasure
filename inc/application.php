<?
if(empty($_SESSION)) {
	session_start();
}
include("{$_SERVER['DOCUMENT_ROOT']}/inc/config.php");

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
	header('Location: ' . $_config['mobile_base_url']);
}
include("{$_config['root_dir']}/inc/functions.php");
include("{$_config['root_dir']}/managers/db.class.php");
include("{$_config['root_dir']}/managers/log.php");
include("{$_config['root_dir']}/inc/constants.php");

$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
$mm->UseDB($_config['db_dbname']);
$mm->Query("SET NAMES utf8");

include("{$_config['root_dir']}/inc/session.php");

if(preg_match('/\/en\//',$_SERVER['REQUEST_URI'])) {
	$_SESSION['ln']=1;
	$_SESSION['isoLN']=$_langs[$_SESSION['ln']];
} else if(preg_match('/\/ro\//',$_SERVER['REQUEST_URI'])) {
	$_SESSION['ln']=3;
	$_SESSION['isoLN']=$_langs[$_SESSION['ln']];
} else {
	$_SESSION['ln']=2;
	$_SESSION['isoLN']=$_langs[$_SESSION['ln']];
}

if(!isset($_SESSION['ln'])) {
	$_SESSION['ln']=2;
	$_SESSION['isoLN']=$_langs[$_SESSION['ln']];
}

// $groups = $mm->SelAssoc("SELECT id, name_ln name FROM product_groups ORDER BY id LIMIT 4");

// if(!empty($groups)) {
// 	$GLOBALS['groups'] = $groups;
// }

// $product_types = $mm->SelAssoc("SELECT id, name_ln title, description_ln description, slug, IF(photo2 IS NOT NULL, 1, 0) AS photo2 FROM product_types WHERE id<5");
// if(!empty($product_types)) {
// 	foreach($product_types AS &$pt) {
// 		$pt['categories'] = $mm->SelAssoc("SELECT pc.id, pc.name_ln name, pc.slug FROM product_category pc WHERE pc.hidden=0 AND pc.product_type_id={$pt['id']} AND EXISTS (SELECT 1 FROM products WHERE product_category_id=pc.id AND deleted=0 and hidden=0)");
// 	}
	
// 	$GLOBALS['_product_types'] = $product_types;
// }

// $product_colors = $mm->SelAssoc("SELECT c.id, c.name_ln title, c.name_bg FROM product_quantity p LEFT JOIN product_colors c ON c.id=p.product_color_id WHERE p.qty>0 ORDER BY c.name_ln");
// if(!empty($product_colors)) {
// 	$GLOBALS['_product_colors'] = $product_colors;
// }

// $product_sizes = $mm->SelAssoc("SELECT s.id, s.name_ln title, s.name_bg FROM product_quantity p LEFT JOIN product_sizes s ON s.id=p.product_size_id WHERE p.qty>0 ORDER BY s.name_ln");
// if(!empty($product_sizes)) {
// 	$GLOBALS['_product_sizes'] = $product_sizes;
// }

// $price_ranges = $mm->SelAssoc("SELECT id, from_amount, to_amount FROM product_price_ranges ORDER BY to_amount asc");
// if(!empty($price_ranges)) {
// 	$GLOBALS['price_ranges'] = $price_ranges;
// }

// $top_news = $mm->SelAssoc("SELECT id, name_ln title, short_desc_ln text, url, date, name_bg FROM news WHERE hidden=0 AND deleted=0 AND is_hot=0 ORDER BY created_at DESC LIMIT 3");
// if(!empty($top_news)) {
// 	$GLOBALS['news'] = $top_news;
// }
// $hot_news = $mm->SelArr("SELECT id, name_ln title, short_desc_ln text, url, date, name_bg FROM news WHERE hidden=0 AND deleted=0 AND is_hot=1 ORDER BY created_at DESC LIMIT 1");
// if(!empty($hot_news)) {
// 	$GLOBALS['ribbon'] = $hot_news;
// }

// $outfits = $mm->SelAssoc("
// 					SELECT po.id, po.name_ln name, po.name_bg
// 					FROM	product_outfits po
// 				");
// if(!empty($outfits)) {
// 	$GLOBALS['outfits'] = $outfits;
// }

$PAGE_TITLE = text::get('main_title', -1000);
$GLOBALS['PAGE_KEYWORDS'] = text::get('keywords', -1000);
$GLOBALS['PAGE_DESCIPTION'] = text::get('description', -1000);
/*
$GLOBALS['counts'] = $mm->SelArr("
				SELECT COUNT(*) wine_cnt
						,(SELECT COUNT(*) FROM producers WHERE hidden=0) producer_cnt
						,(SELECT COUNT(*) FROM countries) country_cnt
				FROM	products
				WHERE	deleted=0
						AND
						hidden=0
						AND
						type_id={$_sys_product_types[0]}
");
*/

switch($_SESSION['ln']) {
	case 1:
		$lang_url = 'en/';
		break;
	case 3:
		$lang_url = 'ro/';
		break;
	default:
		$lang_url = '';
		break;
}

$GLOBALS['scriptname'] = basename($_SERVER["SCRIPT_FILENAME"],'.php');

header('Content-Type: text/html; charset=utf8'); 
function __autoload($class_name) {
	global $_config;
    require_once "{$_config['root_dir']}/managers/$class_name" . '.php';
}
?>