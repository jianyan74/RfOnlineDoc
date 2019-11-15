<?php

use yii\db\Migration;

class m191106_013319_addon_online_doc_content extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_online_doc_content}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'uuid' => "varchar(100) NULL DEFAULT '' COMMENT 'uuid'",
            'member_id' => "int(11) NULL DEFAULT '0' COMMENT '创建者id'",
            'doc_id' => "int(10) NULL DEFAULT '0' COMMENT '所属文档id'",
            'merchant_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '商户id'",
            'type' => "tinyint(1) NULL DEFAULT '0' COMMENT '章节类型'",
            'title' => "varchar(50) NOT NULL DEFAULT '' COMMENT '标题'",
            'content' => "text NULL COMMENT '内容管理'",
            'sort' => "int(5) NULL DEFAULT '999' COMMENT '排序'",
            'level' => "tinyint(1) NULL DEFAULT '1' COMMENT '级别'",
            'pid' => "int(50) NULL DEFAULT '0' COMMENT '上级id'",
            'tree' => "varchar(500) NOT NULL DEFAULT '' COMMENT '树'",
            'view' => "int(10) NULL DEFAULT '0' COMMENT '浏览量'",
            'comment_num' => "int(10) NULL DEFAULT '0' COMMENT '评论数量'",
            'nice_num' => "int(10) NULL DEFAULT '0' COMMENT '点赞数量'",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态'",
            'created_at' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='扩展_在线文档_文档章节'");
        
        /* 索引设置 */
        $this->createIndex('uuid','{{%addon_online_doc_content}}','uuid',0);
        $this->createIndex('doc_id','{{%addon_online_doc_content}}','doc_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_online_doc_content}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

