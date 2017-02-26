<?php

class m130712_111635_create_user_bloger_assignment extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';
        
	public function safeUp()
	{
		$this->createTable('user_bloger_assignment', array(
                        "user_id" => "int(11) NOT NULL",
                        "bloger_id" => "int(11) NOT NULL",
                        'PRIMARY KEY (`bloger_id`,`user_id`)',
                    ), $this->MySqlOptions);

		//foreign key relationships
		//the user_bloger_assignment.user_id is a reference to usr_users.id
		$this->addForeignKey("fk_user_bloger", "user_bloger_assignment", "user_id", "usr_users", "id", "CASCADE", "RESTRICT");
		//the user_bloger_assignment.bloger_id is a reference to bloger.user_id
		$this->addForeignKey("fk_bloger_user", "user_bloger_assignment", "bloger_id", "bloger", "user_id", "CASCADE", "RESTRICT");
	}

	public function safeDown()
	{
            $this->truncateTable('user_bloger_assignment');
            $this->dropTable('user_bloger_assignment');
	}
}