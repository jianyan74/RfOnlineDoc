<?php

use yii\db\Migration;

class m191017_034222_addon_online_doc_content_history extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addon_online_doc_content_history}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'member_id' => "int(11) NULL DEFAULT '0' COMMENT '创建者id'",
            'content_id' => "int(10) NULL DEFAULT '0' COMMENT '内容id'",
            'doc_id' => "int(10) NULL DEFAULT '0' COMMENT '所属文档id'",
            'merchant_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '商户id'",
            'title' => "varchar(50) NOT NULL DEFAULT '' COMMENT '标题'",
            'content' => "text NULL COMMENT '内容管理'",
            'serial_number' => "int(10) NULL DEFAULT '1' COMMENT '自动递增排序'",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态'",
            'created_at' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='扩展_在线文档_文档内容历史记录'");
        
        /* 索引设置 */
        $this->createIndex('content_id','{{%addon_online_doc_content_history}}','content_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addon_online_doc_content_history}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

