<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Rtype */

$this->title = 'Update Rtype: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Rtypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rtype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
