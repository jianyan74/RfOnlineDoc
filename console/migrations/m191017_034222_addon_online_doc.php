<?php

use yii\db\Migration;

class m191017_034222_addon_online_doc extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_online_doc}}', [
            'id' => "int(10) NOT NULL AUTO_INCREMENT",
            'uuid' => "varchar(100) NULL DEFAULT '' COMMENT 'uuid'",
            'merchant_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '商户id'",
            'title' => "varchar(50) NOT NULL COMMENT '标题'",
            'cover' => "varchar(100) NULL DEFAULT '' COMMENT '封面'",
            'nav' => "json NULL COMMENT '导航菜单'",
            'seo_key' => "varchar(50) NULL DEFAULT '' COMMENT 'seo关键字'",
            'seo_content' => "varchar(1000) NULL DEFAULT '' COMMENT 'seo内容'",
            'cate_id' => "int(10) NULL DEFAULT '0' COMMENT '分类id'",
            'description' => "char(140) NULL DEFAULT '' COMMENT '描述'",
            'position' => "smallint(5) NULL DEFAULT '0' COMMENT '推荐位'",
            'content' => "longtext NULL COMMENT '文章内容'",
            'author' => "varchar(40) NULL DEFAULT '' COMMENT '作者'",
            'price' => "decimal(10,2) NULL DEFAULT '0.00' COMMENT '价格'",
            'view' => "int(10) NULL DEFAULT '0' COMMENT '浏览量'",
            'is_authorized' => "tinyint(4) NULL DEFAULT '0' COMMENT '授权访问 0无需 1可试读 2全授权可读'",
            'chapter_number' => "int(10) NULL DEFAULT '0' COMMENT '章节数量'",
            'pid' => "int(11) NULL DEFAULT '0' COMMENT '系列'",
            'sort' => "int(10) NULL DEFAULT '999' COMMENT '优先级'",
            'version' => "varchar(50) NULL DEFAULT '1.0.0' COMMENT '版本号'",
            'comment_num' => "int(10) NULL DEFAULT '0' COMMENT '评论数量'",
            'nice_num' => "int(10) NULL DEFAULT '0' COMMENT '点赞数量'",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态'",
            'created_at' => "int(10) unsigned NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => "int(10) unsigned NULL DEFAULT '0' COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='扩展_在线文档_文档'");
        
        /* 索引设置 */
        $this->createIndex('uuid','{{%addon_online_doc}}','uuid',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_online_doc}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

