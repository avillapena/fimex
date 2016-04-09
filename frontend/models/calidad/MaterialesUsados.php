<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "MaterialesUsados".
 *
 * @property integer $IdMaterialesUsados
 * @property integer $IdProduccion
 * @property integer $Clase
 * @property integer $IdMarca
 * @property integer $IdTipo
 * @property string $Lote
 * @property string $vExtra
 *
 * @property Producciones $idProduccion
 */
class MaterialesUsados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MaterialesUsados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'Clase', 'IdMarca', 'IdTipo'], 'required'],
            [['IdProduccion', 'Clase', 'IdMarca', 'IdTipo'], 'integer'],
            [['Lote', 'vExtra'], 'string']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }
}
