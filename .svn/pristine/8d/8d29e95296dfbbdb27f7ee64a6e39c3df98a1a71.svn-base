<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "CertificadoTT".
 *
 * @property integer $IdCertificadoTT
 * @property string $NoCert
 * @property string $Cliente
 * @property string $Fecha
 * @property integer $IdTratamientoTermico
 *
 * @property TratamientosTermicos $idTratamientoTermico
 * @property CertificadoTTDetalle[] $certificadoTTDetalles
 */
class CertificadoTT extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CertificadoTT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NoCert', 'Cliente', 'Fecha', 'IdTratamientoTermico'], 'required'],
            [['NoCert', 'Cliente'], 'string'],
            [['Fecha'], 'safe'],
            [['IdTratamientoTermico'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCertificadoTT' => 'Id Certificado Tt',
            'NoCert' => 'No Cert',
            'Cliente' => 'Cliente',
            'Fecha' => 'Fecha',
            'IdTratamientoTermico' => 'Id Tratamiento Termico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTratamientoTermico()
    {
        return $this->hasOne(TratamientosTermicos::className(), ['IdTratamientoTermico' => 'IdTratamientoTermico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificadoTTDetalles()
    {
        return $this->hasMany(CertificadoTTDetalle::className(), ['IdCertificadoTT' => 'IdCertificadoTT']);
    }
}
