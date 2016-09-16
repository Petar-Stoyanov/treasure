{include file="templates/header.tpl"
	css1="css/noms.css"
	css2="js/jscalendar/css/jscal2.css"
	js1="js/jquery.validation.js"
	js2="js/jscalendar/js/jscal2.js"
	js3="js/jscalendar/js/lang/en.js"}
<div class="inner">
	
{if !in($FILTER.mode,'edit','view')}
	{capture name=back_url}{query_str full_request_uri=true}{/capture}
	<!--[if !IE]>start section<![endif]-->	
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			{if isset($templatelite.get.p)}{assign var=t value="`$FILTER.type`_`$templatelite.get.p`"}{else}{assign var=t value="`$FILTER.type`_0"}{/if}
			<h2>{$side_menu[$t].title}</h2>
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
									<table cellpadding="0" cellspacing="0" width="100%" >
										<tbody><tr>
											<th>ID</th>
											<th>{sorter_link sort_id=2 title='Потребител'}</th>
											<th>Email</th>
											<th>{sorter_link sort_id=3 title='Тотал'}</th>
											<th>{sorter_link sort_id=5 title='Направена&nbsp;на'}</th>
											<th title="Начин на плащане">Плащане</th>
											<th title="Платена?">{sorter_link sort_id=9 title='П'}</th>
											
											<th>Действия</th>
										</tr>
										
										{if $FILTER.list}
											{assign var=counter value=0}
											{foreach from=$FILTER.list item=item}
												<tr class="{if $counter%2}second{else}first{/if}">
													<td style="width: 16px;">{$item.id}</td>
													<td>{strip}
														<a href="{query_str mode='view' id=$item.id}&back_url={$templatelite.capture.back_url|escape:'url'}" class="product_name">{$item.name}</a>
														<a href="users.php?mode=edit&id={$item.user_id}" target="_blank">&nbsp;&nbsp;
															<img src='css/layout/site/tables/edit_action.gif' title="Виж данни за потребител" style="border:0">
														</a>
														{/strip}
													</td>
													<td><a href="mailto:{$item.email}" class="product_name">{$item.email}</a></td>
													<td><a href="{query_str mode='view' id=$item.id}&back_url={$templatelite.capture.back_url|escape:'url'}" class="product_name">{$item.total}</a></td>
													<td><a href="{query_str mode='view' id=$item.id}&back_url={$templatelite.capture.back_url|escape:'url'}" class="product_name">{$item.created_at}</a></td>
													<td>
														{if $item.payment_method_id==1}Наложен платеж
														{elseif $item.payment_method_id==2}Банков път
														{/if}
													</td>
													<td>
														{if $item.paid==1}<b>ДА</b>{else}<font color="red">НЕ</font>{/if}
													</td>
													
													<td style="width: 120px;">
														<div>
															<a href="{query_str mode='view' id=$item.id}&back_url={$templatelite.capture.back_url|escape:'url'}">Виж</a> |
															<a href="{query_str mode='edit' id=$item.id}&back_url={$templatelite.capture.back_url|escape:'url'}">Редактирай</a>
														</div>
													</td>
												</tr>
												{math equation='x+1' x=$counter assign=counter}
											{/foreach}
										{else}
											<tr class="first">
												<td colspan="8">Няма данни</td>
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
		</div>
		<!--[if !IE]>end section content<![endif]-->
	</div>
	<!--[if !IE]>end section<![endif]-->	
	
