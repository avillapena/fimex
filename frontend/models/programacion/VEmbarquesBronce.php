<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_EmbarquesBronce".
 *
 * @property integer $IdArea
 * @property string $Fecha
 * @property integer $Cantidad
 * @property string $Nota
 * @property string $FechaCreacion
 * @property integer $IdEmbarque
 * @property string $Observaciones
 * @property integer $OE
 * @property string $OC
 * @property string $FechaRecepcion
 * @property string $FechaEmbarque
 * @property integer $Anio
 * @property string $class
 * @property string $FechaEntrega
 * @property integer $IdProducto
 * @property string $ParteFimex
 * @property string $ParteCliente
 * @property integer $NivelRiesgo
 * @property string $Almacen
 * @property string $Aleacion
 * @property string $QTY
 * @property string $Serie
 * @property string $Balance
 * @property string $CODYNUMPAR
 * @property string $TotalPartida
 * @property string $TotalBalance
 * @property string $PesoBalance
 * @property string $Cliente
 * @property string $PLB
 * @property string $PLB2
 * @property string $PMB
 * @property string $PMB2
 * @property string $CTB
 * @property string $CTB2
 * @property string $PTB
 * @property string $Descripcion
 * @property string $PesoCastingA
 * @property string $PrecioUnitario
 * @property integer $Linea
 * @property string $EntregaEmbarque
 */
class VEmbarquesBronce extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_EmbarquesBronce';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Cantidad', 'IdEmbarque', 'OE', 'Anio', 'IdProducto', 'NivelRiesgo', 'Linea'], 'integer'],
            [['Fecha', 'FechaCreacion', 'FechaRecepcion', 'FechaEmbarque', 'FechaEntrega', 'EntregaEmbarque'], 'safe'],
            [['Nota', 'Observaciones', 'OC', 'class', 'ParteFimex', 'ParteCliente', 'Almacen', 'Aleacion', 'Serie', 'CODYNUMPAR', 'Cliente', 'Descripcion'], 'string'],
            [['IdEmbarque'], 'required'],
            [['QTY', 'Balance', 'TotalPartida', 'TotalBalance', 'PesoBalance', 'PLB', 'PLB2', 'PMB', 'PMB2', 'CTB', 'CTB2', 'PTB', 'PesoCastingA', 'PrecioUnitario'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'Fecha' => 'Fecha',
            'Cantidad' => 'Cantidad',
            'Nota' => 'Nota',
            'FechaCreacion' => 'Fecha Creacion',
            'IdEmbarque' => 'Id Embarque',
            'Observaciones' => 'Observaciones',
            'OE' => 'Oe',
            'OC' => 'Oc',
            'FechaRecepcion' => 'Fecha Recepcion',
            'FechaEmbarque' => 'Fecha Embarque',
            'Anio' => 'Anio',
            'class' => 'Class',
            'FechaEntrega' => 'Fecha Entrega',
            'IdProducto' => 'Id Producto',
            'ParteFimex' => 'Parte Fimex',
            'ParteCliente' => 'Parte Cliente',
            'NivelRiesgo' => 'Nivel Riesgo',
            'Almacen' => 'Almacen',
            'Aleacion' => 'Aleacion',
            'QTY' => 'Qty',
            'Serie' => 'Serie',
            'Balance' => 'Balance',
            'CODYNUMPAR' => 'Codynumpar',
            'TotalPartida' => 'Total Partida',
            'TotalBalance' => 'Total Balance',
            'PesoBalance' => 'Peso Balance',
            'Cliente' => 'Cliente',
            'PLB' => 'Plb',
            'PLB2' => 'Plb2',
            'PMB' => 'Pmb',
            'PMB2' => 'Pmb2',
            'CTB' => 'Ctb',
            'CTB2' => 'Ctb2',
            'PTB' => 'Ptb',
            'Descripcion' => 'Descripcion',
            'PesoCastingA' => 'Peso Casting A',
            'PrecioUnitario' => 'Precio Unitario',
            'Linea' => 'Linea',
            'EntregaEmbarque' => 'Entrega Embarque',
        ];
    }
}
