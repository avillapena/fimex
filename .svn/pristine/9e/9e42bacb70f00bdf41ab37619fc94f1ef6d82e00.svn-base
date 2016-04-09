<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "ExistenciasDetalle".
 *
 * @property integer $IdExistenciaDetalle
 * @property integer $IdExistencia
 * @property string $FechaMoldeo
 * @property integer $Existencia
 * @property integer $Hecho
 *
 * @property Existencias $idExistencia
 */
class ExistenciasDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ExistenciasDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdExistencia', 'Existencia'], 'integer'],
            [['FechaMoldeo'], 'string'],
            [['Existencia','Hecho'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdExistenciaDetalle' => 'Id Existencia Detalle',
            'IdExistencia' => 'Id Existencia',
            'FechaMoldeo' => 'Fecha Moldeo',
            'Existencia' => 'Existencia',
            'Hecho' => 'Hecho',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdExistencia()
    {
        return $this->hasOne(Existencias::className(), ['IdExistencias' => 'IdExistencia']);
    }
}
