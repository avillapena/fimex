<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "TipoProbeta".
 *
 * @property integer $idTipoProbeta
 * @property string $Descripcion
 */
class TipoProbeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TipoProbeta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTipoProbeta' => 'Id Tipo Probeta',
            'Descripcion' => 'Descripcion',
        ];
    }
}
