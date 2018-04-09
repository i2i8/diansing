<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RmodelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rmodels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rmodel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rmodel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'mid',
            //@See:http://www.prettyscripts.com/code/php/yii2-gridview-inline-editing-with-editable-column/
            [
                'attribute' => 'name',
                'class'         => 'kartik\grid\EditableColumn',
                'editableOptions'   => function($model, $key, $index) {
                return [
                    'header'        => 'Header Name',
                    'formOptions'   => [
                        'action'    => [
                            '/rmodel/editable',
                        ],
                    ],
                    'submitButton'  => [
                        'class' => 'btn btn-sm btn-primary',
                        'icon'  => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                    ],
                ];
                },
                ],
            'created',
            'updated',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
