<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Настройки на административни потребители';
$PAGE_ID = -4;

$side_menu = array(
	array('href' => 'users.php', 'title' => 'Потребители на сайта'),
	array('href' => 'adminusers.php', 'title' => 'Администратори', 'active' => true),
	array('href' => 'nom_user_types.php', 'title' => 'Типове потребители'),
);

if($_POST) {
	$FILTER = getFilter($_POST);
	$FILTER['mode'] = 'save';	
	$FILTER = quotes_filter($FILTER, 'FirstName, MiddleName, LastName, description');
	$FILTER['id'] = intval($FILTER['id']);
} else {
	$FILTER = getFilter($_GET);
	$FILTER['id'] = intval($FILTER['id']);
}

if(!in_array(nvl($FILTER['mode']),array('edit','save','del'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
	case 'del':
		if($FILTER['id']==$_SESSION['user']['id']) redirect('adminusers.php');
		$mm->Query("UPDATE adminusers SET deleted=1 WHERE id={$FILTER['id']}");
		redirect('adminusers.php');
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
	global $mm;
	
	$sql = "SELECT 	id, email, name
			FROM 	adminusers
			WHERE 	deleted=0
			ORDER BY id";
	
	$FILTER['adminusers'] = $mm->SelAssoc($sql,true,10,4,$uri);
	$FILTER['pager'] = $mm->pager;
	
	$tpl = new Template_Lite();
	$tpl->assign_by_ref('FILTER',$FILTER);
	
	$tpl->display('adminusers.tpl');
}

function edit(&$FILTER,$errs = array()){
	global $mm,$PAGE_TITLE,$proceedings;
	
	$sql = "SELECT 	id, email, name
			FROM 	adminusers
			WHERE 	deleted=0
			ORDER BY id";
	
	$FILTER['adminusers'] = $mm->SelAssoc($sql,true,10,4,$uri);
	$FILTER['pager'] = $mm->pager;
	
	$FILTER['id']=intval($FILTER['id']);
	if($FILTER['id']>0) {
		$res = $mm->SelAssoc("	SELECT 	id, name, email
								FROM adminusers
								WHERE id={$FILTER['id']}
							");
		if($res!=false) {
			$res = $res[$FILTER['id']];
			$FILTER = array_merge($res, $FILTER);
		} else {
			redirect('adminusers.php');
		}
	} 
	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	
	$cache .= "|edit";
	$tpl->assign_by_ref('FILTER', $FILTER);
	$tpl->display('adminusers.tpl', $cache);
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
		edit($FILTER, $errs);
		return;
	}
	
	$data['email']=$FILTER['email'];
	$data['name']=$FILTER['name'];
	
	if($FILTER['id']>0) {
		if(!empty($FILTER['pass'])) $data['password']=$FILTER['pass'];
		$mm->AutoExecute('adminusers', $data, 2, "id='{$FILTER['id']}'");
	} else {
		$data['password']=$FILTER['pass'];
		$mm->AutoExecute('adminusers', $data, 1);
	}
	redirect("adminusers.php");
}
?>