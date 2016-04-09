<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_ProgramacionesSemana".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProgramacionSemana
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $Pedido
 * @property integer $pedido_hecho
 * @property integer $programadas_semana
 * @property integer $hechas_semana
 * @property integer $prioridad_semana
 * @property integer $IdPedido
 * @property integer $IdAlmacen
 * @property integer $IdProducto
 * @property integer $Codigo
 * @property integer $Numero
 * @property string $Producto
 * @property string $Almacen
 * @property string $Fecha
 * @property string $Cliente
 * @property string $OrdenCompra
 * @property integer $Estatus
 * @property string $Cantidad
 * @property string $SaldoCantidad
 * @property string $FechaEmbarque
 * @property integer $NivelRiesgo
 * @property string $TotalProgramado
 * @property string $Observaciones
 * @property integer $PiezasMolde
 * @property string $CiclosMolde
 * @property string $CiclosMoldeA
 * @property string $PesoCasting
 * @property string $PesoArania
 * @property integer $IdPresentacion
 * @property integer $IdProductoCasting
 * @property string $ProductoCasting
 * @property string $Aleacion
 * @property integer $IdAreaAct
 * @property string $AreaAct
 * @property string $LlevaSerie
 * @property string $MoldeCompleto
 * @property integer $FechaMoldeo
 * @property integer $IdParteMolde
 * @property integer $IdArea
 * @property integer $IdProceso
 * @property integer $IdConfiguracionSerie
 */
class VProgramacionesSemana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionesSemana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'Pedido', 'IdPedido', 'IdAlmacen', 'IdProducto', 'Codigo', 'Numero', 'Fecha', 'Estatus', 'Cantidad', 'SaldoCantidad', 'NivelRiesgo', 'TotalProgramado', 'CiclosMolde', 'CiclosMoldeA', 'IdArea'], 'required'],
            [['IdProgramacion', 'IdProgramacionSemana', 'Anio', 'Semana', 'Pedido', 'pedido_hecho', 'programadas_semana', 'hechas_semana', 'prioridad_semana', 'IdPedido', 'IdAlmacen', 'IdProducto', 'Codigo', 'Numero', 'Estatus', 'NivelRiesgo', 'PiezasMolde', 'IdPresentacion', 'IdProductoCasting', 'IdAreaAct', 'FechaMoldeo', 'IdParteMolde', 'IdArea', 'IdProceso', 'IdConfiguracionSerie'], 'integer'],
            [['Producto', 'Almacen', 'Cliente', 'OrdenCompra', 'Observaciones', 'ProductoCasting', 'Aleacion', 'AreaAct', 'LlevaSerie', 'MoldeCompleto'], 'string'],
            [['Fecha', 'FechaEmbarque'], 'safe'],
            [['Cantidad', 'SaldoCantidad', 'TotalProgramado', 'CiclosMolde', 'CiclosMoldeA', 'PesoCasting', 'PesoArania'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Pedido' => 'Pedido',
            'pedido_hecho' => 'Pedido Hecho',
            'programadas_semana' => 'Programadas Semana',
            'hechas_semana' => 'Hechas Semana',
            'prioridad_semana' => 'Prioridad Semana',
            'IdPedido' => 'Id Pedido',
            'IdAlmacen' => 'Id Almacen',
            'IdProducto' => 'Id Producto',
            'Codigo' => 'Codigo',
            'Numero' => 'Numero',
            'Producto' => 'Producto',
            'Almacen' => 'Almacen',
            'Fecha' => 'Fecha',
            'Cliente' => 'Cliente',
            'OrdenCompra' => 'Orden Compra',
            'Estatus' => 'Estatus',
            'Cantidad' => 'Cantidad',
            'SaldoCantidad' => 'Saldo Cantidad',
            'FechaEmbarque' => 'Fecha Embarque',
            'NivelRiesgo' => 'Nivel Riesgo',
            'TotalProgramado' => 'Total Programado',
            'Observaciones' => 'Observaciones',
            'PiezasMolde' => 'Piezas Molde',
            'CiclosMolde' => 'Ciclos Molde',
            'CiclosMoldeA' => 'Ciclos Molde A',
            'PesoCasting' => 'Peso Casting',
            'PesoArania' => 'Peso Arania',
            'IdPresentacion' => 'Id Presentacion',
            'IdProductoCasting' => 'Id Producto Casting',
            'ProductoCasting' => 'Producto Casting',
            'Aleacion' => 'Aleacion',
            'IdAreaAct' => 'Id Area Act',
            'AreaAct' => 'Area Act',
            'LlevaSerie' => 'Lleva Serie',
            'MoldeCompleto' => 'Molde Completo',
            'FechaMoldeo' => 'Fecha Moldeo',
            'IdParteMolde' => 'Id Parte Molde',
            'IdArea' => 'Id Area',
            'IdProceso' => 'Id Proceso',
            'IdConfiguracionSerie' => 'Id Configuracion Serie',
        ];
    }
}
