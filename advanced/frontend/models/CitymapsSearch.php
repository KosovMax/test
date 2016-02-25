<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Citymaps;

/**
 * CitymapsSearch represents the model behind the search form about `frontend\models\Citymaps`.
 */
class CitymapsSearch extends Citymaps
{
    /**
     * @inheritdoc
     */
    public $search;

    public function rules()
    {
        return [
            [['cityid'], 'integer'],
            [['address','search' ,'coorYX', 'color', 'date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Citymaps::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'cityid' => $this->cityid,
        // ]);

        // $query->orFilterWhere(['like', 'address', $this->search])
        //     ->orFilterWhere(['like', 'coorYX', $this->search])
        //     ->orFilterWhere(['like', 'color', $this->search])
        //     ->orFilterWhere(['like', 'date', $this->search]);

        $query->orFilterWhere(['like', 'color', $this->search])
            ->orFilterWhere(['like', 'date', $this->search]);

        return $dataProvider;
    }
}
