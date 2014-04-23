<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property string $id
 * @property string $event_type_id
 * @property string $name
 * @property string $quantity
 *
 * @property EventType $eventType
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
            [['event_type_id', 'name', 'quantity'], 'required'],
            [['event_type_id'], 'integer'],
            [['quantity'], 'number'],
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
            'event_type_id' => 'Corresponding event type',
            'name' => 'Name of this event',
            'quantity' => 'Quantity given',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventType()
    {
        return $this->hasOne(EventType::className(), ['id' => 'event_type_id']);
    }
    
    /**
     * http://www.yiiframework.com/forum/index.php/topic/49479-gridview-with-foreign-key/
     * @return type
     */
    public function getEventTypeName()
    {
        return $this->eventType->name;
    }
}
