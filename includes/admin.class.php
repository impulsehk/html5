<?php
	$bsiAdminMain = new bsiAdminCore; 
	
	class bsiAdminCore
	{
		
	public function global_setting(){ 
	global $bsiCore;
	$global_selects=array();
	//date format start
	$dt_format_array=array("mm/dd/yy","dd/mm/yy","mm-dd-yy","dd-mm-yy","mm.dd.yy","dd.mm.yy","yy-mm-dd");
	$select_dt_format="";
	for($p=0; $p<7; $p++){
	if($dt_format_array[$p]==$bsiCore->config['conf_dateformat'])
	$select_dt_format.='<option value="'.$dt_format_array[$p].'" selected="selected">'.strtoupper($dt_format_array[$p]).'</option>';
	else
	$select_dt_format.='<option value="'.$dt_format_array[$p].'" >'.strtoupper($dt_format_array[$p]).'</option>';
	}
	$global_selects['select_dt_format']=$select_dt_format;     
	//date format end
	  
	//room lock start
	$room_lock = array(
	        '200' => '2 Minute',
			'500' => '5 Minute',
			'1000' => '10 Minute',
			'2000' => '20 Minute',
			'3000' => '30 Minute');
			
	$select_room_lock="";
	foreach($room_lock as $key => $value) {
	    if($key==$bsiCore->config['conf_booking_exptime'])
		$select_room_lock.='		<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
		else
		$select_room_lock.='		<option value="' . $key . '">' . $value . '</option>' . "\n";
	}
	$global_selects['select_room_lock']=$select_room_lock;
	//room lock end
	$theme_color = array(
	        'none' => 'Default',
			'orange' => 'Orange',
			'pink' => 'Pink',
			'red' => 'Red',
			'blue' => 'Blue',
			'brown' => 'Brown',
			'cyan' => 'Cyan',
			'purple' => 'Purple');
	$select_theme_color="";
	foreach($theme_color as $key => $value) {
	    if($key==$bsiCore->config['conf_theme_color'])
		$select_theme_color.='		<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
		else
		$select_theme_color.='		<option value="' . $key . '">' . $value . '</option>' . "\n";
	}
	$global_selects['select_theme_color']=$select_theme_color;
	
	//timezone_start
	$zonelist = array('Kwajalein' => '(GMT-12:00) International Date Line West',
			'Pacific/Midway' => '(GMT-11:00) Midway Island',
			'Pacific/Samoa' => '(GMT-11:00) Samoa',
			'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
			'America/Anchorage' => '(GMT-09:00) Alaska',
			'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
			'America/Tijuana' => '(GMT-08:00) Tijuana, Baja California',
			'America/Denver' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
			'America/Chihuahua' => '(GMT-07:00) Chihuahua',
			'America/Mazatlan' => '(GMT-07:00) Mazatlan',
			'America/Phoenix' => '(GMT-07:00) Arizona',
			'America/Regina' => '(GMT-06:00) Saskatchewan',
			'America/Tegucigalpa' => '(GMT-06:00) Central America',
			'America/Chicago' => '(GMT-06:00) Central Time (US &amp; Canada)',
			'America/Mexico_City' => '(GMT-06:00) Mexico City',
			'America/Monterrey' => '(GMT-06:00) Monterrey',
			'America/New_York' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
			'America/Bogota' => '(GMT-05:00) Bogota',
			'America/Lima' => '(GMT-05:00) Lima',
			'America/Rio_Branco' => '(GMT-05:00) Rio Branco',
			'America/Indiana/Indianapolis' => '(GMT-05:00) Indiana (East)',
			'America/Caracas' => '(GMT-04:30) Caracas',
			'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
			'America/Manaus' => '(GMT-04:00) Manaus',
			'America/Santiago' => '(GMT-04:00) Santiago',
			'America/La_Paz' => '(GMT-04:00) La Paz',
			'America/St_Johns' => '(GMT-03:30) Newfoundland',
			'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
			'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
			'America/Godthab' => '(GMT-03:00) Greenland',
			'America/Montevideo' => '(GMT-03:00) Montevideo',
			'Atlantic/South_Georgia' => '(GMT-02:00) Mid-Atlantic',
			'Atlantic/Azores' => '(GMT-01:00) Azores',
			'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
			'Europe/Dublin' => '(GMT) Dublin',
			'Europe/Lisbon' => '(GMT) Lisbon',
			'Europe/London' => '(GMT) London',
			'Africa/Monrovia' => '(GMT) Monrovia',
			'Atlantic/Reykjavik' => '(GMT) Reykjavik',
			'Africa/Casablanca' => '(GMT) Casablanca',
			'Europe/Belgrade' => '(GMT+01:00) Belgrade',
			'Europe/Bratislava' => '(GMT+01:00) Bratislava',
			'Europe/Budapest' => '(GMT+01:00) Budapest',
			'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
			'Europe/Prague' => '(GMT+01:00) Prague',
			'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
			'Europe/Skopje' => '(GMT+01:00) Skopje',
			'Europe/Warsaw' => '(GMT+01:00) Warsaw',
			'Europe/Zagreb' => '(GMT+01:00) Zagreb',
			'Europe/Brussels' => '(GMT+01:00) Brussels',
			'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
			'Europe/Madrid' => '(GMT+01:00) Madrid',
			'Europe/Paris' => '(GMT+01:00) Paris',
			'Africa/Algiers' => '(GMT+01:00) West Central Africa',
			'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
			'Europe/Berlin' => '(GMT+01:00) Berlin',
			'Europe/Rome' => '(GMT+01:00) Rome',
			'Europe/Stockholm' => '(GMT+01:00) Stockholm',
			'Europe/Vienna' => '(GMT+01:00) Vienna',
			'Europe/Minsk' => '(GMT+02:00) Minsk',
			'Africa/Cairo' => '(GMT+02:00) Cairo',
			'Europe/Helsinki' => '(GMT+02:00) Helsinki',
			'Europe/Riga' => '(GMT+02:00) Riga',
			'Europe/Sofia' => '(GMT+02:00) Sofia',
			'Europe/Tallinn' => '(GMT+02:00) Tallinn',
			'Europe/Vilnius' => '(GMT+02:00) Vilnius',
			'Europe/Athens' => '(GMT+02:00) Athens',
			'Europe/Bucharest' => '(GMT+02:00) Bucharest',
			'Europe/Istanbul' => '(GMT+02:00) Istanbul',
			'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
			'Asia/Amman' => '(GMT+02:00) Amman',
			'Asia/Beirut' => '(GMT+02:00) Beirut',
			'Africa/Windhoek' => '(GMT+02:00) Windhoek',
			'Africa/Harare' => '(GMT+02:00) Harare',
			'Asia/Kuwait' => '(GMT+03:00) Kuwait',
			'Asia/Riyadh' => '(GMT+03:00) Riyadh',
			'Asia/Baghdad' => '(GMT+03:00) Baghdad',
			'Africa/Nairobi' => '(GMT+03:00) Nairobi',
			'Asia/Tbilisi' => '(GMT+03:00) Tbilisi',
			'Europe/Moscow' => '(GMT+03:00) Moscow',
			'Europe/Volgograd' => '(GMT+03:00) Volgograd',
			'Asia/Tehran' => '(GMT+03:30) Tehran',
			'Asia/Muscat' => '(GMT+04:00) Muscat',
			'Asia/Baku' => '(GMT+04:00) Baku',
			'Asia/Yerevan' => '(GMT+04:00) Yerevan',
			'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
			'Asia/Karachi' => '(GMT+05:00) Karachi',
			'Asia/Tashkent' => '(GMT+05:00) Tashkent',
			'Asia/Calcutta' => '(GMT+05:30) Calcutta',
			'Asia/Colombo' => '(GMT+05:30) Sri Jayawardenepura',
			'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
			'Asia/Dhaka' => '(GMT+06:00) Dhaka',
			'Asia/Almaty' => '(GMT+06:00) Almaty',
			'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
			'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
			'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
			'Asia/Bangkok' => '(GMT+07:00) Bangkok',
			'Asia/Jakarta' => '(GMT+07:00) Jakarta',
			'Asia/Brunei' => '(GMT+08:00) Beijing',
			'Asia/Chongqing' => '(GMT+08:00) Chongqing',
			'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
			'Asia/Urumqi' => '(GMT+08:00) Urumqi',
			'Asia/Irkutsk' => '(GMT+08:00) Irkutsk',
			'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
			'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
			'Asia/Singapore' => '(GMT+08:00) Singapore',
			'Asia/Taipei' => '(GMT+08:00) Taipei',
			'Australia/Perth' => '(GMT+08:00) Perth',
			'Asia/Seoul' => '(GMT+09:00) Seoul',
			'Asia/Tokyo' => '(GMT+09:00) Tokyo',
			'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
			'Australia/Darwin' => '(GMT+09:30) Darwin',
			'Australia/Adelaide' => '(GMT+09:30) Adelaide',
			'Australia/Canberra' => '(GMT+10:00) Canberra',
			'Australia/Melbourne' => '(GMT+10:00) Melbourne',
			'Australia/Sydney' => '(GMT+10:00) Sydney',
			'Australia/Brisbane' => '(GMT+10:00) Brisbane',
			'Australia/Hobart' => '(GMT+10:00) Hobart',
			'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
			'Pacific/Guam' => '(GMT+10:00) Guam',
			'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
			'Asia/Magadan' => '(GMT+11:00) Magadan',
			'Pacific/Fiji' => '(GMT+12:00) Fiji',
			'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
			'Pacific/Auckland' => '(GMT+12:00) Auckland',
			'Pacific/Tongatapu' => '(GMT+13:00) Nukualofa');
			
	$select_timezone="";
	foreach($zonelist as $key => $value) {
	    if($key==$bsiCore->config['conf_portal_timezone'])
		$select_timezone.='		<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
		else
		$select_timezone.='		<option value="' . $key . '">' . $value . '</option>' . "\n";
	}
     $global_selects['select_timezone']=$select_timezone;
	 
	 if($bsiCore->config['conf_booking_turn_off']==0){
		 $select_booking_turn='		<option value="0" selected="selected">Turn On</option>' . "\n";
		 $select_booking_turn.='		<option value="1">Turn Off</option>' . "\n";
	 }else{
		 $select_booking_turn='		<option value="1" selected="selected">Turn Off</option>' . "\n";
		 $select_booking_turn.='		<option value="0">Turn On</option>' . "\n";
	 }
	 $global_selects['select_booking_turn']=$select_booking_turn;
	 
	 $select_min_booking="";
	 for($k=1; $k<11; $k++){
	 	if($bsiCore->config['conf_min_night_booking']==$k){
		$select_min_booking.='		<option value="' . $k . '" selected="selected">' . $k . '</option>' . "\n";
		}else{
		$select_min_booking.='		<option value="' . $k . '">' . $k . '</option>' . "\n";
		}
	 }
	 $global_selects['select_min_booking']=$select_min_booking;
	 
	 return $global_selects;
	} //global setting end
	
	
	//global setting post function
	public function global_setting_post(){
		global $bsiCore;
		if((isset($_FILES['conf_portal_logo'])) || isset($_FILES['conf_portal_signature']) || isset($_FILES['conf_pdf_logo']) || isset($_FILES['conf_mail_logo']) ){
			
			$enable_thumbnails	= 1 ;
			$max_image_size		= 1024000 ;
			$upload_dir			= "../gallery/portal/";
	
			foreach($_FILES as $k => $v){ 	
				$img_type = "";
				if( $_FILES[$k]['error']==0 && $_FILES[$k]['size'] < $max_image_size ){
					$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
					$img_rname = time().'_'.$_FILES[$k]['name'];
					$img_path = $upload_dir.$img_rname;
					copy( $_FILES[$k]['tmp_name'], $img_path ); 
					$imginfo = getimagesize($img_path);
					$aspectRatio = $imginfo[0] / $imginfo[1];
					$newWidth = (int)($aspectRatio * 50);
					
					if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,$newWidth,50);
					if($k == "conf_portal_logo"){
						if(file_exists("../gallery/portal/".$_POST['portal_logo'])){
							unlink("../gallery/portal/".$_POST['portal_logo']);
							unlink("../gallery/portal/thumb_".$_POST['portal_logo']);
						}
					}
					if($k == "conf_portal_signature"){
						if(file_exists("../gallery/portal/".$_POST['portal_sig'])){
							unlink("../gallery/portal/".$_POST['portal_sig']);
							unlink("../gallery/portal/thumb_".$_POST['portal_sig']);
						}	
					}
					
					
					if($k == "conf_pdf_logo"){
						if(file_exists("../gallery/portal/".$_POST['pdf_logo'])){
							unlink("../gallery/portal/".$_POST['pdf_logo']);
							unlink("../gallery/portal/thumb_".$_POST['pdf_logo']);
						}	
					}
					
					if($k == "conf_mail_logo"){
						if(file_exists("../gallery/portal/".$_POST['mail_logo'])){
							unlink("../gallery/portal/".$_POST['mail_logo']);
							unlink("../gallery/portal/thumb_".$_POST['mail_logo']);
						}	
					}
					
					
					$this->configure_update($k, $img_rname);
				}
			}	
		}
		$this->configure_update('conf_portal_name', $bsiCore->ClearInput($_POST['portal_name']));
		$this->configure_update('conf_portal_streetaddr', $bsiCore->ClearInput($_POST['str_addr']));
		$this->configure_update('conf_portal_city', $bsiCore->ClearInput($_POST['city']));
		$this->configure_update('conf_portal_state', $bsiCore->ClearInput($_POST['state']));
		$this->configure_update('conf_portal_country', $bsiCore->ClearInput($_POST['country']));
		$this->configure_update('conf_portal_zipcode', $bsiCore->ClearInput($_POST['zipcode']));
		$this->configure_update('conf_portal_phone', $bsiCore->ClearInput($_POST['phone']));
		$this->configure_update('conf_portal_fax', $bsiCore->ClearInput($_POST['fax']));
		$this->configure_update('conf_portal_email', $bsiCore->ClearInput($_POST['email']));
		
		$this->configure_update('conf_portal_sitetitle', $bsiCore->ClearInput($_POST['title']));
		$this->configure_update('conf_portal_sitedesc', $bsiCore->ClearInput($_POST['desc']));
		$this->configure_update('conf_portal_sitekeywords', $bsiCore->ClearInput($_POST['keywords']));
		$this->configure_update('conf-google-ads', $bsiCore->ClearInput($_POST['sponsored_ads']));
		
		$this->configure_update('conf_portal_twitter_link', $bsiCore->ClearInput($_POST['twitter']));
		$this->configure_update('conf_portal_facebook_link', $bsiCore->ClearInput($_POST['facebook']));
		$this->configure_update('conf_portal_linkedin_link', $bsiCore->ClearInput($_POST['linkedin']));
		$this->configure_update('conf_portal_pinterest_link', $bsiCore->ClearInput($_POST['pinterest']));
		$this->configure_update('conf_portal_googleplus_link', $bsiCore->ClearInput($_POST['googleplus']));
		
		$this->configure_update('conf_currency_symbol', $bsiCore->ClearInput($_POST['currency_symbol'])); 	
		$this->configure_update('conf_currency_code', $bsiCore->ClearInput($_POST['currency_code']));
		$this->configure_update('conf_smtp_mail', $bsiCore->ClearInput($_POST['email_send_by']));
		$this->configure_update('conf_smtp_host', $bsiCore->ClearInput($_POST['smtphost']));
		$this->configure_update('conf_smtp_port', $bsiCore->ClearInput($_POST['smtpport']));
		$this->configure_update('conf_smtp_username', $bsiCore->ClearInput($_POST['smtpuser']));
		$this->configure_update('conf_smtp_password', $bsiCore->ClearInput($_POST['smtppass']));
		$this->configure_update('conf_tax_amount', $bsiCore->ClearInput($_POST['tax']));
		$this->configure_update('conf_theme_color', $bsiCore->ClearInput($_POST['theme_color']));
		if(isset($_POST['agent_hotel'])){
			$this->configure_update('conf_agent_hotel', $bsiCore->ClearInput($_POST['agent_hotel']));
		}else{
			$this->configure_update('conf_agent_hotel', 0);
		}
		$this->configure_update('conf_dateformat', $_POST['date_format']);
		$this->configure_update('conf_booking_exptime', $bsiCore->ClearInput($_POST['room_lock']));
		$this->configure_update('conf_portal_timezone', $bsiCore->ClearInput($_POST['timezone']));
		$this->configure_update('conf_server_os', $bsiCore->ClearInput($_POST['server_os']));
		$this->configure_update('conf_booking_turn_off', $bsiCore->ClearInput($_POST['booking_turn']));
		$this->configure_update('conf_min_night_booking', $bsiCore->ClearInput($_POST['minbooking']));
		$this->configure_update('conf_bookingid_prefix', $bsiCore->ClearInput($_POST['bpfix']));
		$this->configure_update('destination_search_type', $bsiCore->ClearInput($_POST['destination_search_type']));
		$this->configure_update('conf_payment_commission', $bsiCore->ClearInput($_POST['conf_payment_commission']));
		if($bsiCore->ClearInput($_POST['hotel_price_listing'])){
			mysql_query("UPDATE bsi_hotelmenu bh1
						 LEFT JOIN
								 bsi_hotelmenu bh2
						 ON      bh1.id = bh2.parent_id
						 SET     bh1.status = 'Y', bh2.status = 'Y'
						 WHERE   bh1.id=19");
		}else{
			mysql_query("UPDATE bsi_hotelmenu bh1
						 LEFT JOIN
								 bsi_hotelmenu bh2
						 ON      bh1.id = bh2.parent_id
						 SET     bh1.status = 'N', bh2.status = 'N'
						 WHERE   bh1.id=19");
		}
		$this->configure_update('hotel_price_listing', $bsiCore->ClearInput($_POST['hotel_price_listing'])); 
	}
	
	private function configure_update($key, $value){
		mysql_query("update bsi_configure set conf_value='".$value."' where conf_key='".$key."'");
	}
	
	//Hotel data entry
	public function hotel_addedit_entry($front=false){
		global $bsiCore;
		$hotel_id			= mysql_real_escape_string($_POST['hotel_id']);
		$password           = 0;
		if(isset($_POST['password']) && $_POST['password'] != "" || $_POST['password'] != NULL){$password = md5(mysql_real_escape_string($_POST['password']));}
		$pre_img 			= $bsiCore->ClearInput($_POST['pre_img']);
		$row_country_name	= $bsiCore->getCountryName($_POST['country_code']);
		
		if($_POST['latitude']>0 &&$_POST['longitude']>0){	
		$lat=mysql_real_escape_string($_POST['latitude']);
		$long=mysql_real_escape_string($_POST['longitude']);
		}else{
		$address = "";
		$address .= mysql_real_escape_string($_POST['address_1'])." ";
		$address .= mysql_real_escape_string($_POST['city_name'])." ";
		$address .= mysql_real_escape_string($_POST['post_code'])." ";
		$address .= $row_country_name; 	
		$address3 = urlencode($address);
		$url = "http://maps.google.com/maps/api/geocode/json?address=$address3&sensor=false";
		if (!function_exists('curl_init')){
    		die('Sorry cURL is not installed!');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_REFERER, $_SERVER['PHP_SELF']);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response);
				
		$lat        = $response_a->results[0]->geometry->location->lat;
		$long       = $response_a->results[0]->geometry->location->lng;
		}
		//echo "||latitute : ".$lat;
		//echo "||Longitute :".$long;die;
		$enable_thumbnails	= 1 ; // set 0 to disable thumbnail creation
		$max_image_size		= 1024000 ; // max image size in bytes, default 1MB
		
		if($front){
			$upload_dir			= "gallery/hotelImage/"; // default script location, use relative or absolute path
		}else{
			$upload_dir			= "../gallery/hotelImage/"; // default script location, use relative or absolute path
		}
		//$img_rname ="";
		if($hotel_id){
			if($password){
				$password=$password;
			}else{
				$password=$bsiCore->ClearInput($_POST['pre_pass']);
			}
							
			$enable_thumbnails	= 1 ;
			$max_image_size		= 1024000 ;
			if($front){
				$upload_dir			= "gallery/hotelImage/"; // default script location, use relative or absolute path
			}else{
				$upload_dir			= "../gallery/hotelImage/"; // default script location, use relative or absolute path
			}
			$img_rname = "";
			foreach($_FILES as $k => $v){ 	
				$img_type = "";
				if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
					$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
					$img_rname = time().'_'.$_FILES[$k]['name'];
					$img_path = $upload_dir.$img_rname;
					copy( $_FILES[$k]['tmp_name'], $img_path ); 
					if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,96,96);
					
					$delrow = mysql_fetch_assoc(mysql_query("select * from bsi_hotels where hotel_id=$hotel_id"));
					if(isset($delrow['default_img'])){
						if(file_exists("../gallery/hotelImage/".$delrow['default_img'])){
							unlink("../gallery/hotelImage/".$delrow['default_img']);
							unlink("../gallery/hotelImage/thumb_".$delrow['default_img']);
						}
					}
				}else{
					$img_rname = $pre_img;
				}
			}
			
			//echo "arup";die;	
			
			mysql_query("UPDATE `bsi_hotels` SET `hotel_name` = '".mysql_real_escape_string($_POST['hotel_name'])."',`address_1` = '".mysql_real_escape_string($_POST['address_1'])."',`address_2` = '".mysql_real_escape_string($_POST['address_2'])."',
`city_name` = '".mysql_real_escape_string($_POST['city_name'])."',`state` = '".mysql_real_escape_string($_POST['state'])."',`post_code` = '".mysql_real_escape_string($_POST['post_code'])."',`country_code`= '".mysql_real_escape_string($_POST['country_code'])."',`email_addr` = '".mysql_real_escape_string($_POST['email_addr'])."',`phone_number` = '".$bsiCore->ClearInput($_POST['phone_number'])."',`fax_number` = '".$bsiCore->ClearInput($_POST['fax_number'])."',`desc_short` = '".mysql_real_escape_string($_POST['desc_short'])."',`desc_long` = '".$_POST['desc_long']."',`checking_hour` = '".$bsiCore->ClearInput($_POST['checking_hour'])."',`checkout_hour` = '".$bsiCore->ClearInput($_POST['checkout_hour'])."',`pets_status` = '".$bsiCore->ClearInput($_POST['pets_status'])."',`latitude` = '".$lat."',`longitude` = '".$long."',`terms_n_cond` = '".mysql_real_escape_string($_POST['terms_n_cond'])."',`status` = '".$bsiCore->ClearInput($_POST['status'])."',password = '".$password."',default_img='".$img_rname."',star_rating = '".$bsiCore->ClearInput($_POST['star_rating'])."',hotel_policies ='".$_POST['hotel_policies']."' ,  customer_notes='".$_POST['customer_notes']."' WHERE `hotel_id` ='".$hotel_id."'") or die("Error at line : 360".mysql_error());
		}else{
			$enable_thumbnails	= 1 ;
			$max_image_size		= 1024000 ;
			if($front){
				$upload_dir			= "gallery/hotelImage/"; // default script location, use relative or absolute path
			}else{
				$upload_dir			= "../gallery/hotelImage/"; // default script location, use relative or absolute path
			}
			$img_rname = "";
			foreach($_FILES as $k => $v){ 	
				$img_type = "";
				if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
					$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
					$img_rname = time().'_'.$_FILES[$k]['name'];
					$img_path = $upload_dir.$img_rname;
					copy( $_FILES[$k]['tmp_name'], $img_path ); 
					if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,96,96);
				}else{
					$img_rname = "";
				}
			}	
		
					
		mysql_query("INSERT INTO `bsi_hotels` ( `hotel_name`, `address_1`, `address_2`, `city_name`, `state`, `post_code`, `country_code`, `email_addr`, `phone_number`, `fax_number`, `desc_short`, `desc_long`, `checking_hour`, `checkout_hour`, `pets_status`, `latitude`, `longitude`, `terms_n_cond`, `status`, `password`,`star_rating`,`default_img`,`hotel_policies`,`customer_notes`) VALUES ( '".mysql_real_escape_string($_POST['hotel_name'])."', '".mysql_real_escape_string($_POST['address_1'])."', '".mysql_real_escape_string($_POST['address_2'])."', '".mysql_real_escape_string($_POST['city_name'])."', '".mysql_real_escape_string($_POST['state'])."', '".$bsiCore->ClearInput($_POST['post_code'])."', '".$bsiCore->ClearInput($_POST['country_code'])."', '".mysql_real_escape_string($_POST['email_addr'])."', '".$bsiCore->ClearInput($_POST['phone_number'])."', '".$bsiCore->ClearInput($_POST['fax_number'])."', '".mysql_real_escape_string($_POST['desc_short'])."', '".mysql_real_escape_string($_POST['desc_long'])."', '".$bsiCore->ClearInput($_POST['checking_hour'])."', '".$bsiCore->ClearInput($_POST['checkout_hour'])."', '".$bsiCore->ClearInput($_POST['pets_status'])."', '$lat', '$long', '".mysql_real_escape_string($_POST['terms_n_cond'])."', '".$bsiCore->ClearInput($_POST['status'])."', '".$password."','".$bsiCore->ClearInput($_POST['star_rating'])."','".$img_rname."','".$_POST['hotel_policies']."','".$_POST['customer_notes']."')");
		
		
			
			global $bsimail;
			
			$host_info = pathinfo($_SERVER["PHP_SELF"]);		
		    $bsiHostPath = "http://".$_SERVER['HTTP_HOST'].substr($host_info['dirname'], 0, strrpos($host_info['dirname'], '/'))."/";
			$url=$bsiHostPath."hotel/index.php";
			
			$emailSub        ="Your Hotel Control Panel Account";
			
			$emailBody       = "Dear ".$_POST['email_addr'].",<br><br>";
			
			$emailBody      .= "Your login information is: <br><br>" .
			                    "Log In URL: ".$url."<br>".
								"Email ID: " . $_POST['email_addr'] . "<br>" .
								"Password: " . $_POST['password'] . "<br><br>" ."Thanking You.";	
		
			$returnMsg =$bsimail->sendEMailHotelEntry(mysql_real_escape_string($_POST['email_addr']), $emailSub, $emailBody);	
			//$bsimail->sendEMailHotelEntry(mysql_real_escape_string($_POST['email_addr']), $emailSub, $emailBody);				
		$id=mysql_insert_id();
		if(isset($_POST['agent_id'])){
			mysql_query("insert into bsi_agent_entry_hotel (agent_id, hotel_id) values ('".$bsiCore->ClearInput($_POST['agent_id'])."', '".$id."')");
			//echo "sasmal";die;
			
			
		  }
		}
	}
		
	public function hotel_delete(){
  global $bsiCore;
 $delid=$bsiCore->ClearInput($_REQUEST['delid']);
  $row = mysql_fetch_assoc(mysql_query("select * from bsi_hotels where hotel_id=$delid"));
  $result = mysql_query("select * from bsi_gallery where hotel_id=$delid");
  $num = mysql_num_rows($result);
  if($num){
   $row2= mysql_fetch_assoc($result);
   if($row2['img_path'] != "" || $row2['img_path'] != NULL){
  if(file_exists("../gallery/hotelImage/".$row2['img_path']) && file_exists("../gallery/hotelImage/thumb_".$row2['img_path'])){
    unlink("../gallery/hotelImage/".$row2['img_path']);
    unlink("../gallery/hotelImage/thumb_".$row2['img_path']);
  }
   }
  } 
  if($row['default_img'] != "" || $row['default_img'] != NULL){
if(file_exists("../gallery/hotelImage/".$row['default_img']) && file_exists("../gallery/hotelImage/thumb_".$row['default_img'])){
   unlink("../gallery/hotelImage/".$row['default_img']);
   unlink("../gallery/hotelImage/thumb_".$row['default_img']);
}
  }
  
  $resqrry=mysql_query("SELECT * FROM `bsi_agent_entry_hotel` WHERE `hotel_id`=".$delid);
  if(mysql_num_rows($resqrry)){
   $rr=mysql_fetch_assoc($resqrry);
   mysql_query("delete from `bsi_agent_entry_hotel` where `hotel_id`='".$rr['hotel_id']."'");
   }
  mysql_query("delete from `bsi_hotels` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_room` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_priceplan` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_roomtype` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_hotel_review` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_hotel_facilities` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_around_hotel` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_around_hotel_category` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_capacity` where `hotel_id`=".$delid);
  mysql_query("delete from `bsi_gallery` where `hotel_id`=".$delid);
 }
		//****************************************************
		
		//hotel room entry
		public function hotel_room_entry(){
			global $bsiCore;
			$roomno=$bsiCore->ClearInput($_POST['room_no']);	
			$extrabed1 = (isset($_POST['extrabed'])) ? 'true' : 'false';
			if(isset($_SESSION['hhid'])){
				 $hotel_id = $_SESSION['hhid'];
			}else{
				$hotel_id = $bsiCore->ClearInput($_POST['hotel_id']);
			}
			for($r=1;$r<=$roomno;$r++){
				//echo "INSERT INTO `bsi_room` (`hotel_id` ,`roomtype_id`, `room_no` ,`capacity_id`,`no_of_child`,`extra_bed` )VALUES ('". $hotel_id."', '".$bsiCore->ClearInput($_POST['roomtype_id'])."','1', '".$bsiCore->ClearInput($_POST['capacity_id'])."', '".$bsiCore->ClearInput($_POST['no_of_child'])."',".$extrabed1.")";die;
				mysql_query("INSERT INTO `bsi_room` (`hotel_id` ,`roomtype_id`, `room_no` ,`capacity_id`,`no_of_child`,`extra_bed` )VALUES ('". $hotel_id."', '".$bsiCore->ClearInput($_POST['roomtype_id'])."','1', '".$bsiCore->ClearInput($_POST['capacity_id'])."', '".$bsiCore->ClearInput($_POST['no_of_child'])."',".$extrabed1.")") or die("Error at line : 342".mysql_error());
				
				
				mysql_query("update bsi_room set room_no='".mysql_insert_id()."',extra_bed=$extrabed1 where room_id='".mysql_insert_id()."'"); 
			}
			if(isset($_POST['hotel_id'])){
			$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']);
			}
			header("location:roomList.php");
		}   
		//***************************************************
		
		//country
		public function country($country_code=''){
			$country = '<select name="country_code" id="country_code"><option value="">select country</option>';
			$countrySql = "select * from `bsi_country`";
			$result = mysql_query($countrySql) or die("Error at line : 400".mysql_error());
			while($countryRow=mysql_fetch_assoc($result)){
				if($countryRow['country_code'] == $country_code)
					$country .='<option value="'.$countryRow['country_code'].'" selected="selected">'.$countryRow['name'].'</option>';
				else
					$country .='<option value="'.$countryRow['country_code'].'">'.$countryRow['name'].'</option>';
			}
			$country .= '</select>';
			return $country;
		}
		//*********************************************************
				
		
		//***********************************************************
		
		//room type
		public function roomtypeList($hid, $rt_id){ 
			global $bsiCore;
			$roomtype = "";
			$gethtml='';
			$rearr=array();
			$result = mysql_query("select * from `bsi_roomtype` where hotel_id='".$hid."'");
			while($roomtypelRow=mysql_fetch_assoc($result)){
				if($roomtypelRow['roomtype_id']==$rt_id){
					$roomtype .="<option value='".$roomtypelRow['roomtype_id']."' selected='selected' '>".$roomtypelRow['type_name']."</option>";
				}else{
					$roomtype .="<option value='".$roomtypelRow['roomtype_id']."'>".$roomtypelRow['type_name']."</option>";
				}
			}
			$daterange   = mysql_query("select date_start, date_end, DATE_FORMAT(date_start, '".$bsiCore->userDateFormat."') AS start_date1, DATE_FORMAT(date_end, '".$bsiCore->userDateFormat."') AS end_date1, `default` from bsi_priceplan where room_type_id='".$rt_id."' and hotel_id='$hid' group by date_start, date_end");	
			if(mysql_num_rows($daterange)){	
				$gethtml = "";
				while($row_daterange = mysql_fetch_assoc($daterange)){
					$query = mysql_query("select bp.*, bc.title from bsi_priceplan as bp, bsi_capacity as bc where date_start='".$row_daterange['date_start']."' and date_end='".$row_daterange['date_end']."' and room_type_id='".$rt_id."' and bp.hotel_id='$hid' and bp.capacity_id=bc.capacity_id");
					if($row_daterange['default'] == 1){  
						$gethtml .= '<tr class="gradeX"><td colspan="10"><strong>Regular Price</strong></td></tr>';
						$daletetd = mysql_num_rows($query);	
						$i1       = $daletetd;
						while($row_pp=mysql_fetch_assoc($query)){	
							$gethtml.='<tr class="gradeX"> 
												<td>'.$row_pp['title'].'</td> 									 
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</td> 
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</td>
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['extrabed'].'</td>';  
												
							if($daletetd==$i1){	
								$gethtml .= '<td rowspan="'.$daletetd.'"><a href="pricePlan.php?default_value='.base64_encode($row_pp['default']).'&rtype_id='.base64_encode($row_pp['room_type_id']).'&start_date='.base64_encode($row_pp['date_start']).'&end_date='.base64_encode($row_pp['date_end']).'&hid='.base64_encode($row_pp['hotel_id']).'">Edit</a></td>';
								 $gethtml .= '</tr>';
							}
							$i1--;
						}
					}else{
						$gethtml .= '<tr class="gradeX"><td colspan="9"><strong>Date Range : '.$row_daterange['start_date1'].'&nbsp; To &nbsp;'.$row_daterange['end_date1'].'</strong></td></tr>';
						$daletetd = mysql_num_rows($query);		
					    $i1       = $daletetd;
						while($row_pp=mysql_fetch_assoc($query)){
							$gethtml.='<tr class="gradeX"> 
												<td>'.$row_pp['title'].'</td> 									 
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</td> 
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</td>  
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</td>
												<td>'.$bsiCore->config['conf_currency_symbol'].$row_pp['extrabed'].'</td>';  
												
							if($daletetd==$i1){
							   $pln_del   = base64_encode($row_pp['date_start'].'|'.$row_pp['date_end'].'|'.$row_pp['room_type_id'].'|'.$row_pp['hotel_id']);
							   $gethtml .= '<td rowspan="'.$daletetd.'"><a href="pricePlan.php?rtype_id='.base64_encode($row_pp['room_type_id']).'&start_date='.base64_encode($row_pp['date_start']).'&end_date='.base64_encode($row_pp['date_end']).'&default_value='.base64_encode($row_pp['default']).'&hid='.base64_encode($row_pp['hotel_id']).'">Edit</a>&nbsp;';
							   $gethtml .= '<td rowspan="'.$daletetd.'"><a href="javascript:;" onclick="javascript:priceplan_delete(\''.$pln_del.'\');">Delete</a></td>';
							   $gethtml .= '</tr>';
							}
					   	$i1--;
						}
					}
				}	
			}
			$rearr[0]=$roomtype;
			$rearr[1]=$gethtml;
			return $rearr;
		}
			
		//getroomTypeList
		
   public function 	getroomTypeList($hotelid){
	          global $bsiCore;
			  $roomtype='<option value="0" selected="selected">Select Room Type</option>';
			//$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
			$result = mysql_query("select * from `bsi_roomtype` where hotel_id='".$hotelid."'") or die("Error at line : 103".mysql_error());
			if(mysql_num_rows($result)){
				while($roomtypelRow=mysql_fetch_assoc($result)){
					
						$roomtype .="<option value=".$roomtypelRow['roomtype_id'].">".$roomtypelRow['type_name']."</option>";
					
				}
				//echo json_encode(array("errorcode"=>$errorcode,"roomtype_dowpdown"=>$roomtype));
			}
	   return $roomtype;
   }
		
		//hotel facility enter
		public function hotel_facility_entry(){
			global $bsiCore;
			$id = $bsiCore->ClearInput($_POST['id']);
			if($id){
				mysql_query("update bsi_hotel_facilities set general='".$bsiCore->ClearInput($_POST['general'])."', activities='".$bsiCore->ClearInput($_POST['activities'])."', services='".$bsiCore->ClearInput($_POST['services'])."' where facilities_id='".$bsiCore->ClearInput($_POST['id'])."'");
			}else{
			
			$chkquery=mysql_query("select * from `bsi_hotel_facilities` where hotel_id='".$bsiCore->ClearInput($_POST['hotel_id'])."' ");
			if(mysql_num_rows($chkquery)){
			
			$_SESSION['error_msg']  = "<font color=\"red\">Facility Already Exists. Edit  the facility</font>";
			}else{
			//echo "new";die;
				mysql_query("INSERT INTO `bsi_hotel_facilities` (`hotel_id` ,`general` ,`activities` ,`services`)VALUES ('".$bsiCore->ClearInput($_POST['hotel_id'])."', '".$bsiCore->ClearInput($_POST['general'])."', '".$bsiCore->ClearInput($_POST['activities'])."', '".$bsiCore->ClearInput($_POST['services'])."')");
			}
			}
			
				
		}
		
		
		public function facilty_delete(){  
			global $bsiCore;
			$delid=$bsiCore->ClearInput($_REQUEST['delid']);
			mysql_query("delete from `bsi_hotel_facilities` where `facilities_id`='".$delid."'");
		}
		
		//******************************************************************
		//bsibookingcancel
		public function BookingCancel($bid){
			global $bsiCore;
			mysql_query("update bsi_bookings set is_deleted=1 where booking_id='".$bid."'");
			return true;
		}
		//bsibookingdelete
		public function BookingDelete($bid){
			global $bsiCore;
			mysql_query("DELETE t1, t4 FROM bsi_bookings as t1 INNER JOIN  bsi_clients as t4 on t1.client_id=t4.client_id WHERE  t1.booking_id='".$bid."'");
			return true;
		}
		
		//hoetl capacity entry
		public function hotel_capacity_entry(){
			global $bsiCore;
			$sql = "INSERT INTO `bsi_capacity` (`hotel_id` ,`title` ,`capacity` )VALUES ('".$bsiCore->ClearInput($_POST['hotel_id'])."', '".$bsiCore->ClearInput($_POST['title'])."', '".$bsiCore->ClearInput($_POST['capacity'])."')";
			mysql_query($sql);
		}
		//****************************************************************
		
		//****************************************************************
		
		public function hotel_category_entry(){
			global $bsiCore;
			$category_id=$bsiCore->ClearInput($_POST['category_id']);
			if($category_id){
				mysql_query("update bsi_around_hotel_category set category_title='".mysql_real_escape_string($_POST['category_title'])."' where category_id='".$category_id."'");
				$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']);
			}else{
				mysql_query("INSERT INTO bsi_around_hotel_category (`hotel_id` , `category_title`) VALUES ('".$bsiCore->ClearInput($_POST['hotel_id'])."', '".mysql_real_escape_string($_POST['category_title'])."')");
				$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']);
			}
		}
				
		//hotel room type entry
		public function hotel_roomtype_entry(){
			global $bsiCore;
			$roomtype_id  = $bsiCore->ClearInput($_POST['roomtype_id']);
			$pre_img	  = $bsiCore->ClearInput($_POST['pre_img']);
			$hotel_id     = $bsiCore->ClearInput($_POST['hotel_id']);
			$type_name    = mysql_real_escape_string($_POST['type_name']);
			$type_service = mysql_real_escape_string($_POST['type_service']);
			$roomsize    = mysql_real_escape_string($_POST['roomsize']);
			$bedsize    = mysql_real_escape_string($_POST['bedsize']);
			$roomtype_name    = mysql_real_escape_string($_POST['roomtype_name']);
			
			if($roomtype_id){				
				$enable_thumbnails	= 1;
				$max_image_size		= 1024000 ;
				$upload_dir			= "../gallery/roomTypeImage/"; 
				$img_rname = "";
				foreach($_FILES as $k => $v){ 	
					$img_type = "";
					if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
						$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
						$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
						$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
	
						$img_rname = time().'_'.$_FILES[$k]['name'];
						$img_path = $upload_dir.$img_rname;
	
						copy( $_FILES[$k]['tmp_name'], $img_path ); 
						if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,96,96);
						$row = mysql_fetch_assoc(mysql_query("select * from bsi_roomtype where roomtype_id=$roomtype_id"));
						if($row['rtype_image'] != "" || $row['rtype_image'] != NULL){
							if(file_exists("../gallery/roomTypeImage/".$row['rtype_image'])){
								unlink("../gallery/roomTypeImage/".$row['rtype_image']);
								unlink("../gallery/roomTypeImage/thumb_".$row['rtype_image']);
							}
						}
					}else{
						$img_rname = $pre_img;
					}	
			}
			
			//echo "update bsi_roomtype set hotel_id='".$hotel_id."', type_name='".$type_name."',services='".$type_service."', rtype_image='".$img_rname."'  , roomsize='".$roomsize."' ,bedsize='".$bedsize."' ,roomtype_name='".$roomtype_name."' where roomtype_id='".$roomtype_id."'";die;
			mysql_query("update bsi_roomtype set hotel_id='".$hotel_id."', type_name='".$type_name."',services='".$type_service."', rtype_image='".$img_rname."'  , roomsize='".$roomsize."' ,bedsize='".$bedsize."' ,roomtype_name='".$roomtype_name."' where roomtype_id='".$roomtype_id."'");
			if(isset($_POST['hotel_id'])){
				$_SESSION['hotel_id']=$hotel_id;
			}
			}else{
				$enable_thumbnails	= 1 ;
				$max_image_size		= 1024000 ;
				$upload_dir			= "../gallery/roomTypeImage/";
				$img_rname = "";
				foreach($_FILES as $k => $v){ 	
					$img_type = "";
					if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
						$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
						$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
						$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
	
						$img_rname = time().'_'.$_FILES[$k]['name'];
						$img_path = $upload_dir.$img_rname;
	
						copy( $_FILES[$k]['tmp_name'], $img_path ); 
						if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,96,96);
					}
				}
				mysql_query("insert into bsi_roomtype(hotel_id, type_name, rtype_image, services ,roomsize , bedsize , roomtype_name) values ('".$hotel_id."', '".$type_name."', '".$img_rname."', '".$type_service."' , '".$roomsize."' ,'".$bedsize."' ,'".$roomtype_name."')");
				$roomtypeid = mysql_insert_id();
				$defaultSql = mysql_query("select `date_start`, `date_end`, `capacity_id`, `default` from bsi_priceplan where hotel_id=$hotel_id group by `date_start`, `date_end`, `capacity_id`");
				$num = mysql_num_rows($defaultSql);
				if($num){
					while($row = mysql_fetch_assoc($defaultSql)){
						//mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`,`room_type_id`,`capacity_id`, `date_start`, `date_end`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `extrabed`,`default`) VALUES ('".$hotel_id."', '".$roomtypeid."', '".$row['capacity_id']."', '".$row['date_start']."', '".$row['date_end']."', '0', '0', '0', '0', '0', '0','0', '0' , '".$row['default']."')");
						
						mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`,`room_type_id`,`capacity_id`, `date_start`, `date_end`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default`) VALUES ('".$hotel_id."', '".$roomtypeid."', '".$row['capacity_id']."', '".$row['date_start']."', '".$row['date_end']."', '0', '0', '0', '0', '0', '0','0', '".$row['default']."')");
					}
				}else{
					$capaSql = mysql_query("select * from bsi_capacity where hotel_id=$hotel_id");
					$numc    = mysql_num_rows($capaSql);
					if($numc){
						while($rowc = mysql_fetch_assoc($capaSql)){
							//mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`,`room_type_id`,`capacity_id`,`sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`,`extrabed`, `default`) VALUES ('".$hotel_id."', '".$roomtypeid."', '".$rowc['capacity_id']."', '0', '0', '0', '0', '0', '0','0', '0','1')");
						mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`,`room_type_id`,`capacity_id`,`sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default`) VALUES ('".$hotel_id."', '".$roomtypeid."', '".$rowc['capacity_id']."', '0', '0', '0', '0', '0', '0','0', '1')");		
							
						}
						
						mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`,`room_type_id`,`capacity_id`,`sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default`) VALUES ('".$hotel_id."', '".$roomtypeid."', '1001', '0', '0', '0', '0', '0', '0','0', '1')"); 
					}
				}
				if(isset($_POST['hotel_id'])){ 
					$_SESSION['hotel_id']   = $bsiCore->ClearInput($_POST['hotel_id']);
					$_SESSION['roomtypeid'] = $roomtypeid;
				}
			}
		}
		//************************************************************* 
		private function make_thumbnails($updir, $img, $w, $h){
		    
			$thumbnail_width	= $w;
			$thumbnail_height	= $h;
			$thumb_preword		= "thumb_";
		
			$arr_image_details	= GetImageSize("$updir"."$img");
			$original_width		= $arr_image_details[0];
			$original_height	= $arr_image_details[1];
		
			if( $original_width > $original_height ){
				$new_width	= $thumbnail_width;
				$new_height	= intval($original_height*$new_width/$original_width);
			} else {
				$new_height	= $thumbnail_height;
				$new_width	= intval($original_width*$new_height/$original_height);
			}
		
			$dest_x = intval(($thumbnail_width - $new_width) / 2);
			$dest_y = intval(($thumbnail_height - $new_height) / 2);
		 
		
		
			if($arr_image_details[2]==1) { $imgt = "ImageGIF"; $imgcreatefrom = "ImageCreateFromGIF";  }
			if($arr_image_details[2]==2) { $imgt = "ImageJPEG"; $imgcreatefrom = "ImageCreateFromJPEG";  }
			if($arr_image_details[2]==3) { $imgt = "ImagePNG"; $imgcreatefrom = "ImageCreateFromPNG";  }
		
		
			if( $imgt ) { 
				$old_image	= $imgcreatefrom("$updir"."$img");
				$new_image	= imagecreatetruecolor($thumbnail_width, $thumbnail_height);
				imageCopyResized($new_image,$old_image,0, 0,0,0,$w,$h,$original_width,$original_height);
				$imgt($new_image,"$updir"."$thumb_preword"."$img");
			}
		
		}
		//**************************************************************
		
		public function star_rating($rating){
			$star_rating = '<select name="star_rating" id="star_rating"><option value="">select</option>';
			for($i=1;$i<=5;$i++){
				if($i==$rating)
					$star_rating.='<option value="'.$i.'" selected="selected">'.$i.'</option>';
				else
					$star_rating.='<option value="'.$i.'">'.$i.'</option>';
			}
			$star_rating .= '</select>';
			return $star_rating;
		}
		
		//***************************************************************
		public function pets_status($status){
			$petsallowed = '<select name="pets_status" id="pets_status">';
			if($status == 0){
				$petsallowed.='<option value="0" selected="selected">No</option><option value="1">Yes</option>';
			}else{
				$petsallowed.='<option value="0">No</option><option value="1" selected="selected">Yes</option>';
			}
			$petsallowed .= '</select>';
			return $petsallowed;
		}
		
		//***************************************************************
		public function status($hotel_status){
			if($hotel_status == 0){
				$status='<input type="checkbox" name="status" value="1">';
			}else{
				$status='<input type="checkbox" name="status" value="1" checked="checked">';
			}
			return $status;
		}
		
		// hotel room
		public function hotelroom()
		{
			$room = "";
			$room .= "<option value='0'>Select Room Type</option>";
			$roomSql = "select * from `bsi_roomtype`";
			$result = mysql_query($roomSql) or die("Error at line : 149 ".mysql_error());
			while($roomRow=mysql_fetch_array($result))
			{
				$room .="<option value=".$roomRow['roomtype_ID'].">".$roomRow['type_name']."</option>";
			}
			
			return $room;
		}
		
		//*****************************************************************
		
		//hotel room capacity
		public function hotel_room_capacity()
		{
			$capacity = "";
			$capacity .= "<option value=''>Select Capacity</option>";
			$capacitySql = "select * from `bsi_capacity`";
			$result = mysql_query($capacitySql) or die("Error at line : 163 ".mysql_error());
			while($capacityRow=mysql_fetch_array($result))
			{
				$capacity .="<option value=".$capacityRow['capacity_id'].">".$capacityRow['capacity']." (".$capacityRow['title'].")</option>";
			}
			
			return $capacity;
		}
		
		public function gethotel_room_capacity($hid)
		{
			$capacity = "";
			$capacity .= "<option value=''>Select Capacity</option>";
			$capacitySql = "select * from `bsi_capacity` where hotel_id=".$hid;
			$result = mysql_query($capacitySql) or die("Error at line : 163 ".mysql_error());
			while($capacityRow=mysql_fetch_array($result))
			{
				$capacity .="<option value=".$capacityRow['capacity_id'].">".$capacityRow['title']." (".$capacityRow['capacity'].")</option>";
			}
			
			return $capacity;
		}
		//*********************************************************************
		//around category add/edit *************
		public function category_addedit(){
			global $bsiCore;
			if($_POST['id']){
			
				mysql_query("update `bsi_around_hotel` set `category_id`='".$bsiCore->ClearInput($_POST['categoryTitle'])."', 
				hotel_id='".$bsiCore->ClearInput($_POST['hotel_id'])."', title='".mysql_real_escape_string($_POST['title'])."', 
				distance='".$bsiCore->ClearInput($_POST['distance'])."' where id='".$bsiCore->ClearInput($_POST['id'])."'");
				$_SESSION['hotel_id'] = $bsiCore->ClearInput($_POST['hotelid']);
			}else{
		
				$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']);
				mysql_query("insert into `bsi_around_hotel` (`category_id`, `hotel_id`, `title`, `distance`) values 
				('".$bsiCore->ClearInput($_POST['category_title'])."','".$bsiCore->ClearInput($_POST['hotel_id'])."',
				'".mysql_real_escape_string($_POST['title'])."', '".$bsiCore->ClearInput($_POST['distance'])."')");
				$_SESSION['hotel_id'] = $bsiCore->ClearInput($_POST['hotel_id']); 
			}	
		}
	
		public function category_delete(){
			global $bsiCore;
			$delid=$bsiCore->ClearInput($_REQUEST['delid']);
			mysql_query("delete from `bsi_around_hotel` where `id`='".$delid."'");
		}
		//*********************************************************************
		
		//capacity add/edit *************
	public function capacity_addedit(){
	    global $bsiCore;
		if(isset($_SESSION['hhid'])){
			$hotelid = $_SESSION['hhid'];
			
		}else{
			$hotelid = $bsiCore->ClearInput($_POST['hotel_id']);
		}
		if($_POST['id']){
			mysql_query("update bsi_capacity set hotel_id='".$hotelid."', title='".mysql_real_escape_string($_POST['title'])."',capacity='".$bsiCore->ClearInput($_POST['capacity'])."' where capacity_id=".$bsiCore->ClearInput($_POST['id']));
			$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']);
		}else{
			mysql_query("INSERT INTO `bsi_capacity` (`hotel_id` ,`title` ,`capacity`) VALUES ('".$hotelid."', '".mysql_real_escape_string($_POST['title'])."', '".$bsiCore->ClearInput($_POST['capacity'])."')");
			$capacityid = mysql_insert_id();
			$defaultSql = mysql_query("select `date_start`, `date_end`, `room_type_id`, `default` from bsi_priceplan where hotel_id=$hotelid group by `date_start`, `date_end`, `room_type_id`");
			$num = mysql_num_rows($defaultSql);
			if($num){
				while($row = mysql_fetch_assoc($defaultSql)){
					//mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`, `room_type_id`, `capacity_id`, `date_start`, `date_end`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `extrabed`,`default`) VALUES ('".$hotelid."', '".$row['room_type_id']."', '".$capacityid."', '".$row['date_start']."', '".$row['date_end']."', '0', '0', '0', '0', '0', '0','0', '0','".$row['default']."')");
					//$roomtypeid = $row['room_type_id'];
					
						mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`, `room_type_id`, `capacity_id`, `date_start`, `date_end`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default`) VALUES ('".$hotelid."', '".$row['room_type_id']."', '".$capacityid."', '".$row['date_start']."', '".$row['date_end']."', '0', '0', '0', '0', '0', '0','0', '".$row['default']."')");
					$roomtypeid = $row['roomtype_id'];
					$rowDef = $row['default'];
					
				//mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`, `room_type_id`, `capacity_id`, `date_start`, `date_end`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default`) VALUES ('".$hotelid."', '".$row['room_type_id']."', '1001', '".$row['date_start']."', '".$row['date_end']."', '0', '0', '0', '0', '0', '0','0', '".$rowDef."')");
				}
			}else{
				$rtSql = mysql_query("select * from bsi_roomtype where hotel_id=$hotelid");
				$numrt    = mysql_num_rows($rtSql);
				if($numrt){
					while($rowrt = mysql_fetch_assoc($rtSql)){
						//mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`,`room_type_id`,`capacity_id`,`sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `extrabed`,`default`) VALUES ('".$hotelid."', '".$rowrt['roomtype_id']."', '".$capacityid."', '0', '0', '0', '0', '0', '0','0', '0','1')");
						//$roomtypeid = $rowrt['room_type_id'];
						
						mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`,`room_type_id`,`capacity_id`,`sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default`) VALUES ('".$hotelid."', '".$rowrt['roomtype_id']."', '".$capacityid."', '0', '0', '0', '0', '0', '0','0', '1')");
						$roomtypeid = $rowrt['roomtype_id'];
						mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`,`room_type_id`,`capacity_id`,`sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default`) VALUES ('".$hotelid."', '".$rowrt['roomtype_id']."', '1001', '0', '0', '0', '0', '0', '0','0', '1')");
					}
				}
			}  
			
			if(isset($_POST['hotel_id'])){
				$_SESSION['hotel_id']   = $bsiCore->ClearInput($_POST['hotel_id']);
				$_SESSION['roomtypeid'] = $roomtypeid;
			}
		}	
	}
	
	public function capacity_deleteold(){
		global $bsiCore;
		$delid=$bsiCore->ClearInput($_REQUEST['delid']);
		mysql_query("delete from bsi_capacity where capacity_id=".$delid);
		mysql_query("delete from bsi_room where capacity_id=".$delid);
		mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	}
	
	public function capacity_delete(){
		global $bsiCore;
		$delid=$bsiCore->ClearInput($_REQUEST['delid']);
		mysql_query("delete from bsi_capacity where capacity_id=".$delid);
		mysql_query("delete from bsi_room where capacity_id=".$delid);
		
	$sql=mysql_query("SELECT * FROM  `bsi_priceplan` WHERE  date_start='0000-00-00'  and capacity_id=".$delid);
	while($row=mysql_fetch_assoc($sql)){
	echo $row['room_type_id'];
	$sql2=mysql_query("SELECT * FROM  `bsi_priceplan` WHERE  capacity_id!=1001 and date_start='0000-00-00' and room_type_id=".$row['room_type_id']);
	$count=mysql_num_rows($sql2);
	if($count==1){
	//echo "delete from bsi_priceplan where capacity_id=".$delid;
	//echo "delete from bsi_priceplan where capacity_id=1001 and room_type_id=".$row['room_type_id'];//die;
	mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	mysql_query("delete from bsi_priceplan where capacity_id=1001 and room_type_id=".$row['room_type_id']);
	}else{
	//echo "delete from bsi_priceplan where capacity_id=".$delid;//die;
	mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	}
	}
	
	
	$sql=mysql_query("SELECT * FROM  `bsi_priceplan` WHERE  date_start!='0000-00-00'  and capacity_id=".$delid);
	while($row=mysql_fetch_assoc($sql)){
	echo $row['room_type_id'];
	$sql2=mysql_query("SELECT * FROM  `bsi_priceplan` WHERE  capacity_id!=1001 and date_start!='0000-00-00' and room_type_id=".$row['room_type_id']);
	$count=mysql_num_rows($sql2);
	if($count==1){
	//echo "delete from bsi_priceplan where capacity_id=".$delid;
	//echo "delete from bsi_priceplan where capacity_id=1001 and room_type_id=".$row['room_type_id'];//die;
	mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	mysql_query("delete from bsi_priceplan where capacity_id=1001 and room_type_id=".$row['room_type_id']);
	}else{
	//echo "delete from bsi_priceplan where capacity_id=".$delid;//die;
	mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	
	}
	}

		//echo  "delete from bsi_priceplan where capacity_id=".$delid;die;
		//mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	}
	
	
	
public function capacity_deletetest(){
		global $bsiCore;
		$delid=$bsiCore->ClearInput($_REQUEST['delid']);
		mysql_query("delete from bsi_capacity where capacity_id=".$delid);
		mysql_query("delete from bsi_room where capacity_id=".$delid);
		
	$sql=mysql_query("SELECT * FROM  `bsi_priceplan` WHERE  capacity_id=".$delid);
	
	while($row=mysql_fetch_assoc($sql)){
	$sql2=mysql_query("SELECT * FROM  `bsi_priceplan` WHERE  capacity_id!=1001 and  date_start='0000-00-00' and room_type_id=".$row['room_type_id']);
	$count=mysql_num_rows($sql2);
	echo $count;
	if($count==1){
	echo "for single";
	echo "delete from bsi_priceplan where capacity_id=".$delid;
	echo "delete from bsi_priceplan where capacity_id=1001 and room_type_id=".$row['room_type_id'];//die;
	mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	mysql_query("delete from bsi_priceplan where capacity_id=1001 and room_type_id=".$row['room_type_id']);
	}else{
	echo "delete from bsi_priceplan where capacity_id=".$delid;//die;
	mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	}
	
	echo "SELECT * FROM  `bsi_priceplan` WHERE  capacity_id!=1001 and  date_start!='0000-00-00' and room_type_id=".$row['room_type_id'];
	$sql3=mysql_query("SELECT * FROM  `bsi_priceplan` WHERE  capacity_id!=1001 and  date_start!='0000-00-00' and room_type_id=".$row['room_type_id']);
	$count=mysql_num_rows($sql3);
	echo $count;
	if($count==1){
	echo "for single";
	echo "delete from bsi_priceplan where capacity_id=".$delid;
	echo "delete from bsi_priceplan where capacity_id=1001 and room_type_id=".$row['room_type_id'];//die;
	mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	mysql_query("delete from bsi_priceplan where capacity_id=1001 and room_type_id=".$row['room_type_id']);
	}else{
	echo "delete from bsi_priceplan where capacity_id=".$delid;//die;
	mysql_query("delete from bsi_priceplan where capacity_id=".$delid);
	}
	}//die;
	}
	
	
	
	// Payment gateway
	
		public function payment_gateway(){
		$gateway_value=array();
		$pp_row=mysql_fetch_assoc(mysql_query("select * from bsi_payment_gateway where gateway_code='pp'"));
		$co_row=mysql_fetch_assoc(mysql_query("select * from bsi_payment_gateway where gateway_code='2co'"));
		$poa_row=mysql_fetch_assoc(mysql_query("select * from bsi_payment_gateway where gateway_code='poa'"));
		$an_row=mysql_fetch_assoc(mysql_query("select * from bsi_payment_gateway where gateway_code='an'"));
		$cc_row=mysql_fetch_assoc(mysql_query("select * from bsi_payment_gateway where gateway_code='cc'"));
		$an_account=explode("=|=",$an_row['account']);
		
		$gateway_value['pp_enabled']=$pp_row['enabled'];
		$gateway_value['pp_gateway_name']=$pp_row['gateway_name'];
		$gateway_value['pp_account']=$pp_row['account'];
		$gateway_value['pp_order']=$pp_row['ord'];
		
		$gateway_value['co_enabled']=$co_row['enabled'];
		$gateway_value['co_gateway_name']=$co_row['gateway_name'];
		$gateway_value['co_account']=$co_row['account'];
		$gateway_value['co_order']=$co_row['ord'];
		
		$gateway_value['cc_enabled']=$cc_row['enabled'];
		$gateway_value['cc_gateway_name']=$cc_row['gateway_name'];
		$gateway_value['cc_order']=$cc_row['ord'];
		
		$gateway_value['poa_enabled']=$poa_row['enabled'];
		$gateway_value['poa_gateway_name']=$poa_row['gateway_name'];
		$gateway_value['poa_order']=$poa_row['ord'];
		
		/*$gateway_value['an_enabled']=$an_row['enabled'];
		$gateway_value['an_order']=$an_row['ord'];
		$gateway_value['an_gateway_name']=$an_row['gateway_name'];
		$gateway_value['an_login']=$an_account[0];
		$gateway_value['an_txnkey']=$an_account[1];*/
		return $gateway_value;
	}
	
	// End Here
	
	//
	
	public function payment_gateway_post(){
		global $bsiCore;
	    $pp = ((isset($_POST['pp'])) ? 1 : 0);
		$pp_order=$bsiCore->ClearInput($_POST['pp_order']);
		$pp_title=$bsiCore->ClearInput($_POST['pp_title']);
		$paypal_id=$bsiCore->ClearInput($_POST['paypal_id']);
		
		$co = ((isset($_POST['2co'])) ? 1 : 0);
		$co_order=$bsiCore->ClearInput($_POST['2co_order']);
		$co_title=$bsiCore->ClearInput($_POST['2co_title']);
		$co_id=$bsiCore->ClearInput($_POST['2co_id']);
		
		$cc = ((isset($_POST['cc'])) ? 1 : 0);
		$cc_order=$bsiCore->ClearInput($_POST['cc_order']);
		$cc_title=$bsiCore->ClearInput($_POST['cc_title']);
		$cc_id=$bsiCore->ClearInput($_POST['cc_id']);
		
		$poa = ((isset($_POST['poa'])) ? 1 : 0);
		$poa_order=$bsiCore->ClearInput($_POST['poa_order']);
		$poa_title=$bsiCore->ClearInput($_POST['poa_title']);
		
		/*$an = ((isset($_POST['an'])) ? 1 : 0);
		$an_order=$bsiCore->ClearInput($_POST['an_order']);
		$an_title=$bsiCore->ClearInput($_POST['an_title']);
		$an_loginid=$bsiCore->ClearInput($_POST['an_loginid']);
		$an_txnkey=$bsiCore->ClearInput($_POST['an_txnkey']);
		$auth_account=$an_loginid."=|=".$an_txnkey;*/
		
		mysql_query("update bsi_payment_gateway set gateway_name='$pp_title',ord='$pp_order', account='$paypal_id', enabled=$pp where gateway_code='pp'");
		mysql_query("update bsi_payment_gateway set gateway_name='$co_title',ord='$co_order',  account='$co_id', enabled=$co where gateway_code='2co'");
		mysql_query("update bsi_payment_gateway set gateway_name='$cc_title',ord='$cc_order',  account='$cc_id', enabled=$cc where gateway_code='cc'");
		mysql_query("update bsi_payment_gateway set gateway_name='$poa_title',ord='$poa_order',   enabled=$poa where gateway_code='poa'");
		/*mysql_query("update bsi_payment_gateway set gateway_name='$an_title', ord='$an_order', account='$auth_account', enabled=$an where gateway_code='an'");*/
	}
	
	//password change
	public function change_password(){
		global $bsiCore; 
		$msg="";
	    $old_password=md5($bsiCore->ClearInput($_POST['old_pass']));
		$new_password=md5($bsiCore->ClearInput($_POST['myPass']));
		$retype_newpass=$bsiCore->ClearInput($_POST['myPass2']);
		$newpass=$bsiCore->ClearInput($_POST['myPass']);
		$bsi_admin=mysql_query("select * from bsi_admin");
		$row_res=mysql_fetch_assoc($bsi_admin);
		if($old_password==$row_res['pass'] && $retype_newpass==$newpass){
			mysql_query("update bsi_admin set pass='".$new_password."' where pass='".$old_password."' and id=".$_SESSION['cpid']);
			$msg="Successfully Updated ......";
		}
		return $msg;
	}
	//agent password change
	public function change_pass(){
		global $bsiCore;
		$old_password=md5($bsiCore->ClearInput($_POST['old_pass']));
		$new_password=md5($bsiCore->ClearInput($_POST['new_pass']));
		$retype_newpass=$bsiCore->ClearInput($_POST['r_new_pass']);
		$newpass=$bsiCore->ClearInput($_POST['new_pass']);
		$agentid=$bsiCore->ClearInput($_POST['agent_id']);
		$bsi_agent = $bsiCore->getAgentrow($agentid);
		
		if($old_password == $bsi_agent['password'] && ($retype_newpass == $newpass)){			
			mysql_query("update bsi_agent set password='".$new_password."' where agent_id='".$agentid."'");
			$subject='Your Password is Successfully Changed';
			include("../includes/mail.class.php");
			$bsiMail = new bsiMail();
			$emailBody  = "Dear ".$bsi_agent['fname']." ".$bsi_agent['lname']." ,<br>";
			$emailBody .= "Your Registration with us is successful.<br>";
			$emailBody .= "Your Email Id : ".$bsi_agent['email']." and New Updated Password : ".$_POST['new_pass'];
			$emailBody .= '<br><br>Regards,<br>';
			$emailBody .= '<font style=\"color:#F00; font-size:10px;\">'.$bsiCore->config['conf_portal_name'].'</font>';
			$send 		= $bsiMail->sendEMail($bsi_agent['email'], $subject, $emailBody);
			$_SESSION['agentPass_2012'] = $new_password;
			return true;
		}else{
			return false;
		}
	}
	
		//room_add_edit		
	public function pagination_global($tbl_name, $noofperpage,$page,$targetpage,$type)
		{
			global $bsiCore;
		/*
			Place code to connect to your DB here.
		*/
			$pagination_array=array();
			//your table name
			// How many adjacent pages should be shown on each side?
			$adjacents = 3;
			
			/* 
			   First get total number of rows in data table. 
			   If you have a WHERE clause in your query, make sure you mirror it here.
			*/
			switch($type){
			case 1:
			$query = "SELECT COUNT(*) as num FROM $tbl_name where payment_success=true and CURDATE() <= end_date and is_block=false and is_deleted=false order by start_date";
			break;
			
			case 2:
			$query = "SELECT COUNT(*) as num FROM $tbl_name where payment_success=true and (CURDATE() > end_date OR is_deleted=true) and is_block=false ";
			break;	
			
			case 3:
			$query = "SELECT COUNT(*) as num FROM $tbl_name";
			break;	
			
			case 4:
			$query = "select count(*) as num from (SELECT * FROM bsi_room group by `roomtype_id`,`capacity_id`, no_of_child) as t1";
			break;
			}
			$total_pages = mysql_fetch_array(mysql_query($query));
			$total_pages = $total_pages['num'];
		
			/* Setup vars for query. */
			
			$limit =  $noofperpage; 
			if($page) 
			$start = ($page - 1) * $limit; 			//first item to display on this page
			else
			$start = 0;								//if no page var is given, set start to 0
			switch($type){
			case 1:
			$sql = "SELECT booking_id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id  FROM $tbl_name where payment_success=true and CURDATE() <= end_date and is_deleted=false and is_block=false order by start_date  LIMIT $start, $limit";
			break;
			
			case 2:
			$sql = "SELECT booking_id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id, is_deleted  FROM $tbl_name where payment_success=true and (CURDATE() > end_date OR is_deleted=true)  and is_block=false order by start_date  LIMIT $start, $limit";
			break;
			
			case 3:
			$sql ="SELECT * FROM $tbl_name LIMIT $start, $limit";
			break;
			
			case 4:
			$sql ="SELECT `hotel_id`, `roomtype_id`, `capacity_id`, count(*), `no_of_child` FROM bsi_room group by `hotel_id`, `roomtype_id`,`capacity_id`, `no_of_child` LIMIT $start, $limit";
			break;
			}
			/* Get data. */
			$result = mysql_query($sql) or die(mysql_error());
			
			/* Setup page vars for display. */
			if ($page == 0) $page = 1;					//if no page var is given, default to 1.
			$prev = $page - 1;							//previous page is page - 1
			$next = $page + 1;							//next page is page + 1
			$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;						//last page minus 1
			
			/* 
				Now we apply our rules and draw the pagination object. 
				We're actually saving the code to a variable in case we want to draw it more than once.
			*/
			$pagination = "";
		if($lastpage > 1)
		{	
			$pagination .= "<div class=\"pagination\">";
			//previous button
			if ($page > 1) 
				$pagination.= "<a href=\"$targetpage?page=$prev\">« previous</a>";
			else
				$pagination.= "<span class=\"disabled\">« previous</span>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
				}
			}
			//next button
			if ($page < $counter - 1) 
				$pagination.= "<a href=\"$targetpage?page=$next\">next »</a>";
			else
				$pagination.= "<span class=\"disabled\">next »</span>";
			$pagination.= "</div>\n";		
		}
	    $pagination_array['pagination_return_sql']=$result;
		$pagination_array['page_list']=$pagination;
		$pagination_array['total_pages']=$total_pages;
		$pagination_array['limit']=$limit;
		return $pagination_array;
		}
	################################# UPLOAD IMAGES
	public function main_gallery_img_upload(){
		$enable_thumbnails	= 1 ;
		$max_image_size		= 1024000 ; 
		$upload_dir			= "../gallery/hotelImage/"; 
		$hotel_id=mysql_real_escape_string($_POST['hotel_id']);
		$i=0;
		foreach($_FILES as $k => $v){ 
			$img_type = ""; 
			if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
				$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
				$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
				$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
				$img_rname = time().'_'.$i.$_FILES[$k]['name'];
				$img_path = $upload_dir.$img_rname;
				copy( $_FILES[$k]['tmp_name'], $img_path ); 
				if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname, 150, 84);
				mysql_query("insert into bsi_gallery(hotel_id, img_path, gallery_type) values('".$hotel_id."','".$img_rname."','1')");
			}
			$i++;
		}	
	
	}	
	
	public function agent_addedit_entry(){
		//print_r($_POST);die;
		global $bsiCore;
		$cname      = mysql_real_escape_string($_POST['cname']);
		$fname      = mysql_real_escape_string($_POST['fname']);
		$lname      = mysql_real_escape_string($_POST['lname']);
		$email      = mysql_real_escape_string($_POST['email']);
		$phone      = $bsiCore->ClearInput($_POST['phone']);
		$fax        = $bsiCore->ClearInput($_POST['fax']);
		$address    = mysql_real_escape_string($_POST['address']);
		$city       = mysql_real_escape_string($_POST['city']);
		$state      = mysql_real_escape_string($_POST['state']);
		$country    = $bsiCore->ClearInput($_POST['country_code']);
		$zipcode    = $bsiCore->ClearInput($_POST['zipcode']);
		$status     = $bsiCore->ClearInput($_POST['status']);
		$commission = $bsiCore->ClearInput($_POST['commission']);
		$agent_id   = $bsiCore->ClearInput($_POST['agent_id']);
		
		if($agent_id){
			$result=mysql_query("UPDATE `bsi_agent` SET 
								`company`		=	'".$cname."',
								`fname` 		= 	'".$fname."',
								`lname`			= 	'".$lname."',
								`email` 		= 	'".$email."',
								`phone` 		= 	'".$phone."',
								`fax` 			= 	'".$fax."',
								`address` 		= 	'".$address."',
								`city` 			= 	'".$city."',
								`state` 		= 	'".$state."',
								`country` 		= 	'".$country."',
								`zipcode` 		= 	'".$zipcode."',
								`status` 		= 	'".$status."',
								`commission` 	= 	'".$commission."'
								 WHERE `agent_id` =	'".$agent_id."'");	
		}else{
			$password=md5($_POST['password']);			
			$result=mysql_query("INSERT INTO `bsi_agent` ( `company`,`fname` , `lname` , `email` , `password` , `phone` , `fax` ,
`address` , `city` , `state` , `country` , `zipcode` , `status` , `commission` , `register_date` ) VALUES ( '".$cname."', '".$fname."', '".$lname."', '".$email."', '".$password."', '".$phone."', '".$fax."', '".$address."', '".$city."', '".$state."', '".$country."', '".$zipcode."', '".$status."', '".$commission."', '".date("Y/m/d")."' )");	
		}
	}
		
	public function getRoomtype($roomtype){
		$row = mysql_fetch_assoc(mysql_query("select * from bsi_roomtype where roomtype_id='".$roomtype."'"));
		return $row;
	}	
//category
		public function getCategory($category_id){
			$row =mysql_fetch_assoc(mysql_query("select * from bsi_around_hotel_category where category_id='".$category_id."'"));
			return $row;
		}
		
		public function getAgent($agent_id){
			$row=mysql_fetch_assoc(mysql_query("select * from bsi_agent where agent_id='".$agent_id."'"));
			return $row;
		}
		
		public function getAgentBookingDetails($client_id){
			global $bsiCore;
			$result = mysql_query("SELECT bb.booking_id, bh.hotel_name, concat(ba.fname,' ', ba.lname) as name, ba.phone,
								   DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') AS booking_time, 
								   DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date, 
								   DATE_FORMAT(bb.checkout_date,'".$bsiCore->userDateFormat."') AS checkout_date,
								   bb.total_cost
								   FROM bsi_bookings AS bb, bsi_agent AS ba, bsi_hotels AS bh
								   WHERE bb.hotel_id = bh.hotel_id
								   AND bb.client_id = ba.agent_id
								   AND bb.agent = '1'
								   AND bb.checkout_date >= CURDATE()
								   AND bb.is_deleted = '0'
								   AND bb.client_id ='".$client_id."'");
			return $result;				   
		}
		
		public function getAgentBookingDetailsHistory($client_id){
			global $bsiCore;
			$result = mysql_query("SELECT bb.booking_id, bh.hotel_name, concat(ba.fname,' ', ba.lname) as name, ba.phone,
								   DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') AS booking_time, 
								   DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date, 
								   DATE_FORMAT(bb.checkout_date,'".$bsiCore->userDateFormat."') AS checkout_date,
								   bb.total_cost
								   FROM bsi_bookings AS bb, bsi_agent AS ba, bsi_hotels AS bh
								   WHERE bb.hotel_id = bh.hotel_id
								   AND bb.client_id = ba.agent_id
								   AND bb.agent = '1'
								   AND (bb.checkout_date < CURDATE()
								   OR bb.is_deleted = '1')
								   AND bb.client_id ='".$client_id."'");
			return $result;				   
		}
		
		public function getAgentComm($agent_id){
			global $bsiCore;
			$result = mysql_query("SELECT bb.booking_id, ba.commission,
								   DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') AS booking_time, 
								   DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date, 
								   DATE_FORMAT(bb.checkout_date,'".$bsiCore->userDateFormat."') AS checkout_date,
								   bb.total_cost, bb.is_deleted
								   FROM bsi_bookings AS bb, bsi_agent AS ba, bsi_hotels AS bh
								   WHERE bb.hotel_id = bh.hotel_id
								   AND bb.client_id = ba.agent_id
								   AND bb.agent = '1'
								   AND bb.client_id ='".$agent_id."'");
			return $result;				   
		}
		
		//getEmailContents
		
    public function getEmailContents(){
				global $bsiCore;
				$dropList='<option value="0" selected="selected">'.'Select Type'.'</option>';
				$sql=mysql_query("select * from bsi_email_contents");
				while($rowemailinfo=mysql_fetch_assoc($sql)){
					$dropList.='<option value="'.$rowemailinfo['id'].'">'.$rowemailinfo['email_name'].'</option>';
					}
				return $dropList;
		}
		
//updateEmailContent
		public function updateEmailContent(){	
		   global $bsiCore;
		   $emailsub=$bsiCore->ClearInput($_POST['email_sub']);
		   $emailcon=$bsiCore->ClearInput($_POST['email_con']);
		   $mailid=$bsiCore->ClearInput($_POST['c_update']);
		   mysql_query("update bsi_email_contents set email_subject='".$emailsub."',email_text='".$emailcon."' where id='".$mailid."'");	
		}
		
		
		public function getPricePlanStatus($hotelid, $room_type, $capacity_id){
			$result = mysql_query("select * from bsi_priceplan where hotel_id='".$hotelid."' and room_type_id='".$room_type."' and 
								   capacity_id='".$capacity_id."'");
			if(mysql_num_rows($result)){
				return true;	
			}else{
				return false;	
			}
		}
		
				
		public function getPriceplanEditFrm($ro_ppresss){
		global $bsiCore;
		$currency_symbol= $bsiCore->currency_symbol();
		$gethtml='';
		$result = mysql_query($ro_ppresss);  
		if(mysql_num_rows($result)){
			while($ro_pp=mysql_fetch_assoc($result)){
				$row_capacity = mysql_fetch_assoc(mysql_query("SELECT * FROM `bsi_capacity` where capacity_id='".$ro_pp['capacity_id']."'"));
				/*if($ro_pp['capacity_id']==1001){    
					$title = "Per Child";*/
					
			
				if($ro_pp['capacity_id']!=1001){    
					$title = $row_capacity['title'];
				

		$gethtml.='<tr> 
			<td style="width:200px; padding:5px !important;">&nbsp;&nbsp;&nbsp;&nbsp;'.$title.'<input type="hidden" value="'.$ro_pp['priceplan_id'].'" name="pp_id['.$ro_pp['capacity_id'].']" /></td> 									 
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="sun['.$ro_pp['priceplan_id'].']" id="sun" value="'.$ro_pp['sun'].'" class="number" /> </td> 
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="mon['.$ro_pp['priceplan_id'].']" id="mon" value="'.$ro_pp['mon'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;"  name="tue['.$ro_pp['priceplan_id'].']" id="tue" value="'.$ro_pp['tue'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="wed['.$ro_pp['priceplan_id'].']" id="wed" value="'.$ro_pp['wed'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;"  name="thu['.$ro_pp['priceplan_id'].']" id="thu" value="'.$ro_pp['thu'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="fri['.$ro_pp['priceplan_id'].']" id="fri" value="'.$ro_pp['fri'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="sat['.$ro_pp['priceplan_id'].']" id="sat" value="'.$ro_pp['sat'].'" class="number"/> </td>
			</tr>';  
			/*<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="extrabed['.$ro_pp['priceplan_id'].']" id="extrabed" value="'.$ro_pp['extrabed'].'" class="number"/> </td>  
			</tr>';*/
			}
				else{
				$title = "Per Child";
				$gethtml.='<tr> 
			<td style="width:200px; padding:5px !important;">&nbsp;&nbsp;&nbsp;&nbsp;'.$title.'<input type="hidden" value="'.$ro_pp['priceplan_id'].'" name="pp_id['.$ro_pp['capacity_id'].']" /></td> 									 
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="sun['.$ro_pp['priceplan_id'].']" id="sun" value="'.$ro_pp['sun'].'" class="number" /> </td> 
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="mon['.$ro_pp['priceplan_id'].']" id="mon" value="'.$ro_pp['mon'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;"  name="tue['.$ro_pp['priceplan_id'].']" id="tue" value="'.$ro_pp['tue'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="wed['.$ro_pp['priceplan_id'].']" id="wed" value="'.$ro_pp['wed'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;"  name="thu['.$ro_pp['priceplan_id'].']" id="thu" value="'.$ro_pp['thu'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="fri['.$ro_pp['priceplan_id'].']" id="fri" value="'.$ro_pp['fri'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$currency_symbol.'<input type="text" style="width:70px;" name="sat['.$ro_pp['priceplan_id'].']" id="sat" value="'.$ro_pp['sat'].'" class="number"/> </td>  
			</tr>';
				
				}
			
			
			}   
		}
		$gethtml.='<tr><td colspan="2"><font style="color:#F00;">* &nbsp;&nbsp;</font><b>This Field is required</b><br /><font style="color:#F00;">** &nbsp;</font><b>Only Numbers</b></td><td colspan="7">&nbsp;</td></tr>';
			
			return $gethtml;
	}
		
    //discountCouponshow
	public function discountCouponshow(){
		    global $bsiCore;  	
			 $getHtml='';
		 $result=mysql_query("select promo_id,promo_code,discount,min_amount,percentage,promo_category,customer_email,reuse_promo,DATE_FORMAT(exp_date,'".$bsiCore->userDateFormat."') AS exp_date from bsi_promocode");
		 if(mysql_num_rows($result)){
				
			while($row=mysql_fetch_assoc($result)){
				$promoid=$row['promo_id'];
				$amount='';	
				
								if($row['percentage']==1){
									$amount.=$row['discount'].'%';
								  }else{
									$amount.='$'.$row['discount'];
								}
					$getHtml.='<tr><td align="left">'.$row['promo_code'].'</td><td>'.$amount.'</td><td>'.$bsiCore->config['conf_currency_symbol'].$row['min_amount'].'</td><td>'.$row['exp_date'].'</td><td>'.$row['customer_email'].'</td><td>'.$row['reuse_promo'].'</td>'.'<td style="text-align:right; padding-right:10px;"><a href="discount_coupon.php?id='.$promoid.'">'.'Delete'.'</a></td></tr>';
								
			}
			$getHtml=$getHtml;
		
	}
	return $getHtml;
	
	}
	
   //discountCouponInsert
   
   public function 	discountCouponInsert(){
	   
	  global $bsiCore; 
					  //$strmsg = "succesfully inserted";
		//echo "<pre>";print_r($_POST);echo "</pre>";die;
		$coupon_code=mysql_real_escape_string($_POST['coupon_code']);
		$discount_amt=mysql_real_escape_string($_POST['discount_amt']);
		$min_amt=mysql_real_escape_string($_POST['min_amt']);
	    $chk_expire=mysql_real_escape_string($_POST['chk_expire']);
		$coupon_category=mysql_real_escape_string($_POST['coupon_category']);
		$cust_email=mysql_real_escape_string($_POST['cust_email']);
		$rad_discount_type=mysql_real_escape_string($_POST['rad_discount_type']);
		$chk_reusecoupon=mysql_real_escape_string($_POST['chk_reusecoupon']);	
		if($cust_email != "undefined"){
			$email = $cust_email;
		}else{
			$email = "";
		}
		/*if(isset($chk_expire)){
			  $chk_expire1 = date('Y-m-d',strtotime(str_replace('-', '/', $chk_expire)));		
			
		}*/
		
		$bsipromocoderesult=mysql_query("insert into  `bsi_promocode`(`promo_code`,`discount`,`min_amount`,`percentage`,`promo_category`,`customer_email`,`exp_date`,`reuse_promo`)values('".$coupon_code."','".$discount_amt."','".$min_amt."','".$rad_discount_type."','".$coupon_category."','".$email."','".$bsiCore->getMySqlDate($chk_expire)."','".$chk_reusecoupon."')");

	   }
	
		public function getCombination($room, $adult){
			$array = array();
			$room  = $bsiCore->ClearInput($room);
			$adult = $bsiCore->ClearInput($adult);
			$ro_ad     = $adult%$room;
			if($ro_ad == 0){
				$perroom = $adult/$room;
				for($i=0; $i < $room; $i++){
					$array[]=$perroom;
				}
			}else{
				$c=0;
				$d= $room-1;
				//$j=floor($adult/$room);
				for($i=0; $i < $d; $i++){
				$array[]=floor($adult/$room);
				$c=$c+floor($adult/$room);
				}
				$array[]=$adult-$c;
			}
			$adultperrrom="";
			$getArray='
			<table border="1" width="200">';
		  foreach($array as $i => $value){
		  $getArray.="<tr><td>Room ".($i+1)."</td><td>".$value."</td></tr>";
		  $adultperrrom.=$value.'#'; 
		  }
		  $adultperrrom = substr($adultperrrom, 0, -1);
		  $_SESSION['adultperrrom']=$adultperrrom;
		}
		
		//gallery photo delete start.............
		public function gallery_photo_delete(){
			global $bsiCore;
			$id = $bsiCore->ClearInput(base64_decode($_REQUEST['pid']));
			$row_pic = mysql_fetch_assoc(mysql_query("select * from bsi_gallery where id=".$id));
			if(file_exists("../gallery/".$row_pic['img_path'])){
				unlink("../gallery/".$row_pic['img_path']);
			}
			mysql_query("delete from bsi_gallery where gallery_type='2' AND id=".$row_pic['id']);
		}
		//gallery photo delete end.............
		
	public function slider_gallery_img_upload(){
		if(isset($_POST['eid'])){
			$enable_thumbnails	= 1 ;
			$max_image_size		= 1024000 ;
			$upload_dir			= "../gallery/"; 
			foreach($_FILES as $k => $v){ 
				$img_type = "";
				if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
					$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
					$img_rname = time().'_'.$_FILES[$k]['name'];
					$img_path = $upload_dir.$img_rname;
					copy( $_FILES[$k]['tmp_name'], $img_path );
					if(file_exists($upload_dir.mysql_real_escape_string($_POST['preImg']))){
						unlink($upload_dir.mysql_real_escape_string($_POST['preImg']));	
					}
					mysql_query("update bsi_gallery set img_path='".$img_path."' where id=".mysql_real_escape_string($_POST['eid']));
				}
			}
			mysql_query("update bsi_gallery set description='".mysql_real_escape_string($_POST['desc'])."' where id=".mysql_real_escape_string($_POST['eid']));
		}else{
			$k2=0;
			$enable_thumbnails	= 1 ;
			$max_image_size		= 1024000 ;
			$upload_dir			= "../gallery/";
			foreach($_FILES as $k => $v){ 
				$img_type = "";
				if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
	
					$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
	
					$img_rname = time().'_'.$_FILES[$k]['name'];
					$img_path = $upload_dir.$img_rname;
	
					copy( $_FILES[$k]['tmp_name'], $img_path );
					$aa=mysql_query("insert into bsi_gallery(img_path, gallery_type, description) values('".$img_rname."','2', '".$_POST['desc'][$k2]."')");				
					$k2++;
				}
			}
		}
	
	}
	
	public function getHotelhtml($agent_id=0){
		$getHtml = "";
		if($agent_id){
			$sql = "SELECT * FROM bsi_hotels, bsi_agent_entry_hotel where bsi_agent_entry_hotel.hotel_id=bsi_hotels.hotel_id and bsi_agent_entry_hotel.agent_id=$agent_id";
		}else{
			$sql = "SELECT * FROM bsi_hotels";
		}
		$result = mysql_query($sql);
		$hidden = base64_encode($sql);
		while($row = mysql_fetch_assoc($result)){
			$status=($row['status']==1)? '<font color="#006600">Enabled</font>' : '<font color="#840000">Disabled</font>';
			$countryname=mysql_fetch_assoc(mysql_query("select `name` from `bsi_country` where `country_code`='".$row['country_code']."'"));						
			$getHtml.='<tr class="gradeX">';
			$getHtml.=    '<td nowrap="nowrap">'.$row['hotel_name'].'</td> 
						   <td nowrap="nowrap">'.$row['address_1'].', '.$row['city_name'].', '.$countryname['name'].'</td> 
						   <td>'.$row['checking_hour'].'</td> 
						   <td>'.$row['checkout_hour'].'</td> 
						   <td>'.$status.'</td>
						   <td align="right" nowrap="nowrap">
								<a href="hotel_details_entry.php?hotel_id='.base64_encode($row['hotel_id']).'&addedit=1">Edit</a> | 
								<a href="javascript:;" onclick="return capacity_delete(\''.$row['hotel_id'].'\');">Delete</a> | 
								<a href="hotel_details.php?hotel_id='.base64_encode($row['hotel_id']).'">View Details</a>
						   </td>
					   </tr>';
		}
		$hotelarray=array("0"=>$hidden,"1"=>$getHtml);
		return $hotelarray;  	
	}
	
	//Booking Active And history
	 public function getBookingInfo($info, $hotel_id=0, $clientid=0){
		global $bsiCore;
		switch($info){
			case 1:
			//echo  "SELECT booking_id, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id,agent FROM bsi_bookings where payment_success=true and CURDATE() <= checkout_date and is_deleted=false and is_block=false and hotel_id='".$hotel_id."' order by start_date";die;
			$sql = "SELECT booking_id, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, checkout_date as chkOut ,checkin_date,checkout_date,total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time,booking_time as bt,payment_amount,payment_type,is_deleted,client_id,agent FROM bsi_bookings where payment_success=true and CURDATE() <= checkout_date and is_deleted=false and is_block=false and hotel_id='".$hotel_id."' order by start_date";
			
			break;
		
			case 2:
			$sql = "SELECT booking_id, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id, is_deleted,checkin_date,checkout_date,agent,booking_time as bt,payment_amount  FROM bsi_bookings where payment_success=true and (CURDATE() > checkout_date OR is_deleted=true)  and is_block=false and hotel_id='".$hotel_id."' order by `booking_id` DESC";
		   //echo $sql;die;
			break;
		
			case 3:
			$sql = "SELECT booking_id, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, is_deleted, is_block,checkout_date  FROM bsi_bookings where agent=false and client_id=".$clientid;
			
			break;
			
			case 4:
			$sql = "SELECT booking_id, CONCAT(bsi_clients.first_name,' ',bsi_clients.surname) as Name, bsi_clients.phone, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, payment_type, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, bsi_bookings.client_id FROM bsi_bookings, bsi_clients where bsi_clients.client_id = bsi_bookings.client_id and payment_success=true and CURDATE() <= checkout_date and is_deleted=false and is_block=false and hotel_id=".$_SESSION['hotelidpdf']." and (DATE_FORMAT(".mysql_real_escape_string($_SESSION['shortby']).", '%Y-%m-%d') between '".$bsiCore->getMySqlDate(mysql_real_escape_string($_SESSION['check_in']))."' and '".$bsiCore->getMySqlDate(mysql_real_escape_string($_SESSION['check_out']))."')";
		
			break;
			
			case 5:
			$sql = "SELECT booking_id, CONCAT(bsi_clients.first_name,' ',bsi_clients.surname) as Name, bsi_clients.phone, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, bsi_bookings.client_id FROM bsi_bookings, bsi_clients where bsi_clients.client_id = bsi_bookings.client_id and payment_success=true and (CURDATE() > checkout_date or is_deleted=true) and is_block=false and hotel_id=".$_SESSION['hotelidpdf']." and (DATE_FORMAT(".mysql_real_escape_string($_SESSION['shortby']).", '%Y-%m-%d') between '".$bsiCore->getMySqlDate(mysql_real_escape_string($_SESSION['check_in']))."' and '".$bsiCore->getMySqlDate(mysql_real_escape_string($_SESSION['check_out']))."')";
		
			break;
			
			case 6:
			//echo  "SELECT booking_id, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id,agent FROM bsi_bookings where payment_success=true and CURDATE() <= checkout_date and is_deleted=false and is_block=false and hotel_id='".$hotel_id."' order by start_date";die;
			$sql = "SELECT booking_id, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, checkout_date as chkOut , total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time,booking_time as bt,confirmation_time as ct,is_deleted,payment_amount,payment_type, client_id,agent FROM bsi_bookings where payment_success=true and CURDATE() <= checkout_date and is_block=false and hotel_id='".$hotel_id."' order by booking_id DESC LIMIT 30";
		}
		return $sql;
	 }
	 
	 public function getClientInfo($client_id, $agent=0){
		if($agent){
			$row=mysql_fetch_assoc(mysql_query("select * from bsi_agent where agent_id=".$client_id));
		}else{
		//echo "select * from bsi_clients where client_id=".$client_id;die;
			$row=mysql_fetch_assoc(mysql_query("select * from bsi_clients where client_id=".$client_id));
		}
		return $row;
	 }
	 
	 public function getHtml($type=0, $hotelid, $query){
		global $bsiCore;
		$returnValue = array();
		$clientArr = array();
		$exist = false;
		//echo $type;die;
		if($type == 1){
			$data = array();
		//$csv_datas = "Booking ID ; Name ; Check In ; Check Out ; Amount ; Booking Date";
		$csv_datas = "Hotel Name ; Hotel Id ; Room Type ; Booking id ; Customer Name ; Phone ; Email ; Booking Time ; Booking Date ; Check In ; Status ; Room Rent ; Down Payment ; Amount Due ; Dispute ";

		array_push($data,$csv_datas);
		$fp = '';
			$html = '<thead>
						  <tr>
							<th width="10%" nowrap>Booking ID</th>
							<th width="15%" nowrap>Name</th>
							<th width="15%" nowrap>Check In</th>
							<th width="15%" nowrap>Check Out</th>
							<th width="10%" nowrap>Amount</th>
							<th width="10%" nowrap>Booking Date</th>
							<th width="25%" nowrap>&nbsp;</th>
						   </tr>
					  </thead>
					  <tbody>';
			$result = mysql_query($query);
			
			if(mysql_num_rows($result)){
				$exist = true;
				while($row = mysql_fetch_assoc($result)){
					$clientArr = $this->getClientInfo($row['client_id']);

//for cvs					
$rooms1='';					
$roomnamequery = $bsiCore->getNoOfRoom($row['booking_id']);
$roomnameresult = mysql_query($roomnamequery);
$num = mysql_num_rows($roomnameresult);
$i=0;
while($roomnamerow = mysql_fetch_assoc($roomnameresult)){
		if($i == $num){
			$rooms1 .= $roomnamerow['type_name']." (".$roomnamerow['title'].").";
		}else{
			$rooms1 .= $roomnamerow['type_name']." (".$roomnamerow['title'].").<br/>";
		}
}
$amountdue=$row['total_cost']-$row['payment_amount'];
$hoteldata=$this->getHotelDetails($hotelid);

//********************** For Status
$bookingstatus=mysql_fetch_assoc(mysql_query("select * from bsi_reservation where booking_id='".$row['booking_id']."'"));
if($row['is_deleted'] == 0)
	{
		
	
	if($bookingstatus['boking_status']==0){$bstatus='Confirm';}
	if($bookingstatus['boking_status']==1){$bstatus='Confirm';}
	if($bookingstatus['boking_status']==2){$bstatus='Check In';}
	if($bookingstatus['boking_status']==3){$bstatus='Check Out';}
	}else{
	$bstatus='Cancel';
	}
	
$bdispute=$bookingstatus['booking_dispute'];				
					//$csv_datas = $row['booking_id']." ; ".$clientArr['first_name']." ; ".$row['start_date']." ; ".$row['end_date']." ; ".$row['total_cost']." ; ".$row['booking_time'];
					$csv_datas = $hoteldata['hotel_name']." ;".$hotelid." ; ".$rooms1." ; ".$row['booking_id']." ; ".$clientArr['first_name']." ; ".$clientArr['phone']." ; ".$clientArr['email']."; ".date("H:i:s",strtotime($row['bt']))." ; ".$row['booking_time']." ; ".$row['start_date']." ; ".$bstatus." ; ".$bsiCore->currency_symbol().$row['total_cost']." ; ".$bsiCore->currency_symbol().$row['payment_amount']." ; ".$bsiCore->currency_symbol().$amountdue." ; ".$bdispute;
				
				array_push($data,$csv_datas); // creating the csv file string
					$html .= '<tr>
								<td width="10%" nowrap>'.$row['booking_id'].'</td>
								<td width="15%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
								<td width="15%" nowrap>'.$row['checkin_date'].'</td>
								<td width="15%" nowrap>'.$row['checkout_date'].'</td>
								<td width="10%" nowrap>'.$bsiCore->currency_symbol().$row['total_cost'].'</td>
								<td width="10%" nowrap>'.date("Y-m-d",strtotime($row['bt'])).'</td>
								<td width="25%" nowrap>
								<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'&hotel_id='.base64_encode($hotelid).'">View Details</a> | 
								<a href="javascript:;" onclick="myPopup2(\''.$row['booking_id'].'\');">Print Voucher</a> |  
								<a href="javascript:;" onclick="return cancel(\''.$row['booking_id'].'\');">Cancel</a>
								</td>
							  </tr>';
				}
				
				$fp = fopen('../data/csvs/Active-'.$hoteldata['hotel_name'].'-'.date('Ymd').'.csv', 'w');  
		
		foreach ($data as $line ) {
			$val = explode(";", $line);
			fputcsv($fp, $val);
		}  
		fclose($fp);
			
			}
			
			
		}
		if($type == 2){
		$data = array();
		
		$csv_datas = "Hotel Name ; Hotel Id ; Room Type ; Booking id ; Customer Name ; Phone ; Email ; Booking Time ; Booking Date ; Check In ; Status ; Room Rent ; Down Payment ; Amount Due ; Dispute ";
		
		//$csv_datas = "Booking ID ; Name ; Check In ; Check Out ; Amount ; Booking Date";
		array_push($data,$csv_datas);
		$fp = '';
			$html = '<thead>
						  <th width="10%" nowrap><strong>Booking ID</strong></th>
						  <th width="15%" nowrap><strong>Name</strong></th>
						  <th width="15%" nowrap><strong>Check In</strong></th>
						  <th width="15%" nowrap><strong>Check Out</strong></th>
						  <th width="10" nowrap><strong>Amount</strong></th>
						  <th width="10%" nowrap><strong>Booking Date</strong></th>
						  <th width="25%" nowrap>&nbsp;</th>
					  </thead>
					  <tbody>';
			$result = mysql_query($query);
			if(mysql_num_rows($result)){
				$exist = true;
				while($row = mysql_fetch_assoc($result)){
					
$rooms1='';					
$roomnamequery = $bsiCore->getNoOfRoom($row['booking_id']);
$roomnameresult = mysql_query($roomnamequery);
$num = mysql_num_rows($roomnameresult);
$i=0;
while($roomnamerow = mysql_fetch_assoc($roomnameresult)){
		if($i == $num){
			$rooms1 .= $roomnamerow['type_name']." (".$roomnamerow['title'].").";
		}else{
			$rooms1 .= $roomnamerow['type_name']." (".$roomnamerow['title'].").";
		}
}
$amountdue=$row['total_cost']-$row['payment_amount'];
$hoteldata=$this->getHotelDetails($hotelid);

//********************** For Status
$bstatus='';
$bookingstatus=mysql_fetch_assoc(mysql_query("select * from bsi_reservation where booking_id='".$row['booking_id']."'"));
if($row['is_deleted'] == 0)
	{
	if($bookingstatus['boking_status']==0){$bstatus='Confirm';}
	if($bookingstatus['boking_status']==1){$bstatus='Confirm';}
	if($bookingstatus['boking_status']==2){$bstatus='Check In';}
	if($bookingstatus['boking_status']==3){$bstatus='Check Out';}
	}else{
	$bstatus='Cancel';
	}
$bdispute=$bookingstatus['booking_dispute'];
			
					$clientArr = $this->getClientInfo($row['client_id']);
					$csv_datas = $hoteldata['hotel_name']." ;".$hotelid." ; ".$rooms1." ; ".$row['booking_id']." ; ".$clientArr['first_name']." ; ".$clientArr['phone']." ; ".$clientArr['email']."; ".date("H:i:s",strtotime($row['bt']))." ; ".$row['booking_time']." ; ".$row['start_date']." ; ".$bstatus." ; ".$bsiCore->currency_symbol().$row['total_cost']." ; ".$bsiCore->currency_symbol().$row['payment_amount']." ; ".$bsiCore->currency_symbol().$amountdue." ; ".$bdispute;
					array_push($data,$csv_datas);
					$html .= '<tr>
								<td width="10%" nowrap>'.$row['booking_id'].'</td>
								<td width="15%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
								<td width="15" nowrap>'.$row['checkin_date'].'</td>
								<td width="15%" nowrap>'.$row['checkout_date'].'</td>
								<td width="10%" nowrap>'.$bsiCore->currency_symbol().$row['total_cost'].'</td>
								<td width="10" nowrap>'.date("Y-m-d",strtotime($row['bt'])).'</td>
								<td width="25%">
									<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'&hotel_id='.base64_encode($hotelid).'">View Details</a> | 
									<a href="javascript:;" onclick="myPopup2(\''.$row['booking_id'].'\');">Print Voucher</a> |  
									<a href="javascript:;" onclick="return deleteBooking(\''.$row['booking_id'].'\');">Delete</a>
								</td>
							  </tr>';
				}
				
				$fp = fopen('../data/csvs/History-'.$hoteldata['hotel_name'].'-'.date('Ymd').'.csv', 'w');  
		
		foreach ($data as $line ) {
			$val = explode(";", $line);
			fputcsv($fp, $val);
		}  
		fclose($fp);
			}
			
			
		}
		
		if($type == 4){
		$data = array();
		$csv_datas = "Booking ID ; Name ; Check In ; Check Out ; Amount ; Booking Date";
		array_push($data,$csv_datas);
		$fp = '';
			$html = '<thead>
						  <tr>
							<th width="10%" nowrap>Booking ID</th>
							<th width="20%" nowrap>Name</th>
							<th width="10%" nowrap>Check In</th>
							<th width="10%" nowrap>Check Out</th>
							<th width="10%" nowrap>Amount</th>
							<th width="10%" nowrap>Booking Date</th>
							<th width="30%" nowrap>&nbsp;</th>
						   </tr>
					  </thead>
					  <tbody>';
			$result = mysql_query($query);
			if(mysql_num_rows($result)){
				$exist = true;
				while($row = mysql_fetch_assoc($result)){
					$clientArr = $this->getClientInfo($row['client_id']);
					$html .= '<tr>
								<td width="10%" nowrap>'.$row['booking_id'].'</td>
								<td width="20%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
								<td width="10%" nowrap>'.$row['start_date'].'</td>
								<td width="10%" nowrap>'.$row['end_date'].'</td>
								<td width="10%" nowrap>'.$bsiCore->currency_symbol().$row['total_cost'].'</td>
								<td width="10%" nowrap>'.$row['booking_time'].'</td>
								<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap">
									<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'&hotel_id='.base64_encode($hotelid).'">View Details</a> | 
									<a href="javascript:;" onclick="myPopup2(\''.$row['booking_id'].'\');">Print Voucher</a> |  
									<a href="javascript:;" onclick="return cancel(\''.$row['booking_id'].'\');">Cancel</a>
								</td>
							  </tr>';
				}
			
			
			}
			
			$fp = fopen('../data/csvs/bookings.csv', 'w');
		
		foreach ($data as $line ) {
			$val = explode(";", $line);
			fputcsv($fp, $val);
		}  
		fclose($fp);
		}
		
		if($type == 5){
		$data = array();
		$csv_datas = "Booking ID ; Name ; Check In ; Check Out ; Amount ; Booking Date";
		array_push($data,$csv_datas);
		$fp = '';
			$html = '<thead>
						  <th width="10%" nowrap><strong>Booking ID</strong></th>
						  <th width="20%" nowrap><strong>Name</strong></th>
						  <th width="10%" nowrap><strong>Check In</strong></th>
						  <th width="10%" nowrap><strong>Check Out</strong></th>
						  <th width="10" nowrap><strong>Amount</strong></th>
						  <th width="10%" nowrap><strong>Booking Date</strong></th>
						  <th width="30%" nowrap>&nbsp;</th>
					  </thead>
					  <tbody>';
			$result = mysql_query($query);
			if(mysql_num_rows($result)){
				$exist = true;
				while($row = mysql_fetch_assoc($result)){
					$clientArr = $this->getClientInfo($row['client_id']);
					$html .= '<tr>
								<td width="10%" nowrap>'.$row['booking_id'].'</td>
								<td width="20%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
								<td width="10" nowrap>'.$row['start_date'].'</td>
								<td width="10%" nowrap>'.$row['end_date'].'</td>
								<td width="10%" nowrap>'.$bsiCore->currency_symbol().$row['total_cost'].'</td>
								<td width="10" nowrap>'.$row['booking_time'].'</td>
								<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap">
									<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'&hotel_id='.base64_encode($hotelid).'">View Details</a> | 
									<a href="javascript:;" onclick="myPopup2(\''.$row['booking_id'].'\');">Print Voucher</a> |  
									<a href="javascript:;" onclick="return deleteBooking(\''.$row['booking_id'].'\');">Delete</a>
								</td>
							  </tr>';
				}	
			
			}
			
			
		$fp = fopen('../data/csvs/bookings.csv', 'w');
		
		foreach ($data as $line ) {
			$val = explode(";", $line);
			fputcsv($fp, $val);
		}  
		fclose($fp);
		}
		//$hoteldatacsv=$this->getHotelDetails($hotelid);
		$html .= '</tbody>'; 
		$returnValue['exist']=$exist;
		$returnValue['html']=$html;
		
		return $returnValue;
	 }
	 
	 public function getCustomerHtml(){
		$html = '';
		$result = mysql_query("select * from bsi_clients");
		while($row = mysql_fetch_assoc($result)){
			$html .= '<tr><td width="25%">'.$row['title']." ".$row['first_name']." ".$row['surname'].'</td>
			
			<td width="25%">'.$row['phone'].'</td><td width="25%">'.$row['email'].'</td><td width="25%" align="right"><a href="customerbooking.php?client='.base64_encode($row['client_id']).'">View Bookings</a>&nbsp;&nbsp;| <a href="customerlookupEdit.php?update='.base64_encode($row['client_id']).'"> Edit</a></td></tr>';
		}
		return $html;
	}
	
	//fetchClientBookingDetails
	public function fetchClientBookingDetails($clientid){
		global $bsiCore;
		$html   = '<tbody>';
	  	$query  = $this->getBookingInfo(3, 0, $clientid);
		$result = mysql_query($query);
      	while($row =  mysql_fetch_assoc($result)){
			$client_info=mysql_fetch_assoc(mysql_query("select * from bsi_clients where client_id=".$clientid));
			if($row['checkout_date'] >= date('Y-m-d') && $row['is_deleted'] == 0 && $row['is_block'] == 0){
				$status = '<font color="#00CC00"><b>Active</b></font>';	
				$option = '<a href="javascript:;" onclick="return cancel(\''.$row['booking_id'].'\');" class="bodytext"> Cancel</a>'; 	
			}elseif($row['checkout_date'] < date('Y-m-d') && $row['is_deleted'] == 0 && $row['is_block'] == 0){
				$status = '<font color="#0033FF"><b>Departed</b></font>';
				$option = '<a href="javascript:;" onclick="javascript:booking_delete(\''.$row['booking_id'].'\');" class="bodytext"> Delete forever</a>';	
			}else{
				$status = '<font color="#FF0000"><b>Cancelled</b></font>';
				$option = '<a href="javascript:;" onclick="javascript:booking_delete(\''.$row['booking_id'].'\');" class="bodytext"> Delete forever</a>';	
			}
			  $html .= '<tr class="gradeX">  
				<td align="left">'.$row['booking_id'].'</td>
				<td align="left" nowrap="nowrap">'.$client_info['title']." ". $client_info['first_name']." ".$client_info['surname'].'</td>
				<td align="left">'.$row['start_date'].'</td>
				<td align="left">'.$row['end_date'].'</td>
				<td align="left">'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
				<td align="left">'.$row['booking_time'].'</td>
				<td align="left">'.$status.'</td>
				<td align="right" nowrap="nowrap"><a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&client='.base64_encode($clientid).'" class="bodytext">View Details</a>&nbsp;&nbsp;|<a  href="javascript:;" onclick="javascript:myPopup2(\''.$row['booking_id'].'\');" class="bodytext"> Print Voucher</a>&nbsp;&nbsp;|'.$option.'</td>
			  </tr>';
       }
	   $html .= '</tbody>';	
	   return $html;
	}
	
	public function booking_cencel_delete($type){
		global $bsiCore;
		global $bsiMail;
		switch($type){ 
			case 1:
				$bsiMail = new bsiMail();
				mysql_query("update bsi_bookings set is_deleted=true where booking_id='".$bsiCore->ClearInput($_REQUEST['cancel'])."'");
				$cust_details = mysql_fetch_assoc(mysql_query("select * from bsi_invoice where booking_id='".$bsiCore->ClearInput($_REQUEST['cancel'])."'"));
				$email_details = mysql_fetch_assoc(mysql_query("select * from bsi_email_contents where id=2"));
				$cancel_emailBody="Dear ".$cust_details['client_name']."<br>";
				$cancel_emailBody.=html_entity_decode($email_details['email_text'])."<br>";
				$cancel_emailBody.="<b>Your Booking Details:</b><br>".$cust_details['invoice']."<br>";
				$cancel_emailBody.="<b>Regards</b><br>".$bsiCore->config['conf_portal_name']."<BR>".$bsiCore->config['conf_portal_phone']."<br>";
				$bsiMail->sendEMail($cust_details['client_email'], $email_details['email_subject'], $cancel_emailBody);
				
			break;
			
			case 2:
				mysql_query("delete from  bsi_bookings where booking_id='".$bsiCore->ClearInput($_REQUEST['delid'])."'");
				mysql_query("delete from  bsi_reservation where booking_id='".$bsiCore->ClearInput($_REQUEST['delid'])."'");
				mysql_query("delete from  bsi_invoice where booking_id='".$bsiCore->ClearInput($_REQUEST['delid'])."'");
			break;
			
			case 3:   
		
			$bsiMail = new bsiMail();
			
			$emailContent=$bsiCore->loadEmailContent(1);              
			$subject    = $emailContent['subject'];
			
			mysql_query("UPDATE bsi_bookings SET status=false WHERE booking_id = ".$bsiCore->ClearInput($_REQUEST['active']));
			//mysql_query("UPDATE bsi_clients SET existing_client = 1 WHERE email = '".$bookprs->clientEmail."'");		
			$cust_details = mysql_fetch_assoc(mysql_query("select * from bsi_invoice where booking_id=".$bsiCore->ClearInput($_REQUEST['active'])));
			$emailBody  = "Dear ".$cust_details['client_name'].",<br>";
			$emailBody  = "Your Booking Confirmation No- ".$_POST['confirmation_code']."<br><br>";
			$emailBody .= $emailContent['body']."<br><br>";  
			$emailBody .= $cust_details['invoice'];
			$emailBody .= '<br><br>Regards,<br>'.$bsiCore->config['conf_portal_name'].'<br>'.$bsiCore->config['conf_portal_phone']."<br>";
			
			
			$returnMsg = $bsiMail->sendEMail($cust_details['client_email'], $subject, $emailBody);
			 if($returnMsg == true) {		
		$notifyEmailSubject = "Notification of Room  Booking by ".$cust_details['client_name'];				
		$notifynMsg = $bsiMail->sendEMail($bsiCore->config['conf_portal_email'], $notifyEmailSubject, $cust_details['invoice']); 
		
	}
		break;
		   
		}	
	}
	
	//getCustomerLookup
	public function getCustomerLookup($cid){
		global $bsiCore;
		$result = mysql_query("select * from bsi_clients where client_id=".$bsiCore->ClearInput($cid));
		$customerarray=mysql_fetch_assoc($result);
		return $customerarray;
		
	}
	
	public function getTitle($title){
		$html  = '<select name="title" id="title">';
		$titleArray =array("Mr" => "Mr.", "Mrs" => "Mrs.", "Ms" => "Ms.", "Dr" => "Dr.", "Miss" => "Miss.", "Prof" => "Prof.");
		foreach($titleArray as $key => $value){
			if($title == $key){
				$html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
			}else{
				$html .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		$html .= '</select>'; 
		return $html; 
	}	
	
	//updateCustomerLookup
	public function updateCustomerLookup(){
		$title = mysql_real_escape_string($_POST['title']);
		$fname = mysql_real_escape_string($_POST['fname']);
		$sname = mysql_real_escape_string($_POST['sname']);
		$sadd = mysql_real_escape_string($_POST['sadd']);
		$city = mysql_real_escape_string($_POST['city']);
		$province = mysql_real_escape_string($_POST['province']);
		$zip = mysql_real_escape_string($_POST['zip']);
		$country = mysql_real_escape_string($_POST['country_code']);
		$phone = mysql_real_escape_string($_POST['phone']);
		$fax = mysql_real_escape_string($_POST['fax']);
		$email = mysql_real_escape_string($_POST['email']);
		$cid = mysql_real_escape_string($_POST['cid']);
		mysql_query("update bsi_clients set first_name='".$fname."', surname='".$sname."', title='".$title."', street_addr='".$sadd."', city='".$city."', province='".$province."', zip='".$zip."', country='".$country."', phone='".$phone."', email='".$email."' where client_id=".$cid);	
	}	
	
	public function combobox($selected = 0){
		$html = '<select name="minbooking" id="minbooking">';
		for($i=1; $i<=10;$i++){
			if($selected == $i){
				$html .= '<option selected="selected" value="'.$i.'">'.$i.'</option>';
			}else{
				$html .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
		
	public function combobox_room($selected = 0){
		$html = '<select id="rooms" name="rooms">';
		for($i=1; $i<=10;$i++){
			if($selected == $i){
				$html .= '<option selected="selected" value="'.$i.'">'.$i.'</option>';
			}else{
				$html .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	
	public function combobox_adult($selected = 2){
		$html = '<select id="adults" name="adults">';
		for($i=1; $i<=10;$i++){
			if($selected == $i){
				$html .= '<option selected="selected" value="'.$i.'">'.$i.'</option>';
			}else{
				$html .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	} 
		
	public function showbsiAdmin(){
	          global $bsiCore;
			  $gethtml='<thead><tr>
							<th>Name</th>
							<th>Email</th>
							<th>User Name</th>
							<th>Designation</th>
							<th>Last Login</th>
							<th>Status</th>
							<th>&nbsp;</th>
						</tr></thead>';
			   $sql=mysql_query("select DATE_FORMAT(last_login, '".$bsiCore->userDateFormat."') AS login_date,DATE_FORMAT(last_login, '%h:%i:%s') AS login_time, f_name, l_name, email, username, designation, status, id, access_id from bsi_admin");
		   
		   if(mysql_num_rows($sql)){
			   while($row=mysql_fetch_assoc($sql)){
				   if($row['status'] == 1){
					   $status='<font color="#009900"><b>Enabled</b></font>';
				   }else{
					  $status='<font color="#FF0000"><b>Disabled</b></font>'; 
				   }
				   if($row['access_id'] == 1){
					   $gethtml.= '<tbody><tr>
								<td align="left">'.$row['f_name'].' '. $row['l_name'].'</td>
								<td align="left">'.$row['email'].'</td>
								<td align="left">'.$row['username'].'</td>
								<td align="left">'.$row['designation'].'</td>
								<td align="left">'.$row['login_date'].'&nbsp; '.$row['login_time'].'</td>
								<td align="left">'.$status.'</td>
								<td align="right">
									<a href="add_new_user.php?id='.base64_encode($row['id']."|".$row['access_id']).'&addedit=1" class="bodytext">Edit</a>'.'
								</td>
							</tr></tbody>';
				   }else{
					   $gethtml.= '<tr>
								<td align="left">'.$row['f_name'].' '. $row['l_name'].'</td>
								<td align="left">'.$row['email'].'</td>
								<td align="left">'.$row['username'].'</td>
								<td align="left">'.$row['designation'].'</td>
								<td align="left">'.$row['login_date'].'&nbsp; '.$row['login_time'].'</td>
								<td align="left">'.$status.'</td> 
								<td align="right">
									<a href="add_new_user.php?id='.base64_encode($row['id']."|".$row['access_id']).'&addedit=1" class="bodytext">Edit</a>'.' | 
									<a href="user_list.php?id='.base64_encode($row['id']).'" class="bodytext"> Delete</a> 
								</td>
							</tr>';
				   }				   
			   }
			   
		   }
	return $gethtml;
}
	public function bsiEditupdate($id){
		global $bsiCore;
		$choose        = array();
		if(isset($_POST['status'])){
			$status=mysql_real_escape_string($_POST['status']);	
		}else{
			$status=0;
		}
		$accessid      = mysql_real_escape_string($_POST['accessid']);
		$password      = mysql_real_escape_string($_POST['pass']);
		$username      = mysql_real_escape_string($_POST['uname']);
		$fname         = mysql_real_escape_string($_POST['fname']);
		$lname         = mysql_real_escape_string($_POST['lname']);
		$email         = mysql_real_escape_string($_POST['email']);
		$designation   = mysql_real_escape_string($_POST['designation']);	
		$choose        = $_POST['choose'];
			
		if($id){
			if($accessid == 1){
				if($password == ""){
					mysql_query("update bsi_admin set f_name='".$fname."', l_name='".$lname."', username='".$username."', email='".$email."', 	status='".$status."' where id='".$id."'");
				}else{
					mysql_query("update bsi_admin set pass='".md5($password)."', f_name='".$fname."', l_name='".$lname."', username='".$username."', email='".$email."',	status='".$status."' where id='".$id."'");
				}
			}else{
				if($password == ""){
					mysql_query("update bsi_admin set f_name='".$fname."', l_name='".$lname."',  username='".$username."', email='".$email."', designation='".$designation."',	status='".$status."' where id='".$id."'");
				}else{
					mysql_query("update bsi_admin set pass='".md5($password)."', f_name='".$fname."', l_name='".$lname."', username='".$username."', email='".$email."',	designation='".$designation."',status='".$status."' where id='".$id."'");				
				}
				mysql_query("delete from bsi_user_access where user_id=".$id);					
				//Header Menu Insert				
				$mainMenu = mysql_query("select * from bsi_adminmenu where parent_id=0 and status='Y' order by ord");
				while($rowMenu  = mysql_fetch_assoc($mainMenu)){ 
					mysql_query("insert into bsi_user_access (user_id, menu_id) values (".$id.", ".$rowMenu['id'].")");	
				}
				//Header Menu Insert Completed
				if(!empty($choose)){
					foreach($choose as $key => $menuid){
						mysql_query("insert into bsi_user_access (user_id, menu_id) values (".$id.", ".$menuid.")");
						$result = mysql_query("select * from bsi_adminmenu where parent_id='".$menuid."' and status='Y' order by ord");
						if(mysql_num_rows($result)){
							while($rowSubMenu = mysql_fetch_assoc($result)){
								mysql_query("insert into bsi_user_access (user_id, menu_id) values (".$id.", ".$rowSubMenu['id'].")");
							}
						}
					}							
				}
			}	
			$_SESSION['httpRefferer'] = $_POST['httpRefferer'];
		}else{ 
			$search = mysql_query("select * from bsi_admin where username='".$username."' or email='".$email."'");
			if(mysql_num_rows($search)){
				$_SESSION['logmsg'] = "User name or Email id Already Exists";
				header("location:user_list.php");
				exit;
			}else{  //If Id is 0 then this part will activate	
				$password = md5(mysql_real_escape_string($_POST['pass']));
				mysql_query("INSERT INTO `bsi_admin` ( `pass`, `username`, `access_id`, `f_name`, `l_name`, `email`, `designation`, `status`) VALUES ( '".$password."', '".$username."', '0', '".$fname."', '".$lname."', '".$email."', '".$designation."', '".$status."')");
				$insertid = mysql_insert_id();				
				//Header Menu Insert				
				$mainMenu = mysql_query("select * from bsi_adminmenu where parent_id=0 and status='Y' order by ord");				
				while($rowMenu  = mysql_fetch_assoc($mainMenu)){ 
					mysql_query("insert into bsi_user_access (user_id, menu_id) values (".$insertid.", ".$rowMenu['id'].")");	
				}
				//Header Menu Insert Completed
				if(!empty($choose)){	
					foreach($choose as $key => $menuid){
						mysql_query("insert into bsi_user_access (user_id, menu_id) values (".$insertid.", ".$menuid.")");
						$result = mysql_query("select * from bsi_adminmenu where parent_id='".$menuid."' and status='Y' order by ord");
						if(mysql_num_rows($result)){
							while($rowSubMenu = mysql_fetch_assoc($result)){
								mysql_query("insert into bsi_user_access (user_id, menu_id) values (".$insertid.", ".$rowSubMenu['id'].")");
							}
						}
					}		
				}
				$_SESSION['httpRefferer'] = $_POST['httpRefferer'];
			}
		}
	}
	
	
	//getmenuListGenerate
	public function getmenuListGenerate($id=0){
		
		$menuListHtml = '';
	     $menuList = mysql_query("select * from bsi_adminmenu where parent_id=0 and status='Y' order by ord");
	 	if(mysql_num_rows($menuList)){
			$i7=-1;
	 		while($row=mysql_fetch_assoc($menuList)){
				if($row['url'] == 'admin-home.php'){
					$menuListHtml .= '';
				}else{
					 $menuListHtml.='<br><fieldset name="adminmenu" id="fs-'.$i7.'">
					 					<legend ><input type="checkbox"  id="ca-'.$i7.'" />
											<strong>'.$row['name'].'</strong>
										</legend>'; 
					 $childMenu = mysql_query("select * from bsi_adminmenu where parent_id='".$row['id']."' and status='Y' order by ord"); 
					if(mysql_num_rows($childMenu)){
						$menuListHtml.='<table cellpadding="3" cellspacing="0" border="0" class="bodytext"><tr>';
						$flag=0;
						while($row2=mysql_fetch_assoc($childMenu)){
							$selectSql = mysql_query("select access_id from bsi_user_access where user_id=$id and menu_id=".$row2['id']);
													
							if(mysql_num_rows($selectSql)){
								$menu   = 'checked="checked"';									
							}else{
								$menu   = '';
							}
								
							if($flag != 3){								
								$menuListHtml.='<td style="padding:0 0 5px 20px;" width="260px"><div><table><tr><td>'.$row2['name'].'</td><td width="50px"><input type="checkbox" name="choose[]" id="access_" value="'.$row2['id'].'" '.$menu.' /></td></tr></table></div></td>';
								$flag++;
							}else{
								$menuListHtml.='</tr><br/><tr>';
								$flag=0;
								$menuListHtml.='<td style="padding:0 0 5px 20px;" width="260px"><div><table><tr><td>'.$row2['name'].'</td><td width="50px"><input type="checkbox" name="choose[]" id="access_" value="'.$row2['id'].'" '.$menu.' /></td></tr></table></div></td>';
								$flag++;
							}
						}
						$menuListHtml.='</tr></table></fieldset>';
					}
				}	
				$menuListHtml.='<br/>';	
				$i7++;				  
			}
		}
		
		return $menuListHtml;
		
	}
	
	//edit bsiadmin
	public function bsiAdminedit($id){
		global $bsiCore;
		if($id != 0){
			$selectedrecord=mysql_fetch_assoc(mysql_query("select * from bsi_admin where id='".$id."'"));
		}
		return $selectedrecord;	
	}
	
	//Page Access Check For User
 public function pageAccess($uid, $pageid){
  global $bsiCore;
  $num  = mysql_num_rows(mysql_query("select * from bsi_user_access where menu_id='".$pageid."' and user_id=$uid"));
  if(!$num){
	$_SESSION['ACCESS DENIED'] = '<table align="center"><tr><td><font style="font-family:\'Comic Sans MS\', cursive; font-size:24px; color:#F00;">ACCESS DENIED</font></td></tr></table>';
   header("location:admin-home.php");
   exit;
  }
 }
 
 public function getBsiNewsletter(){
	 $getHtml = '';
	 $newsletterresult = mysql_query("select id,email,emailTime from bsi_newsletter");
	        while($newsrow = mysql_fetch_assoc($newsletterresult)){
				$getHtml.='<tr class="gradeX"><td nowrap="nowrap">'.$newsrow['id'].'</td> 
						   <td nowrap="nowrap">'.$newsrow['email'].'</td> 
						   <td>'.date('d-m-y',strtotime($newsrow['emailTime'])).'</td>
						   <td align="right" nowrap="nowrap">
								<a href="javascript:;" onclick="return email_delete(\''.$newsrow['id'].'\');">Delete</a>
						   </td>
					   </tr>';  
				
			}     
			return $getHtml; 
	 } 
	 
	 public function email_delete(){
		 global $bsiCore;
		$delid=$bsiCore->ClearInput($_REQUEST['delid']);
		if(isset($delid)){
			mysql_query("delete from `bsi_newsletter` where `id`=".$delid);
		}
		 
	 }
	 
	 public function getHotelDetails($id){
		     global $bsiCore;
			// echo "select * from bsi_hotels where hotel_id='".$id."'";
			 $hdetails = mysql_fetch_assoc(mysql_query("select * from bsi_hotels where hotel_id='".$id."'"));
			 return $hdetails;
	}
	
	 public function getCapacityDetails($id){
		     global $bsiCore;
			 //echo "select * from bsi_capacity where hotel_id='".$id."'";
			 $capacitylist = mysql_query("select * from bsi_capacity where hotel_id='".$id."'");
			 return $capacitylist;
	}
	
	 public function getRoomtypeDetails($id){
		     global $bsiCore;
			 //echo "select * from bsi_capacity where hotel_id='".$id."'";
			 $roomtypelist = mysql_query("select * from bsi_roomtype where hotel_id='".$id."'");
			 return $roomtypelist;
	}
	
	public function getRoomDetails($id){
		     global $bsiCore;
			 //echo "select * from bsi_capacity where hotel_id='".$id."'";
			 $getroomtype = mysql_query("select br.*, brt.type_name, bc.capacity, 
												bc.title, count(*) as totalroom from bsi_room br, 
												bsi_roomtype brt, bsi_capacity bc 
												where br.roomtype_id=brt.roomtype_id and 
												br.capacity_id=bc.capacity_id and 
												br.hotel_id=".$id." 
												group by `roomtype_id`,`capacity_id`, `no_of_child`");
			 return $getroomtype;
	}
	
	// Admin Room Blocking
	public function getBlockRoomDetails($hotelid=0){
		global $bsiCore;
		$cur_date  = date('Y-m-d');
		$getHtml='';
		$result=mysql_query("SELECT br.booking_id, DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS StartDate, DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS EndDate, br.roomtype_id, brt.type_name, br.room_id, brm.capacity_id, count(*) as NoOfRoom from bsi_reservation br, bsi_bookings bb, bsi_roomtype brt, bsi_room brm where br.booking_id=bb.booking_id and bb.is_block=1 and br.roomtype_id=brt.roomtype_id and br.room_id=brm.room_id and bb.hotel_id=".$hotelid." and bb.checkin_date>='$cur_date' group by br.roomtype_id, br.booking_id, brm.capacity_id");
		if(mysql_num_rows($result)){
			while($row=mysql_fetch_assoc($result)){
				$row_capacity_title=mysql_fetch_assoc(mysql_query("SELECT bc.title from bsi_capacity bc, bsi_room br where br.capacity_id=bc.capacity_id and br.room_id='".$row['room_id']."'"));
				$getHtml.='<tr><td align="center" >'.$row['StartDate']."-".$row['EndDate'].'</td><td align="center" >'.$row['type_name']."(".$row_capacity_title['title'].')</td><td align="center" >'.$row['NoOfRoom'].'</td><td ><a href="'.$_SERVER['PHP_SELF'].'?action=unblock&bid='.$row['booking_id'].'&rti='.$row['roomtype_id'].'&cid='.$row['capacity_id'].'&hid='.$hotelid.'">Un-Block</a></td></tr>';
			}
		}else{
			$getHtml.='<tr><td colspan="4" align="center">No Block Room Found</td></tr>';
		}
		return $getHtml;
	}
	
	public function getYearcombo($yearselected){
		$year = '<select name="year" id="year">';
		$time = time();
		$current_year = date("Y", $time);
		
		for($i = $current_year; $i <= ($current_year+5); $i++){
			if($i == $yearselected){
				$year .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			}else{
				$year .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$year .= '</select>';
		return $year;
	}
	
	public function getRoomtypeCal($hotelid=0, $id=0){
		$roomtype = '<select name="roomtype" id="roomtype"><option value="0">All RoomType</option>';
		$result = mysql_query("select * from bsi_roomtype where hotel_id=".$hotelid);
		while($roomtypeRow=mysql_fetch_assoc($result)){
			if($roomtypeRow['roomtype_id'] == $id)
				$roomtype .='<option value="'.$roomtypeRow['roomtype_id'].'" selected="selected">'.$roomtypeRow['type_name'].'</option>';
			else
				$roomtype .='<option value="'.$roomtypeRow['roomtype_id'].'">'.$roomtypeRow['type_name'].'</option>';
		}
		$roomtype .= '</select>';
		return $roomtype;
	}
	
	public function getdaysName(){	
			$html = '';
		for($i=0; $i<5; $i++){
			$html .= '<td align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>Su</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Mo</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Tu</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>We</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Th</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Fr</strong></td>
					  <td align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>Sa</strong></td>';
		}
		
			$html .= '<td align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>Su</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Mo</strong></td>';
		return $html;
	}
	
	//hotelname
  public function hotelname($hid=0){			
			$hotel = '<option value=""></option>';
			$hotelSql = "select * from `bsi_hotels`";
			$result = mysql_query($hotelSql) or die("Error at line : 370".mysql_error());
			while($hotelRow=mysql_fetch_assoc($result)){
				if($hotelRow['hotel_id'] == $hid)
					$hotel .="<option value='".$hotelRow['hotel_id']."' selected='selected'>".$hotelRow['hotel_name']."</option>";
				else
					$hotel .="<option value='".$hotelRow['hotel_id']."'>".$hotelRow['hotel_name']."</option>";
			}
			
			return $hotel;
		}
		
		public function getHotelFacility(){ 
		$sqlaround = mysql_query("SELECT * FROM `bsi_hotel_facilities` WHERE hotel_id =".$_SESSION['hhid']);
		if(mysql_num_rows($sqlaround)){
			$getAroundList = "";
			while($rowAround=mysql_fetch_assoc($sqlaround)){
				$getAroundList .='<tr class="gradeX"><td valign="top" align="justify">'.$rowAround['general'].'</td><td valign="top" align="justify">'.$rowAround['activities'].'</td><td valign="top" align="justify">'.$rowAround['services'].'</td><td align="right" style="padding-right:15px;" valign="top" nowrap><a href="hotel_facility_entry.php?id='.base64_encode($rowAround['facilities_id']).'&addedit=1">'.EDIT.'</a> | <a href="javascript:;" onclick="javascript:capacity_delete('.$rowAround['facilities_id'].');">'.DELETE.'</a></td></tr>';		
			}
			return $getAroundList;
		}
	}
	
	public function getPricePlanRow($r_id,$dvalue,$startdate,$enddate){
		global $bsiCore;
		//$res= "SELECT bp.*, date_format(bp.date_start, '".$bsiCore->userDateFormat."') as startdate, date_format(bp.date_end, '".$bsiCore->userDateFormat."') as enddate, bc.title,bc.capacity_id FROM bsi_priceplan bp, bsi_capacity bc where bp.capacity_id=bc.capacity_id and bp.room_type_id='".$r_id."' and bp.default='".$dvalue."' and bp.date_start='".$startdate."' and bp.date_end='".$enddate."'";	
		
		$res= "SELECT bp.*, date_format(bp.date_start, '".$bsiCore->userDateFormat."') as startdate, date_format(bp.date_end, '".$bsiCore->userDateFormat."') as enddate FROM bsi_priceplan bp where  bp.room_type_id='".$r_id."' and bp.default='".$dvalue."' and bp.date_start='".$startdate."' and bp.date_end='".$enddate."'";	
		return $res;
	}  
		
	public function getPriceplanEditFrm1($ro_ppresss){
		global $bsiCore;
		$gethtml='';
		$result = mysql_query($ro_ppresss);
		if(mysql_num_rows($result)){
			while($ro_pp=mysql_fetch_assoc($result)){
		$gethtml.='<tr> 
			<td style="width:200px; padding:5px !important;">&nbsp;&nbsp;&nbsp;&nbsp;'.$ro_pp['title'].'<input type="hidden" value="'.$ro_pp['priceplan_id'].'" name="pp_id['.$ro_pp['capacity_id'].']" /></td> 									 
			<td style="padding:5px !important;">'.$bsiCore->config['conf_currency_symbol'].'<input type="text" style="width:70px;" name="sun['.$ro_pp['priceplan_id'].']" id="sun" value="'.$ro_pp['sun'].'" class="number" /> </td> 
			<td style="padding:5px !important;">'.$bsiCore->config['conf_currency_symbol'].'<input type="text" style="width:70px;" name="mon['.$ro_pp['priceplan_id'].']" id="mon" value="'.$ro_pp['mon'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$bsiCore->config['conf_currency_symbol'].'<input type="text" style="width:70px;"  name="tue['.$ro_pp['priceplan_id'].']" id="tue" value="'.$ro_pp['tue'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$bsiCore->config['conf_currency_symbol'].'<input type="text" style="width:70px;" name="wed['.$ro_pp['priceplan_id'].']" id="wed" value="'.$ro_pp['wed'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$bsiCore->config['conf_currency_symbol'].'<input type="text" style="width:70px;"  name="thu['.$ro_pp['priceplan_id'].']" id="thu" value="'.$ro_pp['thu'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$bsiCore->config['conf_currency_symbol'].'<input type="text" style="width:70px;" name="fri['.$ro_pp['priceplan_id'].']" id="fri" value="'.$ro_pp['fri'].'" class="number"/> </td>  
			<td style="padding:5px !important;">'.$bsiCore->config['conf_currency_symbol'].'<input type="text" style="width:70px;" name="sat['.$ro_pp['priceplan_id'].']" id="sat" value="'.$ro_pp['sat'].'" class="number"/> </td> 
			<td style="padding:5px !important;">'.$bsiCore->config['conf_currency_symbol'].'<input type="text" style="width:70px;" name="extrabed['.$ro_pp['priceplan_id'].']" id="extrabed" value="'.$ro_pp['extrabed'].'" class="number"/> </td>  
			</tr>';
			}
		}
		$gethtml.='<tr><td colspan="2"><font style="color:#F00;">* &nbsp;&nbsp;</font><b>This Field is required</b><br /><font style="color:#F00;">** &nbsp;</font><b>Only Numbers</b></td><td colspan="7">&nbsp;</td></tr>';
			
			return $gethtml;
	}
		
	public function UpdateAndInsertPriceplan(){//function start
		global $bsiCore;
		$pricearray = array();
		
		if(isset($_POST['pp_id'])){//if start
			foreach($_POST['pp_id'] as $k1 => $v1){
				$pricearray[$v1] = array();
				$pricearray[$v1] = array("hotelid" => mysql_real_escape_string($_POST['hotelid']), "room_type" => mysql_real_escape_string($_POST['room_type']), "capacityid" => $k1, "startDate" => $bsiCore->getMySqlDate(mysql_real_escape_string($_POST['startdate'])), "endDate" => $bsiCore->getMySqlDate(mysql_real_escape_string($_POST['enddate'])), "sun" => mysql_real_escape_string($_POST['sun'][$v1]), "mon" => mysql_real_escape_string($_POST['mon'][$v1]), "tue" => mysql_real_escape_string($_POST['tue'][$v1]), "wed" => mysql_real_escape_string($_POST['wed'][$v1]), "thu" => mysql_real_escape_string($_POST['thu'][$v1]), "fri" => mysql_real_escape_string($_POST['fri'][$v1]), "sat" => mysql_real_escape_string($_POST['sat'][$v1]),"extrabed" => mysql_real_escape_string($_POST['extrabed'][$v1]));		
			}
			
			if($_POST['default1']){
				if(!empty($pricearray)){
					foreach($pricearray as $key => $value){
						mysql_query("update bsi_priceplan set sun='".$pricearray[$key]['sun']."', mon='".$pricearray[$key]['mon']."', tue='".$pricearray[$key]['tue']."', wed='".$pricearray[$key]['wed']."', thu='".$pricearray[$key]['thu']."', fri='".$pricearray[$key]['fri']."', sat='".$pricearray[$key]['sat']."', extrabed='".$pricearray[$key]['extrabed']."' where priceplan_id=".$bsiCore->ClearInput($key));
					}
				}
			}else{
				$startdate = $bsiCore->getMySqlDate(mysql_real_escape_string($_POST['startdate']));
				$enddate   = $bsiCore->getMySqlDate(mysql_real_escape_string($_POST['enddate']));
				$ppid = '';
				foreach($_POST['pp_id'] as $k1 => $v1){
					$ppid .= $v1.",";
				}
				$ppid = substr($ppid, 0, -1);
				$result = mysql_query("select * from `bsi_priceplan` where `hotel_id`='".mysql_real_escape_string($_POST['hotelid'])."' and `room_type_id`='".mysql_real_escape_string($_POST['room_type'])."' and  `priceplan_id` not in ($ppid)  and (('$startdate'  Between `date_start` and `date_end` OR  '$enddate' between `date_start` and `date_end`) OR (`date_start` between '$startdate' and '$enddate' OR `date_end` between '$startdate' and '$enddate'))  group by `room_type_id`");
				if(!mysql_num_rows($result)){
					if(!empty($pricearray)){
						foreach($pricearray as $key => $value){
							mysql_query("delete from bsi_priceplan where priceplan_id='".mysql_real_escape_string($key)."'");	
							mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`, `room_type_id`, `capacity_id`, `date_start`, `date_end`, `sun`, `mon`,  `tue`, `wed`, `thu`, `fri`, `sat`,`extrabed`, `default`) VALUES ('".$pricearray[$key]['hotelid']."', '".$pricearray[$key]['room_type']."', '".$pricearray[$key]['capacityid']."', '$startdate', '$enddate', '".$pricearray[$key]['sun']."', '".$pricearray[$key]['mon']."', '".$pricearray[$key]['tue']."', '".$pricearray[$key]['wed']."', '".$pricearray[$key]['thu']."', '".$pricearray[$key]['fri']."', '".$pricearray[$key]['sat']."','".$pricearray[$key]['extrabed']."', '0')");
						}	
					}			
				}else{
					$_SESSION['error_msg']  = "<font color=\"red\">Date Slot Already Exists.</font>";
				}
			}
			$_SESSION['hotel_id']   = mysql_real_escape_string($_POST['hotelid']);
			$_SESSION['roomtypeid'] = mysql_real_escape_string($_POST['room_type']);	
		}else{
			$hotelid      = mysql_real_escape_string($_POST['hotelid']);
			$roomtypeid   = mysql_real_escape_string($_POST['room_type']);
			$startdate    = $bsiCore->getMySqlDate(mysql_real_escape_string($_POST['startdate']));
			$closingdate  = $bsiCore->getMySqlDate(mysql_real_escape_string($_POST['enddate']));
			$priceplanArr = $_POST['priceplan'];
			$arr1         = array_keys($priceplanArr);
				
			$result = mysql_query("select * from bsi_priceplan where hotel_id='$hotelid' and room_type_id='$roomtypeid' and (('$startdate'  Between date_start and date_end OR  '$closingdate' between date_start and date_end ) OR (date_start between '$startdate' and '$closingdate' OR date_end between '$startdate' and '$closingdate'))  group by room_type_id");
			if(mysql_num_rows($result)){
				$_SESSION['error_msg']  = "<font color=\"red\">Date Slot Already Exists.</font>";
			}else{
				for($i = 0; $i < count($arr1); $i++) {//lopp start	
					$arr2   = array_values($priceplanArr[$arr1[$i]]);			
					mysql_query("INSERT INTO `bsi_priceplan` (`hotel_id`, `room_type_id`, `capacity_id`, `date_start`, `date_end`, `sun`, `mon`,  `tue`, `wed`, `thu`, `fri`, `sat`,`extrabed`, `default`) VALUES ('".$hotelid."','".$roomtypeid."','".$arr1[$i]."', '$startdate', '$closingdate', '".$arr2[0]."', '".$arr2[1]."', '".$arr2[2]."', '".$arr2[3]."', '".$arr2[4]."', '".$arr2[5]."','".$arr2[6]."','".$arr2[7]."', '0')");
					$_SESSION['hotel_id']   = $hotelid;
					$_SESSION['roomtypeid'] = $roomtypeid;
				}
			}
		}	
	}//function end
	//language function start
	public function langauge_setting(){
		global $bsiCore;
		$lang_sql2=mysql_query("select * from bsi_language order by lang_order");
		while($lang_row2=mysql_fetch_assoc($lang_sql2)){
			if($lang_row2['lang_code']==$_POST['lang_default']){
				mysql_query("update bsi_language set status=true, `default`=true, lang_order=".mysql_real_escape_string($_POST['order_'.$lang_row2['lang_code']])." where  lang_code='".$lang_row2['lang_code']."'");
			}else{
				if($lang_row2['status']==true and $lang_row2['default']==true){
				mysql_query("update bsi_language set status=true, `default`=false, lang_order=".mysql_real_escape_string($_POST['order_'.$lang_row2['lang_code']])." where  lang_code='".$lang_row2['lang_code']."'");
				}else{
				mysql_query("update bsi_language set status=".((is_null($_POST['lang_'.$lang_row2['lang_code']])) ? 0 : 1).", `default`=false, lang_order=".mysql_real_escape_string($_POST['order_'.$lang_row2['lang_code']])." where  lang_code='".$lang_row2['lang_code']."'");
				}
			 }
		}
	}	
	//langauge function end 
	
	public function getAllcountry(){ 
		 global $bsiCore;
		 $gethtml222='';
		 $cres=mysql_query("select * from bsi_country");
		 if(mysql_num_rows($cres)){
			 while($row66=mysql_fetch_assoc($cres)){
				 $gethtml222.= '<tr>
								<td align="left">'.$row66['cou_name'].'</td>
								<td align="right">
									<a href="add_new_country.php?c_code='.base64_encode($row66['country_code']).'" class="bodytext">Edit</a>'.' | 
									<a href="country_list.php?delcode='.base64_encode($row66['country_code']).'" class="bodytext"> Delete</a> 
								</td>
							</tr>';
			 }
		 }
		 return $gethtml222;
	}
	
	public function addCountry(){
		global $bsiCore;
		$code=mysql_real_escape_string($_POST['c_cod']);
		$name=mysql_real_escape_string($_POST['c_name']);
		$res33=mysql_query("select * from bsi_country where country_code='".$code."'");
		if(!mysql_num_rows($res33)){
			mysql_query("insert into bsi_country(country_code,name,cou_name)values('".$code."','".strtoupper($name)."','".$name."')");
		}else{
			mysql_query("update bsi_country set name='".strtoupper($name)."',cou_name='".$name."' where country_code='".$code."'");
		}
	}
	
	public function deleteCountry(){
		global $bsiCore;
		$delcode=base64_decode($_GET['delcode']);
		$delcode1=mysql_real_escape_string($delcode);
		mysql_query("delete from bsi_country where country_code='".$delcode1."'");
	}
	
	public function getAllcity(){
		global $bsiCore;
		$gethtml888='';
		 $cres=mysql_query("select * from bsi_city");
		 if(mysql_num_rows($cres)){
			 while($row77=mysql_fetch_assoc($cres)){
			 $row78=mysql_fetch_assoc(mysql_query("select  cou_name from bsi_country  where country_code='".$row77['country_code']."' "));
				 $gethtml888.= '<tr>
								<td align="left">'.$row77['city_name'].'</td>
								<td align="left">'.$row78['cou_name'].'</td>
								<td align="right">
									<a href="add_new_city.php?cid='.base64_encode($row77['cid']).'" class="bodytext">Edit</a>'.' | 
									<a href="city_list.php?delcid='.base64_encode($row77['cid']).'" class="bodytext"> Delete</a> 
								</td>
							</tr>';
			 }
		 }
		 return $gethtml888;
		
	}
	
	public function getCountrydropdown($code=''){
		global $bsiCore;
		$drophtml='';
		$resqry=mysql_query("select * from bsi_country");
		if(mysql_num_rows($resqry)){
			
			while($row89=mysql_fetch_assoc($resqry)){
				if($code == $row89['country_code']){
				   $drophtml.='<option value="'.$row89['country_code'].'" selected="selected">'.$row89['cou_name'].'</option>';
				}else{
					$drophtml.='<option value="'.$row89['country_code'].'">'.$row89['cou_name'].'</option>';
				}
			}
		}
		return $drophtml;
	}
	
	
	public function addCity(){
		global $bsiCore;
		$cid=mysql_real_escape_string($_POST['cid']);
		$code=mysql_real_escape_string($_POST['c_cod']);
		$c_name=mysql_real_escape_string($_POST['city_name']);
		$res33=mysql_query("select * from bsi_country where country_code='".$code."'");
		if($cid == 0){
		
		
		$enable_thumbnails	= 1 ;
			$max_image_size		= 1024000 ;
			
				$upload_dir			= "../gallery/cityImage/"; // default script location, use relative or absolute path
			
			$img_rname = "";
			foreach($_FILES as $k => $v){ 	
				$img_type = "";
				if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
					$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
					$img_rname = time().'_'.$_FILES[$k]['name'];
					$img_path = $upload_dir.$img_rname;
					copy( $_FILES[$k]['tmp_name'], $img_path ); 
					if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,96,96);
				}else{
					$img_rname = "";
				}
			}	
			mysql_query("insert into bsi_city(country_code,city_name,default_img)values('".$code."','".$c_name."','".$img_rname."')");			
		}else{
			$enable_thumbnails	= 1 ;
			$max_image_size		= 1024000 ;
			if($front){
				$upload_dir			= "gallery/cityImage/"; // default script location, use relative or absolute path
			}else{
				$upload_dir			= "../gallery/cityImage/"; // default script location, use relative or absolute path
			}
			$img_rname = "";
			foreach($_FILES as $k => $v){ 	
				$img_type = "";
				if( !$_FILES[$k]['error'] && preg_match("#^image/#i", $_FILES[$k]['type']) && $_FILES[$k]['size'] < $max_image_size ){
					$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
					$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;
					$img_rname = time().'_'.$_FILES[$k]['name'];
					$img_path = $upload_dir.$img_rname;
					copy( $_FILES[$k]['tmp_name'], $img_path ); 
					if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname,96,96);
					
					$delrow = mysql_fetch_assoc(mysql_query("select * from bsi_city where cid=".$cid));
					if(isset($delrow['default_img'])){
						if(file_exists("../gallery/cityImage/".$delrow['default_img'])){
							unlink("../gallery/cityImage/".$delrow['default_img']);
							unlink("../gallery/cityImage/thumb_".$delrow['default_img']);
						}
					}
				}else{
					$img_rname = $pre_img;
				}
			}
			
			  mysql_query("update bsi_city set city_name='".$c_name."',country_code='".$code."'  , default_img='".$img_rname."' where cid=".$cid);
		//	}else{
			//	$_SESSION['err']=89;
		//	}
		}
	}
	
	public function deleteCity(){
		global $bsiCore;
		$delid=base64_decode($_GET['delcid']);
		$delid1=mysql_real_escape_string($delid);
		mysql_query("delete from bsi_city where cid='".$delid1."'");
	}
	
	
	public function add_edit_currency()
	{
		global $bsiCore;
		$id = $bsiCore->ClearInput($_POST['addedit']);
		$currency_code = $bsiCore->ClearInput($_POST['currency_code']);
		$currency_symbl = $bsiCore->ClearInput($_POST['currency_symbol']);
		
		//print_r($_POST);die;
		
			$amount=1;
			$amount = urlencode($amount);
			$from_Currency = urlencode('USD');
			$to_Currency = urlencode($currency_code);
			
			$url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
			
			$ch = curl_init();
			$timeout = 0;
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
			
			curl_setopt ($ch, CURLOPT_USERAGENT,
			"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$rawdata = curl_exec($ch);
			curl_close($ch);
			$data = explode('bld>', $rawdata);
			$data = explode($to_Currency, $data[1]);
			
			$var=round($data[0], 2);
			
			//echo $var;die;
			
		if($var != ""){ 
		
		$reslt = mysql_query("select * from bsi_currency where currency_code = '".$currency_code."'");	
		if(mysql_num_rows($reslt) > 0 &&  $id == 0)
		{
			$_SESSION['msg'] = "This Currency Code Is Already Exists! ";
		}
		else
		{ 
		$default = (isset($_POST['default_c']))? 1:0;
		if($default==1)
		mysql_query("update bsi_currency set default_c=0");  
		
		if($id){
			mysql_query("update bsi_currency set currency_code='$currency_code',exchange_rate='$default', currency_symbl='$currency_symbl', default_c='$default'  where id=".$id);
			
		
		}else{ 
		  
			mysql_query("insert into `bsi_currency` (`currency_code`, `currency_symbl`, `default_c`, exchange_rate) values ('$currency_code','$currency_symbl', '$default', '$default')");  
		
		}
		
	
	
		$bsiCore->getExchangemoney_update();
		}
		}
		else{
			// You enter wrong currency code! 
			$_SESSION['msg'] = "You enter wrong currency code! ";
		}
		
	}
	
	
	public function generatecurrency()
	{
		$clhtml	= '<tbody>';
		$result = mysql_query("select * from bsi_currency");
		while($row = mysql_fetch_assoc($result)){  
			$dflt=($row['default_c'])? 'Yes':'No';
			if($row['default_c']==0){
			$clhtml .= '<tr>
						  <td >'.$row['currency_code'].'</td>
						  <td >'.$row['currency_symbl'].'</td>
						  <td >'.round($row['exchange_rate'],6).'</td>
						  <td >'.$dflt.'</td>			  
						  <td class="center"  align="right"><a href="add_edit_currency.php?id='.$row['id'].'">Edit</a> | <a href="currency_list.php?delid='.$row['id'].'" >Delete</a></td>
						</tr>';
			}else{
				
				$clhtml .= '<tr>
						  <td >'.$row['currency_code'].'</td>
						  <td >'.$row['currency_symbl'].'</td>
						  <td >'.round($row['exchange_rate'],6).'</td>
						  <td >'.$dflt.'</td>			  
						  <td class="center"  align="right"><a href="add_edit_currency.php?id='.$row['id'].'">Edit</a></td>
						</tr>';
			}
		}
		$clhtml .= '</tbody>';
		return $clhtml;
	}
	
	public function delete_currency(){
		global $bsiCore;
		mysql_query("delete from bsi_currency where id=".$bsiCore->ClearInput($_GET['delid']));	
		
	}
	
	
	public function updatePopularHotel(){
		global $bsiCore;
		mysql_query("delete from `bsi_popular_hotel` ");
			foreach($_POST['popularhotel'] as $val){
			//echo "insert into `bsi_popular_hotel` (Hotel_id) values('".$val."')";
			mysql_query("insert into `bsi_popular_hotel` (Hotel_id)  values('".$val."')");  
			
			}//die;
	}
	

	
	public function create_map_json(){
		global $bsiCore;
		$hotel_data_map='';
		$icons=array("marker_h.png","marker_h1.png","marker_h2.png","marker_h3.png","marker_h4.png","marker_h5.png");
		$i89=1;
		$hotel_sql = mysql_query("select * from bsi_hotels where status =1");
		$total_rows89= mysql_num_rows($hotel_sql);
		while($row_hotel = mysql_fetch_assoc($hotel_sql)){  
		if($i89==$total_rows89){
			$hotel_data_map.='{"lat":"'.$row_hotel['latitude'].'", "lng":"'.$row_hotel['longitude'].'", "title":"'.$row_hotel['hotel_name'].'", "street":"'.$row_hotel['address_1'].'", "city":"'.$row_hotel['city_name'].'", "zip":"'.$row_hotel['post_code'].'", "url":"http://feelspark.com/'.$row_hotel['city_name'].'/'.str_replace(" ","-",strtolower(trim($row_hotel['hotel_name']))).'-'.$row_hotel['hotel_id'].'.html", "iconset":"'.$icons[$row_hotel['star_rating']].'"}';
		}else{
			$hotel_data_map.='{"lat":"'.$row_hotel['latitude'].'", "lng":"'.$row_hotel['longitude'].'", "title":"'.$row_hotel['hotel_name'].'", "street":"'.$row_hotel['address_1'].'", "city":"'.$row_hotel['city_name'].'", "zip":"'.$row_hotel['post_code'].'", "url":"http://feelspark.com/'.$row_hotel['city_name'].'/'.str_replace(" ","-",strtolower(trim($row_hotel['hotel_name']))).'-'.$row_hotel['hotel_id'].'.html", "iconset":"'.$icons[$row_hotel['star_rating']].'"},'; 
		}
		$hotel_data_map.="\n";
		$i89++;
		}
		
		$myfile = fopen("../data/json/homepagemap.json", "w") or die("Unable to open file!");
		
		fwrite($myfile, "[\n");
		fwrite($myfile, $hotel_data_map);
		fwrite($myfile, "]");
		fclose($myfile);
		
	}
	
	
	public function hotel_extras(){
			global $bsiCore;
			$eid=$bsiCore->ClearInput($_POST['eid']);
			
			if($eid){
				
				mysql_query("update `bsi_hotel_extras`  set hotel_id='".mysql_real_escape_string($_POST['hotel_id'])."',service_name='".mysql_real_escape_string($_POST['service_name'])."' , service_price='".mysql_real_escape_string($_POST['price'])."' where id='".$eid."'");
				$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']);
			}else{   
				
				mysql_query("INSERT INTO `bsi_hotel_extras`  (`hotel_id`,`service_name`,`service_price` ) VALUES ('".mysql_real_escape_string($_POST['hotel_id'])."', '".mysql_real_escape_string($_POST['service_name'])."' , '".mysql_real_escape_string($_POST['price'])."')");
				$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']);  
			}
		}
	
	
public function extras_delete()
	{ 
		global $bsiCore;
		$delid=$bsiCore->ClearInput($_REQUEST['delid']);
		mysql_query("delete from bsi_hotel_extras where id=".$delid);
		
	} 
	
	
	public function hotel_offer(){
			global $bsiCore;
			$eid=$bsiCore->ClearInput($_POST['eid']); 
			$start_dt = $bsiCore->getMySqlDate($bsiCore->ClearInput($_POST['start_dt']));
			$end_dt = $bsiCore->getMySqlDate($bsiCore->ClearInput($_POST['end_dt'])); 
		if($eid){
			$exist=mysql_query("select * from `bsi_hotel_offer` where (('".$start_dt."' between start_dt and end_dt) or ('".$end_dt."' between start_dt and end_dt) or (start_dt between '".$start_dt."' and '".$end_dt."') or (end_dt between '".$start_dt."' and '".$end_dt."'))  and  hotel_id='".mysql_real_escape_string($_POST['hotel_id'])."' and id not in (".$eid.")");
				
			if(!mysql_num_rows($exist))
			{
				mysql_query("update `bsi_hotel_offer` set hotel_id='".mysql_real_escape_string($_POST['hotel_id'])."',offer_name='".mysql_real_escape_string($_POST['offer_name'])."', minimum_nights='".mysql_real_escape_string($_POST['minimum_nights'])."' , discount_percent='".mysql_real_escape_string($_POST['discount_percent'])."' , start_dt='".$start_dt."' , end_dt='".$end_dt."' where id='".$eid."'");
				$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']); 
			
			}else{$_SESSION['msg']='<font color="#FF0000">Date Slot already Exist</font>';}
			
			
		}else{   
				
				$exist=mysql_query("select * from `bsi_hotel_offer` where (('".$start_dt."' between start_dt and end_dt) or ('".$end_dt."' between start_dt and end_dt) or (start_dt between '".$start_dt."' and '".$end_dt."') or (end_dt between '".$start_dt."' and '".$end_dt."'))  and  hotel_id='".mysql_real_escape_string($_POST['hotel_id'])."'");
			if(!mysql_num_rows($exist))
			{
				mysql_query("INSERT INTO `bsi_hotel_offer` (`hotel_id`,`offer_name`,`discount_percent`,`start_dt`,`end_dt`, minimum_nights ) VALUES ('".mysql_real_escape_string($_POST['hotel_id'])."', '".mysql_real_escape_string($_POST['offer_name'])."' , '".mysql_real_escape_string($_POST['discount_percent'])."','".$start_dt."','".$end_dt."', ".mysql_real_escape_string($_POST['discount_percent']).")");
				$_SESSION['hotel_id']=$bsiCore->ClearInput($_POST['hotel_id']); 
			
			}else{$_SESSION['msg']='<font color="#FF0000">Date Slot already Exist</font>';}
		}

}
		
		
public function offer_delete(){ 
		global $bsiCore;
		$delid=$bsiCore->ClearInput($_REQUEST['delid']);
		mysql_query("delete from `bsi_hotel_offer` where id=".$delid);
} 
	
	
}
?> 