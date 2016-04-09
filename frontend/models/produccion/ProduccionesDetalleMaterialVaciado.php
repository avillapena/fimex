<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "ProduccionesDetalleMaterialVaciado".
 *
 * @property integer $Id
 * @property integer $IdProduccionDetalle
 * @property integer $IdMaterialVaciado
 *
 * @property MaterialesVaciado $idMaterialVaciado
 * @property ProduccionesDetalle $idProduccionesDetalle
 */
class ProduccionesDetalleMaterialVaciado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesDetalleMaterialVaciado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccionDetalle'], 'required'],
            [['IdProduccionDetalle', 'IdMaterialVaciado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdProduccionDetalle' => 'Id Producciones Detalle',
            'IdMaterialVaciado' => 'Id Material Vaciado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaterialVaciado()
    {
        return $this->hasOne(MaterialesVaciado::className(), ['IdMaterialVaciado' => 'IdMaterialVaciado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalle()
    {
        return $this->hasOne(ProduccionesDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }
}
