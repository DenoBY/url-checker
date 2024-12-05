<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%url_checks}}`.
 */
class m241203_224415_create_url_checks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%url_checks}}', [
            'id' => $this->primaryKey(),
            'url_id' => $this->integer()->notNull(),
            'status_code' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-check-url_id',
            '{{%url_checks}}',
            'url_id',
            'urls',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-check-url_id', '{{%url_checks}}');
        $this->dropTable('{{%url_checks}}');
    }
}
