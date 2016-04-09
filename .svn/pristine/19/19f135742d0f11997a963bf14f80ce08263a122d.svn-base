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
 * @property string $rutaImagen
 * @property integer $IdProduccionDetalle
 *
 * @property ProduccionesDetalle $idProduccionDetalle
 * @property BitacoraCalidad $idBitacoraCalidad
 * @property ObservacionesEvidencias[] $observacionesEvidencias
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
            [['IdBitacoraCalidad', 'IdMotivo', 'IdSerie', 'IdProduccionDetalle'], 'integer'],
            [['Comentarios', 'Imagen', 'rutaImagen'], 'string']
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
            'rutaImagen' => 'Ruta Imagen',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalle()
    {
        return $this->hasOne(ProduccionesDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBitacoraCalidad()
    {
        return $this->hasOne(BitacoraCalidad::className(), ['IdBitacoraCalidad' => 'IdBitacoraCalidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservacionesEvidencias()
    {
        return $this->hasMany(ObservacionesEvidencias::className(), ['IdEvidenciaCalidad' => 'IdEvidenciasCalidad']);
    }
}
