<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "social_providers".
 *
 * @property integer $id
 * @property string $name
 */
class SocialProviders extends \yii\db\ActiveRecord
{
    const VK       = 1;
    const FACEBOOK = 2;
    const GOOGLE   = 3;

    public static $providers = [
        self::VK       => 1,
        self::FACEBOOK => 2,
        self::GOOGLE   => 3,
    ];

    public static $providersNames = [
        1 => 'VK',
        2 => 'FACEBOOK',
        3 => 'GOOGLE',

    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'social_providers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\SocialProvidersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SocialProvidersQuery(get_called_class());
    }
}//SocialProviders
