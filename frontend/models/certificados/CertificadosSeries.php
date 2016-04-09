<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "CertificadosSeries".
 *
 * @property integer $IdCertificadoSerie
 * @property integer $IdSerie
 * @property integer $IdCertificadoDetalle
 * @property string $Fecha
 *
 * @property CertificadosDetalle $idCertificadoDetalle
 * @property Series $idSerie
 */
class CertificadosSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertificadosSeries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdSerie', 'IdCertificadoDetalle'], 'integer'],
            [['Fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertificadoSerie' => 'Id Certificado Serie',
            'IdSerie' => 'Id Serie',
            'IdCertificadoDetalle' => 'Id Certificado Detalle',
            'Fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCertificadoDetalle()
    {
        return $this->hasOne(CertificadosDetalle::className(), ['IdCertificadoDetalle' => 'IdCertificadoDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSerie()
    {
        return $this->hasOne(Series::className(), ['IdSerie' => 'IdSerie']);
    }
}
