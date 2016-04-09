<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "v_CamisasTipo".
 *
 * @property integer $IdCamisaTipo
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $CantidadPorPaquete
 * @property string $DUX_CodigoPesos
 * @property string $DUX_CodigoDolares
 * @property string $Tamano
 * @property string $TiempoDesmoldeo
 * @property string $ExistenciaDolares
 * @property string $ExistenciaPesos
 */
class VCamisasTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CamisasTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCamisaTipo', 'Identificador', 'Descripcion', 'CantidadPorPaquete'], 'required'],
            [['IdCamisaTipo', 'CantidadPorPaquete'], 'integer'],
            [['Identificador', 'Descripcion', 'DUX_CodigoPesos', 'DUX_CodigoDolares', 'Tamano'], 'string'],
            [['TiempoDesmoldeo', 'ExistenciaDolares', 'ExistenciaPesos'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCamisaTipo' => 'Id Camisa Tipo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'CantidadPorPaquete' => 'Cantidad Por Paquete',
            'DUX_CodigoPesos' => 'Dux  Codigo Pesos',
            'DUX_CodigoDolares' => 'Dux  Codigo Dolares',
            'Tamano' => 'Tamano',
            'TiempoDesmoldeo' => 'Tiempo Desmoldeo',
            'ExistenciaDolares' => 'Existencia Dolares',
            'ExistenciaPesos' => 'Existencia Pesos',
        ];
    }
}
