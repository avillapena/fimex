<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_PedidosEmbarquesBronces".
 *
 * @property integer $IdPedido
 * @property integer $IdArea
 * @property integer $OE
 * @property string $OC
 * @property string $FechaRecepcion
 * @property string $FechaEmbarque
 * @property string $FechaEntrega
 * @property integer $IdProducto
 * @property string $ParteFimex
 * @property string $ParteCliente
 * @property integer $NivelRiesgo
 * @property string $Almacen
 * @property string $Observaciones
 * @property string $Aleacion
 * @property string $QTY
 * @property string $Serie
 * @property string $Balance
 * @property string $Cantidad
 * @property string $AnioMes
 * @property integer $Anio
 * @property integer $Mes2
 * @property string $class
 * @property string $CODYNUMPAR
 * @property string $TotalPartida
 * @property string $TotalBalance
 * @property string $PesoPartida
 * @property string $PesoBalance
 * @property string $NOMBRE
 * @property string $Cliente
 * @property string $PLA
 * @property string $PLA2
 * @property string $PMA
 * @property string $PMA2
 * @property string $CTA
 * @property string $CTA2
 * @property string $PTA
 * @property string $Descripcion
 * @property string $PesoCastingA
 * @property string $PrecioUnitario
 * @property integer $Linea
 */
class VPedidosEmbarquesBronces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_PedidosEmbarquesBronces';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPedido', 'FechaRecepcion', 'IdProducto', 'NivelRiesgo', 'QTY', 'Balance', 'Cantidad', 'AnioMes', 'class', 'CODYNUMPAR', 'PesoCastingA'], 'required'],
            [['IdPedido', 'IdArea', 'OE', 'IdProducto', 'NivelRiesgo', 'Anio', 'Mes2', 'Linea'], 'integer'],
            [['OC', 'ParteFimex', 'ParteCliente', 'Almacen', 'Observaciones', 'Aleacion', 'Serie', 'AnioMes', 'class', 'CODYNUMPAR', 'NOMBRE', 'Cliente', 'Descripcion'], 'string'],
            [['FechaRecepcion', 'FechaEmbarque', 'FechaEntrega'], 'safe'],
            [['QTY', 'Balance', 'Cantidad', 'TotalPartida', 'TotalBalance', 'PesoPartida', 'PesoBalance', 'PLA', 'PLA2', 'PMA', 'PMA2', 'CTA', 'CTA2', 'PTA', 'PesoCastingA', 'PrecioUnitario'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPedido' => 'Id Pedido',
            'IdArea' => 'Id Area',
            'OE' => 'Oe',
            'OC' => 'Oc',
            'FechaRecepcion' => 'Fecha Recepcion',
            'FechaEmbarque' => 'Fecha Embarque',
            'FechaEntrega' => 'Fecha Entrega',
            'IdProducto' => 'Id Producto',
            'ParteFimex' => 'Parte Fimex',
            'ParteCliente' => 'Parte Cliente',
            'NivelRiesgo' => 'Nivel Riesgo',
            'Almacen' => 'Almacen',
            'Observaciones' => 'Observaciones',
            'Aleacion' => 'Aleacion',
            'QTY' => 'Qty',
            'Serie' => 'Serie',
            'Balance' => 'Balance',
            'Cantidad' => 'Cantidad',
            'AnioMes' => 'Anio Mes',
            'Anio' => 'Anio',
            'Mes2' => 'Mes2',
            'class' => 'Class',
            'CODYNUMPAR' => 'Codynumpar',
            'TotalPartida' => 'Total Partida',
            'TotalBalance' => 'Total Balance',
            'PesoPartida' => 'Peso Partida',
            'PesoBalance' => 'Peso Balance',
            'NOMBRE' => 'Nombre',
            'Cliente' => 'Cliente',
            'PLA' => 'Pla',
            'PLA2' => 'Pla2',
            'PMA' => 'Pma',
            'PMA2' => 'Pma2',
            'CTA' => 'Cta',
            'CTA2' => 'Cta2',
            'PTA' => 'Pta',
            'Descripcion' => 'Descripcion',
            'PesoCastingA' => 'Peso Casting A',
            'PrecioUnitario' => 'Precio Unitario',
            'Linea' => 'Linea',
        ];
    }
}
