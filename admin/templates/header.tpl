<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Treasure</title>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<meta http-equiv="imagetoolbar" content="no" />
	{if empty($login)}
		<link media="screen" rel="stylesheet" type="text/css" href="css/admin.css"  />
		<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-ie.css" /><![endif]-->
	{else}
		<link media="screen" rel="stylesheet" type="text/css" href="css/admin-login.css"  />
		<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-login-ie.css" /><![endif]-->	
	{/if}
	{if $css1}<link href="{$css1}" rel="stylesheet" type="text/css" />{/if}
	{if $css2}<link href="{$css2}" rel="stylesheet" type="text/css" />{/if}
	{if $css3}<link href="{$css3}" rel="stylesheet" type="text/css" />{/if}
	{if $css4}<link href="{$css4}" rel="stylesheet" type="text/css" />{/if}
	{if $css5}<link href="{$css5}" rel="stylesheet" type="text/css" />{/if}
	{if $css6}<link href="{$css6}" rel="stylesheet" type="text/css" />{/if}
	{if $css7}<link href="{$css7}" rel="stylesheet" type="text/css" />{/if}
	<script type="text/javascript" src="js/css.js"></script>
	<script type="text/javascript" src="js/behaviour.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script> 
	{if $js1}<script language="javascript" type="text/javascript" src="{$js1}"></script>{/if}
	{if $js2}<script language="javascript" type="text/javascript" src="{$js2}"></script>{/if}
	{if $js3}<script language="javascript" type="text/javascript" src="{$js3}"></script>{/if}
	{if $js4}<script language="javascript" type="text/javascript" src="{$js4}"></script>{/if}
	{if $js5}<script language="javascript" type="text/javascript" src="{$js5}"></script>{/if}
	{if $js6}<script language="javascript" type="text/javascript" src="{$js6}"></script>{/if}
	{if $js7}<script language="javascript" type="text/javascript" src="{$js7}"></script>{/if}
