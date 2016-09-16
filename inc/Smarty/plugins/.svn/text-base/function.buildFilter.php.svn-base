<?php
/**
 * template_lite {buildFilter} function plugin
 *
 * Type:     function
 * Name:     buildFilter
 * Purpose:  Returns the 10 top wines mostly ordered 
 * Author:   Konstantin Radoslavov
 */
function tpl_function_buildFilter($params, &$tpl) {
	global $mm, $_langs;
	
	require_once("shared.escape_chars.php");
	extract($params);
	
	if(empty($filter)) return "";
	$langUrl = '';
	if($_SESSION['ln']==1) $langUrl = "en/";
	switch($filter) {
		case 'country';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'country, country_group');
			}
			
			if(isset($FILTER['accessoires'])) {
				$ptype_id = "9";
				$FILTER['product_type'] = 'accessoires';
			} elseif(isset($FILTER['mixedcases'])) {
				$ptype_id = "12";
				$FILTER['product_type'] = 'mixedcases';
			} elseif(isset($FILTER['books'])) {
				$ptype_id = "13";
				$FILTER['product_type'] = 'books';
			} else {
				$ptype_id = "1";
				$FILTER['product_type'] = 'wine';
			}
			
			$groups = array();
			$data = $mm->SelAssoc("SELECT 	DISTINCT p.country_id, c.name_ln country, c.country_group_id, cg.name_ln group_name,
											(SELECT COUNT(*) FROM products pr WHERE pr.country_id=c.id AND pr.deleted=0 AND pr.hidden=0 AND pr.type_id={$ptype_id}) cnt
									FROM 	products p
											LEFT JOIN countries c ON c.id=p.country_id
											LEFT JOIN country_groups cg ON cg.id=c.country_group_id
									WHERE 	p.country_id IS NOT NULL
											AND
											p.hidden=0
											AND
											p.deleted=0
											AND
											p.type_id={$ptype_id}
											AND
											c.country_group_id IS NOT NULL");
			
			$toReturn = '<div id="dd" class="wrapper-dropdown">';
			$toReturn .= text::get('country',0);
			$toReturn .= '<ul class="dropdown">';
			
			if($data) {
				
				foreach($data AS $fltr) {
					if(!isset($groups[$fltr['country_group_id']])) {
						$groups[$fltr['country_group_id']] = array();
						$groups[$fltr['country_group_id']]['name'] = $fltr['group_name'];
						$groups[$fltr['country_group_id']]['data'] = array();
					}
					$groups[$fltr['country_group_id']]['data'][] = $fltr;
					$toReturn .= "<li><a ".($FILTER['country']==$fltr['country_id']?"class='active'":"")." href='/{$langUrl}search/?country={$fltr['country_id']}'>{$fltr['country']}</a></li>";
				}
				
			}
			
			
			/*
			if(!empty($groups)) {
				$win_lbl = text::get('wineries', 0);
				foreach($groups AS $group_id=>$item) {
					$toReturn .= "<li><a ".($FILTER['country_group']==$group_id?"class='active'":"")." href='/{$langUrl}search/?country_group={$group_id}'>{$item['name']}</a><ul id='country_menu'>";
					if(!empty($item['data'])) {
						
						foreach($item['data'] AS $sub) {
							$wineries = $mm->SelAssoc("SELECT p.id, p.name_ln name, (SELECT COUNT(*) FROM products pr WHERE pr.producer_id=p.id AND pr.deleted=0 AND pr.hidden=0 AND pr.type_id={$ptype_id}) cnt FROM producers p LEFT JOIN regions r ON r.id=p.region_id WHERE r.country_id={$sub['country_id']} AND EXISTS(SELECT 1 FROM products pr WHERE pr.producer_id=p.id AND pr.hidden=0 AND pr.deleted=0 LIMIT 1) AND p.hidden=0 ORDER BY p.name_ln ASC");
							
							$toReturn .= "<li><a ".($FILTER['country']==$sub['country_id']?"class='active'":"")." href='/{$langUrl}search/?country={$sub['country_id']}'>{$sub['country']} ({$sub['cnt']})</a>";
							if(!empty($wineries)) {
								$toReturn .= "<ul><li><a href='#'>{$win_lbl}</a><ul>";
								$cnt = 0;
								foreach($wineries AS $w) {
									$cnt++;
									$toReturn .= "<li><a href='/{$langUrl}search/?winery={$w['id']}'>{$w['name']} ({$w['cnt']})</a></li>";
									if($cnt%20==0) {
										$toReturn .= "</ul></li><li><ul>";
									}
								}
								$toReturn .= "</ul></li></ul>";
								unset($wineries);
							}
							$toReturn .= "</li>";
						}
					}
					
					$toReturn .= "</ul></li>";
				}
			}
			*/
			$toReturn .= '</ul></div>';
		
			break;
		case 'winetype';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'type');
			}
			
			if(isset($FILTER['accessoires'])) {
				$ptype_id = "9";
				$FILTER['product_type'] = 'accessoires';
			} elseif(isset($FILTER['mixedcases'])) {
				$ptype_id = "12";
				$FILTER['product_type'] = 'mixedcases';
			} elseif(isset($FILTER['books'])) {
				$ptype_id = "13";
				$FILTER['product_type'] = 'books';
			} else {
				$ptype_id = "1";
				$FILTER['product_type'] = 'wine';
			}
			
			$groups = array();
			$data = $mm->SelAssoc("SELECT id, name_ln name FROM product_category WHERE hidden=0 AND product_type_id={$ptype_id} ORDER BY zindex ASC, id ASC");
			
			if($data) {
				
				foreach($data AS $fltr) {
					if(!isset($groups[$fltr['id']])) {
						$groups[$fltr['id']] = array();
						$groups[$fltr['id']]['name'] = $fltr['name'];
						$groups[$fltr['id']]['data'] = array();
					}
				}
				
			}
			
			$toReturn = '<div id="dd" class="wrapper-dropdown">';
			$toReturn .= text::get('type of wine', 0);
			$toReturn .= '<ul class="dropdown">';
			
			if(!empty($groups)) {
					
				foreach($groups AS $type_id=>$item) {
					
					$toReturn .= "<li><a ".($FILTER['type']==$type_id?"class='active'":"")." href='/{$langUrl}search/?type={$type_id}'>{$item['name']}</a></li>";
				}
			}
			
			$toReturn .= '</ul></div>';
			
			break;
		case 'winery';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'winery,region,country');
			}
			
			if(isset($FILTER['accessoires'])) {
				$ptype_id = "9";
				$FILTER['product_type'] = 'accessoires';
			} elseif(isset($FILTER['mixedcases'])) {
				$ptype_id = "12";
				$FILTER['product_type'] = 'mixedcases';
			} elseif(isset($FILTER['books'])) {
				$ptype_id = "13";
				$FILTER['product_type'] = 'books';
			} else {
				$ptype_id = "1";
				$FILTER['product_type'] = 'wine';
			}
			
			//winery
			$region_where = "";
			if(!empty($FILTER['region'])) {
				$region_where .= " AND p.region_id={$FILTER['region']}";
			}
			if(!empty($FILTER['country'])) {
				$region_where .= " AND r.country_id={$FILTER['country']}";
			}
			//$data = $mm->SelAssoc("SELECT p.id, p.name_ln name FROM producers p LEFT JOIN regions r ON r.id=p.region_id WHERE p.hidden=0 AND p.alctypeId=1{$region_where} ORDER BY p.name_ln ASC");
			$data = $mm->SelAssoc("SELECT 	DISTINCT pr.producer_id, 
											p.name_bg `name` 
									FROM 	products pr
											LEFT JOIN producers p ON p.id=pr.producer_id
											LEFT JOIN regions r ON r.id=p.region_id 
									WHERE 	p.hidden=0 
											AND
											pr.hidden=0
											AND
											pr.deleted=0
											AND
											pr.type_id={$ptype_id}
											AND 
											p.alctypeId=1
											{$region_where}
									ORDER BY p.name_bg ASC");
			
		
			
			$toReturn = '<div id="dd" class="wrapper-dropdown">';
			$toReturn .= text::get('winery', 0);
			$toReturn .= '<ul class="dropdown">';
			
			if(!empty($data)) {		
				foreach($data AS $id=>$name) {
					
					$toReturn .= "<li><a ".($FILTER['winery']==$id?"class='active'":"")." href='/{$langUrl}search/?winery={$id}'>{$name['name']}</a></li>";
				}
			}
			
			$toReturn .= '</ul></div>';
			
			break;
		case 'variety';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'color,variery');
			}
			
			if(isset($FILTER['accessoires'])) {
				$ptype_id = "9";
				$FILTER['product_type'] = 'accessoires';
			} elseif(isset($FILTER['mixedcases'])) {
				$ptype_id = "12";
				$FILTER['product_type'] = 'mixedcases';
			} elseif(isset($FILTER['books'])) {
				$ptype_id = "13";
				$FILTER['product_type'] = 'books';
			} else {
				$ptype_id = "1";
				$FILTER['product_type'] = 'wine';
			}
			
			//variety
			if(!empty($FILTER['color'])) {
				$data = $mm->SelAssoc("SELECT 	DISTINCT pr.wine_sort_id, 
											s.name_ln `name` 
									FROM 	products pr
											LEFT JOIN wine_sorts s ON s.id=pr.wine_sort_id
									WHERE 	s.hidden=0 
											AND
											pr.hidden=0
											AND
											pr.deleted=0
											AND
											pr.color={$FILTER['color']}
									ORDER BY s.name_ln ASC");
			} else {
				$data = $mm->SelAssoc("SELECT id, name_ln name FROM wine_sorts WHERE hidden=0 ORDER BY name_ln ASC");
			}

			$toReturn = '<div id="dd" class="wrapper-dropdown">';
			$toReturn .= text::get('variety', 0);
			$toReturn .= '<ul class="dropdown">';
			
			if(!empty($data)) {		
				foreach($data AS $id=>$name) {
					
					$toReturn .= "<li><a ".($FILTER['variety']==$id?"class='active'":"")." href='/{$langUrl}search/?variety={$id}'>{$name['name']}</a></li>";
				}
			}
			
			$toReturn .= '</ul></div>';
			
			break;
		case 'vintage';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'vintage');
			}
			
			if(isset($FILTER['accessoires'])) {
				$ptype_id = "9";
				$FILTER['product_type'] = 'accessoires';
			} elseif(isset($FILTER['mixedcases'])) {
				$ptype_id = "12";
				$FILTER['product_type'] = 'mixedcases';
			} elseif(isset($FILTER['books'])) {
				$ptype_id = "13";
				$FILTER['product_type'] = 'books';
			} else {
				$ptype_id = "1";
				$FILTER['product_type'] = 'wine';
			}
			
			//vintage
			$data = $mm->SelAssoc("SELECT id, name FROM vintages WHERE hidden=0 ORDER BY name ASC");

			$toReturn = '<div id="dd" class="wrapper-dropdown">';
			$toReturn .= text::get('vintage', 0);
			$toReturn .= '<ul class="dropdown">';
			
			if(!empty($data)) {		
				foreach($data AS $id=>$name) {
					
					$toReturn .= "<li><a ".($FILTER['vintage']==$id?"class='active'":"")." href='/{$langUrl}search/?vintage={$id}'>{$name['name']}</a></li>";
				}
			}
			
			$toReturn .= '</ul></div>';
			
			break;
		case 'price';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'price');
			}
			
			if(isset($FILTER['accessoires'])) {
				$ptype_id = "9";
				$FILTER['product_type'] = 'accessoires';
			} elseif(isset($FILTER['mixedcases'])) {
				$ptype_id = "12";
				$FILTER['product_type'] = 'mixedcases';
			} elseif(isset($FILTER['books'])) {
				$ptype_id = "13";
				$FILTER['product_type'] = 'books';
			} else {
				$ptype_id = "1";
				$FILTER['product_type'] = 'wine';
			}
			
			//price ranges
			$data = $mm->SelAssoc("SELECT id, from_amount, to_amount FROM wine_price_ranges ORDER BY to_amount asc");

			$toReturn = '<div id="dd" class="wrapper-dropdown">';
			$toReturn .= text::get('price', 0);
			$toReturn .= '<ul class="dropdown">';
			
			if(!empty($data)) {		
				$fromLbl = text::get('from', 0);
				$toLbl = text::get('to', 0);
				$lvLbl = text::get('lv', 0);
				foreach($data AS $id=>$name) {
					
					$toReturn .= "<li><a ".($FILTER['price']==$id?"class='active'":"")." href='/{$langUrl}search/?price={$id}'>{$fromLbl} {$name['from_amount']}{$lvLbl} {$toLbl} {$name['to_amount']}{$lvLbl}</a></li>";
				}
			}
			
			$toReturn .= '</ul></div>';
			
			break;
		case 'region';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'region');
			}
			
			if(isset($FILTER['accessoires'])) {
				$ptype_id = "9";
				$FILTER['product_type'] = 'accessoires';
			} elseif(isset($FILTER['mixedcases'])) {
				$ptype_id = "12";
				$FILTER['product_type'] = 'mixedcases';
			} elseif(isset($FILTER['books'])) {
				$ptype_id = "13";
				$FILTER['product_type'] = 'books';
			} else {
				$ptype_id = "1";
				$FILTER['product_type'] = 'wine';
			}
			
			$groups = array();
			//Regions
			$data = $mm->SelAssoc("SELECT 	DISTINCT p.region_id, r.name_ln name
									FROM 	products p
											LEFT JOIN regions r ON r.id=p.region_id
									WHERE 	p.region_id IS NOT NULL
											AND
											p.hidden=0
											AND
											p.deleted=0
											AND
											p.type_id={$ptype_id}
									ORDER BY r.name_ln ASC
									");
					
			if($data) {
				
				foreach($data AS $fltr) {
					if(!isset($groups[$fltr['region_id']])) {
						$groups[$fltr['region_id']] = array();
						$groups[$fltr['region_id']]['name'] = $fltr['name'];
					}
				}
				
			}
			
			$toReturn = '<div id="dd" class="wrapper-dropdown">';
			$toReturn .= text::get('region', 0);
			$toReturn .= '<ul class="dropdown">';
			if(!empty($groups)) {
					
				foreach($groups AS $type_id=>$item) {
					
					$toReturn .= "<li><a ".($FILTER['region']==$type_id?"class='active'":"")." href='/{$langUrl}search/?region={$type_id}'>{$item['name']}</a></li>";
				}
			}
			
			$toReturn .= '</ul></div>';
			
			break;
		case 'popular';
			$FILTER = getFilter($_GET);
			
			$groups = array();
			$data = $mm->SelAssoc("SELECT id, name_ln name, url FROM popular_searches ORDER BY zindex ASC, id ASC");
			
			if($data) {
				
				foreach($data AS $fltr) {
					if(!isset($groups[$fltr['id']])) {
						$groups[$fltr['id']] = array();
						$groups[$fltr['id']]['name'] = $fltr['name'];
						$groups[$fltr['id']]['url'] = $fltr['url'];
					}
				}
				
			}
			
			if(!empty($groups)) {
				
				foreach($groups AS $type_id=>$item) {
					$url = parse_url($item['url']);
					
					$url['path'] = str_replace("/en/", "", $url['path']);
					
					if($_SESSION['ln']==1) {
						if($url['path'][0]!='/') {
							$url['path'] = '/' . $url['path'];
						}
						$url['path'] = "/en" . $url['path'];
					}
					if($url['path'][0]!='/') {
						$url['path'] = '/' . $url['path'];
					}
					$item['url'] = $url['path'] . "?" . $url['query']; 
					$toReturn .= "<li><a href='{$item['url']}'>{$item['name']}</a></li>";
				}
			}
		
			break;
		case 'winecolor';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'color');
			}
			$groups = array();
			$data = $mm->SelAssoc("SELECT id, name_ln name FROM wine_colors ORDER BY id ASC");
			
			if($data) {
				
				foreach($data AS $fltr) {
					if(!isset($groups[$fltr['id']])) {
						$groups[$fltr['id']] = array();
						$groups[$fltr['id']]['name'] = $fltr['name'];
						$groups[$fltr['id']]['data'] = array();
					}
				}
				
			}
			
			$toReturn = '<div id="dd" class="wrapper-dropdown">';
			$toReturn .= text::get('wine color', 0);
			$toReturn .= '<ul class="dropdown">';
			
			if(!empty($groups)) {
				
				foreach($groups AS $type_id=>$item) {
					$toReturn .= "<li><a ".($FILTER['color']==$type_id?"class='active'":"")." href='/{$langUrl}search/?color={$type_id}'>{$item['name']}</a></li>";
				}
			}
			
			$toReturn .= '</ul></div>';
		
			break;
		case 'search';
			$FILTER = getFilter($_GET);
			if(!empty($FILTER)) {
				$FILTER = intval_filter($FILTER, 'country, type, region, variety, vintage, price, closure, strength, maturity, options, winery, color');
			}
			
			if(isset($FILTER['accessoires'])) {
				$ptype_id = "9";
				$FILTER['product_type'] = 'accessoires';
			} elseif(isset($FILTER['mixedcases'])) {
				$ptype_id = "12";
				$FILTER['product_type'] = 'mixedcases';
			} elseif(isset($FILTER['books'])) {
				$ptype_id = "13";
				$FILTER['product_type'] = 'books';
			} else {
				$ptype_id = "1";
				$FILTER['product_type'] = 'wine';
			}
			
			if(isset($product_type)) {
				$FILTER['product_type'] = $product_type;
				switch($product_type) {
					case "wine":
						$ptype_id = "1";
						break;
					case "books":
						$ptype_id = "13";
						break;
					case "accessoires":
						$ptype_id = "9";
						break;
					case "mixedcases":
						$ptype_id = "12";
						break;
				}
			}
			
			if(in($FILTER['product_type'], 'wine', 'mixedcases')) {
				$toReturn = "";
				//Wine type
				$data = $mm->SelAssoc("SELECT id, name_ln name FROM product_category WHERE hidden=0 AND product_type_id={$ptype_id} ORDER BY zindex ASC, id ASC");
				
				if(!empty($data)) {
					$lbl = text::get('type of wine');
					$toReturn .= "<select name='type' id='type'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						
						$toReturn .= "<option value='{$id}' ".($FILTER['type']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				}
				
				//Wine color
				$data = $mm->SelAssoc("SELECT id, name_ln name FROM wine_colors ORDER BY name_ln ASC");
				
				if(!empty($data)) {
					$lbl = text::get('wine color');
					$toReturn .= "<select name='color' id='color'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						
						$toReturn .= "<option value='{$id}' ".($FILTER['color']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				}
			}
			
			//Countries
			$data = $mm->SelAssoc("SELECT 	DISTINCT p.country_id, c.name_ln name, c.country_group_id
									FROM 	products p
											LEFT JOIN countries c ON c.id=p.country_id
									WHERE 	p.country_id IS NOT NULL
											AND
											p.hidden=0
											AND
											p.deleted=0
											AND
											p.type_id={$ptype_id}
											AND
											c.country_group_id IS NOT NULL
									ORDER BY c.name_ln ASC ");
			
			if(!empty($data)) {
				$lbl = text::get('country');
				$toReturn .= "<select name='country' id='country'>";
				$toReturn .= "<option value=''>{$lbl}</option>";
				foreach($data AS $id=>$name) {
					$toReturn .= "<option value='{$id}' ".($FILTER['country']==$id?'selected':'').">{$name['name']}</option>";
				}
				$toReturn .= "</select>";
			}
			
			if(in($FILTER['product_type'], 'wine', 'mixedcases')) {
			
				//Regions
				$data = $mm->SelAssoc("SELECT 	DISTINCT p.region_id, r.name_ln name
										FROM 	products p
												LEFT JOIN regions r ON r.id=p.region_id
										WHERE 	p.region_id IS NOT NULL
												AND
												p.hidden=0
												AND
												p.deleted=0
												AND
												p.type_id={$ptype_id}
										ORDER BY r.name_ln ASC
										");
				
				if(!empty($data)) {
					$lbl = text::get('region');
					$toReturn .= "<select name='region' id='region'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						$toReturn .= "<option value='{$id}' ".($FILTER['region']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				}
				//winery
				$region_where = "";
				if(!empty($FILTER['region'])) {
					$region_where .= " AND p.region_id={$FILTER['region']}";
				}
				if(!empty($FILTER['country'])) {
					$region_where .= " AND r.country_id={$FILTER['country']}";
				}
				//$data = $mm->SelAssoc("SELECT p.id, p.name_ln name FROM producers p LEFT JOIN regions r ON r.id=p.region_id WHERE p.hidden=0 AND p.alctypeId=1{$region_where} ORDER BY p.name_ln ASC");
				$data = $mm->SelAssoc("SELECT 	DISTINCT pr.producer_id, 
												p.name_bg `name` 
										FROM 	products pr
												LEFT JOIN producers p ON p.id=pr.producer_id
												LEFT JOIN regions r ON r.id=p.region_id 
										WHERE 	p.hidden=0 
												AND
												pr.hidden=0
												AND
												pr.deleted=0
												AND 
												p.alctypeId=1
												{$region_where}
										ORDER BY p.name_bg ASC");
				
				if(!empty($data)) {
					$lbl = text::get('winery');
					$toReturn .= "<select name='winery' id='winery'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						$toReturn .= "<option value='{$id}' ".($FILTER['winery']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				} else {
					$lbl = text::get('winery');
					$toReturn .= "<select name='winery' id='winery' style='display:none;'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					$toReturn .= "</select>";
				}
				
				//variety
				if(!empty($FILTER['color'])) {
					$data = $mm->SelAssoc("SELECT 	DISTINCT pr.wine_sort_id, 
												s.name_ln `name` 
										FROM 	products pr
												LEFT JOIN wine_sorts s ON s.id=pr.wine_sort_id
										WHERE 	s.hidden=0 
												AND
												pr.hidden=0
												AND
												pr.deleted=0
												AND
												pr.color={$FILTER['color']}
										ORDER BY s.name_ln ASC");
				} else {
					$data = $mm->SelAssoc("SELECT id, name_ln name FROM wine_sorts WHERE hidden=0 ORDER BY name_ln ASC");
				}
				if(!empty($data)) {
					$lbl = text::get('variety');
					$toReturn .= "<select name='variety' id='variety'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						$toReturn .= "<option value='{$id}' ".($FILTER['variety']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				}
				//vintage
				$data = $mm->SelAssoc("SELECT id, name FROM vintages WHERE hidden=0 ORDER BY name ASC");
				
				if(!empty($data)) {
					$lbl = text::get('vintage');
					$toReturn .= "<select name='vintage' id='vintage'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						$toReturn .= "<option value='{$id}' ".($FILTER['vintage']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				}
			}
			
			//price ranges
			$data = $mm->SelAssoc("SELECT id, from_amount, to_amount FROM wine_price_ranges ORDER BY to_amount desc");
			
			if(!empty($data)) {
				$lbl = text::get('price');
				$toReturn .= "<select name='price' id='price'>";
				$toReturn .= "<option value=''>{$lbl}</option>";
				$fromLbl = text::get('from');
				$toLbl = text::get('to');
				$lvLbl = text::get('lv');
				foreach($data AS $id=>$name) {
					$toReturn .= "<option value='{$id}' ".($FILTER['price']==$id?'selected':'').">{$fromLbl} {$name['from_amount']}{$lvLbl} {$toLbl} {$name['to_amount']}{$lvLbl}</option>";
				}
				$toReturn .= "</select>";
			}
			
			if(in($FILTER['product_type'], 'wine', 'mixedcases')) {
				//closure
				$data = $mm->SelAssoc("SELECT id, name_ln name FROM wine_closings");
				
				if(!empty($data)) {
					$lbl = text::get('closure');
					$toReturn .= "<select name='closure' id='closure'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						$toReturn .= "<option value='{$id}' ".($FILTER['closure']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				}
				
				//strength ranges
				$data = $mm->SelAssoc("SELECT id, from_amount, to_amount FROM wine_strength_ranges ORDER BY from_amount asc");
				
				if(!empty($data)) {
					$lbl = text::get('strength');
					$toReturn .= "<select name='strength' id='strength'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					$fromLbl = text::get('from');
					$toLbl = text::get('to');
					foreach($data AS $id=>$name) {
						$toReturn .= "<option value='{$id}' ".($FILTER['strength']==$id?'selected':'').">{$fromLbl} {$name['from_amount']}% {$toLbl} {$name['to_amount']}%</option>";
					}
					$toReturn .= "</select>";
				}

				//maturity
				
				$data = $mm->SelAssoc("SELECT id, name_ln name FROM wine_maturity");
				
				if(!empty($data)) {
					$lbl = text::get('maturity');
					$toReturn .= "<select name='maturity' id='maturity'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						$toReturn .= "<option value='{$id}' ".($FILTER['maturity']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				}
				
				//bottle types
				
				$data = $mm->SelAssoc("SELECT id, name_ln name FROM bottle_types WHERE hidden=0 ORDER BY 2");
				
				if(!empty($data)) {
					$lbl = text::get('bottle types');
					$toReturn .= "<select name='bottle' id='bottle'>";
					$toReturn .= "<option value=''>{$lbl}</option>";
					foreach($data AS $id=>$name) {
						$toReturn .= "<option value='{$id}' ".($FILTER['bottle']==$id?'selected':'').">{$name['name']}</option>";
					}
					$toReturn .= "</select>";
				}
				
				//options
				/*
				if(isset($FILTER['toprated'])) $FILTER['options'] = 1;
				$lbl = text::get('options');
				$toReturn .= "<select name='options' id='options'>";
				$toReturn .= "<option value=''>{$lbl}</option>";
				
				$toReturn .= "<option value='toprated' ".($FILTER['options']==1?'selected':'').">TOP RATED WINES</option>";
				$toReturn .= "<option value='winery' ".($FILTER['options']==2?'selected':'').">Winery of the mounth</option>";
				
				$toReturn .= "</select>";
				*/
			}
			break;
	}

	return $toReturn;
}
?>