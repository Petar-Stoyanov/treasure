{include file="templates/header.tpl"
	css1="css/library.css"
	js1="js/ckeditor/ckeditor.js"
	js2="js/ckeditor/adapters/jquery.js"
	js3="js/jquery.validation.js"
}
<div class="innerFull">
	{capture name=back_url}{query_str full_request_uri=true}{/capture}
	<!--[if !IE]>start dashboard menu<![endif]-->
	<ul class="dashboard_menu" style="margin-bottom: 10px;">
		<li style="float: left;"><a href="{query_str mode=sync}" id="syncA" onclick="return confirm_del('Синхроннизация с Мистрал?');" class="d10"><span>Синхронизирай</span></a></li>
		{if $errs.sync}<li style="float: left; background: none; width: 50%;" ><span class="system negative" style="white-space: normal; padding: 0 18px 0; text-align: left;">{$errs.sync}</span></li>{/if}
	</ul>
	<!--[if !IE]>end dashboard menu<![endif]-->
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Синхронизация</h2>
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
													<th class="left" align="left">Синхронизация на</th>
													<th align="left">Брой</th>
												</tr>
											</thead>
											{if $syncs}
												{foreach from=$syncs item=sync name=list}					
													<tr {if $sync.cnt==0}class="redTr"{/if} onmouseover="this.className='hoverTr';" onmouseout="this.className='{if $sync.cnt==0}redTr{/if}';">
														<td>{$sync.id}</td>
														<td>{$sync.created_at|date_format:"%d.%m.%Y&nbsp;&nbsp;%H:%M"}</td>
														<td><a href="/admin/products.php?type=1&sort_id=-1">{$sync.cnt}</a></td>
													</tr>
												{/foreach}
											{else}
												<tr>
													<td class="names" colspan="7">Системата все още не е синхронизирана с мистрал</td>
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