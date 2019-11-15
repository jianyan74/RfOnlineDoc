<?php

use yii\widgets\ActiveForm;
use common\enums\StatusEnum;
use common\widgets\webuploader\Files;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '文档管理', 'url' => ['doc/index']];
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
                <?= $form->field($model, 'pid')->dropDownList($items)->hint('注意: 如果已有子系列不允许修改顶级系列为其他系列'); ?>
                <?= $form->field($model, 'title')->textInput()->hint('建议最长不超过 12 个中文长度'); ?>
                <?= $form->field($model, 'cate_id')->dropDownList($cates); ?>
                <?= $form->field($model, 'version')->textInput(); ?>
                <?= $form->field($model, 'author')->textInput(); ?>
                <?= $form->field($model, 'sort')->textInput(); ?>
                <?= $form->field($model, 'cover')->widget(Files::class, [
                    'config' => [
                        // 可设置自己的上传地址, 不设置则默认地址
                        // 'server' => '',
                        'pick' => [
                            'multiple' => false,
                        ],
                    ]
                ]); ?>
                <?= $form->field($model, 'nav')->widget(\unclead\multipleinput\MultipleInput::class, [
                    'max' => 6,
                    'columns' => [
                        [
                            'name'  => 'key',
                            'title' => '链接名称',
                            'enableError' => false,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                        [
                            'name'  => 'value',
                            'title' => '链接地址',
                            'enableError' => false,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                    ]
                ]); ?>
                <?= $form->field($model, 'description')->textarea(); ?>
                <?= $form->field($model, 'status')->radioList(StatusEnum::getMap()); ?>
            </div>
            <div class="box-footer text-center">
                <button class="btn btn-primary" type="submit">保存</button>
                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
