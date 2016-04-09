<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_producciones".
 *
 * @property integer $IdProduccion
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdEmpleado
 * @property integer $IdProduccionEstatus
 * @property string $Fecha
 * @property integer $Semana
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property integer $IdProduccionDetalle
 * @property integer $IdProgramacion
 * @property integer $IdProductos
 * @property string $Inicio
 * @property string $Fin
 * @property integer $CiclosMolde
 * @property integer $PiezasMolde
 * @property integer $Programadas
 * @property string $Hechas
 * @property string $Rechazadas
 * @property string $Eficiencia
 * @property integer $Colada
 * @property integer $Lance
 * @property string $Aleacion
 * @property integer $Nomina
 * @property string $Empleado
 * @property string $Turno
 * @property string $Maquina
 * @property string $Producto
 */
class VProducciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_producciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'Fecha', 'IdSubProceso', 'IdArea'], 'required'],
            [['IdProduccion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'Semana', 'IdSubProceso', 'IdArea', 'IdProduccionDetalle', 'IdProgramacion', 'IdProductos', 'CiclosMolde', 'PiezasMolde', 'Programadas', 'Colada', 'Lance', 'Nomina'], 'integer'],
            [['Fecha', 'Inicio', 'Fin'], 'safe'],
            [['Hechas', 'Rechazadas', 'Eficiencia'], 'number'],
            [['Aleacion', 'Empleado', 'Turno', 'Maquina', 'Producto'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'IdEmpleado' => 'Id Empleado',
            'IdProduccionEstatus' => 'Id Produccion Estatus',
            'Fecha' => 'Fecha',
            'Semana' => 'Semana',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdProgramacion' => 'Id Programacion',
            'IdProductos' => 'Id Productos',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'CiclosMolde' => 'Ciclos Molde',
            'PiezasMolde' => 'Piezas Molde',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'Rechazadas' => 'Rechazadas',
            'Eficiencia' => 'Eficiencia',
            'Colada' => 'Colada',
            'Lance' => 'Lance',
            'Aleacion' => 'Aleacion',
            'Nomina' => 'Nomina',
            'Empleado' => 'Empleado',
            'Turno' => 'Turno',
            'Maquina' => 'Maquina',
            'Producto' => 'Producto',
        ];
    }
}
