<?php
use yii\helpers\Html;
use app\components\widgets\pceuropa\LanguageSelection;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <h3 style="width: 70%;
                    float: left;
                    margin: 10px;
                    text-align: center;
                    padding-top: 10px;
                    color: #fff;">
            <?php echo Html::encode($this->title) ?>
        </h3>

<!--        <div class="navbar-custom-menu">-->
<!--            --><?//= LanguageSelection::widget([
//                'language' => ['uk', 'ru',],
//                'languageParam' => 'lng',
//                'handler' => Url::to(['/main/lang']),
//                'container' => 'li', // li for navbar, div for sidebar or footer example
//                'classContainer' => 'dropdown-toggle' // btn btn-default dropdown-toggle
//            ]);
//; ?>
<!--        </div>-->
    </nav>
</header>
