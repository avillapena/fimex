<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_ProduccionAlmas".
 *
 * @property integer $IdProduccion
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdEmpleado
 * @property integer $IdProduccionEstatus
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Fecha
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property integer $IdTurno
 * @property integer $IdAlmaProduccionDetalle
 * @property integer $IdProgramacionAlma
 * @property integer $IdProducto
 * @property integer $IdAlmaTipo
 * @property string $Inicio
 * @property string $Fin
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $Rechazadas
 * @property integer $PiezasCaja
 * @property integer $PiezasMolde
 * @property integer $PiezasHora
 */
class VProduccionAlmas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProduccionAlmas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'Fecha', 'IdSubProceso', 'IdArea', 'IdAlmaProduccionDetalle', 'IdProgramacionAlma', 'IdProducto', 'IdAlmaTipo', 'Programadas', 'Rechazadas', 'PiezasCaja', 'PiezasMolde'], 'required'],
            [['IdProduccion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'Anio', 'Semana', 'IdSubProceso', 'IdArea', 'IdTurno', 'IdAlmaProduccionDetalle', 'IdProgramacionAlma', 'IdProducto', 'IdAlmaTipo', 'Programadas', 'Hechas', 'Rechazadas', 'PiezasCaja', 'PiezasMolde', 'PiezasHora'], 'integer'],
            [['Fecha', 'Inicio', 'Fin'], 'safe']
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
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Fecha' => 'Fecha',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'IdTurno' => 'Id Turno',
            'IdAlmaProduccionDetalle' => 'Id Alma Produccion Detalle',
            'IdProgramacionAlma' => 'Id Programacion Alma',
            'IdProducto' => 'Id Producto',
            'IdAlmaTipo' => 'Id Alma Tipo',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'Rechazadas' => 'Rechazadas',
            'PiezasCaja' => 'Piezas Caja',
            'PiezasMolde' => 'Piezas Molde',
            'PiezasHora' => 'Piezas Hora',
        ];
    }
}
