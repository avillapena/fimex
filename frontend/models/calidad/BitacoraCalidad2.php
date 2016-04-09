<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "BitacoraCalidad".
 *
 * @property integer $IdBitacoraCalidad
 * @property integer $IdProduccionesCalidad
 * @property integer $IdProducto
 * @property integer $Cantidad
 * @property integer $IdUsuario
 * @property string $Fecha
 * @property integer $IdEstatus
 * @property double $TPenetracion
 * @property double $TRevelado
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
            [['IdProduccionesCalidad', 'IdProducto', 'Cantidad', 'IdUsuario', 'IdEstatus'], 'integer'],
            [['Fecha'], 'safe'],
            [['TPenetracion', 'TRevelado'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdBitacoraCalidad' => 'Id Bitacora Calidad',
            'IdProduccionesCalidad' => 'Id Producciones Calidad',
            'IdProducto' => 'Id Producto',
            'Cantidad' => 'Cantidad',
            'IdUsuario' => 'Id Usuario',
            'Fecha' => 'Fecha',
            'IdEstatus' => 'Id Estatus',
            'TPenetracion' => 'Tpenetracion',
            'TRevelado' => 'Trevelado',
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
