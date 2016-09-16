<?php require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/function.query_str.php'); $this->register_function("query_str", "tpl_function_query_str");  require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/block.capture.php'); $this->register_block("capture", "tpl_block_capture");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-16 12:20:48 EEST */ ?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->_vars['PAGE_TITLE']; ?>
</title>
	<meta NAME="KEYWORDS" CONTENT="<?php echo $this->_vars['GLOBALS']['PAGE_KEYWORDS']; ?>
">
	<?php if ($this->_vars['GLOBALS']['PAGE_DESCIPTION']): ?><META NAME="DESCRIPTION" CONTENT="<?php echo $this->_vars['GLOBALS']['PAGE_DESCIPTION']; ?>
"><?php endif; ?>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta name='ROBOTS' content='INDEX,FOLLOW,NOARCHIVE'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if ($this->_vars['fb_img']): ?>
		<meta property="og:image" content="<?php echo $this->_vars['fb_img']; ?>
"/>
	<?php endif; ?>
	<?php if ($this->_vars['GLOBALS']['OG']): ?>
		<?php if (count((array)$this->_vars['GLOBALS']['OG'])): foreach ((array)$this->_vars['GLOBALS']['OG'] as $this->_vars['tagname'] => $this->_vars['tag']): ?>
		<meta property="og:<?php echo $this->_vars['tagname']; ?>
" content="<?php echo $this->_vars['tag']; ?>
">
		<?php endforeach; endif; ?>
	<?php endif; ?>
	<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />
	<link href="<?php echo $this->_vars['_config']['base_url']; ?>
/favicon.ico" rel="SHORTCUT ICON">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">	
	<link rel="stylesheet" type="text/css" href="/styles/main.css" />

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
	<script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script language="javascript" type="text/javascript" src="/styles/main.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700" rel="stylesheet"> 
	<script type="text/javascript" src="masonry.js"></script>
	<link rel="stylesheet" href="css/main.css">

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
	<?php if ($this->_vars['js8']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js8']; ?>
"></script><?php endif; ?>
	<?php if ($this->_vars['js9']): ?><script language="javascript" type="text/javascript" src="<?php echo $this->_vars['js9']; ?>
"></script><?php endif; ?>

</head>
<body>
<?php $this->_tag_stack[] = array('tpl_block_capture', array('name' => back_url)); tpl_block_capture(array('name' => back_url), null, $this); ob_start();  echo tpl_function_query_str(array('full_request_uri' => true), $this); $this->_block_content = ob_get_contents(); ob_end_clean(); $this->_block_content = tpl_block_capture($this->_tag_stack[count($this->_tag_stack) - 1][1], $this->_block_content, $this); echo $this->_block_content; array_pop($this->_tag_stack); ?>
<input type="hidden" value="<?php echo $_SESSION['ln']; ?>
" id="ln">
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
	        <a href="" class="logo-one"></a>
	      </span>
	      <span>
	        <a href="" class="logo-two"></a>
	      </span>
	      <span>
	        <a href="" class="logo-three"></a>
	      </span>
	    </div>