<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "social_accounts".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $provider_id
 * @property string $client_id
 * @property string $username
 * @property string $email
 * @property string $img
 *
 * @property SocialProviders $provider
 * @property User $user
 */
class SocialAccounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'social_accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'provider_id'], 'integer'],
            [['provider_id', 'client_id', 'username'], 'required'],
            [['client_id', 'username', 'email', 'img'], 'string', 'max' => 255],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialProviders::className(), 'targetAttribute' => ['provider_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'provider_id' => Yii::t('app', 'Provider ID'),
            'client_id' => Yii::t('app', 'Client ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'img' => Yii::t('app', 'Img'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(SocialProviders::className(), ['id' => 'provider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\SocialAccountsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SocialAccountsQuery(get_called_class());
    }
}
