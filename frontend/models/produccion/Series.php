<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Series".
 *
 * @property integer $IdSerie
 * @property integer $IdProducto
 * @property integer $IdSubProceso
 * @property string $Serie
 * @property string $Estatus
 * @property string $FechaHora
 * @property integer $IdSeriePadre
 * @property integer $IdCentroTrabajo
 *
 * @property SerieMovimientos[] $serieMovimientos
 * @property Productos $idProducto
 * @property SubProcesos $idSubProceso
 * @property Series $idSeriePadre
 * @property Series[] $series
 * @property CentrosTrabajo $idCentroTrabajo
 * @property SeriesDetalles[] $seriesDetalles
 * @property CertificadosSeries[] $certificadosSeries
 */
class Series extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Series';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdSubProceso'], 'required'],
            [['IdProducto', 'IdSubProceso', 'IdSeriePadre', 'IdCentroTrabajo'], 'integer'],
            [['Serie', 'Estatus'], 'string'],
            [['FechaHora'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdSerie' => 'Id Serie',
            'IdProducto' => 'Id Producto',
            'IdSubProceso' => 'Id Sub Proceso',
            'Serie' => 'Serie',
            'Estatus' => 'Estatus',
            'FechaHora' => 'Fecha Hora',
            'IdSeriePadre' => 'Id Serie Padre',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSerieMovimientos()
    {
        return $this->hasMany(SerieMovimientos::className(), ['IdSerie' => 'IdSerie']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubProceso()
    {
        return $this->hasOne(SubProcesos::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSeriePadre()
    {
        return $this->hasOne(Series::className(), ['IdSerie' => 'IdSeriePadre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeries()
    {
        return $this->hasMany(Series::className(), ['IdSeriePadre' => 'IdSerie']);
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
    public function getSeriesDetalles()
    {
        return $this->hasMany(SeriesDetalles::className(), ['IdSerie' => 'IdSerie']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificadosSeries()
    {
        return $this->hasMany(CertificadosSeries::className(), ['IdSerie' => 'IdSerie']);
    }
}
