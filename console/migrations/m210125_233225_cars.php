<?php

use yii\db\Migration;

/**
 * Class m210125_233225_cars
 */
class m210125_233225_cars extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cars', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'lot' => $this->integer()->notNull()->unique(),
            'price' => $this->integer()->notNull(),
            'make_id' => $this->integer()->notNull(),
            'model_id' => $this->integer()->notNull(),
            'registration' => $this->string(64),
            'fuel_type' => $this->string(64),
            'first_produced' => $this->date(),
            'mileage' => $this->integer(),
            'vin' => $this->string(64),
            'bodywork' => $this->string(64),
            'storage' => $this->string(64),
            'gearbox' => $this->string(64),
            'options' => $this->text(),
            'expertise' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210125_233225_cars cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210125_233225_cars cannot be reverted.\n";

        return false;
    }
    */
}
