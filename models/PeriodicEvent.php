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
            
            $day_count = 0;
            foreach ($days as $key => $day) {
               if ($this->$day == 1) {
                    $dow .= $key . ',';
                    $day_count++;
                }
            }
            if (count($day_count) == 7)
                $dow .= '*,';
            $dow = substr($dow, 0, -1); // remove last comma
            
            // take timezone into account
            // TODO: also for day?
            $timezone = Yii::$app->user->isGuest ? 'Europe/Amsterdam' : Yii::$app->user->identity->timezone;
            date_default_timezone_set($timezone);
            $local_time = strtotime("{$this->hour}:{$this->minute}");
            date_default_timezone_set('UTC');
            $utc_hour = date('G', $local_time);
            $utc_minute = date('i', $local_time);
            $this->cron_string = "{$utc_minute} {$utc_hour} {$dom} {$month} {$dow}";
            return true;
        } else {
            return false;
        }
    }
    
    public function afterSave($insert)
    {
        // create log entry                    
        $log = new Log();
        $log->log_source_id = 1;    // periodic event
        $log->log_severity = 1;
        $hour = sprintf("%02d", $this->hour);
        $minute = sprintf("%02d", $this->minute);
        $days = $this->dayString();
        if ($insert) {
            $log->subject = "Periodic event {$this->id} registered";
            $log->message = "Periodic event {$this->id} \"{$this->name}\" with quantity {$this->quantity} has been registered to run at {$hour}:{$minute} local time on {$days}.";
            $log->save();
        } 
        else 
        {
            $log->subject = "Periodic event {$this->id} updated";
            $log->message = "Periodic event {$this->id} \"{$this->name}\" has been updated to run at {$hour}:{$minute} local time with quantity {$this->quantity} on {$days}.";
            $log->save();
        }
        $this->writeCrontab();
    }
    
    public function afterDelete()
    {
        // create log entry                    
        $log = new Log();
        $log->log_source_id = 1;    // periodic event
        $log->log_severity = 1;
        $hour = sprintf("%02d", $this->hour);
        $minute = sprintf("%02d", $this->minute);
        $days = $this->dayString();
        $log->subject = "Periodic event {$this->id} deleted";
        $log->message = "Periodic event {$this->id} \"{$this->name}\" with quantity {$this->quantity} has been deleted. It was registered to run at {$hour}:{$minute} local time on {$days}.";
        $log->save();        
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
    
    public function dayString()
    {
        $days = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
        $run_on = array();
        $day_count = 0;
        foreach ($days as $key => $day) {
            if ($this->$day == 1) {
                $run_on[] = $day;
            }
       }
       if (count($run_on) == 7)
           $string = 'all days';
       else
       {
           $last = array_pop($run_on);
           $string = count($run_on) ? implode(', ', $run_on) . " and {$last}" : $last;
       }
       return $string;
    }
}
