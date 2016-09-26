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
				<h2>Vehicle's</h2>
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
														<th>{sorter_link sort_id=2 title='Photo'}</th>
														<th>{sorter_link sort_id=3 title='Brand'}</th>
														<th>{sorter_link sort_id=4 title='Model'}</th>
														<th>{sorter_link sort_id=5 title='Type'}</th>
														<th>{sorter_link sort_id=6 title='sortingWeight'}</th>
														<th>Actions</th>
													</tr>

													{if $FILTER.list}
														{assign var=counter value=0}
														{foreach from=$FILTER.list item=item}
															<tr class="{if $counter%2}second{else}first{/if}{if $item.hidden} hidden{/if}">
																<td style="width: 16px;">{$item.id}</td>
																<td style="width: 1px;"><img src="image.php?type=photos&id={$item.photo}&field=big_photo" width="200" alt="Vehicle {$item.id} photo"/></td>
																<td><a href="{query_str mode='edit' id=$item.id}" class="product_name">{$item.brand}</a></td>
																<td><a href="{query_str mode='edit' id=$item.id}" class="product_name">{$item.model}</a></td>
																<td><a href="{query_str mode='edit' id=$item.id}" class="product_name">{$item.type}</a></td>
																<td><a href="{query_str mode='edit' id=$item.id}" class="product_name">{$item.sortingWeight}</a></td>

																<td style="width: 120px;">
																	<div class="actions_menu">
																		<ul>

																			<li><a class="edit" href="{query_str mode='edit' id=$item.id}">Edit</a></li>
																			<li>
																				{capture name=back_url}vehicle.php{query_str} {/capture}
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
				<h2>Edit vehicle</h2>
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
											<input type="hidden" name='back_url' value="vehicle.php{query_str mode=null id=null}"/>
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
														<label>Brand:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="brand" type="text" value="{$FILTER.item.brand}"  validation="required"/></span>
															{if $errs.brand}<span class="system negative">Mandatory field</span>{/if}
														</div>
														<label>Model:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="model" type="text" value="{$FILTER.item.model}" validation="required"/></span>
															{if $errs.model}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>

													<div class="row">
														<label>Vehicle type:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<select name="vehicle_types">
																	{ foreach value=vehicle_types from=$FILTER.vars.vehicle_types }
																			<option value="{$vehicle_types.id}" {if $FILTER.item.vehicle_type_id eq $vehicle_types.id} selected="selected" {/if}>{$vehicle_types.name_en}</option>
																	{ /foreach }
																</select>
															</span>
														</div>

														<label>Vehicle class:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<select name="vehicle_class">
																	{ foreach value=vehicle_class from=$FILTER.vars.vehicle_class }
																			<option value="{$vehicle_class.id}" {if $FILTER.item.vehicle_class_id eq $vehicle_class.id.id} selected="selected" {/if} >{$vehicle_class.name_en}</option>
																	{ /foreach }
																</select>
															</span>
														</div>
													</div>

													<div class="row">
														<label>Human capacity:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<select name="human_capacity">
																	{ foreach value=h_c from=$FILTER.vars.human_capacity }
																			<option value="{$h_c.id}" {if $FILTER.item.human_capacity_id eq $h_c.id} selected="selected" {/if} >{$h_c.name_en}</option>
																	{ /foreach }
																</select>
															</span>
														</div>

														<label>Doors:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<select name="number_of_doors">
																	{ foreach value=n_of_d from=$FILTER.vars.number_of_doors }
																			<option value="{$n_of_d.id}" {if $FILTER.item.number_of_doors_id eq $n_of_d.id} selected="selected" {/if} >{$n_of_d.name_en}</option>
																	{ /foreach }
																</select>
															</span>
														</div>
													</div>

													<!--[if !IE]>start row<![endif]-->
														<div class="row">
															<label>Transmission:</label>
															<select name="transmission">
																<option value="Manual" {if $FILTER.item.transmission_en eq "Manual"} selected="selected" {/if}>Manual</option>
																<option value="Automatic" {if $FILTER.item.transmission_en eq "Automatic"} selected="selected" {/if}>Automatic</option>
															</select>
														</div>
													<!--[if !IE]>end row<![endif]-->

													<div class="row">
														<label>Is promo:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank editor">
																<input type="checkbox" name="is_promo" value="1" {if $FILTER.item.is_promo} checked="checked"{/if}/>
															</span>
														</div>

														<label style="display:none;">With driver:</label>
														<div class="twoSelectionsInRow" style="display:none;">
															<span class="input_wrapper blank editor">
																<input type="checkbox" name="withDriver" value="1" {if $FILTER.item.withDriver} checked="checked"{/if}/>
															</span>
														</div>
													</div>
													<div class="row">
														<label>Is transfer car:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank editor">
																<input type="checkbox" name="is_transfer" value="1" {if $FILTER.item.is_transfer} checked="checked"{/if}/>
															</span>
														</div>
													</div>
													<div class="row">
														<label>Vehicle extras:</label>

														{ foreach value=vehicle_extras from=$FILTER.vars.vehicle_extras }
															<label style="width:200px;">{$vehicle_extras.name_en}:
																<input type="checkbox" name="vehicle_extras[]" value="{$vehicle_extras.id}"
																	{ foreach value=ext from=$FILTER.item.extras }
																		{if $ext eq $vehicle_extras.id} checked="checked"{/if}
																	{ /foreach }
																/></label>
														{ /foreach }
													</div>

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Sorting weight:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="sortingWeight" type="text" value="{$FILTER.item.sortingWeight}"  validation="required decimal"/></span>
															{if $errs.sortingWeight}<span class="system negative">Mandatory field</span>{/if}
														</div>
														<!--
														<label>Vehicle use for:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<select name="use_for_id">
																	{ foreach value=vehicle_use_f from=$FILTER.vars.vehicles_use_for }
																			<option value="{$vehicle_use_f.id}" {if $FILTER.item.use_for_id eq $vehicle_use_f.id} selected="selected" {/if}>{$vehicle_use_f.name}</option>
																	{ /foreach }
																</select>
															</span>
														</div>
														-->
													</div>
                                                    <!--[if !IE]>end row<![endif]-->


													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Include mileage:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="includedKm" type="text" value="{$FILTER.item.includedKm}"  validation="required integer"/></span>
															{if $errs.includedKm}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>
                                                    <!--[if !IE]>end row<![endif]-->


													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Description BG:</label>
														<div class="inputs">
														<span class="input_wrapper blank">
															<textarea rows="" cols="" class="text" name="description_bg" id="description_bg">{$FILTER.item.description_bg}</textarea>
														</span>
														</div>
													</div>
													<div class="row">
														<label>Description EN:</label>
														<div class="inputs">
															<span class="input_wrapper blank">
																<textarea rows="" cols="" class="text" name="description_en" id="description_en">{$FILTER.item.description_en}</textarea>
															</span>
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Description RU:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<textarea rows="" cols="" class="text" name="description_ru" id="description_ru">{$FILTER.item.description_ru}</textarea>
															</span>
														</div>

														<label>Description DE:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper blank">
																<textarea rows="" cols="" class="text" name="description_de" id="description_de">{$FILTER.item.description_de}</textarea>
															</span>
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<!--<div class="row">
														<label>Classification BG:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="classification_bg" type="text" value="{$FILTER.item.classification_bg}"  validation="required"/></span>
															{if $errs.classification_bg}<span class="system negative">Mandatory field</span>{/if}
														</div>
														<label>Classification EN</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="classification_en" type="text" value="{$FILTER.item.classification_en}" validation="required"/></span>
															{if $errs.classification_en}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>-->
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<!--<div class="row">
														<label>Classification RU:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="classification_ru" type="text" value="{$FILTER.item.classification_ru}"  validation="required"/></span>
															{if $errs.classification_ru}<span class="system negative">Mandatory field</span>{/if}
														</div>
														<label>Classification DE</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="classification_de" type="text" value="{$FILTER.item.classification_de}" validation="required"/></span>
															{if $errs.classification_de}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>-->
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<!--
														<label>SEO URL BG:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper">
																<input type="text" class="text" name="seo_url_bg" required="url" value="{$FILTER.item.seo_url_bg}">
															</span>
															{if $errs.seo_url_bg}<span class="system negative">Mandatory field</span>{/if}
														</div>
														-->

														<label>SEO URL:</label>
														<div>
															<span class="input_wrapper">
																<input type="text" class="text" name="seo_url_en" required="url" value="{$FILTER.item.seo_url_en}">
															</span>
															<span>(Do not use spaces between words, do for instance "opel-astra")</span>

															{if $errs.seo_url_en}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>

													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<!--
													<div class="row">
														<label>SEO URL RU:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper">
																<input type="text" class="text" name="seo_url_ru" required="url" value="{$FILTER.item.seo_url_ru}">
															</span>
															{if $errs.seo_url_ru}<span class="system negative">Mandatory field</span>{/if}
														</div>

														<label>SEO URL DE:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper">
																<input type="text" class="text" name="seo_url_de" required="url" value="{$FILTER.item.seo_url_de}">
															</span>
															{if $errs.seo_url_de}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>
													-->
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>SEO title BG:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper textarea_wrapper">
																<textarea rows="" cols="" class="text" name="seo_title_bg">{$FILTER.item.seo_title_bg}</textarea>
															</span>
														</div>

														<label>SEO title EN:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper textarea_wrapper">
																<textarea rows="" cols="" class="text" name="seo_title_en">{$FILTER.item.seo_title_en}</textarea>
															</span>
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->


													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>SEO title RU:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper textarea_wrapper">
																<textarea rows="" cols="" class="text" name="seo_title_ru">{$FILTER.item.seo_title_ru}</textarea>
															</span>
														</div>

														<label>SEO title DE:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper textarea_wrapper">
																<textarea rows="" cols="" class="text" name="seo_title_de">{$FILTER.item.seo_title_de}</textarea>
															</span>
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>SEO description BG:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper textarea_wrapper">
																<textarea rows="" cols="" class="text" name="seo_description_bg">{$FILTER.item.seo_description_bg}</textarea>
															</span>
														</div>

														<label>SEO description EN:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper textarea_wrapper">
																<textarea rows="" cols="" class="text" name="seo_description_en">{$FILTER.item.seo_description_en}</textarea>
															</span>
														</div>

													</div>
													<!--[if !IE]>end row<![endif]-->
														<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>SEO description RU:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper textarea_wrapper">
																<textarea rows="" cols="" class="text" name="seo_description_ru">{$FILTER.item.seo_description_ru}</textarea>
															</span>
														</div>

														<label>SEO description DE:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper textarea_wrapper">
																<textarea rows="" cols="" class="text" name="seo_description_de">{$FILTER.item.seo_description_de}</textarea>
															</span>
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->

													{*PRICE*}

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Price for day:</label>
														<div class="twoSelectionsInRow">
																<span class="input_wrapper"><input class="text" name="price_1" type="text" value="{$FILTER.item.price_1}"  validation="required decimal"/></span>
																{if $errs.price_1}<span class="system negative">Mandatory field</span>{/if}
														</div>

														<label>Price for 2-7 days:</label>
														<div class="twoSelectionsInRow">
																<span class="input_wrapper"><input class="text" name="price_2" type="text" value="{$FILTER.item.price_2}"  validation="required decimal"/></span>
																{if $errs.price_2}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Price for 8-14 days:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="price_3" type="text" value="{$FILTER.item.price_3}"  validation="required decimal"/></span>
															{if $errs.price_3}<span class="system negative">Mandatory field</span>{/if}
														</div>

														<label>Price for 15 days:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="price_4" type="text" value="{$FILTER.item.price_4}"  validation="required decimal"/></span>
															{if $errs.price_4}<span class="system negative">Mandatory field</span>{/if}

														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->


													<!--[if !IE]>start row<![endif]-->
												<!--	<div class="row">
														<label>Price per day:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="pricePerDay" type="text" value="{$FILTER.item.pricePerDay}"  validation="required decimal"/></span>
															{if $errs.pricePerDay}<span class="system negative">Mandatory field</span>{/if}
														</div>

													<label>Price per day without driver:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="pricePerDayWithoutDriver" type="text" value="{$FILTER.item.pricePerDayWithoutDriver}"  validation="required decimal"/></span>
															{if $errs.pricePerDayWithoutDriver}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>-->
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Deposit:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="deposit" type="text" value="{$FILTER.item.deposit}"  validation="required decimal"/></span>
															{if $errs.deposit}<span class="system negative">Mandatory field</span>{/if}
														</div>
														<label>Price per km:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="pricePerKm" type="text" value="{$FILTER.item.pricePerKm}" /></span>
															{if $errs.pricePerKm}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Promotional price:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="promo_price" type="text" value="{$FILTER.item.promo_price}"  validation="required decimal"/></span>
															{if $errs.promo_price}<span class="system negative">Mandatory field</span>{/if}
														</div>

														<label>Discount for agency %:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="discount" type="text" value="{$FILTER.item.discount}"  validation="required percent"/></span>
															{if $errs.discount}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->


													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>CDW:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="cdw" type="text" value="{$FILTER.item.cdw}"  validation="required decimal"/></span>
															{if $errs.cdw}<span class="system negative">Mandatory field</span>{/if}
														</div>

														<label>CDW2:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="cdw2" type="text" value="{$FILTER.item.cdw2}"  validation="required decimal"/></span>
															{if $errs.cdw2}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>PAI:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="pai" type="text" value="{$FILTER.item.pai}"  validation="required decimal"/></span>
															{if $errs.pai}<span class="system negative">Mandatory field</span>{/if}
														</div>

														<label>GAT:</label>
														<div class="twoSelectionsInRow">
															<span class="input_wrapper"><input class="text" name="gat" type="text" value="{$FILTER.item.gat}"  validation="required decimal"/></span>
															{if $errs.gat}<span class="system negative">Mandatory field</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->

													{*BUTTONS*}

													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<div class="buttons">
															<ul>
																<li><span class="button send_form_btn"><span><span>Save</span></span><input name="submit" type="submit" /></span></li>
																<li><span class="button cancel_btn"><a href="vehicle.php{query_str mode=null id=null}"><span><span>Cancel</span></span></a></span></li>
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
										{if $FILTER.pictures}
											<div class="row">
												<label>&nbsp;</label>
												{foreach from=$FILTER.pictures item=picture}
												<img src="image.php?mode=db&type=photos&field=big_photo&id={$picture.photo_id}" alt="{$picture.picture}" />
														<span style="width: 30px;vertical-align:top;">
															<a href="del_image.php?mode=db&type=photos&id={$picture.photo_id}&back_url=vehicle%2Ephp%3Fmode%3Dedit%26id%3D{$FILTER.id}%26tab%3D2" title="Изтрий"><img src="css/layout/site/tables/action4.gif" style="border:0"></a>
														</span>


												{/foreach}
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
                    $( 'textarea#description_bg' ).parent().css('width', '90%').parent().css('width', '90%');
                    $( 'textarea#description_bg' ).ckeditor();
                    $( 'textarea#description_ru' ).parent().css('width', '90%').parent().css('width', '90%');
                    $( 'textarea#description_ru' ).ckeditor();
                    $( 'textarea#description_en' ).parent().css('width', '90%').parent().css('width', '90%');
                    $( 'textarea#description_en' ).ckeditor();
                    $( 'textarea#description_de' ).parent().css('width', '90%').parent().css('width', '90%');
                    $( 'textarea#description_de' ).ckeditor();
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
				var url = 'doajaxfileupload.php?mode=db&type=photos&field=original_photo&id={$FILTER.id}&elem='+fileelemid;
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

										//window.location.reload();
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