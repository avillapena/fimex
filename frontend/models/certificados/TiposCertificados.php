<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "TiposCertificados".
 *
 * @property integer $IdTipoCertificado
 * @property string $Certificado
 * @property string $NombreCorto
 * @property integer $TipoCert
 *
 * @property Certificados[] $certificados
 */
class TiposCertificados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TiposCertificados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Certificado', 'NombreCorto'], 'string'],
            [['TipoCert'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTipoCertificado' => 'Id Tipo Certificado',
            'Certificado' => 'Certificado',
            'NombreCorto' => 'Nombre Corto',
            'TipoCert' => 'Tipo Cert',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificados()
    {
        return $this->hasMany(Certificados::className(), ['IdTipoCertificado' => 'IdTipoCertificado']);
    }
}
