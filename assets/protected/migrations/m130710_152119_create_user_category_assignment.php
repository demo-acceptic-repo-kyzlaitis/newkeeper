<?php

class m130710_152119_create_user_category_assignment extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';

	public function safeUp()
	{
		$this->createTable('user_category_assignment', array(
                        "user_id" => "int(11) NOT NULL",
                        "category_id" => "int(11) NOT NULL",
                        'PRIMARY KEY (`category_id`,`user_id`)',
                    ), $this->MySqlOptions);

		//foreign key relationships
		//the news.category_id is a reference to category.id
		$this->addForeignKey("fk_news_category", "news", "category_id", "category", "id", "CASCADE", "RESTRICT");
		//the news.author_id is a reference to usr_users.id
		$this->addForeignKey("fk_news_author", "news", "author_id", "usr_users", "id", "CASCADE", "RESTRICT");
		//the category_user_assignment.category_id is a reference to category.id
		$this->addForeignKey("fk_category_user", "user_category_assignment", "category_id", "category", "id", "CASCADE", "RESTRICT");
		//the user_category_assignment.user_id is a reference to usr_users.id
		$this->addForeignKey("fk_user_category", "user_category_assignment", "user_id", "usr_users", "id", "CASCADE", "RESTRICT");
	}

	public function safeDown()
	{
	}

}