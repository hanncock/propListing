<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
error_reporting(1);

class Mail
{
    protected $host = "mail.homeventures.co.ke";
    protected $username = "sales@homeventures.co.ke";
    protected $password = "Home_V123*";
    protected $port = "26";
    protected $secure = "smtp";
    protected $smtp, $mail;

    public function __construct() 
    {
        $this->smtp = Mail::factory('smtp', array ('host' => $this->host, 
        'port' => $this->port, 'auth' => true, 'username' => $this->username, 
        'password' => $this->password, 'secure' => $this->secure, 'HTML' => true));
    }

    function sendMail($names, $from, $phone, $subject, $message, $receipient) 
    {
        #mail fields
        $names_arr = explode(" ", $names);
        $email_body = $message."\n\nYou can reach out to me via ".$from." OR via".$phone."\n\n\nKind Regards\n".$names;
        $Response = "Response From Ijara";
        $response_body = "Hello ".$names.",".
					"\nYour request has been received".
                    "\nWe will get back to you ASAP".
					"\n\nFrom Us".
					"\nIjara Properties Ltd Team";

        #headers
        $headers = array('From' => $names_arr[0], 'To' => $receipient, 'Subject' => $subject,'Reply-To' => $from);
        $otherheaders = array ('From' => "Ijara Properties Ltd<".$receipient.">", 'To' => $from, 'Subject' => $Response, 'Reply-To' => $receipient);
        
        #send mail
        $this->mail = $this->smtp->send($receipient, $headers, $email_body);

        if(PEAR::isError($this->mail)) 
        {
            $response = array(
                'status' => true,
                'message' => 'Error occurred while sending your request. Please try again!'
            );

            return $response;
        }
        else 
        {
            #auto respond
            $autorespond = $this->autoresponse($from, $otherheaders, $response_body);

            if($autorespond['status']) 
            {
                return $response = array(
                    'status' => true,
                    'message' => 'Error occurred while sending your request. Please try again!'
                );
            }

            return $response = array(
                'status' => true,
                'message' => 'Request sent successfully!'
            ); 
        }
    }

    function autoresponse($from, $otherheaders, $response_body) 
    {
        $this->mail = $this->smtp->send($from, $otherheaders, $response_body);

        if(PEAR::isError($auto_respond)){
            return $response = array(
                'status' => true
            );
        }
        else
        {
            return $response = array(
                'status' => false
            );
        }
    }
}

?>