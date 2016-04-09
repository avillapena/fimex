<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "ProductosTratamientos".
 *
 * @property integer $idProductosTratamientos
 * @property string $NoParte
 * @property string $TipoTT
 * @property integer $Min
 * @property integer $Max
 */
class ProductosTratamientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProductosTratamientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NoParte', 'TipoTT', 'Min', 'Max'], 'required'],
            [['NoParte', 'TipoTT'], 'string'],
            [['Min', 'Max'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idProductosTratamientos' => 'Id Productos Tratamientos',
            'NoParte' => 'No Parte',
            'TipoTT' => 'Tipo Tt',
            'Min' => 'Min',
            'Max' => 'Max',
        ];
    }
}
