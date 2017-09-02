<?php
use yii\helpers\Url;
use app\models\User;
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
                    ['label' => Yii::t('app', 'Sample 1'), 'icon' => 'line-chart divider', 'url' => ['/admin']],
                    ['label' => Yii::t('app', 'Sample 2'), 'icon' => 'sitemap', 'url' => ['/admin']],
                    ['label' => Yii::t('app', 'Sample 3'), 'icon' => 'bullhorn', 'url' => ['/admin']],
                    [
                        'label' => Yii::t('app', 'Service'),
                        'icon' => 'cogs divider',
                        'url' => '#',
                        'items' => [
//                            [
//                                'label' => Yii::t('app', 'Users'),
//                                'icon' => 'users',
//                                'url' => ['/admin'],
//                            ],
                            ['label' => Yii::t('app', 'Refresh cash'), 'icon' => 'file-code-o', 'url' => ['/admin/admin/clear-cash'],],

                        ],
                    ],
                    ['label' => Yii::t('app', 'Back to site'), 'icon' => 'share', 'url' => ['/']],
                    ['label' => Yii::t('app', 'Logout'), 'icon' => 'power-off', 'url' => ['/admin/admin/logout']],
                ],
            ]
        ) ?>

    </section>
</aside>
