{include file="templates/header.tpl" login=true}
{if $errs.email}
<div class="error">
	<div class="error_inner">
		<strong>Грешка</strong> | <span><label for="email">{$errs.email}</label></span>
	</div>
</div>
{/if}
{if $errs.pass}
<div class="error">
	<div class="error_inner">
		<strong>Грешка</strong> | <span><label for="pass">{$errs.pass}</label></span>
	</div>
</div>
{/if}
{if $errs.login}
<div class="error">
	<div class="error_inner">
		<strong>Нямате достъп</strong> | <span>{$errs.login}</span>
	</div>
</div>
{/if}

<!--[if !IE]>start login<![endif]-->
<form method="POST" enctype="multipart/form-data">
	<fieldset>
		<h1 id="logo"><a href="#">Apollowine.com Административен панел</a></h1>
		<div class="formular">
			<div class="formular_inner">
			<label>
				<strong>Email:</strong>
				<span class="input_wrapper">
					<input name="email" type="text" id="email" />
				</span>
			</label>
			<label>
				<strong>Парола:</strong>
				<span class="input_wrapper">
					<input name="pass" type="password" id='pass' />
				</span>
			</label>
			<ul class="form_menu">
				<li><span class="button"><span><span>Вход</span></span><input type="submit" name=""/></span></li>
				<li><a href="#"><span><span>Забравена парола</span></span></a></li>
			</ul>
			
			</div>
		</div>
	</fieldset>
</form>
<!--[if !IE]>end login<![endif]-->
{include file="templates/footer.tpl" login=true}