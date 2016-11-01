<?php

use yii\db\Schema;
use app\migrations\Migration;

class m141230_081319_create_news extends Migration
{
    public function safeUp()
    {
        /**
         * News
         */
        $this->createTable('{{%news}}', [
            'id' => Schema::TYPE_PK,
            'type_id' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT 0",
            'title' => Schema::TYPE_STRING . " NOT NULL DEFAULT ''",
            'text' => "longtext",
            'preview' => Schema::TYPE_STRING . " NOT NULL DEFAULT ''",
            'date_create' => Schema::TYPE_TIMESTAMP . " NULL DEFAULT NULL",
            'date_update' => Schema::TYPE_TIMESTAMP . " NULL DEFAULT NULL",
            'date_pub' => Schema::TYPE_TIMESTAMP . " NULL DEFAULT NULL",
            'reference' => Schema::TYPE_STRING . " NOT NULL DEFAULT ''",
            'status' => "tinyint(1) NOT NULL DEFAULT 0",
        ], $this->tableOptions);

        $this->createIndex('title', '{{%news}}', 'title');
        $this->createIndex('type_id', '{{%news}}', 'type_id');
        $this->createIndex('status', '{{%news}}', 'status');

        /**
         * Types
         */
        $this->createTable('{{%news_type}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . " NOT NULL",
        ], $this->tableOptions);

        /**
         * Tags
         */
        $this->createTable('{{%news_tags}}', [
            'news_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'tag_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], $this->tableOptions);

        $this->addPrimaryKey('key', '{{%news_tags}}', 'news_id, tag_id');

        $this->addForeignKey('fk_news_tag', '{{%news_tags}}', 'news_id', '{{%news}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%news_tags}}');
        $this->dropTable('{{%news_type}}');
        $this->dropTable('{{%news}}');
    }
}
