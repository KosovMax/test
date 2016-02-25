<?php

use yii\db\Migration;

class m160224_173435_citymaps extends Migration
{
    public function up()
    {
        $this->createTable('citymaps',[
            'cityid' => $this->primaryKey(),
            'address' => $this->string(500),
            'coorYX' => $this->string(255),
            'color' => $this->string(255),
            'date' => $this->string(255),
            
        ]);
    }

    public function down()
    {
        //echo "m160224_173435_citymaps cannot be reverted.\n";

        $this->dropTable('citymaps');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
