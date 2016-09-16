<?php
/**
 * Type:     function
 * Name:     sort
 * Purpose:  Changes the sortid link in URL
 * Input:
 *           - val = int - the sortid value
 */
function tpl_function_sort($params, &$tpl)
{
	extract($params);

	if (!isset($val))
	{
		$tpl->trigger_error("tpl_function_sort: missing 'parameters");
		return;
	}
	$sort_id = intval($val);
	
	if(abs(nvl($_REQUEST['sortid'])) == abs($sort_id)) {
		$sort_id = -$_REQUEST['sortid'];
		$href = replace_param_in_url('sortid', $sort_id);
		$href = replace_param_in_url('page', '', $href);
	} else {
		$href = replace_param_in_url('sortid', $sort_id);
		$href = replace_param_in_url('page', '', $href);
	}
	
	return $href;
}
?>