<?php

class m140804_084803_insert_notes extends CDbMigration
{
	public function up()
	{
		$this->insert('notes', array(
				'Author' => 'mr.I',
				'Title' => 'My first Note',
				'Content' => 'Hello world!',
				'Date' => date("Y-m-d H:i:s"),
		));
	}

	public function down()
	{
		echo "m140804_084803_insert_notes does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}