<?php

use yii\db\Migration;

class m170719_100902_create_tbl_user extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170719_100902_create_tbl_user cannot be reverted.\n";

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
		$tableOptions = null;

        if ($this->db->driverName === 'mysql') { // Тип БД, далее тип таблицы и стандартная кодировка для этой таблицы.
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('tbl_user', [
            'user_id' => $this->primaryKey(),
            'user_username' => $this->string()->notNull()->unique(),
            'user_auth_key' => $this->string(32)->notNull(),
            'user_password_hash' => $this->string()->notNull(),
            'user_password_reset_token' => $this->string()->unique(),
            'user_email' => $this->string()->notNull()->unique(),
            'user_status' => $this->smallInteger()->notNull()->defaultValue(10),
            'user_created_at' => $this->integer()->notNull(),
            'user_updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m170719_100902_create_tbl_user cannot be reverted.\n";

        return false;
    }
    
}
