<?php
class Mailing{
    public $email_ad = "";
    public $subject = "";
    public $body = "";
    
    /**
    * Send Email
    */
    public function sendMail()
    {
        $mail             = new PHPMailer();  
       
        $mail->IsSMTP();
        $mail->Host       = "mail.yourdomain.com"; 
        $mail->SMTPDebug  = 2;                     
        $mail->SMTPAuth   = true;                  
        $mail->SMTPSecure = "tls";                
        $mail->Host       = "smtp.gmail.com";      
        $mail->Port       = 587;                   
        $mail->Username   = "messenger.klabhouse@gmail.com";  
        $mail->Password   = "klabklab";
        $mail->SetFrom('messenger.klabhouse@gmail.com', 'Klabhouse Admin');
        $mail->AddReplyTo("messenger.klabhouse@gmail.com","Klabhouse Admin");
        $mail->Subject    = $this->subject;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 
        $mail->MsgHTML($this->body);
        $mail->AddAddress($this->email_ad, "Human");

        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } 

    }
}