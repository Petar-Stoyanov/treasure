{include file="templates/header.tpl"
	js1="js/jquery.validation.js"
}
<div class="inner{if not $side_menu}Full{/if}">
	<!--[if !IE]>start section<![endif]-->	
	<div class="section table_section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Административни потребители</h2>
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
												<th>Действия</th>
											</tr>
										</thead>
										{if $FILTER.adminusers}
											<tbody>
											{assign var=counter value=0}
											{foreach from=$FILTER.adminusers item=item}
												<tr class={if $counter%2}"second"{else}"first"{/if}>
													<td><a href="{query_str mode=edit id=$item.id}" class="product_name">{$item.email}</a></td>
													<td><a href="{query_str mode=edit id=$item.id}" class="product_name">{$item.name}</a></td>
													<td style="width: 120px;">
														<div class="actions_menu">
															<ul>
																<li><a class="edit" href="{query_str mode=edit id=$item.id}">Edit</a></li>
																{if $templatelite.SESSION.user.id!=$item.id}<li><a class="delete" id="del{$item.id}" href="{query_str mode=del id=$item.id}" onclick="return confirm_del('Сигурни ли сте, че искате да изтриете този потребител?');">Delete</a></li>{/if}
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
								{if $FILTER.adminusers}{$FILTER.pager}{/if}
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
	
	{if $FILTER.mode eq 'edit'}
		<!--[if !IE]>start section<![endif]-->	
		<div class="section">
			<!--[if !IE]>start title wrapper<![endif]-->
			<div class="title_wrapper">
				<h2>{if $FILTER.id<0}Добави{else}Редактирай{/if} административен потребител</h2>
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
												<div class="row">
													<label>Име:</label>
													<div class="inputs">
														<span class="input_wrapper"><input class="text" name="name" id="name" type="text" value="{$FILTER.name}" validation="required"/></span>
														{if $errs.name}<span class="system negative">{$errs.name}</span>{/if}
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
												<!--[if !IE]>end row<![endif]-->
												<!--[if !IE]>start row<![endif]-->
												<div class="row">
													<div class="buttons">
														<ul>
															<li><span class="button send_form_btn"><span><span>Запази</span></span><input name="" type="submit" /></span></li>
															<li><span class="button cancel_btn"><a href="users.php{query_str id=null mode=null}"><span><span>CANCEL</span></span></a></span></li>
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