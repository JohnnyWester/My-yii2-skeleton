<?php

namespace app\modules\api\common\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\helpers\FileHelper;
use yii\web\BadRequestHttpException;

class ApiUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [
                ['imageFile'], 'file',
                'skipOnEmpty' => false,
                'maxSize' => param('MAX_UPLOAD_IMG_SISE'),// максимальный размер файла
                'maxFiles' => 1// кол-во одновременно загружаемых файлов
            ],
        ];
    }

    public function uploadFile()
    {
        if ($this->validate()) {
            $path = param('UPLOAD_IMG_PATH');
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;

            if (!file_exists( $uploadPath)) {
                mkdir($uploadPath, 0777,true);
            }

            //$extension = $this->imageFile->extension;

            // достаем действительное расширение файла из myme-type
            $finfo = new \finfo;
            $mime_type = $finfo->file($this->imageFile->tempName, FILEINFO_MIME_TYPE);
            $extension = FileHelper::getExtByMimeType($mime_type);

            // проверка расширения
            if (!in_array($extension, param('extensions'))) {
                throw new BadRequestHttpException('Upload image failed(bad extension).');
            }

            // имя с расширением
            $filename = FileHelper::getRandomFileName($path, $extension);

            $res = $this->imageFile->saveAs($path . $filename);

            return $res ? $filename : null;
        } else {
            return false;
        }
    }

}