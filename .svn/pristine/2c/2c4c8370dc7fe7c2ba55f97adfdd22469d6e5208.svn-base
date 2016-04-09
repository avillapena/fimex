<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "v_ColadasCerty".
 *
 * @property integer $IdProduccion
 * @property integer $IdProduccionDetalle
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdEmpleado
 * @property integer $IdProduccionEstatus
 * @property string $Fecha
 * @property integer $IdSubProceso
 * @property integer $IdProgramacion
 * @property integer $IdProductos
 * @property string $Inicio
 * @property string $Fin
 * @property integer $CiclosMolde
 * @property integer $PiezasMolde
 * @property integer $Programadas
 * @property string $Hechas
 * @property string $Rechazadas
 * @property integer $IdArea
 * @property integer $IdLance
 * @property integer $Colada
 * @property integer $Lance
 */
class VColadasCerty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ColadasCerty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdProduccionDetalle', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'Fecha', 'IdSubProceso', 'IdProgramacion', 'IdProductos', 'CiclosMolde', 'PiezasMolde', 'Programadas', 'IdArea', 'IdLance', 'Colada', 'Lance'], 'required'],
            [['IdProduccion', 'IdProduccionDetalle', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'IdSubProceso', 'IdProgramacion', 'IdProductos', 'CiclosMolde', 'PiezasMolde', 'Programadas', 'IdArea', 'IdLance', 'Colada', 'Lance'], 'integer'],
            [['Fecha', 'Inicio', 'Fin'], 'safe'],
            [['Hechas', 'Rechazadas'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'IdEmpleado' => 'Id Empleado',
            'IdProduccionEstatus' => 'Id Produccion Estatus',
            'Fecha' => 'Fecha',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdProgramacion' => 'Id Programacion',
            'IdProductos' => 'Id Productos',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'CiclosMolde' => 'Ciclos Molde',
            'PiezasMolde' => 'Piezas Molde',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'Rechazadas' => 'Rechazadas',
            'IdArea' => 'Id Area',
            'IdLance' => 'Id Lance',
            'Colada' => 'Colada',
            'Lance' => 'Lance',
        ];
    }
}
