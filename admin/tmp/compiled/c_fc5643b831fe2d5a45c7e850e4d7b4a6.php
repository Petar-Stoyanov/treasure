<?php require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/function.query_str.php'); $this->register_function("query_str", "tpl_function_query_str");  require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 14:11:29 EEST */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $this->_vars['PAGE_TITLE']; ?>
</title>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<meta http-equiv="imagetoolbar" content="no" />
	<?php if (empty ( $this->_vars['login'] )): ?>
		<link media="screen" rel="stylesheet" type="text/css" href="css/admin.css"  />
		<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-ie.css" /><![endif]-->
	<?php else: ?>
		<link media="screen" rel="stylesheet" type="text/css" href="css/admin-login.css"  />
		<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-login-ie.css" /><![endif]-->	
	<?php endif; ?>
	<?php if ($this->_vars['css1']): ?><link href="<?php echo $this->_vars['css1']; ?>
" rel="stylesheet" type="text/css" /><?php endif; ?>
	<?php if ($this->_vars['css2']): ?><link href="<?php echo $this->_vars['css2']; ?>
" rel="stylesheet" type="text/css" /><?php endif; ?>
	<?php if ($this->_vars['css3']): ?><link href="<?php echo $this->_vars['css3']; ?>
" rel="stylesheet" type="text/css" /><?php endif; ?>
	<?php if ($this->_vars['css4']): ?><link href="<?php echo $this->_vars['css4']; ?>
" rel="stylesheet" type="text/css" /><?php endif; ?>
	<?php if ($this->_vars['css5']): ?><link href="<?php echo $this->_vars['css5']; ?>
" rel="stylesheet" type="text/css" /><?php endif; ?>
	<?php if ($this->_vars['css6']): ?><link href="<?php echo $this->_vars['css6']; ?>
" rel="stylesheet" type="text/css" /><?php endif; ?>
	<?php if ($this->_vars['css7']): ?><link href="<?php echo $this->_vars['css7']; ?>
