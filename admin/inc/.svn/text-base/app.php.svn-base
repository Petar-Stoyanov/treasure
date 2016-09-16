<?
@session_start();
include("{$_SERVER['DOCUMENT_ROOT']}/inc/config.php");
include("{$_SERVER['DOCUMENT_ROOT']}/inc/functions.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/db.class.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/log.php");
include("{$_SERVER['DOCUMENT_ROOT']}/inc/constants.php");

if ($_SERVER['SERVER_PORT'] != 443 && !$_config['debug']) header("Location: https://www.apollowine.com/admin/");

$_config['smarty_cache'] = $_SERVER['DOCUMENT_ROOT'] . '/admin/tmp'; 

if(!isset($_SESSION['ln'])) $_SESSION['ln']=2;
$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
$mm->UseDB($_config['db_dbname']);
$mm->Query("SET NAMES cp1251");

$mm->Query("DELETE FROM asession WHERE ADDDATE(updated_at, 1)<NOW()");
$sql = "SELECT 	a.user_id, a.session_id, a.updated_at, u.last_ip
		FROM 	asession a
				LEFT JOIN adminusers u ON u.id=a.user_id
		WHERE 	a.session_id='".session_id()."'";
$session = $mm->SelRow($sql);

if(!empty($session)) {
	if(empty($session[2])) {
		$data['user_id'] = $session[0];
		$data['session_id'] = session_id();
		$mm->AutoExecute('asession', $data, 2, "session_id='{$data['session_id']}'");
		
		$data['id'] = $data['user_id'];
		$data['name'] = $_SESSION['user']['name'];
		$data['last_ip'] = $session[3];
		unset($data['user_id']);
		$_SESSION['user'] =  $data;
	} else {
		$timeout = strtotime($session[2])+$_config['session_life'];
		if(time()>$timeout) { // Session expired
			unset($_SESSION['user']);
			$session_id = session_id();
			session_destroy();
			$mm->Query("DELETE FROM asession WHERE session_id='{$session_id}'");
			redirect('/admin/login.php');
		} else {
			$data['user_id'] = $session[0];
			$data['session_id'] = session_id();
			$mm->AutoExecute('asession', $data, 2, "session_id='{$data['session_id']}'");
			
			$data['id'] = $data['user_id'];
			$data['name'] = $_SESSION['user']['name'];
			$data['last_ip'] = $session[3];
			unset($data['user_id']);
			$_SESSION['user'] =  $data;
		}
	}
} elseif (empty($session) && !empty($_SESSION['user'])) {
	unset($_SESSION['user']);
	$session_id = session_id();
	session_destroy();
	$mm->Query("DELETE FROM asession WHERE session_id='{$session_id}'");
	redirect('/admin/login.php');
}

if(empty($_SESSION['user']) && !preg_match('/\/login.php/', $_SERVER['SCRIPT_NAME'])) {
	redirect('/admin/login.php');
}

$PAGE_TITLE = 'Lingadore.bg - Администрация';
header('Content-Type: text/html; charset=utf-8'); 

function __autoload($class_name) {
	global $_config;
    require_once "{$_SERVER['DOCUMENT_ROOT']}/managers/$class_name" . '.php';
}
?>