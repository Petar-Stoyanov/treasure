<?
abstract class text {
	public static function get($textid, $pageid=null, $lang=null) {
		global $_text, $PAGE_ID, $_config, $_langs;
		
		if(is_null($pageid)) $pageid = $PAGE_ID;
		if(is_null($pageid)) return "*{$textid}*";
		
		if(empty($textid)) return '';
		
		require("{$_config['root_dir']}/inc/page_{$pageid}.php");
		
		if(empty($lang)) $lang = $_langs[$_SESSION['ln']];
		
		if(isset($_text[$textid])) {
			return $_text[$textid][$lang];
		}else{
			return "*{$textid}*";
		}
	}

}
?>