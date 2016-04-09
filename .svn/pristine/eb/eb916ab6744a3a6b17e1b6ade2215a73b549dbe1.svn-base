<?php
/* @var $this yii\web\View */
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;

$url = "http://servidorcont:8080/birt/frameset?__format=html&__report=ProduccionSemanalAcero.rptdesign";
?>

<embed id= "rep" width="90%" height="768" src="<?= $url ?>">

<script>
function ReloadPage() {
	setTimeout(function(){
		location.reload();
	},900000);
};
</script>
<script>ReloadPage();</script>