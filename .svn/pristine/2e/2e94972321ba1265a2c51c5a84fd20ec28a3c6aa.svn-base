<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Camisas".
 *
 * @property integer $IdCamisa
 * @property integer $IdProducto
 * @property integer $IdCamisaTipo
 * @property integer $Cantidad
 * @property string $Observaciones
 *
 * @property CamisasTipo $idCamisaTipo
 * @property Productos $idProducto
 */
class Camisas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Camisas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdCamisaTipo'], 'required'],
            [['IdProducto', 'IdCamisaTipo', 'Cantidad'], 'integer'],
            [['Observaciones'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCamisa' => 'Id Camisa',
            'IdProducto' => 'Id Producto',
            'IdCamisaTipo' => 'Id Camisa Tipo',
            'Cantidad' => 'Cantidad',
            'Observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCamisaTipo()
    {
        return $this->hasOne(CamisasTipo::className(), ['IdCamisaTipo' => 'IdCamisaTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
}
