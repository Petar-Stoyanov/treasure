<!DOCTYPE html>
<html>
<head>
	<title>{$PAGE_TITLE}</title>
	<meta NAME="KEYWORDS" CONTENT="{$GLOBALS.PAGE_KEYWORDS}">
	{if $GLOBALS.PAGE_DESCIPTION}<META NAME="DESCRIPTION" CONTENT="{$GLOBALS.PAGE_DESCIPTION}">{/if}
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta name='ROBOTS' content='INDEX,FOLLOW,NOARCHIVE'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{if $fb_img}
		<meta property="og:image" content="{$fb_img}"/>
	{/if}
	{if $GLOBALS.OG}
		{foreach from=$GLOBALS.OG value=tag key=tagname}
		<meta property="og:{$tagname}" content="{$tag}">
		{/foreach}
	{/if}
	<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />
	<link href="{$_config.base_url}/favicon.ico" rel="SHORTCUT ICON">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">	
	
	
	
	{if $css1}<link href="{$css1}" rel="stylesheet" type="text/css" />{/if}
	{if $css2}<link href="{$css2}" rel="stylesheet" type="text/css" />{/if}
	{if $css3}<link href="{$css3}" rel="stylesheet" type="text/css" />{/if}
	{if $css4}<link href="{$css4}" rel="stylesheet" type="text/css" />{/if}
	{if $css5}<link href="{$css5}" rel="stylesheet" type="text/css" />{/if}
	<script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script language="javascript" type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<script language="javascript" type="text/javascript" src="/styles/main.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700" rel="stylesheet">

	<script type="text/javascript" src="/styles/masonry.js"></script>

	<link rel="stylesheet" type="text/css" href="/styles/main.css" />
	
	{if $js1}<script language="javascript" type="text/javascript" src="{$js1}"></script>{/if}
	{if $js2}<script language="javascript" type="text/javascript" src="{$js2}"></script>{/if}
	{if $js3}<script language="javascript" type="text/javascript" src="{$js3}"></script>{/if}
	{if $js4}<script language="javascript" type="text/javascript" src="{$js4}"></script>{/if}
	{if $js5}<script language="javascript" type="text/javascript" src="{$js5}"></script>{/if}
	{if $js6}<script language="javascript" type="text/javascript" src="{$js6}"></script>{/if}
	{if $js7}<script language="javascript" type="text/javascript" src="{$js7}"></script>{/if}
	{if $js8}<script language="javascript" type="text/javascript" src="{$js8}"></script>{/if}
	{if $js9}<script language="javascript" type="text/javascript" src="{$js9}"></script>{/if}

</head>
<body>
{capture name=back_url}{query_str full_request_uri=true}{/capture}
<input type="hidden" value="{$templatelite.SESSION.ln}" id="ln">
<div class="mainWrap">
<header>

</header>
<section class="main">

	<body>
	    <div class="top-wrapper">
	      <div class="inner-holder">
	        <span>
	          <a href="" class="top-icon-one"></a>
	        </span>
	        <span>
	          <a href="" class="top-icon-two"></a>
	        </span>
	        <span>
	          <a href="" class="top-text">HOME</a>
	        </span>
	      </div>
	    </div>

	    <div class="top-logo-wrapper">
	      <span>
	        <!-- <a href="" class="logo-one"></a> -->
	        <img src="/img/logo-full.png" class="img-responsive floating-logo">
	      </span>
	      <span>
	        <!-- <a href="" class="logo-two"></a> -->
	        <img src="/img/middle-logo.png" class="img-responsive floating-logo-2">
	      </span>
	      <span>
	        <!-- <a href="" class="logo-three"></a> -->
	        <img src="/img/cys.png" class="img-responsive floating-logo-3">
	      </span>
	    </div>