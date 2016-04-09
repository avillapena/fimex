<?php

namespace frontend\models\certificados;

use Yii;
use common\models\dux\Productos;

/**
 * This is the model class for table "CertificadoTTDetalle".
 *
 * @property integer $IdCertificadoTTDetalle
 * @property string $OrdenDeCompra
 * @property integer $IdProducto
 * @property integer $Cantidad
 * @property integer $IdCertificadoTT
 *
 * @property CertificadoTT $idCertificadoTT
 * @property Productos $idProducto
 * @property CertTTColada[] $certTTColadas
 * @property CertTTSerie[] $certTTSeries
 */
class CertificadoTTDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertificadoTTDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OrdenDeCompra', 'IdProducto', 'IdCertificadoTT'], 'required'],
            [['OrdenDeCompra'], 'string'],
            [['IdProducto', 'Cantidad', 'IdCertificadoTT'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertificadoTTDetalle' => 'Id Certificado Ttdetalle',
            'OrdenDeCompra' => 'Orden De Compra',
            'IdProducto' => 'Id Producto',
            'Cantidad' => 'Cantidad',
            'IdCertificadoTT' => 'Id Certificado Tt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCertificadoTT()
    {
        return $this->hasOne(CertificadoTT::className(), ['IdCertificadoTT' => 'IdCertificadoTT']);
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
    public function getCertTTColadas()
    {
        return $this->hasMany(CertTTColada::className(), ['IdCertificadoTTDetalle' => 'IdCertificadoTTDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertTTSeries()
    {
        return $this->hasMany(CertTTSerie::className(), ['IdCertificadoTTDetalle' => 'IdCertificadoTTDetalle']);
    }
}
