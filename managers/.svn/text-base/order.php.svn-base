<?

abstract class order {

	public static function createOrder() {
		global $mm;
		$user_id = nvl($_SESSION['user']['id'],'null');
		$session_id = session_id();
		$sql = "INSERT INTO orders(user_id, total, discount, vat, status, address_id, payment_method_id, session_id)
				VALUES ($user_id, 0, 0, (SELECT vat FROM system), 0, null, 1, '$session_id');";
		$sql .= "\n|SELECT last_insert_id() as id";

		$res = $mm->Transaction($sql);
		$order_id = $res['id'];
		log::logNotice('order::createOrder',"Order [$order_id] created");
		return $order_id;
	}

	/**
	 * Returns the order id for an user (or session). The one with status 0
	 * @return int order_id. if false - no order for the user
	 *
	 */
	public static function getId() {
		global $mm;

		if(isset($_SESSION['user']['id'])) {
			$sql = "SELECT id FROM orders WHERE user_id={$_SESSION['user']['id']} AND status=0";
		} else {
			$session_id = session_id();
			$sql = "SELECT id FROM orders WHERE session_id='$session_id' AND status=0";
		}
		$order_id = $mm->SelOne($sql);

		if(!$order_id) {
			return false;
		} else {
			return $order_id;
		}

	}

	/**
	 * Duplicates the given order of the user and places the same products in the basket.
	 *
	 * @param int $order_id
	 */
	public static function duplicateOrder($order_id) {
		global $mm;

		if(!$order_id) {
			log::logWarning('order::duplicateOrder()', "Called without order ID");
			return false;
		}
		$user_id = $_SESSION['user']['id'];
		if(empty($user_id)) {
			log::logWarning('order::duplicateOrder()', "Called with no logged user");
			return false;
		}

		$allow = $mm->SelOne("SELECT 1 FROM orders WHERE id={$order_id} AND user_id={$user_id}");
		if(!$allow) {
			log::logWarning('order::duplicateOrder()', "Given order [{$order_id}] is not for user [{$user_id}]");
			return false;
		}

		$cur_order_id = self::getId();
		if(!$cur_order_id) {
			$cur_order_id = self::createOrder();
		}else{
			$cnt = self::getItemsCount($cur_order_id);
			if($cnt>0) {
				$res = $mm->Query("DELETE FROM order_detail WHERE order_id=$cur_order_id");
			}
		}

		$products = $mm->SelAssoc("SELECT product_id, quantity FROM order_detail WHERE order_id = {$order_id}");
		foreach ($products AS $cur_prod) {
			self::addProduct($cur_prod['product_id'], $cur_prod['quantity'], $cur_order_id);
		}

		return true;
	}

	/**
	 *
	 * This will return the id of the order with with the given paymentId
	 * @return int order_id. if false - no order for the user
	 *
	 */
	public static function getOrderByPaymentId($paymentId) {
		global $mm;

		if(empty($paymentId)) {
			log::logError('order::getOrderByPaymentId', 'Called without $paymentId parameter');
			return false;
		}
		if(!isset($_SESSION['user']['id'])) return false;

		$sql = "SELECT id FROM orders WHERE user_id={$_SESSION['user']['id']} AND paymentId='{$paymentId}' LIMIT 1";
		$order_id = $mm->SelOne($sql);

		if(!$order_id) {
			return false;
		} else {
			return $order_id;
		}
	}
	/**
	 * As order::getId seeks only in the unfinished orders (status=0), we need getLastWaitingOrderId() method for the Success.php.
	 * This will return the id of the last order with status=1
	 * @return int order_id. if false - no order for the user
	 *
	 */
	public static function getLastWaitingOrderId() {
		global $mm;

		if(!isset($_SESSION['user']['id'])) return false;

		$sql = "SELECT id FROM orders WHERE user_id={$_SESSION['user']['id']} AND status=1 ORDER BY created_at DESC LIMIT 1";
		$order_id = $mm->SelOne($sql);

		if(!$order_id) {
			return false;
		} else {
			return $order_id;
		}
	}

