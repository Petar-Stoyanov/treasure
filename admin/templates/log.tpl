{include file="templates/header.tpl"}
<div class="innerFull">
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Системен лог</h2>
			<h2 style="float:right;"><a href="?mode=delall" style="color:#fff;">изтрий лога</a></h2>
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
											<thead>
												<tr>
													<th align="left">ID</th>
													<th class="first" align="left">Дата</th>
													<th align="left">Потребител</th>
													<th align="left">Адм.Потребител</th>
													<th align="left">Тип</th>
													<th align="left">Файл</th>
													<th align="left">Описание</th>
													<th>Операции</th>
												</tr>
											</thead>
											{if $logs}
												{foreach from=$logs item=log name=list}					
													<tr onmouseover="this.className='hoverTr';" onmouseout="this.className='';">
														<td>{$log.id}</td>
														<td>{$log.created_at|date_format:"%d.%m.%Y&nbsp;&nbsp;%H:%M"}</td>
														<td>{$log.username}</td>
														<td>{$log.admusername}</td>
														<td>{$log.type}</td>
														<td width="1">{$log.source}</td>
														<td width="100%">{$log.message}</td>
														<td width="1">
															<div class="actions_menu">
																<ul>
																	<li>
																		<a class="delete" href="?mode=del&id={$log.id}&back_url={$templatelite.capture.back_url|escape:url}">изтрий</a>
																	</li>
																</ul>
															</div>
														</td>
													</tr>
												{/foreach}
											{else}
												<tr>
													<td class="names" colspan="8">Няма системни лог записи в момента</td>
												</tr>
											{/if}
										</table>
									</div>
								</div>
								<!--[if !IE]>end table_wrapper<![endif]-->
								</div>
								<!--[if !IE]>start pagination<![endif]-->
								{if $logs}{$pager}{/if}
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
</div>
{include file="templates/footer.tpl"}