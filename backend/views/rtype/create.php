<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Rtype */

$this->title = 'Create Rtype';
$this->params['breadcrumbs'][] = ['label' => 'Rtypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rtype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
