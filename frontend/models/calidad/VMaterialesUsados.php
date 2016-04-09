<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_MaterialesUsados".
 *
 * @property integer $IdMaterialesUsados
 * @property integer $IdProduccion
 * @property integer $Clase
 * @property integer $IdMarca
 * @property integer $IdTipo
 * @property string $Lote
 * @property string $vExtra
 * @property string $ClaseDescripcion
 * @property string $MarcaDescripcion
 * @property string $TipoDescripcion
 */
class VMaterialesUsados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_MaterialesUsados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMaterialesUsados', 'IdProduccion', 'Clase', 'IdMarca', 'IdTipo'], 'required'],
            [['IdMaterialesUsados', 'IdProduccion', 'Clase', 'IdMarca', 'IdTipo'], 'integer'],
            [['Lote', 'vExtra', 'ClaseDescripcion', 'MarcaDescripcion', 'TipoDescripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMaterialesUsados' => 'Id Materiales Usados',
            'IdProduccion' => 'Id Produccion',
            'Clase' => 'Clase',
            'IdMarca' => 'Id Marca',
            'IdTipo' => 'Id Tipo',
            'Lote' => 'Lote',
            'vExtra' => 'V Extra',
            'ClaseDescripcion' => 'Clase Descripcion',
            'MarcaDescripcion' => 'Marca Descripcion',
            'TipoDescripcion' => 'Tipo Descripcion',
        ];
    }
}
