<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m180726_083713_addYandexUID
 */
class m180726_083713_addYandexUID extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'yandexMailUID', Schema::TYPE_BIGINT . ' DEFAULT 0');
        $this->addCommentOnColumn('{{%user}}', 'yandexMailUID', 'UID пользователя в почте Яндекса. (для поиска неисполненных писем в почте яндекса)');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
//        echo "m180726_083713_addYandexUID cannot be reverted.\n";
        $this->dropColumn('{{%user}}', 'yandexMailUID');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180726_083713_addYandexUID cannot be reverted.\n";

        return false;
    }
    */
}
