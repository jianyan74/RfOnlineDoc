<?php

return [
    // ----------------------- 权限配置 ----------------------- //

    'authItem' => [
        'doc/index' => '文档首页',
        'doc/edit' => '文档编辑',
        'doc/ajax-update' => '文档状态修改',
        'doc/destroy' => '文档删除',
        'content/index' => '页面首页',
        'content/edit' => '页面编辑',
        'content/ajax-update' => '页面状态修改',
        'content/destroy' => '页面删除',
        'content/history' => '历史版本',
        'content/comparison' => '历史版本对比',
        'content/restore' => '历史记录还原',
        'cate/index' => '分类首页',
        'cate/edit' => '分类编辑',
        'cate/ajax-update' => '分类状态修改',
        'cate/delete' => '分类删除',
    ],

    // ----------------------- 快捷入口 ----------------------- //

    'cover' => [

    ],

    // ----------------------- 菜单配置 ----------------------- //

    'menu' => [
        [
            'title' => '文档管理',
            'route' => 'doc/index',
            'icon' => '',
            'params' => [
            
            ],
        ],
        [
            'title' => '文档分类',
            'route' => 'cate/index',
            'icon' => '',
            'params' => [

            ],
        ],
    ],
];