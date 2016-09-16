<?
include('inc/application.php');

require("{$_SERVER['DOCUMENT_ROOT']}/inc/Smarty/class.template.php");

$PAGE_TITLE .= ' - Публикации';
$PAGE_ID = -21;
require_once('submenu.php');

if($_POST) {
	$FILTER = getFilter($_POST);
	$FILTER['mode'] = 'save';	
	$FILTER = quotes_filter($FILTER, 'name_bg, name_en, name_ro, text_bg, text_en, text_ro, short_desc_bg, short_desc_en, short_desc_ro, description_bg, description_en, description_ro, date, active_till, url');
	$FILTER = intval_filter($FILTER, 'id, etype');
} else {
	$FILTER = getFilter($_GET);
}

if(!in_array(nvl($FILTER['mode']),array('edit','save','dellib','delnews','hidenews','unhidenews','link','sel'))) $FILTER['mode']='';
if(!in_array(nvl($FILTER['type']),array('library','news','static'))) $FILTER['type']='';
if ($FILTER['type']=='static') {
	$side_menu = array(
		array('href'=>'library.php?type=static&mode=edit&id=1', 'title'=>'За нас', 'active'=>($FILTER['id']==1)),
		array('href'=>'library.php?type=static&mode=edit&id=2', 'title'=>'Контакти', 'active'=>($FILTER['id']==2)),
		array('href'=>'library.php?type=static&mode=edit&id=3', 'title'=>'Общи условия', 'active'=>($FILTER['id']==3)),
		array('href'=>'library.php?type=static&mode=edit&id=4', 'title'=>'Реклама', 'active'=>($FILTER['id']==4)),
		array('href'=>'library.php?type=static&mode=edit&id=5', 'title'=>'Въпроси за моята поръчка', 'active'=>($FILTER['id']==5)),
		array('href'=>'library.php?type=static&mode=edit&id=6', 'title'=>'Доставки', 'active'=>($FILTER['id']==6)),
		array('href'=>'library.php?type=static&mode=edit&id=7', 'title'=>'Правo и защита на лични данни', 'active'=>($FILTER['id']==7)),
		array('href'=>'library.php?type=static&mode=edit&id=8', 'title'=>'Начини на плащане', 'active'=>($FILTER['id']==8)),
		array('href'=>'library.php?type=static&mode=edit&id=9', 'title'=>'Намаления', 'active'=>($FILTER['id']==9)),
		array('href'=>'library.php?type=static&mode=edit&id=10', 'title'=>'Определете своя размер', 'active'=>($FILTER['id']==10)),
		array('href'=>'library.php?type=static&mode=edit&id=11', 'title'=>'За ритейлъри', 'active'=>($FILTER['id']==11)),
	);
}

switch ($FILTER['mode']) {
	case 'dellib':
		$mm->Query("DELETE FROM library WHERE id={$FILTER['id']}");
		redirect('library.php?type=library');
		break;
	case 'delnews':
		$mm->Query("UPDATE news SET deleted=1 WHERE id={$FILTER['id']}");
		redirect('library.php?type=news');
		break;
	case 'hidenews':
		$mm->Query("UPDATE news SET hidden=1 WHERE id={$FILTER['id']}");
		redirect('library.php?type=news');
		break;
	case 'unhidenews':
		$mm->Query("UPDATE news SET hidden=0 WHERE id={$FILTER['id']}");
		redirect('library.php?type=news');
		break;
	
	case 'edit':
		if($FILTER['type']=='static') {
			editStatic($FILTER);
		} else {
			edit($FILTER);	
		}		
		break;
	case 'save':
		insertUpdate($FILTER);
		break;
	case 'sel':
		linkArticle($FILTER);
		break;
	default:
		show($FILTER);
		break;
}


