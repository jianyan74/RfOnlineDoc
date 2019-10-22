<?php

use common\helpers\Html;
use common\helpers\Url;

$this->title = $config['title'] ?? '在线文档';

?>

<style>
    body, hmtl {
        background: #ecf0f1;
        font-family: 'Anton', sans-serif;
    }

    .skin-black-light .wrapper,
    .skin-black-light .main-sidebar,
    .skin-black-light .left-side {
        background-color: #ecf0f1;
    }

    .mailbox-attachment-icon {
        background-color: #fff;
    }

    .mailbox-attachment-info {
        background-color: #fff;
    }

    .mailbox-attachment-size {
        padding-top: 10px;
        background-color: #fff;
    }

    .mailbox-attachment-name {
        font-weight: 500;
    }

    a,
    a:hover,
    a:focus {
        color: #3e8ef7;
    }

    .fa-file-text {
        font-size: 50px;
    }

    .text-purple {
        color: #1dc9b7 !important;
    }

    .pagination > .active > a,
    .pagination > .active > a:focus,
    .pagination > .active > a:hover,
    .pagination > .active > span,
    .pagination > .active > span:focus,
    .pagination > .active > span:hover {
        background-color: #1dc9b7;
        border-color: #1dc9b7;
    }

    .nav-stacked > li > a,
    .nav > li > a:hover, .nav > li > a:active,
    .nav > li > a:focus {
        color: #636b6f;
    }

    .nav-stacked > li.active > a, .nav-stacked > li.active > a:hover {
        background: transparent;
        color: #636b6f;
        border-top: 0;
        border-left-color: #1dc9b7;
    }

    .pagination {
        margin-top: 0;
    }

    .pagination > li > a:focus, .pagination > li > a:hover, .pagination > li > span:focus, .pagination > li > span:hover {
        z-index: 2;
        color: #1dc9b7;
        background-color: #eee;
        border-color: #ddd;
    }

    .logo {
        font-size: 2.15rem;
        line-height: 60px;
        text-align: center;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-weight: 500;
        outline: none !important;
        color: #282a3c !important;
        box-sizing: border-box;
    }

    .nav {
        background-color: #fff;
        margin-bottom: 20px;
        box-shadow: 0 0 3px 0 rgba(82, 63, 105, 0.1);
    }

    .content {
        padding: 0;
    }
</style>

<!-- Site wrapper -->
<div class="wrapper">
    <div class="content">
        <!-- Main content -->
        <div class="row">
            <div class="col-lg-12 nav">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                    <div class="col-lg-12">
                        <a href="<?= Url::to(['doc/index']); ?>" class="logo"><?= $config['title'] ?? '在线文档'; ?></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="col-lg-3">
                    <div class="box box-solid">
                        <div class="box-body">
                            <!-- the events -->
                            <div id="external-events">
                                <form action="<?= Url::to(['index']) ?>" method="get" class="sidebar-form">
                                    <div class="input-group">
                                        <input type="text" name="keyword" value="<?= Html::encode($keyword) ?>" class="form-control" placeholder="请输入搜索关键字">
                                        <input type="hidden" name="merchant_id" value="<?= Yii::$app->services->merchant->getId(); ?>">
                                        <span class="input-group-btn">
                                            <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="border-bottom-none <?php if(empty($cate_id)) { ?>active<?php } ?>">
                                        <a href="<?= Url::to(['index']); ?>">
                                            全部分类
                                        </a>
                                    </li>
                                    <?php foreach ($cates as $key => $value) { ?>
                                    <li class="border-bottom-none <?php if($cate_id == $key) { ?>active<?php } ?>">
                                        <a href="<?= Url::to(['index', 'cate_id' => $key]); ?>">
                                            <?= Html::encode($value); ?>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-lg-9">
                    <?php foreach ($models as $model) { ?>
                        <div class="col-lg-4" style="margin-bottom: 30px">
                            <span class="mailbox-attachment-icon">
                                <?php if (!empty($model['cover'])) {?>
                                    <img src="<?= $model['cover']; ?>" alt="" width="64" height="64">
                                <?php }else{ ?>
                                    <i class="fa fa-file-text text-purple"></i>
                                <?php } ?>
                            </span>
                            <div class="mailbox-attachment-info text-center">
                                <a href="<?= Url::to(['content/index', 'uuid' => $model['uuid']]); ?>" class="mailbox-attachment-name"><?= Html::encode($model['title']); ?></a>
                                <span class="mailbox-attachment-size">作者：<?= Html::encode($model['author']); ?></span>
                                <span class="mailbox-attachment-size">章节数：<?= Html::encode($model['chapter_number']); ?> 篇</span>
                                <span class="mailbox-attachment-size" style="padding-bottom: 30px">
                                    <a href="<?= Url::to(['content/index', 'uuid' => $model['uuid']]); ?>">了解更多</a>
                            </span>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-lg-12">
                        <?= \yii\widgets\LinkPager::widget([
                            'pagination' => $pages,
                            'maxButtonCount' => 5,
                            'nextPageLabel' => '<i class="icon ion-ios-arrow-right"></i>',
                            'prevPageLabel' => '<i class="icon ion-ios-arrow-left"></i>',
                            'lastPageLabel' => '<i class="icon ion-ios-arrow-right"></i><i class="icon ion-ios-arrow-right"></i>',
                            'firstPageLabel' => '<i class="icon ion-ios-arrow-left"></i><i class="icon ion-ios-arrow-left"></i>',
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
