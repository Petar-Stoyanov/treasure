<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Превозно средство';
$PAGE_ID = -7;
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
        $mm->Query("UPDATE treasure SET is_deleted=1 WHERE id={$FILTER['id']}");
        redirect($FILTER['back_url']);
        break;
    case 'unhide':
        $mm->Query("UPDATE treasure SET is_deleted=0 WHERE id={$FILTER['id']}");
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
    $tpl->display('object.tpl');
}


function edit(&$FILTER,$errs = array()){
    global $mm,$PAGE_TITLE;


    get_list($FILTER);

    $FILTER['id']=intval($FILTER['id']);


    if(empty($errs) && $FILTER['id']!=-1) {

        if($FILTER['tab']==1) {
            $res = $mm->SelAssoc("	SELECT id, name, type_id, area_id, video_url as video, description, area_id, address,
                                    X(o.location) as location_x, Y(o.location) as location_y, working_time, description,
                                    first_rel_place_id, second_rel_place_id, sorting_weight
                                    FROM treasure o
                                    WHERE id={$FILTER['id']}
                                ");

            if($res!=false) {
                $FILTER['item'] = $res;
                $FILTER['item'] = $FILTER['item'][$FILTER['id']];
            } else {
               redirect('object.php');
            }
          } else {
            $FILTER['main_picture'] = $mm->SelOne("SELECT main_pic_id FROM treasure WHERE id={$FILTER['id']}");

            $FILTER['pictures'] = $mm->SelAssoc("SELECT picture_id FROM treasure_have_picture WHERE treasure_id={$FILTER['id']}");

          }
    }


    $FILTER['types'] = $mm->SelAssoc("SELECT id, name FROM type WHERE is_deleted = 0");
    $FILTER['areas'] = $mm->SelAssoc("SELECT id, name_bg as name FROM area WHERE is_deleted = 0");
    $FILTER['historical_periods'] = $mm->SelAssoc("SELECT id, name FROM historical_period WHERE is_deleted = 0");
    $FILTER['related_places'] = $mm->SelAssoc("SELECT id, name FROM related_place WHERE is_deleted = 0");


    $tpl = new Template_Lite();
    if(!empty($errs)) {
        $cache .= "|errs";
        $tpl->assign_by_ref('errs', $errs);
    }



    $cache .= "|edit";

    $tpl->assign_by_ref('FILTER', $FILTER);
    $tpl->display('object.tpl', $cache);
}


function insertUpdate(&$FILTER) {
    global $mm;



    if(empty($FILTER['name'])) $errs['name'] = 'Полето е задължително.';
    if(empty($FILTER['type'])) $errs['type'] = 'Полето е задължително.';
    if(empty($FILTER['area'])) $errs['area'] = 'Полето е задължително.';

    if(empty($FILTER['first_rel_place_id']) || is_null($FILTER['first_rel_place_id']) || $FILTER['first_rel_place_id'] == "") $FILTER['first_rel_place_id'] = NULL;
    if(empty($FILTER['second_rel_place_id']) || is_null($FILTER['second_rel_place_id']) || $FILTER['second_rel_place_id'] == "") $FILTER['second_rel_place_id'] = NULL;


    if(!empty($errs)) {
        $FILTER['mode'] = 'edit';
        edit($FILTER, $errs);
        return;
    }



    $name = $FILTER['name'];
    $address = $FILTER['address'];
    $area = $FILTER['area'];
    $type = $FILTER['type'];
    $location_x = $FILTER['location_x'];
    $location_y = $FILTER['location_y'];
    $description = $FILTER['text'];
    $historical_period = $FILTER['hist_period_id'];
//        var_dump($FILTER);
//        die();
    $first_rel_place_id = $FILTER['first_rel_place_id'];
    $second_rel_place_id = $FILTER['second_rel_place_id'];
    $video = $FILTER['video'];
    $working_time = $FILTER['working_time'];
    $sorting_weight = $FILTER['sorting_weight'];
   if($FILTER['id']>0) {
        $id = $FILTER['id'];
//        $res = $mm->AutoExecute('area', $FILTER['item'], 2, "id={$FILTER['id']}", true);

          $res = $mm->Query("UPDATE treasure SET name='{$name}', description='{$description}', location=GeomFromText('POINT({$location_x} {$location_y})'),
                            area_id={$area}, type_id={$type}, working_time='{$working_time}', hist_period_id={$historical_period},
                             video_url='{$video}', first_rel_place_id={$first_rel_place_id}, second_rel_place_id={$second_rel_place_id}, sorting_weight={$sorting_weight} WHERE id={$id}");
    } else {

    if(is_null($first_rel_place_id) || is_null($second_rel_place_id)){
    $res = $mm->Query("INSERT INTO treasure(name, description, address, area_id, location, working_time, type_id, hist_period_id, video_url, sorting_weight)
          VALUES('{$name}', '{$description}', '{$address}',{$area}, GeomFromText('POINT({$location_x} {$location_y})'), '{$working_time}', {$type}, {$historical_period}, '{$video}', {$sorting_weight})");
    }else {
    $res = $mm->Query("INSERT INTO treasure(name, description, address, area_id, location, working_time, type_id, hist_period_id, video_url, first_rel_place_id, second_rel_place_id, sorting_weight)
              VALUES('{$name}', '{$description}', '{$address}',{$area}, GeomFromText('POINT({$location_x} {$location_y})'), '{$working_time}', {$type}, {$historical_period}, '{$video}', {$first_rel_place_id}, {$second_rel_place_id}, {$sorting_weight})");
    }

//        $res = $mm->AutoExecute('area', $FILTER['item'], 1, false);
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



    $sql = "SELECT 	id, name, sorting_weight, is_deleted as hidden
			FROM treasure
			$srch_where
			ORDER BY sorting_weight ASC";

    $treasure = $mm->SelAssoc($sql,true,10,4,$uri,3);


    $FILTER['list'] = $treasure;
    $FILTER['pager'] = $mm->pager;
}

?>
