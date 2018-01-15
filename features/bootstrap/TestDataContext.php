<?php
/**
 * Created by PhpStorm.
 * User: madha
 * Date: 28-12-2017
 * Time: 16:38
 */

class TestDataContext
{
    static function getTestData($data)
    {
        if ($data === 'New Email Address')
        {
            $data = UtilityContext::shapeSpace_random_string(10).date('YmdHis')."@gwrtest.33mail.com";
            $file = __DIR__.'/resources/files/useremail.txt';
            file_put_contents($file, $data);
        } elseif ($data === 'Southern California Page')
        {
            $data = 'https://www.greatwolf.com/southern-california';
        } elseif ($data === 'Niagara Page')
        {
            $data = 'https://www.greatwolf.com/niagara';
        } elseif ($data === 'Reset Password URL')
        {
            $data = file_get_contents(__DIR__.'/resources/files/resetpasswordlink.txt');
        } elseif ($data === 'Registered Email Address')
        {
            $data = file_get_contents(__DIR__.'/resources/files/useremail.txt');
        }

        return $data;
    }
}