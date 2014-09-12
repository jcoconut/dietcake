<?php
class MailController extends AppController
{
    public function sendMail()
    {
        $mail             = new PHPMailer();
        
        $body             = 'You have been invited';
       

        $mail->IsSMTP();
        $mail->Host       = "mail.yourdomain.com"; 
        $mail->SMTPDebug  = 2;                     
        $mail->SMTPAuth   = true;                  
        $mail->SMTPSecure = "tls";                
        $mail->Host       = "smtp.gmail.com";      
        $mail->Port       = 587;                   
        $mail->Username   = "jalbinco@gmail.com";  
        $mail->Password   = "walangpass";            // GMAIL password
        $mail->SetFrom('klabhouse@klab.com', 'Klabhouse Admin');
        $mail->AddReplyTo("klabhouse@klab.com","Klabhouse Admin");
        $mail->Subject    = "Congratulations Scorpion!";
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->MsgHTML($body);

        $address = "jay.co@klab.com";
        $mail->AddAddress($address, "John Doe");

        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            flash_message('message', 'User is added!');
            flash_message('positive_message', 1);
            redirect(url('admin/adduser'));
        }
        
                        
    }

}