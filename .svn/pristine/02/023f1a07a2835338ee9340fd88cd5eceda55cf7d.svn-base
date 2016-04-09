<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "CertificadosExtendido".
 *
 * @property integer $IdCertificadoExtendido
 * @property integer $IdCertificado
 * @property string $Procedimiento
 *
 * @property Certificados $idCertificado
 */
class CertificadosExtendido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertificadosExtendido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCertificado'], 'integer'],
            [['Procedimiento'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertificadoExtendido' => 'Id Certificado Extendido',
            'IdCertificado' => 'Id Certificado',
            'Procedimiento' => 'Procedimiento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCertificado()
    {
        return $this->hasOne(Certificados::className(), ['IdCertificado' => 'IdCertificado']);
    }
}
