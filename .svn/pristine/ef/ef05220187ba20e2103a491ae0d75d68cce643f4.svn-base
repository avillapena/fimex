<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use common\models\Areas;
use yii\db\ActiveQuery;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
$role = isset(Yii::$app->user->identity->role) ? Yii::$app->user->identity->role : '';
$menu = [///Menu para Productos adicionales
    [],
    [ 
        ['label' => 'Acero', 'url' => ['/productos?area=2']],
        ['label' => 'Bronce', 'url' => ['/productos?area=3']],
        ['label' => 'Moldeo Permanente', 'url' => ['/productos?area=4']],
        ['label' => 'Salir', 'url' => ['/site/quit']],
    ],

    [ //menu para Aceros
        ['label' => 'Inicio', 'url' => ['/site/index']],
        [
            'label' => 'Programacion',
            'items' => [
                ['label' => 'Programacion Semanal', 'url' => ['/programacion/semanal-moldeo-aceros']],
                ['label' => 'Programacion Diaria', 'url' => ['/moldeo-acero/diario']],
                ['label' => 'Programacion Tarimas', 'url' => ['/programacion-angular/tarimas']],
            ],
        ],
        [
            'label' => 'Pedidos y Embarques',
            'items' => [
                '<li class="dropdown-header">Pedidos</li>',
                '<li class="divider"></li>',
                ['label' => 'Pedidos Clientes', 'url' => ['/programacion/pedidos-clientes']],
                ['label' => 'Analisis Pedidos', 'url' => ['/programacion/analisis-pedidos'], 'visible'=>$role == 1 ? true : false],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Embarques</li>',
                '<li class="divider"></li>',
                ['label' => 'Programacion Embarques', 'url' => ['/programacion/embarques-aceros'], 'visible'=>$role == 1 ? true : false],
                ['label' => 'Junta de Produccion', 'url' => ['/programacion/embarques-junta-aceros']],
                ['label' => 'Informe', 'url' => ['/programacion/embarques-informe-aceros']],
            ],
        ],
        [
            'label' => 'Almas',
            'items' => [
                ['label' => 'Catalogo Almas', 'url' => ['/reportes/almas-catalogo-acero']],
                ['label' => 'Programacion Semanal', 'url' => ['/programacion-almas/semanal']],
                ['label' => 'Programacion Diaria', 'url' => ['/programacion-almas/diaria?AreaProceso=2&subProceso=2']],
                ['label' => 'Camisas Por Producto', 'url' => ['/reportes/camisas-producto']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Captura de produccion</li>',
                ['label' => 'Produccion Almas', 'url' => ['/angular/almasac']],
                ['label' => 'Pintado ', 'url' => ['/angular/pintadoalm ']],
                //['label' => 'Control de Pintura', 'url' => ['/pintura']],
            ],
        ],
        [
            'label' => 'Control de inventarios',
            'items' => [
                ['label' => 'Transacciones', 'url' => ['/moldeo-acero/transacciones']],
                ['label' => 'Transferencias', 'url' => ['/moldeo-acero/transferencias']],
            ],
        ],
        [
            'label' => 'Captura de Produccion',
            'items' => [
                //['label' => 'Almas', 'url' => ['/angular/almasac']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Moldeo</li>',
                ['label' => 'Moldeo Varel', 'url' => ['/produccion-acero/moldeo-v']],
                ['label' => 'Moldeo Kloster', 'url' => ['/produccion-acero/moldeo-k']],
                ['label' => 'Moldeo Especial', 'url' => ['/produccion-acero/moldeo-e']],
                ['label' => 'Control Pintura', 'url' => ['/pintura']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Cerrado</li>',
                ['label' => 'Cerrado Kloster', 'url' => ['/produccion-acero/cerrado-k']],
                ['label' => 'Cerrado Varel', 'url' => ['produccion-acero/cerrado-v']],
                //['label' => 'Cerrado Especial', 'url' => ['produccion-acero/cerrado-e']],
                '<li class="divider"></li>',
                ['label' => 'Vaciado', 'url' => ['/produccion-acero/vaciado-acero']],
                ['label' => 'Configuracion Series', 'url' => ['/produccion-acero/series']],
                ['label' => 'Estatus Monitoreo', 'url' => ['/produccion-acero/estatus-monitoreo']],
            ],
            'url' => ['/programaciones']
        ],
        [
            'label' => 'Limpieza',
            'items' => [
                //['label' => 'Almas', 'url' => ['/angular/almasac']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Programacion</li>',
                ['label' => 'Programacion Semanal', 'url' => ['/limpieza-acero/semanal']],
                ['label' => 'Programacion Diaria', 'url' => ['/limpieza-acero/diario']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Captura de produccion</li>',
                ['label' => 'Limpieza', 'url' => ['/limpieza-acero/captura']],
            ],
        ],
        [
            'label' => 'Pruebas Calidad',
            'items' => [
                '<li class="divider"></li>',
                '<li class="dropdown-header">Pruebas Destructivas</li>',
                ['label' => 'Impacto', 'url' => ['/produccion-acero/charpy']],
                ['label' => 'Tension y Dureza', 'url' => ['/produccion-acero/pruebasmecanicas']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Pruebas No Destructivas</li>',
                ['label' => 'Ultrasonido', 'url' => ['/produccion-acero/calidad-u']],
                ['label' => 'Liquidos Penetrantes', 'url' => ['/produccion-acero/calidad-l']],
                ['label' => 'Particulas Magneticas', 'url' => ['/produccion-acero/calidad-p']],
                ['label' => 'Inspeccion Visual', 'url' => ['/produccion-acero/calidad-v']],
                ['label' => 'Tratamientos Termicos', 'url' => ['/produccion-acero/tratamientos']],
            ],
        ],
        [
            'label' => 'Reportes',
            'items' => [
                '<li class="dropdown-header">Requerimiento de material</li>',
                '<li class="divider"></li>',
                ['label' => 'Metal', 'url' => ['/reportes/metal-semana']],
                ['label' => 'Camisas', 'url' => ['/reportes/camisas']],
                ['label' => 'Filtros', 'url' => ['/reportes/filtros-aceros']],
                ['label' => 'Promol Semanal', 'url' => ['/reportes/promol-semana']],
                ['label' => 'Series historial', 'url' => ['/reportes/series-a']],
                ['label' => 'Grafica Kloster', 'url' => ['/reportes/grafica-kloster']],
                ['label' => 'Grafica Varel', 'url' => ['/reportes/grafica-varel']],
                ['label' => 'Reporte Moldes Ciclos', 'url' => ['/reportes/moldesciclos']],
                ['label' => 'Produccion Semanal Acero', 'url' => ['/reportes/produccion-semanal-acero']],

                '<li class="divider"></li>',
                '<li class="dropdown-header">Requerimiento de material por Dia</li>',
                '<li class="divider"></li>',
                ['label' => 'Camisas', 'url' => ['/reportes/camisas-dia']],
                ['label' => 'Filtros', 'url' => ['/reportes/filtros-aceros-dia']],
                ['label' => 'Metal', 'url' => ['/reportes/metal-dia']],
                ['label' => 'Promol Dia', 'url' => ['/reportes/promol-dia']],
                '<li class="divider"></li>',
                ['label' => 'Tiempos Muertos', 'url' => ['/reportes/tiempos-muertos-aceros']],
                ['label' => 'Series', 'url' => ['/reportes/series-aceros']],
                ['label' => 'Almas', 'url' => ['/site/about']],
                ['label' => 'Moldeo', 'url' => ['/site/about']],
                ['label' => 'Cerrado', 'url' => ['/site/about']],
                ['label' => 'Vaciado', 'url' => 'http://servidor/supervisores/reporte_vaciado_back.php'],
                ['label' => 'Limpieza', 'url' => ['/site/about']],

            ],

            'url' => ['/programaciones']
        ],
        [
            'label' => 'Certificados',
            'items' => [
                ['label' => 'Certificado Gral', 'url' => ['/certificados/certificado-general']],
                ['label' => 'Pruebas No Destructivas', 'url' => ['/certificados/pruebas-no-destructivas']],
            ],
        ],
        ['label' => 'Salir', 'url' => ['/site/quit']],
    ],
    [ //menu para bronces
        ['label' => 'Inicio', 'url' => ['/site/index']],
        [
            'label' => 'Programacion',
            'items' => [
                ['label' => 'Programacion Semanal', 'url' => ['/programacion/semanal-moldeo-bronces']],
                ['label' => 'Programacion Diaria', 'url' => ['/moldeo-bronce/diario']],
            ],
        ],
        [
            'label' => 'Pedidos y Embarques',
            'items' => [
                '<li class="dropdown-header">Pedidos</li>',
                '<li class="divider"></li>',
                ['label' => 'Pedidos Clientes', 'url' => ['/programacion/pedidos-clientes-bronces']],
                ['label' => 'Analisis Pedidos', 'url' => ['/programacion/analisis-pedidos-bronces']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Embarques</li>',
                '<li class="divider"></li>',
                ['label' => 'Programacion Embarques', 'url' => ['/programacion/embarques-bronces']],
                ['label' => 'Junta de Produccion', 'url' => ['/programacion/embarques-junta-bronces']],
                ['label' => 'Informe', 'url' => ['/programacion/embarques-informe-bronces']],
            ],
        ],
        [
            'label' => 'Almas',
            'items' => [
                ['label' => 'Catalogo Almas', 'url' => ['/reportes/almas-catalogo']],
                ['label' => 'Programacion Semanal', 'url' => ['/programacion-almas/semanal']],
                ['label' => 'Programacion Diaria', 'url' => ['/programacion-almas/diaria?AreaProceso=3&subProceso=2']],
                ['label' => 'Produccion', 'url' => ['/angular/almas']],
                ['label' => 'Rebabeo y Ensamble', 'url' => ['/angular/rebabeo']],
            ],

        ],
        [
            'label' => 'Produccion Moldeo',
            'items' => [
                ['label' => 'Moldeo', 'url' => ['/angular/moldeo']],
                ['label' => 'Vaciado', 'url' => ['/angular/vaciado']],
            ],

        ],
        [
            'label' => 'Produccion Limpieza',
            'items' => [
                ['label' => 'Programacion Diaria', 'url' => ['/programacion-angular/diaria?AreaProceso=3&subProceso=12']],
                ['label' => 'Limpieza', 'url' => ['/angular/limpieza']],
                ['label' => 'Empaque', 'url' => ['/angular/empaque']],
            ],

        ],
        [
            'label' => 'Reportes',
            'items' => [
                ['label' => 'Productos Colli', 'url' => ['/reportes/productoscolli']],
                '<li class="dropdown-header">Produccion</li>',
                ['label' => 'Almas', 'url' => ['/reportes/almas']],
                ['label' => 'Moldeo', 'url' => ['/reportes/moldeo']],
                ['label' => 'Vaciado', 'url' => ['/reportes/vaciado']],
                '<li class="divider"></li>',
                ['label' => 'Tiempos Muertos', 'url' => ['/reportes/tiempos-muertos']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">ETE</li>',
                ['label' => 'Moldeo', 'url' => ['/reportes/ete?subProceso=6']],
                ['label' => 'Almas', 'url' => ['/reportes/ete-almas']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Materiales Requeridos</li>',
                ['label' => 'Metal', 'url' => ['/reportes/material']],
                ['label' => 'Camisas x Semana', 'url' => ['/reportes/camisas-bronce']],
                ['label' => 'Camisas x Dia', 'url' => ['/reportes/camisas-dia-bronce']],
                ['label' => 'Cajas', 'url' => ['/reportes/piezascajas']],
                ['label' => 'Filtros', 'url' => ['/reportes/filtros-bronces']],
            ],
            'url' => ['/programaciones']
        ],
        ['label' => 'Salir', 'url' => ['/site/quit']],
    ],
    [ //menu para Moldeo permanente
        ['label' => 'Inicio', 'url' => ['/site/index']],
        ['label' => 'Programacion Semanal', 'url' => ['/programacion/semanal']],
        [
            'label' => 'Almas',
            'items' => [
                ['label' => 'Programacion', 'url' => ['/almas/semanal']],
                ['label' => 'Produccion', 'url' => ['/produccion/almas?proceso=15']],
            ],
        ],
        [
            'label' => 'Moldeo',
            'items' => [
                ['label' => 'Programacion', 'url' => ['/programacion/diaria?AreaProceso=4&subProceso=6']],
                ['label' => 'Produccion', 'url' => ['/produccion2/captura2?subProceso=6']],
            ],

        ],
        [
            'label' => 'Reportes',
            'items' => [
                ['label' => 'Almas', 'url' => ['/site/about']],
                ['label' => 'Moldeo', 'url' => ['/reportes/moldeo']],
                ['label' => 'Cerrado', 'url' => ['/site/about']],
                ['label' => 'Vaciado', 'url' => ['/reportes/vaciado']],
                ['label' => 'Limpieza', 'url' => ['/site/about']],
                ['label' => 'Tiempos Muertos', 'url' => ['/reportes/tiemposmuertos?ini=0&fin=0']],
                ['label' => 'ETE', 'url' => ['/reportes/ete']],
            ],
            'url' => ['/programaciones']
        ],
        ['label' => 'Salir', 'url' => ['/site/quit']],
    ],
    [ //menu para Maquinado

        ['label' => 'Salir', 'url' => ['/site/quit']],
    ],
    [],
];
?>
<?php $this->beginPage() ?>
<?php $this->registerCSS(".container{width:100%;}");?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="programa">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            padding: 0 8px;
        }
        .form-control, .filter{
            //width: 100px;
            height: 30px;
            font-size: 10pt;
        }
        th, td{
            text-align: center;
        }

        .success2{
            background-color: lightgreen;
        }

        .scrollable {
            margin: auto;
            height: 742px;
            border: 2px solid #ccc;
            overflow-y: scroll; /* <-- here is what is important*/
        }
        #pedidos{
            height: 300px;
        }
        thead {
            background: white;
        }
        table {
            width: 100%;
            border-spacing:0;
            margin:0;
        }
        table th , table td  {
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
        }
        .par{
            background-color: #BFB2CF;
        }
        .par2{
            background-color: #DFDBE7;
        }
        .impar{
            background-color: #A4D5E2;
        }
        .impar2{
            background-color: #D1EAF0;
        }
    </style>
</head>
<body onkeypress="return getkey(event,this)">
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            //echo Html::img('@web/frontend/assets/img/fimex_logo.png',['width'=>'100']);
            $area = Yii::$app->session->get('area');
            $brandLabel = ($area !== null ? "<b>Sistema de ".$area['Descripcion']." :: </b>" : "<b>Sistema Fimex :: </b>");
            //var_dump($area);exit;
            if($area !== null){
                $menuItems = $menu[$area['IdArea']];
            }else{
                $model = new Areas();
                
                foreach($model->find()->asArray()->all() as $area => $valores){
                    $menuItems[] = ['label' => $valores['Descripcion'], 'url' => ['/site/index?area='.$valores['IdArea']]];
                }
            }

            NavBar::begin([
                'brandLabel' => $brandLabel,
                'brandUrl'=> '#',
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            if (Yii::$app->user->isGuest) {
                $menuLogin[] = ['label' => 'Iniciar Sesion', 'url' => ['/site/login']];
            } else {
                $menuLogin[] = [
                    'label' => 'Cerrar Sesion',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            if (!Yii::$app->user->isGuest) {
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-left'],
                    'items' => $menuItems,
                ]);
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuLogin,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>