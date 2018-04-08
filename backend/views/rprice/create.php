<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Rprice */

$this->title = 'Create Rprice';
$this->params['breadcrumbs'][] = ['label' => 'Rprices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rprice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsRemark' => $modelsRemark,
    ]) ?>

</div>
