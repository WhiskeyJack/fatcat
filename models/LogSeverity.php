<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_severity".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * @property Log[] $logs
 */
class LogSeverity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_severity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 254]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['log_severity' => 'id']);
    }
}
