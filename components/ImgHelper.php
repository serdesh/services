<?php

namespace app\components;

/**
 * Image helper functions
 *
 * @author Chris
 */
class ImageHelper {

    /**
     * Create a thumbnail of an image and returns relative path in webroot
     *
     * @param int $width
     * @param int $height
     * @param string $img
     * @param int $quality
     * @return string $path
     */
    public static function thumb($width, $height, $img, $quality = 75)
    {
        $pathinfo = pathinfo($img);
        $thumb_name = "thumb_".$pathinfo['filename'].'_'.$width.'_'.$height.'.'.$pathinfo['extension'];
        $thumb_path = $pathinfo['dirname'].'/.tmb/';
        if(!file_exists($thumb_path)){
            mkdir($thumb_path);
        }

        if(!file_exists($thumb_path.$thumb_name)){

            $image = Yii::app()->image->load($img);

            $image->resize($width, $height, Image::SQUARE)->crop($width, $height)->sharpen(15)->quality($quality);
            $image->save($thumb_path.$thumb_name);
        }

        $relative_path = str_replace(YiiBase::getPathOfAlias('webroot'), '', $thumb_path.$thumb_name);
        return $relative_path;
    }
}
//Использование
//$src = ImageHelper::thumb($width, $height, $this->imagePath);
//$src = CHtml::image(Yii::app()->request->hostInfo . '/' . $src, $this->name, array('title'=>$this->name));