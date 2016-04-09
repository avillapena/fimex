<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "CertificadosReferecia".
 *
 * @property integer $IdCertificadoReferencia
 * @property integer $IdCertificadoGeneral
 * @property integer $IdCertificadoReferenciado
 */
class CertificadosReferecia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertificadosReferecia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCertificadoGeneral', 'IdCertificadoReferenciado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertificadoReferencia' => 'Id Certificado Referencia',
            'IdCertificadoGeneral' => 'Id Certificado General',
            'IdCertificadoReferenciado' => 'Id Certificado Referenciado',
        ];
    }
}
