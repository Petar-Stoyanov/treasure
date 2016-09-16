<?
function tpl_function_title_to_url($params) {
	if(!isset($params['ln'])) $params['ln'] = null;
	$id = $params['id'];
	$ln = $params['ln'];
	$title = $params['ttl'];
	$res = trim($title);
	$res = Cyrillic2Latin($res); // BG should be converted to EN for URL
	$res = strtolower($res); // SEO optimization all URL in lowercase
	$res = preg_replace('/[^a-z0-9]+/', '-', $res); // remove all unneeded symbols and replace them with -
	$res = trim($res, '-'); // clearing - at the end

	if(strlen($res)>=100) { // limit len of friendly URL to 100 symbols
		$res = substr($res, 0, 100);
	 	$res = preg_replace('/-[^-]*$/', '', $res); // remove whole last word or last dash if it is at the end
	}

	$id = intval($id);
	$res .= '-' . $id;
	
	echo $res;
}
?>