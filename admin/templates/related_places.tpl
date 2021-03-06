{include file="templates/header.tpl"
css1="css/noms.css"
js1="js/jquery.validation.js"
js2="js/ckeditor/ckeditor.js"
js3="js/ckeditor/adapters/jquery.js"
js4="js/ajaxfileupload.js"
}
<div class="inner{if not $side_menu}Full{/if}">

	{if $FILTER.mode neq 'edit'}
		<!--[if !IE]>start section<![endif]-->
		<div class="section table_section">
			<!--[if !IE]>start title wrapper<![endif]-->
			<div class="title_wrapper">
				<h2>Related places</h2>
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
																<td style="width: 1px;">
																<img src="image.php?mode=db&type=pictures&field=small_photo&id={$item.picture_id}" alt="{$picture}" />
																<td><a href="{query_str mode='edit' id=$item.id}" class="product_name">{$item.name}</a></td>

																<td style="width: 120px;">
																	<div class="actions_menu">
																		<ul>

																			<li><a class="edit" href="{query_str mode='edit' id=$item.id}">Edit</a></li>
																			<li>
																				{capture name=back_url}related_places.php{query_str} {/capture}
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

	{else}
		<!--[if !IE]>start section<![endif]-->
		<div class="section">
			<!--[if !IE]>start title wrapper<![endif]-->
			<div class="title_wrapper">
				<h2>Edit related places</h2>
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
								<div id="sec_menu" style="float:right; height: 40px">
									<ul>
										<li><a href="{query_str tab=1}" {if $FILTER.tab==1}class='selected'{/if}><span><span>Characterization</span></span></a></li>
										<li><a href="{query_str tab=2}" {if $FILTER.tab==2}class='selected'{/if}><span><span>Pictures</span></span></a></li>
									</ul>
								</div>
								<div class="sct_right" style="padding-top:50px;">
									{if $FILTER.success eq "true"}
										<div id="successBox" style="width: 250px; height: 100px; position: absolute; z-index: 10; margin-left: auto; margin-right: auto; left: 0; right: 0; font-size: 21px; color: green; border-radius: 19px; padding: 35px; text-align: center; background-color: rgb(250, 250, 250);">
											Your car have been saved!
											<button id="closeSuccess" style="width: 150px; height: 30px; border-radius: 10px; background-color: white; border: 1px solid black; margin-top: 30px;"> Close </button>
										</div>
									{/if}

									{if $FILTER.tab eq 1}

										<!--[if !IE]>start forms<![endif]-->
										<form class="search_form general_form" name='nom_frm' id='nom_frm' method="POST">
											<input type="hidden" name='back_url' value="related_places.php{query_str mode=null id=null}"/>
											<input type="hidden" name='mode' value="save"/>
											<input type="hidden" name="id" id="id" value="{$FILTER.id}"/>
											<input type="hidden" name="tab" id="tab" value="{$FILTER.tab}"/>
											<!--[if !IE]>start fieldset<![endif]-->
											<fieldset>
												<!--[if !IE]>start forms<![endif]-->
												<div class="forms">
													<!--[if !IE]>start row<![endif]-->
													{if $errs.global}<div class="row"><label>&nbsp;</label><span class="system negative">{$errs.global}</span></div>{/if}
													<div class="row">
														<label>Name:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="name" type="text" value="{$FILTER.item.name}"  validation="required"/></span>
															{if $errs.name}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>

													<div class="row">
														<label>Type:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<select name="type">
																	{ foreach value=type from=$FILTER.types }
																			<option value="{$type.id}" {if $FILTER.item.type_id eq $type.id} selected="selected" {/if}>{$type.name}</option>
																	{ /foreach }
																</select>
															</span>
														</div>
														<label>Region:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<select name="area">
																	{ foreach value=area from=$FILTER.areas }
																			<option value="{$area.id}" {if $FILTER.item.area_id eq $area.id} selected="selected" {/if} >{$area.name}</option>
																	{ /foreach }
																</select>
															</span>
														</div>
													</div>
													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Link:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="link" type="text" value="{$FILTER.item.link}"  validation="required"/></span>
															{if $errs.link}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->



													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Description:</label>
														<div class="inputs">
														<span class="input_wrapper blank">
															<textarea rows="" cols="" class="text" name="text" id="text">{$FILTER.item.text}</textarea>
														</span>
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->



													{*BUTTONS*}

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<div class="buttons">
															<ul>
																<li><span class="button send_form_btn"><span><span>Save</span></span><input name="submit" type="submit" /></span></li>
																<li><span class="button cancel_btn"><a href="related_places.php{query_str mode=null id=null}"><span><span>Cancel</span></span></a></span></li>
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
									{else} {* PHOTOS TAB *}
										{if $FILTER.picture}
											<div class="row">
												<label>&nbsp</label>
{*												{foreach from=$FILTER.pictures item=picture} *}
												<img src="image.php?mode=db&type=pictures&field=small_photo&id={$FILTER.picture}" alt="{$picture}" />
														<span style="width: 30px;vertical-align:top;">
															<a href="del_image.php?mode=db&type=pictures&tbl=related_places&id={$FILTER.picture}&back_url=related_places%2Ephp%3Fmode%3Dedit%26id%3D{$FILTER.id}%26tab%3D2" title="Изтрий"><img src="css/layout/site/tables/action4.gif" style="border:0"></a>
														</span>


												{* {/foreach} *}
											</div>
											{/if}

											<div class="row">
												<!-- <label>Picture:</label> -->
												<div class="inputs pic vehicle-page-inputs">
													<label class="vehicle-page-label">Picture:</label>

													<span class="input_wrapper blank vehicle-page-span"><input id="picture" type="file" size="16" name="picture" class="input" ></span>
													{if $errs.picture}<label>&nbsp;</label><span class="system negative">{$errs.picture}</span>{/if}

													{if $FILTER.id > 0}
													<span class="button light_blue_btn"><span><span>Upload</span></span><input type="submit" id="uplmain" onclick="return ajaxFileUpload('picture');"></span>
													<img id="loading" src="images/loading.gif" style="display:none;">
													{/if}
												</div>
											</div>
										{/if}
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
				$('#closeSuccess').click(function(){
					$('#successBox').hide();
				});

                $(function(){ // jQuery DOM ready function.
                    $( 'textarea#text' ).parent().css('width', '90%').parent().css('width', '90%');
                    $( 'textarea#text' ).ckeditor();
                });
            });

			function ajaxFileUpload(fileelemid) {
				$("#loading")
						.ajaxStart(function(){
							$(this).show();
						})
						.ajaxComplete(function(){
							$(this).hide();
						});
				{/literal}
				var url = 'doajaxfileupload.php?mode=db&type=related_places&tbl=related_places&field=original_photo&id={$FILTER.id}&elem='+fileelemid;
				{literal}

				$.ajaxFileUpload
				(
						{
							url: url,
							secureuri:false,
							fileElementId:fileelemid,
							dataType: 'json',
							success: function (data, status) {
								if(typeof(data.error) != 'undefined') {
									if(data.error != '') {
										//alert(data.error);

											console.log(data);
											console.log(status);
											console.log(e);

										window.location.reload();
									} else {
										window.location.reload();
									}
								} else {
									window.location.reload();
								}
							},
							error: function (data, status, e) {
								//alert(e);
								console.log(data);
								console.log(status);
								console.log(e);
							}
						}
				)

				return false;

			}
            {/literal}
        </script>
	{/if}
</div>
{include file="templates/footer.tpl"}