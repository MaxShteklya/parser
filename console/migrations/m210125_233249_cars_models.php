<?php

use yii\db\Migration;

/**
 * Class m210125_233249_cars_models
 */
class m210125_233249_cars_models extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cars_models', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210125_233249_cars_models cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210125_233249_cars_models cannot be reverted.\n";

        return false;
    }
    */
}
