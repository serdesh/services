<?php

namespace app\components;

use app\models\Siteinfo;
use yii;
use ZipArchive;

class ZipFiles
{
    /**
     * @param $sourceFile Файл для архивации
     * @param $destfile Архивированный файл
     * @param $filename Имя файла
     */
    public static function zipFile($sourceFile, $destfile, $filename)
    {
        $zip = new ZipArchive();
        if (!$zip->open($destfile, ZIPARCHIVE::CREATE)) {
            app()->session->addFlash('error', 'Невозможно открыть ' . $destfile);
//            exit("Не могу открыть " . $destfile . '<br>');
        }
        $zip->addFile($sourceFile->tempName, $filename);
        $zip->close();
        unset($zip);
    }


    /**
     * @param $sourceDir
     * @return string
     */
    public static function zipDirectory($sourceDir)
    {
        $destinationDir =  'uploads/temp';

        $zip = new ZipArchive();
        $filename = $destinationDir . '/' . time() . '.zip';
        Siteinfo::removefiles($destinationDir);
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir);
        }

        if (!$zip->open($filename, ZIPARCHIVE::CREATE)) {
            exit("Не могу открыть " . $filename . '<br>' . $destDir);
        }

        if ($objs = glob($sourceDir . "/*")) {
            foreach ($objs as $obj) {
                if (is_file($obj)) {
                    $zip->addFile($obj, '/' . basename($obj));
                }
            }
        }
        //$zippedcount = $zip->numFiles;
        $zip->close();
        unset($zip);
        app()->response->sendFile(Yii::getAlias('@webroot/' . $filename));
        return $filename;
    }
}