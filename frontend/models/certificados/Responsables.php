<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "Responsables".
 *
 * @property integer $IdResponsable
 * @property integer $IdCertificado
 * @property integer $IdEmpleado
 * @property integer $IdTipoFuncion
 *
 * @property Certificados $idCertificado
 * @property Empleados $idEmpleado
 * @property TiposFunciones $idTipoFuncion
 */
class Responsables extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Responsables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCertificado', 'IdEmpleado', 'IdTipoFuncion'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdResponsable' => 'Id Responsable',
            'IdCertificado' => 'Id Certificado',
            'IdEmpleado' => 'Id Empleado',
            'IdTipoFuncion' => 'Id Tipo Funcion',
        ];
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
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoFuncion()
    {
        return $this->hasOne(TiposFunciones::className(), ['IdTipoFuncion' => 'IdTipoFuncion']);
    }
}
