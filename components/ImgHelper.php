<?php

namespace app\components;


use yii\helpers\VarDumper;

class ImgHelper
{
    /**
     * @param string $pathfile
     * @param bool $save
     * @param int $width
     * @param int $height
     * @return bool
     */
    public static function resizeImg($pathfile, $save, $width, $height)
    {
        $info = getimagesize($pathfile); //Инфа о картинке
        $size = [$info[0], $info[1]];
//        VarDumper::dump($info, 3, true);
//        exit;
        switch ($info['mime'])
        {
            case 'image/png':
                $func = imagecreatefrompng($pathfile);
                $ext = 'png';
                break;
            case 'image/jpeg':
                $func = imagecreatefromjpeg($pathfile);
                $ext = 'jpeg';
                break;
            case 'image/gif':
                $func = imagecreatefromgif($pathfile);
                $ext = 'gif';
                break;
            default :
                return false;
        }
        $thumb = imagecreatetruecolor($width, $height); //Индентификатор изображения с заданными размерами
        $src_aspect = $size[0] / $size[1]; //Отношение ширины к высоте полноразмерного изображения
        $thumb_aspect = $width / $height; //Отношение ширины к высоте превьюшки

        if ($src_aspect < $thumb_aspect)
        {
            $scale = $height / $size[1];
            $new_size = [$height * $src_aspect, $height];
            $src_pos = [($size[0] * $scale - $width) / $scale / 2, 0];
        } else
        {
            $new_size = [$width, $height];
            $src_pos = [0, 0];
        }

        $new_size[0] = max($new_size[0], 1);
        $new_size[1] = max($new_size[1], 1);

        imagecopyresampled($thumb, $func, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);

        if ($save === false)
        {
            return imagepng($thumb); //возвращает превьюху
        } else
        {
            $name = (string)time();
            return imagepng($thumb, 'uploads/' . $name . '.' . $ext); //сохраняет превьюху
        }
    }

    /**
     * Функция "cropImg" взята отсюда: https://codengineering.ru/post/32
     * @param string $aInitialImageFilePath - строка, представляющая путь к обрезаемому изображению
     * @param string $aNewImageFilePath - строка, представляющая путь куда нахо сохранить выходное обрезанное изображение
     * @param int $aNewImageWidth - ширина выходного обрезанного изображения
     * @param int $aNewImageHeight - высота выходного обрезанного изображения
     * @return bool
     */
    public static function cropImg($aInitialImageFilePath, $aNewImageFilePath, $aNewImageWidth, $aNewImageHeight)
    {
        if (($aNewImageWidth < 0) || ($aNewImageHeight < 0)) {
            return false;
        }
        // Массив с поддерживаемыми типами изображений
        $lAllowedExtensions = array(1 => "gif", 2 => "jpeg", 3 => "png");

        // Получаем размеры и тип изображения в виде числа
        list($lInitialImageWidth, $lInitialImageHeight, $lImageExtensionId) = getimagesize($aInitialImageFilePath);

        if (!array_key_exists($lImageExtensionId, $lAllowedExtensions)) {
            return false;
        }
        $lImageExtension = $lAllowedExtensions[$lImageExtensionId];

        // Получаем название функции, соответствующую типу, для создания изображения
        $func = 'imagecreatefrom' . $lImageExtension;
        // Создаём дескриптор исходного изображения
        $lInitialImageDescriptor = $func($aInitialImageFilePath);
        // Определяем отображаемую область
        $lCroppedImageWidth = 0;
        $lCroppedImageHeight = 0;
        $lInitialImageCroppingX = 0;
        $lInitialImageCroppingY = 0;
        if ($aNewImageWidth / $aNewImageHeight > $lInitialImageWidth / $lInitialImageHeight) {
            $lCroppedImageWidth = floor($lInitialImageWidth);
            $lCroppedImageHeight = floor($lInitialImageWidth * $aNewImageHeight / $aNewImageWidth);
            $lInitialImageCroppingY = floor(($lInitialImageHeight - $lCroppedImageHeight) / 2);
        } else {
            $lCroppedImageWidth = floor($lInitialImageHeight * $aNewImageWidth / $aNewImageHeight);
            $lCroppedImageHeight = floor($lInitialImageHeight);
            $lInitialImageCroppingX = floor(($lInitialImageWidth - $lCroppedImageWidth) / 2);
        }

        // Создаём дескриптор для выходного изображения
        $lNewImageDescriptor = imagecreatetruecolor($aNewImageWidth, $aNewImageHeight);
        imagecopyresampled($lNewImageDescriptor, $lInitialImageDescriptor, 0, 0, $lInitialImageCroppingX, $lInitialImageCroppingY, $aNewImageWidth, $aNewImageHeight, $lCroppedImageWidth, $lCroppedImageHeight);
        $func = 'image' . $lImageExtension;

        // сохраняем полученное изображение в указанный файл
        return $func($lNewImageDescriptor, $aNewImageFilePath);
    }
}
