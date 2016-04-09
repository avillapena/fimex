<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "CertTTSerie".
 *
 * @property integer $IdCertTTSerie
 * @property string $Serie
 * @property integer $IdCertificadoTTDetalle
 *
 * @property CertificadoTTDetalle $idCertificadoTTDetalle
 */
class CertTTSerie extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertTTSerie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Serie'], 'string'],
            [['IdCertificadoTTDetalle'], 'required'],
            [['IdCertificadoTTDetalle'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertTTSerie' => 'Id Cert Ttserie',
            'Serie' => 'Serie',
            'IdCertificadoTTDetalle' => 'Id Certificado Ttdetalle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCertificadoTTDetalle()
    {
        return $this->hasOne(CertificadoTTDetalle::className(), ['IdCertificadoTTDetalle' => 'IdCertificadoTTDetalle']);
    }
}
