<?php
class bsiInstallStart 
{	
	private $bsiCoreRoot  = '';
	private $bsiHostPath  = '';
	private $bsiGallery   = 'gallery/';
	private $bsiData      = 'data/';
	private $bsiDBCONFile = '/includes/db.conn.php';
	
	public $installinfo  = array('php_version'=>false, 'gd_version'=>false, 'config_file'=>false, 'gallery_path'=>false, 'data_path'=>false);
	public $installerror = array('session_disabled'=>false, 'config_notwritable'=>false, 'gallery_notwritable'=>false, 'data_notwritable'=>false, 'gd_notinstalled'=>false, 'gd_versionnotpermit'=>false, 'mysql_notavailable'=>false);
	
	function bsiInstallStart(){
		$this->getPathInfo();
		$this->getInstallInfo(); 
	}

	private function getPathInfo(){
		$path_info = pathinfo($_SERVER["SCRIPT_FILENAME"]);
		preg_match("/(.*[\/\\\])/",$path_info['dirname'],$tmpvar);
		$this->bsiCoreRoot = $tmpvar[1];		
		$host_info = pathinfo($_SERVER["PHP_SELF"]);
		$this->bsiHostPath = "http://".$_SERVER['HTTP_HOST'].$host_info['dirname']."/";		
	}
	public function getInstallInfo(){
		$this->installinfo['php_version'] = phpversion();
		
		if (!session_id()) $this->installerror['session_disabled'] = true;
		
		$this->installinfo['config_file'] = $this->bsiCoreRoot.$this->bsiDBCONFile;
		
		// check writable settings file
		if (!is_writable($this->installinfo['config_file'])) $this->installerror['config_notwritable'] = true; 
		
		$this->installinfo['gallery_path'] = $this->bsiCoreRoot.$this->bsiGallery;
		if (!$this->checkFolder($this->installinfo['gallery_path'])) $this->installerror['gallery_notwritable'] = true;
		
		$this->installinfo['data_path'] = $this->bsiCoreRoot.$this->bsiData;
		if (!$this->checkFolder($this->installinfo['data_path'])) $this->installerror['data_notwritable'] = true;
				
		if (!in_array("gd",get_loaded_extensions())) {
			$this->installerror['gd_notinstalled'] = true;
			$this->installerror['gd_versionnotpermit'] = true;
		}
		
		if (!$this->installerror['gd_notinstalled'] && function_exists('gd_info')){
			$info = gd_info();
			$this->installinfo['gd_version'] = preg_replace("/[^\d\.]/","",$info['GD Version'])*1;	
			if ($this->installinfo['gd_version'] < 2) $this->installerror['gd_versionnotpermit'] = true;
		}
		
		if (!in_array("mysql",get_loaded_extensions())) $this->installerror['mysql_notavailable'] = true;			
	}
	
	private function checkFolder($folderPath){
		if ( !($fileHandler=@fopen($folderPath."sample_bsi_dir_test.php","a+"))) return false;
		if (!@fwrite($fileHandler,"test")) return false;
		if (!@fclose($fileHandler)) return false;
		if (!@unlink($folderPath."sample_bsi_dir_test.php")) return false;
		
		return true;
	}	
} 

class bsiInstallFinish
{	
	public $adminUserName = '';
	public $adminUserPass = '';
	public $userSitePath = '';
	public $adminSitePath = '';
	public $hotelSitePath = '';
	
	private $encAdminPass = '';
	private $hotelName = '';
	private $hotelEmail = '';
		
	function bsiInstallFinish(){
		$this->getAuthParams();		
		$this->updateConfigData();
		$this->getHostPaths();
	}

	private function getAuthParams(){
		if(trim($_POST["admin_login"])){
			$this->adminUserName = trim($_POST["admin_login"]);
		}else{
			$this->adminUserName = "admin@".$_SERVER['HTTP_HOST'];
		}		
		
		if(trim($_POST["admin_password"])){
			$this->adminUserPass = trim($_POST["admin_password"]);
		}else{
			$this->adminUserPass = $this->autoGeneratePassword(8,8);
		}
		$this->encAdminPass = md5($this->adminUserPass);		
		
		if(trim($_POST["hotel_name"])){
			$this->hotelName = trim($_POST["hotel_name"]);
		}else{
			$this->hotelName = false;
		}
		
		if(trim($_POST["hotel_email"])){
			$this->hotelEmail = trim($_POST["hotel_email"]);
		}else{
			$this->hotelEmail = false;
		}				
	}
	
	private function autoGeneratePassword($length=10, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%~';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}	
	
	private function updateConfigData(){
		mysql_query("UPDATE bsi_admin SET username = '".$this->adminUserName."', pass = '".$this->encAdminPass."' WHERE id = 1");
				
		if($this->hotelName){
			mysql_query("UPDATE bsi_configure SET conf_value = '".$this->hotelName."' WHERE conf_key = 'conf_portal_name'");
		}
		if($this->hotelEmail){
			mysql_query("UPDATE bsi_configure SET conf_value = '".$this->hotelEmail."' WHERE conf_key = 'conf_portal_email'");
		}
	}
	private function getHostPaths(){
		$host_info = pathinfo($_SERVER["PHP_SELF"]);		
		$bsiHostPath = "http://".$_SERVER['HTTP_HOST'].substr($host_info['dirname'], 0, strrpos($host_info['dirname'], '/'))."/";
		$this->hotelSitePath = $bsiHostPath."hotel/index.php";
		$this->adminSitePath = $bsiHostPath."admin/index.php";
		$this->userSitePath = $bsiHostPath."index.php";	
	}
}

class bsiInstallScript
{	
	private $bsiCoreRoot = '';
	private $bsiDBCONFile = '/includes/db.conn.php';
	public  $installerror = array('save_conn'=>false, 'mysql_conn'=>false, 'create_db'=>false, 'create_table'=>false);
	
	function bsiInstallScript(){
		$this->setConfigPath();
		$this->doInstallScript();
	}

	private function setConfigPath(){
		$path_info = pathinfo($_SERVER["SCRIPT_FILENAME"]);
		preg_match("/(.*[\/\\\])/",$path_info['dirname'],$tmpvar);
		$this->bsiCoreRoot = $tmpvar[1];			
	}
	
	private function cleanString($string){	
		$string = preg_replace("/[\'\/\\\]/","",stripslashes($string));
		return $string;
	}
	
	public function writeFile($filestring){		
		$this->bsiDBCONFile = $this->bsiCoreRoot.$this->bsiDBCONFile;		
		$fhandle = fopen($this->bsiDBCONFile,"w");
		if (!$fhandle) {
			return false;
		}	
		if (fwrite($fhandle, $filestring) === FALSE) {
			return false;
		}
		fclose ($fhandle);
		return true;
	}		
		
