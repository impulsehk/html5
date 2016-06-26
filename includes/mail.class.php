<?php

/**

* @package BSI

* @author BestSoft Inc see README.php

* @copyright BestSoft Inc.

* See COPYRIGHT.php for copyright notices and details.

*/

error_reporting(0);

class bsiMail 

{

	private $isSMTP 		= false;

	private $emailFrom 		= '';

	private $emailReplyTo 	= '';

    private $smtpHost 		= NULL;	

	private $smtpPort 		= NULL;

	private $smtpUserName 	= NULL;			

	private $smtpPassword 	= NULL;

	private $emailTo 		= '';

	private $emailSubject 	= '';

	private $emailBody 		= '';	

	private $attachment		= 0;	

	private $flag           = 0;

	private $filename       ='';	

	public $emailContent	= array();	 	

	

	function bsiMail() {

		global $bsiCore;		

					

		$this->isSMTP = $bsiCore->config['conf_smtp_mail'];	

		if($this->isSMTP == "true"){

			require_once "Mail.php"; 
        
			require_once ('Mail/mime.php');		
  
			$this->emailFrom    = mysql_real_escape_string($bsiCore->config['conf_portal_name'])."<".$bsiCore->config['conf_smtp_username'].">";	

		}else{

			$this->emailFrom    = mysql_real_escape_string($bsiCore->config['conf_portal_name'])."<".$bsiCore->config['conf_portal_email'].">";

		}

		

		$this->emailReplyTo 	= $bsiCore->config['conf_portal_email'];

		$this->smtpHost 		= $bsiCore->config['conf_smtp_host'];

		$this->smtpPort 		= $bsiCore->config['conf_smtp_port'];

		$this->smtpUserName 	= $bsiCore->config['conf_smtp_username'];

		$this->smtpPassword 	= $bsiCore->config['conf_smtp_password'];

		$this->loadEmailContent();	

		if(!$this->smtpPort){

			$this->smtpPort = NULL;

		}			

	}

	

	public function sendEMail($emailTo, $emailSubject, $emailBody, $attachment=0, $flag=0, $admin=0){

		$this->emailTo = $emailTo;

		$this->emailSubject = $emailSubject;

		$this->emailBody = $emailBody;

		if($admin == 1){

			$this->attachment   = '../data/invoice/voucher_'.$attachment.'.pdf';  	 

		}else{

			$this->attachment   = 'data/invoice/voucher_'.$attachment.'.pdf';

		}

		

		$this->filename         = 'voucher_'.$attachment.'.pdf';

		

		if($flag == 1){		

			return (($this->isSMTP == 'true')? $this->sendSMTPMail_withAttachment() : $this->sendPHPMail_withAttachment());				

		}else{

			return (($this->isSMTP == 'true')? $this->sendSMTPMail() : $this->sendPHPMail());

		}

	}

	
	public function sendEMailHotelEntry($emailTo, $emailSubject, $emailBody){
        
		$this->emailTo = $emailTo;

		$this->emailSubject = $emailSubject;

		$this->emailBody = $emailBody;

		return (($this->isSMTP == 'true')? $this->sendSMTPMail() : $this->sendPHPMail());


	}
	

	/* Send Email using PHP Mail Function */	

	public function sendPHPMail(){

		// To send HTML mail, the Content-type header must be set

		$emailHeaders  = 'MIME-Version: 1.0' . "\r\n";

		$emailHeaders .= 'Content-type: text/html; charset=utf-8' . "\r\n";

				

		// Additional headers

		$emailHeaders .= 'reply-to: '.$this->emailReplyTo.'' . "\r\n";

		$emailHeaders .= 'From: '.$this->emailFrom.'' . "\r\n";	

		

		$retmsg = mail($this->emailTo, $this->emailSubject, $this->emailBody, $emailHeaders);		

		// Mail it

		if($retmsg) {

			return true;

		}else{

			return "Failed to sent Message!";

		}

	}

			

	/* Send Email using SMTP authentication */	

	public function sendSMTPMail(){

		$this->emailFrom;

		$emailHeaders = array (

			'From' => $this->emailFrom, 

			'To' => $this->emailTo, 			

			'reply-to' => $this->emailReplyTo, 

			'Subject' => $this->emailSubject,

			'Mime-Version' => "1.0",

			'Content-Type' => "text/html",

			'charset' => "utf-8",

			'Content-Transfer-Encoding' => "7bit");

		$smtpAuthData = array (

			'host' => $this->smtpHost, 

			'port' => $this->smtpPort,

			'auth' => true, 

			'username' => $this->smtpUserName, 

			'password' => $this->smtpPassword);

			

		$smtpMail = Mail::factory('smtp', $smtpAuthData);			

		$smtpMsg = $smtpMail->send($this->emailTo, $emailHeaders, $this->emailBody);

		if (PEAR::isError($smtpMail)) {

			return $smtpMail->getMessage();

		}else {

			return true;

		}	

	} 

	//Email Sending with attachments through smtp

	

	public function sendSMTPMail_withAttachment(){		

		$from = $this->emailFrom;

		$to = $this->emailTo;

		$subject = $this->emailSubject;

		$headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);

		$file = $this->attachment; // attachment 

		$crlf = "\n";

		

		$mime = new Mail_mime($crlf);

		$mime->setHTMLBody($this->emailBody);

		$mime->addAttachment($file, 'text/plain');

		

		//do not ever try to call these lines in reverse order

		$body = $mime->get();

		$headers = $mime->headers($headers);

		

		$host     = $this->smtpHost;

		$port     = $this->smtpPort;

		$username = $this->smtpUserName;

		$password = $this->smtpPassword;

		

		$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true,

		'username' => $username,'password' => $password));

		

		$mail = $smtp->send($to, $headers, $body);

			

		

		if (PEAR::isError($mail)) {

			return $mail->getMessage();

		}else {

			return true;

		}	

		

	} 

	

	//Email Sending with attachments through php mail

	

	public function sendPHPMail_withAttachment(){

		// To send HTML mail, the Content-type header must be set		

		$files = $this->attachment; // attachment

 		

		// email fields: to, from, subject, and so on

		$to      = $this->emailTo;

		$from    = $this->emailFrom; 

		$subject = $this->emailSubject; 

		$message = $this->emailBody;

		$headers = "From: $from";

		 

		// boundary 

		$semi_rand = md5(time()); 

		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

		 

		// headers for attachment 

		$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

		 

		// multipart boundary 

		$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"utf-8\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 

		$message .= "--{$mime_boundary}\n";

		 

		// preparing attachments

		$file = fopen($files,"rb");

		$data = fread($file,filesize($files));

		fclose($file);

		$data = chunk_split(base64_encode($data));

		$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"".$this->filename."\"\n" . 

		"Content-Disposition: attachment;\n" . " filename=\"".$this->filename."\"\n" . 

		"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";

		$message .= "--{$mime_boundary}\n";

 

	// send

	 

		$ok = @mail($to, $subject, $message, $headers); 

		if ($ok) { 

			return true; 

		} else { 

			return "Failed to sent Message!";

		} 

 

	}

	

	

	private function loadEmailContent() {		

		$sql = mysql_query("SELECT * FROM bsi_email_contents WHERE email_name = 'Confirmation Email'");

		$currentrow = mysql_fetch_assoc($sql);	

		$this->emailContent =  array('subject'=> $currentrow["email_subject"], 'body'=> $currentrow["email_text"]);			

		mysql_free_result($sql);		

	}	
	


}

?>