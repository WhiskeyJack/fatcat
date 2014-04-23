<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodic_event".
 *
 * @property string $id
 * @property string $event_type_id
 * @property integer $every_day
 * @property integer $monday
 * @property integer $tuesday
 * @property integer $wednesday
 * @property integer $thursday
 * @property integer $friday
 * @property integer $saturday
 * @property integer $sunday
 * @property integer $interval_in_sec
 * @property string $start_date
 * @property string $created
 *
 * @property EventType $eventType
 */
class PeriodicEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periodic_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_type_id', 'every_day', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'interval_in_sec', 'start_date'], 'required'],
            [['event_type_id', 'every_day', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'interval_in_sec'], 'integer'],
               [['start_date', 'created'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID and primary key',
            'event_type_id' => 'Event Type ID',
            'every_day' => 'Every Day',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
            'interval_in_sec' => 'Interval In Sec',
            'start_date' => 'Start Date',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventType()
    {
        return $this->hasOne(EventType::className(), ['id' => 'event_type_id']);
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->start_date=date('Y-m-d g:i:s', strtotime($this->start_date));
            return true;
        } else {
            return false;
        }
    }
}
