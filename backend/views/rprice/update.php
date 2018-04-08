<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Rprice */

$this->title = 'Update Rprice: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Rprices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rprice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsRemark' => $modelsRemark,
    ]) ?>

</div>
