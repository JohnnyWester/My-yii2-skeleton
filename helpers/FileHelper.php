<?php

namespace app\helpers;

use yii\helpers\Url;

class FileHelper
{
    /**
     * @param string $path
     * @param string $extension
     * @return string
     */
    public static function getRandomFileName($path, $extension='')
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path  : '';

        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));

        return $name . $extension;
    }// getRandomFileName

    public static function getExtByMimeType($mime)
    {
        preg_match('/(.+)?\/(.+)?$/', $mime, $output);
        $name = $output[1];
        $ext = $output[2];

        return $ext;
    }

}