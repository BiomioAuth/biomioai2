<?php
//Email controller class


//require 'vendor/autoload.php';
//use Mailgun\Mailgun;

class Email {
	
	public static function welcome_email($email, $first_name, $last_name, $code) {
		$to = $email;

		$from = "BIOMIO service <service@biom.io>";
		$from = "service@biom.io";
		$from_name = "BIOMIO service";
		$subject = "BIOMIO: Email Verification";

		$body = file_get_contents("../tpl/emails/WelcomeEmail.html");
		$body = str_replace('%email%',$email,$body);
		$body = str_replace('%first_name%',$first_name,$body);
		$body = str_replace('%last_name%',$last_name,$body);
		$body = str_replace('%code%',$code,$body);

		
		$headers = "From: $from\n";
		        $headers .= "MIME-Version: 1.0\n";
		        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		//mail($to, $subject, $body, $headers);

		monkey_mail($to, $subject, $body, $from, $from_name);
	}

	public static function welcome2_email($email, $first_name, $last_name, $code) {
		$to = $email;

		$from = "BIOMIO service <service@biom.io>";
		$from = "service@biom.io";
		$from_name = "BIOMIO service";
		$subject = "BIOMIO: Email Verification";

		$body = file_get_contents("../tpl/emails/Welcome2Email.html");
		$body = str_replace('%email%',$email,$body);
		$body = str_replace('%first_name%',$first_name,$body);
		$body = str_replace('%last_name%',$last_name,$body);
		$body = str_replace('%code%',$code,$body);

		
		$headers = "From: $from\n";
		        $headers .= "MIME-Version: 1.0\n";
		        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		//mail($to, $subject, $body, $headers);

		monkey_mail($to, $subject, $body, $from, $from_name);
	}

	public static function send_email_verification_code($email, $first_name, $last_name, $code) {
		$to = $email;
		$from = "BIOMIO login <login@biom.io>";
		$from = "login@biom.io";
		$from_name = "BIOMIO login";
		$subject = "BIOMIO: Email Verification";

		$body = file_get_contents("../tpl/emails/EmailVerification.html");
		$body = str_replace('%email%',$email,$body);
		$body = str_replace('%first_name%',$first_name,$body);
		$body = str_replace('%last_name%',$last_name,$body);
		$body = str_replace('%code%',$code,$body);

		
		$headers = "From: $from\n";
		        $headers .= "MIME-Version: 1.0\n";
		        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		//mail($to, $subject, $body, $headers);

		monkey_mail($to, $subject, $body, $from, $from_name);
	}

	public static function login_code($code, $email) {
		//$to = "ditkis@gmail.com";
		$from = "BIOMIO login <login@biom.io>";
		$from = "login@biom.io";
		$from_name = "BIOMIO login";
		$subject = "BIOMIO: Temporary login code";
		$to = $email;

		$body = file_get_contents("../tpl/emails/LoginCode.html");
		$body = str_replace('%code%',$code,$body);

		
		$headers = "From: $from\n";
		        $headers .= "MIME-Version: 1.0\n";
		        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		//mail($to, $subject, $body, $headers);
		
		monkey_mail($to, $subject, $body, $from, $from_name);
	}

	// -------------------
	public static function contact($name, $email, $message) {
		//$to = "ditkis@gmail.com";
		$from = "BIOMIO service <service@biom.io>";
		$from_name = "BIOMIO service";
		$subject = "BIOMIO: New Message from User";

		$body = file_get_contents("../tpl/emails/ContactEmail.html");
		$body = str_replace('%name%',$name,$body);
		$body = str_replace('%email%',$email,$body);
		$body = str_replace('%message%',$message,$body);

		
		$headers = "From: $from\n";
		        $headers .= "MIME-Version: 1.0\n";
		        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$to = "alexander.lomov1@gmail.com";
		mail($to, $subject, $body, $headers);
		

		$to = "alexander.lomov1@gmail.com";
		monkey_mail($to, $subject, $body, $from, $from_name);

		//$to = "ditkis@gmail.com";
		//monkey_mail($to, $subject, $body, $from, $from_name);
		return '#success';
	}

	public static function provider_app_registration($email, $code) {
		//$to = "ditkis@gmail.com";
		$from = "BIOMIO service <service@biom.io>";
		$from_name = "BIOMIO service";
		$subject = "BIOMIO: Application Registration";

		$body = file_get_contents("../../tpl/emails/ProviderAppRegistration.html.html");
		$body = str_replace('%code%',$code,$body);

		
		$headers = "From: $from\n";
		        $headers .= "MIME-Version: 1.0\n";
		        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$to = $email;
		mail($to, $subject, $body, $headers);
		

		$to = "alexander.lomov1@gmail.com";
		monkey_mail($to, $subject, $body, $from, $from_name);

		//$to = "ditkis@gmail.com";
		//monkey_mail($to, $subject, $body, $from, $from_name);
		return '#success';
	}
}

function monkey_mail($to, $subject, $body, $from, $from_name) {

//	require_once './Mailgun/Mailgun.php';
//require 'vendor/autoload.php';
//use Mailgun\Mailgun;

//$client = new \Http\Adapter\Guzzle6\Client();

        $mgClient = new \Mailgun\Mailgun('key-22d04f5f1108f80acd648c9234c45546');
        $domain = "mg.biom.io";

        return $mgClient->sendMessage("$domain",
            array('from'    => $from_name.' <'.$from.'>',
                'to'      => $to,
                'subject' => $subject,
                'html'    => $body));

/*
	require_once 'mandrill/Mandrill.php';
	try {
	    $mandrill = new Mandrill('vyS5QUBZJP9bstzF1zeVNA');
	    $message = array(
	        'html' => $body,
	        'subject' => $subject,
	        'from_email' => $from,
	        'from_name' => $from_name,
	        'to' => array(
	            array(
	                'email' => $to,
	                'type' => 'to'
	            )
	        )  
	    );
	    $async = false;
	    $result = $mandrill->messages->send($message, $async);
	} catch(Mandrill_Error $e) {
	    // Mandrill errors are thrown as exceptions
	    //echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
	    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
	    throw $e;
	}
*/
}
