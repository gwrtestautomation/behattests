<?php
/**
 * Created by PhpStorm.
 * User: madha
 * Date: 09-01-2018
 * Time: 16:46
 */

class emailVerificationGMail
{
    public static $emailReceived;
    public static $startTime;
    public static $endTime;
    public static $elapsedTime;

    static function emailVerification($host, $port, $username, $password, $maxverificationtime)
    {
        self::$emailReceived = "false";
        self::$startTime = microtime(true);

        /* connect to gmail */
        //$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $hostname = '{'.$host.':'.$port.'/imap/ssl}INBOX';

        do
        {
            /* try to connect */
            $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
            $emails = imap_search($inbox,'UNSEEN');

            if($emails) {

                //rsort($emails);

                /* for every email... */
                foreach ($emails as $email_number)
                {
                    //$headerInfo = imap_headerinfo($inbox,$email_number);
                    //$structure = imap_fetchstructure($inbox, $email_number);

                    /* get information specific to this email */
                    $overview = imap_fetch_overview($inbox, $email_number, 0);
                    //print_r($overview);

                    $subject = $overview[0]->subject;

                    $message = imap_fetchbody($inbox, $email_number, '');
                    $received = explode("Received:", $message);
                    //print_r($received);
                    $emailPart1 = explode("for ", $received[5]);
                    //print_r($emailPart1);
                    $emailPart2 = explode(";", $emailPart1[1]);
                    // print_r($emailPart2);
                    $emailfor = $emailPart2[0];
                    $registereduser = file_get_contents(__DIR__.'/resources/files/useremail.txt');

                    if ((trim($subject) == 'Welcome from Great Wolf Lodge') and ($registereduser == $emailfor))
                    {
                        self::$emailReceived = "true";

                        $matches = array();

                        preg_match_all('/href=3D(.*?)"/s', $message, $matches);
                        //print_r($matches);
                        //print_r($matches[1][4]);
                        $splitStrFirst = explode("'", $matches[1][4]);
                        //print_r($splitStrFirst);

                        $splitStrSecond = explode("=", $splitStrFirst[1]);
                        //print_r($splitStrSecond);

                        $splitStrThird = substr($splitStrSecond[1], 2);
                        //print_r($splitStrThird);

                        $url = $splitStrSecond[0].'='.$splitStrThird.$splitStrSecond[2].$splitStrSecond[3];
                        //print_r($url);

                        $file = __DIR__.'/resources/files/resetpasswordlink.txt';
                        file_put_contents($file, $url);

                        imap_mail_move($inbox, "$email_number:$email_number", '[Gmail]/Trash');

                        break;
                    }
                }
            }
            self::$endTime = microtime(true);
            self::$elapsedTime = Round((self::$endTime - self::$startTime), 0);
        }while((self::$emailReceived == 'false') and (self::$elapsedTime < $maxverificationtime));

        /* close the connection */
        //imap_expunge($inbox);
        imap_close($inbox);
        return array(self::$emailReceived, self::$elapsedTime);
    }

}