<?
$mm->Query("DELETE FROM session WHERE ADDDATE(updated_at, 1)<NOW()");
$sql = "SELECT 	s.user_id, s.session_id, s.updated_at, u.last_ip
		FROM 	session s
				LEFT JOIN users u ON u.id=s.user_id
		WHERE 	s.session_id='".session_id()."'";
$session = $mm->SelRow($sql);

if(!empty($session)) {
	if(empty($session[2])) {
		$data['user_id'] = $session[0];
		$data['session_id'] = session_id();
		$mm->AutoExecute('session', $data, 2, "session_id='{$data['session_id']}'");
		
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
			$mm->Query("DELETE FROM session WHERE session_id='{$session_id}'");
			//redirect('/login.php');
		} else {
			$data['user_id'] = $session[0];
			$data['session_id'] = session_id();
			$mm->AutoExecute('session', $data, 2, "session_id='{$data['session_id']}'");
			
			$data['id'] = $data['user_id'];
			$data['name'] = $_SESSION['user']['name'];
			$data['last_ip'] = $session[3];
			unset($data['user_id']);
			$_SESSION['user'] =  $data;
		}
	}
} elseif(!empty($_SESSION['user'])) {
	unset($_SESSION['user']);
	$session_id = session_id();
	$mm->Query("DELETE FROM session WHERE session_id='{$session_id}'");
}
?>