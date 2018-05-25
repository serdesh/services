<?php

namespace app\models;

use yii\base\Model;
use \app\components\ImgHelper;

class Test extends Model
{
    public $files = [];

    /**
     * @param array $sourcePath
     * @return string
     */
    public static function compressImg($sourcePath)
    {
        foreach ($sourcePath as $key => $value) {
            $file = pathinfo($value->name);
            $savePathFile = 'uploads/temp/' . time() . '.' . $file['extension'];
            return ImgHelper::resizeImage($value->tempName, $savePathFile, 800);
        }
        return '';
    }
}

