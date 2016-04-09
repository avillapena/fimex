<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "EvidenciasCalidad".
 *
 * @property integer $IdEvidenciasCalidad
 * @property integer $IdBitacoraCalidad
 * @property integer $IdMotivo
 * @property integer $IdSerie
 * @property string $Comentarios
 * @property string $Imagen
 *
 * @property BitacoraCalidad $idBitacoraCalidad
 */
class EvidenciasCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'EvidenciasCalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdBitacoraCalidad', 'IdMotivo', 'IdSerie'], 'integer'],
            [['Comentarios', 'Imagen'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEvidenciasCalidad' => 'Id Evidencias Calidad',
            'IdBitacoraCalidad' => 'Id Bitacora Calidad',
            'IdMotivo' => 'Id Motivo',
            'IdSerie' => 'Id Serie',
            'Comentarios' => 'Comentarios',
            'Imagen' => 'Imagen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBitacoraCalidad()
    {
        return $this->hasOne(BitacoraCalidad::className(), ['IdBitacoraCalidad' => 'IdBitacoraCalidad']);
    }
}