</head>
<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
	{if !empty($login)}
		<!--[if !IE]>start login wrapper<![endif]-->
		<div id="login_wrapper">
	{else}
		<!--[if !IE]>start head<![endif]-->
		<div id="head">
			<!--[if !IE]>start logo and user details<![endif]-->
			<div id="logo_user_details">
				<h1 id="logo"><a href="/admin/">&nbsp;</a></h1>
				<h2 id="sublogo">Administration Panel</h2>
				<!--[if !IE]>start user details<![endif]-->
				<div id="user_details">
					<ul id="user_details_menu">
						<li><strong>{$templatelite.SESSION.user.name}</strong></li>
						<li>
							<ul id="user_access">
								<li class="first"><a href="profile.php">Профил</a></li>
								<li class="last"><a href="logout.php">Изход</a></li>
							</ul>
						</li>
						{*<li><a class="new_messages" href="#">4 new messages</a></li>*}
					</ul>
					<div id="server_details">
						<dl>
							<dt>Server time :</dt>
							<dd>{$templatelite.NOW|date_format:"%H:%M"}</dd>
						</dl>
						<dl>
							<dt>Последно IP :</dt>
							<dd>{$templatelite.SESSION.user.last_ip}</dd>
						</dl>
					</div>
					<!--[if !IE]>start search<![endif]-->
					<!--<div id="search_wrapper">
						<form method="POST">
							<fieldset>
								<label>
									<input class="text" name="search" type="text" value="{$FILTER.search}"/>
								</label>
								<span class="go"><input name="" type="submit" /></span>
							</fieldset>
						</form>
						<ul id="search_wrapper_menu">
							<li class="first"><a href="filter.php{query_str smode=$smode}">Разширено търсене</a></li>
						</ul>
					</div>-->
				<!--[if !IE]>end search<![endif]-->
				</div>
				<!--[if !IE]>end user details<![endif]-->
			</div>
			<!--[if !IE]>end logo end user details<![endif]-->
			<!--[if !IE]>start menus_wrapper<![endif]-->
			<div id="menus_wrapper">
				<div id="main_menu">
					<ul>
						<li><a href="nom_slider.php" {if $PAGE_ID eq -6}class="selected"{/if}><span><span>Banner</span></span></a></li>
						<li><a href="nom_object_types.php" {if $PAGE_ID eq -2}class="selected"{/if}><span><span>Object type</span></span></a></li>
						<li><a href="nom_historical_period.php" {if $PAGE_ID eq -3}class="selected"{/if}><span><span>Historical period</span></span></a></li>
						<li><a href="nom_area.php" {if $PAGE_ID eq -4}class="selected"{/if}><span><span>Region</span></span></a></li>
						<li><a href="related_places.php" {if $PAGE_ID eq -5}class="selected"{/if}><span><span>Related places</span></span></a></li>
						<li><a href="object.php" {if $PAGE_ID eq -7}class="selected"{/if}><span><span>Treasure</span></span></a></li>

						{*
						<li><a href="orders.php?type=1&p=0" {if in($PAGE_ID,-5,-6,-7,-8,-9,-10,-11,-12,-15,-16,-17,-18,-23,-25)}class="selected"{/if}><span><span>Магазин</span></span></a></li>
						<li><a href="partners.php" {if in($PAGE_ID,-13,-14)}class="selected"{/if}><span><span>Партньори</span></span></a></li>
						<li><a href="users.php"  {if in($PAGE_ID,-4,-26)}class="selected"{/if}><span><span>Потребители</span></span></a></li>
						<li><a href="log.php"  {if $PAGE_ID eq -27}class="selected"{/if}><span><span>Системен лог</span></span></a></li>
						<li><a href="bulletin.php"  class="last{if $PAGE_ID eq -28} selected{/if}"><span><span>Бюлетин</span></span></a></li>
						<li><a href="archive.php"  class="last{if $PAGE_ID eq -30} selected{/if}"><span><span>Системно</span></span></a></li>
						<li><a href="galleries.php"  class="last{if $PAGE_ID eq -42} selected{/if}"><span><span>Галерии</span></span></a></li>
						<li><a href="reports.php"  class="last{if $PAGE_ID eq -41} selected{/if}"><span><span>Справки</span></span></a></li>
						*}
					</ul>
				</div>
				<div id="sec_menu">
					<ul>
						{if $sub_menu}
							{foreach from=$sub_menu item=link key=id}
								{if $link.popup}
									<li>
										<span class="drop"><span><span><a href="{$link.href}" class="sm8">{$link.title}</a></span></span></span>
										<ul>
										{foreach from=$link.menus item=slink key=sid}
											<li><a class="sm{$sid}" href="{$slink.href}">{$slink.title}</a></li>
										{/foreach}
										</ul>
									</li>
								{else}
									<li><a href="{$link.href}" class="{if $link.selected}selected{/if}">{$link.title}</a></li>
								{/if}
							{/foreach}
							{*
							<li><a href="#" class="sm1">Security Settings</a></li>
							<li><a href="#" class="sm2">Chat and PMs</a></li>
							<li><a href="#" class="sm3">Search Options</a></li>
							<li><a href="#" class="sm4">Moderators</a></li>
							<li><a href="#" class="sm5">Upload Options</a></li>
							<li><a href="#" class="sm6">Download Options</a></li>
							<li><a href="#" class="sm7">Emails</a></li>
							<li>
								<span class="drop"><span><span><a href="#" class="sm8">More</a></span></span></span>
								<ul>
									<li><a class="sm6" href="#">Download options</a></li>
									<li><a class="sm4" href="#">Menu item</a></li>
									<li><a class="sm6" href="#">Download options</a></li>
									<li><a class="sm6" href="#">Download options</a></li>
									<li><a class="sm6" href="#">Download options</a></li>
								</ul>
							</li>*}
						{else}
							<li>&nbsp;</li>
						{/if}
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
	{/if}