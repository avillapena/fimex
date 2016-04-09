<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "ProgramacionesAlmaDia".
 *
 * @property integer $IdProgramacionAlmaDia
 * @property integer $IdProgramacionAlmaSemana
 * @property string $Dia
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 *
 * @property CentrosTrabajo $idCentroTrabajo
 * @property Maquinas $idMaquina
 * @property ProgramacionesAlmaSemana $idProgramacionAlmaSemana
 */
class ProgramacionesAlmaDia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProgramacionesAlmaDia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacionAlmaSemana', 'Dia', 'Programadas', 'IdCentroTrabajo', 'IdMaquina'], 'required'],
            [['IdProgramacionAlmaSemana', 'Prioridad', 'Programadas', 'Hechas', 'IdCentroTrabajo', 'IdMaquina'], 'integer'],
            [['Dia'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacionAlmaDia' => 'Id Programacion Alma Dia',
            'IdProgramacionAlmaSemana' => 'Id Programacion Alma Semana',
            'Dia' => 'Dia',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
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
    public function getIdMaquina()
    {
        return $this->hasOne(Maquinas::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacionAlmaSemana()
    {
        return $this->hasOne(ProgramacionesAlmaSemana::className(), ['IdProgramacionAlmaSemana' => 'IdProgramacionAlmaSemana']);
    }
}
