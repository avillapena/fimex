<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "Normas".
 *
 * @property integer $IdNorma
 * @property integer $IdAleacion
 * @property string $NombreNorma
 *
 * @property Aleaciones $idAleacion
 * @property NormaMediciones[] $normaMediciones
 */
class Normas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Normas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAleacion', 'NombreNorma'], 'required'],
            [['IdAleacion'], 'integer'],
            [['NombreNorma'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdNorma' => 'Id Norma',
            'IdAleacion' => 'Id Aleacion',
            'NombreNorma' => 'Nombre Norma',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAleacion()
    {
        return $this->hasOne(Aleaciones::className(), ['IdAleacion' => 'IdAleacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNormaMediciones()
    {
        return $this->hasMany(NormaMediciones::className(), ['IdNorma' => 'IdNorma']);
    }
}
