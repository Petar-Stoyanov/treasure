<?php

/**
 * DB class allows you to manage most operations you will need to do with mysql dadtabases
 *
 * @package Mysql DB Management Class
 * @author Ahmed Elbshry(bondo2@bondo2.info)
 * @copyright 2015
 * @version 2.0
 * @access public
 */

define('AUTO_INSERT', 1);
define('AUTO_UPDATE', 2);
define('EMPTY_RESULT', false);
define('PAGING_NEXT_PREV_ONLY',3);
define('PAGING_NEXT_PREV_NUM',4);

class DB {
	/**
	* the database host
	* @var	string
	*/
	private $hostname;
	/**
	* the database name
	* @var	string
	*/
	private $dbname;
	/**
	* the database username
	* @var	string
	*/
	private $dbuser;
	/**
	* the database password
	* @var	string
	*/
	private $dbpass;
	/**
	* the table perfix
	* @var	string
	*/
	private $perfix='';
	/**
	* Whether you want to show the database errors or not
	* @var	boolean
	*/
	private $showerr=true;
	/**
	* the pagination html code
	* @var	string
	*/
	var $pager;
	/**
	* current link with our database
	* @var	object
	*/
	var $link=false;

  /**
   * DB::__construct() - call connect function with specified username and password
   *
   * @param string $hostname - is host that database located in
   * @param string $dbuser - is the username of the database
   * @param string $dbpass - is the password of the database
   * @return
   */
	function __construct($hostname, $dbuser, $dbpass) {
		$this->Connect($hostname, $dbuser, $dbpass);
	}

  /**
   * DB::Connect() -  connect with specified username and password
   *
   * @param string $hostname - is host that database located in
   * @param string $dbuser - is the username of the database
   * @param string $dbpass - is the password of the database
   * @return object $link - is the connection with the database host
   */
	function Connect($hostname, $dbuser, $dbpass) {
		$this->hostname = $hostname;
		$this->dbuser = $dbuser;
		$this->dbpass = $dbpass;
		$this->link = mysqli_connect($this->hostname, $this->dbuser, $this->dbpass);
		if (!$this->link) {
			throw new Exception($this->Err());
			exit();
		} else {
			return $this->link;
		}
	}

  /**
   * DB::UseDB() - select a database to use
   *
   * @param string $dbname - the database name
   * @return boolean
   */
	function UseDB($dbname) {
		$this->dbname = $dbname;

		if (!$selected = mysqli_select_db($this->link, $this->dbname)) {
			throw new Exception($this->Err());
			exit();
		} else {
			return true;
		}

	}

  /**
   * DB::Close() - closes the current connection with the database
   *
   * @return object
   */
	function Close() {
		return mysqli_close($this->link);
	}

  /**
   * DB::Query() - execute mysql query
   *
   * @param string $sql - the text of the query you will execute
   * @return object
   */
	function Query($sql, $silent=false) {
		global $_langs;
		$replace_str = "_" . $_langs[$_SESSION['ln']];

		$sql = str_replace('_ln', $replace_str, $sql);

		$result = mysqli_query($this->link, $sql);
		if (!$silent && !$result) {
			throw new Exception($this->Err($sql));
			exit();
		} elseif($silent) {
			return mysqli_error();
		}
		return $result;
	}

  /**
   * DB::Transaction() - execute mysql transaction
   *
   * @param string $sql - the text of the query you will execute as a transaction
   * @return object
   */
	function Transaction($sql) {
		global $_langs;
		$replace_str = "_" . $_langs[$_SESSION['ln']];

		$sql = str_replace('_ln', $replace_str, $sql);

		@mysqli_query("SET AUTOCOMMIT=0");
		@mysqli_query("BEGIN TRANSACTION");
		$sql = explode(chr(10).'|', $sql);
		foreach ($sql AS $cur_sql) {
			$cur_sql = trim($cur_sql);
			$result = mysqli_query($cur_sql);

			if (!$result) {
				@mysqli_query("ROLLBACK");
				throw new Exception($this->Err($cur_sql));
				exit();
			}
			if(is_resource($result)) {
				$return = ($this->ResultNumRows($result) == EMPTY_RESULT) ? EMPTY_RESULT : mysqli_fetch_array($result,MYSQLI_ASSOC);
			} else {
				$return = $result;
			}
		}

		@mysqli_query("COMMIT");
		@mysqli_query("SET AUTOCOMMIT=1");
		return $return;
	}

