<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "ProduccionesCalidad".
 *
 * @property integer $IdProduccionesCalidad
 * @property integer $IdProduccion
 * @property integer $IdCentroTrabajo
 * @property string $Procedimiento
 * @property string $Norma
 *
 * @property Producciones $idProduccion
 */
class ProduccionesCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesCalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdCentroTrabajo'], 'required'],
            [['IdProduccion', 'IdCentroTrabajo'], 'integer'],
            [['Procedimiento', 'Norma'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccionesCalidad' => 'Id Producciones Calidad',
            'IdProduccion' => 'Id Produccion',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Procedimiento' => 'Procedimiento',
            'Norma' => 'Norma',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }
}
