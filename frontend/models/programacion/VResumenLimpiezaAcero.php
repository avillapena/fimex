<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_resumenLimpiezaAcero".
 *
 * @property integer $IdArea
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Aleacion
 * @property string $TonPrg
 * @property string $TonVac
 * @property integer $PzaPrg
 */
class VResumenLimpiezaAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_resumenLimpiezaAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Anio', 'Semana'], 'required'],
            [['IdArea', 'Anio', 'Semana', 'PzaPrg'], 'integer'],
            [['Aleacion'], 'string'],
            [['TonPrg', 'TonVac'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Aleacion' => 'Aleacion',
            'TonPrg' => 'Ton Prg',
            'TonVac' => 'Ton Vac',
            'PzaPrg' => 'Pza Prg',
        ];
    }
}
