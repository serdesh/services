<?php

use yii\db\Migration;

/**
 * Class m180719_055201_upgrade_task
 */
class m180719_055201_upgrade_task extends Migration
{
    private $table = 'tbl_task';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->table,'task_deleted', $this->integer(1). ' DEFAULT 0');
        $this->addCommentOnColumn($this->table, 'task_deleted', 'Пометка на удаление. Значения 1 и 0');
        $this->addColumn($this->table,'task_solution', $this->text());
        $this->addCommentOnColumn($this->table, 'task_solution', 'Решение');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
//        $this->dropColumn('tbl_task','task_deleted');
//        $this->dropColumn('tbl_task','task_solution');
//        return true;
        echo "m180719_055201_upgrade_task cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180719_055201_upgrade_task cannot be reverted.\n";

        return false;
    }
    */
}
