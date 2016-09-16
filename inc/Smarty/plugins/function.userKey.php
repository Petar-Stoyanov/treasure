<?
function tpl_function_userKey($params, &$tpl) {
    global $_session, $mm;
	extract($params);
    
	$userId = $_session['user']['userId'];
	
	$res = $mm->run("SELECT password FROM user WHERE userId={$userId}");
    
	$password = $res->password;
	
	$enc_pass = base64_encode($password);
	$enc_pass = str_replace(array('=', '+'), array('_', '.'), $enc_pass);
	return $enc_pass;	
}
?>