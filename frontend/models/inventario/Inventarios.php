<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "Inventarios".
 *
 * @property integer $IdInventario
 * @property string $Fecha
 * @property integer $IdEmpleado
 * @property integer $IdEstatusInventario
 * @property integer $IdSubProceso
 * @property string $Transaccion
 * @property integer $IdCentroTrabajo
 *
 * @property InventarioTransferencias[] $inventarioTransferencias
 * @property CentrosTrabajo $idCentroTrabajo
 * @property Empleados $idEmpleado
 * @property EstatusInventario $idEstatusInventario
 * @property SubProcesos $idSubProceso
 * @property InventarioMovimientos[] $inventarioMovimientos
 * @property UnionInv[] $unionInvs
 */
class Inventarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Inventarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Fecha', 'IdEmpleado', 'IdEstatusInventario', 'IdSubProceso'], 'required'],
            [['Fecha'], 'safe'],
            [['IdEmpleado', 'IdEstatusInventario', 'IdSubProceso', 'Transaccion', 'IdCentroTrabajo'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdInventario' => 'Id Inventario',
            'Fecha' => 'Fecha',
            'IdEmpleado' => 'Id Empleado',
            'IdEstatusInventario' => 'Id Estatus Inventario',
            'IdSubProceso' => 'Id Sub Proceso',
            'Transaccion' => 'Transaccion',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarioTransferencias()
    {
        return $this->hasMany(InventarioTransferencias::className(), ['IdInventario' => 'IdInventario'])->with('idInventarioMovimientoEntrada','idInventarioMovimientoSalida');
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
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstatusInventario()
    {
        return $this->hasOne(EstatusInventario::className(), ['IdEstatusInventario' => 'IdEstatusInventario']);
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
    public function getInventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimientos::className(), ['IdInventario' => 'IdInventario'])->with('idProducto','idSubProceso','idCentroTrabajo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnionInvs()
    {
        return $this->hasMany(UnionInv::className(), ['IdInventario' => 'IdInventario']);
    }
}