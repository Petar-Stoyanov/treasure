<?
function utf2c($string) {
  return iconv("UTF-8", "windows-1251", $string);
}

function returnSize($size) {
  $size = $size/1024; ### kbytes
  $field = 'Kb';

  if ($size > 1024) {
    $size = $size/1024;
    $field = 'Mb';
  }
  return floor($size)." ".$field;
}

function backurl($back_url) {
	if(empty($back_url)) $back_url = $_SERVER['HTTP_REFERER'];
	
	$back_url = preg_replace('/en\//', '', $back_url);
	
	$lang_url = ($_SESSION['ln']==1?'en/':'');
	
	if(substr($back_url,0,1)=='/') {
		$back_url = substr($back_url,1);
		$back_url = "/" . $lang_url . $back_url;
	} else {
		$back_url = $lang_url . $back_url;
	}
	
	return $back_url;
}

function query_str($params) {
	$url = '';
	if(isset($params['full_request_uri']) && $params['full_request_uri']) {
		$url = str_replace("?{$_SERVER['QUERY_STRING']}", '', $_SERVER['REQUEST_URI']);
		unset($params['full_request_uri']);
	}

	$query = array();
	parse_str($_SERVER['QUERY_STRING'] , $query);

	$escape = !empty($params['escape']);
	unset($params['escape']);
	if(!empty($params['var'])) {
		$params[$params['var']] = nvl($params['val'], null);
	}
	unset($params['var']);
	unset($params['val']);

	foreach($params AS $key=>$val) {
		if ($val=='') {
			unset($query[$key]); // remove param with value if present
		} else {
			$query[$key]=$val; // new val of param
		}
	}
	if($escape) {
		$query = http_build_query($query, null, '&amp;');
	} else {
		$query = http_build_query($query);
	}
	if($query!='') $url .= '?' . $query;

	return $url;
}

function getFilter(&$DATA, $format=1) {
	if (empty($DATA)) return false;
	if($format>2) return false;
	
	foreach ($DATA AS $key=>$value) {
		if($format==2) {
			$tmp->$key = $value;
		}elseif($format==1){
			$tmp["$key"] = $value;
		}
	}
	
	if($format==2) {
		$tmp->lang_url = ($_SESSION['ln']==1?'en/':'');
		if(!empty($tmp->back_url)) $tmp->back_url = backurl($tmp->back_url);
	}elseif($format==1){
		$tmp['lang_url'] = ($_SESSION['ln']==1?'en/':'');
		if(!empty($tmp['back_url'])) $tmp['back_url'] = backurl($tmp['back_url']);
	}
	
	return $tmp;
}

function redirect($url) {
	if($url=='') return;
	header('Cache-Control: no-cache,no-store,max-age=0,s-maxage=0,must-revalidate', true); // HTTP/1.1
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT', true);
	header('Expires: 0', true);	// HTTP/1.0
	header('Pragma: no-cache', true);
	header("Location:$url", true);
	die;
}

function intval_filter($frm, $keys) {
	$keys = strtolower(str_replace(array("\t","\n","\r",' '), '', $keys));
	$keys = explode(',', $keys);
	$keys = array_combine($keys, array_pad(array(), count($keys), 0));
	$keys = array_intersect_key($frm, $keys);
	$keys = array_map('intval', $keys);
	$frm  = array_merge($frm, $keys);

	return $frm;
}
	
function nvl($var, $default='', $when_set_value=null) {
/* if $var is undefined, return $default, otherwise return $var */
	if (!isset($var)) return $default;
	if(is_string($var) && $var=='') return $default;

	if(isset($when_set_value)) return $when_set_value;
	return $var;

}

function quotes($val='', $force=false) {
	$val =  str_replace(array("\'",'\"'),array("'",'"'), $val);
	$val = str_replace(array("'"), array("\'"), $val);
	return $val;
}

