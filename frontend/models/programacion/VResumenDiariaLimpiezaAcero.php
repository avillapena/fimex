<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_ResumenDiariaLimpiezaAcero".
 *
 * @property integer $IdArea
 * @property string $TonPrg
 * @property string $TonHechas
 * @property integer $Programadas
 * @property integer $Hechas
 * @property string $Dia
 * @property integer $Anio
 * @property integer $Semana
 */
class VResumenDiariaLimpiezaAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ResumenDiariaLimpiezaAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Hechas', 'Dia', 'Anio', 'Semana'], 'required'],
            [['IdArea', 'Programadas', 'Hechas', 'Anio', 'Semana'], 'integer'],
            [['TonPrg', 'TonHechas'], 'number'],
            [['Dia'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'TonPrg' => 'Ton Prg',
            'TonHechas' => 'Ton Hechas',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'Dia' => 'Dia',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
        ];
    }
}
