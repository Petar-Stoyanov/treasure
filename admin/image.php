<?
include("{$_SERVER['DOCUMENT_ROOT']}/inc/config.php");
include("{$_SERVER['DOCUMENT_ROOT']}/inc/functions.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/db.class.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/log.php");

$FILTER = getFilter($_GET);
$FILTER['id'] = intval(nvl($FILTER['id']));

if(!isset($_SESSION['ln'])) $_SESSION['ln']=2;
if($FILTER['mode']=='file') {
	$image = "{$_config['root_dir']}/img/products/{$FILTER['name']}";
	if(file_exists($image)) {
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$fp = fopen ($image, "r");
		$photo = fread($fp, filesize($image));
 	 	fclose ($fp);
		$type = image_type_to_mime_type($imageType);;
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
} else {
	$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
	$mm->UseDB($_config['db_dbname']);
	$mm->Query("SET NAMES utf8");	
	$table = $FILTER['type'];
	$photo_fld = nvl($FILTER['field'],'photo');
	$type_fld = 'image_type';
	$res = $mm->SelRow("SELECT {$photo_fld}, {$type_fld} FROM {$table} WHERE id={$FILTER['id']}");
	$photo = $res[0];
	$photo = base64_decode($photo);
	$type = $res[1];
	if(!empty($FILTER['height'])) {
		$tmppath = ini_get('upload_tmp_dir');
		$FILTER['name'] = 'dbPhoto' . $FILTER['id'];
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
		$tmppath = ini_get('upload_tmp_dir');
		$FILTER['name'] = 'dbPhoto' . $FILTER['id'];
		$image = "$tmppath/{$FILTER['name']}";
		$fp = fopen ($image, "x");
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