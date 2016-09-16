{include file="templates/header.tpl"
	js1="js/jquery.validation.js"
	css1="css/users.css"
}
<div class="inner{if not $side_menu}Full{/if}">
	{if $FILTER.mode neq 'edit'}
		{capture name=back_url}{query_str full_request_uri=true}{/capture}
		<!--[if !IE]>start section<![endif]-->	
		<div class="section table_section">
			<!--[if !IE]>start title wrapper<![endif]-->
			<div class="title_wrapper">
				<h2>Потребители</h2>
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
										<table cellpadding="0" cellspacing="0" width="100%" id="userTbl">
											<thead>
												<tr>
													<th>{sorter_link sort_id=2 title='Email'}</th>
													<th>{sorter_link sort_id=3 title='Потребител'}</th>
													<th>Тип потребител</th>
													<th>Действия</th>
												</tr>
											</thead>
											{if $FILTER.users}
												<tbody>
												{assign var=counter value=0}
												{foreach from=$FILTER.users item=item}
													{assign var=usrt value=$item.user_type_id}
													<tr class="{if $counter%2}second{else}first{/if}{if $item.deleted} hidden{/if}">
														<td><a href="{query_str mode=edit id=$item.id page=null}&back_url={$templatelite.capture.back_url|escape:url}" class="product_name">{$item.email}</a></td>
														<td><a href="{query_str mode=edit id=$item.id page=null}&back_url={$templatelite.capture.back_url|escape:url}" class="product_name">{$item.name}</a></td>
														<td>{$user_types[$usrt].name}</td>
														<td style="width: 120px;">
															<div class="actions_menu">
																<ul>
																	<li><a class="edit" href="{query_str mode=edit id=$item.id page=null}&back_url={$templatelite.capture.back_url|escape:url}">Edit</a></li>
																	{if $item.deleted}
																		<a href="?mode=undel&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}">Activate</a>
																	{else}
																		<a id="del{$item.id}" href="{query_str mode=del id=$item.id page=null}&back_url={$templatelite.capture.back_url|escape:url}" onclick="return confirm_del('Сигурни ли сте, че искате да деактивирате този потребител?');">Disable</a>
																	{/if}
																</ul>
															</div>
														</td>
													</tr>
													{math equation='x+1' x=$counter assign=counter}
												{/foreach}
												</tbody>
											{else}
												<tr class="first">
													<td colspan="3">Няма въведени данни</td>
												</tr>
											{/if}
										</tbody></table>
										</div>
									</div>
									<!--[if !IE]>end table_wrapper<![endif]-->
									</div>
									<!--[if !IE]>start pagination<![endif]-->
									{if $FILTER.users}{$FILTER.pager}{/if}
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
					<a class="button add_new" href="?mode=edit&id=-1"><span><span>ДОБАВИ</span></span></a>
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
				<h2>{if $FILTER.id<0}Добави{else}Редактирай{/if} потребител</h2>
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
									<form method="post" class="search_form general_form" id="userFrm">
										<input type="hidden" name="id" id="id" value="{$FILTER.id}"/>
										<!--[if !IE]>start fieldset<![endif]-->
										<fieldset>
											<!--[if !IE]>start forms<![endif]-->
											<div class="forms">
												<!--[if !IE]>start row<![endif]-->
												<div class="left">
													<div class="row">
														<label>Име:</label>
														<div class="inputs">
															<span class="input_wrapper"><input class="text" name="fname" id="fname" type="text" value="{$FILTER.fname}" validation="required"/></span>
															{if $errs.name}<span class="system negative">{$errs.fname}</span>{/if}
														</div>
													</div>
													<div class="row">
														<label>Фамилия:</label>
														<div class="inputs">
															<span class="input_wrapper"><input class="text" name="lname" id="lname" type="text" value="{$FILTER.lname}" validation="required"/></span>
															{if $errs.lname}<span class="system negative">{$errs.lname}</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->
													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Email:</label>
														<div class="inputs">
															<span class="input_wrapper"><input class="text" name="email" id="email" type="text" value="{$FILTER.email}" validation="required email"/></span>
															{if $errs.email}<span class="system negative">{$errs.email}</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->
													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Парола:</label>
														<div class="inputs">
															<span class="input_wrapper"><input class="text" name="pass" id="pass" type="password" {if $FILTER.id<0}validation="required"{/if}/></span>
															{if $errs.pass}<span class="system negative">{$errs.pass}</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->
													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Повтори паролата:</label>
														<div class="inputs">
															<span class="input_wrapper"><input class="text" name="pass2" id="pass2" type="password" {if $FILTER.id<0}validation="required"{/if}/></span>
															{if $errs.pass2}<span class="system negative">{$errs.pass2}</span>{/if}
														</div>
													</div>
													
													<div class="row">
														<label>Тип потребител:</label>
														<div class="inputs">
															<span class="input_wrapper blank">
																<select name="user_type_id">
																	<option value="">Изберете...</option>
																	{foreach from=$FILTER.user_types key=key value=val}
																		<option {if $FILTER.user_type_id == $key}selected{/if} value="{$key}">{$val.name}</option>
																	{/foreach}
																</select>
															</span>
														</div>
													</div>
													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>Номер на кл. карта:</label>
														<div class="inputs">
															<span class="input_wrapper"><input class="text" name="membercard_no" id="membercard_no" type="text" value="{$FILTER.membercard_no}"/></span>
															{if $errs.membercard_no}<span class="system negative">{$errs.membercard_no}</span>{/if}
														</div>
													</div>
													<!--[if !IE]>end row<![endif]-->
													<div class="row">
														<div class="buttons">
															<ul>
																<li><span class="button send_form_btn"><span><span>Запази</span></span><input name="" type="submit" /></span></li>
																<li><span class="button cancel_btn"><a href="users.php{query_str id=null mode=null}"><span><span>CANCEL</span></span></a></span></li>
															</ul>
														</div>
													</div>
												</div>
												<div class="right">
													{if $FILTER.photo}
														<div class="row">
															<label>Снимка:</label>
															<img src="{$FILTER.photo}">
														</div>
													{/if}
													{if $FILTER.created_at}
														<div class="row">
															<label>Създаден на:</label>
															<div class="inputs">
																<span class="input_wrapper blank">{$FILTER.created_at|date_format:"%d.%m.%Y"}</span>
															</div>
														</div>
													{/if}
													{if $FILTER.last_ip}
														<div class="row">
															<label>Последно IP:</label>
															<div class="inputs">
																<span class="input_wrapper blank">{$FILTER.last_ip}</span>
															</div>
														</div>
													{/if}
												</div>
												
												{if $FILTER.id > 0}
													<div class="row line">&nbsp;</div>
													<div class="row">
														<label>Адреси:</label>
														<div class="inputs" style="width:600px;">
															{if $FILTER.addresses}
																{assign var=cur_idx value=0}
																{foreach from=$FILTER.addresses item=address key=key}
																	{ math equation="(x + 1)" x=$cur_idx assign='cur_idx' }
																	<span class="blank{if $address.prime} heavy{/if}">
																		{$cur_idx})&nbsp;&nbsp;{$address.street}, {$address.zip}, {$address.city}, {$address.countryname}, тел. {$address.phone}
																	</span>
																		<span style="width: 30px">
																			<a href="address.php?id={$address.id}&user_id={$address.user_id}" title="редактирай"><img src="css/layout/site/tables/edit_action.gif" style="border:0"></a>
																			<a href="address.php?mode=del&id={$address.id}&user_id={$address.user_id}" title="изтрий"><img src="css/layout/site/tables/action4.gif" style="border:0"></a>
																		</span>
																	<br>

																{/foreach}
															{else}
																<span class="input_wrapper blank">Няма въведени</span>
															{/if}
														</div>
														<div class="row"><span class="button light_blue_btn"><span><span><a href="address.php?user_id={$FILTER.id}&id=-1" >Добави</a></span></span></span></div>
													</div>
													{if $FILTER.orders}
														<div class="row line">&nbsp;</div>
														<div class="row"><h3>История на поръчките</h3></div>
														<div class="row">
															<div class="table_wrapper">
																<div class="table_wrapper_inner">
																<table cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #D3E5ED">
																	<tbody><tr class="head">
																		<th>ID</th>
																		<th>Статус</th>
																		<th>Направена на</th>
																		<th>Тотал</th>
																		<th>Начин на плащане</th>
																		<th>Платена</th>
																		<th>&nbsp;</th>
																	</tr>
																	{assign var=grand_total value=0}
																	{assign var=counter value=0}
																	{foreach from=$FILTER.orders item=item}
																		<tr class="{if $counter%2}second{else}first{/if}">
																			<td>{$item.id}</td>
																			<td>{if $item.status == 1}Чакаща
																				{elseif $item.status == 2}Изпратена
																				{elseif $item.status == 3}Доставена
																				{elseif $item.status == 4}Приключена
																				{elseif $item.status == 5}Отказана
																				{/if}
																			</td>
																			<td>{$item.created_at}</td>
																			<td>{$item.total}&nbsp;лв.</td>
																			<td>
																				{if $item.payment_method_id == 1}Наложен платеж
																				{elseif $item.payment_method_id == 2}Банков път
																				{/if}
																			</td>
																			<td>{if $item.paid==1}ДА{else}НЕ{/if}</td>
																			<td style="width: 120px;">
																				<div class="actions_menu">
																					<ul>
																						<li>
																							<a class="" href="orders.php?type={$item.status}&p={$item.paid}&mode=view&id={$item.id}">Виж</a>
																						</li>
																					</ul>
																				</div>
																			</td>
																		</tr>
																		{math equation='x+1' x=$counter assign=counter}
																		{assign var=total value=$item.total}
																		{math equation='x+y' x=$grand_total y=$total assign=grand_total}
																	{/foreach}
																	<tr class="{if $counter%2}second{else}first{/if}">
																		<td colspan=3></td>
																		<td><b>{$grand_total}&nbsp;лв.</b></td>
																		<td colspan=3></td>
																	</tr>
																</tbody></table>
																<div>{$FILTER.pager}</div>
																</div>
															</div>
														</div>
													{/if}
												{/if}
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
		    var myForm = $("#userFrm");
		    myForm.validation();
		});
		{/literal}
</script>
	{/if}
</div>
<script type="text/javascript">
{literal}
function confirm_del(msg) {
	return confirm(msg);

}
{/literal}
</script>
{include file="templates/footer.tpl"}