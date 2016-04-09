<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "CertificadosDetalle".
 *
 * @property integer $IdCertificadoDetalle
 * @property integer $IdCertificado
 * @property integer $IdProducto
 * @property integer $Cantidad
 * @property string $FechaMoldeo
 *
 * @property CertificadosSeries[] $certificadosSeries
 * @property Productos $idProducto
 */
class CertificadosDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertificadosDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCertificado', 'IdProducto', 'Cantidad'], 'integer'],
            [['FechaMoldeo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertificadoDetalle' => 'Id Certificado Detalle',
            'IdCertificado' => 'Id Certificado',
            'IdProducto' => 'Id Producto',
            'Cantidad' => 'Cantidad',
            'FechaMoldeo' => 'Fecha Moldeo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificadosSeries()
    {
        return $this->hasMany(CertificadosSeries::className(), ['IdCertificadoDetalle' => 'IdCertificadoDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
}
