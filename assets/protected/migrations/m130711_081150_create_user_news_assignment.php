<?php

class m130711_081150_create_user_news_assignment extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';

	public function safeUp()
	{
		$this->createTable('user_news_bookmark', array(
                        "user_id" => "int(11) NOT NULL",
                        "news_id" => "int(11) NOT NULL",
                        'PRIMARY KEY (`news_id`,`user_id`)',
                    ), $this->MySqlOptions);

		//foreign key relationships
		//the news_user_assignment.news_id is a reference to news.id
		$this->addForeignKey("fk_news_user", "user_news_bookmark", "news_id", "news", "id", "CASCADE", "RESTRICT");
		//the user_news_assignment.user_id is a reference to usr_users.id
		$this->addForeignKey("fk_user_news", "user_news_bookmark", "user_id", "usr_users", "id", "CASCADE", "RESTRICT");
	}

	public function safeDown()
	{
	}
}