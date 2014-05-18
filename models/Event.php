<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property string $id
 * @property string $name
 * @property string $quantity
 * @property string $at
 * @property string $event_status_id
 * @property string $at_job
 * @property string $created
 *
 * @property EventStatus $eventStatus
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'quantity', 'at'], 'required'],
            [['quantity'], 'number'],
            [['at', 'created'], 'safe'],
            [['event_status_id', 'at_job'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID and primary key',
            'name' => 'Name of this event',
            'quantity' => 'Quantity given',
            'at' => 'Time of event',
            'at_local' => 'Time of event',
            'event_status_id' => 'Event Status ID',
            'at_job' => 'At Job',
            'created' => 'When event was created',
            'created_local' => 'When event was created',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventStatus()
    {
        return $this->hasOne(EventStatus::className(), ['id' => 'event_status_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $timezone = Yii::$app->user->isGuest ? 'Europe/Amsterdam' : Yii::$app->user->identity->timezone;
            date_default_timezone_set($timezone);
            $at_ts = strtotime($this->at);
            date_default_timezone_set('UTC');
            $this->at=date('Y-m-d G:i:s', $at_ts);
            return true;
        } else {
            return false;
        }
    }
    
    public function afterSave($insert)
    {
        if ($insert) {

            // create log entry
            date_default_timezone_set('UTC');
            $at_ts = strtotime($this->at);
            $timezone = Yii::$app->user->isGuest ? 'Europe/Amsterdam' : Yii::$app->user->identity->timezone;
            date_default_timezone_set($timezone);
            $local_time = date('Y-m-d G:i:s', $at_ts);
                    
            $log = new Log();
            $log->log_source_id = 2;    // one-time event
            $log->log_severity = 1;
            $log->subject = "Event {$this->id} registered";
            $log->message = "Event {$this->id} \"{$this->name}\" with quantity {$this->quantity} has been registered to run at {$local_time} local time ({$this->at} UTC).";
            $log->save();
            
            $log = new Log();
            $log->log_source_id = 2;    // one-time event
            $log->subject = "Event {$this->id} NOT scheduled";
            $log->message = "Event {$this->id} \"{$this->name}\" was NOT scheduled.";
            $log->log_severity = 3;
            date_default_timezone_set('UTC');
            $at_time = date('G:i Y-m-d', strtotime($this->at));
            $feedme = Yii::getAlias('@webroot') . '/../shell/feedme.sh ';
            $cmd = "echo \"{$feedme} -q {$this->quantity} -N '{$this->name}' -e $this->id\"";
            exec("{$cmd} | at {$at_time} 2>&1", $output);
            $matches = array();
            foreach ($output as $input_line) {
                if (preg_match("/^job (\d*) /", $input_line, $matches)) {
                    $this->at_job = $matches[1];
                    $this->event_status_id = 2;
                    $update = array('at_job' => $this->at_job, 'event_status_id' => $this->event_status_id);
                    \Yii::$app->db->createCommand()->update(self::tableName(), $update, ['id'=>$this->id])->execute();
                    $log->log_severity = 1;
                    $log->subject = "Event {$this->id} scheduled";
                    $log->message = "Event {$this->id} \"{$this->name}\" has been scheduled with at job id {$this->at_job}.";
                }
            }
            if (empty($this->at_job)) {
                // something went wrong
                $log->message .= PHP_EOL . "Command: {$cmd} | at {$at_time}";
                $log->message .= PHP_EOL . 'Output: ' . implode(PHP_EOL, $output);
            }
            $log->save();

            return true;
        } else {
            return false;
        }
    }
    
    public $at_local; 
    public $created_local;
    public function afterFind() {
        $at_ts = strtotime($this->at);
        $created_ts = strtotime($this->created);
        $timezone = Yii::$app->user->isGuest ? 'Europe/Amsterdam' : Yii::$app->user->identity->timezone;
        Yii::$app->timeZone = $timezone;
        
        $this->at_local = date('l F j g:i A', $at_ts);
        $this->created_local = date('l F j g:i A', $created_ts);
        return parent::afterFind();
    }
}