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
 * @property string $created
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
            'created' => 'When event was created',
        ];
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
            $testname = '/tmp/testfile_' . $this->id;
            exec("touch {$testname} | at {$at_time}", $output);
            $a=1;
            
            return true;
        } else {
            return false;
        }
    }
}
