<?php
/**
 * template_lite {html_input} function plugin
 *
 * Type:     function
 * Name:     html_input
 * Purpose:  Creates a pager element
 * Input:
 *           - name = the name of the textbox
 *           - password = boolean - if set, this box will be a password box
 *           - value = optional default value for the input box
 *           - size = optional size for the input box
 *           - length = optional maxlength for the input box
 * Author:   Paul Lockaby <paul@paullockaby.com>
 */
function tpl_function_sorter_link($params, &$tpl)
{
	extract($params);

	if (!isset($title) || !isset($sort_id))
	{
		$tpl->trigger_error("tpl_function_sorter_link: missing 'parameters");
		return;
	}
	if(abs(nvl($_REQUEST['sort_id'])) == abs($sort_id)) {
		$class = $_REQUEST['sort_id']>0 ? 'asc' : 'desc';
		$sort_id = -$_REQUEST['sort_id'];
		$href = replace_param_in_url('sort_id', $sort_id);
		$link = "<a class='$class' href='$href'>$title</a>";
	} else {
		$href = replace_param_in_url('sort_id', $sort_id);
		$link = "<a href='$href'>$title</a>";
	}
	
	return $link;
}
?>