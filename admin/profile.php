<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Профил';
$PAGE_ID = -3;


if($_POST) {
	$FILTER = getFilter($_POST);
	$FILTER['mode'] = 'save';	
	$FILTER = quotes_filter($FILTER, 'name,email,pass,pass2');
	$FILTER['email'] = trim($FILTER['email']);	
	$FILTER['pass'] = trim($FILTER['pass']);	
	$FILTER['pass2'] = trim($FILTER['pass2']);	
} else {
	$FILTER = getFilter($_GET);
}

if(!in_array(nvl($FILTER['mode']),array('save'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
	case 'save':
		insertUpdate($FILTER);
		break;
	default:
		show($FILTER);
		break;
}


function show(&$FILTER, $errs = array()) {
	global $mm;
	
	$res = $mm->SelAssoc("	SELECT 	id, name, email
								FROM adminusers
								WHERE id={$_SESSION['user']['id']}
							");
	if($res!=false) {
		$res = $res[$_SESSION['user']['id']];
		$FILTER = array_merge($res, $FILTER);
	}
	
	
	$tpl = new Template_Lite();
	
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	
	
	$tpl->assign_by_ref('FILTER',$FILTER);
	
	$tpl->display('profile.tpl', $_cache);
}

function insertUpdate(&$FILTER) {
	global $mm;
	
	if(empty($FILTER['name'])) $errs['name'] = 'Полето е задължително.';
	if(empty($FILTER['email'])) {
		$errs['email'] = 'Полето е задължително';
	} else {
		$regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,4}$/i";
		if ( !preg_match($regexp, $FILTER['email']) ) {
			$errs['email'] = 'Невалиден email адрес.';
		} else {
			$sql_where = " AND id<>{$_SESSION['user']['id']}";
			$res = $mm->SelOne("SELECT id FROM adminusers WHERE email='{$FILTER['email']}'{$sql_where}");
			if(!empty($res)) $errs['email'] = 'Този email вече е регистриран в системата.';
		}
	}
	
	if(!empty($FILTER['pass'])) {
		if($FILTER['pass']!=$FILTER['pass2']) {
			$errs['pass'] = 'Паролите не съвпадат.';
			$errs['pass2'] = 'Паролите не съвпадат.';
		}
	}
	
	if(!empty($errs)) {
		show($FILTER, $errs);
		return;
	}
	
	$data['email']=$FILTER['email'];
	$data['name']=$FILTER['name'];
	if(!empty($FILTER['pass'])) $data['password']=$FILTER['pass'];
	$mm->AutoExecute('adminusers', $data, 2, "id='{$_SESSION['user']['id']}'");
	
	redirect("profile.php");
}
?>