<?php

return [
    // ----------------------- 默认配置 ----------------------- //

    'config' => [
        // 菜单配置
        'menu' => [
            'location' => 'addons', // default:系统顶部菜单;addons:应用中心菜单
            'icon' => 'fa fa-puzzle-piece',
        ],
        // 子模块配置
        'modules' => [

        ],
    ],

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
        'cate/ajax-edit' => '分类编辑',
        'cate/ajax-update' => '分类状态修改',
        'cate/delete' => '分类删除',
        'template/index' => '模板首页',
        'template/edit' => '模板编辑',
        'template/ajax-update' => '模板状态修改',
        'template/delete' => '模板删除',
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
        [
            'title' => '模板管理',
            'route' => 'template/index',
            'icon' => '',
            'params' => [

            ],
        ],
    ],
];