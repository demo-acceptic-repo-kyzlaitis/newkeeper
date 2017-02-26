<?php

class m130801_105940_cron_jobs extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('cron_jobs', array(
			'id' => 'pk',
			'execute_after' => 'timestamp',
			'executed_at' => 'timestamp NULL',
			'succeeded' => 'boolean',
			'action' => 'string NOT NULL',
			'parameters' => 'text',
			'execution_result' => 'text'
		));
	}

	public function safeDown()
	{
		$this->truncateTable('cron_jobs');
		$this->dropTable('cron_jobs');
	}
}