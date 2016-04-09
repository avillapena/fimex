<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "Certificados".
 *
 * @property integer $IdCertificado
 * @property integer $IdTipoCertificado
 * @property integer $NoCertificado
 * @property string $IdEquipo
 * @property string $Fecha
 * @property string $OrdenCompra
 * @property string $Observaciones
 * @property integer $IdNorma
 * @property string $Factura
 *
 * @property CertificadosExtendido[] $certificadosExtendidos
 * @property Normas $idNorma
 * @property TiposCertificados $idTipoCertificado
 * @property CertificadosAQ[] $certificadosAQs
 * @property Responsables[] $responsables
 */
class Certificados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Certificados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTipoCertificado', 'NoCertificado', 'IdNorma'], 'integer'],
            [['IdEquipo', 'OrdenCompra', 'Observaciones', 'Factura'], 'string'],
            [['Fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertificado' => 'Id Certificado',
            'IdTipoCertificado' => 'Id Tipo Certificado',
            'NoCertificado' => 'No Certificado',
            'IdEquipo' => 'Id Equipo',
            'Fecha' => 'Fecha',
            'OrdenCompra' => 'Orden Compra',
            'Observaciones' => 'Observaciones',
            'IdNorma' => 'Id Norma',
            'Factura' => 'Factura',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificadosExtendidos()
    {
        return $this->hasMany(CertificadosExtendido::className(), ['IdCertificado' => 'IdCertificado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNorma()
    {
        return $this->hasOne(Normas::className(), ['IdNorma' => 'IdNorma']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoCertificado()
    {
        return $this->hasOne(TiposCertificados::className(), ['IdTipoCertificado' => 'IdTipoCertificado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificadosAQs()
    {
        return $this->hasMany(CertificadosAQ::className(), ['IdCertificado' => 'IdCertificado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsables()
    {
        return $this->hasMany(Responsables::className(), ['IdCertificado' => 'IdCertificado']);
    }
}
