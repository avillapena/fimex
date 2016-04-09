<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "Embarques".
 *
 * @property integer $IdEmbarque
 * @property integer $IdPedido
 * @property string $Fecha
 * @property integer $Cantidad
 * @property string $FechaEntrega
 * @property string $Observaciones
 * @property string $Nota
 * @property string $FechaCreacion
 * @property string $Cliente
 * @property integer $IdArea
 *
 * @property Pedidos $idPedido
 */
class Embarques extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Embarques';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPedido', 'Cantidad', 'IdArea'], 'integer'],
            [['Fecha', 'FechaEntrega', 'FechaCreacion'], 'safe'],
            [['Observaciones', 'Nota', 'Cliente'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEmbarque' => 'Id Embarque',
            'IdPedido' => 'Id Pedido',
            'Fecha' => 'Fecha',
            'Cantidad' => 'Cantidad',
            'FechaEntrega' => 'Fecha Entrega',
            'Observaciones' => 'Observaciones',
            'Nota' => 'Nota',
            'FechaCreacion' => 'Fecha Creacion',
            'Cliente' => 'Cliente',
            'IdArea' => 'Id Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPedido()
    {
        return $this->hasOne(Pedidos::className(), ['IdPedido' => 'IdPedido']);
    }
}
