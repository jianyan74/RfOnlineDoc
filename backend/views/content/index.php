<?php

use common\helpers\Url;
use common\helpers\Html;
use common\helpers\AddonHelper;
use jianyan\treegrid\TreeGrid;

$this->title = '章节管理';
$this->params['breadcrumbs'][] = ['label' => '文档管理', 'url' => ['doc/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
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
                <h3 class="box-title"><?= $this->title . ' · ' . $doc['title']; ?></h3>
                <div class="box-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-white dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">创建</button>
                        <button type="button" class="btn btn-white dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu top-create" role="menu">
                            <li><a href="<?= Url::to(['edit', 'doc_id' => $doc_id, 'type' => 1])?>">MarkDown</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= Url::to(['edit', 'doc_id' => $doc_id, 'type' => 2])?>">普通章节</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="box-body table-responsive">
                <?= TreeGrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'pid',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                         'initialState' => 'collapsed',
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

                                $markdownUrl = Url::to(['edit', 'pid' => $model['id'], 'doc_id' => $doc_id, 'type' => 1]);
                                $UEditorUrl = Url::to(['edit', 'pid' => $model['id'], 'doc_id' => $doc_id, 'type' => 2]);

                                $str .= <<<HTML
                    <div class="btn-group">
                        <a class="icon ion-android-add-circle dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="$markdownUrl">MarkDown</a></li>
                            <li class="divider"></li>
                            <li><a href="$UEditorUrl">普通章节</a></li>
                        </ul>
                    </div>
HTML;

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