<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Превозно средство';
$PAGE_ID = -11;
require_once('submenu.php');
$sub_menu = array(
    array('href' => 'vehicle.php', 'title' => 'Cars', 'selected' => ($PAGE_ID==-11)),
    array('href' => 'nom_vehicle_class.php', 'title' => 'Vehicle Class', 'selected' => ($PAGE_ID==-6)),
    array('href' => 'nom_vehicle_extras.php', 'title' => 'Vehicle Features', 'selected' => ($PAGE_ID==-7)),
    array('href' => 'nom_vehicle_types.php', 'title' => 'Vehicle Type', 'selected' => ($PAGE_ID==-8)),
    array('href' => 'nom_vehicle_additional_extras.php', 'title' => 'Vehicle Extras', 'selected' => ($PAGE_ID==-13)),
);


if($_POST) {
    $FILTER = getFilter($_POST);
    if(isset($_POST['search'])) {
        $get = getFilter($_GET);
        if(is_array($get)) $FILTER = array_merge($FILTER,$get);

        $FILTER = quotes_filter($FILTER, 'search');
    } else {
        $FILTER['mode'] = 'save';
        $FILTER['success'] = "false";
        $FILTER = quotes_filter($FILTER, 'model, brand, description_bg, description_en, description_ru, description_de, transmission_bg, transmission_en,
        , transmission_ru, transmission_de, sortingWeight,
//         seo_url_bg,
         seo_url_en,
//         seo_url_ru,
//         seo_url_de,

         seo_description_bg
        , seo_description_en, seo_description_ru, seo_description_de, seo_title_bg, seo_title_en, seo_title_ru, seo_title_de, is_transfer');

        $FILTER['price_1'] = floatval($FILTER['price_1']);
        $FILTER['price_2'] = floatval($FILTER['price_2']);
        $FILTER['price_3'] = floatval($FILTER['price_3']);
        $FILTER['price_4'] = floatval($FILTER['price_4']);
        $FILTER['promo_price'] = floatval($FILTER['promo_price']);

        $FILTER['is_transfer'] = intval($FILTER['is_transfer']);

//        $FILTER['pricePerDay'] = floatval($FILTER['pricePerDay']);
//        $FILTER['pricePerDayWithoutDriver'] = floatval($FILTER['pricePerDayWithoutDriver']);
        $FILTER['pricePerDay'] = floatval(0);
        $FILTER['pricePerDayWithoutDriver'] = floatval(0);
        $FILTER['pricePerKm'] = floatval($FILTER['pricePerKm']);

        $FILTER['cdw'] = floatval($FILTER['cdw']);
        $FILTER['cdw2'] = floatval($FILTER['cdw2']);
        $FILTER['pai'] = floatval($FILTER['pai']);
        $FILTER['gat'] = floatval($FILTER['gat']);
        $FILTER['deposit'] = floatval($FILTER['deposit']);

        $FILTER['discount'] = intval($FILTER['discount']);
        $FILTER['id'] = intval($FILTER['id']);
        $FILTER['use_for_id'] = intval(5);
        $FILTER['sortingWeight'] = floatval($FILTER['sortingWeight']);
        $FILTER['includedKm'] = floatval($FILTER['includedKm']);
    }
} else {
    $FILTER = getFilter($_GET);
    $FILTER['tab'] = nvl($FILTER['tab'], 1);
}

if(!in_array(nvl($FILTER['mode']),array('hide','unhide','edit','save'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
    case 'hide':
        $mm->Query("UPDATE vehicle SET hidden=1 WHERE id={$FILTER['id']}");
        redirect($FILTER['back_url']);
        break;
    case 'unhide':
        $mm->Query("UPDATE vehicle SET hidden=0 WHERE id={$FILTER['id']}");
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
    $tpl->display('vehicle.tpl');
}


function edit(&$FILTER,$errs = array()){
    global $mm,$PAGE_TITLE;


    get_list($FILTER);

    $FILTER['id']=intval($FILTER['id']);


    if(empty($errs) && $FILTER['id']!=-1) {

        if($FILTER['tab']==1) {
            $res = $mm->SelAssoc("	SELECT id, brand, model, description_bg, description_en, description_ru, description_de,use_for_id, includedKm,
                                    transmission_bg, transmission_en, transmission_ru, transmission_de, vehicle_type_id,
                                    is_promo, withDriver, sortingWeight,
                                    vehicle_class_id, seo_url_en, seo_description_bg, seo_description_en, seo_description_ru, seo_description_de,
                                    seo_title_bg, seo_title_en, seo_title_ru, seo_title_de, price_id, is_transfer
                                    FROM vehicle
                                    WHERE id={$FILTER['id']}
                                ");
            $price = $mm->SelAssoc("SELECT id as p_id, price_1, price_2, price_3, price_4,
            promo_price, discount, pai, gat, cdw, cdw2, pricePerDay, pricePerDayWithoutDriver, pricePerKm, deposit
                                    FROM vehicle_price
                                    WHERE id = {$res[$FILTER['id']]['price_id']}");

            $extras = $mm->SelAssoc("SELECT vehicle_have_extras.extra_id, vehicle_extras.vehicle_extras_group_id FROM vehicle_have_extras
                                    LEFT JOIN vehicle_extras ON vehicle_have_extras.extra_id = vehicle_extras.id
                                    WHERE vehicle_have_extras.vehicle_id = {$FILTER['id']}");

            $extrasArr = array();

            if(isset($extras) && count($extras) > 0 && $extras != false){

                foreach($extras as $val) {
                    if($val['vehicle_extras_group_id'] != 1 && $val['vehicle_extras_group_id'] != 3){
                        array_push($extrasArr, $val['extra_id']);
                    }else if($val['vehicle_extras_group_id'] == 1){
                        $FILTER['vars']['human_capacity_id'] = $val['extra_id'];
                    }else if($val['vehicle_extras_group_id'] == 3){
                        $FILTER['vars']['number_of_doors_id'] = $val['extra_id'];
                    }
                }
            }


            if($res!=false) {
               $FILTER['item'] =  array_merge($res[$FILTER['id']], $price[$res[$FILTER['id']]['price_id']]);
               $FILTER['item']['extras'] = $extrasArr;
               $FILTER['item']['human_capacity_id'] = $FILTER['vars']['human_capacity_id'];
               $FILTER['item']['number_of_doors_id'] = $FILTER['vars']['number_of_doors_id'];
            } else {
               redirect('vehicle.php');
            }
          } else {
            $FILTER['pictures'] = $mm->SelAssoc("SELECT photo_id FROM vehicle_have_photos WHERE vehicle_id={$FILTER['id']}");
          }
    }



    $vehicle_type = $mm->SelAssoc("SELECT id, name_en FROM vehicle_type WHERE hidden = 0");
    $FILTER['vars']['vehicle_types'] = $vehicle_type;

    $vehicle_extras = $mm->SelAssoc("SELECT id, name_en FROM vehicle_extras WHERE hidden = 0 AND vehicle_extras_group_id != 1 AND vehicle_extras_group_id != 3");
    $FILTER['vars']['vehicle_extras'] = $vehicle_extras;

    $human_capacity = $mm->SelAssoc("SELECT id, name_en FROM vehicle_extras WHERE hidden = 0 AND vehicle_extras_group_id = 1");
    $FILTER['vars']['human_capacity'] = $human_capacity;

    $number_of_doors = $mm->SelAssoc("SELECT id, name_en FROM vehicle_extras WHERE hidden = 0 AND vehicle_extras_group_id = 3");
    $FILTER['vars']['number_of_doors'] = $number_of_doors;

    $vehicles_use_for = $mm->SelAssoc("SELECT id, name FROM vehicle_use_for");
    $FILTER['vars']['vehicles_use_for'] = $vehicles_use_for;

    $vehicle_class = $mm->SelAssoc("SELECT id, name_en FROM vehicle_class WHERE hidden = 0");
    $FILTER['vars']['vehicle_class'] = $vehicle_class;


    $tpl = new Template_Lite();
    if(!empty($errs)) {
        $cache .= "|errs";
        $tpl->assign_by_ref('errs', $errs);
    }



    $cache .= "|edit";

    $tpl->assign_by_ref('FILTER', $FILTER);
    $tpl->display('vehicle.tpl', $cache);
}


function insertUpdate(&$FILTER) {
    global $mm;

    if(empty($FILTER['brand'])) $errs['brand'] = 'Полето е задължително.';
    if(empty($FILTER['model'])) $errs['model'] = 'Полето е задължително.';
    if(empty($FILTER['sortingWeight'])) $errs['sortingWeight'] = 'Полето е задължително.';
//    if(empty($FILTER['use_for_id'])) $errs['use_for_id'] = 'Полето е задължително.';

    if(empty($FILTER['price_1'])) $errs['price_1'] = 'Полето е задължително.';
    if(empty($FILTER['price_2'])) $errs['price_2'] = 'Полето е задължително.';
    if(empty($FILTER['price_3'])) $errs['price_3'] = 'Полето е задължително.';
    if(empty($FILTER['price_4'])) $errs['price_4'] = 'Полето е задължително.';
    if(empty($FILTER['promo_price'])) $errs['promo_price'] = 'Полето е задължително.';
//    if(empty($FILTER['pricePerDay'])) $errs['pricePerDay'] = 'Полето е задължително.';
//    if(empty($FILTER['pricePerDayWithoutDriver'])) $errs['pricePerDayWithoutDriver'] = 'Полето е задължително.';
    if(empty($FILTER['pricePerKm'])) $FILTER['pricePerKm'] = 0;//$errs['pricePerKm'] = 'Полето е задължително.';
    if(empty($FILTER['cdw'])) $errs['cdw'] = 'Полето е задължително.';
    if(empty($FILTER['cdw2'])) $errs['cdw2'] = 'Полето е задължително.';
    if(empty($FILTER['pai'])) $errs['pai'] = 'Полето е задължително.';
    if(empty($FILTER['gat'])) $errs['gat'] = 'Полето е задължително.';
    if(empty($FILTER['deposit'])) $errs['deposit'] = 'Полето е задължително.';

    if(is_null($FILTER['is_promo']) && empty($FILTER['withDriver']) || is_null($FILTER['is_promo'])) {
        $FILTER['item']['is_promo'] = 0;
    }else {
        $FILTER['item']['is_promo'] = $FILTER['is_promo'];
    }

    if(is_null($FILTER['is_transfer'])) {
        $FILTER['item']['is_transfer'] = false;
    }else {
        $FILTER['item']['is_transfer'] = $FILTER['is_transfer'];
    }


    if(is_null($FILTER['withDriver']) || empty($FILTER['withDriver']) || $FILTER['withDriver'] = "") {
        $FILTER['item']['withDriver'] = 0;
    }else {
        $FILTER['item']['withDriver'] = $FILTER['withDriver'];
    }



    if(!empty($errs)) {
        $FILTER['mode'] = 'edit';
        edit($FILTER, $errs);
        return;
    }



    $FILTER['item']['brand'] = $FILTER['brand'];
    $FILTER['item']['model'] = $FILTER['model'];

    $FILTER['item']['sortingWeight'] = $FILTER['sortingWeight'];
    $FILTER['item']['includedKm'] = $FILTER['includedKm'];

    $FILTER['item']['use_for_id'] = 5;

    $FILTER['item']['description_bg'] = $FILTER['description_bg'];
    $FILTER['item']['description_en'] = $FILTER['description_en'];
    $FILTER['item']['description_ru'] = $FILTER['description_ru'];
    $FILTER['item']['description_de'] = $FILTER['description_de'];


    if(strcmp($FILTER['transmission'], "Automatic") == 0){
        $FILTER['item']['transmission_bg'] = $FILTER['transmission'];
        $FILTER['item']['transmission_en'] = $FILTER['transmission'];
        $FILTER['item']['transmission_ru'] = $FILTER['transmission'];
        $FILTER['item']['transmission_de'] = $FILTER['transmission'];
    }else{
        $FILTER['item']['transmission_bg'] = $FILTER['transmission'];
        $FILTER['item']['transmission_en'] = $FILTER['transmission'];
        $FILTER['item']['transmission_ru'] = $FILTER['transmission'];
        $FILTER['item']['transmission_de'] = $FILTER['transmission'];
    }

    $vehicle_classification = $mm->SelOne("SELECT name_en FROM vehicle_type WHERE id={$FILTER['vehicle_types']}");

    $FILTER['item']['classification_bg'] = $vehicle_classification;
    $FILTER['item']['classification_en'] = $vehicle_classification;
    $FILTER['item']['classification_ru'] = $vehicle_classification;
    $FILTER['item']['classification_de'] = $vehicle_classification;

    $FILTER['item']['vehicle_type_id'] = $FILTER['vehicle_types'];
    $FILTER['item']['vehicle_class_id'] = $FILTER['vehicle_class'];

//    $FILTER['item']['seo_url_bg'] = $FILTER['seo_url_bg'];
    $FILTER['item']['seo_url_en'] = $FILTER['seo_url_en'];
//    $FILTER['item']['seo_url_ru'] = $FILTER['seo_url_ru'];
//    $FILTER['item']['seo_url_de'] = $FILTER['seo_url_de'];

    $FILTER['item']['seo_description_bg'] = $FILTER['seo_description_bg'];
    $FILTER['item']['seo_description_en'] = $FILTER['seo_description_en'];
    $FILTER['item']['seo_description_ru'] = $FILTER['seo_description_ru'];
    $FILTER['item']['seo_description_de'] = $FILTER['seo_description_de'];

    $FILTER['item']['seo_title_bg'] = $FILTER['seo_title_bg'];
    $FILTER['item']['seo_title_en'] = $FILTER['seo_title_en'];
    $FILTER['item']['seo_title_ru'] = $FILTER['seo_title_ru'];
    $FILTER['item']['seo_title_de'] = $FILTER['seo_title_de'];

    $FILTER['item']['is_transfer'] = $FILTER['is_transfer'];

    $FILTER['price']['price_1'] = $FILTER['price_1'];
    $FILTER['price']['price_2'] = $FILTER['price_2'];
    $FILTER['price']['price_3'] = $FILTER['price_3'];
    $FILTER['price']['price_4'] = $FILTER['price_4'];

    $FILTER['price']['promo_price'] = $FILTER['promo_price'] ;
    $FILTER['price']['discount'] = $FILTER['discount'];


//    $FILTER['price']['pricePerDayWithoutDriver'] = $FILTER['pricePerDayWithoutDriver'];
//    $FILTER['price']['pricePerDay'] = $FILTER['pricePerDay'];

    $FILTER['price']['pricePerKm'] = $FILTER['pricePerKm'];

    $FILTER['price']['cdw'] = $FILTER['cdw'];
    $FILTER['price']['cdw2'] = $FILTER['cdw2'];

    $FILTER['price']['pai'] = $FILTER['pai'];
    $FILTER['price']['gat'] = $FILTER['gat'];

    $FILTER['price']['deposit'] = $FILTER['deposit'];


    array_push($FILTER['vehicle_extras'], $FILTER['number_of_doors']);
    array_push($FILTER['vehicle_extras'], $FILTER['human_capacity']);

    $FILTER['extras']['vehicle_extras'] = $FILTER['vehicle_extras'];



    if($FILTER['id']>0) {

        $res = $mm->AutoExecute('vehicle', $FILTER['item'], 2, "id={$FILTER['id']}", true);


        $price_id = $mm->SelOne("SELECT price_id FROM vehicle WHERE id={$FILTER['id']}");
        $price = $mm->AutoExecute('vehicle_price', $FILTER['price'], 2, "id={$price_id}", true);

        $mm->Query("DELETE FROM vehicle_have_extras WHERE vehicle_id={$FILTER['id']}");
        if($FILTER['extras']) {
            foreach($FILTER['extras']['vehicle_extras'] as $key => $value) {
                $FILTER['extra']['vehicle_id'] = $FILTER['id'];
                $FILTER['extra']['extra_id'] = $value;
                $res = $mm->AutoExecute('vehicle_have_extras', $FILTER['extra'], 1, true);
            }
        }
    } else {


        $price = $mm->AutoExecute('vehicle_price', $FILTER['price'], 1, false);
        $price_id = $mm->GetId();
        $FILTER['item']['price_id'] = $price_id;
        $res = $mm->AutoExecute('vehicle', $FILTER['item'], 1, false);

        $vehicle_id = $mm->GetId();

        if($FILTER['extras']) {
            if(count($FILTER['extras']['vehicle_extras']) > 0){
                foreach($FILTER['extras']['vehicle_extras'] as $key => $value) {
                    $FILTER['extra']['vehicle_id'] = $vehicle_id;
                    $FILTER['extra']['extra_id'] = $value;
                    $res = $mm->AutoExecute('vehicle_have_extras', $FILTER['extra'], 1, false);
                }
            }
        }
    }

    if(stristr($res,'duplicate entry')) {
        $errs['global'] = 'Вече има номенклатура с такова име!';
        $FILTER['mode'] = 'edit';
        edit($FILTER, $errs);
    } else {
        $redirect_url = replace_param_in_url(array('mode'=>'edit','id'=>$FILTER['id'],'tab'=>$FILTER['tab'],'back_url'=>''));
        $redirect_url .= "&back_url=" . rawurlencode($FILTER['back_url']);
        $FILTER['success'] = "true";
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

    if(!isset($FILTER['sort_id'])) $FILTER['sort_id'] = 5;
    $sort_id = $FILTER['sort_id'];
    $order_by = abs($sort_id);
    $order_by .= ($sort_id>0?' ASC':' DESC');

    if($sort_id) $uri .= ($uri?'&':'')."sort_id=$sort_id";


    $sql = "SELECT 	id, brand, model, vehicle_type_id, sortingWeight, hidden
			FROM vehicle
			$srch_where
			ORDER BY $order_by";

    $vehicles = $mm->SelAssoc($sql,true,10,4,$uri,3);

    $listing_vehicles = array();
    foreach($vehicles as $vh) {

        $type = $mm->SelOne("SELECT name_en FROM vehicle_type WHERE id={$vh['vehicle_type_id']}");
        $photos = $mm->SelOne("SELECT photo_id FROM vehicle_have_photos WHERE vehicle_id={$vh['id']}");


        $vh['type'] = $type;
        $vh['photo'] = $photos;

        array_push($listing_vehicles, $vh);
    }

    $FILTER['list'] = $listing_vehicles;
    $FILTER['pager'] = $mm->pager;
}

?>
