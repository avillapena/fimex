<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_MantenimientosHornos".
 *
 * @property integer $IdMantenimientoHorno
 * @property string $Fecha
 * @property integer $Consecutivo
 * @property string $Observaciones
 * @property string $Refractario
 * @property integer $IdCentroTrabajo
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property string $Habilitado
 * @property integer $IdMaquina
 * @property string $ClaveMaquina
 * @property string $Maquina
 * @property integer $ConsecutivoActual
 * @property string $Eficiencia
 */
class VMantenimientosHornos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_MantenimientosHornos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMantenimientoHorno', 'IdCentroTrabajo', 'Identificador', 'Descripcion', 'IdSubProceso', 'IdArea'], 'required'],
            [['IdMantenimientoHorno', 'Consecutivo', 'IdCentroTrabajo', 'IdSubProceso', 'IdArea', 'Habilitado', 'IdMaquina', 'ConsecutivoActual'], 'integer'],
            [['Fecha'], 'safe'],
            [['Observaciones', 'Refractario', 'Identificador', 'Descripcion', 'ClaveMaquina', 'Maquina'], 'string'],
            [['Eficiencia'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMantenimientoHorno' => 'Id Mantenimiento Horno',
            'Fecha' => 'Fecha',
            'Consecutivo' => 'Consecutivo',
            'Observaciones' => 'Observaciones',
            'Refractario' => 'Refractario',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'Habilitado' => 'Habilitado',
            'IdMaquina' => 'Id Maquina',
            'ClaveMaquina' => 'Clave Maquina',
            'Maquina' => 'Maquina',
            'ConsecutivoActual' => 'Consecutivo Actual',
            'Eficiencia' => 'Eficiencia',
        ];
    }
}
