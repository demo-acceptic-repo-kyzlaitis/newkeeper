<?php

class m130809_112908_widget_traffic_element extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';

	public function safeUp()
	{
            $this->createTable('widget_traffic_element', array(
                        "id" => "pk",
                        "city_id" => "string NOT NULL REFERENCES city(id)",
                        "value" => "int(2) NOT NULL",
                    ), $this->MySqlOptions);
            
            $this->createTable('city', array(
                        "id" => "pk",
                        "name" => "string NOT NULL",
                        "country_id" => "int(11) NOT NULL REFERENCES net_country(id)",
                    ), $this->MySqlOptions);
            
		//foreign key relationships
		//$this->addForeignKey("fk_country_city", "city", "country_id", "net_country", "id", "CASCADE", "RESTRICT");
		//$this->addForeignKey("fk_city_traffic", "widget_traffic_element", "city_id", "city", "id", "CASCADE", "RESTRICT");
		//$this->addForeignKey("fk_city_weather", "widget_weather_element", "city_id", "city", "id", "CASCADE", "RESTRICT");
	}

	public function safeDown()
	{
            $this->truncateTable('widget_traffic_element');
            $this->dropTable('widget_traffic_element');
	}
}