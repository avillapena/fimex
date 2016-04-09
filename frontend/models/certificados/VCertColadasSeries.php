<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "V_CertColadasSeries".
 *
 * @property integer $IdLance
 * @property integer $Lance
 * @property integer $Colada
 * @property string $Fecha
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property integer $IdTurno
 * @property string $Hechas
 * @property string $Serie
 * @property string $Estatus
 * @property string $LlevaSerie
 * @property string $CodProducto
 * @property string $DescProducto
 * @property string $Aleacion
 */
class VCertColadasSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'V_CertColadasSeries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdLance', 'Lance', 'Colada', 'Fecha', 'IdSubProceso', 'IdArea'], 'required'],
            [['IdLance', 'Lance', 'Colada', 'IdSubProceso', 'IdArea', 'IdTurno'], 'integer'],
            [['Fecha'], 'safe'],
            [['Hechas'], 'number'],
            [['Serie', 'Estatus', 'LlevaSerie', 'CodProducto', 'DescProducto', 'Aleacion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdLance' => 'Id Lance',
            'Lance' => 'Lance',
            'Colada' => 'Colada',
            'Fecha' => 'Fecha',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'IdTurno' => 'Id Turno',
            'Hechas' => 'Hechas',
            'Serie' => 'Serie',
            'Estatus' => 'Estatus',
            'LlevaSerie' => 'Lleva Serie',
            'CodProducto' => 'Cod Producto',
            'DescProducto' => 'Desc Producto',
            'Aleacion' => 'Aleacion',
        ];
    }
}
