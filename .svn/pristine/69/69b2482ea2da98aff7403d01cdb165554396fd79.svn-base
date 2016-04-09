<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "CentrosTrabajoMaquinas".
 *
 * @property integer $IdCentroTrabajoMaquina
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 *
 * @property CentrosTrabajo $idCentroTrabajo
 * @property Maquinas $idMaquina
 */
class CentrosTrabajoMaquinas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CentrosTrabajoMaquinas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCentroTrabajo', 'IdMaquina'], 'required'],
            [['IdCentroTrabajo', 'IdMaquina'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCentroTrabajoMaquina' => 'Id Centro Trabajo Maquina',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCentroTrabajo()
    {
        return $this->hasOne(CentrosTrabajo::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaquina()
    {
        return $this->hasOne(Maquinas::className(), ['IdMaquina' => 'IdMaquina']);
    }
}
