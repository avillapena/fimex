<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "SerieCavidad".
 *
 * @property integer $IdSerieCavidad
 * @property integer $IdProducto
 * @property string $Prefijo
 * @property string $ConsecutivoCavidad
 */
class SerieCavidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SerieCavidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto'], 'integer'],
            [['Prefijo', 'ConsecutivoCavidad'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdSerieCavidad' => 'Id Serie Cavidad',
            'IdProducto' => 'Id Producto',
            'Prefijo' => 'Prefijo',
            'ConsecutivoCavidad' => 'Consecutivo Cavidad',
        ];
    }
}
