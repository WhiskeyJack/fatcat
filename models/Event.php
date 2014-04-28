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
            'event_status_id' => 'Event Status ID',
            'at_job' => 'At Job',
            'created' => 'When event was created',
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
            $this->at=date('Y-m-d G:i:s', strtotime($this->at));
            return true;
        } else {
            return false;
        }
    }
    
    public function afterSave($insert)
    {
        $a=1;
        if ($insert) {
            $at_time = date('G:i Y-m-d', strtotime($this->at));
            $feedme = Yii::getAlias('@webroot') . '/../shell/feedme.sh ';
            $cmd = "echo \"{$feedme} -q {$this->quantity} -N '{$this->name}' -e $this->id\"";
            exec("{$cmd} | at {$at_time} 2>&1", $output);
            $matches = array();
            foreach ($output as $input_line) {
                if (preg_match("/^job (\d*) /", $input_line, $matches)) {
                    $this->at_job = $matches[1];
                    $this->event_status_id = 2;
                    $this->update();
                }
            }
            return true;
        } else {
            return false;
        }
    }
}

    
