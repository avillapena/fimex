<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "CertTTColada".
 *
 * @property integer $IdCertTTColada
 * @property integer $Colada
 * @property integer $IdCertificadoTTDetalle
 *
 * @property CertificadoTTDetalle $idCertificadoTTDetalle
 */
class CertTTColada extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertTTColada';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Colada', 'IdCertificadoTTDetalle'], 'integer'],
            [['IdCertificadoTTDetalle'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertTTColada' => 'Id Cert Ttcolada',
            'Colada' => 'Colada',
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
