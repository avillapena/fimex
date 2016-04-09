<?php

namespace frontend\models\certificados;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\certificados\ProductosTratamientos;

/**
 * ProductosttSearch represents the model behind the search form about `frontend\models\certificados\ProductosTratamientos`.
 */
class ProductosttSearch extends ProductosTratamientos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProductosTratamientos', 'Min', 'Max'], 'integer'],
            [['NoParte', 'TipoTT'], 'safe'],
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
        $query = ProductosTratamientos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->load($params) && !$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idProductosTratamientos' => $this->idProductosTratamientos,
            'Min' => $this->Min,
            'Max' => $this->Max,
        ]);

        $query->andFilterWhere(['like', 'NoParte', $this->NoParte])
            ->andFilterWhere(['like', 'TipoTT', $this->TipoTT]);

        return $dataProvider;
    }
}
