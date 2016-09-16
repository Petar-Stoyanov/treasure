{include file="templates/header.tpl"
	css1="css/library.css"
	js1="js/jquery.validation.js"
}
<div class="innerFull">
	
	<!--[if !IE]>start section<![endif]-->	
	<div class="section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Редактирай системни настройки</h2>
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
								<form method="post" class="search_form general_form" id="SetFrm" enctype="multipart/form-data">
									<input type="hidden" name="id" id="id" value="{$settings.id}"/>
									<!--[if !IE]>start fieldset<![endif]-->
									<fieldset>
										<!--[if !IE]>start forms<![endif]-->
										<div class="forms">
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<label>Системен имейл:</label>
												<div class="inputs">
													<span class="input_wrapper"><input class="text" name="email" id="email" type="text" value="{$settings.email}" validation="required email"/></span>
													{if $errs.email}<span class="system negative">{$errs.email}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<label>ДДС (%):</label>
												<div class="inputs">
													<span class="input_wrapper"><input class="text" name="vat" id="vat" type="text" value="{$settings.vat}" validation="required"/></span>
													{if $errs.vat}<span class="system negative">{$errs.vat}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<label>Курс EUR:</label>
												<div class="inputs">
													<span class="input_wrapper"><input class="text" name="eur" id="eur" type="text" value="{$settings.eur}"/></span>
													{if $errs.eur}<span class="system negative">{$errs.eur}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<label>Курс USD:</label>
												<div class="inputs">
													<span class="input_wrapper"><input class="text" name="usd" id="usd" type="text" value="{$settings.usd}"/></span>
													{if $errs.usd}<span class="system negative">{$errs.usd}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<div class="buttons">
													<ul>
														<li><span class="button send_form_btn"><span><span>Запази</span></span><input name="" type="submit" /></span></li>
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
			var myForm = $("#SetFrm");
			myForm.validation();
		});
	{/literal}
	</script>
</div>
{include file="templates/footer.tpl"}