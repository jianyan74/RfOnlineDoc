<?php

use yii\widgets\ActiveForm;
use common\widgets\webuploader\Files;
use common\helpers\Url;

$this->title = '参数设置';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">基础设置</h3>
            </div>
            <?php $form = ActiveForm::begin([]); ?>
            <div class="box-body">
                 <div class="col-sm-12">
                     <?= $form->field($model, 'open_plaza')->checkbox(); ?>
                     <?= $form->field($model, 'title')->textInput(); ?>
                    <?= $form->field($model, 'ip')->textarea(['style' => [
                            'height' => '200px'
                    ]])->hint('多个 ip 换行显示, 不填为不限制。 支持通配符 *，例如：127.0.0.*'); ?>
                </div>
            </div>
            <div class="box-footer text-center">
                <button class="btn btn-primary" type="submit">保存</button>
                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
