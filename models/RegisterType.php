<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "register_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $comment
 *
 * @property User[] $users
 */
class RegisterType extends \yii\db\ActiveRecord
{
    const EMAIL  = 1;
    const SOCIAL = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'register_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => Yii::t('app', 'ID'),
            'name'    => Yii::t('app', 'Name'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['login_type' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\RegisterTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RegisterTypeQuery(get_called_class());
    }
}