" rel="stylesheet" type="text/css" /><?php endif; ?>
	<script type="text/javascript" src="js/css.js"></script>
	<script type="text/javascript" src="js/behaviour.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script> 
	<?php if ($this->_vars['js1']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js1']; ?>
"></script><?php endif; ?>
	<?php if ($this->_vars['js2']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js2']; ?>
"></script><?php endif; ?>
	<?php if ($this->_vars['js3']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js3']; ?>
"></script><?php endif; ?>
	<?php if ($this->_vars['js4']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js4']; ?>
"></script><?php endif; ?>
	<?php if ($this->_vars['js5']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js5']; ?>
"></script><?php endif; ?>
	<?php if ($this->_vars['js6']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js6']; ?>
"></script><?php endif; ?>
	<?php if ($this->_vars['js7']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js7']; ?>
"></script><?php endif; ?>
</head>
<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
	<?php if (! empty ( $this->_vars['login'] )): ?>
		<!--[if !IE]>start login wrapper<![endif]-->
		<div id="login_wrapper">
	<?php else: ?>
		<!--[if !IE]>start head<![endif]-->
		<div id="head">
			<!--[if !IE]>start logo and user details<![endif]-->
			<div id="logo_user_details">
				<h1 id="logo"><a href="/admin/">&nbsp;</a></h1>
				<h2 id="sublogo">Administration Panel</h2>
				<!--[if !IE]>start user details<![endif]-->
				<div id="user_details">
					<ul id="user_details_menu">
						<li><strong><?php echo $_SESSION['user']['name']; ?>
</strong></li>
						<li>
							<ul id="user_access">
								<li class="first"><a href="profile.php">Профил</a></li>
								<li class="last"><a href="logout.php">Изход</a></li>
							</ul>
						</li>
						
					</ul>
					<div id="server_details">
						<dl>
							<dt>Server time :</dt>
							<dd><?php echo $this->_run_modifier(time(), 'date_format', 'plugin', 1, "%H:%M"); ?>
</dd>
						</dl>
						<dl>
							<dt>Последно IP :</dt>
							<dd><?php echo $_SESSION['user']['last_ip']; ?>
</dd>
						</dl>
					</div>
					<!--[if !IE]>start search<![endif]-->
					<div id="search_wrapper">
						<form method="POST">
							<fieldset>
								<label>
									<input class="text" name="search" type="text" value="<?php echo $this->_vars['FILTER']['search']; ?>
"/>
								</label>
								<span class="go"><input name="" type="submit" /></span>
							</fieldset>
						</form>
						<ul id="search_wrapper_menu">
							<li class="first"><a href="filter.php<?php echo tpl_function_query_str(array('smode' => $this->_vars['smode']), $this);?>">Разширено търсене</a></li>
						</ul>
					</div>
				<!--[if !IE]>end search<![endif]-->
				</div>
				<!--[if !IE]>end user details<![endif]-->
			</div>
			<!--[if !IE]>end logo end user details<![endif]-->
			<!--[if !IE]>start menus_wrapper<![endif]-->
			<div id="menus_wrapper">
				<div id="main_menu">
					<ul>
						<li><a href="index.php" <?php if ($this->_vars['PAGE_ID'] == -1): ?>class="selected"<?php endif; ?>><span><span>Начало</span></span></a></li>
						<li><a href="orders.php?type=1&p=0" <?php if (in ( $this->_vars['PAGE_ID'] , -5 , -6 , -7 , -8 , -9 , -10 , -11 , -12 , -15 , -16 , -17 , -18 , -23 , -25 )): ?>class="selected"<?php endif; ?>><span><span>Магазин</span></span></a></li>
						<li><a href="library.php" <?php if ($this->_vars['PAGE_ID'] == -21): ?>class="selected"<?php endif; ?>><span><span>Сайт-съдържание</span></span></a></li>
						<li><a href="partners.php" <?php if (in ( $this->_vars['PAGE_ID'] , -13 , -14 )): ?>class="selected"<?php endif; ?>><span><span>Партньори</span></span></a></li>
						<li><a href="users.php"  <?php if (in ( $this->_vars['PAGE_ID'] , -4 , -26 )): ?>class="selected"<?php endif; ?>><span><span>Потребители</span></span></a></li>
						<li><a href="log.php"  <?php if ($this->_vars['PAGE_ID'] == -27): ?>class="selected"<?php endif; ?>><span><span>Системен лог</span></span></a></li>
						<li><a href="bulletin.php"  class="last<?php if ($this->_vars['PAGE_ID'] == -28): ?> selected<?php endif; ?>"><span><span>Бюлетин</span></span></a></li>
						<li><a href="archive.php"  class="last<?php if ($this->_vars['PAGE_ID'] == -30): ?> selected<?php endif; ?>"><span><span>Системно</span></span></a></li>
						<li><a href="galleries.php"  class="last<?php if ($this->_vars['PAGE_ID'] == -42): ?> selected<?php endif; ?>"><span><span>Галерии</span></span></a></li>
						<li><a href="reports.php"  class="last<?php if ($this->_vars['PAGE_ID'] == -41): ?> selected<?php endif; ?>"><span><span>Справки</span></span></a></li>
						
					</ul>
				</div>
				<div id="sec_menu">
					<ul>
						<?php if ($this->_vars['sub_menu']): ?>
							<?php if (count((array)$this->_vars['sub_menu'])): foreach ((array)$this->_vars['sub_menu'] as $this->_vars['id'] => $this->_vars['link']): ?>
								<?php if ($this->_vars['link']['popup']): ?>
									<li>
										<span class="drop"><span><span><a href="<?php echo $this->_vars['link']['href']; ?>
" class="sm8"><?php echo $this->_vars['link']['title']; ?>
</a></span></span></span>
										<ul>
										<?php if (count((array)$this->_vars['link']['menus'])): foreach ((array)$this->_vars['link']['menus'] as $this->_vars['sid'] => $this->_vars['slink']): ?>
											<li><a class="sm<?php echo $this->_vars['sid']; ?>
" href="<?php echo $this->_vars['slink']['href']; ?>
"><?php echo $this->_vars['slink']['title']; ?>
</a></li>
										<?php endforeach; endif; ?>
										</ul>
									</li>
								<?php else: ?>
									<li><a href="<?php echo $this->_vars['link']['href']; ?>
" class="<?php if ($this->_vars['link']['selected']): ?>selected<?php endif; ?>"><?php echo $this->_vars['link']['title']; ?>
</a></li>
								<?php endif; ?>
							<?php endforeach; endif; ?>
							
						<?php else: ?>
							<li>&nbsp;</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<!--[if !IE]>end menus_wrapper<![endif]-->
		</div>
		<!--[if !IE]>end head<![endif]-->
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			<!--[if !IE]>start page<![endif]-->
			<div id="page">
	<?php endif; ?>