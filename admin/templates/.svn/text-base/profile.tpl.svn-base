{include file="templates/header.tpl"
	js1="js/jquery.validation.js"
}
<div class="inner">
	<!--[if !IE]>start section<![endif]-->	
	<div class="section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Профил</h2>
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
								<form method="POST" class="search_form general_form" id="profileFrm">
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
													<span class="input_wrapper"><input class="text" name="pass" id="pass" type="password"/></span>
													{if $errs.pass}<span class="system negative">{$errs.pass}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<label>Повтори паролата:</label>
												<div class="inputs">
													<span class="input_wrapper"><input class="text" name="pass2" id="pass2" type="password"/></span>
													{if $errs.pass2}<span class="system negative">{$errs.pass2}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											
											<div class="row">
												<div class="buttons">
													<ul>
														<li><span class="button send_form_btn"><span><span>Запиши</span></span><input name="" type="submit" /></span></li>
														<li><span class="button cancel_btn"><a href="{query_str mode=null}"><span><span>Назад</span></span></a></span></li>
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
</div>
<script type="text/javascript"> {literal}
$(function(){ // jQuery DOM ready function. 
    var myForm = $("#profileFrm");
    myForm.validation();
});
{/literal}</script>
{include file="templates/footer.tpl"}