  /**
   * DB::Err() - get some information about the databse error
   *
   * @param string $sql - the text of the query you will execute
   * @return string
   */
	function Err($sql='') {
		$err = "
				Mysql Error Occurred<br />
				Error Details:<br />
				File Name: ".__FILE__."<br />
				Line Number: ". __LINE__."<br />
				Err Number: ".mysqli_error($this->link)."<br />
				Err Desc: ".mysqli_error($this->link)."<br />";
		if($sql != '') {
			$err .= "Query Says: <textarea cols='60' rows='8'>$sql</textarea>";
		}
		if ($this->showerr) {
			die($err);
		}
	}

  /**
   * DB::SelAssoc() - execute select query and get it back in associative array, pagination to move throw the records. or array to use with {html_options} in smarty
   *
   * @param string $sql - the text of the query you will execute
   * @param boolean $pager - if you want to activate the pagination function
   * @param integer $perpage - the number records to show per page
   * @param integer $mode - you can choose between the tow conectants PAGING_NEXT_PREV_ONLY or PAGING_NEXT_PREV_NUM
   * @param string $uri - if your page have some get vars assign them here
   * @param integer $pages - if you choose PAGING_NEXT_PREV_NUM in $mode you may need to specify the number of pages to show before and after the current page
   * @return Array
   */
	function SelAssoc($sql, $pager=false, $perpage=9, $mode=4, $uri='', $pages=5, $label='items') {
		global $_langs;
		$replace_str = "_" . $_langs[$_SESSION['ln']];

		$sql = str_replace('_ln', $replace_str, $sql);

		if($pager == true) {
			$result = $this->Query($sql);
			$this->pager = $this->Paging($perpage,$this->ResultNumRows($result),$mode,$pages,$uri, $label);
			if(!empty($_GET['page']) && ($this->IntValue( $_GET['page']) > 1)) {
				$current = $this->IntValue($_GET['page'] - 1) * $perpage;
				$sql .= " LIMIT $current , $perpage";
			} else {
				$sql .= " LIMIT $perpage";
			}

		}

		$result = $this->Query($sql);
		if ($result) {
			if ($this->ResultNumRows($result) == EMPTY_RESULT) return EMPTY_RESULT;
			while ($row = @mysqli_fetch_array($result,MYSQLI_ASSOC)) {
				reset($row);
				$rs[$row[key($row)]] = $row;
			}
			return $rs;
		}
	}

