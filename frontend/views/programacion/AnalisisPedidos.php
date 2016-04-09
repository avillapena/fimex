<?php
/* @var $this yii\web\View */
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;

$url = "http://servidorcont:8080/birt/frameset?__report=AnalisisPedidos".($IdArea == 3 ? "Bronce" : "").".rptdesign";
?>
<embed id= "rep" width="100%" height="868" src="<?= $url ?>">
