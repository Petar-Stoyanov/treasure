{include file="templates/header.tpl"}
<div class="inner{if not $side_menu}Full{/if}">
	<!--[if !IE]>start section<![endif]-->	
	<div class="section">
		<!--[if !IE]>start title wrapper<![endif]-->
		{*
		<div class="title_wrapper">
			<h2>Бързи връзки</h2>
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
								<!--[if !IE]>start dashboard menu<![endif]-->
								<ul class="dashboard_menu">
									
									<li><a href="products.php?mode=edit&id=-1&type=1" class="d2"><span>Добави продукт</span></a></li>
									<li><a href="products.php?type=1&act=sel&return_to=prom" class="d3"><span>Добави промоция</span></a></li>
									<li><a href="library.php?mode=edit&type=news&id=-1" class="d4"><span>Добави новина</span></a></li>
									<li><a href="users.php" class="d1"><span>Потребители</span></a></li>
									<li><a href="orders.php?type=1&p=1" class="d14"><span>Чакащи платени поръчки ({$FILTER.waiting_p_cnt})</span></a></li>
									<li><a href="orders.php?type=1&p=0" class="d13"><span>Чакащи&nbsp;неплатени поръчки ({$FILTER.waiting_np_cnt})</span></a></li>
								
								</ul>
								<!--[if !IE]>end dashboard menu<![endif]-->
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
		*}
	</div>
	<!--[if !IE]>end section<![endif]-->
	
		{*
	<!--[if !IE]>start section<![endif]-->	
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Последни поръчки</h2>
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
								
								<form action="#">
								<fieldset>
								<!--[if !IE]>start table_wrapper<![endif]-->
								<div class="table_wrapper">
									<div class="table_wrapper_inner">
									<table cellpadding="0" cellspacing="0" width="100%">
										<tbody><tr>
											<th>ID</th>
											<th>Статус</th>
											<th>Направена на</th>
											<th>Тотал</th>
											<th>Начин на плащане</th>
											<th>Платена</th>
											<th>&nbsp;</th>
										</tr>
										{if $FILTER.orders}
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
											{/foreach}
										{else}
											<tr class="first">
												<td colspan="7">Няма чакащи поръчки</td>
											</tr>
										{/if}
									</tbody></table>
									</div>
								</div>
								<!--[if !IE]>end table_wrapper<![endif]-->
								</fieldset>
								</form>
								
								
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
	
	
	
	<!--[if !IE]>start section<![endif]-->	
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Изтичащи промоции</h2>
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
											
											<th>Действия</th>
										</tr>
										
										{if $FILTER.promotions}
											{assign var=counter value=0}
											{foreach from=$FILTER.promotions item=item}
												<tr class="{if $counter%2}second{else}first{/if}{if $item.hidden} hidden{/if}">
													<td style="width: 1px;">
														<img src="image.php?mode=file&name=img{$item.prod_id}_thum2.jpg" width="72" alt="снимка"/>	
													</td>
													<td><a href="promotions.php{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.name_bg}</a></td>
													<td><a href="promotions.php{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.active_from|date_format:"%d.%m.%Y"} - {$item.active_till|date_format:"%d.%m.%Y"}</a></td>
													<td><a href="promotions.php{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.disc_price} лв.</a></td>
													
													<td style="width: 120px;">
														<div class="actions_menu">
															<ul>
																
																<li><a class="edit" href="promotions.php{query_str mode='edit' id=$item.id prod_id=$item.prod_id}">Edit</a></li>
																<li>
																	{capture name=back_url} promotions.php{query_str} {/capture}
																	<a class="delete" href="promotions.php?mode=del&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}">Del</a>
																</li>
															</ul>
														</div>
													</td>
												</tr>
												{math equation='x+1' x=$counter assign=counter}
											{/foreach}
										{else}
											<tr class="first">
												<td colspan="5">Няма изтичащи промоции следващите 3 дни</td>
											</tr>
										{/if}
									</tbody></table>
									</div>
								</div>
								<!--[if !IE]>end table_wrapper<![endif]-->
								</div>
								<!--[if !IE]>start pagination<![endif]-->
								{if $FILTER.promotions}{$FILTER.pager}{/if}
								<!--[if !IE]>end pagination<![endif]-->
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
		
		</div>
		<!--[if !IE]>end section content<![endif]-->
	</div>
	
	<!--[if !IE]>start section<![endif]-->	
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Изтичащи групови промоции</h2>
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
											
											<th>Промоция</th>
											<th>{sorter_link sort_id=2 title='Промоция активна до:'}</th>
											<th>Промо цена</th>
											
											<th>Действия</th>
										</tr>
										
										{if $FILTER.group_promotions}
											{assign var=counter value=0}
											{foreach from=$FILTER.group_promotions item=item}
												<tr class="{if $counter%2}second{else}first{/if}{if $item.hidden} hidden{/if}">
													
													<td><a href="promotions.php{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.desctiption_bg}</a></td>
													<td><a href="promotions.php{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.active_from|date_format:"%d.%m.%Y"} - {$item.active_till|date_format:"%d.%m.%Y"}</a></td>
													<td><a href="promotions.php{query_str mode='edit' id=$item.id prod_id=$item.prod_id}" class="product_name">{$item.disc_price} лв.</a></td>
													
													<td style="width: 120px;">
														<div class="actions_menu">
															<ul>
																
																<li><a class="edit" href="promotions.php{query_str mode='edit' id=$item.id prod_id=$item.prod_id}">Edit</a></li>
																<li>
																	{capture name=back_url} promotions.php{query_str} {/capture}
																	<a class="delete" href="promotions.php?mode=del&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}">Del</a>
																</li>
															</ul>
														</div>
													</td>
												</tr>
												{math equation='x+1' x=$counter assign=counter}
											{/foreach}
										{else}
											<tr class="first">
												<td colspan="4">Няма изтичащи промоции следващите 3 дни</td>
											</tr>
										{/if}
									</tbody></table>
									</div>
								</div>
								<!--[if !IE]>end table_wrapper<![endif]-->
								</div>
								<!--[if !IE]>start pagination<![endif]-->
								{if $FILTER.promotions}{$FILTER.pager}{/if}
								<!--[if !IE]>end pagination<![endif]-->
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
		
		</div>
		<!--[if !IE]>end section content<![endif]-->
	</div>


	<!--[if !IE]>start section<![endif]-->	
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Изтичащи кампании</h2>
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
											<th>Име кампания</th>
											<th>Активна до:</th>
											<th>Отстъпка</th>
											
											<th>Действия</th>
										</tr>
										
										{if $FILTER.campaigns}
											{assign var=counter value=0}
											{foreach from=$FILTER.campaigns item=item}

													<td style="width: 120px;">
											<tr class="{if $counter%2}second{else}first{/if}{if $item.hidden} hidden{/if}">
        													<td style="width: 1px;">
        														&nbsp;
        													</td>
        													<td><a href="campaigns.php{query_str mode='edit' id=$item.id}" class="product_name">{$item.name}</a></td>
        													<td><a href="campaigns.php{query_str mode='edit' id=$item.id}" class="product_name">{$item.active_till|date_format:"%d.%m.%Y"}</a></td>
        													<td><a href="campaigns.php{query_str mode='edit' id=$item.id}" class="product_name">{$item.discount} %</a></td>
        													<div class="actions_menu">
															<ul>
																
																<li><a class="edit" href="{query_str mode='edit' id=$item.id prod_id=$item.prod_id}">Edit</a></li>
																<li>
																	{capture name=back_url} campaigns.php{query_str} {/capture}
																	<a class="delete" href="campaigns.php?mode=del&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}">Del</a>
																</li>
															</ul>
														</div>
													</td>
												</tr>
												{math equation='x+1' x=$counter assign=counter}
											{/foreach}
										{else}
											<tr class="first">
												<td colspan="5">Няма изтичащи кампании следващите 7 дни</td>
											</tr>
										{/if}
									</tbody></table>
									</div>
								</div>
								<!--[if !IE]>end table_wrapper<![endif]-->
								</div>
								<!--[if !IE]>start pagination<![endif]-->
								{if $FILTER.campaigns}{$FILTER.pager}{/if}
								<!--[if !IE]>end pagination<![endif]-->
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
			*}
		
		</div>
		<!--[if !IE]>end section content<![endif]-->
	</div>

	<!--[if !IE]>end section<![endif]-->
</div>
{include file="templates/footer.tpl"}