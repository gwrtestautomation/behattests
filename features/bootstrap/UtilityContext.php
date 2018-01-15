<?php
/**
 * Created by PhpStorm.
 * User: madha
 * Date: 28-12-2017
 * Time: 16:33
 */

class UtilityContext
{
    static function shapeSpace_random_string($length)
    {

        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        srand((double)microtime()*1000000);

        $random = '';

        for ($i = 0; $i < $length; $i++) {
            $random .= $characters[rand() % strlen($characters)];
        }

        return $random;
    }

   static function zipResults()
    {
        $folderName = file_get_contents(__DIR__.'/resources/files/reportfolder.txt');
        $folder = __DIR__.'/resources/'.$folderName;
        $destination = $folder.".zip"; // name of zip file
        $source = $folder; // the folder which you archivate

        if (extension_loaded('zip')) {
            if (file_exists($source)) {
                $zip = new ZipArchive();
                if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
                    $source = realpath($source);
                    if (is_dir($source)) {
                        $iterator = new RecursiveDirectoryIterator($source);
                        // skip dot files while iterating
                        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
                        $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = realpath($file);
                            if (is_dir($file)) {
                                $zip->addEmptyDir(str_replace($source . '', '', $file . ''));
                            } else if (is_file($file)) {
                                $zip->addFromString(str_replace($source . '', '', $file), file_get_contents($file));
                            }
                        }
                    } else if (is_file($source)) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }
                return $zip->close();
            }
        }
    }

    static function getSendEmailValues($key, $def)
    {
        $path = __DIR__.'/resources/files/sendemailconfig.txt';
        $found = false;
        $val = null;

        $file = fopen($path,"r");

        while(! feof($file))
        {
            //print_r(fgets($file));
            $line = fgets($file);

            $pairs = explode("=", $line);
            //print_r($pairs);

            if (trim($pairs[0]) == $key)
            {
                $val = trim($pairs[1]);
                //print_r($val);
                $found = true;
            }
        }
        fclose($file);

        if($found == false)
        {
           $val = $def;
        }

        return $val;
    }

    static function getVerifyEmailValues($key, $def)
    {
        $path = __DIR__.'/resources/files/verifyemailconfig.txt';
        $found = false;
        $val = null;

        $file = fopen($path,"r");

        while(! feof($file))
        {
            //print_r(fgets($file));
            $line = fgets($file);

            $pairs = explode("=", $line);
            //print_r($pairs);

            if (trim($pairs[0]) == $key)
            {
                $val = trim($pairs[1]);
                //print_r($val);
                $found = true;
            }
        }
        fclose($file);

        if($found == false)
        {
            $val = $def;
        }

        return $val;
    }
}