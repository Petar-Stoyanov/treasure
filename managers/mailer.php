<?
abstract class mailer {

	public static function send_activation($user_id) {
		if(!$user_id) {
			log::logError("mailer::send_activation","UserID not sent when calling the method");
			return false;
		}
		global $_config,$mm;
		require_once "{$_config['root_dir']}/inc/Smarty/class.template.php";
		
		$tpl = new Template_Lite();
		$usr = $mm->SelArr("SELECT CONCAT_WS(' ', fname, lname) AS name, email, act_key FROM users WHERE id=$user_id");
		if(!$usr) {
			log::logError("mailer::send_activation","User with UserID [$user_id] does not exist");
			return false;
		}
		$tpl->assign_by_ref('userdata', $usr);

		$tpl->template_dir = "{$_config['root_dir']}/templates";
		$body = $tpl->fetch('mails/activation.tpl');
		$body = eregi_replace("[\]",'',$body);
		$subj = ($_SESSION['ln'] == 1 ? "Please activate your account in Lingadore.bg" : "Моля активирайте своя профил в Lingadore.bg");
		
		self::sendMail($usr, $subj, $body);
	}

	public static function send_welcome($user_id) {
		if(!$user_id) {
			log::logError("mailer::send_welcome","UserID not sent when calling the method");
			return false;
		}
		global $_config,$mm;
		require_once "{$_config['root_dir']}/inc/Smarty/class.template.php";
		
		$tpl = new Template_Lite();
		$usr = $mm->SelArr("SELECT CONCAT_WS(' ', fname, lname) AS name, email FROM users WHERE id=$user_id");
		if(!$usr) {
			log::logError("mailer::send_welcome","User with UserID [$user_id] does not exist");
			return false;
		}
		
		$usr['groups'] = $mm->SelAssoc("
										SELECT 	id,
												name_ln name,
												short_descr_ln text
										FROM	product_groups
										ORDER BY created_at DESC
									");
									
		$tpl->assign_by_ref('userdata', $usr);
		
		$tpl->template_dir = "{$_config['root_dir']}/templates";
		$body = $tpl->fetch('mails/welcome.tpl');
		$body = eregi_replace("[\]",'',$body);
		$subj = ($_SESSION['ln'] == 1 ? "Welcome to Lingadore.bg" : "Добре дошли в Lingadore.bg");
		
		self::sendMail($usr, $subj, $body);
	}
	
	public static function send_forgotten_pass($email, $pass) {
		if(!$email) {
			log::logError("mailer::send_forgotten_pass","EMail is not sent when calling the method");
			return false;
		}
		global $_config,$mm;
		require_once "{$_config['root_dir']}/inc/Smarty/class.template.php";
		
		$tpl = new Template_Lite();
		$usr = $mm->SelArr("SELECT CONCAT_WS(' ', fname, lname) AS name, email, passwd FROM users WHERE email='$email'");
		if(!$usr) {
			log::logError("mailer::send_forgotten_pass","User with Email [$email] does not exist");
			return false;
		}
		$usr['passwd'] = $pass;
		$tpl->assign_by_ref('userdata', $usr);

		$tpl->template_dir = "{$_config['root_dir']}/templates";
		$body = $tpl->fetch('mails/fpass.tpl');
		$body = eregi_replace("[\]",'',$body);
		$subj = ($_SESSION['ln'] == 1 ? "Lingadore.bg Forgotten password" : "Lingadore.bg Забравена парола");
		
		self::sendMail($usr, $subj, $body);
	}
	
	public static function send_order_change($order_id, $st1, $st2) {
		if(!$order_id) {
			log::logError("mailer::send_order_change","OrderId is not sent when calling the method");
			return false;
		}
		global $_config,$mm,$_order_status, $_langs;
		require_once "{$_config['root_dir']}/inc/Smarty/class.template.php";
		
		$tpl = new Template_Lite();
		
		$usr = $mm->SelArr("SELECT CONCAT_WS(' ', fname, lname) AS name, email FROM users WHERE id=(SELECT user_id FROM orders WHERE id=$order_id)");
		if(!$usr) {
			log::logError("mailer::send_order_change","User with Order [$order_id] does not exist");
			return false;
		}
		$tpl->assign_by_ref('userdata', $usr);
		$tpl->assign('st1', $_order_status[$_langs[$_SESSION['ln']]][$st1]);
		$tpl->assign('st2', $_order_status[$_langs[$_SESSION['ln']]][$st2]);
		$tpl->assign('order_id', $order_id);
		
		$tpl->template_dir = "{$_config['root_dir']}/templates";
		$body = $tpl->fetch("mails/order_change.tpl");
		$body = eregi_replace("[\]",'',$body);

		$subj = ($_SESSION['ln'] == 1 ? "Lingadore.bg Order status change[ID:$order_id]" : "Lingadore.bg Смяна на статус на поръчка[ID:$order_id]");

		self::sendMail($usr, $subj, $body);
	}
	
	public static function send_order_success($order_id, $user_id=null) {
		if(!$user_id) $user_id = $_SESSION['user']['id'];
		if(!$user_id) {
			log::logError("mailer::send_order_success","Userid is not sent when calling the method");
			return false;
		}
		if(!$order_id) {
			log::logError("mailer::send_order_success","Order_id is not sent when calling the method");
			return false;
		}
		global $_config,$mm;
		require_once "{$_config['root_dir']}/inc/Smarty/class.template.php";
		
		$tpl = new Template_Lite();
		$usr = $mm->SelArr("SELECT CONCAT_WS(' ', fname, lname) AS name, email, pref_lang FROM users WHERE id=$user_id");
		if(!$usr) {
			log::logError("mailer::send_order_success","User with ID [$user_id] does not exist");
			return false;
		}
		$order = order::getDetails($order_id);
		$order['address'] = $mm->SelArr("SELECT ua.street, ua.city, ua.zip, ua.phone, ac.name_ln country FROM user_addresses ua LEFT JOIN allcountries ac ON ac.id=ua.country WHERE ua.id={$order['address_id']}");
		
		$tpl->assign_by_ref('order', $order);
		$tpl->assign_by_ref('userdata', $usr);

		$tpl->template_dir = "{$_config['root_dir']}/templates";
		$body = $tpl->fetch('mails/order_success.tpl');
		$body = eregi_replace("[\]",'',$body);
		$subj = ($usr['pref_lang'] == 1 ? "Lingadore.bg Successful order[ID:$order_id]" : "Lingadore.bg Успешна поръчка[ID:$order_id]");
		
		
		
		self::sendMail($usr, $subj, $body, 'administrator@lingadore.bg', $certificates);
	}
	
	public static function send($emailto, $subject, $body, $from='administrator@lingadore.bg', $attachements=null) {
		return self::sendMail($emailto, $subject, $body, $from, $attachements);
	}
	
	private static function sendMail(&$emailto, $subject, &$body, $from='administrator@lingadore.bg', $attachements=null) {
		global $_config;
		require_once 'PHPMailer/class.phpmailer.php';
		
		$mail = new PHPMailer(); // defaults to using php "mail()"
		if($from=='newsletter@lingadore.bg') {
			$fromName = 'Lingadore.bg Newsletter';
		} else {
			$fromName = 'Lingadore.bg Administrator';
		}
		
		$mail->IsSMTP();
		$mail->Host = "mail.lingadore.bg";
		$mail->SMTPAuth = true;
		$mail->Username = $from;
		$mail->Password = "mitkovanya12";
		
		$mail->SetFrom($from, $fromName);
		$mail->AddReplyTo($from, $fromName);
		
		$mail->SetFrom($from, $fromName);
		$mail->AddReplyTo($from, $fromName);
		//$mail->AddEmbeddedImage("{$_config['root_dir']}/img/hder_mail_bg.jpg", 'header_img');
		if(!empty($emailto['images'])) {
			foreach($emailto['images'] AS $img) {
				$mail->AddEmbeddedImage("{$_config['root_dir']}{$img['path']}", $img['name']);
			}
		}
		$mail->AddAddress($emailto['email'], $emailto['name']);
		if(!$_config['debug']) {
			$mail->AddBCC("k.radoslavov@premium-bg.com", "Константин Радославов");
		}
		//$mail->AddAddress("vel_vet@abv.bg", "Иванка Василева");
		
		$mail->Subject    = $subject;
		$mail->AltBody    = strip_tags($body);
		
		$mail->MsgHTML($body);
		$mail->CharSet="UTF-8";
		if(!empty($attachements)) {
			foreach($attachements AS $a) {
				if(file_exists($a)) {
					$mail->AddAttachment($a);      // attachment
				}
			}
		}
		//$mail->AddAttachment("images/hder_top_bg.gif");      // attachment
		if($_config['debug']) return true;
		if(!$mail->Send()) {
			log::logError("mailer::sendMail;","Mail was not send due to error: " . $mail->ErrorInfo);		
			return false;
		}
		
		return true;
	}
}

?>