{include file="templates/header.tpl"
	css1="css/promotions.css"
	css2="js/jscalendar/css/jscal2.css"
	js1="js/jquery.validation.js"
	js2="js/jscalendar/js/jscal2.js"
	js3="js/jscalendar/js/lang/en.js"
}
<div class="inner">
	
	{if $FILTER.mode neq 'edit'}
		<!--[if !IE]>start section<![endif]-->	
		<div class="section table_section">
			<!--[if !IE]>start title wrapper<![endif]-->
			<div class="title_wrapper">
				<h2>Активни промоции</h2>
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
												<th>&nbsp;</th>
												<th>Продукт</th>
												<th>{sorter_link sort_id=2 title='Промоция активна до:'}</th>
												<th>Промо цена</th>
												<th>Реална цена</th>
												
												<th>Действия</th>
											</tr>
											
											{if $FILTER.list}
												{assign var=counter value=0}
												{foreach from=$FILTER.list item=item}
													<tr class="{if $counter%2}second{else}first{/if}{if $item.hidden} hidden{/if}">
														<td style="width: 1px;">
															<img src="image.php?mode=file&name=img{$item.prod_id}_thum2.jpg" width="72" alt="снимка"/>	
														</td>
														<td>
															<a href="{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.name_bg}</a>
															<a href="products.php?type={$item.type_id}&mode=edit&id={$item.prod_id}">
																<img src='css/layout/site/tables/edit_action.gif' title="Виж данни за продукт" style="border:0">
															</a>
														</td>
														<td><a href="{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.active_from|date_format:"%d.%m.%Y"}-{$item.active_till|date_format:"%d.%m.%Y"}</a></td>
														<td><a href="{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.disc_price} лв.</a></td>
														<td><a href="{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.real_price} лв.</a></td>
														
														<td style="width: 120px;">
															<div class="actions_menu">
																<ul>
																	
																	<li><a class="edit" href="{query_str mode='edit' id=$item.id prod_id=$item.prod_id}">Edit</a></li>
																	<li>
																		{capture name=back_url} promotions.php{query_str} {/capture}
																		<a class="delete" href="?mode=del&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}">Del</a>
																	</li>
																</ul>
															</div>
														</td>
													</tr>
													{math equation='x+1' x=$counter assign=counter}
												{/foreach}
											{else}
												<tr class="first">
													<td colspan="6">Няма въведени промоции</td>
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
					<a class="button add_new" href="products.php?type=1&act=sel&return_to=prom"><span><span>ДОБАВИ ПРОДУКТ В ПРОМОЦИЯ</span></span></a>
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
				<h2>Редактирай промоция</h2>
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
									<form class="search_form general_form" name='prom_frm' id='prom_frm' method="POST">
										<input type="hidden" name='back_url' value="promotions.php{query_str mode=null id=null prod_id=null}"/>
										<input type="hidden" name='mode' value="save"/>
										<input type="hidden" name="id" value="{$FILTER.id}"/>
										<input type="hidden" name="prod_id" value="{$FILTER.prod_id}"/>
										<!--[if !IE]>start fieldset<![endif]-->
										<fieldset>
											<!--[if !IE]>start forms<![endif]-->
											<div class="forms">
												<!--[if !IE]>start row<![endif]-->
												
												{if $errs.global}<div class="row"><label>&nbsp;</label><span class="system negative">{$errs.global}</span></div>{/if}
												<div class="row">
													<label>Продукт:</label>
													<div class="inputs product">
														<span class="input_wrapper">{$FILTER.product.name}</span>
														<span class="image"><img src="image.php?mode=file&name=img{$FILTER.product.id}_thum1.jpg" alt="снимка"/></span>
														<span class="input_wrapper descr">{$FILTER.product.short_descr_bg}</span>
													</div>
												</div>
												<!--[if !IE]>end row<![endif]-->
												
												<!--[if !IE]>start row<![endif]-->
												<div class="row">
													<label>Описание БГ:</label>
													<div class="inputs">
														
														<span class="input_wrapper textarea_wrapper">
															<textarea rows="" cols="" class="text" name="description_bg">{$FILTER.item.description_bg}</textarea>
														</span>
													</div>
												</div>
												<!--[if !IE]>end row<![endif]-->
												<div class="row">
													<label>Описание EN:</label>
													<div class="inputs">
														
														<span class="input_wrapper textarea_wrapper">
															<textarea rows="" cols="" class="text" name="description_en">{$FILTER.item.description_en}</textarea>
														</span>
													</div>
												</div>
												<div class="row">
													<label>Промоция от:</label>
													<div class="inputs">
														<span class="input_wrapper">
															<input class="text" name="active_from" id='active_from' type="text" value="{$FILTER.item.active_from|date_format:'%d.%m.%Y'}"  validation="date required"/>
														</span>
														{if $errs.active_from}<div class="row"><label>&nbsp;</label><span class="system negative">{$errs.active_from}</span></div>{/if}
													</div>
												</div>
												<div class="row">
													<label>Промоция до:</label>
													<div class="inputs">
														<span class="input_wrapper">
															<input class="text" name="active_till" id='active_till' type="text" value="{$FILTER.item.active_till|date_format:'%d.%m.%Y'}"  validation="date required"/>
														</span>
														{if $errs.active_till}<div class="row"><label>&nbsp;</label><span class="system negative">{$errs.active_till}</span></div>{/if}
													</div>
												</div>
												<div class="row">
													<label>Настояща цена:</label>
													<div class="inputs">
														<span class="input_wrapper blank"><input type="text" value="{$FILTER.real_price}" name="real_price" id='act_price'></span>лв.  {if $FILTER.product.price2}(над 5 бут. - <b>{$FILTER.product.price2}</b>лв.){/if}
													</div>
												</div>
												<div>
													<label>&nbsp;</label>
													<div class="inputs">
														<span class=""><b>Попълнете:</b> <noscript><br/>(полетата ще се изчисляват автоматично ако включите JavaScript на браузер-а ви)</noscript></span>
													</div>
												</div>
												<div class="row">
													<label style="font-weight:normal;">Промоция %:</label>
													<div class="inputs">
														<span class="input_wrapper">
															<input class="text" name="disc_perc" id='disc_perc' type="text" value="{$FILTER.item.disc_perc}"  validation="percent" onkeyup="calcDiscPrice(this);" onblur="calcDiscPrice(this);"/>
														</span>
													</div>
												</div>
												<div class="row">
													<label>&nbsp;</label>
													<div class="inputs">
														<span class="input_wrapper blank"><b>или:</b></span>
													</div>
												</div>
												<div class="row">
													<label style="font-weight:normal;">Промоция цена:</label>
													<div class="inputs">
														<span class="input_wrapper">
															<input class="text" name="disc_price" id='disc_price' type="text" value="{$FILTER.item.disc_price}"  validation="decimal required" onkeyup="calcDiscPrice(this);" onblur="calcDiscPrice(this);"> 
														</span>лв.
													</div>
													{if $errs.disc_price}<div class="row"><label>&nbsp;</label><span class="system negative">{$errs.disc_price}</span></div>{/if}
												</div>
												<div class="row">
													<div class="buttons">
														<ul>
															<li><span class="button send_form_btn"><span><span>ЗАПИШИ</span></span><input name="submit" type="submit" /></span></li>
															<li><span class="button cancel_btn"><a href="promotions.php{query_str mode=null id=null prod_id=null}"><span><span>ОТКАЖИ</span></span></a></span></li>
														</ul>
													</div>
													
												</div>
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
			    var myForm = $("#prom_frm");
			    myForm.validation();
			});
			
			function setPrice(item) {
				var priceSpan = document.getElementById('act_price');
				var val = item.value.replace(/^[0-9]+-/g,'');
				priceSpan.value = val;
			}
			
			function calcDiscPrice(item) {
				var priceSpan = document.getElementById('act_price');	
				var price = priceSpan.value;
				var discPriceInp = document.getElementById('disc_price');
				var discPercInp = document.getElementById('disc_perc');
				
				if(!discPriceInp.value && !discPercInp.value) return;
				
				if(item.id=='disc_perc') {
					var disc_percent =  Number(item.value);	
					discPriceInp.value = Math.round((price*((100-disc_percent)/100))*100)/100;
				} else if(item.id=='disc_price') {
					var disc_price =  Number(item.value);	
					val = Math.round(((price-disc_price)*100/price)*100)/100;
					discPercInp.value = (val==-Infinity ? 0 : val);
				} else {
					var disc_price =  Number(discPriceInp.value);
					val = Math.round(((price-disc_price)*100/price)*100)/100;
					discPercInp.value = (val==-Infinity ? 0 : val);
				}
			}
			
			new Calendar({
				inputField: "active_till",
				dateFormat: "%d.%m.%Y",
				trigger: "active_till",
				bottomBar: false,
			}); 
			new Calendar({
				inputField: "active_from",
				dateFormat: "%d.%m.%Y",
				trigger: "active_from",
				bottomBar: false,
			}); 
			{/literal}
		</script>
	{/if}
</div>
{include file="templates/footer.tpl"}