<?php

class m130806_112930_widget_weather_element_table extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';

	public function safeUp()
	{
            $this->createTable('widget_weather_element', array(
                        "id" => "pk",
                        "city_id" => "string NOT NULL REFERENCES city(id)",
                        "location" => "string NOT NULL",
                        "country_id" => "int(11) NOT NULL REFERENCES net_country(id)",
                        "temp" => "int(11) NOT NULL",
                    ), $this->MySqlOptions);
		//foreign key relationships
		//the bloger.user_id is a reference to usr_users.id
		//$this->addForeignKey("fk_country", "widget_weather_element", "country_id", "net_country", "id", "CASCADE", "RESTRICT");
	}

	public function safeDown()
	{
            $this->truncateTable('widget_weather_element');
            $this->dropTable('widget_weather_element');
	}
}