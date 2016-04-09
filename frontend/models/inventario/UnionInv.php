<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "UnionInv".
 *
 * @property integer $IdUnionInv
 * @property integer $IdProduccion
 * @property integer $IdProduccionDetalle
 * @property integer $IdInventario
 * @property integer $IdInventarioMovimiento
 *
 * @property InventarioMovimientos $idInventarioMovimiento
 * @property Inventarios $idInventario
 * @property Producciones $idProduccion
 * @property ProduccionesDetalle $idProduccionDetalle
 */
class UnionInv extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UnionInv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdProduccionDetalle', 'IdInventario', 'IdInventarioMovimiento'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdUnionInv' => 'Id Union Inv',
            'IdProduccion' => 'Id Produccion',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdInventario' => 'Id Inventario',
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
    public function getIdInventario()
    {
        return $this->hasOne(Inventarios::className(), ['IdInventario' => 'IdInventario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalle()
    {
        return $this->hasOne(ProduccionesDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }
}
