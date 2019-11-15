<?php

use common\helpers\Url;
use common\helpers\Html;

?>

<?php foreach ($menus as $item) { ?>
    <?php if (empty($item['-'])) { ?>
        <li class="<?php if (isset($item['is_active'])) { echo 'active';} ?>">
            <a href="<?= Url::to(['content/index', 'uuid' => $uuid, 'content_id' => $item['uuid']])?>">
                <i class="fa fa-file-text-o"></i> <span><?= Html::encode($item['title']); ?></span>
            </a>
        </li>
    <?php } else { ?>
        <li class="treeview <?php if (isset($item['is_active'])) { echo 'active';} ?>">
            <a href="#">
                <i class="fa fa-folder-o"></i> <span><?= Html::encode($item['title']); ?></span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
                <?= $this->render('_menu-tree', [
                    'menus' => $item['-'],
                    'uuid' => $uuid
                ]) ?>
            </ul>
        </li>
    <?php } ?>
<?php } ?>