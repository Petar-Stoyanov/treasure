<?
/**
 * Smarty function for building query string. It takes curretn QUERY string removes specified params
 * from URL and place it agin with newest specified value. If new value is NULL, '' then param is just removed.
 *
 * Smarty params ... many
 * 			- bol full_request_uri specifies for function not only to return query string but full request URI
 * 			- bol escape specifies to escape & to &amp;
 * 			- str var name of var to change
 * 			- str val value of var to be removed
 * 			- str sep value of separator
 *
 * @param 	arr $params Params to the function
 */
function tpl_function_remove_query_str($params) {
	$url = '';
	if(isset($params['full_request_uri']) && $params['full_request_uri']) {
		$url = str_replace("?{$_SERVER['QUERY_STRING']}", '', $_SERVER['REQUEST_URI']);
		unset($params['full_request_uri']);
	}

	$query = array();
	parse_str($_SERVER['QUERY_STRING'] , $query);

	$escape = !empty($params['escape']);
	
	$separator = $params['sep'];
	if(empty($separator)) $separator = ',';
	
	unset($params['escape']);
	if(!empty($params['var'])) {
		$params[$params['var']] = nvl($params['val'], null);
	}
	unset($params['var']);
	unset($params['val']);
	unset($params['sep']);

	foreach($params AS $key=>$val) {
		if ($val=='') {
			continue;
		} else {
			$tmpVal = $query[$key];
			
			$vals = explode($separator, $tmpVal);
			if(in_array($val, $vals)) {
				foreach ($vals AS $id=>$cur_val) {
					if($cur_val==$val) {
						unset($vals[$id]);
						break;
					}
				}
				$tmpVal = implode($separator, $vals);
				if(empty($tmpVal)) {
					unset($query[$key]);
				} else {
					$query[$key]=$tmpVal; // new val of param
				}
			}
		}
	}
	if($escape) {
		$query = http_build_query($query, null, '&amp;');
	} else {
		$query = http_build_query($query);
	}
	if($query!='') $url .= '?' . $query;

	echo $url;
}
?>