<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "AnalisisQuimicos".
 *
 * @property integer $IdAnalisisQuimico
 * @property integer $IdCertificadoAQ
 * @property string $Elemento
 * @property string $Valor
 * @property string $Min
 * @property string $Max
 *
 * @property CertificadosAQ $idCertificadoAQ
 */
class AnalisisQuimicos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AnalisisQuimicos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCertificadoAQ'], 'integer'],
            [['Elemento'], 'string'],
            [['Valor', 'Min', 'Max'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAnalisisQuimico' => 'Id Analisis Quimico',
            'IdCertificadoAQ' => 'Id Certificado Aq',
            'Elemento' => 'Elemento',
            'Valor' => 'Valor',
            'Min' => 'Min',
            'Max' => 'Max',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCertificadoAQ()
    {
        return $this->hasOne(CertificadosAQ::className(), ['IdCertificadoAQ' => 'IdCertificadoAQ']);
    }
}
