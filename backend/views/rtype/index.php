<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RtypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rtypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rtype-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rtype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'vid',
            [
                'attribute' => 'tid',
                'value' => 't.name',
            ],       
            //@See:http://www.prettyscripts.com/code/php/yii2-gridview-inline-editing-with-editable-column/
            [
                'attribute' => 'type',
                'class'         => 'kartik\grid\EditableColumn',
                'editableOptions'   => function($model, $key, $index) {
                return [
                    'header'        => 'Header Name',
                    'formOptions'   => [
                        'action'    => [
                            '/rtype/editable',
                        ],
                    ],
                    'submitButton'  => [
                        'class' => 'btn btn-sm btn-primary',
                        'icon'  => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                    ],
                ];
              },
            ],
            //'type',
            //'created',
            //'updated',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
