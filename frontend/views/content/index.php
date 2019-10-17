<?php

use common\helpers\Html;
use common\helpers\Url;
use common\helpers\MarkdownHelper;

$title = '';
if (isset($defaultContent['title']) && !empty($defaultContent['title'])) {
    $title = $defaultContent['title'];
}

if (!empty($title)) {
    $this->title = $title . ' · ' . $model['title'] . ' · 在线文档';
} else {
    $this->title = $model['title'] . ' · 在线文档';
}

$this->title = Html::encode($this->title);

?>

<style>
    i {
        min-width: 18px;
        font-size: 13px;
    }

    .content-wrapper {
        background-color: #fff;
    }

    .skin-blue .sidebar-menu > li:hover > a,
    .skin-blue .sidebar-menu > li.active > a,
    .skin-blue .sidebar-menu > li.menu-open > a {
        color: #666;
        background: #fff;
    }

    .skin-blue .sidebar-menu > li.active > a {
        border-left-color: #fff;
    }

    .skin-black-light .sidebar-menu > li > a,
    .skin-black-light .sidebar-menu > li.active > a,
    .skin-black-light .sidebar-menu .treeview-menu > li.active > a {
        font-weight: 500;
    }

    .skin-black-light .main-header .logo {
        border-right: 0;
    }

    .skin-black-light .main-header .navbar .navbar-custom-menu .navbar-nav > li > a,
    .skin-black-light .main-header .navbar .navbar-right > li > a {
        border-left: 0;
        border-right-width: 0;
    }

    .content-null,
    .skin-black-light .sidebar a {
        color: #666;
    }

    .skin-black-light .sidebar-menu > li:hover > a,
    .skin-black-light .sidebar-menu > li.active > a {
        color: #666;
    }

    .main-header .logo {
        font-size: 16px;
        line-height: 50px;
    }

    .sidebar-menu > li > a {
        padding: 9px 5px 9px 15px;
    }

    .markdown-toc ul {
        padding-left: 15px;
        margin: 0;
        list-style-type: square;
    }

    .markdown-toc li a {
        display: block;
        padding: 3px 0;
        color: #000;
    }

    .markdown-toc a:hover, a:focus {
        color: #72afd2;
        text-decoration: underline;
    }

    .versionDropdown{
        padding-top: 8px;
        padding-right: 10px
    }

    select.form-control {
        padding-right: 30px;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAFCAYAAABB9hwOAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpiNWZkMzNlMC0zNTcxLTI4NDgtYjA3NC01ZTRhN2RjMWVmNjEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RTUxRUI3MDdEQjk4MTFFNUI1NDA5QTcyNTlFQzRERTYiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RTUxRUI3MDZEQjk4MTFFNUI1NDA5QTcyNTlFQzRERTYiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6ZWNiNjQzMjYtNDc1Yi01OTQxLWIxYjItNDVkZjU5YjZlODA2IiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6N2RlYzI2YWMtZGI5OC0xMWU1LWIwMjgtY2ZhNDhhOGNjNWY1Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+AXTIGgAAAFRJREFUeNpidI1KSWFgYDBlwASngXjOrqWzGcgBTEC8DIjfo4m/h4qTDUAGfwPi+UD8Hyr2H8r/RqnBIHATiPdC2XuhfIoACxJ7PRDzQmmKAUCAAQDxOxHyb4DjOAAAAABJRU5ErkJggg==) center right no-repeat #fff;
    }

    .form-control {
        box-sizing: border-box;
        border-color: #e4eaec;
        box-shadow: none;
        -webkit-transition: box-shadow .25s linear, border .25s linear, color .25s linear, background-color .25s linear;
        transition: box-shadow .25s linear, border .25s linear, color .25s linear, background-color .25s linear;
        -webkit-appearance: none;
        -moz-appearance: none;
        -webkit-font-smoothing: auto;
        color: #76838f;
    }
</style>

<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= Url::to(['content/index', 'uuid' => $model['uuid']]) ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">Doc</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?= $model['title']; ?></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <div class="navbar-custom-menu pull-left">
                <ul class="nav navbar-nav">
                    <li class="dropdown notifications-menu">
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                            <span class="sr-only">切换导航</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                    </li>
                    <?php foreach ($model['nav'] as $nav){ ?>
                        <?php if (!empty($nav['key']) && !empty($nav['value'])){ ?>
                            <li class="dropdown notifications-menu">
                                <a href="<?= $nav['value'] ?>" target="_blank">
                                    <b><?= Html::encode($nav['key']); ?></b>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php if (!empty($open_plaza)){ ?>
                    <li class="dropdown">
                        <a href="<?= Url::to(['doc/index'])?>" data-method="post"><i class="fa fa fa-home"></i>首页</a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="javascript:void(0);">当前版本</a>
                    </li>
                    <li class="versionDropdown">
                        <?= Html::dropDownList('version', $model['uuid'], $versions, [
                            'class' => 'form-control',
                            'id' => 'version',
                        ])?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- search form -->
            <form action="<?= Url::to(['content/index']) ?>" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="keyword" value="<?= Html::encode($keyword) ?>" class="form-control" placeholder="请输入搜索关键字">
                    <input type="hidden" name="uuid" value="<?= $model['uuid']; ?>">
                    <input type="hidden" name="merchant_id" value="<?= Yii::$app->services->merchant->getId(); ?>">
                    <span class="input-group-btn">
                        <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header" data-rel="external">在线文档</li>
                <?= $this->render('_menu-tree', [
                    'menus' => $menus,
                    'uuid' => $model['uuid'],
                ]) ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content" style="overflow:auto;">
            <!-- Default box -->

            <div class="col-lg-10">
                <?php if (empty($defaultContent)) { ?>
                    <div class="content-null">文档不存在...</div>
                <?php } elseif (empty($defaultContent['content'])) { ?>
                    <div class="content-null">还未填写任何信息...</div>
                <?php } else { ?>
                    <?= MarkdownHelper::toHtml($defaultContent['content'], 'catalogue') ?>
                <?php } ?>
            </div>
            <div class="col-lg-2" id="right-catalogue" style="overflow:auto;">
                <div class="text-right"><h5><?= Html::encode($title); ?></h5></div>
                <div class="text-left"><h5>目录</h5></div>
                <div id="catalogue"></div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script>
    $(document).ready(function () {
        autoChangeContent();

        if ($(this).width() < 769) {
            $("#right-catalogue").addClass('hide');
            return;
        }

        $('.content').scroll(function () {
            let offsetTop = $('.content').scrollTop() + "px";
            $("#right-catalogue").animate({top: offsetTop}, {duration: 600, queue: false});
        });
    });

    $(window).resize(function () {
        autoChangeContent();

        if ($(this).width() < 769) {
            $("#right-catalogue").addClass('hide');
        } else {
            $("#right-catalogue").removeClass('hide');
        }
    });

    $('#version').change(function () {
        var uuid = $(this).val();
        window.location = '<?= Url::to(['content/index'])?>' + '&uuid=' + uuid;
    });

    function autoChangeContent() {
        // 改变框架高度
        var mainContent = window.innerHeight - 83;
        $(".content").height(mainContent);
        $("#right-catalogue").height(mainContent);
    }
</script>

