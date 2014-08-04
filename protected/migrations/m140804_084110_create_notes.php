<?php

class m140804_084110_create_notes extends CDbMigration
{
	public function up()
	{
		if (Yii::app()->db->schema->getTable('notes',true)===null) {
			$this->createTable('notes', array(
				'id_Note' => 'pk',
				'Author' => 'CHAR(255) NOT NULL',
				'Title' => 'CHAR(255) NOT NULL',
				'Content' => 'TEXT NOT NULL',
				'Date' => 'DATETIME',
			),'ENGINE InnoDB  CHARACTER SET=UTF8');
		} else {
			echo "table notes already exist\n";
		}

		if (Yii::app()->db->schema->getTable('comments',true)===null) {
			$this->createTable('comments', array(
				'id' => 'pk',
				'Author' => 'CHAR(255) NOT NULL',
				'Content' => 'TEXT NOT NULL',
				'Date' => 'DATETIME',
				'id_Note' => 'INT',
			),'ENGINE InnoDB  CHARACTER SET=UTF8');
			$this->addForeignKey('FK_comment_note', 'comments', 'id_Note', 
				'notes', 'id_Note', 'CASCADE', 'CASCADE');
		} else {
			echo "table comments already exist\n";
		}		
	}

	public function down()
	{
		echo "m140804_084110_create_notes does not support migration down.\n";
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
