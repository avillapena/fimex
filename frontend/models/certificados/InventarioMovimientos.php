<?php

namespace app\models\certificados;

use Yii;

/**
 * This is the model class for table "InventarioMovimientos".
 *
 * @property integer $IdInventarioMovimiento
 * @property integer $IdInventario
 * @property integer $IdCentroTrabajo
 * @property integer $IdProducto
 * @property string $Tipo
 * @property integer $Cantidad
 * @property integer $Existencia
 * @property string $Observaciones
 * @property string $FechaMoldeo
 * @property integer $IdSubProceso
 *
 * @property CentrosTrabajo $idCentroTrabajo
 * @property Inventarios $idInventario
 * @property SubProcesos $idSubProceso
 * @property UnionInv[] $unionInvs
 */
class InventarioMovimientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'InventarioMovimientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdInventario', 'IdCentroTrabajo', 'IdProducto', 'Tipo', 'IdSubProceso'], 'required'],
            [['IdInventario', 'IdCentroTrabajo', 'IdProducto', 'Cantidad', 'Existencia', 'IdSubProceso'], 'integer'],
            [['Tipo', 'Observaciones', 'FechaMoldeo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdInventarioMovimiento' => 'Id Inventario Movimiento',
            'IdInventario' => 'Id Inventario',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdProducto' => 'Id Producto',
            'Tipo' => 'Tipo',
            'Cantidad' => 'Cantidad',
            'Existencia' => 'Existencia',
            'Observaciones' => 'Observaciones',
            'FechaMoldeo' => 'Fecha Moldeo',
            'IdSubProceso' => 'Id Sub Proceso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCentroTrabajo()
    {
        return $this->hasOne(CentrosTrabajo::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
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
    public function getIdSubProceso()
    {
        return $this->hasOne(SubProcesos::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnionInvs()
    {
        return $this->hasMany(UnionInv::className(), ['IdInventarioMovimiento' => 'IdInventarioMovimiento']);
    }
}
