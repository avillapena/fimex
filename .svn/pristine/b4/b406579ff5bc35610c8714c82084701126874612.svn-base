<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "BitacoraCalidad".
 *
 * @property integer $IdBitacoraCalidad
 * @property integer $IdProduccionesDetalles
 * @property integer $IdProducto
 * @property integer $Cantidad
 * @property integer $IdUsuario
 * @property string $Fecha
 * @property integer $IdEstatus
 * @property double $TPenetracion
 * @property double $TRevelado
 * @property string $Aplicacion
 * @property string $FechaMoldeo
 *
 * @property EvidenciasCalidad[] $evidenciasCalidads
 */
class BitacoraCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BitacoraCalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccionesDetalles', 'IdProducto', 'Cantidad', 'IdUsuario', 'IdEstatus'], 'integer'],
            [['Fecha'], 'safe'],
            [['TPenetracion', 'TRevelado'], 'number'],
            [['Aplicacion', 'FechaMoldeo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdBitacoraCalidad' => 'Id Bitacora Calidad',
            'IdProduccionesDetalles' => 'Id Producciones Detalles',
            'IdProducto' => 'Id Producto',
            'Cantidad' => 'Cantidad',
            'IdUsuario' => 'Id Usuario',
            'Fecha' => 'Fecha',
            'IdEstatus' => 'Id Estatus',
            'TPenetracion' => 'Tpenetracion',
            'TRevelado' => 'Trevelado',
            'Aplicacion' => 'Aplicacion',
            'FechaMoldeo' => 'Fecha Moldeo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvidenciasCalidads()
    {
        return $this->hasMany(EvidenciasCalidad::className(), ['IdBitacoraCalidad' => 'IdBitacoraCalidad']);
    }
}