	/**
	 * Adds quantity of product with product_id to the order. Recalcs the order when less or more than 6 products.
	 * Recalcs the order totals.
	 *
	 * @param int $product_id
	 * @param int $quantity
	 * @param int $order_id
	 * @param int $color_id
	 * @param int $size_id
	 * @return false on err true on success
	 */
	public static function addProduct($product_id, $quantity=1, $order_id=null, $color_id=null, $size_id=null ) {
		global $mm;

		if($order_id == null) {
			$order_id = order::getId();
			if(!$order_id) {
				log::logWarning('order::addProduct()', "Unable to add product[$product_id] to order as order::getId() returned null");
				return false;
			}
		}
		$product_where = '';
		if(!empty($color_id)) $product_where .= " AND product_color_id={$color_id}";
		if(!empty($size_id)) $product_where .= " AND product_size_id={$size_id}";
		$pr_exists = $mm->SelOne("SELECT id FROM order_detail WHERE order_id=$order_id AND product_id=$product_id {$product_where}");

		if($pr_exists) {
			$sql = "UPDATE order_detail SET quantity=quantity+$quantity WHERE order_id=$order_id AND product_id=$product_id AND id={$pr_exists}";
		} else {

			$is_group = $mm->SelOne("SELECT 1 FROM products_2_promotions pp LEFT JOIN product_promotions p ON p.id=pp.promotion_id WHERE pp.product_id={$product_id} AND p.active_till>=CURRENT_DATE AND p.active_from<=CURRENT_DATE");
			$sql = "SELECT	id,
							disc_price,
							disc_perc,
							active_till
						FROM 	product_promotions
						WHERE 	product_id={$product_id}
							AND
							active_till>=CURRENT_DATE
							AND
							active_from<=CURRENT_DATE
						ORDER BY active_till
						LIMIT 1
							";

			if($is_group) {
				$sql = "SELECT	p.id,
								pp.disc_price,
								p.disc_perc,
								p.active_till
						FROM 	products_2_promotions pp
								LEFT JOIN product_promotions p ON p.id=pp.promotion_id
						WHERE 	pp.product_id={$product_id}
								AND
								p.active_till>=CURRENT_DATE
								AND
								p.active_from<=CURRENT_DATE
						ORDER BY p.active_till
						LIMIT 1
						";
			}
			$promotion = $mm->SelArr($sql);
			if($promotion) {
				$disc_price = $promotion['disc_price'];
			}
			$sql = "INSERT INTO order_detail (order_id, product_id, quantity, price, disc_price, product_color_id, product_size_id)
			VALUES ($order_id, $product_id, $quantity,
			(SELECT price1 FROM products WHERE id=$product_id),
			".(empty($disc_price)?'NULL':$disc_price).",
			".(empty($color_id)?'NULL':$color_id).",
			".(empty($size_id)?'NULL':$size_id)."
			)";
		}
			$res = $mm->Query($sql);

			order::recalcPriceOnQuantity($order_id);
			order::recalcOrderTotals($order_id);

			return $res;
	}

	/**
	 * if address is id - then address_id is inserted into order
	 * if address is array(street, sity, zip, phone) an entry is added for user and its ID is inserted in order
	 */
	public static function addAddress($order_id, $address) {
		global $mm;
		if($order_id == null) {
			$order_id = order::getId();
			if(!$order_id) return false;
		}

		if(is_array($address)) {
			if(!nvl($_SESSION['user']['id'])) return false;
			if(!nvl($address['street'])) return false;
			if(!nvl($address['city'])) return false;
			if(!nvl($address['country'])) return false;
			if(!nvl($address['zip'])) return false;
			if(!nvl($address['phone'])) return false;

			$address['street'] = quotes($address['street']);
			$address['city'] = quotes($address['city']);
			$address['country'] = intval($address['country']);
			$address['zip'] = quotes($address['zip']);
			$address['phone'] = quotes($address['phone']);
			$address['notes'] = quotes($address['notes']);

			$sql = "INSERT INTO user_addresses(user_id, street, country, city, zip, phone, notes)
					VALUES ({$_SESSION['user']['id']}, '{$address['street']}', '{$address['country']}', '{$address['city']}', '{$address['zip']}', '{$address['phone']}', '{$address['notes']}')";
			$sql .= "\n|UPDATE orders SET address_id=last_insert_id() WHERE id=$order_id";
			$sql .= "\n|SELECT address_id FROM orders WHERE id=$order_id";
			$res = $mm->Transaction($sql);
			$address_id = $res['address_id'];
		} elseif(($address = intval($address)) > 0) {
			$res = $mm->Query("UPDATE orders SET address_id=$address WHERE id=$order_id");
			$address_id = $address;
		}

		self::setDeliveryPrice($order_id, $address_id);
		self::recalcOrderTotals($order_id);
	}

