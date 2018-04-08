<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RemarkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="remark-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //隐藏搜索框
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width' => '25']],
            //'id',
            //'eid',
            'remark',
            //'created',
            //'updated',
            [
                'attribute' => 'updated',
                'value' => 'updated',
                'hAlign'=>'center',
                'width'=>'150px',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
