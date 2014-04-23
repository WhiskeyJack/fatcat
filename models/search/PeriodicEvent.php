<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PeriodicEvent as PeriodicEventModel;

/**
 * PeriodicEvent represents the model behind the search form about `app\models\PeriodicEvent`.
 */
class PeriodicEvent extends PeriodicEventModel
{
    public function rules()
    {
        return [
            [['id', 'event_type_id', 'every_day', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'interval_in_sec'], 'integer'],
            [['start_date', 'created'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PeriodicEventModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'event_type_id' => $this->event_type_id,
            'every_day' => $this->every_day,
            'monday' => $this->monday,
            'tuesday' => $this->tuesday,
            'wednesday' => $this->wednesday,
            'thursday' => $this->thursday,
            'friday' => $this->friday,
            'saturday' => $this->saturday,
            'sunday' => $this->sunday,
            'interval_in_sec' => $this->interval_in_sec,
            'start_date' => $this->start_date,
            'created' => $this->created,
        ]);

        return $dataProvider;
    }
}
