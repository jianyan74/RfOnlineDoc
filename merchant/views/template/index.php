<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\helpers\Url;
use common\helpers\AddonHelper;

$this->title = '模板管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .top-create {
        right: 0;
        left: auto;
    }

    .btn-group.open .dropdown-toggle {
        -webkit-box-shadow: inset 0 0 0 rgba(0,0,0,.125);
        box-shadow: 0;
    }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    <div class="box-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-white dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">创建</button>
                            <button type="button" class="btn btn-white dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu top-create" role="menu">
                                <li><a href="<?= Url::to(['edit', 'type' => 1])?>">MarkDown</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= Url::to(['edit', 'type' => 2])?>">普通章节</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    //重新定义分页样式
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        'id',
                        'title',
                        [
                            'label' => '类型',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                if ($model->type == 1) {
                                    $str = Html::img(AddonHelper::file('img/editormd.png'), [
                                        'width' => '15px',
                                        'height' => '15px',
                                    ]);
                                } else {
                                    $str = Html::img(AddonHelper::file('img/UEditor.png'), [
                                        'width' => '32px',
                                        'height' => '15px',
                                    ]);
                                }

                                return $str;
                            },
                        ],
                        [
                            'attribute' => 'sort',
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return Html::sort($model->sort);
                            },
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{edit} {status} {delete}',
                            'buttons' => [
                                'edit' => function ($url, $model, $key) {
                                    return Html::edit(['edit', 'id' => $model['id']]);
                                },
                                'status' => function ($url, $model, $key) {
                                    return Html::status($model->status);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::delete(['destroy', 'id' => $model->id]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>