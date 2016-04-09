<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_ResumenCelda".
 *
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $DiaSemana
 * @property integer $IdCentroTrabajo
 * @property integer $Pzas
 * @property string $TON
 */
class VResumenCelda extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ResumenCelda';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Anio', 'Semana', 'Dia'], 'required'],
            [['Anio', 'Semana', 'DiaSemana', 'IdCentroTrabajo', 'Pzas'], 'integer'],
            [['Dia'], 'safe'],
            [['TON'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'DiaSemana' => 'Dia Semana',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Pzas' => 'Pzas',
            'TON' => 'Ton',
        ];
    }
}
