<?
/**
 * Smarty function for building query string. It takes curretn QUERY string removes specified params
 * from URL and place it agin with newest specified value. If new value is NULL, '' then param is just removed.
 *
 * Smarty params ... many
 * 			- bol full_request_uri specifies for function not only to return query string but full request URI
 * 			- bol escape specifies to escape & to &amp;
 * 			- str var name of var to change
 * 			- str val value of var to change
 *
 * @param 	arr $params Params to the function
 */
function tpl_function_query_str($params) {
	$url = '';
	if(isset($params['full_request_uri']) && $params['full_request_uri']) {
		$url = str_replace("?{$_SERVER['QUERY_STRING']}", '', $_SERVER['REQUEST_URI']);
		unset($params['full_request_uri']);
	}

	$query = array();
	parse_str($_SERVER['QUERY_STRING'] , $query);

	$escape = !empty($params['escape']);
	unset($params['escape']);
	if(!empty($params['var'])) {
		$params[$params['var']] = nvl($params['val'], null);
	}
	unset($params['var']);
	unset($params['val']);
	
	foreach($params AS $key=>$val) {
		if (empty($val)) {
			unset($query[$key]); // remove param with value if present
		} else {
			$query[$key]=$val; // new val of param
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