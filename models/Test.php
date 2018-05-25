<?php

namespace app\models;

use yii\base\Model;
use \app\components\ImgHelper;
use yii\helpers\VarDumper;

class Test extends Model
{
    public $files = [];

    /**
     * @param array $sourcePath
     * @return string
     */
    public static function compressImg($sourcePath)
    {
        foreach ($sourcePath as $key => $value){
            $path = ImgHelper::resizeImg($value->tempName, true, 800, 800);
            VarDumper::dump($path, 3, true);
            exit;
        }

    }
}

