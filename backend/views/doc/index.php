<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\helpers\Url;

$this->title = '文档管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    <?= Html::create(['edit']); ?>
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
                            'attribute' => 'cate_id',
                            'label'=> '所属分类',
                            'filter' => Html::activeDropDownList($searchModel, 'cate_id', $cates, [
                                    'prompt' => '全部',
                                    'class' => 'form-control'
                                ]
                            ),
                            'value' => function ($model) use ($cates) {
                                return $cates[$model->cate_id] ?? '';
                            },
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'attribute' => 'version',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'attribute' => 'author',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'attribute' => 'view',
                            'headerOptions' => ['class' => 'col-md-1'],
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
                            'attribute' => 'pid',
                            'label'=> '所属系列',
                            'filter' => Html::activeDropDownList($searchModel, 'pid', $items, [
                                    'prompt' => '全部',
                                    'class' => 'form-control'
                                ]
                            ),
                            'value' => function ($model) {
                                return $model->parent['title'] ?? '顶级系列';
                            },
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {content} {edit} {status} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('预览', Url::toFront(['content/index', 'uuid' => $model['uuid']]), [
                                        'class' => "btn btn-white btn-sm",
                                        'target' => '_blank',
                                    ]);
                                },
                                'content' => function ($url, $model, $key) {
                                    return Html::linkButton(['content/index', 'doc_id' => $model['id']], '章节管理');
                                },
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