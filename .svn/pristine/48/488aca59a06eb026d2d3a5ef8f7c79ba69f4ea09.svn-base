<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "CentrosTrabajo".
 *
 * @property integer $IdCentroTrabajo
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property string $Habilitado
 *
 * @property Existencias[] $existencias
 * @property CentrosTrabajoProductos[] $centrosTrabajoProductos
 * @property CentrosTrabajoMaquinas[] $centrosTrabajoMaquinas
 * @property Areas $idArea
 * @property SubProcesos $idSubProceso
 * @property CentrosTrabajoRutas[] $centrosTrabajoRutas
 * @property Inventarios[] $inventarios
 * @property Producciones[] $producciones
 * @property InventarioMovimientos[] $inventarioMovimientos
 * @property Series[] $series
 * @property ProgramacionesAlmaDia[] $programacionesAlmaDias
 * @property ProgramacionesDia[] $programacionesDias
 */
class CentrosTrabajo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CentrosTrabajo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion', 'IdSubProceso', 'IdArea'], 'required'],
            [['Identificador', 'Descripcion'], 'string'],
            [['IdSubProceso', 'IdArea', 'Habilitado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'Habilitado' => 'Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistencias()
    {
        return $this->hasMany(Existencias::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosTrabajoProductos()
    {
        return $this->hasMany(CentrosTrabajoProductos::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosTrabajoMaquinas()
    {
        return $this->hasMany(CentrosTrabajoMaquinas::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(Areas::className(), ['IdArea' => 'IdArea']);
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
    public function getCentrosTrabajoRutas()
    {
        return $this->hasMany(CentrosTrabajoRutas::className(), ['IdCentroTrabajoDestino' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarios()
    {
        return $this->hasMany(Inventarios::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimientos::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeries()
    {
        return $this->hasMany(Series::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesAlmaDias()
    {
        return $this->hasMany(ProgramacionesAlmaDia::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesDias()
    {
        return $this->hasMany(ProgramacionesDia::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }
}
