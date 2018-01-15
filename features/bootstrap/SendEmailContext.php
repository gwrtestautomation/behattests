<?php
/**
 * Created by PhpStorm.
 * User: madha
 * Date: 03-01-2018
 * Time: 17:57
 */

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

class SendEmailContext
{

    static function sendEmailWithAttachment()
    {
        $host = UtilityContext::getSendEmailValues('Host', 'smtp.gmail.com');
        $smtpauth = UtilityContext::getSendEmailValues('SMTPAuth', 'true');
        $username = UtilityContext::getSendEmailValues('Username', 'gwr.autotest1@gmail.com');
        $password = UtilityContext::getSendEmailValues('Password', '$Reset123$');
        $smtpsecure = UtilityContext::getSendEmailValues('SMTPSecure', 'tls');
        $port = UtilityContext::getSendEmailValues('Port', '587');
        $recipients = UtilityContext::getSendEmailValues('Recipients', 'madhav.shelke@xcelacore.com');

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Disable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = $smtpauth;                               // Enable SMTP authentication
            $mail->Username = $username;                 // SMTP username
            $mail->Password = $password;                           // SMTP password
            $mail->SMTPSecure = $smtpsecure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $port;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($username);
            $mail->addReplyTo($username);

            $recipients = explode(",", $recipients);

            foreach ($recipients as $address)
            {
                $mail->addAddress($address);     // Recipient
            }

            //Set the subject line
            $mail->Subject = 'GWR Test Automation Execution Results';
            //Read an HTML message body from an external file, convert referenced images to embedded,

            $folderName = file_get_contents(__DIR__.'/resources/files/reportfolder.txt');
            //$zipFolder = __DIR__.'/resources/'.$folderName.'.zip';

            $htmlFileName = file_get_contents(__DIR__.'/resources/files/reportfile.txt');
            $htmlFile = __DIR__.'/resources/'.$folderName.'/'.$htmlFileName.'.html';

            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML(file_get_contents($htmlFile), __DIR__);

            //Replace the plain text body with one created manually
            $mail->AltBody = 'This is a plain-text message body';

            //Attach an image file
            $mail->addAttachment($htmlFile);

             //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Results email sent!";
              /*  if (save_mail($mail)) {
                    echo "Message saved!";
                }
              */
            }

        } catch (Exception $e) {
            echo 'Results email could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    function save_mail($mail)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        $mail->Username = 'gwr.autotest1@gmail.com';                 // SMTP username
        $mail->Password = '$Reset123$';                           // SMTP password

        //You can change 'Sent Mail' to any other folder or tag
        $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
        //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
        $imapStream = imap_open($path, $mail->Username, $mail->Password);
        $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
        imap_close($imapStream);
        return $result;
    }
}