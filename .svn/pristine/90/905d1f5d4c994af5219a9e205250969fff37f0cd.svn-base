<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "v_broker_muestras".
 *
 * @property integer $id
 * @property string $programa
 * @property string $Fecha
 * @property string $Hora
 * @property string $muestra
 * @property string $Analista
 * @property string $Peso
 * @property string $Colada
 * @property string $Horno
 * @property string $calidad
 * @property string $elemento
 * @property double $valor
 * @property double $tol_min
 * @property double $tol_max
 * @property string $Dimension
 * @property integer $DisplayOrder
 */
class VBrokerMuestras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_broker_muestras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'DisplayOrder'], 'integer'],
            [['programa', 'Fecha', 'Hora', 'muestra', 'Analista', 'Peso', 'Colada', 'Horno', 'calidad', 'elemento', 'Dimension'], 'string'],
            [['valor', 'tol_min', 'tol_max'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'programa' => 'Programa',
            'Fecha' => 'Fecha',
            'Hora' => 'Hora',
            'muestra' => 'Muestra',
            'Analista' => 'Analista',
            'Peso' => 'Peso',
            'Colada' => 'Colada',
            'Horno' => 'Horno',
            'calidad' => 'Calidad',
            'elemento' => 'Elemento',
            'valor' => 'Valor',
            'tol_min' => 'Tol Min',
            'tol_max' => 'Tol Max',
            'Dimension' => 'Dimension',
            'DisplayOrder' => 'Display Order',
        ];
    }
}
