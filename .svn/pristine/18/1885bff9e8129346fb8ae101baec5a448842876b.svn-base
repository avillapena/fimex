<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "VMaterialesCalidad".
 *
 * @property integer $IdMaterial
 * @property string $Identificador
 * @property string $Nombre
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property integer $IdMaterialTipo
 * @property integer $IdCentroTrabajo
 * @property string $Descripcion
 */
class VMaterialesCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'VMaterialesCalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMaterial', 'Identificador', 'IdSubProceso', 'IdArea', 'IdMaterialTipo'], 'required'],
            [['IdMaterial', 'IdSubProceso', 'IdArea', 'IdMaterialTipo', 'IdCentroTrabajo'], 'integer'],
            [['Identificador', 'Nombre', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMaterial' => 'Id Material',
            'Identificador' => 'Identificador',
            'Nombre' => 'Nombre',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'IdMaterialTipo' => 'Id Material Tipo',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Descripcion' => 'Descripcion',
        ];
    }
}