	public function doInstallScript(){		
		$mysql_host = $this->cleanString($_POST['mysql_host']);
		$mysql_host = !$mysql_host?"localhost":$mysql_host;	
		
		$mysql_user = $this->cleanString($_POST['mysql_login']);
		$mysql_pass = $this->cleanString($_POST['mysql_password']);
		$mysql_db   = $this->cleanString($_POST['mysql_db']);
				
		$filestring = "<?php\ndefine(\"MYSQL_SERVER\", \"".$mysql_host."\");\ndefine(\"MYSQL_USER\", \"".$mysql_user."\");\ndefine(\"MYSQL_PASSWORD\", \"".$mysql_pass."\");\ndefine(\"MYSQL_DATABASE\", \"".$mysql_db."\");\n\nmysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASSWORD) or die ('I cannot connect to the database because 1: ' . mysql_error());\nmysql_select_db(MYSQL_DATABASE) or die ('I cannot connect to the database because 2: ' . mysql_error());\n?>";		
						
		if(!$this->writeFile($filestring)){  // save settings
			$this->installerror['save_conn'] = true;
		}

		$mysql_link = @mysql_connect ($mysql_host,$mysql_user,$mysql_pass);	
	
		
		if ($mysql_link){		
			if(!mysql_select_db($mysql_db,$mysql_link)){
				// attempt to create db when doesn't exists
				if(!mysql_query ("create database ".$mysql_db, $mysql_link)) {
					$this->installerror['create_db'] = true; 
				}else{
					mysql_select_db ($mysql_db, $mysql_link);
				}
			}
		}else{			
			$this->installerror['mysql_conn'] = true;
			$this->installerror['create_db'] = true; 
		}
		

		// no errors if mysql connection successful and db is exists or was created		
		if (!$this->installerror['mysql_conn'] && !$this->installerror['create_db']){

			//install dbscripts
			$this->installDBScripts();
			
			// check if all tables was created correctly
             $allowed_tables = array(1=>"bsi_admin", "bsi_adminmenu", "bsi_agent", "bsi_agent_entry_hotel", "bsi_around_hotel", "bsi_around_hotel_category", "bsi_bookings", "bsi_capacity", "bsi_cc_info", "bsi_city", "bsi_clients", "bsi_configure", "bsi_country", "bsi_currency","bsi_deposit_discount","bsi_email_contents", "bsi_faq", "bsi_gallery", "bsi_hotelmenu", "bsi_hotels", "bsi_hotel_facilities", "bsi_hotel_review", "bsi_invoice", "bsi_language", "bsi_newsletter", "bsi_payment_gateway","bsi_popular_hotel", "bsi_priceplan","bsi_promocode", "bsi_reservation", "bsi_room", "bsi_roomtype", "bsi_site_contents", "bsi_user_access","bsi_hotel_offer","bsi_hotel_extras");
			 
             $res = mysql_query("show tables");			
             while ($row =@mysql_fetch_row($res)){				 
                  $table = preg_replace("/(.*)/","$1",$row[0]); 
                  if ($key = array_search($table,$allowed_tables)) {
                      unset ($allowed_tables[$key]);
                  }
             }

             if (count($allowed_tables)>0) $this->installerror['create_table'] = true;  // not all tables was created			
		}else{
			$this->installerror['create_table'] = true;
		}		
	}	
	
