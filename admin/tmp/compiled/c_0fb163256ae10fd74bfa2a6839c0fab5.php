<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 14:11:29 EEST */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("templates/header.tpl", array('login' => true));
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  if ($this->_vars['errs']['email']): ?>
<div class="error">
	<div class="error_inner">
		<strong>Грешка</strong> | <span><label for="email"><?php echo $this->_vars['errs']['email']; ?>
</label></span>
	</div>
</div>
<?php endif;  if ($this->_vars['errs']['pass']): ?>
<div class="error">
	<div class="error_inner">
		<strong>Грешка</strong> | <span><label for="pass"><?php echo $this->_vars['errs']['pass']; ?>
</label></span>
	</div>
</div>
<?php endif;  if ($this->_vars['errs']['login']): ?>
<div class="error">
	<div class="error_inner">
		<strong>Нямате достъп</strong> | <span><?php echo $this->_vars['errs']['login']; ?>
</span>
	</div>
</div>
<?php endif; ?>

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
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("templates/footer.tpl", array('login' => true));
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>