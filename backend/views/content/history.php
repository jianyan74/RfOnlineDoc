<?php

use common\helpers\Url;
use common\helpers\Html;

?>

<?= Html::jsFile('@web/resources/plugins/diff_match_patch/diff_match_patch.js'); ?>
<?= Html::jsFile('@web/resources/plugins/diff_match_patch/jquery.pretty-text-diff.min.js'); ?>

<div class="row diff-wrapper">
    <div class="col-lg-12">
        <div class="col-lg-9">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title diff1"></h3>
                    <div class="pull-right diff-version"></div>
                </div>
                <div class="box-body diff2" style="overflow:auto;"></div>
                <div class="box-footer">
                    <div class="demo-del"></div>
                    绿色表示与前一版本比较的新增内容，红色表示与前一版本比较的删除内容
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">历史版本</h3>
                    <div class="pull-right">
                        <label class="m-b-none"><input type="checkbox" id="is_newest" name="is_newest" value="1"> 与最新版比较</label>
                    </div>
                </div>
                <div class="box-body doc-version" style="overflow:auto;">
                    <?php foreach ($history as $value) { ?>
                        <div class="mailbox-attachment-info" data-id="<?= $value['id']; ?>">
                            <a href="#" class="mailbox-attachment-name"><?= $value['member']['username']; ?> 修改了文件</a>
                            <span class="mailbox-attachment-size">
                                <?= $value['created_at']; ?>
                            </span>
                            <span class="mailbox-attachment-size">
                                <a href="#" class="mailbox-view">查看</a>
                                <a href="#" class="mailbox-restore">还原</a>
                                <span class="btn btn-default btn-xs pull-right">第<?= $value['serial_number']; ?>版</span>
                            </span>
                        </div>
                    <?php } ?>
                </div>
                <div class="box-footer text-center doc-more">
                    <a href="#" class="blue more">加载更多</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 添加模板 -->
<script id="addHtml" type="text/html">
    {{each data as value i}}
    <div class="mailbox-attachment-info" data-id="{{value.id}}">
        <a href="#" class="mailbox-attachment-name">{{value.member.username}} 修改了文件</a>
        <span class="mailbox-attachment-size">
            {{value.created_at}}
        </span>
        <span class="mailbox-attachment-size">
            <a href="#" class="mailbox-view">查看</a>
            <a href="#" class="mailbox-restore">还原</a>
            <span class="btn btn-default btn-xs pull-right">第{{value.serial_number}}版</span>
        </span>
    </div>
    {{/each}}
</script>

<script>
    var old_id;
    var view_old_id;
    var page = 2;

    $(window).resize(function () {
        autoChangeContent();
    });

    $(document).ready(function () {
        autoChangeContent();

        // 触发默认请求
        $(".doc-version div a:first").click();
    });

    // 还原
    $('.more').click(function () {
        var content_id = <?= $content_id; ?>;

        $.ajax({
            type: "get",
            url: "<?= Url::to(['history'])?>",
            dataType: "json",
            data: {content_id: content_id, page: page},
            success: function (result) {
                if (parseInt(result.code) === 200) {
                    if (result.data.length === 0) {
                        $('.doc-more').html('已加载全部');
                    }

                    var html = template('addHtml', result);
                    $('.doc-version').append(html);

                    page++;
                } else {
                    rfMsg(result.message);
                }
            }
        });
    });

    // 查看
    $(document).on("click", ".mailbox-view", function () {
        var id = $(this).parent().parent().data('id');
        // 获取选中
        $('.mailbox-attachment-info').removeClass('active');
        $(this).parent().parent().addClass('active');

        if (view_old_id === id) {
            return;
        }

        view_old_id = id;
        old_id = 0;

        $.ajax({
            type: "get",
            url: "<?= Url::to(['comparison'])?>",
            dataType: "json",
            data: {history_id: id},
            success: function (result) {
                if (parseInt(result.code) === 200) {
                    var data = result.data;
                    $('.diff-version').text('当前版本为第 ' + data.changed.serial_number + ' 版');

                    $(".diff1").html(data.changed.title);
                    $(".diff2").html('<textarea id="content" class="form-control">' + data.changed.content + '</textarea>');

                    autoChangeContent();
                } else {
                    rfMsg(result.message);
                }
            }
        });
    });

    // 还原
    $(document).on("click", ".mailbox-restore", function () {
        var id = $(this).parent().parent().data('id');

        swal('确定还原至该版本么？', {
            buttons: {
                cancel: "取消",
                defeat: '确定',
            },
            title: '确定还原至该版本么？',
            text: '请谨慎操作',
            // icon: "warning",
        }).then(function (value) {
            switch (value) {
                case "defeat":
                    $.ajax({
                        type: "get",
                        url: "<?= Url::to(['restore'])?>",
                        dataType: "json",
                        data: {history_id: id},
                        success: function (result) {
                            if (parseInt(result.code) === 200) {
                                rfSuccess('还原成功')
                            } else {
                                rfMsg(result.message);
                            }
                        }
                    });
                    break;
                default:
            }
        });
    });

    // 对比
    $(document).on("click", ".mailbox-attachment-name", function () {
        var id = $(this).parent().data('id');

        // 获取选中
        $('.mailbox-attachment-info').removeClass('active');
        $(this).parent().addClass('active');

        if (old_id === id) {
            return;
        }

        // 最新版本比较
        var is_newest = $('#is_newest').is(':checked') ? 1 : 0;

        old_id = id;
        view_old_id = 0;

        $.ajax({
            type: "get",
            url: "<?= Url::to(['comparison'])?>",
            dataType: "json",
            data: {history_id: id, is_newest: is_newest},
            success: function (result) {
                if (parseInt(result.code) === 200) {
                    var data = result.data;

                    $('.diff-version').text('第 ' + data.changed.serial_number + ' 版与第 ' + data.original.serial_number + ' 版的比较结果');

                    $(".diff-wrapper").prettyTextDiff({
                        originalContent: data.original.title,
                        changedContent: data.changed.title,
                        diffContainer: ".diff1"
                    });

                    $(".diff-wrapper").prettyTextDiff({
                        originalContent: data.original.content,
                        changedContent: data.changed.content,
                        diffContainer: ".diff2"
                    });

                } else {
                    rfMsg(result.message);
                }
            }
        });
    });

    function autoChangeContent() {
        // 改变框架高度
        var mainContent = window.innerHeight - 190;
        $(".diff2").height(mainContent);
        $(".doc-version").height(mainContent);
        $("#content").height(mainContent);
    }
</script>
