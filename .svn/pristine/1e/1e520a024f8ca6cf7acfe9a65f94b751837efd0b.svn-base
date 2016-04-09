<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "NormaMediciones".
 *
 * @property integer $IdNormaMedicion
 * @property integer $IdNorma
 * @property string $Medicion
 * @property string $Min
 * @property string $Max
 * @property string $Nominal
 *
 * @property Normas $idNorma
 */
class NormaMediciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'NormaMediciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdNorma'], 'integer'],
            [['Medicion'], 'string'],
            [['Min', 'Max', 'Nominal'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdNormaMedicion' => 'Id Norma Medicion',
            'IdNorma' => 'Id Norma',
            'Medicion' => 'Medicion',
            'Min' => 'Min',
            'Max' => 'Max',
            'Nominal' => 'Nominal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNorma()
    {
        return $this->hasOne(Normas::className(), ['IdNorma' => 'IdNorma']);
    }
}
