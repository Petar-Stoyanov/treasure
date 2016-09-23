<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Номенклатура тип на превозното средство';
$PAGE_ID = -4;
require_once('submenu.php');
$sub_menu = array(
//    array('href' => 'vehicle.php', 'title' => 'Cars', 'selected' => ($PAGE_ID==-11)),
//    array('href' => 'nom_vehicle_class.php', 'title' => 'Vehicle Class', 'selected' => ($PAGE_ID==-6)),
//    array('href' => 'nom_vehicle_extras.php', 'title' => 'Vehicle Features', 'selected' => ($PAGE_ID==-7)),
//    array('href' => 'nom_vehicle_types.php', 'title' => 'Vehicle Type', 'selected' => ($PAGE_ID==-8)),
//    array('href' => 'nom_vehicle_additional_extras.php', 'title' => 'Vehicle Extras', 'selected' => ($PAGE_ID==-13)),
);


if($_POST) {
    $FILTER = getFilter($_POST);
    if(isset($_POST['search'])) {
        $get = getFilter($_GET);
        if(is_array($get)) $FILTER = array_merge($FILTER,$get);

        $FILTER = quotes_filter($FILTER, 'search');
    } else {
        $FILTER['mode'] = 'save';
        $FILTER = quotes_filter($FILTER, 'name_bg, name_en, location_x, location_y');
        $FILTER['id'] = intval($FILTER['id']);
    }
} else {
    $FILTER = getFilter($_GET);
}

if(!in_array(nvl($FILTER['mode']),array('hide','unhide','edit','save'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
    case 'hide':
        $mm->Query("UPDATE area SET is_deleted=1 WHERE id={$FILTER['id']}");
        redirect($FILTER['back_url']);
        break;
    case 'unhide':
        $mm->Query("UPDATE area SET is_deleted=0 WHERE id={$FILTER['id']}");
        redirect($FILTER['back_url']);
        break;
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

    $tpl->display('nom_area.tpl');
}


function edit(&$FILTER,$errs = array()){
    global $mm,$PAGE_TITLE;

    get_list($FILTER);

    $FILTER['id']=intval($FILTER['id']);
    if(empty($errs) && $FILTER['id']!=-1) {
        $res = $mm->SelAssoc("	SELECT id, name_bg, name_en, X(a.location) as location_x, Y(a.location) as location_y
								FROM area as a
								WHERE id={$FILTER['id']}
							");
        if($res!=false) {
            $FILTER['item'] = $res[$FILTER['id']];
        } else {
            redirect('nom_area.php');
        }
    }
    $tpl = new Template_Lite();
    if(!empty($errs)) {
        $cache .= "|errs";
        $tpl->assign_by_ref('errs', $errs);
    }

    $cache .= "|edit";
    $tpl->assign_by_ref('FILTER', $FILTER);
    $tpl->assign_by_ref('errs', $errs);
    $tpl->display('nom_area.tpl', $cache);
}


function insertUpdate(&$FILTER) {
    global $mm;

   

    if(empty($FILTER['name_bg'])) $errs['name_bg'] = 'Полето е задължително.';
    if(empty($FILTER['name_en'])) $errs['name_en'] = 'Полето е задължително.';
    if(empty($FILTER['location_x'])) $errs['location_x'] = 'Полето е задължително.';
    if(empty($FILTER['location_y'])) $errs['location_y'] = 'Полето е задължително.';

    if(!empty($errs)) {
        $FILTER['mode'] = 'edit';
        edit($FILTER, $errs);
        return;
    }

    $name_bg = $FILTER['name_bg'];
    $name_en = $FILTER['name_en'];
    $location_x = $FILTER['location_x'];
    $location_y = $FILTER['location_y'];
    $FILTER['item']['location'] = 'GeomFromText("POINT({$location_x} {$location_y})")';

    if($FILTER['id']>0) {
        $id = $FILTER['id'];
//        $res = $mm->AutoExecute('area', $FILTER['item'], 2, "id={$FILTER['id']}", true);
          $res = $mm->Query("UPDATE area SET name_bg='{$name_bg}', name_en='{$name_en}', location=GeomFromText('POINT({$location_x} {$location_y})') WHERE id={$id}");
    } else {
          $res = $mm->Query("INSERT INTO area(name_bg, name_en, location) VALUES('{$name_bg}', '{$name_en}', GeomFromText('POINT({$location_x} {$location_y})'))");
//        $res = $mm->AutoExecute('area', $FILTER['item'], 1, false);
    }
    if(stristr($res,'duplicate entry')) {
        $errs['global'] = 'Вече има номенклатура с такова име!';
        $FILTER['mode'] = 'edit';
        edit($FILTER, $errs);
    } else {
        redirect($FILTER['back_url']);
    }
}

function get_list(&$FILTER) {
    global $mm,$PAGE_TITLE;

    $FILTER = intval_filter($FILTER, 'id, sort_id');

    $uri = $srch_where = '';

    if(nvl($FILTER['search'])) {
        $srch_where = "\nWHERE ( name_bg like '%{$FILTER['search']}%')";
        $uri="mode=search&search={$FILTER['search']}";
    }

    if(!isset($FILTER['sort_id'])) $FILTER['sort_id'] = 1;
    $sort_id = $FILTER['sort_id'];
    $order_by = abs($sort_id);
    $order_by .= ($sort_id>0?' ASC':' DESC');

    if($sort_id) $uri .= ($uri?'&':'')."sort_id=$sort_id";


    $sql = "SELECT 	id, name_bg, name_en, is_deleted as hidden
			FROM area
			$srch_where
			ORDER BY $order_by";

    $FILTER['list'] = $mm->SelAssoc($sql,true,10,4,$uri,3);
    $FILTER['pager'] = $mm->pager;
}

?>