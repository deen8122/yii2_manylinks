<?php

use yii\db\Migration;

/**
 * Handles adding blockname to table `{{%site_block}}`.
 */
class m200429_063537_add_blockname_column_to_site_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->addColumn('site_block', 'blockname', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	     $this->dropColumn('site_block', 'blockname');
    }
}
