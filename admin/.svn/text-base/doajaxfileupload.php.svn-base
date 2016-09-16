<?php

include("{$_SERVER['DOCUMENT_ROOT']}/inc/config.php");
include("{$_SERVER['DOCUMENT_ROOT']}/inc/functions.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/db.class.php");
include("{$_SERVER['DOCUMENT_ROOT']}/managers/log.php");

$_config['smarty_cache'] = $_SERVER['DOCUMENT_ROOT'] . '/admin/tmp'; 

$FILTER = getFilter($_GET);
$FILTER['id'] = intval($FILTER['id']);
$tmppath = $_config['tmp_dir'];
if(!isset($_SESSION['ln'])) $_SESSION['ln']=2;
	$error = "";
	$msg = "";
	if(empty($FILTER['elem'])) return;
	$fileElementName = $FILTER['elem'];
	
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error']) {

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;
			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
		
		$result = array('error'=>$error, 'msg'=>$msg);
		$result = json_encode($result);
		echo $result;
	} elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none') {
		$error = 'No file was uploaded..';
		$result = array('error'=>$error, 'msg'=>$msg);
		$result = json_encode($result);
		echo $result;
	} else {
		if($FILTER['mode'] == 'file') {
			if(!file_exists("{$_config['root_dir']}/img/products/")) mkdir("{$_config['root_dir']}/img/products/");
			//move_uploaded_file($_FILES[$fileElementName]['tmp_name'],"{$_config['root_dir']}/img/products/img{$FILTER['id']}_$fileElementName.jpg");
			
			$image = $_FILES[$fileElementName]['tmp_name'];
			$tmp = explode(".", $_FILES[$fileElementName]['name']);
			$ext = end($tmp);
			//$ext = 'jpg';
			
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			$smallimage->save("{$_config['root_dir']}/img/products/img{$FILTER['id']}_orig.{$ext}");
			if($fileElementName=='main') {
				if($smallimage->getWidth() > 587) $smallimage->resizeToWidth(587);
			}
			if($fileElementName=='thum1') {
				if($smallimage->getWidth() > $smallimage->getHeight()) {
					//$smallimage->resizeToWidth(282);
					//$smallimage->cutFromCenter(282,203);
					//$smallimage->cutFromCenter(282,203);
				} else {
					//$smallimage->resizeToHeight(203);
					//$smallimage->cutFromCenter(282,203);
				}
				$smallimage->thumbnail_box(282,203);
						
			}
			if($fileElementName=='thum2') {
				if($smallimage->getWidth() > $smallimage->getHeight()) {
					//$smallimage->resizeToWidth(111);
					//$smallimage->cutFromCenter(111,84);
				} else {
					//$smallimage->resizeToHeight(84);
					//$smallimage->cutFromCenter(111,84);
				}
				$smallimage->thumbnail_box(111,84);
						
			}
		    $smallimage->save("{$_config['root_dir']}/img/products/img{$FILTER['id']}_$fileElementName.{$ext}");
		
			
			@unlink($image);
		} elseif($FILTER['mode'] == 'stat_page') {
			if(!file_exists("{$_config['root_dir']}/img/stat_page/")) mkdir("{$_config['root_dir']}/img/stat_page/");
			//move_uploaded_file($_FILES[$fileElementName]['tmp_name'],"{$_config['root_dir']}/img/products/img{$FILTER['id']}_$fileElementName.jpg");
			
			$image = $_FILES[$fileElementName]['tmp_name'];
			$tmp = explode(".", $_FILES[$fileElementName]['name']);
			$ext = end($tmp);
			//$ext = 'jpg';
		
			require_once("{$_config['root_dir']}/managers/SimpleImage.php");
			$smallimage = new SimpleImage();
			$smallimage->load($image);
			if($smallimage->getHeight() > 140) $smallimage->resizeToHeight(140);
			if($smallimage->getWidth() > 110) $smallimage->resizeToWidth(110);
			
			$smallimage->save("{$_config['root_dir']}/img/stat_page/stat_page{$FILTER['id']}_$fileElementName.{$ext}");
			@unlink($image);
		} elseif($FILTER['mode'] == 'gallery') {
			if(!file_exists("{$_config['root_dir']}/img/galleries/{$FILTER['id']}/")) mkdir("{$_config['root_dir']}/img/galleries/{$FILTER['id']}/");
			move_uploaded_file($_FILES[$fileElementName]['tmp_name'],"{$_config['root_dir']}/img/galleries/{$FILTER['id']}/{$_FILES[$fileElementName]['name']}");
		} else {
			$mm = new DB($_config['db_host'], $_config['db_user'], $_config['db_password'], true);
			$mm->UseDB($_config['db_dbname']);
			$mm->Query("SET NAMES utf8");
			$photo_fld = nvl($FILTER['field'], 'photo');
			$type_fld = ($photo_fld=='photo'?'image_type':"{$photo_fld}_type");
			$image = $_FILES[$fileElementName]['tmp_name'];
			$tmp = explode(".", $_FILES[$fileElementName]['name']);
			$ext = end($tmp);
			
			if($FILTER['mode'] == 'gp') { // product gallery photo
		
				require_once("{$_config['root_dir']}/managers/SimpleImage.php");
				$smallimage = new SimpleImage();
				$smallimage->load($image);
				$smallimage->thumbnail_box(111,84);
				//$smallimage->resizeToWidth(111);
				//$smallimage->cutFromCenter(111,84);
				$smallimage->save("$tmppath/small");
				$fp = fopen ("$tmppath/small", "r");
				$data['small_photo'] = fread($fp, filesize("$tmppath/small"));
				$data['small_photo'] = base64_encode($data['small_photo']);
		 	 	fclose ($fp);
		 	 	unlink("$tmppath/small");
		 	 	
		 	 	$smallimage = new SimpleImage();
				$smallimage->load($image);
				$smallimage->resizeToWidth(587);
				$smallimage->save("$tmppath/big");
				$fp = fopen ("$tmppath/big", "r");
				$data[$photo_fld] = fread($fp, filesize("$tmppath/big"));
				$data[$photo_fld] = base64_encode($data[$photo_fld]);
		 	 	fclose ($fp);
		 	 	unlink("$tmppath/big");
		 	 	
		 	 	$data['product_id'] = $FILTER['id'];
		  	} else {
				$fp = fopen ($image, "r");
				$data[$photo_fld] = fread($fp, filesize($image));
		 	 	fclose ($fp);
		 	 	$data[$photo_fld] = base64_encode($data[$photo_fld]);
				
				if($FILTER['type']=='news' && $photo_fld=='photo2') {
					
					require_once("{$_config['root_dir']}/managers/ImageManipulator.php");
					$man = new ImageManipulator($image);
					$man->resample(284,183);
					$man->save("$tmppath/small");
					/*
					require_once("{$_config['root_dir']}/managers/SimpleImage.php");
					$smallimage = new SimpleImage();
					$smallimage->load($image);
					
					//$smallimage->thumbnail_box(284,183);
					$smallimage->save("$tmppath/small");
					*/
					$fp = fopen ("$tmppath/small", "r");
					$photo2 = fread($fp, filesize("$tmppath/small"));
					$data[$photo_fld] = base64_encode($photo2);
				}
		  	}
			
			
			
	 	 	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	 	 	$imageType = image_type_to_mime_type($imageType);
		  	$table = $FILTER['type'];
		  	$data[$type_fld] = $imageType;
		  	
		  	if($FILTER['mode'] == 'gp') { // product gallery photo
		  		$mm->AutoExecute($table, $data, 1, false);
		  		$gpId = $mm->GetId();
		  		$smallimage = new SimpleImage();
		  		$smallimage->load($image);
		  		$smallimage->save("{$_config['root_dir']}/img/products/gal{$FILTER['id']}_{$gpId}.{$ext}");
		  		$url = "/img/products/gal{$FILTER['id']}_{$gpId}.{$ext}";
		  		$mm->Query("UPDATE {$table} SET original='{$url}' WHERE id={$gpId}");
		  	} else {
		  		$mm->AutoExecute($table, $data, 2, "id={$FILTER['id']}");
		  	}
	
			@unlink($image);
		}
		$result = array('error'=>$error, 'msg'=>$msg);
		$result = json_encode($result);
		echo $result;
	}
?>