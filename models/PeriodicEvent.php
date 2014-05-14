<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodic_event".
 *
 * @property string $id
 * @property string $name
 * @property string $quantity
 * @property integer $hour
 * @property integer $minute
 * @property integer $monday
 * @property integer $tuesday
 * @property integer $wednesday
 * @property integer $thursday
 * @property integer $friday
 * @property integer $saturday
 * @property integer $sunday
 * @property string $cron_string
 * @property string $created
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
            [['name', 'quantity', 'hour', 'minute', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'], 'required'],
            [['quantity'], 'number'],
            [['hour', 'minute', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'], 'integer'],
            [['created'], 'safe'],
            [['name', 'cron_string'], 'string', 'max' => 50]
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
            'quantity' => 'Quantity',
            'hour' => 'Hour',
            'minute' => 'Minute',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
            'cron_string' => 'Cron String',
            'created' => 'Created',
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // create cron string
            $days = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
            $min = $this->minute;
            $hour = $this->hour;
            $dom = '*';     // day of month (each day)
            $month = '*';   // month (each month)
            $dow = '';      // day of week (0 to 6 are Sunday to Saturday)
            if (count($days) == 7)
                $dow .= '*,';
            else 
            {
                foreach ($days as $key => $day)
                    $dow .= $this->$day == 1 ? $key . ',' : '';
            }
            $dow = substr($dow, 0, -1); // remove last comma
            $this->cron_string = "{$min} {$hour} {$dom} {$month} {$dow}";
            return true;
        } else {
            return false;
        }
    }
    
    public function afterSave($insert)
    {
        $this->writeCrontab();
    }
    
    public function eraseCrontab()
    {
        exec('crontab -r');
    }
    
    public function writeCrontab()
    {
        $all_events = PeriodicEvent::find()->orderBy('id')->all();
        $feedme = Yii::getAlias('@webroot') . '/../shell/feedme.sh';
        $crontab = '';
        foreach ($all_events as $e) 
        {
            $crontab .= "{$e->cron_string} {$feedme} -q {$e->quantity} -N '{$e->name}' -e $e->id -p" . PHP_EOL;
        }
        file_put_contents('/tmp/crontab.txt', $crontab);
        exec('crontab /tmp/crontab.txt');
        
        
    }
}