	/**
	* Apply campaign to order
	* @param int $campaign_id
	* @param int $order_id
	* @return true on success, false on failure
	*/
	public static function applyCampaignDiscount($campaign_id, $order_id=null) {
		global $mm;
		if($campaign_id == null) return false;
		if($order_id == null) {
			$order_id = order::getId();
			if(!$order_id) return false;
		}

		// get info if active campaigns for the products in order are availiable
		$cam_info = $mm->SelAssoc("
					SELECT od.product_id, od.price, c.name, c.discount, c.id cid
					FROM 	campaigns c, order_detail od
					WHERE 	c.active_till >= CURDATE()
							AND
							c.deleted<>1
							AND
							c.id = $campaign_id
							AND
							od.order_id = $order_id
							AND
							od.campaign_id IS NULL

   ");

	 // if we have active campaign for some of the products in the order
	 if($cam_info) {
		  			$sql = '';
		  			$cid = 0;
						$s = '';
		  			foreach ($cam_info as $pid=>$val) {
		  				$cid = $val['cid'];
		  				$price = round( ($val['price']*(100-$val['discount'])) / 100, 2 );
		  				$sql .= $s . "UPDATE order_detail SET campaign_price=$price, campaign_id={$val['cid']} WHERE product_id=$pid AND order_id=$order_id";
		  				$s = "\n|";
		  			}

		  			$res = $mm->Transaction($sql);
		  			if($res) {
		  				log::logNotice("order::applyCampaignDiscount()", "Campaign [$campaign_id] applied to order $order_id");
		  				order::recalcOrderTotals($order_id);
		  			}
		  			return $res;
	   }
		 return false;
	}

	/**
	 * Apply disconts that come from Campains with promocodes
	 *
	 * @param int $promocode
	 * @param int $order_id
	 * @return true on success, false on failure
	 */
	public static function setPromoDiscount($promocode, $order_id=null) {
		global $mm;
		if($order_id == null) {
			$order_id = order::getId();
			if(!$order_id) return false;
		}

		// get info if active campaigns for the products in order are availiable
		$cam_info = $mm->SelAssoc("
					SELECT p.product_id, od.price, c.name, c.discount, c.id cid, c.for_delivery, c.for_registration, c.onetimecode
					FROM 	campaigns c
						JOIN campaign_promo_codes cc ON c.id=cc.campaign_id
						JOIN product_2_campaign p ON c.id=p.campaign_id
						JOIN order_detail od ON p.product_id = od.product_id
					WHERE 	c.active_till >= CURDATE()
							AND
							c.deleted<>1
							AND
							cc.promocode = '$promocode' AND cc.used<>1
							AND
							od.order_id = $order_id
							AND
							NOT EXISTS (SELECT 1 FROM order_detail WHERE order_id=$order_id AND campaign_id IS NOT NULL)

					");

		// if we have active campaign for some of the products in the order
		if($cam_info) {
			$sql = '';
			$cid = 0;
			foreach ($cam_info as $pid=>$val) {
				$cid = $val['cid'];
				$price = round( ($val['price']*(100-$val['discount'])) / 100, 2 );
				$sql .= "UPDATE order_detail SET campaign_price=$price, campaign_id={$val['cid']} WHERE product_id=$pid AND order_id=$order_id";
				$sql .= "\n|";
			}

			if($cid>0) {
				$campaign = $mm->SelArr("SELECT id, for_registration, for_delivery, onetimecode FROM campaigns WHERE id={$cid}");
				if($campaign) {
					if(empty($campaign['for_registration']) && empty($campaign['onetimecode'])) {
						$sql .= "UPDATE campaign_promo_codes SET used=1 WHERE promocode='$promocode'";
					} else {
						$sql = trim($sql, "\n|");
					}
				}
			} else {
				$sql .= "UPDATE campaign_promo_codes SET used=1 WHERE promocode='$promocode'";
			}

			$res = $mm->Transaction($sql);
			if($res) {
				log::logNotice("order::setPromoDiscount()", "Promocode [$promocode] added to order $order_id");
				order::recalcOrderTotals($order_id);
			}
			return $res;
		}
		return false;
	}

	/**
	 * Apply disconts that come from Campains with promocodes
	 *
	 * @param int $promocode
	 * @param int $order_id
	 * @return true on success, false on failure
	 */
	public static function setFirstOrderPromoDiscount($promocode, $order_id=null) {
		global $mm;
		if($order_id == null) {
			$order_id = order::getId();
			if(!$order_id) return false;
		}

		// get info if active campaigns for the products in order are availiable
		$cam_info = $mm->SelAssoc("
					SELECT od.product_id, od.price, c.name, c.discount, c.id cid, c.for_delivery, c.for_registration
					FROM 	campaigns c
						JOIN campaign_promo_codes cc ON c.id=cc.campaign_id
						JOIN order_detail od ON od.order_id = $order_id
					WHERE 	c.active_till >= CURDATE()
							AND
							c.deleted<>1
							AND
							cc.promocode = '$promocode' AND cc.used<>1
							AND
							od.order_id = $order_id
					");

		// if we have active campaign for some of the products in the order
		if($cam_info) {
			$sql = '';

			foreach ($cam_info as $pid=>$val) {
				$price = round( ($val['price']*(100-$val['discount'])) / 100, 2 );
				$sql .= "UPDATE order_detail SET campaign_price=$price, campaign_id={$val['cid']} WHERE product_id=$pid AND order_id=$order_id";
				$sql .= "\n|";
			}
			$sql = trim($sql, "\n|");
			$res = $mm->Transaction($sql);
			if($res) {
				log::logNotice("order::setFirstOrderPromoDiscount()", "Promocode [$promocode] added to order $order_id");
				order::recalcOrderTotals($order_id);
			}
			return $res;
		}
		return false;
	}

	/**
	 * Apply disconts that come from Campains with promocodes
	 *
	 * @param int $promocode
	 * @param int $order_id
	 * @return true on success, false on failure
	 */
	public static function setFirstOrderPromoCampaign($promocode, $order_id=null) {
		global $mm;
		if($order_id == null) {
			$order_id = order::getId();
			if(!$order_id) return false;
		}

		// get info if active campaigns for the products in order are availiable
		$cam_info = $mm->SelAssoc("
					SELECT od.product_id, od.price, c.name, c.id cid, c.for_firstorder
					FROM 	campaigns c
						JOIN campaign_promo_codes cc ON c.id=cc.campaign_id
						JOIN order_detail od ON od.order_id = $order_id
					WHERE 	c.active_till >= CURDATE()
							AND
							c.deleted<>1
							AND
							cc.promocode = '$promocode' AND cc.used<>1
							AND
							od.order_id = $order_id
							AND
							c.for_firstorder=1
					");

		// if we have active campaign for some of the products in the order
		if($cam_info) {
			$sql = '';

			foreach ($cam_info as $pid=>$val) {
				$price = $val['price'];
				$sql .= "UPDATE order_detail SET campaign_price=$price, campaign_id={$val['cid']} WHERE product_id=$pid AND order_id=$order_id";
				$sql .= "\n|";
			}
			$sql = trim($sql, "\n|");
			$res = $mm->Transaction($sql);
			if($res) {
				log::logNotice("order::setFirstOrderPromoCampaign()", "Promocode [$promocode] added to order $order_id");
				order::recalcOrderTotals($order_id);
			}
			return $res;
		}
		return false;
	}

	/**
	 * *
	 * Changes the status of the order
	 * @param int $status (0-unfinished, 1-pending, 2-shipped, 3-delivered, 4-closed, 5-rejected
	 * @return true on success
	 */
	public static function setStatus($status, $order_id) {
		global $mm;
		if(!$order_id) {
			log::logError('order::setStatus', 'Called without $order_id parameter');
			return false;
		} else {
			$res = $mm->SelOne("SELECT 1 FROM orders WHERE id=$order_id");
			if(!$res) {
				log::logError('order::setStatus', "Called with unexiting order_id[$order_id]");
				return false;
			}
		}
		$created_field='';
		if(in($status, 1, 2)) $created_field = ', created_at=NOW()';
		$result = $mm->Query("UPDATE orders SET status=$status $created_field WHERE id=$order_id");
		if($result) {
			if($status==1) { //Confirmed
				//update the quantities of the products that are not vouchers
				$details = $mm->SelAssoc("	SELECT 	o.id, o.product_id, o.quantity, o.product_color_id, o.product_size_id
											FROM order_detail o
												JOIN products p on o.product_id=p.id
											WHERE o.order_id=$order_id
												AND p.type_id<5");
				if($details) {
					$sql = '';
					foreach ($details as $oid=>$d) {
						//$sql .= "UPDATE products SET quantity=quantity-{$d['quantity']} WHERE id={$d['product_id']}";
						$sql .= "UPDATE product_quantity SET qty=qty-{$d['quantity']} WHERE product_id={$d['product_id']} AND product_color_id={$d['product_color_id']} AND product_size_id={$d['product_size_id']}";
						$sql .= "\n|";
					}

					$sql = trim($sql, "\n|");
					$res = $mm->Transaction($sql);
				}

			}
		}
		return $result;
	}


	public static function setPaymentMethod($order_id, $payment_id) {
		global $mm;
		return $mm->Query("UPDATE orders SET payment_method_id=$payment_id WHERE id=$order_id");
	}

	public static function setDeliveryMethod($order_id, $delivery_method_id) {
		global $mm;
		log::logLog("order.php", "UPDATE orders SET delivery_method_id=$delivery_method_id WHERE id=$order_id");
		return $mm->Query("UPDATE orders SET delivery_method_id=$delivery_method_id WHERE id=$order_id");
	}

	public static function getDeliveryMethod($order_id) {
		global $mm;
		return $mm->SelOne("SELECT delivery_method_id FROM orders WHERE id=$order_id");
	}

	public static function setDiscount($order_id, $discount) {
		global $mm;
		$res = $mm->Query("UPDATE orders SET discount=$discount WHERE id=$order_id");
		order::recalcOrderTotals($order_id);
		return $res;
	}

	public static function setDeliveryPrice($order_id, $address_id = false, $delivery_price = false, $delivery_method_id=false) {
		global $mm, $_sofia, $_delivery_prices,$_delivery_prices_sof;;

		// do not set any price for delivery if Promo is applied for the first user's order
		$res = $mm->SelOne("
			SELECT 1 FROM users
			WHERE id=(SELECT user_id FROM orders WHERE id=$order_id)
			AND delivery_promo IS NOT NULL
			AND (SELECT COUNT(1) FROM orders WHERE user_id=(SELECT user_id FROM orders WHERE id=$order_id))=1;
		");
		if($res==1) return;

		if(!$delivery_price) {
			if(!$address_id) $address_id = self::getAddress($order_id);
			$delivery_price = 0.0;

			if(!$address_id) {
				$mm->Query("UPDATE orders SET delivery_price=null WHERE id=$order_id");
				return;
			}

			if(!$delivery_method_id) $delivery_method_id = self::getDeliveryMethod($order_id);

			$express = ($delivery_method_id==2);
			log::logLog("order.php::setDeliveryPrice", "Delivery method: $delivery_method_id; express: $express");
			$country = $mm->SelArr("SELECT country, city FROM user_addresses WHERE id={$address_id}");
			$total = self::getTotal($order_id);

			if($total>120) {
				$delivery_price = 0.0;
				return;
			} else {
				if($country['country']!=26) {
					$delivery_price = 20.00;
				} else {
					$city = $country['city'];
					$city = mb_strtolower($city, "utf-8");
					if(in_array($city, $_sofia)) {
						if($express) {
							$delivery_price = $_delivery_prices_sof['express'];
						} else {
							$delivery_price = $_delivery_prices_sof['economy'];
						}
					} else {
						if($express) {
							$delivery_price = $_delivery_prices['express'];
						} else {
							$delivery_price = $_delivery_prices['economy'];
						}
					}
				}
			}

			/*
			$delivery_zone = ($address_id ? get_delivery_price($address_id) : 0);

			$itm_cnt = order::getItemsCountBottles($order_id);
			if($delivery_zone) {
				$rates = $mm->SelArr("SELECT usd, eur FROM system WHERE id=1");
				$coeff = 1;
				if($delivery_zone['currency']!='bgn') {
					$coeff = $rates[$delivery_zone['currency']];
					if($itm_cnt<7) {
						$delivery_price = $delivery_zone['price1']*$coeff;
					} elseif ($itm_cnt < 13) {
						$delivery_price = $delivery_zone['price2']*$coeff;
					} elseif ($itm_cnt < 19) {
						$delivery_price = $delivery_zone['price3']*$coeff;
					} else {
						$delivery_price = $delivery_zone['price4']*$coeff;
					}
				} else {
					if($itm_cnt<6) {
						$delivery_price = $delivery_zone['price1']*$coeff;
					} else {
						$delivery_price = $delivery_zone['price2']*$coeff;
					}
				}
			}
			if($itm_cnt===null) $delivery_price = 'null'; // if no items, reset the delivery price to null
			*/
		}
		log::logLog("order.php::setDeliveryPrice", "UPDATE orders SET delivery_price=$delivery_price WHERE id=$order_id");
		$mm->Query("UPDATE orders SET delivery_price=$delivery_price WHERE id=$order_id");

		self::recalcOrderTotals($order_id);

	}

	public static function setPaymentId($order_id, $paymentId) {
		global $mm;
		if(empty($paymentId)) {
			log::logWarning('order::setPaymentId()', "Unable to set paymentId [$paymentId] to order [$order_id]");
			return false;
		}
		$res = $mm->Query("UPDATE orders SET paymentId='$paymentId' WHERE id=$order_id");
		return $res;
	}

	/**
	 * Set new quantity for a product in order
	 *
	 * @param int $quantity (if 0, the row with this product will be deleted from the order)
	 * @param int $order_id
	 * @param int $product_id
	 * @return true on success
	 */
	public static function setProductQuantity($quantity, $product_id, $order_id=null) {
		global $mm;

		if($order_id==null) $order_id=order::getId();
		if(!$order_id) {
			log::logWarning('order::setProductQuantity()', "Unable to set product quantity for product [$product_id] to order as order::getId() returned null");
			return false;
		}

		if($quantity == 0) {
			$res = $mm->Query("DELETE FROM order_detail WHERE order_id=$order_id AND product_id=$product_id");
		} else {
			$detail = $mm->SelArr("SELECT id, product_color_id, product_size_id FROM order_detail WHERE product_id={$product_id} AND order_id={$order_id}");

			//$can_change = $mm->SelOne("SELECT 1 FROM products WHERE id={$product_id} AND quantity>={$quantity}");
			$can_change = $mm->SelOne("SELECT 1 FROM product_quantity WHERE product_id={$product_id} AND qty>={$quantity} AND product_color_id={$detail['product_color_id']} AND product_size_id={$detail['product_size_id']}");

			if($can_change) {
				$res = $mm->Query("UPDATE order_detail SET quantity=$quantity WHERE order_id=$order_id AND product_id=$product_id");
			} else {
				return false;
			}
		}


		order::recalcPriceOnQuantity($order_id);
		order::recalcOrderTotals($order_id);

		return $res;
	}

	/**
	 * Returns array with order details array(total, discount, vat, status, details=array(product_id,price, disc_price, quantity))
	 *
	 * @param int $order_id
	 */
	public static function getDetails($order_id, $product_id=null) {
		global $mm;

		if(!$order_id) return false;

		$order = $mm->SelArr("	SELECT id, total, discount, vat, status, paid, payment_method_id, user_id, address_id, delivery_price, delivery_date, delivered_date, total_no_disc, paymentId, created_at,delivery_method_id,
										(SELECT CONCAT_WS(' ', fname, lname) FROM users where id=user_id) as user
								FROM orders WHERE id=$order_id");

		$product_where = '';
		if($product_id>0) {
			$product_where = "
							AND
							o.product_id={$product_id}";
		}

		$order['details'] = $mm->SelAssoc("	SELECT 	o.id, o.product_id, p.name_ln product_name, o.price, o.disc_price, o.campaign_price, o.final_price,
													o.campaign_id, o.quantity, p.code, c.name_ln color, s.name_ln size, o.product_color_id, o.product_size_id, p.product_category_id
											FROM order_detail o
												JOIN products p on o.product_id=p.id
												LEFT JOIN product_colors c ON c.id=o.product_color_id
												LEFT JOIN product_sizes s ON s.id=o.product_size_id
											WHERE order_id=$order_id
												{$product_where}");

		return $order;
	}

	/**
	 * Returns the number of items currently in the order
	 *
	 * @param int $order_id
	 */
	public static function getItemsCount($order_id) {
		global $mm;

		if(!$order_id) return 0;

		$count = $mm->SelOne("SELECT COUNT(*) FROM order_detail WHERE order_id=$order_id");

		return $count;
	}

	/**
	 * Returns the number of items currently in the order
	 *
	 * @param int $order_id
	 */
	public static function getItemsCountBottles($order_id) {
		global $mm;

		if(!$order_id) return 0;

		$count = $mm->SelOne("SELECT SUM(od.quantity) FROM order_detail od LEFT JOIN products p ON p.id=od.product_id WHERE od.order_id=$order_id AND p.type_id IN (1,2,9,13)");

		return $count;
	}



	/**
	 * Returns true if this is the first order of the user
	 *
	 * @param bol - true if first order else false
	 */
	public static function isFirstOrder($order_id) {
		global $mm;

		if(!$order_id) return 0;

		$count = $mm->SelOne("SELECT COUNT(*) FROM orders WHERE user_id=(SELECT user_id FROM orders WHERE id=$order_id)");
		$count = intval($count);
		return ($count==1);
	}

	/**
	 * Returns only the product names in one order
	 *
	 * @param int $order_id
	 */
	public static function getSimpleDetails($order_id) {
		global $mm;

		if(!$order_id) return false;

		$details = $mm->SelAssoc("	SELECT 	o.id, p.name_ln product_name
											FROM order_detail o
												JOIN products p on o.product_id=p.id
											WHERE order_id=$order_id");

		return $details;
	}



	public static function getTotal($order_id) {
		global $mm;
		if(!$order_id) return false;

		$total = $mm->SelOne("SELECT total FROM orders WHERE id=$order_id");
		return $total;
	}

	public static function getTotalDiscount($order_id) {

	}

	public static function getAddress($order_id) {
		global $mm;
		if(!$order_id) return false;

		$address_id = $mm->SelOne("SELECT address_id FROM orders WHERE id=$order_id");
		return $address_id;
	}

	/**
	 * Returns total discount sum, when promocode from campaign is applied.
	 *
	 * @param int $order_id
	 */
	public static function getTotalPromoDiscount($order_id) {
		global $mm;
		if(!$order_id) return false;

		$total = $mm->SelOne("SELECT SUM(IF(campaign_id IS NOT NULL, IF(campaign_price<final_price,final_price-campaign_price,0),0)*quantity) FROM order_detail WHERE order_id=$order_id");
		return doubleval($total);
	}

	/**
	 * Returns delivery price
	 *
	 * @param int $order_id
	 */
	public static function getDeliveryPrice($order_id) {
		global $mm;
		$res = $mm->SelOne("SELECT delivery_price FROM orders WHERE id=$order_id");
		return $res;
	}

	/**
	 * *
	 * gets the status of the order
	 * @param int order_id
	 * @return int $status (0-unfinished, 1-pending, 2-shipped, 3-delivered, 4-closed, 5-rejected
	 */
	public static function getStatus($order_id) {
		global $mm;
		if(!$order_id) {
			log::logError('order::getStatus', 'Called without $order_id parameter');
			return false;
		} else {
			$res = $mm->SelOne("SELECT 1 FROM orders WHERE id=$order_id");
			if(!$res) {
				log::logError('order::getStatus', "Called with unexiting order_id[$order_id]");
				return false;
			}
		}
		return $mm->SelOne("SELECT status FROM orders WHERE id=$order_id");
	}

	/**
	 * Recalcs the new prices of products in order, depending on quantity (<6 bottles, => 6 bottles
	 *
	 * @param int $order_id
	 */
	private static function recalcPriceOnQuantity($order_id) {
		global $mm;
		$itm_cnt = $mm->SelOne("SELECT SUM(quantity) FROM order_detail WHERE order_id=$order_id");
		if($itm_cnt===null) return; //nothing to change, there is no order_details, this is a deletion of the last product in an order
		$order_rows = $mm->SelAssoc("SELECT * FROM order_detail WHERE order_id=$order_id");
		$err = false;
		$delivery = false;

		if($itm_cnt <=5 ) {
			foreach($order_rows as $key=>$row) {
				$res = $mm->Query("UPDATE order_detail
							SET price = (SELECT price1 FROM products WHERE id={$row['product_id']})
							WHERE id=$key");
				if($res==false) $err=true;
			}

		} else {
			foreach($order_rows as $key=>$row) {
				$res = $mm->Query("UPDATE order_detail
							SET price = (SELECT IF(price2 IS NULL, price1, price2) FROM products WHERE id={$row['product_id']})
							WHERE id=$key");
				if($res==false) $err=true;
			}
			$delivery = 0.0;
		}

		self::setDeliveryPrice($order_id, false, $delivery);

		if($err) log::logError('order::recalcPriceOnQuantity',"Problem recalculating product prices for order [$order_id];");
	}

	/**
	 * Recalcs the total for order
	 *
	 * @param int $order_id
	 */
	private static function recalcOrderTotals($order_id) {
		global $mm;
		$sql = "UPDATE order_detail
				SET final_price = if(disc_price<price, disc_price, price)
				WHERE order_id=$order_id;
		";

		$sql .= "\n|UPDATE orders
				SET total_no_disc = (	SELECT SUM(IF(campaign_price < final_price, campaign_price, final_price )* quantity )
										FROM order_detail WHERE order_id=$order_id
									),
					total =  IF(discount>0, (total_no_disc*(100-discount))/100 , total_no_disc) + IFNULL(delivery_price,0)
				WHERE id=$order_id";

		$res = $mm->Transaction($sql);

		if($res==false) log::logError('order::recalcOrderTotals',"Problem recalculating totals for order [$order_id];");
	}

	/**
	 * checks and gets WineClub discount levels information depending on the order_id
	 * use it when displaying order details to the user, before the checkout
	 * returns array with following keys:
	 * ["lvl2reach"] - the id of the next top level (this is the ID from the user_types table)
	 * ["val2reach"] - the amount needed to reach this level (for a hint to the user: "If you get something for 10lv you will reach level EXPERT")
	 * ["curr_lvl"] - the current level on which the user is (may be NULL if the user has no WineClub level)
	 * ["ordreach_lvl"] - the level (may be NULL if this order does not make upgrading of level)
	 *
	 * @param int $order_id
	 * @return arr array(4) {["lvl2reach"],["val2reach"],["curr_lvl"],["ordreach_lvl"]}
	 */
	public static function getWineClubData($order_id) {
		global $mm;
		$userdata = $mm->SelArr("	SELECT u.id, u.user_type_id to_id, u.type_set_at
									FROM orders o,users u
									WHERE o.user_id=u.id AND o.id=$order_id");
		$turnovers = $mm->SelAssoc("SELECT id, turnover as value, discount FROM user_types ORDER BY turnover ASC");

		$where_cls = ($userdata['type_set_at'] ? "AND created_at>='{$userdata['type_set_at']}'" : '');

		$user_sum = $mm->SelOne("	SELECT SUM(total_no_disc)
									FROM orders
									WHERE user_id = {$userdata['id']} $where_cls");

		$nearesttop_lvl = null;
		$reached_lvl = null;
		// walk truough turnovers and set which one is reached and which not.
		// Set what the value to reach it in a separate array value: 'val2reach'.
		// Get the index of the nearest top to reach turnover. Get the index of the biggest reached level
		foreach($turnovers as $idx => &$to) {
			if ($to['value'] <= $user_sum) {
				$to['val2reach'] = 0;
				$reached_lvl = $idx;
			} else {
				$to['val2reach'] = $to['value'] - $user_sum;
				if($nearesttop_lvl===null) {
					$nearesttop_lvl = $idx;
				} elseif($userdata['to_id'] > $nearesttop_lvl) {
					$nearesttop_lvl = $idx;
				}
			}
		}

		//WineClub levels
		$return['lvl2reach'] = $nearesttop_lvl; //nearest top level
		$return['val2reach'] = $turnovers[$nearesttop_lvl]['val2reach']; // amount to reach nearest top level
		$return['curr_lvl'] = $userdata['to_id']; //current level on which the user is

		$return['ordreach_lvl'] = null; // level reached with this order
		if($userdata['to_id'] < $reached_lvl) {
			$return['ordreach_lvl'] = $reached_lvl;
		}

		return $return;

	}

	public static function checkFreeDeliveryApplicable($order_id) {
		// free delivery is applicable if it is the first order for an user, order has less than 6 products
		// and promocode for free delivery is not applied
		global $mm;
		$res = $mm->SelOne("SELECT COUNT(*) FROM orders WHERE user_id=(SELECT user_id FROM orders where id=$order_id)");
		if($res>1) return false;
		$res = $mm->SelOne("SELECT SUM(quantity) FROM order_detail WHERE order_id=$order_id");
		if($res>5) return false;
		$res = $mm->SelOne("SELECT delivery_promo FROM users WHERE id=(SELECT user_id FROM orders where id=$order_id) AND EXISTS (SELECT 1 FROM campaigns WHERE active_till >= CURDATE() AND deleted<>1 AND for_delivery=1)");
		if($res) return false;
		return true;
	}


	public static function applyFreeDelivery($promocode,$order_id) {
		global $mm;

		$promo = $mm->SelOne("
		SELECT promocode FROM campaign_promo_codes p
		LEFT JOIN campaigns c ON c.id=p.campaign_id
		WHERE p.promocode = '$promocode'
			AND c.active_till>=CURDATE()
			AND c.deleted <> 1
			AND c.for_delivery=1

		");

		if(!$promo) return false;

		$mm->Query("UPDATE users SET delivery_promo='$promo' WHERE id=(SELECT user_id FROM orders where id=$order_id)");
		$mm->Query("UPDATE orders SET delivery_price=0 WHERE id=$order_id");
		return true;
	}
}
?>