{else}
		<!--[if !IE]>start section<![endif]-->	
		<div class="section">
			<!--[if !IE]>start title wrapper<![endif]-->
			<div class="title_wrapper">
				<h2>Преглед/редакция на поръчка - ID: {$FILTER.id}, потребител: {$FILTER.order.user}</h2>
				<h2 style="float:right;"><a target="_blank" href="pdf.php?orderId={$FILTER.id}" style="color:#fff;">Разпечатай</a></h2>
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
							{if $FILTER.mode == 'edit'}
								<form class="search_form general_form" name='order_frm' id='order_frm' method="POST">
								<input type="hidden" name='mode' value="save"/>
								<input type="hidden" name='back_url' value="{$FILTER.back_url}"/>
								<input type="hidden" name="id" id="id" value="{$FILTER.id}"/>
							{else}
								<div class="general_form">
							{/if}
									<fieldset>
										<!--[if !IE]>start fieldset<![endif]-->
											<div class="row">
											 	<label>Метод на плащане:</label>
											 	<span>
												 	<select name="payment_method_id" {if $FILTER.mode == 'view'}disabled{/if}>
												 		<option value="1" {if $FILTER.order.payment_method_id==1}selected{/if}>В брой</option>
												 		<option value="2" {if $FILTER.order.payment_method_id==2}selected{/if}>Банков път</option>
												 	</select>
												 </span>
											 </div>
											 <div class="row">
											 	<label>Доставка на адрес:</label>
											 	<span>
											 		<select name="address_id" {if $FILTER.mode == 'view'}disabled{/if}>
											 		{foreach from=$FILTER.addresses item=item key=key}
											 			<option value="{$key}" {if $FILTER.order.address_id == $key}selected{/if}>{$item.address}</option>
											 		{/foreach}
											 		</select>
											 	</span>
											 </div>
											 {if $FILTER.notes && $FILTER.mode == 'view'}
												  <div class="row">
													<label>Допълнителни бележки към поръчката:</label>
													<span>
														<textarea rows="4" cols="50" name="notes" readonly>{$FILTER.notes}</textarea>
													</span>
												 </div>
											 {/if}
											  <div class="row">
											 	<label>Статус:</label>
											 	<span>
											 		<select name="status" {if $FILTER.mode == 'view'}disabled{/if} onchange="showDateField(this);">
											 			<option value="1" {if $FILTER.order.status == 1}selected{/if}>Чакаща</option>
											 			<option value="2" {if $FILTER.order.status == 2}selected{/if}>Изпратена</option>
											 			<option value="3" {if $FILTER.order.status == 3}selected{/if}>Доставена</option>
											 			<option value="4" {if $FILTER.order.status == 4}selected{/if}>Приключена</option>
											 			<option value="5" {if $FILTER.order.status == 5}selected{/if}>Отказана</option>
											 		</select>
											 	</span>
												 	<span style="float:right;{if !in($FILTER.order.status,2,4)}display:none{/if}" id='planned'>
													 	<label>Планирана доставка:</label>
												 		<div class="inputs">
												 			<span class="input_wrapper short">
												 				{if $FILTER.mode=='edit'}
																	<input class="text" name="delivery_date" id='delivery_date' type="text" value="{$FILTER.order.delivery_date|date_format:'%d.%m.%Y'}" {if $FILTER.order.status == 2}validation="required date"{/if}//>
																{else}
																	{$FILTER.order.delivery_date|date_format:'%d.%m.%Y'}
																{/if}
															</span>
												 		</div>
												 	</span>
												 	<span style="float:right;{if !in($FILTER.order.status,3,4)}display:none{/if}" id='delivered'>
													 	<label>Дата доставка:</label>
												 		<div class="inputs">
												 			<span class="input_wrapper short">
																{if $FILTER.mode=='edit'}
																	<input class="text" name="delivered_date" id='delivered_date' type="text" value="{$FILTER.order.delivered_date|date_format:'%d.%m.%Y'}" {if $FILTER.order.status == 3}validation="required date"{/if}/>
																{else}
																	{$FILTER.order.delivered_date|date_format:'%d.%m.%Y'}
																{/if}
															</span>
												 		</div>
												 	</span>
											 </div>
											 <div class="row">
											 	<label>Платена:</label>
											 	<span>
											 		<input type="checkbox" value="1" name="paid" {if $FILTER.order.paid}checked{/if} {if $FILTER.mode == 'view'}disabled{/if}>
											 	</span>
											 	{if $FILTER.mode == 'view' and !$FILTER.order.paid }
											 		<span><a href="?mode=view&id={$FILTER.id}&act=setpaid">Маркирай платена</a> </span>
											 	{/if}
											 </div>
											 <div class="row line"><b>Продукти:</b></div>
											 <div class="row">
											<!--[if !IE]>start forms<![endif]-->
												<div id="forms">
													<div class="table_wrapper">
														<div class="table_wrapper_inner">
														<table cellpadding="0" cellspacing="0" width="100%" class="detail" style="border:1px solid #D3E5ED">
															<tbody><tr>
																<th>ID</th>
																<th width="1px"></th>
																<th>Име</th>
																<th>Арт.ном.</th>
																<th>Цена</th>
																<th>Цена с отстъпка</th>
																<th>Цена кампания</th>
																<th>Количество</th>
															</tr>
															
															{if $FILTER.order.details}
																{assign var=counter value=0}
																{foreach from=$FILTER.order.details item=item}
																	<tr class="{if $counter%2}second{else}first{/if}">
																		<td style="width: 16px;">{$item.product_id}</td>
																		<td><img src="image.php?mode=file&name=img{$item.product_id}_thum1.jpg"></td>
																		<td valign="middle">
																			{$item.product_name}
																		</td>
																		<td>{$item.code}</td>
																		<td>{$item.price}&nbsp;лв.</td>
																		<td>{if $item.disc_price}{$item.disc_price}&nbsp;лв.{else}-/-{/if}</td>
																		<td>{if $item.campaign_price}{$item.campaign_price}&nbsp;лв.{else}-/-{/if}</td>
																		<td>
																			{if $FILTER.mode == 'edit'}
																				<input type="hidden" name="prev_qty[{$item.product_id}]" value="{$item.quantity}">
																				<input type="text" name="new_qty[{$item.product_id}]" value="{$item.quantity}" style="width: 40px; text-align: right"> бр.
																			{else}
																				<span><b>{$item.quantity}</b></span>
																			{/if}
																			<span><i>(&nbsp;x&nbsp;{$item.final_price} лв.)</i></span>
																		</td>
																	</tr>
																	{math equation='x+1' x=$counter assign=counter}
																{/foreach}
															{else}
																<tr class="first">
																	<td colspan="8">Няма данни</td>
																</tr>
															{/if}
														</tbody></table>
														</div>
													</div>		
												</div>
											</div>
											{if $FILTER.mode == 'edit'}
												<div style="padding: 10px 0 20px 10px;">
													<a class="button add_new" href="products.php?type=1&id={$FILTER.id}&act=sel&return_to=ord"><span><span>Добави продукт</span></span></a>
												</div>
												<p>&nbsp;</p>
											{/if}
											{if $FILTER.is_camp_applied}
												{assign var=cid value=$FILTER.is_camp_applied}
												<div class="row">
													{if $campaigns[$cid].for_firstorder}
														<label>Приложена кампания за първа поръчка:</label>
														<div class="inputs">
															<span>
																<b>кампания {$campaigns[$cid].name}</b>
															</span>
														</div>
													{else}
														<label>Отстъпка кампания:</label>
														
														<div class="inputs">
															<span>
																<b>- {$FILTER.promo_disc_ttl}&nbsp;лв.</b>
															 ({$campaigns[$cid].discount}% от кампания {$campaigns[$cid].name})
															</span>
														</div>
													{/if}
											{/if}
											<div class="row">
											 	<label>Отстъпка:</label>
										 		<div class="inputs">
											 		{if $FILTER.mode == 'edit'}
											 			<span class="input_wrapper blank"><input type="text" value="{$FILTER.order.discount}" name="discount" validation="percent">&nbsp;%</span>
										 			{else}
										 				<span><b>{$FILTER.order.discount}&nbsp;%</b></span>
										 			{/if}
										 		</div>
											 </div>
											 <div class="row">
											 	<label>Доставка:</label>
										 		<span><b>{$FILTER.order.delivery_price}&nbsp;лв.</b></span>
											 </div>
											<div class="row line"></div>
											<div class="row">
											 	<label>Общо:</label>
										 		<span><b>{$FILTER.order.total}&nbsp;лв.</b></span>
											 </div>
											<!--[if !IE]>end forms<![endif]-->
										
							{if $FILTER.mode == 'edit'}
											<div class="row">
												<div class="buttons">
													<ul>
														<li><span class="button send_form_btn"><span><span>ЗАПИШИ</span></span><input name="submit" type="submit" /></span></li>
														<li><span class="button cancel_btn"><a href="{$FILTER.back_url}"><span><span>ОТКАЖИ</span></span></a></span></li>
													</ul>
												</div>
											</div>
									</fieldset>
								</form>
							{else}
								
									<div class="row">&nbsp;</div>
										<div class="row">
											<table id="actions">
												<tr>
													{if !in($FILTER.type,4,5)}
														<td align="center" valign="top">Маркирай като:&nbsp;</td>
														{if $FILTER.type==1}
															<td align="center">
																<form method="POST" id="order_frm">
																	<input type="hidden" name="mode" value="view">
																	<input type="hidden" name="id" value="{$FILTER.id}">
																	<input type="hidden" name="act" value="shi">
																	<input type="submit" class="link" name="send" value="Изпратена"><br>
																	(<input class="text small" name="delivery_date" id='delivery_date' type="text" value="{if $FILTER.order.delivery_date}{$FILTER.order.delivery_date|date_format:'%d.%m.%Y'}{else}Дата за доставка{/if}"  validation="date required"/>)
																</form>
															</td>
															<td align="center" valign="top">
																<span style="margin: 0 12px 0 0;">|</span><a href="?mode=view&id={$FILTER.id}&act=rej">Отказана</a>
															</td>
														{elseif $FILTER.type==2}
															<td align="center">
																<form method="POST" id="order_frm">
																	<input type="hidden" name="mode" value="view">
																	<input type="hidden" name="id" value="{$FILTER.id}">
																	<input type="hidden" name="act" value="del">
																	<input type="submit" class="link" name="send" value="Доставена"><br>
																	(<input class="text small" name="delivered_date" id='delivered_date' type="text" value="{if $FILTER.order.delivered_date}{$FILTER.order.delivered_date|date_format:'%d.%m.%Y'}{else}Дата на доставка{/if}"  validation="date required"/>)
																</form>
															</td>
															<td align="center" valign="top">
																<span style="margin: 0 12px 0 0;">|</span><a href="?mode=view&id={$FILTER.id}&act=rej">Отказана</a>
															</td>
														{elseif $FILTER.type==3}
															<td align="center" valign="top">
																<a href="?mode=view&id={$FILTER.id}&act=clo">Приключена</a>
															</td>
														{/if}
														<td valign="top">
															<span style="margin: 0 12px;"> или </span>
													{/if}
														<a href="orders.php{query_str mode=edit}">Редактирай</a>
													</td>
												</tr>
											</table>
										</div>
									</fieldset>
								</div>
							{/if}
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
			{if $FILTER.mode == 'edit' || in($FILTER.type,1,2)}
				{literal}
				$(function(){ // jQuery DOM ready function. 
				    var myForm = $("#order_frm");
				    myForm.validation();
				});
				function showDateField(type) {
				
					if(type.value==2) {
						$("#planned").css('display', 'block');
						$("#delivery_date").attr('validation', 'required date');
						
						$("#delivered").css('display', 'none');
						$("#delivered_date").removeAttr('validation');
					} else if (type.value==3) {
						$("#delivered").css('display', 'block');
						$("#delivered_date").attr('validation', 'required date');
						
						$("#planned").css('display', 'none');
						$("#delivery_date").removeAttr('validation');
					} else {
						$("#delivered").css('display', 'none');
						$("#delivered_date").removeAttr('validation');
						$("#planned").css('display', 'none');
						$("#delivery_date").removeAttr('validation');
					}
			    	$("#order_frm").validation();
	
				};
				{/literal}
			{/if}
			{if ($FILTER.mode=='edit' && in($FILTER.type,1,2,3,4)) || ($FILTER.mode=='view' && $FILTER.type==1)}
				{literal}
					new Calendar({
						inputField: "delivery_date",
						dateFormat: "%d.%m.%Y",
						trigger: "delivery_date",
						bottomBar: false,
					});
				{/literal}
			{/if}
			{if ($FILTER.mode=='edit' && in($FILTER.type,1,2,3,4)) || ($FILTER.mode=='view' && $FILTER.type==2)}
				{literal}
					new Calendar({
						inputField: "delivered_date",
						dateFormat: "%d.%m.%Y",
						trigger: "delivered_date",
						bottomBar: false,
					});
				{/literal}
			{/if}
		</script>
{/if}
</div>
{include file="templates/footer.tpl"}