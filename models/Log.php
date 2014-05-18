<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $log_severity
 * @property integer $log_source_id
 * @property string $subject
 * @property string $message
 * @property string $created
 *
 * @property LogSeverity $logSeverity
 * @property LogSource $logSource
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
            [['log_severity', 'log_source_id', 'subject', 'message'], 'required'],
            [['log_severity', 'log_source_id'], 'integer'],
            [['created'], 'safe'],
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
            'log_severity' => 'Log Severity',
            'log_source_id' => 'Log Source ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogSeverity()
    {
        return $this->hasOne(LogSeverity::className(), ['id' => 'log_severity']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogSource()
    {
        return $this->hasOne(LogSource::className(), ['id' => 'log_source_id']);
    }
    
    public $created_local;
    public function afterFind() {
        $created_ts = strtotime($this->created);
        $timezone = Yii::$app->user->isGuest ? 'Europe/Amsterdam' : Yii::$app->user->identity->timezone;
        Yii::$app->timeZone = $timezone;
        $this->created_local = date('l F j g:i A', $created_ts);
        return parent::afterFind();
    }
}
