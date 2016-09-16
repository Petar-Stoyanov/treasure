<?
function tpl_function_insertSecurityImage($params, &$tpl) {
	extract($params);
	
	$refid = md5(mktime()*rand());
   	$insertstr = "<img src=\"securityimage.php?refid=".$refid."\" alt=\"Security Image\" style=\"border: 1px #ccc solid;\">\n
   	<input type=\"hidden\" name=\"".$inputname."\" value=\"".$refid."\">";
   	echo $insertstr;
}
?>