<?php


use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP; 

require "vendor/autoload.php";
// require "../../vendor/autoload.php";

class MailView{

    private $body;
    private $to;
    // private $subject;
    private $pass;

    public function __construct($message,$subject,$to){
        $value = $to;
        $this->body = $message;
        $this->to = $value[0];
        $this->pass = $value[1];
        $this->sendMail();
    }

    public function sendMail(){

        // $all = [$this->body, $this->to,$this->subject];

        // return $all;

        $mail = new PHPMailer();

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->isSMTP();

        $mail->SMTPAuth = true;
        $mail->Username = 'mail@mail.com';
        $mail->Password = "mailPassword";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        // $mail->SMTPSecure = "ssl";
        // $mail->Port = 465;
        $mail->Host = 'smtp.gmail.com';
        $mail->isHTML(true);
        
        
        $mail ->setFrom('usefroem@mail.com','name to use');

        $mail->addAddress($this->to,'name to ');
        

        $mail->Subject = "Login Credentials";
        $mail->Body = "Username: ". $this->body . "Password: ". $this->pass;

        if(!$mail->send()){
            return ("Mailer Error :". $mail->ErrorInfo);
        }else{
            return ('The email message was sent');
        }

    }
    
}
