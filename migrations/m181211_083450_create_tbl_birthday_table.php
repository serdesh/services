<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbl_birthday`.
 */
class m181211_083450_create_tbl_birthday_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_birthday', [
            'b_id' => $this->primaryKey(),
            'b_fio' => $this->string(),
            'b_datbirth' => $this->integer(),
            'b_tel' => $this->string(),
            'b_yearbirth' => $this->integer(),
            'b_notes' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tbl_birthday');
    }
}
