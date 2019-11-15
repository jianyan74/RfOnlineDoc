<?php

namespace addons\RfOnlineDoc\services;

use common\components\Service;

/**
 * Class Application
 * @package addons\RfTinyShop\services
 * @property \addons\RfOnlineDoc\services\doc\DocService $doc 文档
 * @property \addons\RfOnlineDoc\services\doc\ContentService $content 文档内容
 * @property \addons\RfOnlineDoc\services\doc\ContentHistoryService $contentHistory 文档历史
 * @property \addons\RfOnlineDoc\services\doc\ActionService $action 文档行为
 * @property \addons\RfOnlineDoc\services\doc\CateService $cate 文档行为
 * @property \addons\RfOnlineDoc\services\doc\TemplateService $template 模板
 *
 * @author jianyan74 <751393839@qq.com>
 */
class Application extends Service
{
    /**
     * @var array
     */
    public $childService = [
        'doc' => 'addons\RfOnlineDoc\services\doc\DocService',
        'content' => 'addons\RfOnlineDoc\services\doc\ContentService',
        'contentHistory' => 'addons\RfOnlineDoc\services\doc\ContentHistoryService',
        'action' => 'addons\RfOnlineDoc\services\doc\ActionService',
        'cate' => 'addons\RfOnlineDoc\services\doc\CateService',
        'template' => 'addons\RfOnlineDoc\services\doc\TemplateService',
    ];
}