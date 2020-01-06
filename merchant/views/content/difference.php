<?php

use common\helpers\Html;

?>

<?= Html::jsFile('@web/resources/plugins/diff_match_patch/diff_match_patch.js'); ?>
<?= Html::jsFile('@web/resources/plugins/diff_match_patch/jquery.pretty-text-diff.min.js'); ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title">第 <?= $changed['serial_number']; ?> 版与当前未修改的版本差异对比结果</h4>
</div>
<div class="modal-body diff-wrapper">
    <div class="col-lg-12 diff"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
</div>

<script>
    $(document).ready(function () {
        $(".diff-wrapper").prettyTextDiff({
            originalContent: "<?= Html::encode($original['content']); ?>",
            changedContent: "<?= Html::encode($changed['content']); ?>",
            diffContainer: ".diff"
        });
    });
</script>