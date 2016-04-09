<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "v_Normas".
 *
 * @property integer $IdNorma
 * @property integer $IdAleacion
 * @property string $NombreNorma
 * @property string $Identificador
 */
class VNormas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Normas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdNorma', 'IdAleacion', 'NombreNorma'], 'required'],
            [['IdNorma', 'IdAleacion'], 'integer'],
            [['NombreNorma', 'Identificador'], 'string']
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
            'Identificador' => 'Identificador',
        ];
    }
}
