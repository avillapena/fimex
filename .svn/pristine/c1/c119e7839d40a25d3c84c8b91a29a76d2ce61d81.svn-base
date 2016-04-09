<?php
namespace frontend\models\calidad;
use Yii;
use yii\base\Model;
//use frontend\Models\calidad\MaquinadoCTA2;

Class ProduccionCalidad extends Model {
    
    public function GetCantidad($IdProduccion, $IdSubProceso, $IdCentroTrabajo) {
        $command = \Yii::$app->db;
        $sql = "SELECT
            dbo.Programaciones.IdProgramacionEstatus,
            dbo.Programaciones.IdProgramacion,
            dbo.Programaciones.IdArea,
            Aceptadas.Hechas AS Aceptadas,
            Reparaciones.Hechas AS Reparaciones,
            Scrap.Hechas AS Scrap,
            dbo.v_Existencias.IdProducto,
            dbo.v_Existencias.IdCentroTrabajo AS IdCentroTrabajoDestino,
            dbo.v_Existencias.IdSubProceso,
            dbo.v_Existencias.IdArea,
            dbo.v_Existencias.Descripcion,
            dbo.v_Existencias.Identificacion,
            dbo.v_Existencias.Existencia,
            dbo.v_Existencias.FechaMoldeo,
            dbo.v_Existencias.ExistenciaFechaMoldeo,
            dbo.v_Existencias.SubProceso,
            dbo.v_Existencias.LlevaSerie
            
            FROM
            v_Existencias
            INNER JOIN Programaciones ON v_Existencias.IdProducto = Programaciones.IdProducto
            LEFT JOIN ProduccionesDetalle AS Aceptadas ON v_Existencias.IdProducto = Aceptadas.IdProductos AND Aceptadas.IdEstatus = 1 AND Aceptadas.IdProduccion = 19356
            LEFT JOIN ProduccionesDetalle AS Reparaciones ON v_Existencias.IdProducto = Reparaciones.IdProductos AND Reparaciones.IdEstatus = 2 AND Reparaciones.IdProduccion = 19356
            LEFT JOIN ProduccionesDetalle AS Scrap ON v_Existencias.IdProducto = Scrap.IdProductos AND Scrap.IdEstatus = 3 AND Scrap.IdProduccion = 19356
            WHERE
            Programaciones.IdProgramacionEstatus = 1 AND
            Programaciones.IdArea = 2 AND
            v_Existencias.IdSubProceso = ".$IdSubProceso."  
            AND v_Existencias.IdCentroTrabajo = ".$IdCentroTrabajo;
        //echo $sql;
        //exit();
        $result =$command->createCommand($sql)->queryAll();
                                                           // )->getRawSql();
                                                           // print_r($result);exit;
        
        return $result;
    }
}