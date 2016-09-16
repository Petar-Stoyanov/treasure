<?
if(!defined('LOG_ERROR')) {
	define('LOG_ERROR', 1);
}
if(!defined('LOG_WARNING')) {
	define('LOG_WARNING', 2);
}
if(!defined('LOG_NOTICE')) {
	define('LOG_NOTICE', 3);
}
if(!defined('LOG_LOG')) {
	define('LOG_LOG', 4);
}

abstract class LOG {
	
	public static function logLog($source, $msg) {
   		global $mm;

   		if(empty($source)) {
   			print_r('LOG::logLog() unable to log. Missing $source argument.');
   			return;
   		}
   		
   		if(empty($msg)) {
   			print_r('LOG::logLog() unable to log. Missing $msg argument.');
   			return;
   		}
		$data['type'] = LOG_LOG;
		$data['source'] = $source;
		$data['message'] = $msg;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		if(!preg_match('/\/admin\//', $_SERVER['SCRIPT_NAME'])) {
			$data['user_id'] = nvl($_SESSION['user']['id'],-1);
		} else {
			$data['admuser_id'] = nvl($_SESSION['user']['id'],-1);
		}
		
		$mm->AutoExecute('log', $data, 1);
	}
	
	public static function logError($source, $msg) {
   		global $mm;

   		if(empty($source)) {
   			print_r('LOG::logError() unable to log. Missing $source argument.');
   			return;
   		}
   		
   		if(empty($msg)) {
   			print_r('LOG::logError() unable to log. Missing $msg argument.');
   			return;
   		}
		$data['type'] = LOG_ERROR;
		$data['source'] = $source;
		$data['message'] = $msg;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		if(!preg_match('/\/admin\//', $_SERVER['SCRIPT_NAME'])) {
			$data['user_id'] = nvl($_SESSION['user']['id'],-1);
		} else {
			$data['admuser_id'] = nvl($_SESSION['user']['id'],-1);
		}
		
		$mm->AutoExecute('log', $data, 1);
	}
	
	public static function logWarning($source, $msg) {
   		global $mm;

   		if(empty($source)) {
   			print_r('LOG::logWarning() unable to log. Missing $source argument.');
   			return;
   		}
   		
   		if(empty($msg)) {
   			print_r('LOG::logWarning() unable to log. Missing $msg argument.');
   			return;
   		}
		$data['type'] = LOG_WARNING;
		$data['source'] = $source;
		$data['message'] = $msg;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		if(!preg_match('/\/admin\//', $_SERVER['SCRIPT_NAME'])) {
			$data['user_id'] = nvl($_SESSION['user']['id'],-1);
		} else {
			$data['admuser_id'] = nvl($_SESSION['user']['id'],-1);
		}
		
		$mm->AutoExecute('log', $data, 1);
	}
	
	public static function logNotice($source, $msg) {
   		global $mm;
		
   		if(empty($source)) {
   			print_r('LOG:logNotice() unable to log. Missing $source argument.');
   			return;
   		}
   		
   		if(empty($msg)) {
   			print_r('LOG:logNotice() unable to log. Missing $msg argument.');
   			return;
   		}
		$data['type'] = LOG_NOTICE;
		$data['source'] = $source;
		$data['message'] = $msg;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		if(!preg_match('/\/admin\//', $_SERVER['SCRIPT_NAME'])) {
			$data['user_id'] = nvl($_SESSION['user']['id'],-1);
		} else {
			$data['admuser_id'] = nvl($_SESSION['user']['id'],-1);
		}
		
		$mm->AutoExecute('log', $data, 1);
	}
}
?>