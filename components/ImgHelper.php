<?php

namespace app\components;


class ImgHelper
{


    /**
     * @param $pathFile
     * @param $savePathFile
     * @param int $width
     * @param int $height
     * @return bool
     */
    public static function resizeImage($pathFile, $savePathFile, int $width, int $height = 0)
    {
        // ПРОВЕРКА НА ИЗОБРАЖЕНИЕ
        $size = getimagesize($pathFile);

        // если это изображение и у него определён размер, то продолжаем
        if ($size) {
//        // ОПРЕДЕЛЯЕМ МАКСИМАЛЬНЫЕ ШИРИНУ И ВЫСОТУ ИЗОБРАЖЕНИЯ
//            $width = 200;
//            $height = 200;

            if ($height == 0) {
                $height = $size[1];
            }

            //ОПРЕДЕЛЯЕМ ТИП
            header("Content-type: {$size['mime']}");


            // ПОЛУЧАЕМ НОВЫЕ РАЗМЕРЫ
            list($width_orig, $height_orig) = getimagesize($pathFile);

            //Если новая ширина меньше ширины загружаемого изображения - меняем размер
            if ($width < $width_orig) {
                if ($width && ($width_orig < $height_orig)) {
                    $width = ($height / $height_orig) * $width_orig;
                } else {
                    $height = ($width / $width_orig) * $height_orig;
                }
                // ПЕРЕСОХРАНЯЕМ ИЗОБРАЖЕНИЕ
                $image_p = imagecreatetruecolor($width, $height);
                $image = imagecreatefromjpeg($pathFile);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                // СОЗДАЁМ
                imagejpeg($image_p, $savePathFile, 100);
            } else {
                //Иначе просто копируем картинку
                copy($pathFile, $savePathFile);
            }
            return true;
        } else {
            return false;
            //exit("Загружаемый файл не изображение...");
        }
    }

    /**
     * @param string $pathFile Путь к картинке
     * @param int $width Желаемая ширина
     * @param int $height Желаемая высота
     * @param bool $savePathFile Путь сохранения картинки
     * @return bool
     */
    public static function thumbImg($pathFile, $savePathFile, int $width, int $height = 0)
    {
        $info = getimagesize($pathFile); //Инфа о картинке
        if ($height == 0) {
            $height = $info[1];
        }
        $size = [$info[0], $info[1]];

        switch ($info['mime']) {
            case 'image/png':
                $func = imagecreatefrompng($pathFile);
//                $ext = 'png';
                break;
            case 'image/jpeg':
                $func = imagecreatefromjpeg($pathFile);
//                $ext = 'jpeg';
                break;
            case 'image/gif':
                $func = imagecreatefromgif($pathFile);
//                $ext = 'gif';
                break;
            default :
                return false;
        }
        $thumb = imagecreatetruecolor($width, $height); //Индентификатор изображения с заданными размерами
        $src_aspect = $size[0] / $size[1]; //Отношение ширины к высоте полноразмерного изображения
        $thumb_aspect = $src_aspect;//$width / $height; //Отношение ширины к высоте превьюшки

        if ($src_aspect < $thumb_aspect) {
            $scale = $height / $size[1];
            $new_size = [$height * $src_aspect, $height];
            $src_pos = [($size[0] * $scale - $width) / $scale / 2, 0];
        } else {
            $new_size = [$width, $height];
            $src_pos = [0, 0];
        }

        $new_size[0] = max($new_size[0], 1);
        $new_size[1] = max($new_size[1], 1);

        imagecopyresampled($thumb, $func, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);

        if (!$savePathFile) {
            return imagepng($thumb); //возвращает сжатую картинку
        } else {
//            $name = (string)time();
            return imagepng($thumb, $savePathFile); //сохраняет превьюху
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
    public static function cropImg($aInitialImageFilePath, $aNewImageFilePath, int $aNewImageWidth, int $aNewImageHeight)
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
//        $lCroppedImageWidth = 0;
//        $lCroppedImageHeight = 0;
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
