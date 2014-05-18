<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_source".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * @property Log[] $logs
 */
class LogSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_source';
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
        return $this->hasMany(Log::className(), ['log_source_id' => 'id']);
    }
}
