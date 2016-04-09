<?php

namespace frontend\models\inventario;

use Yii;
use frontend\models\produccion\Series;

/**
 * This is the model class for table "SerieMovimientos".
 *
 * @property integer $IdSerieMovimiento
 * @property integer $IdSerie
 * @property integer $IdInventarioMovimiento
 *
 * @property InventarioMovimientos $idInventarioMovimiento
 * @property Series $idSerie
 */
class SerieMovimientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SerieMovimientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdSerie', 'IdInventarioMovimiento'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdSerieMovimiento' => 'Id Serie Movimiento',
            'IdSerie' => 'Id Serie',
            'IdInventarioMovimiento' => 'Id Inventario Movimiento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInventarioMovimiento()
    {
        return $this->hasOne(InventarioMovimientos::className(), ['IdInventarioMovimiento' => 'IdInventarioMovimiento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSerie()
    {
        return $this->hasOne(Series::className(), ['IdSerie' => 'IdSerie']);
    }
}
