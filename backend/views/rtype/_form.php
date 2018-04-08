<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Rmodel;

/* @var $this yii\web\View */
/* @var $model backend\models\Rtype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rtype-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--本表关联字段tid -->
    <?= $form->field($model, 'tid')->dropDownList(
    //与外表关联，通过外表的索引字段mid显示出与其对应的name字段
        ArrayHelper::map(Rmodel::find()->all(),'id','name'),
		['prompt' => '品牌型号']
    ) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
