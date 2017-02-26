<?php

class m130809_074348_widget_currency_element_table extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';

	public function safeUp()
	{
            $this->createTable('widget_currency_element', array(
                        "id" => "pk",
                        "name" => "string NOT NULL",
                        "buy" => "decimal(10,2) NOT NULL",
                        "sale" => "decimal(10,2) NOT NULL",
                        "symbol" => "string NOT NULL",
                    ), $this->MySqlOptions);
		//foreign key relationships
		//the bloger.user_id is a reference to usr_users.id
		//$this->addForeignKey("fk_country", "widget_weather_element", "country_id", "net_country", "id", "CASCADE", "RESTRICT");
	}

	public function safeDown()
	{
            $this->truncateTable('widget_currency_element');
            $this->dropTable('widget_currency_element');
	}
}