<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");


if($_POST) {
	$FILTER = getFilter($_POST);
	$FILTER = quotes_filter($FILTER, 'email, pass');
} else {
	$FILTER = getFilter($_GET);
}

if($_POST) {
	do_login($FILTER);
} else {
	show_login($FILTER);
}

function show_login(&$FILTER, $errs = array()) {
	global $PAGE_TITLE;
	$PAGE_TITLE .= ' - РќР°С‡Р°Р»Рѕ';
	
	$tpl = new Template_Lite();
	
	if(!empty($errs)) {
		$tpl->assign_by_ref('errs', $errs);
	}
	
	$tpl->display('login.tpl');
}

function do_login(&$FILTER) {
	global $mm;
	
	if(empty($FILTER['email'])) $errs['email'] = 'РџРѕР»РµС‚Рѕ Рµ Р·Р°РґСЉР»Р¶РёС‚РµР»РЅРѕ';
	if(empty($FILTER['pass'])) $errs['pass'] = 'РџРѕР»РµС‚Рѕ Рµ Р·Р°РґСЉР»Р¶РёС‚РµР»РЅРѕ';
	
	if(empty($errs)) {
		$res = $mm->SelRow("SELECT id, name, last_ip FROM adminusers WHERE email='{$FILTER['email']}' AND password='{$FILTER['pass']}'");
		if(empty($res)) {
			$errs['login'] = 'Р“СЂРµС€РЅРѕ РїРѕС‚СЂРµР±РёС‚РµР»СЃРєРѕ РёРјРµ РёР»Рё РїР°СЂРѕР»Р°';
			show_login($FILTER, $errs);
			return;
		}
		$_SESSION['user']['id'] = $res[0];
		$_SESSION['user']['name'] = $res[1];
		$_SESSION['user']['last_ip'] = $res[2];
		
		$mm->Query("DELETE FROM asession WHERE user_id={$res[0]}");
		$data['user_id'] = $res[0];
		$data['session_id'] = session_id();
		$mm->AutoExecute('asession', $data, 1);
		
		unset($data);
		$data['last_ip']=$_SERVER['REMOTE_ADDR'];
		$mm->AutoExecute('adminusers', $data, 2, "id='{$_SESSION['user']['id']}'");
		
		redirect("/admin/");
	} else {
		show_login($FILTER, $errs);
	}
}
?>