<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Превозно средство';
$PAGE_ID = -5;
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

        $FILTER = quotes_filter($FILTER, 'name');

    }
} else {
    $FILTER = getFilter($_GET);
    $FILTER['tab'] = nvl($FILTER['tab'], 1);
}

if(!in_array(nvl($FILTER['mode']),array('hide','unhide','edit','save'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
    case 'hide':
        $mm->Query("UPDATE related_place SET is_deleted=1 WHERE id={$FILTER['id']}");
        redirect($FILTER['back_url']);
        break;
    case 'unhide':
        $mm->Query("UPDATE related_place SET is_deleted=0 WHERE id={$FILTER['id']}");
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
    global $mm,$PAGE_TITLE;

    get_list($FILTER);

    $tpl = new Template_Lite();
    $tpl->assign_by_ref('FILTER',$FILTER);
    $tpl->display('related_places.tpl');
}


function edit(&$FILTER,$errs = array()){
    global $mm,$PAGE_TITLE;


    get_list($FILTER);

    $FILTER['id']=intval($FILTER['id']);


    if(empty($errs) && $FILTER['id']!=-1) {

        if($FILTER['tab']==1) {
            $res = $mm->SelAssoc("	SELECT id, name, type_id, area_id, link, text
                                    FROM related_place
                                    WHERE id={$FILTER['id']}
                                ");

            if($res!=false) {
                $FILTER['item'] = $res;
                $FILTER['item'] = $FILTER['item'][$FILTER['id']];
            } else {
               redirect('related_places.php');
            }
          } else {
            $FILTER['picture'] = $mm->SelOne("SELECT picture_id FROM related_place WHERE id={$FILTER['id']}");

          }
    }


    $FILTER['types'] = $mm->SelAssoc("SELECT id, name FROM type WHERE is_deleted = 0");
    $FILTER['areas'] = $mm->SelAssoc("SELECT id, name_bg as name FROM area WHERE is_deleted = 0");



    $tpl = new Template_Lite();
    if(!empty($errs)) {
        $cache .= "|errs";
        $tpl->assign_by_ref('errs', $errs);
    }



    $cache .= "|edit";

    $tpl->assign_by_ref('FILTER', $FILTER);
    $tpl->display('related_places.tpl', $cache);
}


function insertUpdate(&$FILTER) {
    global $mm;

    if(empty($FILTER['name'])) $errs['name'] = 'Полето е задължително.';
    if(empty($FILTER['type'])) $errs['type'] = 'Полето е задължително.';
    if(empty($FILTER['area'])) $errs['area'] = 'Полето е задължително.';

    if(!empty($errs)) {
        $FILTER['mode'] = 'edit';
        edit($FILTER, $errs);
        return;
    }



    $FILTER['item']['name'] = $FILTER['name'];
    $FILTER['item']['type_id'] = $FILTER['type'];
    $FILTER['item']['area_id'] = $FILTER['area'];
    $FILTER['item']['text'] = $FILTER['text'];
    $FILTER['item']['link'] = $FILTER['link'];

    if($FILTER['id']>0) {

        $res = $mm->AutoExecute('related_place', $FILTER['item'], 2, "id={$FILTER['id']}", true);

    } else {

        $res = $mm->AutoExecute('related_place', $FILTER['item'], 1, false);

    }

    if(stristr($res,'duplicate entry')) {
        $errs['global'] = 'Вече има номенклатура с такова име!';
        $FILTER['mode'] = 'edit';
        edit($FILTER, $errs);
    } else {
        $redirect_url = replace_param_in_url(array('mode'=>'edit','id'=>$FILTER['id'],'tab'=>$FILTER['tab'],'back_url'=>''));
        $redirect_url .= "&back_url=" . rawurlencode($FILTER['back_url']);
        $FILTER['mode'] = "edit";
        $FILTER['item'] = NULL;

        edit($FILTER);
        redirect($redirect_url);
    }
}

function get_list(&$FILTER) {
    global $mm,$PAGE_TITLE;

    $FILTER = intval_filter($FILTER, 'id, sort_id');

    $uri = $srch_where = '';

    if(nvl($FILTER['search'])) {
        $srch_where = "\nWHERE ( model like '%{$FILTER['search']}%')";
        $uri="mode=search&search={$FILTER['search']}";
    }

    if(!isset($FILTER['sort_id'])) $FILTER['sort_id'] = 0;
    $sort_id = $FILTER['sort_id'];
    $order_by = abs($sort_id);
    $order_by .= ($sort_id>0?' ASC':' DESC');



    $sql = "SELECT 	id, name, picture_id
			FROM related_place
			$srch_where
			ORDER BY id";

    $related_places = $mm->SelAssoc($sql,true,10,4,$uri,3);


    $FILTER['list'] = $related_places;
    $FILTER['pager'] = $mm->pager;
}

?>
