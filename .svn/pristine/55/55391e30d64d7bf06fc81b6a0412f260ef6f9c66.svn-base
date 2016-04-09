<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_BitacoraCalidad".
 *
 * @property integer $IdBitacoraCalidad
 * @property integer $IdProducto
 * @property integer $Cantidad
 * @property integer $IdUsuario
 * @property double $TPenetracion
 * @property double $TRevelado
 * @property string $Aplicacion
 * @property string $Fecha
 * @property string $Identificacion
 * @property string $Hechas
 * @property integer $IdEstatus
 * @property string $FechaMoldeo
 */
class VBitacoraCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_BitacoraCalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdBitacoraCalidad'], 'required'],
            [['IdBitacoraCalidad', 'IdProducto', 'Cantidad', 'IdUsuario', 'IdEstatus'], 'integer'],
            [['TPenetracion', 'TRevelado', 'Hechas'], 'number'],
            [['Aplicacion', 'Identificacion', 'FechaMoldeo'], 'string'],
            [['Fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdBitacoraCalidad' => 'Id Bitacora Calidad',
            'IdProducto' => 'Id Producto',
            'Cantidad' => 'Cantidad',
            'IdUsuario' => 'Id Usuario',
            'TPenetracion' => 'Tpenetracion',
            'TRevelado' => 'Trevelado',
            'Aplicacion' => 'Aplicacion',
            'Fecha' => 'Fecha',
            'Identificacion' => 'Identificacion',
            'Hechas' => 'Hechas',
            'IdEstatus' => 'Id Estatus',
            'FechaMoldeo' => 'Fecha Moldeo',
        ];
    }
}
