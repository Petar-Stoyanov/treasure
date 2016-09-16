{include file="templates/header.tpl"
	css1="css/library.css"
	js1="js/ckeditor/ckeditor.js"
	js2="js/ckeditor/adapters/jquery.js"
	js3="js/jquery.validation.js"
}
<div class="innerFull">
	{capture name=back_url}{query_str full_request_uri=true}{/capture}
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Архиви на база данни</h2>
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
													<th class="left" align="left">Файл</th>
													<th style="width: 120px;">Операции</th>
												</tr>
											</thead>
											{if $files}
												{foreach from=$files item=file name=list}					
													<tr onmouseover="this.className='hoverTr';" onmouseout="this.className='';">
														<td>{$file}</td>
														<td width="1" style="width: 120px;">
																<div class="actions_menu">
																	<ul>
																		<li>
																			<a class="edit" href="?mode=download&file={$file}&back_url={$templatelite.capture.back_url|escape:url}">изтегли</a>
																		</li>
																		<li>
																			<a class="delete" href="?mode=del&file={$file}&back_url={$templatelite.capture.back_url|escape:url}" onclick="return confirm_del('Сигурни ли сте, че искате да изтриете този архив?');">изтрий</a>
																		</li>
																	</ul>
																</div>
															</td>
													</tr>
												{/foreach}
											{else}
												<tr>
													<td class="names" colspan="2">Системата още няма архиви на базата данни</td>
												</tr>
											{/if}
										</table>
									</div>
								</div>
								<!--[if !IE]>end table_wrapper<![endif]-->
								</div>
								<!--[if !IE]>start pagination<![endif]-->
								{if $syncs}{$pager}{/if}
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
		</div>
		<!--[if !IE]>end section content<![endif]-->
	</div>
	<script type="text/javascript">
	{literal}
		function confirm_del(msg) {
			var res = confirm(msg);
			if(res) {
				document.getElementById('syncA').className = 'loading';
				document.getElementById('syncA').style.backgroundPosition = 'center 25px';
			}
			return res;
		}
	{/literal}
	</script>
</div>
{include file="templates/footer.tpl"}