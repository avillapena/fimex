<?php

namespace common\models\vistas;

use Yii;

/**
 * This is the model class for table "v_MaterialArania".
 *
 * @property string $Aleacion
 * @property integer $Semana
 * @property integer $Anio
 * @property string $TonTotales
 * * @property string $TonTotalesCasting 
 */
class VMaterialArania extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_MaterialArania';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Aleacion'], 'string'],
            [['Semana', 'Anio'], 'required'],
            [['Semana', 'Anio'], 'integer'],
            [['TonTotales', 'TonTotalesCasting'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Aleacion' => 'Aleacion',
            'Semana' => 'Semana',
            'Anio' => 'Anio',
            'TonTotales' => 'Ton Totales',
        ];
    }
    
    public function getMaterial($semanas,$cant,$area){

        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM (SELECT TonTotales,anioSemana,Aleacion FROM FIMEX_Produccion.dbo.v_MaterialArania WHERE IdArea = $area) PI
                                            PIVOT (SUM(TonTotales) FOR anioSemana IN ( ".implode(",",$semanas)." ) ) AS PivotTable"
                )->queryAll();


        foreach ($result as &$value) {
            $value['PesoTot'] = 0;
            foreach($value as $key => $data){
                if($key != 'Aleacion' && $key != 'PesoTot'){
                    $value['PesoTot'] += $data;
                }
            }
        }
        return $result;
    }
    
    public function getMaterialCasting($semanas,$cant,$area){

        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM (SELECT TonTotalesCasting,anioSemana,Aleacion FROM FIMEX_Produccion.dbo.v_MaterialArania WHERE IdArea = $area) PI
                                            PIVOT (SUM(TonTotalesCasting) FOR anioSemana IN ( ".implode(",",$semanas)." ) ) AS PivotTable"
                )->queryAll();

        foreach ($result as &$value) {
            $value['PesoTot'] = 0;
            foreach($value as $key => $data){
                if($key != 'Aleacion' && $key != 'PesoTot'){
                    $value['PesoTot'] += $data;
                }
            }
        }
        return $result;
    }
}
