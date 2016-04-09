<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_ProgramacionLimpieza".
 *
 * @property integer $IdProgramacionSemana
 * @property integer $IdProgramacion
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $Llenadas
 * @property integer $Cerradas
 * @property integer $Vaciadas
 * @property integer $IdProceso
 * @property integer $IdSubProceso
 * @property integer $IdCentroTrabajo
 * @property integer $Existencia
 */
class VProgramacionLimpieza extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionLimpieza';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacionSemana', 'IdProgramacion', 'Anio', 'Semana', 'Hechas', 'IdSubProceso', 'IdCentroTrabajo'], 'required'],
            [['IdProgramacionSemana', 'IdProgramacion', 'Anio', 'Semana', 'Prioridad', 'Programadas', 'Hechas', 'Llenadas', 'Cerradas', 'Vaciadas', 'IdProceso', 'IdSubProceso', 'IdCentroTrabajo', 'Existencia'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'IdProgramacion' => 'Id Programacion',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'Llenadas' => 'Llenadas',
            'Cerradas' => 'Cerradas',
            'Vaciadas' => 'Vaciadas',
            'IdProceso' => 'Id Proceso',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Existencia' => 'Existencia',
        ];
    }
}
