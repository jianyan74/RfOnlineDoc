<?php

use yii\widgets\ActiveForm;
use common\enums\StatusEnum;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '文档管理', 'url' => ['doc/index']];
$this->params['breadcrumbs'][] = ['label' => '章节管理', 'url' => ['index', 'doc_id' => $model->doc_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">基本信息</h3>
            </div>
            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'template' => "<div class='col-sm-1 text-right'>{label}</div><div class='col-sm-11'>{input}{hint}{error}</div>",
                ],
            ]); ?>
            <div class="box-body">
                <?= $form->field($model, 'pid')->dropDownList($dropDownList) ?>
                <?= $form->field($model, 'title')->textInput(); ?>
                <?= $form->field($model, 'sort')->textInput(); ?>
                <?= $form->field($model, 'status')->radioList(StatusEnum::$listExplain); ?>
                <?= $form->field($model, 'content')->widget(\common\widgets\markdown\Markdown::class); ?>
            </div>
            <div class="box-footer text-center">
                <button class="btn btn-primary" type="submit">保存</button>
                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
