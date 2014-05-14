<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property string $source
 * @property string $subject
 * @property string $message
 * @property string $created
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source', 'subject', 'message', 'created'], 'required'],
            [['created'], 'safe'],
            [['source'], 'string', 'max' => 50],
            [['subject'], 'string', 'max' => 100],
            [['message'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'subject' => 'Subject',
            'message' => 'Message',
            'created' => 'Created',
        ];
    }
}
