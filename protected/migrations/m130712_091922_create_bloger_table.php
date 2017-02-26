<?php

class m130712_091922_create_bloger_table extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';

	public function safeUp()
	{
            $this->createTable('bloger', array(
                        "user_id" => "int(11) NOT NULL",
                        "pen_name_en" => "string NOT NULL",
                        "pen_name_ru" => "string NOT NULL",
                        "pen_name_ua" => "string NOT NULL",
                        "phone" => "string NOT NULL",
                        "description_en" => "text",
                        "description_ru" => "text",
                        "description_ua" => "text",
                        "tried" => "int(1) NOT NULL",
                        'PRIMARY KEY (`user_id`)',
                    ), $this->MySqlOptions);

		//foreign key relationships
		//the bloger.user_id is a reference to usr_users.id
		$this->addForeignKey("fk_bloger", "bloger", "user_id", "usr_users", "id", "CASCADE", "RESTRICT");
	}

	public function safeDown()
	{
            $this->truncateTable('bloger');
            $this->dropTable('bloger');
	}
}