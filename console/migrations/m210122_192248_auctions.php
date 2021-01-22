<?php

use yii\db\Migration;

/**
 * Class m210122_192248_auctions
 */
class m210122_192248_auctions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auctions', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer()->notNull()->unique(),
            'room_name' => $this->string(255),
            'room_alias' => $this->string(255),
            'room_date' => $this->string(64),
            'room_lots' => $this->integer(),
            'room_place' => $this->string(64)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210122_192248_auctions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210122_192248_auctions cannot be reverted.\n";

        return false;
    }
    */
}
