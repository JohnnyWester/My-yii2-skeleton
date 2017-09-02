<?php
use yii\helpers\Url;
use app\models\BasicUser;
use yii\helpers\Html;
use app\models\Setting;

Url::remember();
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="info border-b">
            <a href="#"><i class="fa fa-circle text-success"></i> Online: </a>
            <span style="color: #fff;"><?php echo Html::encode(Yii::$app->user->identity->username) ?></span>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('app', 'Sample 1'), 'icon' => 'fa fa-line-chart divider', 'url' => ['/admin']],
                    ['label' => Yii::t('app', 'Sample 2'), 'icon' => 'fa fa-sitemap', 'url' => ['/admin']],
                    [
                        'label' => Yii::t('app', 'Service'),
                        'icon' => 'fa fa-cogs divider',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Refresh cash'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/admin/clear-cash'],],

                        ],
                    ],
                    ['label' => Yii::t('app', 'Back to site'), 'icon' => 'fa fa-share', 'url' => ['/']],
                    ['label' => Yii::t('app', 'Logout'), 'icon' => 'fa fa-power-off', 'url' => ['/admin/admin/logout']],
                ],
            ]
        ) ?>
        <?php vd(Yii::$app->user->identity);?>
    </section>
</aside>
