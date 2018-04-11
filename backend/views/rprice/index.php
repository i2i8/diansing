<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use backend\models\RemarkSearch;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RpriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rprices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rprice-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rprice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $gridColumns = [
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'value' => function ($model, $key, $index, $colum) {
                return GridView::ROW_COLLAPSED;
            },
            'contentOptions' => function ($model) {
                if ($model->remark == 'ds') {
                    return ['class' => 'success'];
                }elseif ($model->remark == 'dd') {
                    return ['class' => 'info'];;
                }
            },
            'detail' => function ($model, $key, $index, $colum) {
                $searchModel = new RemarkSearch();
                $searchModel->eid = $model->pid;
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                
                return Yii::$app->controller->renderPartial('_details', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
                ]);
            }
        ],
        
        [ // model_amid:本表里与外表关联的本表的关联字段
            'attribute' => 'index_mid',
            'value' => 'indexM.name'
        ],
        
        // 'id',
        // 'model_amid',
        // modelAmid来源于Aprice模型末尾的hasOne
        // 'modelAmid.name',
        // 'types_atid',
        [
            'attribute' => 'index_tid',
            'value' => 'indexT.type'
        ],
        // 'typesAtid.types',
        // 'aprid',
        // 'nowprice',
        // 'willprice',
        [
            'attribute' => 'nowprice',
            'value' => 'nowprice',
            'hAlign' => 'center',
            'width' => '75px'
        ],
        [
            'attribute' => 'willprice',
            'value' => 'willprice',
            'hAlign' => 'center',
            'width' => '75px'
        ],
        
        [
            'attribute' => 'updated',
            'value' => 'updated',
            'hAlign' => 'center',
            'width' => '150px'
        ],
        [
            'class' => 'yii\grid\ActionColumn'
        ]
    ];
    ?>
    <?php
        // Renders a export dropdown menu
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        // https://stackoverflow.com/questions/46089232/yii2-exportmenu-with-gridview-header-in-excel-file
        'target' => ExportMenu::TARGET_SELF,
        'filename' => 'export-list_' . date('Y-m-d'),
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_EXCEL => false,
            ExportMenu::FORMAT_CSV => false,
            ExportMenu::FORMAT_EXCEL_X => [
                'icon' => true ? 'file-excel-o' : 'floppy-remove',
                'iconOptions' => [
                    'class' => 'text-success'
                ],
                'linkOptions' => [],
                'options' => [
                    'title' => "Microsoft Excel 2007+ (xlsx)"
                ],
                'alertMsg' => "The EXCEL 2007+ (xlsx) export file will be generated for download.",
                'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'extension' => 'xlsx'
            ]
        ]
    ]);
    
    // You can choose to render your own GridView separately
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'columns' => $gridColumns
    ]);
    ?>
</div>