function show(&$FILTER) {
	global $mm;
	$tpl = new Template_Lite();
	
	if(empty($FILTER['type'])) {
		$topNews = $mm->SelAssoc("	SELECT 	id, photo, name_bg, short_desc_bg, date, is_hot, hidden
									FROM 	news
									WHERE 	deleted=0
									ORDER BY -1
									LIMIT 5");
		
		$topLibs = $mm->SelAssoc("	SELECT 	id, photo, name_bg, short_desc_bg, date, type, is_intro
										FROM 	library
										ORDER BY -1
										LIMIT 5");
		
		
		$tpl->assign_by_ref('topNews',$topNews);
		$tpl->assign_by_ref('topLibs',$topLibs);
	} elseif($FILTER['type']!='static') {
		$where_cls = '';
		
		$sql_map = array(
			'news'=>'SELECT 	id, photo, name_bg, short_desc_bg, date, is_hot, hidden
						FROM 	news
						WHERE 	deleted=0
						ORDER BY -1',
			'library'=>"SELECT 	id, photo, name_bg, short_desc_bg, date, type, is_intro
						FROM 	library
						$where_cls
						ORDER BY -1"
		
		);
		
		$sql = $sql_map[$FILTER['type']];
		
		$uri = "type={$FILTER['type']}";
		$FILTER['list'] = $mm->SelAssoc($sql,true,10,4, $uri);
		$FILTER['pager'] = $mm->pager;
	}
	
	
	$tpl->assign_by_ref('FILTER',$FILTER);
	$tpl->display('library.tpl');
}


function edit(&$FILTER,$errs = array()){
	global $mm,$PAGE_TITLE;
	
	if(isset($FILTER['dellink'])) {
		$FILTER['dellink']=intval($FILTER['dellink']);
		$mm->Query("DELETE FROM lib_2_lib WHERE lib_id1={$FILTER['id']} AND lib_id2={$FILTER['dellink']}");
		redirect(replace_param_in_url('dellink'));
	}
	
	$edit_tables = array('news'=>'news', 'library'=>'library');
	
	$FILTER['id']=intval($FILTER['id']);
	if($FILTER['id']>0) {
		
		$sql_table = $edit_tables[$FILTER['type']];
		
		$select_flds = 'id, 
						name_bg, 
						name_en, 
						name_ro, 
						photo,
						created_at
						date,
						short_desc_bg, 
						short_desc_en, 
						short_desc_ro, 
						description_bg, 
						description_en, 
						description_ro';
		
		
		if($FILTER['type']=='library') {
			$select_flds .= ',type, is_intro';
			
			$FILTER['linkedlibs'] = $mm->SelAssoc("SELECT 	id, name_bg, date, type, if(type=4, producer_id, if(type=3, country_id, if(type=2, region_id, sort_id))) as entity_id
												FROM	library
												WHERE	id IN (SELECT lib_id2 FROM lib_2_lib WHERE lib_id1 = {$FILTER['id']})");
		}
		
		if($FILTER['type']=='news') {
		
			if(isset($FILTER['delpr'])) {
				$FILTER['delpr'] = intval($FILTER['delpr']);
				$mm->Query("DELETE FROM products_2_news WHERE product_id={$FILTER['delpr']} AND news_id={$FILTER['id']}");
				redirect(replace_param_in_url('delpr'));
			}
			
			$select_flds .= ',
							is_hot,
							photo2,
							url';
							
			if($FILTER['id']>0) { // get product information
				$FILTER['products'] = $mm->SelAssoc("	SELECT id, name_bg as name, short_descr_bg, type_id 
														FROM products 
														WHERE id IN(SELECT product_id FROM products_2_news WHERE news_id={$FILTER['id']})");
			}
		}
		
		
		$sql = "SELECT 	{$select_flds}
				FROM 	{$sql_table}
				WHERE	id={$FILTER['id']}";
		
		$res = $mm->SelAssoc($sql);
		
		if($res!=false) {
			$res = $res[$FILTER['id']];
			$FILTER['e'] = $res['type'];
			$FILTER = array_merge($res, $FILTER);
		} else {
			redirect('library.php?type='.$FILTER['type']);
		}
	}

	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	
	$cache .= "|edit";
	$tpl->assign_by_ref('FILTER', $FILTER);
	$tpl->display('editLib.tpl', $cache);
}

function editStatic(&$FILTER,$errs = array()){
	global $mm,$PAGE_TITLE, $_config;
	
	$FILTER['id']=intval($FILTER['id']);
	if(!in($FILTER['id'], 1,2,3,4,5,6,7,8,9,10,11)) redirect('library.php?type='.$FILTER['type']);
	
	$titles = array(
		1=>'За нас',
		2=>'Контакти',
		3=>'Общи условия',
		4=>'Реклама',
		5=>'Въпроси за моята поръчка',
		6=>'Доставки',
		7=>'Правo и защита на лични данни',
		8=>'Начини на плащане',
		9=>'Намаления',
		10=>'Определете своя размер',
		11=>'За ритейлъри',
	);
	
	$FILTER['title'] = $titles[$FILTER['id']];
	
	$sql = "SELECT 	text_bg, text_en, text_ro
				FROM 	stat_pages
				WHERE	id={$FILTER['id']}";
		
	$res = $mm->SelArr($sql);
		
	if($res!=false) {
		$FILTER = array_merge($res, $FILTER);
	} else {
		redirect('library.php?type='.$FILTER['type']);
	}
 	
	$tpl = new Template_Lite();
	if(!empty($errs)) {
		$_cache .= "|errs";
		$tpl->assign_by_ref('errs', $errs);
	}
	
	$cache .= "|edit";
	$tpl->assign_by_ref('FILTER', $FILTER);
	$tpl->display('stat_pages.tpl', $cache);
}


function insertUpdate(&$FILTER) {
	global $mm, $_config;
	
	if($FILTER['type']=='static') {
		$data['text_bg']=$FILTER['text_bg'];
		$data['text_en']=$FILTER['text_en'];
		$data['text_ro']=$FILTER['text_ro'];
		$mm->AutoExecute('stat_pages', $data, 2, "id={$FILTER['id']}");
		redirect("library.php?type={$FILTER['type']}&mode=edit&id={$FILTER['id']}");
	}
	
	$edit_tables = array('news'=>'news',
						'events'=>'events',
						'library'=>'library',
						'blog'=>'blog');
	
	if(empty($FILTER['name_bg'])) $errs['name_bg'] = 'Полето е задължително.';
	if(empty($FILTER['name_en'])) $errs['name_en'] = 'Полето е задължително.';
	if($FILTER['type']!='blog') {
		if($FILTER['type'] == 'library' && empty($FILTER['date'])) $FILTER['date'] = date("d.m.Y");
		if(empty($FILTER['date'])) {
			$errs['date'] = 'Полето е задължително.';
		} else {
			$FILTER['date'] = formatDate($FILTER['date']);
		}
	} else {
		if(empty($FILTER['url'])) $errs['url'] = 'Полето е задължително.';
	}
	
	
	
	if(in($FILTER['type'], 'library', 'news')) {
		if(!empty($_FILES['fileToUpload']['tmp_name'])) {
			$image = $_FILES['fileToUpload']['tmp_name'];
			$tmppath = ini_get('upload_tmp_dir');
			list($imagewidth, $imageheight, $imageType) = getimagesize($image);
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			if($FILTER['type']=='news') {
				if($imagewidth>120) $smallimage->resizeToWidth(120);
			}
			$smallimage->save("$tmppath/smallthumb");
			$fp = fopen ("$tmppath/smallthumb", "r");
			$data['photo'] = fread($fp, filesize("$tmppath/smallthumb"));
			$data['photo'] = base64_encode($data['photo']);
	 	 	fclose ($fp);
	 	 	unlink("$tmppath/smallthumb");
	 	 	
	 	 	$imageType = image_type_to_mime_type($imageType);
		  	$data['image_type'] = $imageType;
		}
		
		if(!empty($_FILES['photo2']['tmp_name'])) {
			$image = $_FILES['photo2']['tmp_name'];
			list($imagewidth, $imageheight, $imageType) = getimagesize($image);
			$fp = fopen ($image, "r");
			$data['photo2'] = fread($fp, $image);
			$data['photo2'] = base64_encode($data['photo2']);
	 	 	fclose ($fp);
	 	 	
	 	 	$imageType = image_type_to_mime_type($imageType);
		  	$data['photo2_type'] = $imageType;
		}
	}
	
	if(!empty($errs)) {
		edit($FILTER, $errs);
		return;
	}
	
	$table = $edit_tables[$FILTER['type']];
	
	$data['name_bg']=quotes($FILTER['name_bg']);
	$data['name_en']=quotes($FILTER['name_en']);
	$data['name_ro']=quotes($FILTER['name_ro']);
	$data['short_desc_bg']=$FILTER['short_desc_bg'];
	$data['short_desc_en']=$FILTER['short_desc_en'];
	$data['short_desc_ro']=$FILTER['short_desc_ro'];
	$data['description_bg']=$FILTER['description_bg'];
	$data['description_en']=$FILTER['description_en'];
	$data['description_ro']=$FILTER['description_ro'];
	$data['date']=$FILTER['date'];
	
	if($FILTER['type']=='news') {
		$data['is_hot']=intval($FILTER['is_hot']);
		$data['url']=quotes($FILTER['url']);
	}
	
	if($FILTER['type']=='library') {		
		$data['is_intro'] = intval($FILTER['is_intro']);
	}
	
	if(!empty($data['on_home']) && $data['on_home']==1) {
		$mm->Query("UPDATE {$table} SET on_home=0 WHERE on_home=1");
	}
	if($FILTER['id']>0) {
		$mm->AutoExecute($table, $data, 2, "id={$FILTER['id']}");
	} else {
		$mm->AutoExecute($table, $data, 1);
	}
	redirect("library.php?type={$FILTER['type']}");
}

function linkArticle(&$FILTER) {
	global $mm;
	$FILTER['for_id'] = intval($FILTER['for_id']);
	$FILTER['sel_id'] = intval($FILTER['sel_id']);
	if($FILTER['for_id']>0 && $FILTER['sel_id']>0) {
		$mm->Query("INSERT INTO lib_2_lib(lib_id1, lib_id2) VALUES({$FILTER['for_id']}, {$FILTER['sel_id']})");
	}
	
	redirect("?type={$FILTER['type']}&mode=edit&id={$FILTER['for_id']}");
}
?>