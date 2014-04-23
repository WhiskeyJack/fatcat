<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event_type".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $quantity
 * @property string $created
 *
 * @property Event[] $events
 * @property PeriodicEvent[] $periodicEvents
 */
class EventType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'quantity'], 'required'],
            [['quantity'], 'integer'],
            [['created'], 'safe'],
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
            'id' => 'ID and primary key',
            'name' => 'Name',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['event_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodicEvents()
    {
        return $this->hasMany(PeriodicEvent::className(), ['event_type_id' => 'id']);
    }
}
