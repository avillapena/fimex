<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "CertificadosAQ".
 *
 * @property integer $IdCertificadoAQ
 * @property integer $IdCertificado
 * @property integer $IdLancePm
 *
 * @property AnalisisQuimicos[] $analisisQuimicos
 * @property Certificados $idCertificado
 * @property Lances $IdLancePm
 */
class CertificadosAQ extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertificadosAQ';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCertificado', 'IdLancePm'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertificadoAQ' => 'Id Certificado Aq',
            'IdCertificado' => 'Id Certificado',
            'IdLancePm' => 'Id Lance Pm',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisisQuimicos()
    {
        return $this->hasMany(AnalisisQuimicos::className(), ['IdCertificadoAQ' => 'IdCertificadoAQ']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCertificado()
    {
        return $this->hasOne(Certificados::className(), ['IdCertificado' => 'IdCertificado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLancePm()
    {
        return $this->hasOne(Lances::className(), ['IdLance' => 'IdLancePm']);
    }
}
