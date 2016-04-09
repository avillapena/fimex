<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "v_Existencias".
 *
 * @property integer $IdAlmacen
 * @property string $Almacen
 * @property integer $IdProducto
 * @property string $Producto
 * @property string $Existencia
 * @property string $CostoPromedio
 */
class VExistencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Existencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAlmacen', 'IdProducto', 'Existencia', 'CostoPromedio'], 'required'],
            [['IdAlmacen', 'IdProducto'], 'integer'],
            [['Almacen', 'Producto'], 'string'],
            [['Existencia', 'CostoPromedio'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlmacen' => 'Id Almacen',
            'Almacen' => 'Almacen',
            'IdProducto' => 'Id Producto',
            'Producto' => 'Producto',
            'Existencia' => 'Existencia',
            'CostoPromedio' => 'Costo Promedio',
        ];
    }
}
