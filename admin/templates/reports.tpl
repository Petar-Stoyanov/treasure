{include file="templates/header.tpl"
	css1="css/noms.css"}
<div class="inner">
	
	{capture name=back_url}reports.php{query_str}{/capture}
	<!--[if !IE]>start section<![endif]-->	
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Справки{if empty($FILTER.mode)} - Отворени продукти{/if}</h2>
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
											<th>{sorter_link sort_id=1 title='ID'}</th>
											<th>{sorter_link sort_id=2 title='Име'}</th>
											<th>{sorter_link sort_id=3 title='Тип'}</th>
											<th>{sorter_link sort_id=4 title='Арт.№'}</th>
											
											<th>{sorter_link sort_id=5 title='Цена'}</th>
											<th>{sorter_link sort_id=6 title='Цена 2'}</th>
										</tr>
										
										{if $FILTER.data}
											{assign var=counter value=0}
											{foreach from=$FILTER.data item=item}
												<tr class="{if $counter%2}second{else}first{/if}">
													<td style="width: 16px;">{$item.id}</td>
													<td><a href="products.php?mode=edit&type=1&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}" class="product_name">{$item.name}</a></td>
													<td><a href="products.php?mode=edit&type=1&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}" class="product_name">{$item.type}</a></td>
													<td><a href="products.php?mode=edit&type=1&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}" class="product_name">{$item.code}</a></td>
													<td><a href="products.php?mode=edit&type=1&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}" class="product_name">{$item.price1}&nbsp;лв.</a></td>
													<td><a href="products.php?mode=edit&type=1&id={$item.id}&back_url={$templatelite.capture.back_url|escape:url}" class="product_name">{$item.price2}&nbsp;лв.</a></td>
												</tr>
												{math equation='x+1' x=$counter assign=counter}
											{/foreach}
										{else}
											<tr class="first">
												<td colspan="6">Няма намерени резултати</td>
											</tr>
										{/if}
									</tbody></table>
									</div>
								</div>
								<!--[if !IE]>end table_wrapper<![endif]-->
								</div>
								<!--[if !IE]>start pagination<![endif]-->
								{if $FILTER.data}{$FILTER.pager}{/if}
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
	
</div>
{include file="templates/footer.tpl"}