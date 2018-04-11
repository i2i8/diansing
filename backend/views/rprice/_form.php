<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use kartik\dialog\Dialog;
use common\models\Rmodel;
use common\models\Rtype;
use wbraganca\dynamicform\DynamicFormWidget;

/**-----------------------------------------------------------------------------------------
 *  <!-- 这里最好引入最新版jq，不会，下拉菜单切换里，会不生效 -->
 *  <script src="http://code.jquery.com/jquery-latest.js"></script>
 *  <script>
 *   //审查元素，获取品牌型号下拉框本身input的id
 *   $("#aprice-model_amid").change(function(){
 *       //为了防止csrf攻击，Yii对post的表单数据封装了CSRF令牌验证
 *       //http://www.yiichina.com/tutorial/467
 *       var _csrf  = "<?= Yii::$app->request->csrfToken ?>";
 *       var url  = "<?= Yii::$app->urlManager->createUrl('atypes/listssss') ?>";
 *       // 	将amodel下拉框传递来的值赋值给amid
 *       var amid = $(this).val();
 *       
 *       $.post(url,{"amid":amid,"_csrf":_csrf},function(data){
 *           //$.post(url,{"id":id},function(data){
 *           console.log(data);
 *           //目标input的id，自行定义的
 *           $("select#aprice-types_atid").html(data);
 *       });
 *   });
 *   </script>
 * -----------------------------------------------------------------------------------------
 * 
 * 
 * 参数传递方法：1
 *           'onchange' => '
 *              $.post("'.Yii::$app->urlManager->createUrl('aprice/lists?id=').'"+$(this).val(), function(data) {
 *                  $("select#aprice-types_atid").html(data);
 *              });'
 * 参数传递方法：2
 * 	         'onchange' => '
 *              $.post("'.Url::toRoute(['atypes/lists','id'=>'']).'"+$(this).val(), function(data) {
 *                  $("select#aprice-types_atid").html(data);
 *              });'
 * widget(Rmodel::getCategories(), 
 */
?>
<div class="rprice-form">
	<?= Dialog::widget(['overrideYiiConfirm' => true]); ?>
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <?=$form->field($model, 'index_mid')->dropDownList(Rmodel::getCategories(), 
        ['id' => 'cat-id', 'prompt' => 'Select Category...']); ?>

    <?=$form->field($model, 'index_tid')->widget(DepDrop::classname(), [
        'data' => Rtype::getSubCatList($model->index_mid),
        'options' => ['id' => 'subcat-id', 'prompt' => 'Select Sub Category...'],
        'pluginOptions' => [
            'depends' => ['cat-id'],
            'placeholder' => 'Select Sub Category...',
            'url' => Url::to(['rprice/subcat'])
        ]
    ]); ?>
    <?= $form->field($model, 'nowprice')->textInput() ?>

    <?= $form->field($model, 'willprice')->textInput() ?>
    
    <?= $form->field($model, 'remark')->textInput() ?>
    
<div class="panel panel-default">
   <div class="panel-heading"><h5><i class="glyphicon glyphicon-envelope"></i>noting......</h5></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 8, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsRemark[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'remark',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsRemark as $i => $modelsRemarks): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
<!--                         <h3 class="panel-title pull-left">Address</h3> -->
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                        if (! $modelsRemarks->isNewRecord) {
                            echo Html::activeHiddenInput($modelsRemarks, "[{$i}]id");
                            }
                        ?>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelsRemarks, "[{$i}]remark")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
