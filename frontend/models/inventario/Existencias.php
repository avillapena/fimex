<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "Existencias".
 *
 * @property integer $IdExistencias
 * @property integer $IdSubProceso
 * @property integer $IdCentroTrabajo
 * @property integer $IdProducto
 * @property integer $Existencia
 * @property integer $Hecho
 *
 * @property CentrosTrabajo $idCentroTrabajo
 * @property Productos $idProducto
 * @property ExistenciasDetalle[] $existenciasDetalles
 */
class Existencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Existencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdSubProceso', 'IdCentroTrabajo', 'IdProducto'], 'required'],
            [['IdSubProceso', 'IdCentroTrabajo', 'IdProducto', 'Existencia','Hecho'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdExistencias' => 'Id Existencias',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdProducto' => 'Id Producto',
            'Existencia' => 'Existencia',
            'Hecho' => 'Hecho',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCentroTrabajo()
    {
        return $this->hasOne(CentrosTrabajo::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistenciasDetalles()
    {
        return $this->hasMany(ExistenciasDetalle::className(), ['IdExistencia' => 'IdExistencias']);
    }
}
