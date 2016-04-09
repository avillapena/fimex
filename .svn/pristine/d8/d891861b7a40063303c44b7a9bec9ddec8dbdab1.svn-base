<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_CalidadResumen".
 *
 * @property integer $IdProduccion
 * @property integer $IdProducto
 * @property string $Aceptadas
 * @property string $Reparaciones
 * @property string $Scrap
 */
class VCalidadResumen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CalidadResumen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion'], 'required'],
            [['IdProduccion', 'IdProducto'], 'integer'],
            [['Aceptadas', 'Reparaciones', 'Scrap'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdProducto' => 'Id Producto',
            'Aceptadas' => 'Aceptadas',
            'Reparaciones' => 'Reparaciones',
            'Scrap' => 'Scrap',
        ];
    }
}
