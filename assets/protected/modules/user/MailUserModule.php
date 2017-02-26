<?php
/**
 * @author Alfred Landik <fkbr1993@yandex.ru> 
 */

class MailUserModule extends UserModule
{
	public static function sendMail($from = "",$to = "",$subject = "",$message = "") {
	
		die("<br>from:$from<br>to:$to<br>subject:$subject<br>message:$message");
	    $headers = "MIME-Version: 1.0\r\nFrom: $from\r\nReply-To: $from\r\nContent-Type: text/html; charset=utf-8";
	    $message = wordwrap($message, 70);
	    $message = str_replace("\n.", "\n..", $message);
	    return mail($to,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}
}
