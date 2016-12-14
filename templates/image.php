<?
include("{$_SERVER['DOCUMENT_ROOT']}/inc/config.php");
include("{$_SERVER['DOCUMENT_ROOT']}/inc/functions.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/db.class.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/log.php");

$FILTER = getFilter($_GET);
$FILTER['id'] = intval($FILTER['id']);

if(!isset($_SESSION['ln'])) $_SESSION['ln']=2;
//$tmppath = ini_get('upload_tmp_dir');
if(empty($tmppath)) $tmppath = $_config['tmp_dir'];
if($FILTER['mode']=='file') {
	$image = "{$_config['root_dir']}/img/products/{$FILTER['name']}";
	if(file_exists($image)) {
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
 	 	fclose ($fp);
		$type = image_type_to_mime_type($imageType);
		
		if(!empty($FILTER['height']) && $imageheight>$FILTER['height']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToHeight($FILTER['height']);
			$smallimage->save("$tmppath/{$FILTER['name']}");
			$fp = fopen ("$tmppath/{$FILTER['name']}", "r");
			$photo = fread($fp, filesize("$tmppath/{$FILTER['name']}"));
		 	fclose ($fp);
		 	unlink("$tmppath/{$FILTER['name']}");
		}elseif(!empty($FILTER['width']) && $imagewidth>$FILTER['width']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToWidth($FILTER['width']);
			$smallimage->save("$tmppath/{$FILTER['name']}");
			$fp = fopen ("$tmppath/{$FILTER['name']}", "r");
			$photo = fread($fp, filesize("$tmppath/{$FILTER['name']}"));
		 	fclose ($fp);
		 	unlink("$tmppath/{$FILTER['name']}");
		}
	} else {
		$image = "{$_config['root_dir']}/img/pics/post.jpg";
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
 	 	fclose ($fp);
		$type = image_type_to_mime_type($imageType);
		
		if(!empty($FILTER['height']) && $imageheight>$FILTER['height']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToHeight($FILTER['height']);
			$smallimage->save("$tmppath/{$FILTER['name']}");
			$fp = fopen ("$tmppath/{$FILTER['name']}", "r");
			$photo = fread($fp, filesize("$tmppath/{$FILTER['name']}"));
		 	fclose ($fp);
		 	unlink("$tmppath/{$FILTER['name']}");
		}elseif(!empty($FILTER['width']) && $imagewidth>$FILTER['width']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToWidth($FILTER['width']);
			$smallimage->save("$tmppath/{$FILTER['name']}");
			$fp = fopen ("$tmppath/{$FILTER['name']}", "r");
			$photo = fread($fp, filesize("$tmppath/{$FILTER['name']}"));
		 	fclose ($fp);
		 	unlink("$tmppath/{$FILTER['name']}");
		}
	}

} elseif($FILTER['mode']=='gp') { // galery photo
	$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
	$mm->UseDB($_config['db_dbname']);
	$mm->Query("SET NAMES utf8");
	$table = $FILTER['type'];
	
	$photo_fld = ($FILTER['size'] == 1 ? 'small_photo' : 'photo');
	$res = $mm->SelRow("SELECT $photo_fld, image_type FROM {$table} WHERE id={$FILTER['id']}");
	$photo = $res[0];
	$photo = base64_decode($photo);
	$type = $res[1];
	if(!empty($FILTER['height'])) {
		$FILTER['name'] = 'galleryPhoto';
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "x");
		fwrite($fp, $photo);
		fclose($fp);
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		if($imageheight>$FILTER['height']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToHeight($FILTER['height']);
			$smallimage->save($image);
			$fp = fopen ($image, "r");
			$photo = fread($fp, filesize($image));
		 	fclose ($fp);
		}
	 	unlink($image);
	}elseif(!empty($FILTER['width'])) {
		$FILTER['name'] = 'galleryPhoto';
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "x");
		fwrite($fp, $photo);
		fclose($fp);
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		if($imagewidth>$FILTER['width']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToWidth($FILTER['width']);
			$smallimage->save($image);
			$fp = fopen ($image, "r");
			$photo = fread($fp, filesize($image));
		 	fclose ($fp);
		}
	 	unlink($image);
	}
	/*} elseif($FILTER['mode']=='homepromo') {
		$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
		$mm->UseDB($_config['db_dbname']);
		$mm->Query("SET NAMES cp1251");	
		$table = $FILTER['type'];
		
		$res = $mm->SelRow("SELECT photo, image_type FROM {$table} WHERE id={$FILTER['id']}");
		$photo = $res[0];
		$photo = base64_decode($photo);
		$type = $res[1];
		$fp = fopen ("$tmppath/homePromo", "x");
		fwrite($fp, $photo);
		fclose($fp);
		require_once("{$_config['root_dir']}/managers/SimpleImage.php");
		$smallimage = new SimpleImage();
		$smallimage->load("$tmppath/homePromo");
		$smallimage->resizeToHeight(290);
		$smallimage->save("$tmppath/homePromo");
		$fp = fopen ("$tmppath/homePromo", "r");
		$photo = fread($fp, filesize("$tmppath/homePromo"));
	 	fclose ($fp);
	 	unlink("$tmppath/homePromo");*/
}elseif($FILTER['mode']=='get'){
	$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
	$mm->UseDB($_config['db_dbname']);
	$mm->Query("SET NAMES cp1251");

	$pic_id = NULL;

	if($FILTER['fl'] == "museum_main_pic"){

		$pic_id = $mm->SelOne("SELECT main_pic_id FROM treasure WHERE id={$FILTER['id']}");

	}else if($FILTER['fl'] == "banner"){
		$pic_id = $FILTER['id'];
	}
	$photo_type = $FILTER['size'] != NULL ? $FILTER['size'] . '_' : 'original_';
	$res = $mm->SelRow("SELECT {$photo_type}photo, image_type FROM pictures WHERE id={$pic_id}");

	$photo = $res[0];
	$photo = base64_decode($photo);
	$type = $res[1];
	if(empty($photo) && $table=='users') {
		$image = "{$_config['root_dir']}/img/avatar_def.jpg";
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
		fclose ($fp);
		$type = image_type_to_mime_type($imageType);
	}elseif(empty($photo) && $table=='news') {
		$image = "{$_config['root_dir']}/img/pics/news.jpg";
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
		fclose ($fp);
		$type = image_type_to_mime_type($imageType);
	}
	if(!empty($FILTER['size'])) {
		list($width, $height) = explode("x", $FILTER['size']);
		$FILTER['name'] = 'dbPhoto' . $FILTER['id'];
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "w");
		fwrite($fp, $photo);
		fclose($fp);

		require_once("{$_config['root_dir']}/managers/SimpleImage.php");
		$smallimage = new SimpleImage();
		$smallimage->load($image);
		$smallimage->resize($width, $height);
		$smallimage->save($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
		fclose ($fp);
		unlink($image);
	}elseif(!empty($FILTER['height'])) {
		$FILTER['name'] = 'dbPhoto' . $FILTER['id'];
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "w");
		fwrite($fp, $photo);
		fclose($fp);
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		if($imageheight>$FILTER['height']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToHeight($FILTER['height']);
			$smallimage->save($image);
			$fp = fopen ($image, "r");
			$photo = fread($fp, filesize($image));
			fclose ($fp);
		}
		unlink($image);
	}elseif(!empty($FILTER['width'])) {
		$FILTER['name'] = 'dbPhoto' . $FILTER['id'];
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "w");
		fwrite($fp, $photo);
		fclose($fp);
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		if ($imagewidth>$FILTER['width']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToWidth($FILTER['width']);
			$smallimage->save($image);
			$fp = fopen ($image, "r");
			$photo = fread($fp, filesize($image));
			fclose ($fp);
		}
		unlink($image);
	}


} else {
	$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
	$mm->UseDB($_config['db_dbname']);
	$mm->Query("SET NAMES cp1251");	
	$table = $FILTER['type'];
	$photo_fld = nvl($FILTER['field'],'photo');
	$type_fld = ($photo_fld=='photo'?'image_type':"{$photo_fld}_type");
	
	$res = $mm->SelRow("SELECT {$photo_fld}, {$type_fld} FROM {$table} WHERE id={$FILTER['id']}");
	$photo = $res[0];
	$photo = base64_decode($photo);
	$type = $res[1];
	if(empty($photo) && $table=='users') {
		$image = "{$_config['root_dir']}/img/avatar_def.jpg";
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
 	 	fclose ($fp);
		$type = image_type_to_mime_type($imageType);
	}elseif(empty($photo) && $table=='news') {
		$image = "{$_config['root_dir']}/img/pics/news.jpg";
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
 	 	fclose ($fp);
		$type = image_type_to_mime_type($imageType);
	}


	if(!empty($FILTER['size'])) {
		list($width, $height) = explode("x", $FILTER['size']);
		$FILTER['name'] = 'dbPhoto' . $FILTER['id'];
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "w");
		fwrite($fp, $photo);
		fclose($fp);
		
		require_once("{$_config['root_dir']}/managers/SimpleImage.php");
		$smallimage = new SimpleImage();
		$smallimage->load($image);
		$smallimage->resize($width, $height);
		$smallimage->save($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
		fclose ($fp);
		unlink($image);
	}elseif(!empty($FILTER['height'])) {
		$FILTER['name'] = 'dbPhoto' . $FILTER['id'];
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "w");
		fwrite($fp, $photo);
		fclose($fp);
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		if($imageheight>$FILTER['height']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToHeight($FILTER['height']);
			$smallimage->save($image);
			$fp = fopen ($image, "r");
			$photo = fread($fp, filesize($image));
		 	fclose ($fp);
		}
		unlink($image);
	}elseif(!empty($FILTER['width'])) {
		$FILTER['name'] = 'dbPhoto' . $FILTER['id'];
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "w");
		fwrite($fp, $photo);
		fclose($fp);
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		if ($imagewidth>$FILTER['width']) {
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->resizeToWidth($FILTER['width']);
			$smallimage->save($image);
			$fp = fopen ($image, "r");
			$photo = fread($fp, filesize($image));
		 	fclose ($fp);
		}
	 	unlink($image);
	}
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header ("Content-type: {$type}");



echo $photo;

	
?>