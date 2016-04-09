<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_Existencias".
 *
 * @property integer $Existencia
 * @property integer $Hecho
 * @property string $FechaMoldeo
 * @property integer $IdExistencias
 * @property integer $IdProducto
 * @property integer $IdCentroTrabajo
 * @property integer $IdSubProceso
 */
class VExistencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Existencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Existencia', 'IdExistencias', 'IdProducto', 'IdCentroTrabajo', 'IdSubProceso'], 'required'],
            [['Existencia', 'Hecho', 'IdExistencias', 'IdProducto', 'IdCentroTrabajo', 'IdSubProceso'], 'integer'],
            [['FechaMoldeo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Existencia' => 'Existencia',
            'Hecho' => 'Hecho',
            'FechaMoldeo' => 'Fecha Moldeo',
            'IdExistencias' => 'Id Existencias',
            'IdProducto' => 'Id Producto',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdSubProceso' => 'Id Sub Proceso',
        ];
    }
}
