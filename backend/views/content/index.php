<?php

use common\helpers\Html;
use jianyan\treegrid\TreeGrid;

$this->title = '页面管理';
$this->params['breadcrumbs'][] = ['label' => '文档管理', 'url' => ['doc/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title . ' · ' . $doc['title']; ?></h3>
                <div class="box-tools">
                    <?= Html::create(['edit', 'doc_id' => $doc_id]) ?>
                </div>
            </div>
            <div class="box-body table-responsive">
                <?= TreeGrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'pid',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                        // 'initialState' => 'collapsed',
                    ],
                    'options' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($doc_id) {
                                $str = Html::tag('span', $model->title, [
                                    'class' => 'm-l-sm',
                                ]);
                                $str .= Html::a(' <i class="icon ion-android-add-circle"></i>',
                                    ['edit', 'pid' => $model['id'], 'doc_id' => $doc_id]);

                                return $str;
                            },
                        ],
                        'view',
                        [
                            'attribute' => 'sort',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'col-md-1'],
                            'value' => function ($model, $key, $index, $column) {
                                return Html::sort($model->sort);
                            },
                        ],
                        [
                            'label'=> '修改时间',
                            'attribute' => 'updated_at',
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{history} {edit} {status} {delete}',
                            'buttons' => [
                                'history' => function ($url, $model, $key) use ($doc_id) {
                                    return Html::linkButton(['history', 'content_id' => $model->id, 'doc_id' => $doc_id], '历史版本', [
                                        'class' => 'btn btn-white btn-sm openHistory',
                                    ]);
                                },
                                'edit' => function ($url, $model, $key) use ($doc_id) {
                                    return Html::edit(['edit', 'id' => $model->id, 'doc_id' => $doc_id], '编辑');
                                },
                                'status' => function ($url, $model, $key) {
                                    return Html::status($model->status);
                                },
                                'delete' => function ($url, $model, $key) use ($doc_id) {
                                    return Html::delete(['destroy', 'id' => $model->id, 'doc_id' => $doc_id]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<script>
    // 打一个新窗口
    $('.openHistory').click(function () {
        var content = $(this).attr('href');

        layer.open({
            type: 2,
            title: '历史版本',
            shade: 0.3,
            offset: '10%',
            shadeClose : true,
            btn: ['关闭'],
            yes: function(index, layero) {
                layer.closeAll();
            },
            area: ['80%', '80%'],
            content: content
        });

        return false;
    });
</script>