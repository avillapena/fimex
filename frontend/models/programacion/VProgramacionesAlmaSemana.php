<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "V_ProgramacionesAlmaSemana".
 *
 * @property integer $IdProducto
 * @property string $Producto
 * @property integer $IdAlmaTipo
 * @property string $Alma
 * @property integer $IdAlmaReceta
 * @property string $AlmaReceta
 * @property integer $IdAlmaMaterialCaja
 * @property string $MaterialCaja
 * @property integer $Existencia
 * @property integer $PiezasCaja
 * @property integer $PiezasMolde
 * @property double $Peso
 * @property double $PiezasHora
 * @property double $TiempoFraguado
 * @property double $TiempoGaseoDirecto
 * @property double $TiempoGaseoIndirecto
 * @property integer $IdProgramacionAlma
 * @property integer $IdProgramacionAlmaSemana
 * @property integer $IdArea
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $Programadas
 * @property integer $Hechas
 */
class VProgramacionesAlmaSemana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'V_ProgramacionesAlmaSemana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdAlmaTipo', 'Alma', 'IdAlmaReceta', 'AlmaReceta', 'IdAlmaMaterialCaja', 'MaterialCaja', 'IdProgramacionAlma', 'IdProgramacionAlmaSemana', 'IdArea', 'Anio', 'Semana', 'Programadas', 'Hechas'], 'required'],
            [['IdProducto', 'IdAlmaTipo', 'IdAlmaReceta', 'IdAlmaMaterialCaja', 'Existencia', 'PiezasCaja', 'PiezasMolde', 'IdProgramacionAlma', 'IdProgramacionAlmaSemana', 'IdArea', 'Anio', 'Semana', 'Programadas', 'Hechas'], 'integer'],
            [['Producto', 'Alma', 'AlmaReceta', 'MaterialCaja'], 'string'],
            [['Peso', 'PiezasHora', 'TiempoFraguado', 'TiempoGaseoDirecto', 'TiempoGaseoIndirecto'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProducto' => 'Id Producto',
            'Producto' => 'Producto',
            'IdAlmaTipo' => 'Id Alma Tipo',
            'Alma' => 'Alma',
            'IdAlmaReceta' => 'Id Alma Receta',
            'AlmaReceta' => 'Alma Receta',
            'IdAlmaMaterialCaja' => 'Id Alma Material Caja',
            'MaterialCaja' => 'Material Caja',
            'Existencia' => 'Existencia',
            'PiezasCaja' => 'Piezas Caja',
            'PiezasMolde' => 'Piezas Molde',
            'Peso' => 'Peso',
            'PiezasHora' => 'Piezas Hora',
            'TiempoFraguado' => 'Tiempo Fraguado',
            'TiempoGaseoDirecto' => 'Tiempo Gaseo Directo',
            'TiempoGaseoIndirecto' => 'Tiempo Gaseo Indirecto',
            'IdProgramacionAlma' => 'Id Programacion Alma',
            'IdProgramacionAlmaSemana' => 'Id Programacion Alma Semana',
            'IdArea' => 'Id Area',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
        ];
    }
}
