<?php
/**
 * Created by PhpStorm.
 * User: madha
 * Date: 10-01-2018
 * Time: 16:58
 */

class EmailVerificationAdapter
{
    public static $emailverified;

     static function verifyEmail()
     {
         $emailserver = UtilityContext::getVerifyEmailValues('EmailServer ', 'Gmail');
         $host = UtilityContext::getVerifyEmailValues('Host', 'imap.gmail.com');
         $port = UtilityContext::getVerifyEmailValues('Port', '993');
         $username = UtilityContext::getVerifyEmailValues('Username', 'gwr.autotest1@gmail.com');
         $password = UtilityContext::getVerifyEmailValues('Password', '$Reset123$');
         $maxverificationtime = UtilityContext::getVerifyEmailValues('MaxVerificationTime', '180');

         if ($emailserver === 'Gmail')
         {
            self::$emailverified = EmailVerificationGMail::emailVerification($host, $port, $username, $password, $maxverificationtime);
         }

         return self::$emailverified;
     }
}