function quotes_filter($arr, $keys=null) {
	if($keys) {
		$keys = strtolower(str_replace(array("\t","\n","\r",' '), '', $keys));
		$keys = explode(',', $keys);
		$keys = array_combine($keys, array_pad(array(), count($keys), 0));
		$keys = array_intersect_key($arr, $keys);
		$keys = array_map('quotes', $keys);
		$arr  = array_merge($arr, $keys);
	} else {
		$arr = array_map('quotes', $arr);
	}
	
	return $arr;
}

function pd($var) {
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

function has_priv($priv='') {
	if(!empty($priv)) {
		return !empty($_SESSION['user']['privs'][$priv]);
	}
	return false;
}

function Cyrillic2Latin($str) {
	$cyr  = array('а','б','в','г','д','е','ж','з','и','й','к','л','м','н','о','п','р','с','т','у',
			'ф','х','ц','ч','ш','щ','ъ','ь', 'ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У',
			'Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь', 'Ю','Я' );
	$lat = array( 'a','b','v','g','d','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u',
			'f' ,'h' ,'ts' ,'ch','sh' ,'sht' ,'a' ,'y' ,'yu' ,'ya','A','B','V','G','D','E','Zh',
			'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
			'F' ,'H' ,'Ts' ,'Ch','Sh' ,'Sht' ,'A' ,'Y' ,'Yu' ,'Ya' );
	
	$textcyr = str_replace($cyr, $lat, $str);
	return $textcyr;
}

function in() {
    $args = func_get_args();
    $search = $args[0];
    unset($args[0]);

    return in_array($search, $args);
}


/**
 * Replaces/Removes a param in/from URL string
 *
 * @param 	str|arr	$param_name	Name of param to be removed - if array then asoc and values are into it
 * @package str		[$new_val]	New value of param. If empty string then remove param - not specified when $param_name is asoc array.
 * @param 	str 	[$url]		URL to be processed - if not specified then $_SERVER['QUERY_STRING']
 * @return 	str					URL with removed param from it
 */
function replace_param_in_url($param_name, $new_val=null, $url=null) {
	if(!isset($url)) $url=$_SERVER['REQUEST_URI'];

	if(!is_array($param_name)) {
		$key=$param_name;
		$param_name=array();
		$param_name[$key]=$new_val;
	}

	$url = parse_url($url);

	$query = array();
	if(!isset($url['query'])) {
		$url['query']='';
	} else {
		parse_str($url['query'], $query);
	}

	foreach($param_name AS $key=>$val) {
		if($val===null || $val==='') {
			unset($query[$key]); // remove this param from query
		} else {
			if($val===true) {
				$query[$key]='';
			} else {
				$query[$key]=$val;
			}
		}
	}

	$url['query'] = http_build_query($query, '', '&');
	$url['query'] = preg_replace('/=(&|$)/', '\1', $url['query']); // remove empty vals like &cached=
	$url['query'] = str_replace('%2C', ',', $url['query']); // turn back commas ',' as it is after urlencode in http_build_query()

	$newurl='';
	if(isset($url['scheme']) && isset($url['host'])) $newurl = "{$url['scheme']}://{$url['host']}";
	if(isset($url['port'])) $newurl .= ":{$url['port']}";
	
	if(isset($url['path'])) {
		$newurl .= $url['path'];
	} elseif($newurl!='') {
		$newurl .= '/';
	}
	if($url['query']!='') $newurl .= '?' . $url['query'];
	if(isset($url['fragment'])) $newurl .= '#'.$url['fragment'];

	return $newurl;
}

/**
 * Replaces/Removes a param in/from URL string
 *
 * @param 	str|arr	$param_name	Name of param to be removed - if array then asoc and values are into it
 * @package str		[$new_val]	New value of param. If empty string then remove param - not specified when $param_name is asoc array.
 * @param 	str 	[$url]		URL to be processed - if not specified then $_SERVER['QUERY_STRING']
 * @return 	str					URL with removed param from it
 */
function append_param_in_url($param_name, $new_val=null, $separator=',', $url=null, $remove_pager=true) {
	if(!isset($url)) $url=$_SERVER['REQUEST_URI'];

	if(!is_array($param_name)) {
		$key=$param_name;
		$param_name=array();
		$param_name[$key]=$new_val;
	}

	$url = parse_url($url);

	$query = array();
	if(!isset($url['query'])) {
		$url['query']='';
	} else {
		parse_str($url['query'], $query);
	}

	foreach($param_name AS $key=>$val) {
		if($val===null || $val==='') {
			continue; // remove this param from query
		} else {
			$tmpVal = $query[$key];
			
			$vals = explode($separator, $tmpVal);
			if(!in_array($val, $vals)) {
				if(empty($tmpVal)) {
					$newVal = $val;
				}else{
					$newVal = $tmpVal.$separator.$val;
				}
				$query[$key]=$newVal; // new val of param
			}
		}
	}
	
	if($remove_pager && isset($query['page'])) unset($query['page']);

	$url['query'] = http_build_query($query);
	$url['query'] = preg_replace('/=(&|$)/', '\1', $url['query']); // remove empty vals like &cached=
	$url['query'] = str_replace('%2C', ',', $url['query']); // turn back commas ',' as it is after urlencode in http_build_query()

	$newurl='';
	if(isset($url['scheme']) && isset($url['host'])) $newurl = "{$url['scheme']}://{$url['host']}";
	if(isset($url['port'])) $newurl .= ":{$url['port']}";
	if(isset($url['path'])) {
		$newurl .= $url['path'];
	} elseif($newurl!='') {
		$newurl .= '/';
	}
	if($url['query']!='') $newurl .= '?' . $url['query'];
	if(isset($url['fragment'])) $newurl .= '#'.$url['fragment'];

	return $newurl;
}

function formatDate($date) {
  $date = explode('.', $date);
  return "$date[2]-$date[1]-$date[0]";
}


function php2js($a=false)
{
  if (is_null($a)) return 'null';
  if ($a === false) return 'false';
  if ($a === true) return 'true';
  if (is_scalar($a))
  {
    if (is_float($a))
    {
      // Always use "." for floats.
      $a = str_replace(",", ".", strval($a));
    }

    // All scalars are converted to strings to avoid indeterminism.
    // PHP's "1" and 1 are equal for all PHP operators, but
    // JS's "1" and 1 are not. So if we pass "1" or 1 from the PHP backend,
    // we should get the same result in the JS frontend (string).
    // Character replacements for JSON.
    static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'),
    array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
    return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
  }
  $isList = true;
  for ($i = 0, reset($a); $i < count($a); $i++, next($a))
  {
    if (key($a) !== $i)
    {
      $isList = false;
      break;
    }
  }
  $result = array();
  if ($isList)
  {
    foreach ($a as $v) $result[] = php2js($v);
    return '[ ' . join(', ', $result) . ' ]';
  }
  else
  {
    foreach ($a as $k => $v) $result[] = php2js($k).': '.php2js($v);
    return '{ ' . join(', ', $result) . ' }';
  }
}

function get_delivery_price($address_id=null) {
	global $mm, $_delivery_price;
	
	if($address_id==null) {
		log::logError('get_delivery_price', 'incorrect call with both empty $address_id and $city paramaters');
		return 0;
	}

	 // the current Delivery price policy: anywhere in BG - 5lv, if more than 5 bottles in the order - 0lv;
	 // if this changes for different cities uncomment and make corrections in this code
	if($address_id) { 
		$address_id = intval($address_id);
		$country = $mm->SelOne("SELECT country FROM user_addresses WHERE id=$address_id");
	}
	if(!$country) return 0;
	
	$country = intval($country);
	
	$zone_id = $mm->SelOne("SELECT zone_id FROM delivery_zone_countries WHERE country_id={$country}");
	
	if(!$zone_id) return 0;
	$zone_id = intval($zone_id);
	$zone = $mm->SelArr("SELECT id, price1, price2, price3, price4, currency, min_time, max_time FROM delivery_zones WHERE id={$zone_id}");
	
	if(!$zone) {
		log::logError('get_delivery_price', "Invalid zone for address [{$address_id}] - {$zone_id}");
		return 0;
	}
	return $zone;
}


function Title2URL($title) {
	$cyr  = array('а','б','в','г','д','е','ж','з','и','й','к','л','м','н','о','п','р','с','т','у',
			'ф','х','ц','ч','ш','щ','ъ','ь', 'ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У',
			'Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь', 'Ю','Я' );
	$lat = array( 'a','b','v','g','d','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u',
			'f' ,'h' ,'ts' ,'ch','sh' ,'sht' ,'a' ,'y' ,'yu' ,'ya','A','B','V','G','D','E','Zh',
			'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
			'F' ,'H' ,'Ts' ,'Ch','Sh' ,'Sht' ,'A' ,'Y' ,'Yu' ,'Ya' );
	$title = trim($title);
	$res = str_replace($cyr, $lat, $title);
	$res = strtolower($res); // SEO optimization all URL in lowercase
	$res = preg_replace('/[^a-z0-9]+/', '-', $res); // remove all unneeded symbols and replace them with -
	$res = trim($res, '-'); // clearing - at the end
	
	if(strlen($res)>=100) { // limit len of friendly URL to 100 symbols
		$res = substr($res, 0, 100);
		$res = preg_replace('/-[^-]*$/', '', $res); // remove whole last word or last dash if it is at the end
	}
	
	
	return $res;
}

function title_to_url($id, $title, $ln=null) {
	$id = intval($id);
	$res = trim($title);
	$res = Cyrillic2Latin($res); // BG should be converted to EN for URL
	$res = strtolower($res); // SEO optimization all URL in lowercase
	$res = preg_replace('/[^a-z0-9]+/', '-', $res); // remove all unneeded symbols and replace them with -
	$res = trim($res, '-'); // clearing - at the end

	if(strlen($res)>=100) { // limit len of friendly URL to 100 symbols
		$res = substr($res, 0, 100);
	 	$res = preg_replace('/-[^-]*$/', '', $res); // remove whole last word or last dash if it is at the end
	}

	$id = intval($id);
	$res .= '-' . $id;
	
	return $res;
}


function createPassword($length) {
	$chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$i = 0;
	$password = "";
	while ($i <= $length) {
		$password .= $chars{mt_rand(0,strlen($chars))};
		$i++;
	}
	return $password;
}


function convertNumToMoneyStr($number,$internal = true) {
  if (((strstr($number,'.') == false) || (substr($number,strpos($number,'.')+1,strlen($number)))=='00'));
   else $sufix = ' и '.(substr($number,strpos($number,'.')+1,strlen($number))).' стотинки';
  $number = intval($number)+100000;
  $number = substr($number,1,strlen($number));

  if ($number<20) {
    if ($internal) $pr = 'лева'.$sufix;
    switch ($number) { 
      case '1' : return "един $pr"; break;
      case '2' : return "два $pr"; break;
      case '3' : return "три $pr"; break;
      case '4' : return "четири $pr"; break;
      case '5' : return "пет $pr"; break;
      case '6' : return "шест $pr"; break;
      case '7' : return "седем $pr"; break;
      case '8' : return "осем $pr"; break;
      case '9' : return "девет $pr"; break;
      case '10' : return "десет $pr"; break;
      case '11' : return "единайсет $pr"; break;
      case '12' : return "дванайсет $pr"; break;
      case '13' : return "тринайсет $pr"; break;
      case '14' : return "четиринайсет $pr"; break;
      case '15' : return "петнайсет $pr"; break;
      case '16' : return "шестнайсет $pr"; break;
      case '17' : return "седемнайсет $pr"; break;
      case '18' : return "осемнайсет $pr"; break;
      case '19' : return "деветнайсет $pr"; break;
    }
  }

  for ($i=0;$i<=strlen($number);$i++) {
    if ($i==0) {
      switch (substr($number, 0, 2)) {
        case '1' : $string .= 'хиляда '; break;
        case '2' : $string .= 'две хиляди '; break;
        case '3' : $string .= 'три хиляди '; break;
        case '4' : $string .= 'четири хиляди '; break;
        case '5' : $string .= 'пет хиляди '; break;
        case '6' : $string .= 'шест хиляди '; break;
        case '7' : $string .= 'седем хиляди '; break;
        case '8' : $string .= 'осем хиляди '; break;
        case '9' : $string .= 'девет хиляди '; break;
        case '10' : $string .= 'десет хиляди '; $i++;break;
        case '11' : $string .= 'единайсет хиляди '; $i++;break;
        case '12' : $string .= 'дванайсет хиляди '; $i++;break;
        case '13' : $string .= 'тринайсет хиляди '; $i++;break;
        case '14' : $string .= 'четиринайсет хиляди '; $i++;break;
        case '15' : $string .= 'петнайсет хиляди '; $i++;break;
        case '16' : $string .= 'шестайсет хиляди '; $i++;break;
        case '17' : $string .= 'седемайсет хиляди '; $i++;break;
        case '18' : $string .= 'осемайсет хиляди '; $i++;break;
        case '19' : $string .= 'деветнайсет хиляди '; $i++;break;
      }
    }
    if ($i==2) {
      switch ($number[$i]) {
        case '1' : $string .= 'сто '; break;
        case '2' : $string .= 'двеста '; break;
        case '3' : $string .= 'триста '; break;
        case '4' : $string .= 'четиристотин '; break;
        case '5' : $string .= 'петстотин '; break;
        case '6' : $string .= 'шестотин '; break;
        case '7' : $string .= 'седемстотин '; break;
        case '8' : $string .= 'осемстотин '; break;
        case '9' : $string .= 'деветстотин '; break;
      }
    }
    if ($i==3) {
      if (($number[$i+1]==0)&&($number[$i-1]!=0)&&($number[$i]!=0)&&($number[$i]!=1)) $string .= 'и ';
      switch ($number[$i]) {
        case '1' : $string .= 'и '.convertNumToMoneyStr(substr($number,$i,2),false);
                   break(2);
        case '2' : $string .= 'двадесет '; break;
        case '3' : $string .= 'тридесет '; break;
        case '4' : $string .= 'четиридесет '; break;
        case '5' : $string .= 'петдесет '; break;
        case '6' : $string .= 'шестдесет '; break;
        case '7' : $string .= 'седемдесет '; break;
        case '8' : $string .= 'осемдесет '; break;
        case '9' : $string .= 'деветдесет '; break;
      }
    }
    if ($i==4) {
      switch ($number[$i]) {
        case '1' : $string .= 'и един '; break;
        case '2' : $string .= 'и два '; break;
        case '3' : $string .= 'и три '; break;
        case '4' : $string .= 'и четири '; break;
        case '5' : $string .= 'и пет '; break;
        case '6' : $string .= 'и шест '; break;
        case '7' : $string .= 'и седем '; break;
        case '8' : $string .= 'и осем '; break;
        case '9' : $string .= 'и девет '; break;
      }
    }
  }
  return trim($string).' лева'.$sufix;
}

function generateEnPrimeurCertificate($orderId, $prod_id=null) {
	global $mm;
	$orderId = intval($orderId);
	if(empty($orderId)) return;
	
	$prod_id = intval($prod_id);
	$prod_Where = "";
	if(!empty($prod_id)) {
		// If prod_id specified it always has to generate the certificate - preview
		$prod_Where = "\nAND o.product_id={$prod_id}";
	} else {
		// Check if En Primeur applies when generating for order
		$prod_Where = "\nAND p.coming_date>=CURRENT_DATE";
	}
	
	$enprimeur = $mm->SelAssoc("SELECT 	o.id, o.product_id, p.name_en product_name, o.price, o.disc_price, o.campaign_price, o.final_price,
										o.campaign_id, o.quantity, ws.name_en wine_sort, p.code, v.name vintage, pr.name_en producer, p.coming_date,
										CONCAT(u.fname, ' ', u.lname) buyer, c.name_en country, ord.created_at
								FROM 	order_detail o
										JOIN products p on o.product_id=p.id
										LEFT JOIN orders ord ON ord.id=o.order_id
										LEFT JOIN wine_sorts ws ON ws.id=p.wine_sort_id
										LEFT JOIN vintages v ON v.id=p.vintage_id
										LEFT JOIN producers pr ON pr.id=p.producer_id
										LEFT JOIN users u ON u.id=ord.user_id
										LEFT JOIN countries c ON c.id=p.country_id
								WHERE 	o.order_id=$orderId
										AND
										p.en_primeur=1
										{$prod_Where}
										");
										
										
	if(!empty($enprimeur)) {
		require_once($_SERVER['DOCUMENT_ROOT'] . '/managers/fpdf.php');
		require_once($_SERVER['DOCUMENT_ROOT'] . '/managers/fpdi/fpdi.php');
		$certs = array();
		foreach($enprimeur AS $p) {
			unset($pdf);
			$pdf =& new FPDI();
			$pdf->AddFont('Verdana','','verdana.php');
			$pdf->AddPage();

			//Set the source PDF file
			$pagecount = $pdf->setSourceFile("{$_SERVER['DOCUMENT_ROOT']}/inc/certificate_template.pdf");

			//Import the first page of the file
			$tpl = $pdf->importPage(1);


			//Use this page as template
			// use the imported page and place it at point 20,30 with a width of 170 mm
			$pdf->useTemplate($tpl, 0, 0, 0);

			#Print Hello World at the bottom of the page

			//Select Arial italic 8
			$pdf->SetFont('Verdana','',14);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetXY(108, 109);
			//$pdf->Rotate(90);
			//$pdf->Image('think.jpg',120,240,20,20);
			//$pdf->Image('think.jpg',120,260,20,20);
			$text = "order #{$orderId}";
			$pdf->Write(0, $text);
			
			
			$pdf->SetXY(108, 115);
			$text = "of {$p['product_name']} {$p['vintage']}";
			$pdf->Write(0, $text);
			
			
			$pdf->SetXY(108, 125);
			$text = $p['buyer'];
			$pdf->Write(0, $text);
			
			$pdf->SetXY(108, 134.5);
			$text = date('F d, Y', strtotime($p['created_at']));
			$pdf->Write(0, $text);
			
			
			$pdf->SetFont('Verdana','',15);
			
			$pdf->SetXY(108, 186);
			$text = "{$p['product_name']} {$p['vintage']}";
			$pdf->Write(0, $text);
			
			$pdf->SetXY(108, 195.8);
			$text = "{$p['producer']}, {$p['country']}";
			$pdf->Write(0, $text);
			
			$pdf->SetXY(108, 205);
			if($p['quantity']>1) {
				$text = "{$p['quantity']} bottles (0.75l)";
			} else {
				$text = "{$p['quantity']} bottle (0.75l)";
			}
			$pdf->Write(0, $text);
			
			$total_price = floatval($p['final_price']*$p['quantity']);
			$total_price = number_format($total_price, 2, '.', '');
			$pdf->SetXY(108, 214.8);
			$text = "{$total_price} bgn";
			$pdf->Write(0, $text);
			
			$pdf->SetXY(108, 224.5);
			$text = "after " . date('F d, Y', strtotime($p['coming_date']));;
			$pdf->Write(0, $text);
			
			
			//$pdf->Output();
			if(!empty($prod_id)) {
				$pdf->Output();
				return;
			} else {
				$pdf->Output("{$_SERVER['DOCUMENT_ROOT']}/certs/certificate{$orderId}_{$p['product_id']}.pdf", "F");
			}
			
			$certs[] = "{$_SERVER['DOCUMENT_ROOT']}/certs/certificate{$orderId}_{$p['product_id']}.pdf";
		}
	} else {
		if(!empty($prod_id)) redirect('/profile');
	}
	
	return $certs;
}

function myTruncate($string, $limit, $break=".", $pad="...")
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}
?>