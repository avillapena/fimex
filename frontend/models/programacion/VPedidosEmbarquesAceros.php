<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_PedidosEmbarquesAceros".
 *
 * @property integer $OE
 * @property string $OC
 * @property string $FechaRecepcion
 * @property string $FechaEmbarque
 * @property string $FechaEntrega
 * @property string $ParteFimex
 * @property integer $NivelRiesgo
 * @property string $Almacen
 * @property string $Observaciones
 * @property string $Aleacion
 * @property string $QTY
 * @property string $Balance
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
 */
class VPedidosEmbarquesAceros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_PedidosEmbarquesAceros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OE', 'NivelRiesgo', 'Linea'], 'integer'],
            [['OC', 'ParteFimex', 'Almacen', 'Observaciones', 'Aleacion', 'NOMBRE', 'Descripcion'], 'string'],
            [['FechaRecepcion', 'NivelRiesgo', 'QTY', 'Balance', 'PesoCastingA'], 'required'],
            [['FechaRecepcion', 'FechaEmbarque', 'FechaEntrega'], 'safe'],
            [['QTY', 'Balance', 'TotalPartida', 'PLA', 'PLA2', 'PMA', 'PMA2', 'CTA', 'CTA2', 'PTA', 'PesoCastingA', 'PrecioUnitario'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'OE' => 'Oe',
            'OC' => 'Oc',
            'FechaRecepcion' => 'Fecha Recepcion',
            'FechaEmbarque' => 'Fecha Embarque',
            'FechaEntrega' => 'Fecha Entrega',
            'ParteFimex' => 'Parte Fimex',
            'NivelRiesgo' => 'Nivel Riesgo',
            'Almacen' => 'Almacen',
            'Observaciones' => 'Observaciones',
            'Aleacion' => 'Aleacion',
            'QTY' => 'Qty',
            'Balance' => 'Balance',
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
        ];
    }
}
