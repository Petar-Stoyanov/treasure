{include file="templates/header.tpl"
css1="css/noms.css"
js1="js/jquery.validation.js"
js2="js/ckeditor/ckeditor.js"
js3="js/ckeditor/adapters/jquery.js"
js4="js/ajaxfileupload.js"
}
<div class="inner{if not $side_menu}Full{/if}">


	<!--[if !IE]>start section<![endif]-->
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Region</h2>
			<span class="title_wrapper_left"></span>
			<span class="title_wrapper_right"></span>
		</div>
		<!--[if !IE]>end title wrapper<![endif]-->
		<!--[if !IE]>start section content<![endif]-->
		<div class="section_content">
			<!--[if !IE]>start section content top<![endif]-->
			<div class="sct">
				<div class="sct_left">
					<div class="sct_right">
						<div class="sct_left">
							<div class="sct_right">
								<div  id="product_list">
									<!--[if !IE]>start table_wrapper<![endif]-->
									<div class="table_wrapper">
										<div class="table_wrapper_inner">
											<table cellpadding="0" cellspacing="0" width="100%">
												<tbody><tr>
													<th>{sorter_link sort_id=1 title='No.'}</th>
													<th>{sorter_link sort_id=2 title='Name'}</th>
													<th>Actions</th>
												</tr>

												{if $FILTER.list}
													{assign var=counter value=0}
													{foreach from=$FILTER.list item=item}
														<tr class="{if $counter%2}second{else}first{/if}{if $item.hidden} hidden{/if}">
															<td style="width: 16px;">{$item.id}</td>
															<td><a href="{query_str mode='edit' id=$item.id}" class="product_name">{$item.name_bg}</a></td>

															<td style="width: 120px;">
																<div class="actions_menu">
																	<ul>

																		<li><a class="edit" href="{query_str mode='edit' id=$item.id}">Edit</a></li>
																		<li>
																			{capture name=back_url}nom_area.php{query_str} {/capture}
																			{if $item.hidden}
																				<a class="unhide" href="?mode=unhide&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}">Unhide</a>
																			{else}
																				<a class="delete" href="?mode=hide&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}">Hide</a>
																			{/if}
																		</li>
																	</ul>
																</div>
															</td>
														</tr>
														{math equation='x+1' x=$counter assign=counter}
													{/foreach}
												{else}
													<tr class="first">
														<td colspan="3">No input data</td>
													</tr>
												{/if}
												</tbody></table>
										</div>
									</div>
									<!--[if !IE]>end table_wrapper<![endif]-->
								</div>
								<!--[if !IE]>start pagination<![endif]-->
								{if $FILTER.list}{$FILTER.pager}{/if}
								<!--[if !IE]>end pagination<![endif]-->
							</div>
						</div>
					</div>
				</div>
			</div>


			<!--[if !IE]>end section content top<![endif]-->
			<!--[if !IE]>start section content bottom<![endif]-->
			<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
			<!--[if !IE]>end section content bottom<![endif]-->
			<div style="padding: 10px 0 20px 10px;">
				<a class="button add_new" href="{query_str mode='edit' id=-1}"><span><span>Add</span></span></a>
			</div>
		</div>
		<!--[if !IE]>end section content<![endif]-->
	</div>
	<!--[if !IE]>end section<![endif]-->

	{if $FILTER.mode eq 'edit'}
		<!--[if !IE]>start section<![endif]-->
		<div class="section">
			<!--[if !IE]>start title wrapper<![endif]-->
			<div class="title_wrapper">
				<h2>Edit region</h2>
				<span class="title_wrapper_left"></span>
				<span class="title_wrapper_right"></span>
			</div>
			<!--[if !IE]>end title wrapper<![endif]-->
			<!--[if !IE]>start section content<![endif]-->
			<div class="section_content">
				<!--[if !IE]>start section content top<![endif]-->
				<div class="sct">
					<div class="sct_left">
						<div class="sct_right">
							<div class="sct_left">
								<div class="sct_right">

									<!--[if !IE]>start forms<![endif]-->
									<form class="search_form general_form" name='nom_frm' id='nom_frm' method="POST">
										<input type="hidden" name='back_url' value="nom_area.php{query_str mode=null id=null}"/>
										<input type="hidden" name='mode' value="save"/>
										<input type="hidden" name="id" id="id" value="{$FILTER.id}"/>
										<!--[if !IE]>start fieldset<![endif]-->
										<fieldset>
											<!--[if !IE]>start forms<![endif]-->
											<div class="forms">
												<!--[if !IE]>start row<![endif]-->

												{if $errs.global}<div class="row"><label>&nbsp;</label><span class="system negative">{$errs.global}</span></div>{/if}
												<div class="row">
													<label>Name BG:</label>
													<div class="inputs">
														<span class="input_wrapper"><input class="text" name="name_bg" type="text" value="{$FILTER.item.name_bg}"  validation="required"/></span>
														{if $errs.name_bg}<span class="system negative">Mandatory field</span>{/if}
													</div>
													<label>Name EN:</label>
													<div class="inputs">
														<span class="input_wrapper"><input class="text" name="name_en" type="text" value="{$FILTER.item.name_en}" validation="required"/></span>
														<!-- {if $errs.name_en}<span class="system negative">Mandatory field</span>{/if} -->
													</div>
												</div>
												<!--[if !IE]>end row<![endif]-->
												<!--[if !IE]>start row<![endif]-->
												<div class="row">
													<label>Location x:</label>
													<div class="inputs">
														<span class="input_wrapper"><input class="text" name="location_x" type="text" value="{$FILTER.item.location_x}"  validation="required"/></span>
														{if $errs.location_x}<span class="system negative">Mandatory field</span>{/if}
													</div>
													<label>Location y:</label>
													<div class="inputs">
														<span class="input_wrapper"><input class="text" name="location_y" type="text" value="{$FILTER.item.location_y}" validation="required"/></span>
														<!-- {if $errs.location_y}<span class="system negative">Mandatory field</span>{/if} -->
													</div>
												</div>
												<!--[if !IE]>end row<![endif]-->
												<!--[if !IE]>start row<![endif]-->
												<div class="row">
													<div class="buttons">
														<ul>
															<li><span class="button send_form_btn"><span><span>Save</span></span><input name="submit" type="submit" /></span></li>
															<li><span class="button cancel_btn"><a href="nom_area.php{query_str mode=null id=null}"><span><span>Cancel</span></span></a></span></li>
														</ul>
													</div>
												</div>
												<!--[if !IE]>end row<![endif]-->
											</div>
											<!--[if !IE]>end forms<![endif]-->

										</fieldset>
										<!--[if !IE]>end fieldset<![endif]-->
									</form>
									<!--[if !IE]>end forms<![endif]-->

								</div>
							</div>
						</div>
					</div>
				</div>
				<!--[if !IE]>end section content top<![endif]-->
				<!--[if !IE]>start section content bottom<![endif]-->
				<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
				<!--[if !IE]>end section content bottom<![endif]-->

			</div>
			<!--[if !IE]>end section content<![endif]-->
		</div>
		<!--[if !IE]>end section<![endif]-->
		<script type="text/javascript">
			{literal}
			$(function(){ // jQuery DOM ready function.
				var myForm = $("#nom_frm");
				myForm.validation();
			});
			{/literal}
		</script>
	{/if}
</div>
{include file="templates/footer.tpl"}