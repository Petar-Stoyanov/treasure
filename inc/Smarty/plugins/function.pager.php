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
function tpl_function_pager($params, &$tpl)
{
	require_once("shared.escape_chars.php");
	extract($params);

	if (!isset($_page) || empty($max_page)|| empty($total_cnt))
	{
		$tpl->trigger_error("html_pager: missing 'parameters");
		return;
	}
	if($max_page>0) {
		$toReturn = '<table cellpadding="0" class="pager">
					<tr>
						<td>Results found: <b>'.$total_cnt.'</b></td>
						<td align="right">';
		
		if($_page>1) {
			$toReturn .= '<a href="users.php?_page=1'.($sort_id?'&sort_id='.$sort_id:'').'" style="font-size: 12px; text-decoration: none;" title="First page">[<b>First</b>]</a>
						&nbsp;
						<a href="users.php?_page='.($_page-1).''.($sort_id?'&sort_id='.$sort_id:'').'" style="font-size: 14px; text-decoration: none;" title="Prev page">&#171;</a>&nbsp;';
		}
		if($_page>3) {
			$toReturn .= '...';
		}
		if($_page-2>0) {
			$start=$_page-2;
		}else{
			$start=1;
		}
		$count=0;
		for ($i=$start; $i<=$max_page; $i++) {
			$count++;
			if($_page==$i) {
				$toReturn .= '<a class="selected" style="color: red; font-weight: bold;">'.$i.'</a>&nbsp;';
			}else{
				$toReturn .= '<a href="users.php?_page='.$i.''.($sort_id?'&sort_id='.$sort_id:'').'">'.$i.'</a>&nbsp;';
			}
			if($count==5) {
				$toReturn .= '...';
				break;
			}
		}
		
		if($_page<$max_page) {
			$toReturn .= '&nbsp;<a href="users.php?_page='.($_page+1).''.($sort_id?'&sort_id='.$sort_id:'').'" style="font-size: 14px; text-decoration: none;" title="Next page">&#187;</a>
							&nbsp;
						<a href="users.php?_page='.$max_page.''.($sort_id?'&sort_id='.$sort_id:'').'" style="font-size: 12px; text-decoration: none;" title="Last page">[<b>Last</b>]</a>';
		}
		$toReturn .= '&nbsp;&nbsp;&nbsp;<span style="font-size: 10px;">from</span>&nbsp;<span style="font-size: 12px;"><b>'.$max_page.'</b></span>
						</td>
					</tr>
				</table>';
	}else{
		$toReturn = '<table cellpadding="0" class="pager">
					<tr>
						<td align="center">Няма намерени резултати</td>
					</tr>
				</table>';
	}
	
	return $toReturn;
}
?>