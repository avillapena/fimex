<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "v_CentrosRutas".
 *
 * @property integer $IdSubProceso
 * @property string $Identificador
 * @property integer $IdArea
 * @property integer $IdCentroTrabajoOrigen
 * @property string $Origen
 * @property integer $IdCentroTrabajoDestino
 * @property string $Destino
 */
class VCentrosRutas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CentrosRutas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdSubProceso', 'Identificador', 'IdArea', 'IdCentroTrabajoOrigen', 'Origen', 'IdCentroTrabajoDestino', 'Destino'], 'required'],
            [['IdSubProceso', 'IdArea', 'IdCentroTrabajoOrigen', 'IdCentroTrabajoDestino'], 'integer'],
            [['Identificador', 'Origen', 'Destino'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdSubProceso' => 'Id Sub Proceso',
            'Identificador' => 'Identificador',
            'IdArea' => 'Id Area',
            'IdCentroTrabajoOrigen' => 'Id Centro Trabajo Origen',
            'Origen' => 'Origen',
            'IdCentroTrabajoDestino' => 'Id Centro Trabajo Destino',
            'Destino' => 'Destino',
        ];
    }
}