  /**
   * DB::SelArr() - execute select query and get it back in associative and numric array, pagination to move throw the records.
   *
   * @param string $sql - the text of the query you will execute
   * @param boolean $pager - if you want to activate the pagination function
   * @param integer $perpage - the number records to show per page
   * @param integer $mode - you can choose between the tow conectants PAGING_NEXT_PREV_ONLY or PAGING_NEXT_PREV_NUM
   * @param string $uri - if your page have some get vars assign them here
   * @param integer $pages - if you choose PAGING_NEXT_PREV_NUM in $mode you may need to specify the number of pages to show before and after the current page
   * @return Array
   */
	function SelArr($sql, $pager=false, $perpage=10, $mode=4, $uri='', $pages=3) {
		if($pager == true) {
			$result = $this->Query($sql);
			$this->pager = $this->Paging($perpage,$this->ResultNumRows($result),$mode,$pages,$uri);
			$current = $this->IntValue($_GET['page']) * 10;
			$sql .= " LIMIT $current , $perpage";
		}
		global $_langs;
		$replace_str = "_" . $_langs[$_SESSION['ln']];

		$sql = str_replace('_ln', $replace_str, $sql);

		$result = $this->Query($sql);
		if ($result) {
			if ($this->ResultNumRows($result) == EMPTY_RESULT)
				return EMPTY_RESULT;

			while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                $rs = $row;
	        }
			return $rs;
		}
	}

  /**
   * DB::SelOne() - execute select query and get the first feild from the first record in the result
   *
   * @param string $sql - the text of the query you will execute
   * @return string
   */
	function SelOne($sql) {
		global $_langs;
		$replace_str = "_" . $_langs[$_SESSION['ln']];

		$sql = str_replace('_ln', $replace_str, $sql);
		$result = $this->Query($sql);
		if ($result) {
			$rs = $this->FetchRow($result);
			return ($rs == EMPTY_RESULT) ? EMPTY_RESULT : $rs[0];
		}
	}

  /**
   * DB::FetchRow() - fetching row from given result
   *
   * @param object $res
   * @return
   */
	function FetchRow($res) {
		$rs = mysqli_fetch_row($res);
		return (is_array($rs)) ? $rs : EMPTY_RESULT;
	}

  /**
   * DB::SelRow() - execute select query and get the first row from the result
   *
   * @param string $sql - the text of the query you will execute
   * @return Array
   */
	function SelRow($sql) {
		global $_langs;
		$replace_str = "_" . $_langs[$_SESSION['ln']];

		$sql = str_replace('_ln', $replace_str, $sql);
		$res = $this->Query($sql);
		$rs = $this->FetchRow($res);
		return $rs;
	}

  /**
   * DB::AutoExecute() - execute INSERT or UPDATE query
   *
   * @param string $table - the table you will INSERT or UPDATE in it
   * @param array $keys_values - array from the feilds and values
   * @param integer $autoEx - you can choose between AUTO_INSERT (to insert new record) and AUTO_UPDATE (to update record)
   * @param string $where - if you choose AUTO_UPDATE you will need to specify where condition
   * @return object
   */
	function AutoExecute($table,$keys_values,$autoEx,$where=false, $silent=false) {
		$first = true;
		switch ($autoEx) {
            case AUTO_INSERT:
                $values = '';
                $names = '';
                foreach ($keys_values as $key=>$value) {
                    if ($first) {
                        $first = false;
                    } else {
                        $names .= ',';
                        $values .= ',';
                    }
                    $names .= $key;
                    if($value!='NULL') $value =  $this->Quote($value);
                    $values .= $value;
                }
                $sql = "INSERT INTO $table ($names) VALUES ($values);";
                break;
            case AUTO_UPDATE:
                $set = '';
                foreach ($keys_values as $key=>$value) {
                    if ($first) {
                        $first = false;
                    } else {
                        $set .= ',';
                    }
                    if($value!='NULL') $value =  $this->Quote($value);
                    $set .= "$key = ".$value;

                }
                $sql = "UPDATE $table SET $set";
                if ($where) {
                    $sql .= " WHERE $where";
                }
                break;
            default:
                throw new Exception("Check the variable autoEx, '$autoEx' Not a Valid option to AutoExecute function");
                exit();
        }
        $res = $this->Query($sql, $silent);
        return $res;
	}

  /**
   * DB::Quote() - prepare string to inserted or updated in the database
   *
   * @param string $string
   * @return string
   */
	function Quote($string = null) {
		if($string === null) return 'NULL';
		$string =  str_replace(array("\'",'\"'),array("'",'"'), $string);
        $string = str_replace(array("'"), array("\'"), $string);
        return "'$string'";
    }

  /**
   * DB::ResultNumRows() - get the number of rows in select query
   *
   * @param object $result
   * @return integer
   */
    function ResultNumRows($result) {
		if($result) {
			$num_rows = mysqli_num_rows($result);
			return ($num_rows > 0)? $num_rows : EMPTY_RESULT;
		} else {
			throw new Exception("Not a valid Result to ResultNumRows function, check \$result var");
			exit();
		}
	}

  /**
   * DB::IntValue() - make the given value integer
   *
   * @param mixed $value
   * @return integer
   */
	function IntValue($value) {
		if (is_int($value))
			return $value;
		$value = intval($value);
		return $value;
	}

  /**
   * DB::GetId() - you may need to get the id of the last inserted record
   *
   * @return integer
   */
	function GetId() {
		$id = mysqli_insert_id($this->link);
		if (is_numeric($id))
			return $this->IntValue($id);
		else
			return false;
	}

  /**
   * DB::AddSlashes() - make string save to use
   *
   * @param string $str
   * @return string
   */
	function AddSlashes($str) {
		if (!get_magic_Quotes_gpc()) {
	    	$str = addslashes(strip_tags($str));
		} else {
		    $str = strip_tags($str);
		}
		return $str;
	}

  /**
   * DB::Paging() - you cann't call this function outsite but it uesd to generate the pagination html code
   *
   * @param integer $perpage - the number records to show per page
   * @param integer $count - total recordes to show
   * @param integer $mode - you can choose between the tow conectants PAGING_NEXT_PREV_ONLY or PAGING_NEXT_PREV_NUM
   * @param string $uri - if your page have some get vars assign them here
   * @param integer $pages - if you choose PAGING_NEXT_PREV_NUM in $mode you may need to specify the number of pages to show before and after the current page
   * @return string
   */
	private function Paging($perpage=10,$count,$mode=4,$pages=10,$uri='',$label) {
		global $PAGE_ID;
		if(!empty($_GET['page'])) {
			$current = $this->IntValue($_GET['page']);
		} else {
			$current = 1;
		}
		if($uri != '') {
			$link = "?".$uri."&page=";
		} else {
			$link = "?page=";
		}
		$totalpages = ceil($count/$perpage);
		if($current > $totalpages) {
			$current = 1;
		}

		if($PAGE_ID>0) {
			if($pages==10) {
				$pages = false;
			}
			$pager = $this->generate_pagination($count, $perpage, $current, true, $label, $pages);
			$this->pager = $pager;
			return $pager;
		}
		switch($_SESSION['ln']) {
			case 1:
				$next_lbl = 'Next';
				$prev_lbl = 'Previous';
				$last_lbl = 'Last';
				$first_lbl = 'First';
				break;
			case 3:
				$next_lbl = 'Следваща';
				$prev_lbl = 'Предишна';
				$last_lbl = 'Последна';
				$first_lbl = 'Първа';
				break;
			default:
				$next_lbl = 'Следваща';
				$prev_lbl = 'Предишна';
				$last_lbl = 'Последна';
				$first_lbl = 'Първа';
				break;
		}
		switch ($mode) {
			case PAGING_NEXT_PREV_NUM:
				$pager .= '<div class="pagination">';

				if($totalpages>1) $pager .= "<span class='page_no'>Total results found: <b>$count</b>&nbsp;&nbsp;&nbsp;Page $current of $totalpages</span>";

				$pager .= "<ul class='pag_list'>";
				if(($current == 0) || ($current == 1)) {
					$current = 1;
					if(($totalpages - $pages) <= 0){
						$myloop = $totalpages;
						$havelast = true;
					} else {
						$myloop = $pages;
					}
					for($i=1;$i<=$myloop;$i++) {
						if($i==$current) {
							$pager .= "<li><a href='#' class='current_page'><span><span>$i</span></span></a></li>";
						} else {
							$pager .= "<li><a href='$link$i'>$i</a></li>";
						}
					}

					if($totalpages > 1) {
						$pager .= "<li><a href='".$link.($current+1)."' class='button light_blue_btn next'><span><span>{$next_lbl}</span></span></a> </li>";
					}
					if($totalpages > $pages) {
						$pager .= '<li><a href="'.$link.$totalpages.'" class="button light_blue_btn next"><span><span>'.$last_lbl.'</span></span></a></li>';
					}

				} else {
					if(($current - ($pages +1) > 0)) {
						$pager .= "<li><a href='".$link."1' class='button light_blue_btn prev'><span><span>{$first_lbl}</span></span></a> </li>";
					}
					$pager .= "<li><a href='".$link.($current-1)."' class='button light_blue_btn prev'><span><span>{$prev_lbl}</span></span></a> </li>";
					if(($current - $pages) > 0) {
						for($i=($current - $pages);$i<=$current;$i++) {
							if($i==$current) {
								$pager .= "<li><a href='#' class='current_page'><span><span>$i</span></span></a></li>";
							} else {
								$pager .=  "<li><a href='$link$i'>$i</a></li>";
							}
						}
					} else {
						for($i=1;$i<=$current;$i++) {
							if($i==$current) {
								$pager .= "<li><a href='#' class='current_page'><span><span>$i</span></span></a></li>";
							} else {
								$pager .= "<li><a href='$link$i'>$i</a></li>";
							}
						}
					}
					if((($totalpages - $current) > 0) && (($totalpages - $current) <= $pages)) {
						for($i=$current+1;$i<=$totalpages;$i++) {
							if($i==$current) {
								$pager .=  "<li><a href='#' class='current_page'><span><span>$i</span></span></a></li>";
							} else {
								$pager .= "<li><a href='$link$i'>$i</a></li>";
							}
						}
					} elseif(($totalpages - $current) > $pages) {
						for($i=$current+1;$i<=($current+$pages);$i++) {
							if($i==$current) {
								$pager .=  "<li><a href='#' class='current_page'><span><span>$i</span></span></a></li>";
							} else {
								$pager .= "<li><a href='$link$i'>$i</a></li>";
							}
						}
					}
					if($current < $totalpages) {
						$pager .= "<li><a href='".$link.($current+1)."' class='button light_blue_btn next'><span><span>{$next_lbl}</span></span></a> </li>";
					}
					if($totalpages > ($pages+$current)) {
						$pager .= '<li><a href="'.$link.$totalpages.'" class="button light_blue_btn next"><span><span>'.$last_lbl.'</span></span></a></li>';
					}
				}
				break;
			case PAGING_NEXT_PREV_ONLY:
				if($current > 1) {
					$pager .= ($_GET['lang'] == 'en') ? '<div id="pager-np"><a href="'.$link.($current-1).'">Prev</a></div>' : '<div id="pager-np"><a href="'.$link.($current-1).'"></a></div>';
				} else {
					$pager .= ($_GET['lang'] == 'en') ? '<div id="pager-np"><a href="'.$link.($current-1).'">Prev</a></div>' : '<div id="pager-np"><</div>';
				}
				if(($totalpages - $current) > 0) {
					$pager .= ($_GET['lang'] == 'en') ? '<div id="pager-np"><a href="'.$link.($current+1).'">next</a></div>' : '<div id="pager-np"><a href="'.$link.($current+1).'">></a></div>';
				} else {
					$pager .= ($_GET['lang'] == 'en') ? '<div id="pager-np"><a href="'.$link.($current+1).'">next</a></div>' : '<div id="pager-np">></div>';
				}
				break;
		}
		$pager .= '</ul></div>';
		$this->pager = $pager;
		return $pager;
	}

	private function generate_pagination($num_items, $per_page, $start_item, $add_prevnext_text = false, $label, $pages = false) {

		$FILTER = getFilter($_GET);
		switch($_SESSION['ln']) {
			case 1:
				$next_lbl = '&raquo;';
				$prev_lbl = '&laquo;';

				break;
			case 3:
				$next_lbl = '&raquo;';
				$prev_lbl = '&laquo;';

				break;
			default:
				$next_lbl = '&raquo;';
				$prev_lbl = '&laquo;';

				break;
		}
		$base_url = replace_param_in_url(array('page'=>null,'ajax'=>null));
		// Make sure $per_page is a valid value
		$per_page = ($per_page <= 0) ? 1 : $per_page;

		$seperator = '<span class="page-sep">, </span>';
		$total_pages = ceil($num_items / $per_page);
		$num_items = intval($num_items);
		if($pages==1) {
			$total_pages = 1;
			$num_items = $per_page;
		}
		$lbl = "{$num_items} ";
		if($num_items==1) {
			if(isset($FILTER['accessoires'])) {
				$lbl .= text::get('accessory', 2);
			} else if(isset($FILTER['vouchers'])) {
				$lbl .= text::get('voucher', 2);
			} else if(isset($FILTER['alchohol'])) {
				$lbl .= text::get('alchohol', 2);
			} else if(isset($FILTER['books'])) {
				$lbl .= text::get('book', 2);
			} else if(isset($FILTER['mixedcases'])) {
				$lbl .= text::get('mixedcase', 2);
			} else {
				switch($label) {
					case 'items':
						$lbl .= text::get('item', 2);
						break;
					case 'news':
						$lbl .= text::get('pgr_news1', 2);
						break;
					default:
						$lbl .= text::get('item', 2);
						break;
				}

			}
		} else {
			if(isset($FILTER['accessoires'])) {
				$lbl .= text::get('accessoires', 2);
			} else if(isset($FILTER['vouchers'])) {
				$lbl .= text::get('vouchers', 2);
			} else if(isset($FILTER['alchohol'])) {
				$lbl .= text::get('alchohols', 2);
			} else if(isset($FILTER['books'])) {
				$lbl .= text::get('books', 2);
			} else if(isset($FILTER['mixedcases'])) {
				$lbl .= text::get('mixedcases', 2);
			} else {
				switch($label) {
					case 'items':
						$lbl .= text::get('items', 2);
						break;
					case 'news':
						$lbl .= text::get('pgr_news', 2);
						break;
					default:
						$lbl .= text::get('items', 2);
						break;
				}
			}
		}

		$total_lbl = "<a href='' class='pag_label'>{$lbl}</a>";
		if ($total_pages == 1 || !$num_items)
		{

			$page_string = "<div class='paginator'><div class='box'>{$total_lbl}<a href='' class='active'>1</a></div></div>";

			return $page_string;
		}

		$on_page = $start_item;
		$url_delim = (strpos($base_url, '?') === false) ? '?' : '&amp;';
		$url_delim .= 'page=';


		$page_string .= ($on_page == 1) ? '<a href="" class="active">1</a>' : "<a href='{$base_url}{$url_delim}1'>1</a>";

		if ($total_pages > 5)
		{
			$start_cnt = min(max(1, $on_page - 4), $total_pages - 5);
			$end_cnt = max(min($total_pages, $on_page + 4), 6);

			$page_string .= ($start_cnt > 1) ? '<a href="" class="pag_sep">...</a>' : "";

			for ($i = $start_cnt + 1; $i < $end_cnt; $i++)
			{
				$page_string .= ($i == $on_page) ? "<a href='' class='active'>{$i}</a>" : "<a href='{$base_url}{$url_delim}{$i}'>{$i}</a>";
				if ($i < $end_cnt - 1)
				{
					//$page_string .= $seperator;
				}
			}

			$page_string .= ($end_cnt < $total_pages) ? '<a href="" class="pag_sep">...</a>' :"";
		}
		else
		{
			//$page_string .= $seperator;

			for ($i = 2; $i < $total_pages; $i++)
			{
				$page_string .= ($i == $on_page) ? "<a href='' class='active'>{$i}</a>" : "<a href='{$base_url}{$url_delim}{$i}'>{$i}</a>";
				if ($i < $total_pages)
				{
					//$page_string .= $seperator;
				}
			}
		}

		$page_string .= ($on_page == $total_pages) ? "<a href='' class='active'>{$total_pages}</a>" : "<a href='{$base_url}{$url_delim}{$total_pages}'>{$total_pages}</a>";

		if ($add_prevnext_text)
		{
			if ($on_page != 1)
			{
				$page_string = "<a href='{$base_url}{$url_delim}".($on_page-1)."' class='prev'>{$prev_lbl}</a>" . $page_string;
			} else {
				//$page_string = "<a href='' class='prev_na'>{$prev_lbl}</a>" . $page_string;
				$page_string = $page_string;
			}

			if ($on_page != $total_pages)
			{
				$page_string .= "<a href='{$base_url}{$url_delim}".($on_page+1)."' class='next'>{$next_lbl}</a>";
			} else {
				//$page_string .= "<a href='' class='next_na'>{$next_lbl}</a>";
			}
		}

		$page_string = "<div class='paginator'><div class='box'>{$total_lbl}" . $page_string;

		$page_string .= '</div></div>';
		return $page_string;
	}
}

?>