	private function installDBScripts(){
		
		mysql_query("drop table if exists `bsi_admin`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_admin` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `pass` varchar(255) NOT NULL,
					  `username` varchar(50) NOT NULL DEFAULT 'admin',
					  `access_id` int(1) NOT NULL DEFAULT '0',
					  `f_name` varchar(255) NOT NULL,
					  `l_name` varchar(255) NOT NULL,
					  `email` varchar(255) NOT NULL,
					  `designation` varchar(255) NOT NULL,
					  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  `phone` varchar(20) NOT NULL,
					  `status` binary(1) NOT NULL DEFAULT '1',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;");
					
		mysql_query("INSERT INTO `bsi_admin` VALUES('1', '21232f297a57a5a743894a0e4a801fc3', 'admin', '1', 'Administrator', '', 'yourEmail@mail.com', 'Administrator', '', '', '1');");
		
		mysql_query("drop table if exists `bsi_adminmenu`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_adminmenu` (
					  `id` int(4) NOT NULL AUTO_INCREMENT,
					  `name` varchar(200) NOT NULL DEFAULT '',
					  `url` varchar(200) DEFAULT NULL,
					  `menu_desc` varchar(200) NOT NULL DEFAULT '',
					  `parent_id` int(4) DEFAULT '0',
					  `status` enum('Y','N') DEFAULT 'Y',
					  `ord` int(5) NOT NULL DEFAULT '0',
					  `privileges` int(11) NOT NULL,
					  PRIMARY KEY (`id`),
					  UNIQUE KEY `kid` (`name`,`parent_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;");
					
		mysql_query("INSERT INTO `bsi_adminmenu` (`id`, `name`, `url`, `menu_desc`, `parent_id`, `status`, `ord`, `privileges`) VALUES
					(1, 'Home', 'admin-home.php', '', 0, 'Y', 1, 1),
					(2, 'Hotel Manager', '#', '', 0, 'Y', 3, 1),
					(3, 'Price Manager', '#', '', 0, 'Y', 5, 1),
					(4, 'Booking Manager', '#', '', 0, 'Y', 7, 1),
					(5, 'Content Manager', '#', '', 0, 'Y', 9, 1),
					(6, 'Photo Galary', '#', '', 0, 'Y', 11, 1),
					(7, 'Setting', '#', '', 0, 'Y', 13, 1),
					(9, 'Hotel List', 'hotel_list.php', '', 2, 'Y', 1, 1),
					(13, 'Room Manager', 'roomList.php', '', 2, 'Y', 2, 1),
					(14, 'Room Type Manager', 'roomTypeList.php', '', 2, 'Y', 3, 1),
					(15, 'Hotel Occupancy Types', 'capacityList.php', '', 2, 'Y', 4, 1),
					(16, 'Price Plan', 'priceplan_list.php', '', 3, 'Y', 1, 1),
					(17, 'Around category', 'hotelCategoryList.php', '', 35, 'Y', 5, 1),
					(18, 'Around Add/Edit ', 'adminAroundCategoryList.php', '', 35, 'Y', 6, 1),
					(19, 'Payment Gateway', 'payment_gateway.php', '', 7, 'Y', 2, 1),
					(21, 'Global Setting', 'global_setting.php', '', 7, 'Y', 1, 1),
					(22, 'Change Password', 'change_password.php', '', 7, 'Y', 10, 1),
					(23, 'Hotel Gallery', 'gallery_list.php', '', 6, 'Y', 1, 1),
					(24, 'View Booking', 'view_booking.php', '', 4, 'Y', 3, 1),
					(25, 'Monthly Deposit & Discount', 'deposit_discount.php', '', 3, 'Y', 4, 1),
					(26, 'Page Content Manager', 'content.list.php', '', 5, 'Y', 1, 1),
					(27, 'Book By Administrator', 'admin_room_block.php', '', 4, 'Y', 0, 1),
					(29, 'Customer Lookup', 'customerlookup.php', '', 4, 'Y', 2, 1),
					(31, 'Discount Coupon', 'discount_coupon.php', '', 3, 'Y', 2, 1),
					(32, 'Hotel Review', 'hotel_review.php', '', 5, 'Y', 4, 1),
					(35, 'Hotel Around', '#', '', 2, 'Y', 5, 1),
					(36, 'Email Template', 'email_confirmation.php', '', 5, 'Y', 2, 1),
					(37, 'Hotel Facility', 'hotel_facility_list.php', '', 2, 'Y', 6, 1),
					(38, 'Home Slider Gallery', 'admin_home_slider_gallery.php', '2', 6, 'Y', 0, 0),
					(39, 'User Manager', 'user_list.php', '', 7, 'Y', 5, 0),
					(40, 'NewsLetter', 'newsletter.php', '', 5, 'Y', 5, 1),
					(41, 'Agent Manager', '#', '', 0, 'Y', 4, 0),
					(42, 'Agent', 'agent_list.php', '', 41, 'Y', 1, 0),
					(43, 'Commission', 'commission.php', '', 41, 'Y', 2, 0),
					(44, 'Room Blocking', 'admin_block_room.php', '', 4, 'Y', 4, 1),
					(45, 'Calendar View', 'calendar_view.php', '', 4, 'Y', 5, 1),
					(46, 'Language', 'admin_language.php', '', 7, 'Y', 3, 0),
					(47, 'Country Manager', 'country_list.php', '', 7, 'Y', 5, 1),
					(48, 'City Manager', 'city_list.php', '', 7, 'Y', 6, 1),
					(49, 'Generate Booking List', 'gen-booking-list.php', '', 4, 'Y', 8, 1),
					(52, 'Monthly Discount & Deposit', 'discount_deposit.php', '', 3, 'Y', 3, 1),
					(53, 'Booking Summary Report', 'booking_summary_report.php', '', 4, 'Y', 9, 1),
					(54, 'Currency Manager', '#', '', 0, 'Y', 8, 1),
					(55, 'Manage Currency', 'currency_list.php', '', 54, 'Y', 1, 1),
					(56, 'Popular Hotel', 'add_popular_hotel.php', '', 2, 'Y', 10, 1),
					(57, 'Hotel Extras', 'hotel_extras.php', '', 3, 'Y', 4, 1),
					(58, 'Hotel Offer', 'hotel_offer.php', '', 3, 'Y', 5, 1);");
		
		mysql_query("drop table if exists `bsi_agent`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_agent` (
					  `agent_id` int(11) NOT NULL AUTO_INCREMENT,
					  `company` varchar(255) NOT NULL,
					  `fname` varchar(255) NOT NULL,
					  `lname` varchar(255) NOT NULL,
					  `email` varchar(50) NOT NULL,
					  `password` varchar(100) NOT NULL,
					  `phone` varchar(15) NOT NULL,
					  `fax` varchar(15) NOT NULL,
					  `address` varchar(255) NOT NULL,
					  `city` varchar(255) NOT NULL,
					  `state` varchar(255) NOT NULL,
					  `country` varchar(255) NOT NULL,
					  `zipcode` varchar(10) NOT NULL,
					  `status` tinyint(1) NOT NULL,
					  `commission` decimal(10,2) NOT NULL,
					  `register_date` date NOT NULL,
					  PRIMARY KEY (`agent_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
		
		mysql_query("drop table if exists `bsi_agent_entry_hotel`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_agent_entry_hotel` (
					  `agent_id` int(10) NOT NULL,
					  `hotel_id` int(10) NOT NULL
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		
		mysql_query("drop table if exists `bsi_around_hotel`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_around_hotel` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `category_id` int(11) NOT NULL,
					  `hotel_id` int(11) NOT NULL,
					  `title` varchar(255) NOT NULL,
					  `distance` varchar(100) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");					
		
		mysql_query("drop table if exists `bsi_around_hotel_category`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_around_hotel_category` (
					  `category_id` int(11) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `category_title` varchar(255) NOT NULL,
					  PRIMARY KEY (`category_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");	
					
		mysql_query("drop table if exists `bsi_bookings`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_bookings` (
					  `booking_id` varchar(50) NOT NULL,
					  `hotel_id` int(11) NOT NULL,
					  `booking_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  `checkin_date` date NOT NULL DEFAULT '0000-00-00',
					  `checkout_date` date NOT NULL DEFAULT '0000-00-00',
					  `agent_id` int(11) NOT NULL,
					  `client_id` int(11) unsigned DEFAULT NULL,
					  `child_count` int(2) NOT NULL DEFAULT '0',
					  `extra_guest_count` int(2) NOT NULL DEFAULT '0',
					  `discount_coupon` varchar(50) DEFAULT NULL,
					  `total_cost` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
					  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
					  `payment_type` varchar(255) NOT NULL,
					  `payment_success` tinyint(1) NOT NULL DEFAULT '0',
					  `payment_txnid` varchar(100) DEFAULT NULL,
					  `paypal_email` varchar(500) DEFAULT NULL,
					  `special_id` int(10) unsigned NOT NULL DEFAULT '0',
					  `special_requests` text,
					  `is_block` tinyint(4) NOT NULL DEFAULT '0',
					  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
					  `agent` tinyint(1) DEFAULT '0',
					  `commission` decimal(10,2) NOT NULL,
					  PRIMARY KEY (`booking_id`),
					  KEY `start_date` (`checkin_date`),
					  KEY `end_date` (`checkout_date`),
					  KEY `booking_time` (`discount_coupon`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");			
		
		mysql_query("drop table if exists `bsi_capacity`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_capacity` (
					  `capacity_id` int(11) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `title` varchar(255) NOT NULL,
					  `capacity` int(11) NOT NULL,
					  PRIMARY KEY (`capacity_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
	   mysql_query("drop table if exists `bsi_cc_info`");
	   
	   mysql_query("CREATE TABLE IF NOT EXISTS `bsi_cc_info` (
					  `booking_id` varchar(100) NOT NULL,
					  `cardholder_name` varchar(255) NOT NULL,
					  `card_type` varchar(50) NOT NULL,
					  `card_number` blob NOT NULL,
					  `expiry_date` varchar(10) NOT NULL,
					  `ccv2_no` int(4) NOT NULL,
					  PRIMARY KEY (`booking_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
		
		mysql_query("drop table if exists `bsi_city`");
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_city` (
					  `cid` int(10) NOT NULL AUTO_INCREMENT,
					  `country_code` varchar(255) NOT NULL,
					  `city_name` varchar(255) NOT NULL,
					  `default_img` varchar(255) NOT NULL,
					  PRIMARY KEY (`cid`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
					
		mysql_query("drop table if exists `bsi_clients`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_clients` (
					  `client_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `first_name` varchar(64) DEFAULT NULL,
					  `surname` varchar(64) DEFAULT NULL,
					  `title` varchar(16) DEFAULT NULL,
					  `street_addr` text,
					  `street_addr2` text NOT NULL,
					  `city` varchar(64) DEFAULT NULL,
					  `province` varchar(128) DEFAULT NULL,
					  `zip` varchar(64) DEFAULT NULL,
					  `country` varchar(64) DEFAULT NULL,
					  `phone` varchar(64) DEFAULT NULL,
					  `email` varchar(128) DEFAULT NULL,
					  `password` varchar(255) NOT NULL,
					  `ip` varchar(32) DEFAULT NULL,
					  `agent` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`client_id`),
					  KEY `email` (`email`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
		
		mysql_query("drop table if exists `bsi_configure`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_configure` (
					  `conf_id` int(11) NOT NULL AUTO_INCREMENT,
					  `conf_key` varchar(100) NOT NULL,
					  `conf_value` varchar(500) DEFAULT NULL,
					  PRIMARY KEY (`conf_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='bsi hotel configurations';");
					
		mysql_query("INSERT INTO `bsi_configure` (`conf_id`, `conf_key`, `conf_value`) VALUES
					(1, 'conf_portal_name', 'BSI Multi Hotel Demo'),
					(2, 'conf_portal_streetaddr', '99 abcde Road'),
					(3, 'conf_portal_city', 'Your City'),
					(4, 'conf_portal_state', 'Your State'),
					(5, 'conf_portal_country', 'Your Country'),
					(6, 'conf_portal_zipcode', '11111'),
					(7, 'conf_portal_phone', '9999999999'),
					(8, 'conf_portal_fax', '8888888888'),
					(9, 'conf_portal_email', 'youremail@mail.com'),
					(10, 'conf_portal_sitetitle', 'BSI Multi Hotel Demo'),
					(11, 'conf_portal_sitedesc', 'Testing\r\n'),
					(12, 'conf_portal_sitekeywords', 'Testing\r\n'),
					(13, 'conf_currency_symbol', '$'),
					(14, 'conf_currency_code', 'USD'),
					(15, 'conf_smtp_mail', 'false'),
					(16, 'conf_smtp_host', 'ssl://smtp.gmail.com'),
					(17, 'conf_smtp_port', '465'),
					(18, 'conf_smtp_username', 'youremail@mail.com'),
					(19, 'conf_smtp_password', 'xxxxxxxxxxxxx'),
					(20, 'conf_tax_amount', '12.25'),
					(21, 'conf_dateformat', 'mm/dd/yy'),
					(22, 'conf_booking_exptime', '500'),
					(23, 'conf_license_key', 'dfd924c73621e8a5d527ea51caabfc91'),
					(24, 'conf_enabled_discount', '1'),
					(25, 'conf_enabled_deposit', '1'),
					(26, 'conf_portal_timezone', 'Asia/Calcutta'),
					(27, 'conf_booking_turn_off', '0'),
					(28, 'conf_min_night_booking', '2'),
					(29, 'conf_server_os', '1'),
					(30, 'conf_portal_logo', '1351679509_logo.jpg'),
					(31, 'conf_portal_signature', '1351679509_stamp.jpg'),
					(32, 'conf_bookingid_prefix', 'BSI'),
					(33, 'destination_search_type', '0'),
					(34, 'conf_payment_commission', '0'),
					(35, 'conf_agent_hotel', '1'),
					(36, 'conf_theme_color', 'none'),
					(37, 'hotel_price_listing', '0'),
					(38, 'conf-google-ads', ''),
					(39, 'conf_portal_twitter_link', 'https://twitter.com/'),
					(40, 'conf_portal_facebook_link', 'https://www.facebook.com/'),
					(41, 'conf_portal_linkedin_link', 'https://www.facebook.com/'),
					(42, 'conf_portal_pinterest_link', 'https://www.facebook.com/'),
					(43, 'conf_portal_googleplus_link', 'https://www.facebook.com/'),
					(44, 'conf_pdf_logo', '1436440624_stamp1.jpg');");
					
							
		mysql_query("drop table if exists `bsi_country`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_country` (
					  `country_code` char(2) NOT NULL DEFAULT '',
					  `name` varchar(80) NOT NULL DEFAULT '',
					  `cou_name` varchar(80) NOT NULL DEFAULT '',
					  `iso3` char(3) DEFAULT NULL,
					  `numcode` smallint(6) DEFAULT NULL,
					  PRIMARY KEY (`country_code`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
					
		mysql_query("INSERT INTO `bsi_country` (`country_code`, `name`, `cou_name`, `iso3`, `numcode`) VALUES
					('FR', 'FRANCE', 'France', 'FRA', 250),
					('IN', 'INDIA', 'India', 'IND', 356),
					('IT', 'ITALY', 'Italy', 'ITA', 380),
					('NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554),
					('US', 'UNITED STATES', 'United States', 'USA', 840);");
					
		mysql_query("DROP TABLE IF EXISTS `bsi_currency`;");	
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_currency` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `currency_code` varchar(10) NOT NULL,
					  `currency_symbl` varchar(10) NOT NULL,
					  `exchange_rate` decimal(20,6) NOT NULL,
					  `default_c` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
		mysql_query("INSERT INTO `bsi_currency` (`id`, `currency_code`, `currency_symbl`, `exchange_rate`, `default_c`) VALUES
(1, 'USD', '$', 1.000000, 1);");


mysql_query("DROP TABLE IF EXISTS `bsi_deposit_discount`");
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_deposit_discount` (
					  `month_num` int(11) NOT NULL AUTO_INCREMENT,
					  `month` varchar(255) NOT NULL,
					  `discount_percent` decimal(10,2) NOT NULL,
					  `deposit_percent` decimal(10,2) NOT NULL,
					  PRIMARY KEY (`month_num`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1");
		
		mysql_query("INSERT INTO `bsi_deposit_discount` (`month_num`, `month`, `discount_percent`, `deposit_percent`) VALUES
					(1, 'January', '0.00', '0.00'),
					(2, 'February', '0.00', '0.00'),
					(3, 'March', '0.00', '0.00'),
					(4, 'April', '0.00', '0.00'),
					(5, 'May', '0.00', '0.00'),
					(6, 'June', '0.00', '0.00'),
					(7, 'July', '0.00', '0.00'),
					(8, 'August', '0.00', '0.00'),
					(9, 'September', '0.00', '0.00'),
					(10, 'October', '0.00', '0.00'),
					(11, 'November', '0.00', '0.00'),
					(12, 'December', '0.00', '0.00')");
									
		mysql_query("drop table if exists `bsi_email_contents`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_email_contents` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `email_name` varchar(500) NOT NULL,
					  `email_subject` varchar(500) NOT NULL,
					  `email_text` longtext NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
		mysql_query("INSERT INTO `bsi_email_contents` (`id`, `email_name`, `email_subject`, `email_text`) VALUES
					(1, 'Confirmation Email', 'Confirmation of your successfull Bookings', 'Text can be changed in admin panel'),
					(2, 'Cancellation Email ', 'Cancellation of your booking', 'text can be changed from admin panel'),
					(3, 'Text Email', 'about health', 'i am fine i am fine');");
		
		mysql_query("drop table if exists `bsi_faq`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_faq` (
					  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
					  `question` text NOT NULL,
					  `answer` text NOT NULL,
					  PRIMARY KEY (`faq_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
		mysql_query("drop table if exists `bsi_gallery`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_gallery` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `img_path` varchar(500) NOT NULL,
					  `description` varchar(500) DEFAULT NULL,
					  `gallery_type` varchar(255) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
		mysql_query("INSERT INTO `bsi_gallery` (`id`, `hotel_id`, `img_path`, `description`, `gallery_type`) VALUES
					(43, 0, '1436607125_slider4.jpg', '', '2'),
					(44, 0, '1436607125_slide4.jpg', '', '2'),
					(45, 0, '1436607143_slider2.jpg', '', '2');
					");
									
		mysql_query("drop table if exists `bsi_hotelmenu`");	
				
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_hotelmenu` (
					  `id` int(4) NOT NULL AUTO_INCREMENT,
					  `name` varchar(200) NOT NULL DEFAULT '',
					  `url` varchar(200) DEFAULT NULL,
					  `menu_desc` varchar(200) NOT NULL DEFAULT '',
					  `parent_id` int(4) DEFAULT '0',
					  `status` enum('Y','N') DEFAULT 'Y',
					  `ord` int(5) NOT NULL DEFAULT '0',
					  `privileges` int(11) NOT NULL,
					  PRIMARY KEY (`id`),
					  UNIQUE KEY `kid` (`name`,`parent_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
		
		mysql_query("INSERT INTO `bsi_hotelmenu` (`id`, `name`, `url`, `menu_desc`, `parent_id`, `status`, `ord`, `privileges`) VALUES
					(1, 'Home', 'hotel-home.php', '', 0, 'Y', 1, 1),
					(2, 'Hotel Manager', '#', '', 0, 'Y', 2, 1),
					(3, 'Booking Manager', '#', '', 0, 'Y', 4, 1),
					(4, 'Galary', '#', '', 0, 'Y', 5, 1),
					(5, 'Hotel Details', 'hotel_list.php', '', 2, 'Y', 1, 1),
					(6, 'Room Manager', 'roomList.php', '', 2, 'Y', 2, 1),
					(7, 'Room Type Manager', 'roomTypeList.php', '', 2, 'Y', 3, 1),
					(8, 'Capacity Manager', 'capacityList.php', '', 2, 'Y', 4, 1),
					(9, 'View Booking', 'view_booking.php', '', 3, 'Y', 1, 1),
					(10, 'Booking History', 'booking_history.php', '', 3, 'Y', 2, 1),
					(11, 'Room Blocking', 'admin_block_room.php', '', 3, 'Y', 3, 1),
					(12, 'Calendar View', 'calendar_view.php', '', 3, 'Y', 4, 1),
					(14, 'Hotel Gallery', 'gallery_list.php', '', 4, 'Y', 1, 1),
					(15, 'Hotel Around', '#', '', 2, 'Y', 5, 1),
					(16, 'Hotel Facility', 'hotel_facility_list.php', '', 2, 'Y', 6, 1),
					(17, 'Around category', 'hotelCategoryList.php', '', 15, 'Y', 1, 1),
					(18, 'Around Add/Edit ', 'adminAroundCategoryList.php', '', 15, 'Y', 2, 1),
					(19, 'Price Manager', '#', '', 0, 'Y', 3, 1),
					(20, 'Price Plan', 'priceplan_list.php', '', 19, 'Y', 1, 1);");
		
		mysql_query("drop table if exists `bsi_hotels`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_hotels` (
					  `hotel_id` int(11) NOT NULL AUTO_INCREMENT,
					  `hotel_name` varchar(255) NOT NULL,
					  `address_1` varchar(255) NOT NULL,
					  `address_2` varchar(255) NOT NULL,
					  `city_name` varchar(255) NOT NULL,
					  `state` varchar(255) NOT NULL,
					  `post_code` varchar(10) NOT NULL,
					  `country_code` varchar(4) NOT NULL,
					  `email_addr` varchar(100) NOT NULL,
					  `phone_number` varchar(50) NOT NULL,
					  `fax_number` varchar(50) NOT NULL,
					  `desc_short` text NOT NULL,
					  `desc_long` longtext NOT NULL,
					  `checking_hour` varchar(256) NOT NULL,
					  `checkout_hour` varchar(256) NOT NULL,
					  `pets_status` tinyint(1) NOT NULL,
					  `latitude` varchar(30) NOT NULL,
					  `longitude` varchar(30) NOT NULL,
					  `terms_n_cond` longtext NOT NULL,
					  `status` tinyint(1) NOT NULL,
					  `password` varchar(255) NOT NULL,
					  `star_rating` int(11) NOT NULL,
					  `default_img` varchar(255) DEFAULT NULL,
					  PRIMARY KEY (`hotel_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
		mysql_query("drop table if exists `bsi_hotel_facilities`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_hotel_facilities` (
					  `facilities_id` int(11) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `general` text NOT NULL,
					  `activities` text NOT NULL,
					  `services` text NOT NULL,
					  PRIMARY KEY (`facilities_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
		
		mysql_query("drop table if exists `bsi_hotel_review`");	
				
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_hotel_review` (
					  `review_id` int(11) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `booking_id` varchar(50) NOT NULL,
					  `client_id` int(11) NOT NULL,
					  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  `comment_positive` text NOT NULL,
					  `comment_negetive` text NOT NULL,
					  `rating_clean` decimal(10,2) NOT NULL,
					  `rating_comfort` decimal(10,2) NOT NULL,
					  `rating_location` decimal(10,2) NOT NULL,
					  `rating_services` decimal(10,2) NOT NULL,
					  `rating_staff` decimal(10,2) NOT NULL,
					  `rating_value_fr_money` decimal(10,2) NOT NULL,
					  `approved` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`review_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


		mysql_query("drop table if exists `bsi_invoice`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_invoice` (
					  `booking_id` varchar(50) NOT NULL,
					  `client_name` varchar(500) NOT NULL,
					  `client_email` varchar(500) NOT NULL,
					  `invoice` longtext NOT NULL,
					  PRIMARY KEY (`booking_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1");
		
		mysql_query("drop table if exists `bsi_language`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_language` (
					  `lang_id` int(11) NOT NULL AUTO_INCREMENT,
					  `language` varchar(255) NOT NULL,
					  `lang_code` varchar(4) NOT NULL,
					  `lang_file_name` varchar(255) NOT NULL,
					  `status` tinyint(1) NOT NULL,
					  `default` tinyint(1) NOT NULL,
					  `lang_order` int(11) NOT NULL,
					  PRIMARY KEY (`lang_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
		mysql_query("INSERT INTO `bsi_language` (`lang_id`, `language`, `lang_code`, `lang_file_name`, `status`, `default`, `lang_order`) VALUES
					(1, 'English', 'en', 'english.php', 1, 1, 1),
					(2, 'Deutsch', 'de', 'german.php', 1, 0, 3),
					(3, 'Espa&#241;ol', 'es', 'espanol.php', 1, 0, 2),
					(4, 'Fran&#231;aise', 'fr', 'french.php', 1, 0, 4),
					(5, 'Greek', 'el', 'greek.php', 1, 0, 5),
					(6, 'Italiano', 'it', 'italiano.php', 1, 0, 6),
					(7, 'Albanian', 'alb', 'albanian.php', 1, 0, 7);");
					
					
		mysql_query("drop table if exists `bsi_newsletter`");	
				
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_newsletter` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `email` varchar(64) NOT NULL,
					  `emailTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");		
		
		mysql_query("drop table if exists `bsi_payment_gateway`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_payment_gateway` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `gateway_name` varchar(255) NOT NULL,
					  `gateway_code` varchar(50) NOT NULL,
					  `account` varchar(255) DEFAULT NULL,
					  `enabled` tinyint(1) NOT NULL DEFAULT '0',
					  `ord` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
		mysql_query("INSERT INTO `bsi_payment_gateway` (`id`, `gateway_name`, `gateway_code`, `account`, `enabled`, `ord`) VALUES
					(1, 'PayPal', 'pp', 'phpdev_1330251667_biz@aol.com', 1, 1),
					(2, 'Manual', 'poa', NULL, 1, 4),
					(3, 'Credit Card', 'cc', '', 1, 3);");
					
		mysql_query("drop table if exists `bsi_popular_hotel`");
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_popular_hotel` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`Hotel_id` int(11) NOT NULL,
					 PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");	
					
						
		mysql_query("drop table if exists `bsi_priceplan`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_priceplan` (
					`priceplan_id` int(11) NOT NULL AUTO_INCREMENT,
					`hotel_id` int(11) NOT NULL,
					`room_type_id` int(11) NOT NULL,
					`capacity_id` int(11) NOT NULL,
					`date_start` date NOT NULL DEFAULT '0000-00-00',
					`date_end` date NOT NULL DEFAULT '0000-00-00',
					`sun` decimal(10,2) NOT NULL,
					`mon` decimal(10,2) NOT NULL,
					`tue` decimal(10,2) NOT NULL,
					`wed` decimal(10,2) NOT NULL,
					`thu` decimal(10,2) NOT NULL,
					`fri` decimal(10,2) NOT NULL,
					`sat` decimal(10,2) NOT NULL,
					`default` tinyint(1) NOT NULL DEFAULT '1',
					`extrabed` decimal(10,2) NOT NULL,
					PRIMARY KEY (`priceplan_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
		
		mysql_query("drop table if exists `bsi_reservation`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_reservation` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `booking_id` varchar(50) NOT NULL,
					  `room_id` int(11) NOT NULL,
					  `roomtype_id` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
		mysql_query("DROP TABLE IF EXISTS `bsi_promocode`");
				mysql_query("CREATE TABLE IF NOT EXISTS `bsi_promocode` (
				`promo_id` int(11) NOT NULL AUTO_INCREMENT,
				`promo_code` varchar(50) NOT NULL,
				`discount` decimal(10,2) NOT NULL DEFAULT '0.00',
				`min_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
				`percentage` tinyint(1) NOT NULL DEFAULT '1',
				`promo_category` int(1) NOT NULL COMMENT '1 - All customer, 2 - Existing Customer, 3 - one selected customer',
				`customer_email` varchar(255) DEFAULT NULL,
				`exp_date` date DEFAULT NULL,
				`reuse_promo` tinyint(1) NOT NULL DEFAULT '1',
				PRIMARY KEY (`promo_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1");	
					
		
		
		mysql_query("drop table if exists `bsi_room`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_room` (
					  `room_id` int(10) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `roomtype_id` int(10) DEFAULT NULL,
					  `room_no` varchar(255) DEFAULT NULL,
					  `capacity_id` int(10) DEFAULT NULL,
					  `no_of_child` int(11) NOT NULL DEFAULT '0',
					  `extra_bed` tinyint(1) NOT NULL,
					  PRIMARY KEY (`room_id`),
					  KEY `roomtype_id` (`roomtype_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
		
		
		mysql_query("drop table if exists `bsi_roomtype`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_roomtype` (
					  `roomtype_id` int(10) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `type_name` varchar(500) DEFAULT NULL,
					  `roomtype_name` varchar(255) NOT NULL,
					  `rtype_image` varchar(255) NOT NULL,
					  `services` text,
						`roomsize` varchar(255) NOT NULL,
						`bedsize` varchar(255) NOT NULL,
					  PRIMARY KEY (`roomtype_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");	
					
		mysql_query("drop table if exists `bsi_site_contents`");
						
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_site_contents` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `cont_title` varchar(200) NOT NULL DEFAULT '',
					  `contents` mediumtext,
					  `status` enum('Y','N') DEFAULT 'Y',
					  `file` text,
					  `url` varchar(100) DEFAULT '',
					  `image` varchar(50) DEFAULT '',
					  `menu` int(1) DEFAULT '0',
					  `parent_id` int(10) DEFAULT '0',
					  `ord` int(11) DEFAULT '0',
					  `page_title` varchar(200) DEFAULT '',
					  `page_keywords` text,
					  `page_desc` text,
					  `header_type` enum('0','1') DEFAULT '0',
					  `footer_type` enum('0','1') DEFAULT '0',
					  PRIMARY KEY (`id`),
					  UNIQUE KEY `cont_title` (`cont_title`,`parent_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");	
					
		mysql_query("INSERT INTO `bsi_site_contents` (`id`, `cont_title`, `contents`, `status`, `file`, `url`, `image`, `menu`, `parent_id`, `ord`, `page_title`, `page_keywords`, `page_desc`, `header_type`, `footer_type`) VALUES
(1, 'Home', '<p>Text Can be changed from admin Panel</p>\r\n', 'Y', NULL, 'index.php', '', 0, 0, 1, '', NULL, NULL, '1', '0'),
(6, 'Guest Corner', '<p>\r\n	Text Can be changed from admin Panel.</p>\r\n', 'Y', NULL, '', '', 0, 0, 1, '', NULL, NULL, '1', '0'),
(7, 'How to make a reservation?', '<p>Lorem ipsum dolor sit amet, deserunt pericula sea ut, ei sed oratio dolores. Aeque nullam at ius, no quo nobis audire instructior. Paulo bonorum conceptam ne mea, ad sumo mandamus expetendis eos, doming expetendis incorrupte te per. Te vel quot tibique, sed debet eruditi id. Pri fugit maiorum consequat ad, summo viris ut qui.</p>\r\n\r\n<p>Cu eum aliquid ponderum assentior. Appareat delicata qui at, cum ne idque iudico suavitate, vide neglegentur signiferumque ea pri. Pro quem efficiendi id, rebum tamquam per id, id sed choro omnes mandamus. Ei quod eros pericula pro, ludus scripta honestatis vel in, te his facete persius perfecto. Cu vis pertinacia efficiantur signiferumque.</p>\r\n\r\n<p>Ut aliquip impedit mandamus nam. Vim te etiam voluptatum. Ad vel etiam principes. Mea harum labore ut.</p>\r\n\r\n<p>Pro an sale aliquip, qui harum gloriatur ut. Dicat equidem consequat has ad, sed ne nostrum fastidii percipit. Fabellas ullamcorper his ut, ex elit simul has. Cu nam omnis nominavi appellantur, quo eu sale everti assueverit, in vix suas possim meliore. Noster melius concludaturque vix ei, id odio putant lucilius quo. Ut vix scripta necessitatibus, an dicat assueverit eam.</p>\r\n\r\n<p>Ius solet detracto nominavi in, nec ne zril salutatus prodesset, sint graeco ad mei. Zril iriure qualisque eos ei, nec in dolor vulputate pertinacia, ex liber numquam persecuti eam. Quo ponderum democritum te, tritani sensibus abhorreant no eam, prodesset posidonium ne nec. Sit propriae consetetur dissentiunt id, sale adversarium conclusionemque et eam. Per nemore albucius in, accommodare concludaturque ea sit. Dolore ignota ullamcorper nec ex, vero quando nec an.</p>\r\n', 'Y', NULL, '', '', 0, 6, 1, '', NULL, NULL, '0', '0'),
(10, 'Additional information', '<p>Lorem ipsum dolor sit amet, deserunt pericula sea ut, ei sed oratio dolores. Aeque nullam at ius, no quo nobis audire instructior. Paulo bonorum conceptam ne mea, ad sumo mandamus expetendis eos, doming expetendis incorrupte te per. Te vel quot tibique, sed debet eruditi id. Pri fugit maiorum consequat ad, summo viris ut qui.</p>\r\n\r\n<p>Cu eum aliquid ponderum assentior. Appareat delicata qui at, cum ne idque iudico suavitate, vide neglegentur signiferumque ea pri. Pro quem efficiendi id, rebum tamquam per id, id sed choro omnes mandamus. Ei quod eros pericula pro, ludus scripta honestatis vel in, te his facete persius perfecto. Cu vis pertinacia efficiantur signiferumque.</p>\r\n\r\n<p>Ut aliquip impedit mandamus nam. Vim te etiam voluptatum. Ad vel etiam principes. Mea harum labore ut.</p>\r\n\r\n<p>Pro an sale aliquip, qui harum gloriatur ut. Dicat equidem consequat has ad, sed ne nostrum fastidii percipit. Fabellas ullamcorper his ut, ex elit simul has. Cu nam omnis nominavi appellantur, quo eu sale everti assueverit, in vix suas possim meliore. Noster melius concludaturque vix ei, id odio putant lucilius quo. Ut vix scripta necessitatibus, an dicat assueverit eam.</p>\r\n\r\n<p>Ius solet detracto nominavi in, nec ne zril salutatus prodesset, sint graeco ad mei. Zril iriure qualisque eos ei, nec in dolor vulputate pertinacia, ex liber numquam persecuti eam. Quo ponderum democritum te, tritani sensibus abhorreant no eam, prodesset posidonium ne nec. Sit propriae consetetur dissentiunt id, sale adversarium conclusionemque et eam. Per nemore albucius in, accommodare concludaturque ea sit. Dolore ignota ullamcorper nec ex, vero quando nec an.</p>\r\n', 'Y', NULL, '', '', 0, 6, 2, '', NULL, NULL, '0', '0'),
(11, 'Payment options', '<p>Lorem ipsum dolor sit amet, deserunt pericula sea ut, ei sed oratio dolores. Aeque nullam at ius, no quo nobis audire instructior. Paulo bonorum conceptam ne mea, ad sumo mandamus expetendis eos, doming expetendis incorrupte te per. Te vel quot tibique, sed debet eruditi id. Pri fugit maiorum consequat ad, summo viris ut qui.</p>\r\n\r\n<p>Cu eum aliquid ponderum assentior. Appareat delicata qui at, cum ne idque iudico suavitate, vide neglegentur signiferumque ea pri. Pro quem efficiendi id, rebum tamquam per id, id sed choro omnes mandamus. Ei quod eros pericula pro, ludus scripta honestatis vel in, te his facete persius perfecto. Cu vis pertinacia efficiantur signiferumque.</p>\r\n\r\n<p>Ut aliquip impedit mandamus nam. Vim te etiam voluptatum. Ad vel etiam principes. Mea harum labore ut.</p>\r\n\r\n<p>Pro an sale aliquip, qui harum gloriatur ut. Dicat equidem consequat has ad, sed ne nostrum fastidii percipit. Fabellas ullamcorper his ut, ex elit simul has. Cu nam omnis nominavi appellantur, quo eu sale everti assueverit, in vix suas possim meliore. Noster melius concludaturque vix ei, id odio putant lucilius quo. Ut vix scripta necessitatibus, an dicat assueverit eam.</p>\r\n\r\n<p>Ius solet detracto nominavi in, nec ne zril salutatus prodesset, sint graeco ad mei. Zril iriure qualisque eos ei, nec in dolor vulputate pertinacia, ex liber numquam persecuti eam. Quo ponderum democritum te, tritani sensibus abhorreant no eam, prodesset posidonium ne nec. Sit propriae consetetur dissentiunt id, sale adversarium conclusionemque et eam. Per nemore albucius in, accommodare concludaturque ea sit. Dolore ignota ullamcorper nec ex, vero quando nec an.</p>\r\n', 'Y', NULL, '', '', 0, 6, 3, '', NULL, NULL, '0', '0'),
(12, 'Customer Service', '<p>Lorem ipsum dolor sit amet, deserunt pericula sea ut, ei sed oratio dolores. Aeque nullam at ius, no quo nobis audire instructior. Paulo bonorum conceptam ne mea, ad sumo mandamus expetendis eos, doming expetendis incorrupte te per. Te vel quot tibique, sed debet eruditi id. Pri fugit maiorum consequat ad, summo viris ut qui.</p>\r\n\r\n<p>Cu eum aliquid ponderum assentior. Appareat delicata qui at, cum ne idque iudico suavitate, vide neglegentur signiferumque ea pri. Pro quem efficiendi id, rebum tamquam per id, id sed choro omnes mandamus. Ei quod eros pericula pro, ludus scripta honestatis vel in, te his facete persius perfecto. Cu vis pertinacia efficiantur signiferumque.</p>\r\n\r\n<p>Ut aliquip impedit mandamus nam. Vim te etiam voluptatum. Ad vel etiam principes. Mea harum labore ut.</p>\r\n\r\n<p>Pro an sale aliquip, qui harum gloriatur ut. Dicat equidem consequat has ad, sed ne nostrum fastidii percipit. Fabellas ullamcorper his ut, ex elit simul has. Cu nam omnis nominavi appellantur, quo eu sale everti assueverit, in vix suas possim meliore. Noster melius concludaturque vix ei, id odio putant lucilius quo. Ut vix scripta necessitatibus, an dicat assueverit eam.</p>\r\n\r\n<p>Ius solet detracto nominavi in, nec ne zril salutatus prodesset, sint graeco ad mei. Zril iriure qualisque eos ei, nec in dolor vulputate pertinacia, ex liber numquam persecuti eam. Quo ponderum democritum te, tritani sensibus abhorreant no eam, prodesset posidonium ne nec. Sit propriae consetetur dissentiunt id, sale adversarium conclusionemque et eam. Per nemore albucius in, accommodare concludaturque ea sit. Dolore ignota ullamcorper nec ex, vero quando nec an.</p>\r\n', 'Y', NULL, '', '', 0, 6, 4, '', NULL, NULL, '0', '0'),
(13, 'About Us', '<p>Lorem ipsum dolor sit amet, deserunt pericula sea ut, ei sed oratio dolores. Aeque nullam at ius, no quo nobis audire instructior. Paulo bonorum conceptam ne mea, ad sumo mandamus expetendis eos, doming expetendis incorrupte te per. Te vel quot tibique, sed debet eruditi id. Pri fugit maiorum consequat ad, summo viris ut qui.</p>\r\n\r\n<p>Cu eum aliquid ponderum assentior. Appareat delicata qui at, cum ne idque iudico suavitate, vide neglegentur signiferumque ea pri. Pro quem efficiendi id, rebum tamquam per id, id sed choro omnes mandamus. Ei quod eros pericula pro, ludus scripta honestatis vel in, te his facete persius perfecto. Cu vis pertinacia efficiantur signiferumque.</p>\r\n\r\n<p>Ut aliquip impedit mandamus nam. Vim te etiam voluptatum. Ad vel etiam principes. Mea harum labore ut.</p>\r\n\r\n<p>Pro an sale aliquip, qui harum gloriatur ut. Dicat equidem consequat has ad, sed ne nostrum fastidii percipit. Fabellas ullamcorper his ut, ex elit simul has. Cu nam omnis nominavi appellantur, quo eu sale everti assueverit, in vix suas possim meliore. Noster melius concludaturque vix ei, id odio putant lucilius quo. Ut vix scripta necessitatibus, an dicat assueverit eam.</p>\r\n\r\n<p>Ius solet detracto nominavi in, nec ne zril salutatus prodesset, sint graeco ad mei. Zril iriure qualisque eos ei, nec in dolor vulputate pertinacia, ex liber numquam persecuti eam. Quo ponderum democritum te, tritani sensibus abhorreant no eam, prodesset posidonium ne nec. Sit propriae consetetur dissentiunt id, sale adversarium conclusionemque et eam. Per nemore albucius in, accommodare concludaturque ea sit. Dolore ignota ullamcorper nec ex, vero quando nec an.</p>\r\n', 'Y', NULL, '', '', 0, 0, 3, '', NULL, NULL, '1', '0'),
(20, 'Offers', '<p>Lorem ipsum dolor sit amet, deserunt pericula sea ut, ei sed oratio dolores. Aeque nullam at ius, no quo nobis audire instructior. Paulo bonorum conceptam ne mea, ad sumo mandamus expetendis eos, doming expetendis incorrupte te per. Te vel quot tibique, sed debet eruditi id. Pri fugit maiorum consequat ad, summo viris ut qui.</p>\r\n\r\n<p>Cu eum aliquid ponderum assentior. Appareat delicata qui at, cum ne idque iudico suavitate, vide neglegentur signiferumque ea pri. Pro quem efficiendi id, rebum tamquam per id, id sed choro omnes mandamus. Ei quod eros pericula pro, ludus scripta honestatis vel in, te his facete persius perfecto. Cu vis pertinacia efficiantur signiferumque.</p>\r\n\r\n<p>Ut aliquip impedit mandamus nam. Vim te etiam voluptatum. Ad vel etiam principes. Mea harum labore ut.</p>\r\n\r\n<p>Pro an sale aliquip, qui harum gloriatur ut. Dicat equidem consequat has ad, sed ne nostrum fastidii percipit. Fabellas ullamcorper his ut, ex elit simul has. Cu nam omnis nominavi appellantur, quo eu sale everti assueverit, in vix suas possim meliore. Noster melius concludaturque vix ei, id odio putant lucilius quo. Ut vix scripta necessitatibus, an dicat assueverit eam.</p>\r\n\r\n<p>Ius solet detracto nominavi in, nec ne zril salutatus prodesset, sint graeco ad mei. Zril iriure qualisque eos ei, nec in dolor vulputate pertinacia, ex liber numquam persecuti eam. Quo ponderum democritum te, tritani sensibus abhorreant no eam, prodesset posidonium ne nec. Sit propriae consetetur dissentiunt id, sale adversarium conclusionemque et eam. Per nemore albucius in, accommodare concludaturque ea sit. Dolore ignota ullamcorper nec ex, vero quando nec an.</p>\r\n', 'Y', NULL, '', '', 0, 6, 3, '', NULL, NULL, '0', '0'),
(21, 'Services', '<p>Lorem ipsum dolor sit amet, deserunt pericula sea ut, ei sed oratio dolores. Aeque nullam at ius, no quo nobis audire instructior. Paulo bonorum conceptam ne mea, ad sumo mandamus expetendis eos, doming expetendis incorrupte te per. Te vel quot tibique, sed debet eruditi id. Pri fugit maiorum consequat ad, summo viris ut qui.</p>\r\n\r\n<p>Cu eum aliquid ponderum assentior. Appareat delicata qui at, cum ne idque iudico suavitate, vide neglegentur signiferumque ea pri. Pro quem efficiendi id, rebum tamquam per id, id sed choro omnes mandamus. Ei quod eros pericula pro, ludus scripta honestatis vel in, te his facete persius perfecto. Cu vis pertinacia efficiantur signiferumque.</p>\r\n\r\n<p>Ut aliquip impedit mandamus nam. Vim te etiam voluptatum. Ad vel etiam principes. Mea harum labore ut.</p>\r\n\r\n<p>Pro an sale aliquip, qui harum gloriatur ut. Dicat equidem consequat has ad, sed ne nostrum fastidii percipit. Fabellas ullamcorper his ut, ex elit simul has. Cu nam omnis nominavi appellantur, quo eu sale everti assueverit, in vix suas possim meliore. Noster melius concludaturque vix ei, id odio putant lucilius quo. Ut vix scripta necessitatibus, an dicat assueverit eam.</p>\r\n\r\n<p>Ius solet detracto nominavi in, nec ne zril salutatus prodesset, sint graeco ad mei. Zril iriure qualisque eos ei, nec in dolor vulputate pertinacia, ex liber numquam persecuti eam. Quo ponderum democritum te, tritani sensibus abhorreant no eam, prodesset posidonium ne nec. Sit propriae consetetur dissentiunt id, sale adversarium conclusionemque et eam. Per nemore albucius in, accommodare concludaturque ea sit. Dolore ignota ullamcorper nec ex, vero quando nec an.</p>\r\n', 'Y', NULL, '', '', 0, 6, 4, '', NULL, NULL, '0', '0'),
(23, 'All Destination', '', 'Y', NULL, 'all-destination.php', '', 0, 0, 8, '', NULL, NULL, '1', '1'),
(26, 'Terms & Conditions', '<p>test</p>\r\n', 'Y', NULL, '', '', 0, 0, 1, '', NULL, NULL, '0', '1'),
(27, 'Privacy Policy', '<p>Empire Hotel, Kolkata, offers a fine combination of prompt service and cordial hospitality to pacify the guests and elevate their comfort level. In addition, flavorsome meals from the in-house restaurant and comfortable rooms ensure a restful stay to the business and leisure travelers.</p>\r\n', 'Y', NULL, '', '', 0, 0, 7, '', NULL, NULL, '0', '1'),
(28, 'User Agreement', '<p>Empire Hotel, Kolkata, offers a fine combination of prompt service and cordial hospitality to pacify the guests and elevate their comfort level. In addition, flavorsome meals from the in-house restaurant and comfortable rooms ensure a restful stay to the business and leisure travelers.</p>\r\n', 'Y', NULL, '', '', 0, 0, 7, '', NULL, NULL, '0', '1');
");


		mysql_query("drop table if exists `bsi_hotel_extras`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_hotel_extras` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `service_name` varchar(255) NOT NULL,
					  `service_price` decimal(10,2) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
					
		mysql_query("drop table if exists `bsi_hotel_offer`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_hotel_offer` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `hotel_id` int(11) NOT NULL,
					  `offer_name` varchar(255) NOT NULL,
					  `start_dt` date NOT NULL,
					  `end_dt` date NOT NULL,
					  `minimum_nights` int(11) NOT NULL,
					  `discount_percent` int(3) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
					
		
		mysql_query("drop table if exists `bsi_user_access`");
		
		mysql_query("CREATE TABLE IF NOT EXISTS `bsi_user_access` (
					  `access_id` int(11) NOT NULL AUTO_INCREMENT,
					  `user_id` int(11) NOT NULL,
					  `menu_id` int(11) NOT NULL,
					  PRIMARY KEY (`access_id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
					
		mysql_query("INSERT INTO `bsi_user_access` (`access_id`, `user_id`, `menu_id`) VALUES
					(1, 1, 1),
					(2, 1, 2),
					(3, 1, 3),
					(4, 1, 4),
					(5, 1, 5),
					(6, 1, 6),
					(7, 1, 7),
					(8, 1, 9),
					(9, 1, 13),
					(10, 1, 14),
					(11, 1, 15),
					(12, 1, 16),
					(13, 1, 17),
					(14, 1, 18),
					(15, 1, 19),
					(16, 1, 20),
					(17, 1, 21),
					(18, 1, 23),
					(19, 1, 24),
					(21, 1, 26),
					(22, 1, 27),
					(23, 1, 29),
					(53, 1, 46),
					(25, 1, 32),
					(26, 1, 33),
					(27, 1, 34),
					(28, 1, 35),
					(29, 1, 36),
					(30, 1, 37),
					(31, 1, 38),
					(32, 1, 39),
					(33, 1, 40),
					(48, 1, 41),
					(49, 1, 42),
					(50, 1, 43),
					(51, 1, 44),
					(52, 1, 45),
					(71, 1, 47),
					(72, 1, 48),
					(73, 1, 49),
					(74, 1, 31),
					(75, 1, 52),
					(76, 2, 1),
					(77, 2, 2),
					(78, 2, 41),
					(79, 2, 3),
					(80, 2, 4),
					(81, 2, 5),
					(82, 2, 6),
					(83, 2, 7),
					(84, 2, 9),
					(85, 2, 13),
					(86, 2, 14),
					(87, 2, 15),
					(88, 2, 35),
					(89, 2, 17),
					(90, 2, 18),
					(91, 2, 37),
					(92, 2, 42),
					(93, 2, 43),
					(94, 2, 16),
					(95, 2, 31),
					(96, 2, 52),
					(97, 2, 25),
					(98, 2, 27),
					(99, 2, 29),
					(100, 2, 24),
					(101, 2, 44),
					(102, 2, 45),
					(103, 2, 49),
					(104, 2, 26),
					(105, 2, 36),
					(106, 2, 20),
					(107, 2, 32),
					(108, 2, 40),
					(109, 2, 38),
					(110, 2, 23),
					(111, 2, 21),
					(112, 2, 19),
					(113, 2, 46),
					(114, 2, 39), 
					(115, 2, 47),
					(116, 2, 48),
					(117, 2, 22),
					(118, 1, 53),
					(119, 1, 54),
					(120, 1, 55),
					(121, 1, 56),				
					(122, 1, 57),
					(123, 1, 58);");	 	
	 }	
}

?>
 