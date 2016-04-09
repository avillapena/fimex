<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "InventarioTransferencias".
 *
 * @property integer $IdInventarioTransferencia
 * @property integer $IdInventario
 * @property integer $IdInventarioMovimientoSalida
 * @property integer $IdInventarioMovimientoEntrada
 *
 * @property InventarioMovimientos $idInventarioMovimientoEntrada
 * @property Inventarios $idInventario
 * @property InventarioMovimientos $idInventarioMovimientoSalida
 */
class InventarioTransferencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'InventarioTransferencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdInventario'], 'required'],
            [['IdInventario', 'IdInventarioMovimientoSalida', 'IdInventarioMovimientoEntrada'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdInventarioTransferencia' => 'Id Inventario Transferencia',
            'IdInventario' => 'Id Inventario',
            'IdInventarioMovimientoSalida' => 'Id Inventario Movimiento Salida',
            'IdInventarioMovimientoEntrada' => 'Id Inventario Movimiento Entrada',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInventarioMovimientoEntrada()
    {
        return $this->hasOne(InventarioMovimientos::className(), ['IdInventarioMovimiento' => 'IdInventarioMovimientoEntrada'])->with('idProducto','serieMovimientos','idSubProceso','idCentroTrabajo');
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
    public function getIdInventarioMovimientoSalida()
    {
        return $this->hasOne(InventarioMovimientos::className(), ['IdInventarioMovimiento' => 'IdInventarioMovimientoSalida'])->with('idProducto','serieMovimientos','idSubProceso','idCentroTrabajo');
    }
}
