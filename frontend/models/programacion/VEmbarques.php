<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_Embarques".
 *
 * @property string $Fecha
 * @property integer $Cantidad
 * @property string $Nota
 * @property string $FechaCreacion
 * @property integer $IdEmbarque
 * @property integer $OE
 * @property string $OC
 * @property string $FechaRecepcion
 * @property string $FechaEmbarque
 * @property string $FechaEntrega
 * @property string $ParteFimex
 * @property string $ParteCliente
 * @property integer $NivelRiesgo
 * @property string $Almacen
 * @property string $Observaciones
 * @property string $Aleacion
 * @property string $QTY
 * @property string $Serie
 * @property string $Balance
 * @property string $CODYNUMPAR
 * @property string $TotalPartida
 * @property string $NOMBRE
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
 * @property string $EntregaEmbarque
 */
class VEmbarques extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Embarques';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Fecha', 'FechaCreacion', 'FechaRecepcion', 'FechaEmbarque', 'FechaEntrega', 'EntregaEmbarque'], 'safe'],
            [['Cantidad', 'IdEmbarque', 'OE', 'NivelRiesgo', 'Linea'], 'integer'],
            [['Nota', 'OC', 'ParteFimex', 'ParteCliente', 'Almacen', 'Observaciones', 'Aleacion', 'Serie', 'CODYNUMPAR', 'NOMBRE', 'Descripcion'], 'string'],
            [['IdEmbarque', 'FechaRecepcion', 'NivelRiesgo', 'QTY', 'Balance', 'CODYNUMPAR', 'PesoCastingA'], 'required'],
            [['QTY', 'Balance', 'TotalPartida', 'PLA', 'PLA2', 'PMA', 'PMA2', 'CTA', 'CTA2', 'PTA', 'PesoCastingA', 'PrecioUnitario'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Fecha' => 'Fecha',
            'Cantidad' => 'Cantidad',
            'Nota' => 'Nota',
            'FechaCreacion' => 'Fecha Creacion',
            'IdEmbarque' => 'Id Embarque',
            'OE' => 'Oe',
            'OC' => 'Oc',
            'FechaRecepcion' => 'Fecha Recepcion',
            'FechaEmbarque' => 'Fecha Embarque',
            'FechaEntrega' => 'Fecha Entrega',
            'ParteFimex' => 'Parte Fimex',
            'ParteCliente' => 'Parte Cliente',
            'NivelRiesgo' => 'Nivel Riesgo',
            'Almacen' => 'Almacen',
            'Observaciones' => 'Observaciones',
            'Aleacion' => 'Aleacion',
            'QTY' => 'Qty',
            'Serie' => 'Serie',
            'Balance' => 'Balance',
            'CODYNUMPAR' => 'Codynumpar',
            'TotalPartida' => 'Total Partida',
            'NOMBRE' => 'Nombre',
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
            'EntregaEmbarque' => 'Entrega Embarque',
        ];
    }
}
