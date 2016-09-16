<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Настройки на потребители';
$PAGE_ID = -4;

$side_menu = array(
	array('href' => 'users.php', 'title' => 'Потребители на сайта', 'active' => true),
	array('href' => 'adminusers.php', 'title' => 'Администратори'),
	array('href' => 'nom_user_types.php', 'title' => 'Типове потребители'),
);

if($_POST) {
	$FILTER = getFilter($_POST);
	if(isset($_POST['search'])) {
		$get = getFilter($_GET);
		if(is_array($get)) $FILTER = array_merge($FILTER,$get);
		
		$FILTER = quotes_filter($FILTER, 'search');
	} else {
		$FILTER['mode'] = 'save';	
		$FILTER = quotes_filter($FILTER, 'fname, lname, pass, pass2, membercard_no');
		$FILTER['id'] = intval($FILTER['id']);
	}
} else {
	$FILTER = getFilter($_GET);
	$FILTER['id'] = intval($FILTER['id']);
}

if(!in_array(nvl($FILTER['mode']),array('edit','save','del','undel'))) $FILTER['mode']='';


switch ($FILTER['mode']) {
	case 'del':
		//if($FILTER['id']==$_SESSION['user']['id']) redirect('users.php');
		$mm->Query("UPDATE users SET deleted=1 WHERE id={$FILTER['id']}");
		$mm->Query("DELETE FROM session WHERE user_id={$FILTER['id']}");
		redirect('users.php');
		break;
	case 'undel':
		$mm->Query("UPDATE users SET deleted=0 WHERE id={$FILTER['id']}");
		redirect('users.php');
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
	
	$uri = $srch_where = '';
	
	if(nvl($FILTER['search'])) {
		$srch_where .= "\nAND ( fname like '%{$FILTER['search']}%' OR lname like '%{$FILTER['search']}%' OR email like '%{$FILTER['search']}%' )";
		$uri.="mode=search&search={$FILTER['search']}";
	}
	
	$sql = "SELECT 	id, email, CONCAT(fname,' ', lname) AS name, user_type_id, deleted
			FROM 	users
			WHERE 	1
			$srch_where
			ORDER BY deleted ASC, id";
	
	$FILTER['users'] = $mm->SelAssoc($sql,true,10,4,$uri);
	$FILTER['pager'] = $mm->pager;
	$user_types = $mm->SelAssoc("SELECT id, name_bg name FROM user_types");
	
	$tpl = new Template_Lite();
	$tpl->assign_by_ref('FILTER',$FILTER);
	$tpl->assign_by_ref('user_types',$user_types);
	
	$tpl->display('users.tpl');
}

function edit(&$FILTER,$errs = array()){
	global $mm,$PAGE_TITLE;
	$cache = '';
	$FILTER['id']=intval($FILTER['id']);
	if($FILTER['id']>0) {
		$res = $mm->SelAssoc("	SELECT 	id, fname, lname, email, photo, last_ip, created_at, user_type_id, membercard_no
								FROM users
								WHERE id={$FILTER['id']}
							");
		if($res!=false) {
			$res = $res[$FILTER['id']];
			$FILTER = array_merge($res, $FILTER);
		} else {
			redirect('users.php');
		}
		
		$FILTER['addresses'] = $mm->SelAssoc("SELECT ua.id, ua.user_id, ua.street, ua.city, ua.zip, ua.phone, ua.prime, ac.name_bg countryname FROM user_addresses ua LEFT JOIN allcountries ac ON ac.id=ua.country WHERE ua.deleted=0 AND ua.user_id={$FILTER['id']}");
		
		$sql = "SELECT 	id, status, total, status, created_at, payment_method_id, paid
			FROM orders WHERE user_id={$FILTER['id']} AND status<>0 ORDER BY created_at DESC";
		
		$uri="mode=edit&id={$FILTER['id']}";
		$FILTER['orders'] = $mm->SelAssoc($sql,true,50,4,$uri,3);
		$FILTER['pager'] = $mm->pager;
	} 
	$FILTER['user_types'] = $mm->SelAssoc("SELECT id, name_bg name FROM user_types ORDER BY turnover");
	
	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	
	$cache .= "|edit";
	$tpl->assign_by_ref('FILTER', $FILTER);
	$tpl->display('users.tpl', $cache);
}


function insertUpdate(&$FILTER) {
	global $mm;
	
	if(empty($FILTER['fname'])) $errs['fname'] = 'Полето е задължително.';
	if(empty($FILTER['lname'])) $errs['lname'] = 'Полето е задължително.';
	if(empty($FILTER['email'])) {
		$errs['email'] = 'Полето е задължително';
	} else {
		$regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,4}$/i";
		if ( !preg_match($regexp, $FILTER['email']) ) {
			$errs['email'] = 'Невалиден email адрес.';
		} else {
			$sql_where = ($FILTER['id']>0?" AND id<>{$FILTER['id']}":'');
			$res = $mm->SelOne("SELECT id FROM users WHERE email='{$FILTER['email']}'{$sql_where}");
			if(!empty($res)) $errs['email'] = 'Този email вече е регистриран в системата.';
		}
	}
	
	if($FILTER['id']<=0 && !empty($FILTER['pass'])) {
		if($FILTER['pass']!=$FILTER['pass2']) {
			$errs['pass'] = 'Паролите не съвпадат.';
			$errs['pass2'] = 'Паролите не съвпадат.';
		}
	}
	
	if(!empty($errs)) {
		$FILTER['mode']='edit';
		edit($FILTER, $errs);
		return;
	}
	
	$data['email']=$FILTER['email'];
	$data['fname']=$FILTER['fname'];
	$data['lname']=$FILTER['lname'];
	$data['passwd']=$FILTER['pass'];
	$data['user_type_id']=nvl($FILTER['user_type_id'],'NULL');
	$data['membercard_no']=($FILTER['membercard_no']?"'{$FILTER['membercard_no']}'":'NULL');
	
	if($FILTER['id']>0) {
		// type_set_at: set the date only when new type is set
		$mm->Query("UPDATE users 
					SET email='{$data['email']}', fname='{$data['fname']}', lname='{$data['lname']}', passwd='{$data['passwd']}',
						membercard_no={$data['membercard_no']},
						type_set_at=IF(ISNULL({$data['user_type_id']}), NULL, IF(user_type_id={$data['user_type_id']}, type_set_at, CURDATE())),
						user_type_id={$data['user_type_id']}
					WHERE id={$FILTER['id']}");
	} else {
		$mm->AutoExecute('users', $data, 1);
		$FILTER['id'] = $mm->GetId();
	}
	redirect("users.php?mode=edit&id={$FILTER['id']}");
}
?>