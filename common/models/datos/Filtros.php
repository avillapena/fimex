<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Filtros".
 *
 * @property integer $IdFiltro
 * @property integer $IdProducto
 * @property integer $IdFiltroTipo
 * @property integer $Cantidad
 * @property string $Observaciones
 *
 * @property FiltrosTipo $idFiltroTipo
 * @property Productos $idProducto
 */
class Filtros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Filtros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdFiltroTipo'], 'required'],
            [['IdProducto', 'IdFiltroTipo', 'Cantidad'], 'integer'],
            [['Observaciones'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdFiltro' => 'Id Filtro',
            'IdProducto' => 'Id Producto',
            'IdFiltroTipo' => 'Id Filtro Tipo',
            'Cantidad' => 'Cantidad',
            'Observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFiltroTipo()
    {
        return $this->hasOne(FiltrosTipo::className(), ['IdFiltroTipo' => 'IdFiltroTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
}
