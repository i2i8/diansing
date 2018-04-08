<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Rmodel */

$this->title = 'Create Rmodel';
$this->params['breadcrumbs'][] = ['label' => 'Rmodels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rmodel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
