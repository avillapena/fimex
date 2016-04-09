<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Cajas".
 *
 * @property integer $IdCaja
 * @property integer $IdProducto
 * @property integer $IdTipoCaja
 * @property integer $PiezasXCaja
 * @property string $Observaciones
 *
 * @property CajasTipo $idTipoCaja
 * @property Productos $idProducto
 */
class Cajas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Cajas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdTipoCaja', 'PiezasXCaja'], 'required'],
            [['IdProducto', 'IdTipoCaja', 'PiezasXCaja'], 'integer'],
            [['Observaciones'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCaja' => 'Id Caja',
            'IdProducto' => 'Id Producto',
            'IdTipoCaja' => 'Id Tipo Caja',
            'PiezasXCaja' => 'Piezas Xcaja',
            'Observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoCaja()
    {
        return $this->hasOne(CajasTipo::className(), ['IdTipoCaja' => 'IdTipoCaja']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
}
