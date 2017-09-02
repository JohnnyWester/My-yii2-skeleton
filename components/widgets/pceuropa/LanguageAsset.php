<?php
namespace app\components\widgets\pceuropa;

class LanguageAsset extends \yii\web\AssetBundle{
    public $sourcePath = '@app/components/widgets/pceuropa/assets';
    public $baseUrl = '@web';
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
